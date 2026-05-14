// JavaScript Document

$(document).ready(function() {
		$('.fancybox').fancybox();
			$(".fancybox-effects-a").fancybox({
				helpers: {
					title : {
						type : 'outside'
					},
					overlay : {
						speedOut : 0
					}
				}
			});

			 
			$(".gallery_grid").click(function(){
					//alert('d');
					var currentcat = $(this).attr('catid');
					$.post('getsubimage.php/?catid='+currentcat,function(response){
						var response = JSON.parse(response);
						if(response.result==true){
							$.fancybox.open(response.data);
						}else{
							alert('failes:'+response.data);
						}
					});
				return false;
			});
		
});