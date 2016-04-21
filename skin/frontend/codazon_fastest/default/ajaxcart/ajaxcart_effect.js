(function($){
	
	$.fn.ajaxCartEffect = function(options){
		var defaultConfig = {
			img: '.product-image img',
			parent: '.item',
			effImg: '#effectImg',
			dest: '#footer-cart .cart-icon',
			fCart: '#footer-cart',
			form: '#product_addtocart_form'
		};
		
		var conf = Object.extend(defaultConfig,options || { });
		$(this).each(function(){
			var $this = $(this);
			if(!$this.data('hasBindEffect')){
				$this.data('hasBindEffect',true);
				$this.click(function(){
					var $effImg = $('<img class="animated flipInY" style="display:none; position:absolute; z-index:100000"/>');
					$('body').append($effImg);
					var $pr = $this.parents(conf.parent).first();
					if($pr.length == 0){
						
						if(typeof productAddToCartForm != 'undefined') {
							if(productAddToCartForm.submitvalidator && productAddToCartForm.validator.validate()){
                 				$pr = $(conf.form);
                			}else{
								return false;	
							}
						}else{
							return false;	
						}
					}
					var $img = null;
					$pr.find(conf.img).each(function(){
						if( !$(this).hasClass('hidden') ){
							$img = $(this);
							return false;
						}
					});
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
					
					var $fCart = $(conf.fCart);
					var $dest = $(conf.dest);
					var flyImage = function(){
						var newWidth = 0.1*width, newHeight = 0.1*height;
						var step02Css = {
							top: $dest.offset().top,
							left: $dest.offset().left,
							width: newWidth,
							height: newHeight
						}
						$effImg.animate(step02Css,1000,'linear',function(){
							$effImg.fadeOut(200,'linear',function(){
								$effImg.replaceWith('');	
							});
							$fCart.find('.loading').show();
							$fCart.find('.loaded').hide();
							/*$fCart.removeClass('active');
							$fCart.find('.cart-content').slideUp(300);*/
						});
					}
					
					if( !$dest.is('*:visible') ){
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
		var imgId = 'effectImg', cartId = 'footer-cart';
		var html;
		if($('#footer-cart').length == 0){
			html = '<div class="footer-cart cdz-dropdown" id="'+cartId+'" style="position:fixed; bottom:0; left:0; width:100%; z-index:10000;"></div>';
			$('body').append(html);
			var $cartInner = $('#cart-footer-inner');
			$cartInner.appendTo('#'+cartId);
			$cartInner.find('.cart-content').hide();
		}
		$('.btn-cart').ajaxCartEffect();
		$(window).on('ajaxCartCompleted',function(){
			$fCart.find('.loading').hide();
			$fCart.find('.loaded').show();
			/*$fCart.addClass('active');
			$fCart.find('.cart-content').slideDown(300);*/
		});
		var $fCart = $('#'+cartId);
		$fCart.find('.cart-trigger').click(function(){
			var $this = $(this);
			$fCart.toggleClass('active');
			$fCart.find('.cart-content').slideToggle(300);
		});
	}
	$(document).ready(function(){
		bindEffectEvent();
	});
})(jQuery)