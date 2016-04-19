cdzQuickshop = Class.create();
cdzQuickshop.prototype = {
	productUrl: '',
	initialize: function(options) {
		var config = Object.extend({
			itemClass: '.products-grid .item, .products-list .item',
			qsLabel: 'Quick shop',
			handler: '.cdz-quickshop',
			iframe: '#cdz-qsiframe',
		}, options || { });
		this.config = config;
		this.bindQuickshop(config,this);
	},
	notice: function(){
		
	},
	afterLoad: function(){
		
	},
	bindQuickshop: function(config,qs){
		//$handler = jQuery(config.handler);
		$iframe = jQuery(config.iframe);
		$loader = $iframe.find('.cdz-loader-wrap');
		$iframe.on('show.bs.modal', function (e) {
			$iframe.find('.product-content').html('');
			$loader.show();
			jQuery.ajax({		
				url: qsLoadProductUrl+'?producturl='+qs.productUrl,
				type: 'GET',
				dataType: "html",
				/*cache: false,*/
				success: function(res){
					$loader.hide();
					$iframe.find('.product-content').html(res);
					qs.afterLoad();
				},
				error: function(XMLHttpRequest, textStatus, errorThrown){
				}
			}).always(function(){ $loader.hide(); });
		});
		$iframe.on('hide.bs.modal', function (e) {
			//$iframe.find('.product-content').html('');
		});
		jQuery(config.itemClass).each(function(index, element) {
            jQuery(this).hover(
				function(){
					$this = jQuery(this);
					//$img = $this.find('.product-image');
					$handler = $this.find(config.handler);
					/*imgW = $img.width();
					imgH = $img.height();
					hdW = $handler.width();
					hdH = $handler.height();
					hdL = (imgW - hdW)/2;
					hdT = (imgH - hdH)/2;
					$img.css({position:'relative'})
					$handler.css({
						left: hdL,
						top: hdT,
					});*/
					$handler.show();
					urlKey = $img.attr('href').replace(qsBaseUrl,'');
					$handler.find('a').data('href',urlKey);
					qs.productUrl = urlKey;*/
				},
				function(){
					$handler.hide();
				}
			);
        });
	}
}
