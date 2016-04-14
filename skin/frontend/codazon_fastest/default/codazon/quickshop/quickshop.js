cdzQuickshop = Class.create();
cdzQuickshop.prototype = {
	productUrl: '',
	initialize: function(options) {
		var config = Object.extend({
			itemClass: '.products-grid .item, .products-list .item',
			qsLabel: 'Quick shop',
			handler: '.qs-button',
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
		$loader = $iframe.find('.ajax-load-wrapper');
		$iframe.on('show.bs.modal', function (e) {
			urlKey = jQuery(e.relatedTarget).data('url');
			qs.productUrl = urlKey;
			console.log(urlKey);
			$iframe.find('.product-content').html('');
			$loader.show();
			jQuery.ajax({		
				url: qs.productUrl,
				type: 'GET',
				dataType: "html",
				success: function(res){
					$loader.hide();
					var $dialog = $iframe.find('.modal-dialog');
					$dialog.html(res);
					$dialog.show();
					$dialog.trigger('animated');
					qs.afterLoad();
				},
				error: function(XMLHttpRequest, textStatus, errorThrown){
				}
			}).always(function(){ $loader.hide(); });
		});
		$iframe.on('hide.bs.modal', function (e) {
			$iframe.find('.modal-dialog').hide('');
		});
	}
}
