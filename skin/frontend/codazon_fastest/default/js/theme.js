(function( $ ) {
	var curWinWidth = $(window).width();
	var adapt = 768;
	
	/*Label form effect*/
	window.fieldLabelEffect = function(){
		var list = '.form-list input[type=text].input-text,.form-list input[type=password].input-text,.form-list textarea.input-text';
		$('.form-list select').each(function(){
			var $select = $(this);
			$select.parents('.field,.wide').addClass('field-select-box');
		});
		$(list).each(function(){
			var $input = $(this);
			var $parent = $input.parents('.field,.wide,li').first();
			if($input.val() != ''){
				$parent.addClass('active');	
			}
			$input.focus(function () {
				$parent.addClass('active');
			}).blur(function() {
				if($input.val() == ''){
					$parent.removeClass('active');	
				}
			});
			var checkBrowserFilled = function(){
				if($input.val() != ''){
					$parent.addClass('active');
					$input.off('change.checkbrowserfilled',checkBrowserFilled);
				}
			};
			
			$input.on('change.checkbrowserfilled',checkBrowserFilled);
		});
	};
	$.fn.cdzCatSearch = function(options){
		var defaultConfig = {
			catItem: '.cat-tree > li',
			curLabel: '.current-cat',
			catInput: '#cdz-catsearch',
		};
		var config = Object.extend(defaultConfig,options || { });
		var catItem = config.catItem, curLabel = config.curLabel; catInput = config.catInput;
		$(this).each(function() {
			var $this = $(this);
			var $curLabel = $this.find(curLabel);
			$this.find(catItem).each(function(){
				var $catItem = $(this);
				$catItem.click(function(){
					catId = $catItem.data('cat');
					$(catInput).val(catId);
					var text = $catItem.html();
					$curLabel.html(text.replace(/&nbsp;/g,''));
				});
			});
		});
	};
	$.fn.cdzToogleSidebar = function(options){
		var defaultConfig = {
			title: 'dt',
			content: 'dd',
			onlyMobile: true
		};	
		var config = Object.extend(defaultConfig,options || { });
		$(this).each(function() {
			var $this = $(this);
			var $titles = $this.find(config.title);
			if(config.onlyMobile){
				if(curWinWidth < adapt){
					setup();
				}
				$(window).bind('cdz_mobile',setup);
				$(window).bind('cdz_pc',destroy);
			}else{
				setup();
			}
			
			function getContent($title){
				if($title.parent().find(config.content).length == 1){
					var $content = $title.parent().find(config.content);
				}else{
					var $content = $title.next();
				}
				return $content;
			};
			function setup(){
				$titles.each(function(){
					var $title = $(this);
					var $content = getContent($title);
					$content.hide();
					$title.click(function(e){
						e.stopPropagation();
						$content.slideToggle(100);
						$title.toggleClass('active');
					});
				});
			};
			function destroy(){
				$titles.each(function(){
					var $title = $(this);
					var $content = getContent($title);
					$content.show();
					$title.removeClass('active');
					$title.unbind('click');
				});
			}
		});
	};
	$.fn.cdzZoom = function(options){
		var defaultConfig = {
			mainImg: '.rsMainSlideImage',
			magnify: '.magnify'
		};
		options = Object.extend(defaultConfig,options || { });
		$(this).each(function(index, element) {
			var $this = $(this);
			var $magnify = $this.find(options.magnify);
			var $mainImg = $this.find(options.mainImg);
			var nativeWidth = 0;
			var nativeHeight = 0;
			
			$this.on('mousemove.cdzZoom',
				function(e){
					if(!nativeWidth && !nativeHeight){
						var imgObject = new Image();
						imgObject.src = $mainImg.attr('src');
						nativeWidth = imgObject.width;
						nativeHeight = imgObject.height;
					}else{
						var magnifyOffset = $this.offset();
						var mx = e.pageX - magnifyOffset.left;
						var my = e.pageY - magnifyOffset.top;
					}
					if(mx < $this.width() && my < $this.height() && mx > 0 && my > 0){
						$magnify.fadeIn(100);
					}
					else{
						$magnify.fadeOut(100);
					}
					if($magnify.is(':visible')){
						var rx = Math.round(mx/$mainImg.width()*nativeWidth - $magnify.width()/2)*(-1);
						var ry = Math.round(my/$mainImg.height()*nativeHeight - $magnify.height()/2)*(-1);
						var bgp = rx + "px " + ry + "px";
						var px = mx - $magnify.width()/2;
						var py = my - $magnify.height()/2;
						$magnify.css({left: px, top: py, backgroundPosition: bgp});
					}
				}
			);
			$this.on('mouseleave.cdzZoom',function(e){
				$magnify.fadeOut(100);
			}); 
        }); 
	};
	$.fn.showMoreGroup = function(options){
		$(this).each(function(){
			var defaultConfig = {
				trigger: '.view-more',
				groupClass: 'group-item',
				initGroupNum: 1
			};
			var $this = $(this);
			var conf = Object.extend(defaultConfig,options || { });
			var $trigger = $this.find(conf.trigger);
			var initNum = conf.initGroupNum;
			var groupClass = conf.groupClass;
			setup();
			function setup(){
				$('.'+groupClass+':lt('+initNum+')',$this).addClass('shown');
				if($('.'+groupClass+':not(.shown)',$this).length == 0){
					$trigger.hide();
				}
				$('.'+groupClass+':not(.shown)',$this).hide();				
				$trigger.click(function(e){
					var $newGroup = $('.'+groupClass+':not(.shown)',$this).first();
					$newGroup.addClass('shown');
					$newGroup.slideDown(100);
					if($('.'+groupClass+':not(.shown)',$this).length == 0){
						$trigger.hide();
					}
				});
			}
		});
	}
	$.fn.dropdownMenu = function(options){
		var defaultConfig = {
			trigger: '.cdz-trigger',
			dropdown: '.cdz-dropdown-content',
			exceptClass: null,
			hideAffterClick: false
		};
		var conf = Object.extend(defaultConfig,options || { });
		$(this).each(function(){
			var $cont = $(this);
			if(conf.exceptClass != null){
				if($cont.hasClass(conf.exceptClass)){
					return false;
				}
			}
			var $trigger = $cont.find(conf.trigger);
			var $dropdown = $cont.find(conf.dropdown);
			$trigger.addClass('dd-trigger');
			$dropdown.addClass('dd-content');
			$trigger.click(function(e){
				e.stopPropagation();
				if(!$cont.hasClass('dd-open')){
					if($('.dd-open').length > 0){
						var $ddopen = $('.dd-open');
						$ddopen.find('.dd-trigger').removeClass('active');
						$ddopen.find('.dd-content').slideUp();
						$ddopen.removeClass('dd-open');
					}
				}
				$cont.toggleClass('dd-open');
				$trigger.toggleClass('active');
				$dropdown.slideToggle();
			});
			$('html,body').click(function(e){
				var $target = $(e.target);
				if( ($target.parents('.dd-open').first().length == 0) || conf.hideAffterClick){
					$cont.find(conf.dropdown).slideUp();
					$cont.find(conf.trigger).removeClass('active');
					$cont.removeClass('dd-open');
				}
			});
		});
	}
	function lazyImages(){
		if(typeof $.fn.unveil !== 'undefined'){
			$('.cdz-lazy').addClass('lazy-loading');
			$('.cdz-lazy').unveil(200,function(){
				$(this).load(function() {
					$(this).removeClass('lazy-loading');
				});	
			});
		}
	}
	
	function cdzSlider(){
		$('.cdz-slider').each(function(){
			var $owl = $(this);
			$owl.addClass('owl-carousel owl-theme');
			$owl.owlCarousel({
				loop: $owl.data('loop')?$owl.data('loop'):false,
				margin: $owl.data('margin')?$owl.data('margin'):10,
				responsiveClass: true,
				nav: $owl.data('nav')?$owl.data('nav'):true,
				dots: $owl.data('dots')?$owl.data('dots'):false,
				autoplay: $owl.data('autoplay')?$owl.data('autoplay'):false,
				responsive:{
					0:{items: 	$owl.data('items-0')?$owl.data('items-0'):1},
					320:{items:	$owl.data('items-320')?$owl.data('items-320'):3},
					480:{items:	$owl.data('items-480')?$owl.data('items-480'):4},
					768:{items:	$owl.data('items-768')?$owl.data('items-768'):5},
					1024:{items: $owl.data('items-1024')?$owl.data('items-1024'):7},
					1280:{items: $owl.data('items-1280')?$owl.data('items-1280'):7}
				}	
			})
		});
	}
	function alignMenu(){                            
		$('.cdz-main-menu > .groupmenu > .level-top > .groupmenu-drop').parent().hover(function() {
			var dropdownMenu = $(this).children('.groupmenu-drop');
			if ($(this).hasClass('parent')) 
				dropdownMenu.css('left', 0);
			var menuContainer = $(this).parents('.cdz-fix-left').first();
			if(menuContainer.length){
				var left = menuContainer.offset().left + menuContainer.outerWidth() - (dropdownMenu.offset().left + dropdownMenu.outerWidth());
				var leftPos = dropdownMenu.offset().left + left - menuContainer.offset().left;
				if (leftPos < 0) left = left - leftPos;
				if (left < 0) {
					dropdownMenu.css('left', left - 10 + 'px');
				}
			}
		}, function() {
			$(this).children('.groupmenu-drop').css('left', '0px');
		});
	};
	function cdzTooltip(){
		$('[data-toggle="tooltip"], .cdz-tooltip').tooltip();
	}
	$.fn.sameHeightItems = function(){
		$(this).each(function(){
			var $wrap = $(this);
			if($wrap.find('.same-height').length > 0){
				var item = '.product-item, .ft-item, .cdz-post';
				$wrap.find('.same-height').each(function(){
					var $ul = $(this);
					var setMaxHeight = function(){
						var maxHeight = 0;
						$ul.find(item).css('height','');
						$ul.find(item).each(function(){
							if($(this).height() > maxHeight){
								maxHeight = $(this).height();	
							}
						});
						$ul.find(item).height(maxHeight);
					};
					setMaxHeight();
					$ul.find('.product-image:first img, .product-image:last img').first().bind('load.setMaxHeight',function(){
						setMaxHeight();
						$(this).unbind('load.setMaxHeight');
					});
				});
			}
		});
	};
	
	function changeAdapt(){
		$(window).resize(function(){
			setTimeout(function(){
				var winWidth = $(window).width();
				if( (curWinWidth < adapt) && (winWidth >= adapt) ){
					$(window).trigger('cdz_pc');				
				}else if( (curWinWidth >= adapt) && (winWidth < adapt)){
					$(window).trigger('cdz_mobile');
				}
				curWinWidth = winWidth;
			},200);
		});
	}
	
	function stickyMenu(){
		var $stickyMenu = $('.sticky-menu').first();
		if( $stickyMenu.length > 0 ){
			var threshold = $stickyMenu.height() + $stickyMenu.offset().top;
			$(window).scroll(function(){
				var $win = $(this);
				var curWinTop = $win.scrollTop();
				if(curWinTop > threshold){
					$stickyMenu.addClass('active');
				}else{
					$stickyMenu.removeClass('active');
				}
			});
		}
	}
	
	function responsiveTabs(){
		$('.nav-tab-item a').click(function(){
			var $navTab = $(this);
			var $dropdown = $navTab.parent().parent().parent().find('.mobile-nav-tab-dropdown');
			var tabTitle = $navTab.text();
			$dropdown.text(tabTitle);
			$navTab.parents('.mobile-nav-tabs').first().removeClass('active');
		});
		$('.mobile-nav-tab-dropdown').click(function(){
			var $navTab = $(this);
			var target = $navTab.data('target');
			var $target = $(target);
			$target.toggleClass('active');
		});
		$('body').click(function(e){
			if(!$(e.target).hasClass('mobile-nav-tab-dropdown')){
				$('.mobile-nav-tabs').removeClass('active');
			}
		});
	}
	
	function mobileConfig(){
		function mobileTabs(){
			$('.mobile-nav-tab-dropdown').each(function(){
				var target = $(this).data('target');
				$(target).addClass('mobile-nav-tabs');
			});	
		}
		function mobileFooter(){
			$('.cdz-toggle-title').each(function(){
				var $title = $(this);
				if( $title.data('cdz-toggle') != ''){
					var $content = $($title.data('cdz-toggle'));
					$content.hide();
					$title.click(function(){
						if( !$title.hasClass('active') ){
							$('.cdz-toggle-title.active').click();
						}
						$title.toggleClass('active');
						$content.slideToggle();
					});
				}
			});
		}
		mobileTabs();
		mobileFooter();
	}
	function pcConfig(){
		function hideMobileSidebar(){
			if($('body').hasClass('canvas-slid')){
				$('#cdz-mobile-nav').offcanvas('hide');
			}	
		}
		function pcTabs(){
			$('.mobile-nav-tabs').removeClass('mobile-nav-tabs');	
		}
		function pcFooter(){
			$('.cdz-toggle-title').each(function(){
				var $title = $(this);
				if( $title.data('cdz-toggle') != ''){
					var $content = $($title.data('cdz-toggle'));
					$content.show();
					$title.unbind('click');
					$title.removeClass('active');
				}
			});
		}
		hideMobileSidebar();
		pcTabs();
		pcFooter();
	}
	function mobileMenu(){
		$('.cdz-mobile-menu').find('.root-parent').each(function(){
			var $parent = $(this);
			$parent.find('.cdz-sub-cat').hide();
			$parent.find('.dropdown-toggle').each(function() {
                var $ddToggle = $(this);
				$ddToggle.click(function(){
					var $li = $ddToggle.parents('.menu-item').first();
					var $subCat = $li.find('.cdz-sub-cat').first();
					$li.toggleClass('open');
					$subCat.toggleClass('open');
					$subCat.slideToggle(300);
				});
            });
		});
		
	}
	
	function cdzBackTopButton(){
		var $backTop = $('#back-top');
		if($backTop.length){
			$backTop.hide();
			$(window).scroll(function() {
				if ($(this).scrollTop() > 100) {
					$backTop.fadeIn();
				} else {
					$backTop.fadeOut();
				}
			});
			$('a', $backTop).click(function() {
				$('body,html').animate({
					scrollTop: 0
				}, 800);
				return false;
			});
		}
	}
	$(document).ready(function(e) {
		responsiveTabs();
		mobileMenu();
		changeAdapt();
		stickyMenu();
		
		
		$(window).bind('cdz_mobile',mobileConfig);
		$(window).bind('cdz_pc',pcConfig);
		
		if(curWinWidth < adapt){
			mobileConfig();
		}else{
			pcConfig();
		}
		
		$('.cdz-mobile-search').dropdownMenu({trigger:'.cdz-search-trigger',dropdown:'.cdz-dropdown-content'});
		$('.cdz-dropdown').dropdownMenu({trigger:'.cdz-trigger',dropdown:'.cdz-dropdown-content'});
		$('.cat-input').dropdownMenu({trigger:'.cdz-trigger',dropdown:'.cdz-dropdown-content',hideAffterClick:true});

		alignMenu();
		cdzSlider();
		cdzTooltip();
		cdzBackTopButton();
		$(window).resize(function(){
			setTimeout(function(){
				$('body').sameHeightItems();
			},300);
		});
		$('.codazon-ajax-wrap').bind('contentUpdated',function(){
			var $this = $(this);
			$this.find('[data-toggle="tooltip"],.cdz-tooltip').tooltip();
			if(typeof $.fn.unveil !== 'undefined'){
				$this.find('.cdz-lazy').unveil();
			}
			$this.find('.btn-cart').ajaxCartEffect();
			$this.sameHeightItems();
		});
		$('[data-toggle="tab"]').click(function(){
			var tab = $(this).attr('href');
			var $tab = $(tab);
			setTimeout(function(){
				$tab.sameHeightItems();
			},300);
		});
		if( !$('body').hasClass('checkout-onepage-index') ){
			window.fieldLabelEffect();
		}
    });
	$(window).load(function(){
		$('body').sameHeightItems();
		lazyImages();
	});
})( jQuery );
