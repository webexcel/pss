// JavaScript Document
// Opens the photos of a recognition page in a viewer with zoom, previous, next
// and close buttons. It only listens to images inside the elements carrying
// data-recognition-gallery="<name>", so every other gallery on the site is left
// exactly as it was.

(function () {
	// Every photo of the album: { src: '...', caption: '...' }
	var images = [];
	var index = 0;
	var box, imageEl, stageEl, titleEl, counterEl, prevBtn, nextBtn, inBtn, outBtn;

	// How far a photo may be zoomed, and the step each button press moves.
	var MIN_ZOOM = 1;
	var MAX_ZOOM = 4;
	var ZOOM_STEP = 0.5;

	var zoom = 1;
	var offsetX = 0;
	var offsetY = 0;

	// Drag state, shared by the mouse and single finger panning.
	var dragging = false;
	var dragStartX = 0;
	var dragStartY = 0;
	var dragFromX = 0;
	var dragFromY = 0;

	// Touch state for the swipe between photos and the pinch zoom.
	var touchStartX = null;
	var touchStartY = null;
	var pinchStart = 0;
	var pinchZoom = 1;

	// Keeps a click inside the viewer from reaching the page underneath.
	function stop(event) {
		if (!event) {
			return;
		}
		if (event.preventDefault) {
			event.preventDefault();
		}
		if (event.stopPropagation) {
			event.stopPropagation();
		}
		event.cancelBubble = true;
		event.returnValue = false;
	}

	function build() {
		if (box) {
			return;
		}

		box = document.createElement('div');
		box.className = 'pss-recbox';
		box.innerHTML =
			'<div class="pss-recbox-title"></div>' +
			'<button type="button" class="pss-recbox-close" title="Close">&times;</button>' +
			'<button type="button" class="pss-recbox-nav pss-recbox-prev" title="Previous">&#10094;</button>' +
			'<button type="button" class="pss-recbox-nav pss-recbox-next" title="Next">&#10095;</button>' +
			'<div class="pss-recbox-stage">' +
				'<img class="pss-recbox-image" src="" alt="">' +
			'</div>' +
			'<div class="pss-recbox-bar">' +
				'<button type="button" class="pss-recbox-zoom pss-recbox-out" title="Zoom out">&minus;</button>' +
				'<span class="pss-recbox-counter"></span>' +
				'<button type="button" class="pss-recbox-zoom pss-recbox-in" title="Zoom in">+</button>' +
			'</div>';

		document.body.appendChild(box);

		imageEl = box.querySelector('.pss-recbox-image');
		stageEl = box.querySelector('.pss-recbox-stage');
		titleEl = box.querySelector('.pss-recbox-title');
		counterEl = box.querySelector('.pss-recbox-counter');
		prevBtn = box.querySelector('.pss-recbox-prev');
		nextBtn = box.querySelector('.pss-recbox-next');
		inBtn = box.querySelector('.pss-recbox-in');
		outBtn = box.querySelector('.pss-recbox-out');

		box.querySelector('.pss-recbox-close').onclick = function (event) {
			stop(event);
			close();
		};
		prevBtn.onclick = function (event) { stop(event); step(-1); };
		nextBtn.onclick = function (event) { stop(event); step(1); };
		inBtn.onclick = function (event) { stop(event); zoomBy(ZOOM_STEP); };
		outBtn.onclick = function (event) { stop(event); zoomBy(-ZOOM_STEP); };

		imageEl.onload = function () {
			box.className = box.className.replace(' is-loading', '');
			draw();
		};

		// Nothing inside the viewer closes it - only the close button does.
		box.onclick = function (event) {
			stop(event);
		};

		bindDrag();
		bindTouch();
	}

	// Dragging a zoomed photo with the mouse.
	function bindDrag() {
		imageEl.onmousedown = function (event) {
			if (zoom <= MIN_ZOOM) {
				return;
			}
			stop(event);
			startDrag(event.clientX, event.clientY);
		};

		document.addEventListener('mousemove', function (event) {
			if (!dragging) {
				return;
			}
			stop(event);
			moveDrag(event.clientX, event.clientY);
		}, false);

		document.addEventListener('mouseup', function () {
			endDrag();
		}, false);
	}

	// A single finger pans a zoomed photo and swipes between photos otherwise.
	// Two fingers pinch to zoom.
	function bindTouch() {
		box.addEventListener('touchstart', function (event) {
			if (event.touches.length === 2) {
				touchStartX = null;
				endDrag();
				pinchStart = spread(event.touches);
				pinchZoom = zoom;
				return;
			}
			if (event.touches.length !== 1) {
				return;
			}
			var touch = event.touches[0];
			if (zoom > MIN_ZOOM && event.target === imageEl) {
				startDrag(touch.clientX, touch.clientY);
				return;
			}
			touchStartX = touch.clientX;
			touchStartY = touch.clientY;
		}, false);

		box.addEventListener('touchmove', function (event) {
			if (event.touches.length === 2 && pinchStart) {
				stop(event);
				var now = spread(event.touches);
				if (now > 0) {
					setZoom(pinchZoom * (now / pinchStart));
				}
				return;
			}
			if (dragging && event.touches.length === 1) {
				// the photo is being moved, so the page must not scroll with it
				stop(event);
				moveDrag(event.touches[0].clientX, event.touches[0].clientY);
			}
		}, false);

		box.addEventListener('touchend', function (event) {
			if (pinchStart && event.touches.length < 2) {
				pinchStart = 0;
			}
			if (dragging) {
				endDrag();
				return;
			}
			if (touchStartX === null) {
				return;
			}
			var last = event.changedTouches[0];
			var movedX = last.clientX - touchStartX;
			var movedY = last.clientY - touchStartY;
			touchStartX = null;
			touchStartY = null;
			// only a clearly sideways swipe changes the photo, so scrolling
			// gestures are not mistaken for one
			if (Math.abs(movedX) > 40 && Math.abs(movedX) > Math.abs(movedY)) {
				step(movedX < 0 ? 1 : -1);
			}
		}, false);
	}

	// Distance between two fingers, used to measure a pinch.
	function spread(touches) {
		var dx = touches[0].clientX - touches[1].clientX;
		var dy = touches[0].clientY - touches[1].clientY;
		return Math.sqrt(dx * dx + dy * dy);
	}

	function startDrag(x, y) {
		dragging = true;
		dragStartX = x;
		dragStartY = y;
		dragFromX = offsetX;
		dragFromY = offsetY;
		if (box.className.indexOf('is-panning') === -1) {
			box.className += ' is-panning';
		}
	}

	function moveDrag(x, y) {
		offsetX = dragFromX + (x - dragStartX);
		offsetY = dragFromY + (y - dragStartY);
		draw();
	}

	function endDrag() {
		if (!dragging) {
			return;
		}
		dragging = false;
		box.className = box.className.replace(' is-panning', '');
	}

	function zoomBy(amount) {
		setZoom(zoom + amount);
	}

	function setZoom(next) {
		if (next < MIN_ZOOM) {
			next = MIN_ZOOM;
		}
		if (next > MAX_ZOOM) {
			next = MAX_ZOOM;
		}
		zoom = next;
		if (zoom === MIN_ZOOM) {
			offsetX = 0;
			offsetY = 0;
		}
		draw();
	}

	function resetZoom() {
		zoom = MIN_ZOOM;
		offsetX = 0;
		offsetY = 0;
		endDrag();
	}

	// Applies the current zoom and drag, keeping part of the photo on screen and
	// keeping the buttons in step with what can still be done.
	function draw() {
		if (!imageEl) {
			return;
		}

		// offsetWidth is the photo's laid out size, which the zoom does not change
		var roomX = Math.max(0, (imageEl.offsetWidth * zoom - stageEl.clientWidth) / 2);
		var roomY = Math.max(0, (imageEl.offsetHeight * zoom - stageEl.clientHeight) / 2);

		offsetX = Math.max(-roomX, Math.min(roomX, offsetX));
		offsetY = Math.max(-roomY, Math.min(roomY, offsetY));

		var transform = 'translate(' + Math.round(offsetX) + 'px, ' + Math.round(offsetY) + 'px) scale(' + zoom + ')';
		imageEl.style.webkitTransform = transform;
		imageEl.style.transform = transform;

		inBtn.disabled = zoom >= MAX_ZOOM;
		outBtn.disabled = zoom <= MIN_ZOOM;

		var zoomed = box.className.indexOf('is-zoomed') !== -1;
		if (zoom > MIN_ZOOM && !zoomed) {
			box.className += ' is-zoomed';
		} else if (zoom <= MIN_ZOOM && zoomed) {
			box.className = box.className.replace(' is-zoomed', '');
		}
	}

	function show() {
		var photo = images[index];
		resetZoom();
		box.className = 'pss-recbox is-open is-loading' + (images.length < 2 ? ' is-single' : '');
		imageEl.style.webkitTransform = 'translate(0, 0) scale(1)';
		imageEl.style.transform = 'translate(0, 0) scale(1)';
		imageEl.src = photo.src;
		imageEl.alt = photo.caption;
		titleEl.innerHTML = '';
		titleEl.appendChild(document.createTextNode(photo.caption));
		counterEl.innerHTML = '';
		counterEl.appendChild(document.createTextNode((index + 1) + ' / ' + images.length));
		draw();
		preload(index + 1);
		preload(index - 1);
	}

	function preload(position) {
		if (position >= 0 && position < images.length) {
			var img = new Image();
			img.src = images[position].src;
		}
	}

	function step(direction) {
		if (images.length < 2) {
			return;
		}
		index = (index + direction + images.length) % images.length;
		show();
	}

	function text(node) {
		var value = node ? (node.textContent || node.innerText || '') : '';
		return value.replace(/\s+/g, ' ').replace(/^ | $/g, '');
	}

	// The wording already printed beside a photo, so the viewer can name what is
	// being looked at. Nothing is invented: if the page gives no wording for a
	// photo the title bar is simply left empty.
	function captionFor(image, holder) {
		if (image.getAttribute('alt')) {
			return image.getAttribute('alt');
		}

		// a caption printed under the photo itself, e.g. <img><h5>name</h5>
		var column = image.parentNode;
		if (column && column.getElementsByTagName) {
			var headings = column.getElementsByTagName('h5');
			if (headings.length && text(headings[0])) {
				return text(headings[0]);
			}
		}

		// otherwise the nearest heading printed above the photo's row
		var row = image;
		while (row && row.parentNode && row.parentNode !== holder) {
			row = row.parentNode;
		}
		var block = row;
		while (block) {
			block = block.previousSibling;
			if (!block || block.nodeType !== 1) {
				continue;
			}
			var bold = block.getElementsByTagName ? block.getElementsByTagName('b') : null;
			if (bold && bold.length && text(bold[0])) {
				return text(bold[0]);
			}
		}

		return holder.getAttribute('data-recognition-title') || '';
	}

	// A photo the page never managed to draw would only show as a blank frame,
	// so it is left out of the album.
	function usable(image) {
		if (image.complete && image.naturalWidth === 0) {
			return false;
		}
		return !!(image.offsetWidth || image.offsetHeight);
	}

	// Album built from the photos already printed on the page: every <img> inside
	// the elements carrying data-recognition-gallery="<name>", in the order they
	// appear.
	function openGroup(name, clickedImage) {
		var holders = document.querySelectorAll('[data-recognition-gallery="' + name + '"]');
		var start = -1;

		images = [];

		for (var h = 0; h < holders.length; h++) {
			var found = holders[h].getElementsByTagName('img');
			for (var i = 0; i < found.length; i++) {
				if (!usable(found[i])) {
					continue;
				}
				if (found[i] === clickedImage) {
					start = images.length;
				}
				images.push({
					src: found[i].src,
					caption: captionFor(found[i], holders[h])
				});
			}
		}

		// a photo the page could not draw has nothing to show, so it does nothing
		if (!images.length || start < 0) {
			return;
		}

		build();
		index = start;
		document.documentElement.style.overflow = 'hidden';
		show();
	}

	function close() {
		resetZoom();
		box.className = 'pss-recbox';
		imageEl.src = '';
		document.documentElement.style.overflow = '';
	}

	function onClick(event) {
		var clicked = event.target;
		var node = clicked;

		// Clicks on the viewer itself are handled by its own buttons.
		if (box && box.contains && box.contains(clicked)) {
			return;
		}
		if (clicked.tagName !== 'IMG') {
			return;
		}

		while (node && node !== document) {
			if (node.getAttribute) {
				var group = node.getAttribute('data-recognition-gallery');
				if (group) {
					event.preventDefault();
					openGroup(group, clicked);
					return;
				}
			}
			node = node.parentNode;
		}
	}

	function init() {
		document.addEventListener('click', onClick, false);

		document.addEventListener('keydown', function (event) {
			if (!box || box.className.indexOf('is-open') === -1) {
				return;
			}
			if (event.keyCode === 27) {
				close();
			} else if (event.keyCode === 37) {
				step(-1);
			} else if (event.keyCode === 39) {
				step(1);
			} else if (event.keyCode === 187 || event.keyCode === 107) {
				zoomBy(ZOOM_STEP);
			} else if (event.keyCode === 189 || event.keyCode === 109) {
				zoomBy(-ZOOM_STEP);
			}
		}, false);

		// a photo zoomed on a phone must stay inside the stage when it is turned
		window.addEventListener('resize', function () {
			if (box && box.className.indexOf('is-open') !== -1) {
				draw();
			}
		}, false);
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init, false);
	} else {
		init();
	}
})();
