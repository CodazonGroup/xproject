(function( $ ) {
"use strict";
var cdzFilterProducts = Class.create();
cdzFilterProducts.prototype = {
	curPage: 1,
	element: null,
	options: {
		element: $('[data-role="cdz_product_list"]'),
		jsonData: null,
		trigger: '.cdz-ajax-trigger',
		ajaxLoader: '.ajax-loader',
		itemsWrap: '.product-items',
		ajaxUrl: null,
		jsonData: null,
		currentUrl: null,
		lastPage: 100
	},
	initialize: function(options) {	
		this.options = Object.extend(this.options,options || { });
		var self = this;
		this.element = this.options.element;
		if(self.options.lastPage <= self.curPage){
			self.element.find(self.options.trigger).hide();
		}
		this.element.find(self.options.trigger).click(function(){
			self.ajaxLoadProducts();
		});
	},
	ajaxLoadProducts: function(){
		var self = this;
		var config = this.options;
		var $trigger = self.element.find(config.trigger);
		var $ajaxLoader = self.element.find(config.ajaxLoader);
		var hasLastPage = false;
		$trigger.hide();
		$ajaxLoader.show();
		self.curPage++;
		config.jsonData.cur_page = self.curPage;
		config.jsonData.current_url = config.currentUrl;
		$.ajax({
			url: config.ajaxUrl,
			type: "POST",
			data: config.jsonData,
			cache: false,
			success: function(res){
				self.element.find(config.itemsWrap).first().append(res.html);
				if(config.lastPage <= self.curPage){
					hasLastPage = true;
				}
				if(self.element.parents('.codazon-ajax-wrap').length > 0){
					self.element.parents('.codazon-ajax-wrap').trigger('contentUpdated');
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown){
				console.error(textStatus);
			}
		}).always(function(){
			$ajaxLoader.hide();
			if(!hasLastPage){
				$trigger.show();
			}else{
				$trigger.hide();
			}
		});
	}
}
$.fn.cdzLoadProductBlock = function(options){
	$(this).each(function(){
		var $this = $(this);
		var scrollEvent = 'scroll.'+options.eventName;
		var clickEvent = 'shown.bs.tab';
		var $tabTrigger = false;
		var loadProductByAjax = function(){
			var wrapTop = $this.offset().top;
			var scrollTop = jQuery(window).scrollTop();
			var winHeight = jQuery(window).height();
			//if( (scrollTop + winHeight) >= wrapTop ){
				if( (!$this.hasClass('loaded')) && $this.is('*:visible') ){
					$this.addClass('loaded');
					var $loader = $this.find('.codazon-loader-wrap');
					$loader.show();
					jQuery.ajax({		
						url: options.loadProductsUrl,
						type: 'POST',
						data: options.postData,
						cache: false,
						success: function(res){
							$loader.hide(200,'linear',function(){
								$this.append(res.html);
								$this.trigger('contentUpdated');
							});
							$(document).unbind(scrollEvent);
							if($tabTrigger){
								$tabTrigger.off(clickEvent,loadProductByAjax);
							};
						},
						error: function(XMLHttpRequest, textStatus, errorThrown){
						}
					}).always(function(){ $loader.hide(); });
				}
			//}	
		}
		
		loadProductByAjax();
		$(document).bind(scrollEvent,function(){
			loadProductByAjax();	
		});	
		if($this.parents('.nav-tab-content').length){
			var $pr = $this.parents('.nav-tab-content').parent();
			var tabId =   $this.parents('.tab-pane').attr('id');
			$tabTrigger = $pr.find('a[href="#'+tabId+'"]');
			$tabTrigger.on(clickEvent,loadProductByAjax);
		};
	});
};

$.fn.cdzFilterProducts = function(options){
	var $this = $(this);
	options.element = $this;
	new cdzFilterProducts(options);
};
$.fn.switchSliderGrid = function(options){
	var $this = $(this);
	function mobileSlider($this){
		if(!$this.hasClass('owl-carousel')){
			$this.addClass('owl-carousel owl-theme');
			$this.owlCarousel({
				loop: false,
				margin: 0,
				responsiveClass: true,
				nav: true,
				dots: false,
				responsive: options.carousel.responsive
			});
		}
	}
	function pcGrid($this){
		if($this.hasClass('owl-carousel')){
			$this.data('owl.carousel').destroy();
			$this.removeClass('owl-carousel owl-loaded owl-theme');
			$this.find('.owl-stage-outer').children().unwrap();
			$this.removeData();
		}
	}
	var curWinWidth = $(window).width();
	if(curWinWidth < 768){
		mobileSlider($this);
	}else{
		pcGrid($this);
	}
	$(window).bind('cdz_mobile',function(){
		mobileSlider($this);
	});
	$(window).bind('cdz_pc',function(){
		pcGrid($this);
	});
}
})( jQuery );