// JavaScript Document
// Opens every photo of a gallery album in a lightbox when its thumbnail is clicked.
// The albums are printed by gallery.php into window.pssGalleries.

(function () {
	var albums = {};
	var images = [];
	var title = '';
	var index = 0;
	var box, imageEl, figureEl, titleEl, counterEl, prevBtn, nextBtn;
	var touchStartX = null;
	// Widest a photo may be drawn, and how far a small photo may be enlarged
	// before it would start to look soft.
	var MAX_WIDTH = 1500;
	var MAX_ZOOM = 1.75;

	// Keeps a click inside the lightbox from reaching the page underneath.
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
		box.className = 'pss-lightbox';
		box.innerHTML =
			'<div class="pss-lightbox-title"></div>' +
			'<button type="button" class="pss-lightbox-close" title="Close">&times;</button>' +
			'<button type="button" class="pss-lightbox-nav pss-lightbox-prev" title="Previous">&#10094;</button>' +
			'<button type="button" class="pss-lightbox-nav pss-lightbox-next" title="Next">&#10095;</button>' +
			'<div class="pss-lightbox-stage">' +
				'<span class="pss-lightbox-figure"><img class="pss-lightbox-image" src="" alt=""></span>' +
			'</div>' +
			'<div class="pss-lightbox-counter"></div>';

		document.body.appendChild(box);

		imageEl = box.querySelector('.pss-lightbox-image');
		figureEl = box.querySelector('.pss-lightbox-figure');
		titleEl = box.querySelector('.pss-lightbox-title');
		counterEl = box.querySelector('.pss-lightbox-counter');
		prevBtn = box.querySelector('.pss-lightbox-prev');
		nextBtn = box.querySelector('.pss-lightbox-next');

		box.querySelector('.pss-lightbox-close').onclick = function (event) {
			stop(event);
			close();
		};
		prevBtn.onclick = function (event) { stop(event); step(-1); };
		nextBtn.onclick = function (event) { stop(event); step(1); };

		imageEl.onload = function () {
			fit();
			box.className = box.className.replace(' is-loading', '');
		};

		// Nothing inside the lightbox closes it - only the close button does.
		box.onclick = function (event) {
			stop(event);
		};

		box.addEventListener('touchstart', function (event) {
			touchStartX = event.changedTouches[0].clientX;
		}, false);

		box.addEventListener('touchend', function (event) {
			if (touchStartX === null) {
				return;
			}
			var moved = event.changedTouches[0].clientX - touchStartX;
			touchStartX = null;
			if (Math.abs(moved) > 40) {
				step(moved < 0 ? 1 : -1);
			}
		}, false);
	}

	// Gives the photo as much room as it can fill without being enlarged so far
	// that it turns soft. Big photos are limited by MAX_WIDTH, small ones by how
	// many pixels they actually have.
	function fit() {
		if (!figureEl) {
			return;
		}
		var natural = imageEl.naturalWidth || 0;
		var widest = natural ? Math.min(MAX_WIDTH, Math.round(natural * MAX_ZOOM)) : MAX_WIDTH;
		figureEl.style.maxWidth = widest + 'px';
	}

	function show() {
		box.className = 'pss-lightbox is-open is-loading' + (images.length < 2 ? ' is-single' : '');
		imageEl.src = images[index];
		imageEl.alt = title;
		titleEl.innerHTML = '';
		titleEl.appendChild(document.createTextNode(title));
		counterEl.innerHTML = '';
		counterEl.appendChild(document.createTextNode((index + 1) + ' / ' + images.length));
		preload(index + 1);
		preload(index - 1);
	}

	function preload(position) {
		if (position >= 0 && position < images.length) {
			var img = new Image();
			img.src = images[position];
		}
	}

	function step(direction) {
		if (images.length < 2) {
			return;
		}
		index = (index + direction + images.length) % images.length;
		show();
	}

	function open(album, startIndex) {
		if (!album || !album.images || !album.images.length) {
			return;
		}
		build();
		images = album.images;
		title = album.title || '';
		index = startIndex > 0 ? startIndex : 0;
		document.documentElement.style.overflow = 'hidden';
		show();
	}

	// Album built from the photos already printed on the page: every <img> inside
	// the elements carrying data-gallery-group="<name>", in the order they appear.
	function openGroup(name, clickedImage) {
		var holders = document.querySelectorAll('[data-gallery-group="' + name + '"]');
		var album = { title: '', images: [] };
		var start = 0;

		for (var h = 0; h < holders.length; h++) {
			if (!album.title) {
				album.title = holders[h].getAttribute('data-gallery-title') || '';
			}
			var found = holders[h].getElementsByTagName('img');
			for (var i = 0; i < found.length; i++) {
				if (found[i] === clickedImage) {
					start = album.images.length;
				}
				album.images.push(found[i].src);
			}
		}

		open(album, start);
	}

	function close() {
		box.className = 'pss-lightbox';
		imageEl.src = '';
		document.documentElement.style.overflow = '';
	}

	function onClick(event) {
		var clicked = event.target;
		var node = clicked;

		// Clicks on the lightbox itself are handled by its own buttons.
		if (box && box.contains && box.contains(clicked)) {
			return;
		}

		while (node && node !== document) {
			if (node.getAttribute) {
				var id = node.getAttribute('data-gallery-id');
				if (id) {
					if (albums[id]) {
						event.preventDefault();
						open(albums[id], 0);
					}
					return;
				}
				var group = node.getAttribute('data-gallery-group');
				if (group) {
					if (clicked.tagName === 'IMG') {
						event.preventDefault();
						openGroup(group, clicked);
					}
					return;
				}
			}
			node = node.parentNode;
		}
	}

	function init() {
		albums = window.pssGalleries || {};
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
			}
		}, false);
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init, false);
	} else {
		init();
	}
})();
