(function($){
	
	$.fn.ajaxCartEffect = function(options){
		var defaultConfig = {
			img: '.product-image img',
			parent: '.item',
			effImg: '#effectImg',
			dest: '#footer-cart .cart-icon'
		};
		var $fCart = $('#footer-cart');
		var conf = Object.extend(defaultConfig,options || { });
		var $effImg = $(conf.effImg);
		var $dest = $(conf.dest);
		$(this).each(function(){
			var $this = $(this);
			if(!$this.data('hasBindEffect')){
				$this.data('hasBindEffect',true);
				$this.click(function(){
					$fCart.find('.loading').show();
					$fCart.find('.loaded').hide();
					var $pr = $this.parents(conf.parent).first();
					var $img = $pr.find(conf.img);
					var src = $img.attr('src');
					var width = $img.width(), height = $img.height();
					var step01Css = {
						top: $img.offset().top,
						left: $img.offset().left,
						width: width,
						height: height
					}
					$effImg.attr('src',src);
					$effImg.css(step01Css);
					$effImg.fadeIn(200);
					
					var flyImage = function(){
						var newWidth = 0.1*width, newHeight = 0.1*height;
						var step02Css = {
							top: $dest.offset().top,
							left: $dest.offset().left,
							width: newWidth,
							height: newHeight
						}
						$effImg.animate(step02Css,1000,'linear',function(){
							$effImg.fadeOut(200);
						});
					}
					
					if( !$dest.is('*:visible') ){
						console.log($fCart);
						$fCart.addClass('active');
						$fCart.find('.cart-content').slideDown(300,flyImage);
					}else{
						flyImage();
					}
				});
			}
		});
	};
	var bindEffectEvent = function(){
		var imgId = 'effectImg';
		if($('#'+imgId).length == 0){
			var imgHtml = '<img src="" id="'+imgId+'" class="animated flipInY" style="display:none; position:absolute; z-index:100000"/>';
			$('body').append(imgHtml);
		}
		$('.btn-cart').ajaxCartEffect();
		var $fCart = $('#footer-cart');
		$fCart.find('.cart-trigger').click(function(){
			var $this = $(this);
			$fCart.toggleClass('active');
			$fCart.find('.cart-content').slideToggle(300);
		});
		$('body').on('ajaxCartCompleted',function(){
			$fCart.find('.loading').hide();
			$fCart.find('.loaded').show();
		});
	}
	$(document).ready(function(){
		bindEffectEvent();
	});
})(jQuery)