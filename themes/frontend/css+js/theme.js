
(function($, window, Modernizr, document) {
	'use strict';

	var tmm_theme = function() {
		var self = {
			$window : $(window),
			el : $('body'),
			navMobile: $('#mobile-advanced'),
			navMain : $('#navigation'),
			wrapper: $('#wrapper'),
			header : $('#header'),
			headerBottom : $('.header-bottom'),
			headerTop : $('.header-top'),
			headerMiddle : $('.header-middle'),
			navButton: $(),
			touch : Modernizr.touch,
			support : Modernizr.cssanimations && Modernizr.csstransitions,
			eventtype : this.touch ? 'touchstart' : 'click',
			backTopButton : $('#back-top'),

			init: function () {

				this.navButton = $('<a/>', {
					id: 'responsive-nav-button',
					'class': 'responsive-nav-button',
					href: '#'
				}).insertBefore(self.navMain);

				this.navHide = $('<a/>', {
					id: 'advanced-menu-hide',
					href: '#'
				}).insertBefore(self.navMobile);

				self.navInit();
			},
			stickyHeader: function() {
				if ($(window).width() > 767) {
					if ($(window).scrollTop() > (self.headerTop.outerHeight(true) + self.headerMiddle.outerHeight(true))) {
						self.header.addClass('shrink-bottom-line');
					} else {
						self.header.removeClass('shrink-bottom-line');
					}
				}
			},
			navInit: function () {
				self.mainNav(self, self.$window);
				self.touchNav(self, self.$window);

				self.$window.on('resize.nav', function (e) {
					var timer = setTimeout(function () {
						clearTimeout(timer);
						self.mainNav(self, e.currentTarget);
						self.touchNav(self, e.currentTarget);
					}, 30);
				});
			},

			mainNav: function (self, target) {

				var noTouchWidth = $(target).width() > 992;

				if (noTouchWidth) {

					var widthNav = self.navMain.width();

					self.navMain.children('div').children('ul').children('li').each(function (idx, val) {

						var $this = $(val),
							megaMenu = $this.children('.mega-menu');

						if (!megaMenu.length) {

							$this.find('ul').parent().each(function () {
								var $el = $(this);

								$el.data('is', $el.parents('ul').length === 1 ? true : false)
									.addClass(!$el.data('is') ? 'arrowright' : '');
							});
						}

						if (megaMenu.length) {

							var list = megaMenu.children('ul').find('ul.sub-menu'),
								headerWidth = self.navMain.width(),
								columns = megaMenu.children('ul').find('li>span'),
								empty_li = megaMenu.children('ul').children('li'),
								length = list.length,
								dataColumn,
								li, size = [], Max, m, s;

							if (columns.length > length) {

								empty_li.css({width: Math.ceil(headerWidth / empty_li.length)});
							} else {

								list.each(function (idx, value) {

									var $this = $(this),
										item_width;
									dataColumn = $this.parent().find('span').data('column');
									if (dataColumn) {
										switch (dataColumn) {
											case 'one_fourth' :
												item_width = Math.ceil(headerWidth * 25 / 100);
												break;
											case 'one_third' :
												item_width = Math.ceil(headerWidth * 33.33333333333333 / 100);
												break;
											case 'one_half' :
												item_width = Math.ceil(headerWidth / 2);
												break;
											case 'two_thirds' :
												item_width = Math.ceil(headerWidth * 66.66666666666666 / 100);
												break;
											case 'three_fourth' :
												item_width = Math.ceil(headerWidth * 75 / 100);
												break;
											default :
												item_width = headerWidth;
												break;
										}

										$this.css({width: item_width}).addClass(dataColumn);

									} else {
										$this.css({width: Math.ceil(headerWidth / length)});
									}

									li = $(value).children('li');
									size.push(li.length);
								});
							}

							$this.addClass('is-mega-menu');

						}

					});
				} else {
					self.navMobile.find('.mega-menu')
						.children('ul')
						.find('ul')
						.attr('style', '')
						.find('li:has(.nothing)').remove();
				}
			},

			touchNav: function (self, target) {
				if (self.touch || $(target).width() < 993) {

					if (!self.navMobile.children('div').length) {
						self.navMobile.append(self.navMain.html());
						self.navMobile.find('.inner-tooltip').attr('style', '');
					}

					self.navButton.on(self.eventtype, function (e) {
						e.preventDefault();
						var $this = $(this);
						if (!self.wrapper.is('.active')) {
							$('html, body').animate({scrollTop: 0}, 0, function () {
								self.wrapper.css({
									height: self.navMobile.find('div').outerHeight(true) +
									self.navMobile.children('.search-box').outerHeight(true)
								}).addClass('active');
							});
						}
						var folio_items = self.navMobile.find('.portfolio-items article');
						if (folio_items.length) {
							folio_items.slideFade({
								find: '.item-overlay'
							});
						}

					});
					self.navHide.on(self.eventtype, function (e) {
						e.preventDefault();
						if (self.wrapper.is('.active')) {
							self.wrapper.css({height: 'auto'}).removeClass('active');
						}
					});
				} else {
					self.navMobile.children('ul').remove().next().remove();
				}
			},
			magnificPopupInitStapel: function(a) {
				a.magnificPopup({
					type: 'image',
					removalDelay: 500,
					tLoading: 'Loading image #%curr%...',
					callbacks: {
						beforeOpen: function() {

							this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
							this.st.mainClass = 'mfp-move-horizontal';
						},
						buildControls: function() {
							// re-appends controls inside the main container
							this.contentContainer.append(this.arrowLeft.add(this.arrowRight));
						}
					},
					gallery: {
						enabled: true,
						navigateByImgClick: true,
						preload: [0, 1]
					},
					closeOnContentClick: true,
					midClick: true
				});
			},

			magnificPopupGall: function(a){
				a.magnificPopup({
					delegate: '.popup-link',
					type: 'image',
					removalDelay: 500,
					tLoading: 'Loading image #%curr%...',
					callbacks: {
						beforeOpen: function() {

							this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
							this.st.mainClass = 'mfp-move-horizontal';
						},
						buildControls: function() {

							// re-appends controls inside the main container
							if ($('.popup-link').length > 1) 
								this.contentContainer.append(this.arrowLeft.add(this.arrowRight));

							}
					},
					gallery: {
						enabled: true
					},
					closeOnContentClick: true,
					midClick: true
				});
			},
			magnificPopupImage: function(a){
				a.magnificPopup({
					type: 'image',
					removalDelay: 500,
					tLoading: 'Loading image #%curr%...',
					gallery: {
						enabled: true
					},
					closeOnContentClick: true,
					midClick: true
				});
			},
			magnificPopupPostGall: function(a){
				a.magnificPopup({
					type: 'image',
					removalDelay: 500,
					tLoading: 'Loading image #%curr%...',
					callbacks: {
						beforeOpen: function() {

							this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
							this.st.mainClass = 'mfp-move-horizontal';
						},
						buildControls: function() {
							// re-appends controls inside the main container
							this.contentContainer.append(this.arrowLeft.add(this.arrowRight));
						}
					},
					gallery: {
						enabled: true
					},
					closeOnContentClick: true,
					midClick: true
				});
			},
			backTopClickHandler : function(){
			},
			backTopScrollHandler: function (win) {

				var backTop = self.el.find('#back-top');
				$(window).scrollTop() > 200 ? backTop.fadeIn(400) : backTop.fadeOut(400);
			}
		};
		return self;
	};

	var tmm_ext_theme = null;

	$(function() {

		tmm_ext_theme = new tmm_theme();
		tmm_ext_theme.init();

		/* ---------------------------------------------------- */
		/*	Tmm Loader                                          */
		/* ---------------------------------------------------- */

		var tmm_loader = {
			screen_1 : $('.tmm_loader'),

			init : function(){
				var $this = this,
					wrapper = $('#wrapper');
					wrapper.addClass('translate');

				$(window).load(function() {

					setTimeout(function(){
						$this.screen_1.addClass('fade');
						wrapper.addClass('translateRun');

					},600);
					setTimeout(function(){
						$this.screen_1.remove();
						wrapper.removeClass('translateRun').removeClass('translate');
					},1300);

				});
			}
		};
		if (tmm_loader.screen_1.length) {
			tmm_loader.init();
		}

		/* ---------------------------------------------------- */
		/*	Back to Top											*/
		/* ---------------------------------------------------- */

        $('body').backToTop();

		/* ---------------------------------------------------- */
		/*	Fixed Menu											*/
		/* ---------------------------------------------------- */

        var fixedMenu = CONFIG.objFixedMenu.switcher;

        if (fixedMenu === true) {
            $('body').toggleClass('header-fixed');
        }

		if (jQuery('.header-fixed').length){
			$(window).on('scroll', function (e) {
				tmm_ext_theme.stickyHeader();
				//tmm_ext_theme.backTopScrollHandler();
			});
		}

        /* ---------------------------------------------------- */
        /*	Layer Slider Init                                   */
        /* ---------------------------------------------------- */

        var lsjQuery = jQuery;

        lsjQuery(document).ready(function() {
            if ($("#layerslider_1_1").length) {
                lsjQuery("#layerslider_1_1").layerSlider({
                    skin: 'noskin',
                    globalBGColor: '#11547b',
                    skinsPath: 'themes/frontend/css+js/css/'
                })
            }
            if ($('#layerslider_2_1').length) {
                lsjQuery("#layerslider_2_1").layerSlider({
                    skin: 'v5',
                    globalBGColor: '#11547b',
                    skinsPath: 'themes/frontend/css+js/css/'
                })
            }
        });

		/* ---------------------------------------------------- */
		/*	FitVids                                             */
		/* ---------------------------------------------------- */

		$('#wrapper').fitVids();
        
        /* ---------------------------------------------------- */
		/*	Owl Carousel Init                                   */
		/* ---------------------------------------------------- */

        var postSlider = $('.post-type-gallery > .owl-carousel');
        var config = CONFIG.objOwlCarousel;
        $(function() {
            if (postSlider.length) {
                postSlider.owlCarousel(config);
            }
        });
        
        /* ---------------------------------------------------- */
		/*	Animate Elements									*/
		/* ---------------------------------------------------- */

        $('body').animation();


        /* ---------------------------------------------------- */
        /*	Portfolio											*/
        /* ---------------------------------------------------- */

        if ($('#portfolio-items').length) {

            var folio = $('#portfolio-items');

            folio.mixitup(CONFIG.objMixitup);
            
            $(".filter").on('click', function(event) {
               event.preventDefault(); 
            });

            var $loadMore = $('.load-more');

            if ($loadMore.length) {
				var i = 1,
                    self = this,
                    $next_href = null;

                $loadMore.on('click', function(e) {
                    e.preventDefault();
                var link = $(this).attr('href'),
                        $content = '#portfolio-items',
                        $anchor = '.load-more';
                $.get(link, function(data) {
                    var $new_content = $($content, data).wrapInner('').html();
                    $next_href = $($anchor, data).attr('href');
                    $('article:last', folio).after($new_content);
                    folio.mixitup('remix', 'all');
//							initHoverEffectForThumbView(CONFIG.folioImageMove);
                        $loadMore.attr('data-rel') > i ? $loadMore.attr('href', $next_href) : $loadMore.remove();
                    });
                    i++;
                });
            }
        }

		/*---------------------------------------------------- */
		/*	Alert Boxes Init 							 	   */
		/*---------------------------------------------------- */

		var $notifications = $('.error, .success, .info, .notice, .transparent');

		if ($notifications.length) {
			$notifications.notifications({speed: 300});
		}

		/* ---------------------------------------------------- */
		/*	Stapel												*/
		/* ---------------------------------------------------- */

		if($('#tp-grid').length) {
			var $grid = $( '#tp-grid' ),
				$name = $( '#name' ),
				$close = $( '#gallery-close' ),
				$loader = $( '<div class="loader"><i></i><i></i><i></i><i></i><i></i><i></i><span>Loading...</span></div>' ).insertBefore( $grid ),
				stapel = $grid.stapel( {
					onLoad : function() {
						$loader.remove();
					},
					onBeforeOpen : function( pileName ) {
						$name.html( pileName );
						var groups = $('.tp_groups').val();
						for (var i=1; i<=groups; i++){
							tmm_ext_theme.magnificPopupInitStapel($('.popup-link-'+i));
						}
					},
					onAfterOpen : function( pileName ) {
						$close.show();
					},
					gutter : 45

				});

			$close.on( 'click', function() {
				$close.hide();
				$name.empty();
				stapel.closePile();
			} );
		}

		/* ---------------------------------------------------- */
		/*	Magnific Popup										*/
		/* ---------------------------------------------------- */

		if ($('.popup-gallery').length) {
			tmm_ext_theme.magnificPopupGall($('.popup-gallery'));
		}
		if ($('.single-image-link').length){
			tmm_ext_theme.magnificPopupImage($('.single-image-link'));
		}
		if ($('div:not(.cloned)>.image-link').length){
			tmm_ext_theme.magnificPopupPostGall($('div:not(.cloned)>.image-link'));
		}


		/* ---------------------------------------------------- */
		/*	Media Element Player								*/
		/* ---------------------------------------------------- */

		var $player = $('audio, video');

		if ($player.length) {
			$player.mediaelementplayer({
				audioWidth: '100%',
				audioHeight: 45,
				videoWidth: '',
				videoHeight: ''
			});
		}

        /* ---------------------------------------------------- */
        /*	Tweets Init											*/
        /* ---------------------------------------------------- */

        (function() {
            if ($('#tweet').length) {
                twitterFetcher.fetch(CONFIG.twitterFeed);
            }
        }());

		/* ---------------------------------------------------- */
		/*	Masonry                                             */
		/* ---------------------------------------------------- */

        $(window).load(function() {
           if ($('#masonry').length) {
            	$('#masonry').masonry({
					itemSelector: '.item',
					singleMode: true
				});
            }
        });
	});

    /*----------------------------------------------------*/
	/*	Accordion and Toggle							  */
	/*----------------------------------------------------*/

	if ($('.accordion').length) {

		var	eventtype = Modernizr.touch ? 'touchstart' : 'click',
			$trigger = $('.accordion-navigation .acc-trigger');

		$trigger.on(eventtype, function() {
			var $thisTrigger = $(this).parents('.accordion').find('.acc-trigger');

			var $this = $(this);
			if ($this.data('mode') === 'toggle') {
				$this.toggleClass('active').next().stop(true, true).slideToggle(300);
			} else {
				if ($this.hasClass('active')) {
					$this.removeClass('active').next().stop(true, true).slideUp(300);
				} else {
					$thisTrigger.removeClass('active').next().slideUp(300);
					$this.addClass('active').next().slideDown(300);
				}
			}
			return false;
		});
	}

	/* ---------------------------------------------------- */
	/*	Contact Form										*/
	/* ---------------------------------------------------- */

	if ($('.contact-form').length) {

		var $form = $('.contact-form'),
			$captcha = $('#captcha', $form),
			$loader = '<span>Loader...</span>';
		$form.append('<div class="hide contact-form-responce" />');

		if (CONFIG.objContactForm.captcha) {
			$captcha.addClass('show-captcha');
		}

		$form.each(function () {
			var $this = $(this),
				$response = $('.contact-form-responce', $this).append('<p></p>');
			$this.prepend('<input type="hidden" name="emailAddress" value="' + CONFIG.objContactForm.emailAddress + '" />');

			var value = CONFIG.objContactForm.captcha ? 1 : 0;
			$this.prepend('<input type="hidden" name="captcha" value="' + value + '" />');

			$this.submit(function () {

				$response.find('p').html($loader);

				var data = {
					action: "contact_form_request",
					values: $this.serialize()
				};

				//send data to server
				$.post("php/contact-send.php", data, function (response) {

					$('.wrong-data', $this).removeClass("wrong-data");
					$response.find('span').remove();

					response = $.parseJSON(response);

					if (response.is_errors) {

						var p = $response.find('p');

						p.removeClass().addClass("error");
						$.each(response.info, function (input_name, input_label) {
							$("[name=" + input_name + "]", $this).addClass("wrong-data");
							p.append('Please enter correctly "' + input_label + '"!' + '</br>');
						});
						$response.show(300);
					} else {
						$response.find('p').removeClass().addClass('success');
						if (response.info === 'success') {
							$response.find('p').append('Your email has been sent!');
							$this.find('input, textarea, select').val('').attr('checked', false);
							$response.show(300).delay(2500).hide(400);
						}
						if (response.info === 'server_fail') {
							$response.find('p').append('Server failed. Send later!');
							$response.show(300);
						}
					}

					// Scroll to bottom of the form to show respond message
					var bottomPosition = $response.offset().top - 50;

					if ($(document).scrollTop() < bottomPosition) {
						$('html, body').animate({ scrollTop : bottomPosition });
					}
				});
				return false;
			});
		});

	}

	/* ---------------------------------------------------- */
	/*	Tabs												*/
	/* ---------------------------------------------------- */

	if ($('.tabs-holder').length) {
		var $tabsHolder = $('.tabs-holder');

		$tabsHolder.each(function(i, val) {

			var $tabsNav = $('.tabs-nav', val),
				tabsNavLis = $tabsNav.children('li'),
				$tabsContainer = $('.tabs-container', val),
				eventtype = Modernizr.touch ? 'touchstart' : 'click';

			$tabsNav.each(function() {
				$(this).next().children('.tab-content').first().stop(true, true).show();
				$(this).children('li').first().addClass('active').stop(true, true).show();
			});

			$tabsNav.on(eventtype, 'h3', function(e) {
				var $this = $(this).parent('li'),
					$index = $this.index();
				$this.siblings().removeClass('active').end().addClass('active');
				$this.parent().next().children('.tab-content').stop(true, true).hide().eq($index).stop(true, true).fadeIn(250);
				e.preventDefault();
			});
		});
	}

    /* ---------------------------------------------------------------------- */
    /*	Plugins																  */
    /* ---------------------------------------------------------------------- */

    $.fn.extend({
        backToTop: function() {
			var self = this;

			return this.each(function() {
				return {
					init: function() {
						var me = this;
						self.append('<a href="#" id="back-top" title="Back To Top"></a>');
						this.backToTop = $('#back-top');

						$(window).on('scroll', function (win) {
							me.backTopScrollHandler(win);
						});
						this.backTopClickHandler();
					},
					backTopScrollHandler: function(win) {
						$(win.currentTarget).scrollTop() > 200 ? this.backToTop.fadeIn(400) : this.backToTop.fadeOut(400);
					},
					backTopClickHandler: function() {
						this.backToTop.on('click', function (e) {
							e.preventDefault();
							$('html, body').animate({scrollTop: 0}, 1000);
						})
					}
				}.init();
			});
		},
        /*	Animation  */
		animation: function() {
			return this.each(function() {
				return {
					init: function() {
						var  self = this;
							this.support = Modernizr.cssanimations && Modernizr.csstransitions;
							this.touch = Modernizr.touch;
						if (this.support) {
							if (!this.touch) {
								this.animatedElements();
							} else {
								$("body").removeClass('animated');
							}						
						}
					},
                    animatedElements: function () {
                        if ($('.elementFade').length) {
                            $('.elementFade').appear({
                                accX: 0,
                                accY: -150,
                                data: 'elementFade',
                                speedAddClass: 0
                            });
                        }

                        if ($('.slideUp').length) {
                            $('.slideUp').appear({
                                accX: 0,
                                accY: -150,
                                data: 'slideUp',
                                speedAddClass: 0
                            });
                        }

                        if ($('.slideLeft').length) {
                            $('.slideLeft').appear({
                                accX: 0,
                                accY: -150,
                                data: 'slideLeft',
                                speedAddClass: 0
                            });
                        }

                        if ($('.slideRight').length) {
                            $('.slideRight').appear({
                                accX: 0,
                                accY: -150,
                                data: 'slideRight'
                            });
                        }
                        if ($('.slideDown').length) {
                            $('.slideDown').appear({
                                accX: 0,
                                accY: -150,
                                data: 'slideDown'
                            });
                        }

                        if ($('.opacity').length) {
                            $('.opacity').appear({
                                accX: 0,
                                accY: 300,
                                data: 'opacity'
                            });
                        }

                        if ($('.opacity2x').length) {
                            $('.opacity2x').appear({
                                accX: 0,
                                accY: 150,
                                data: 'opacity2x'
                            });
                        }

                        if ($('.slideUp2x').length) {
                            $('.slideUp2x').appear({
                                accX: 0,
                                accY: 300,
                                data: 'slideUp2x',
                                speedAddClass: 200
                            });
                        }

                        if ($('.scale').length) {
                            $('.scale').appear({
                                accX: 0,
                                accY: 150,
                                data: 'scale'
                            });
                        }

                        if ($('.extraRadius').length) {
                            $('.extraRadius').appear({
                                accX: 0,
                                accY: -150,
                                data: 'extraRadius'
                            });
                        }
                    },
				}.init();
			});
		}
    });
    


    /* ---------------------------------------------------- */
    /*	FitVids												*/
    /* ---------------------------------------------------- */

    $.fn.fitVids = function(options) {
        var settings = {
            customSelector: null
        };

        if (!document.getElementById('fit-vids-style')) {

            var div = document.createElement('div'),
                ref = document.getElementsByTagName('base')[0] || document.getElementsByTagName('script')[0],
                cssStyles = '&shy;<style>.fluid-width-video-wrapper{width:100%; position:relative;padding:0;}.fluid-width-video-wrapper iframe,.fluid-width-video-wrapper object,.fluid-width-video-wrapper embed {position:absolute;top:0;left:0;width:100%;height:100%;}</style>';

            div.className = 'fit-vids-style';
            div.id = 'fit-vids-style';
            div.style.display = 'none';
            div.innerHTML = cssStyles;

            ref.parentNode.insertBefore(div, ref);

        }

        if (options) {
            $.extend(settings, options);
        }

        return this.each(function() {
            var selectors = [
                "iframe[src*='player.vimeo.com'].fitwidth",
                "iframe[src*='youtube.com'].fitwidth",
                "iframe[src*='youtube-nocookie.com'].fitwidth",
                "iframe[src*='kickstarter.com'][src*='video.html'].fitwidth",
                "object",
                "embed"
            ];

            if (settings.customSelector) {
                selectors.push(settings.customSelector);
            }

            var $allVideos = $(this).find(selectors.join(','));
            $allVideos = $allVideos.not("object object"); // SwfObj conflict patch


            $allVideos.each(function() {
                var $this = $(this);
                if (this.tagName.toLowerCase() === 'embed' && $this.parent('object').length || $this.parent('.fluid-width-video-wrapper').length) {
                    return;
                }
                var height = (this.tagName.toLowerCase() === 'object' || ($this.attr('height') && !isNaN(parseInt($this.attr('height'), 10)))) ? parseInt($this.attr('height'), 10) : $this.height(),
                    width = !isNaN(parseInt($this.attr('width'), 10)) ? parseInt($this.attr('width'), 10) : $this.width(),
                    aspectRatio = height / width;
                if (!$this.attr('id')) {
                    var videoID = 'fitvid' + Math.floor(Math.random() * 999999);
                    $this.attr('id', videoID);
                }
                $this.wrap('<div class="fluid-width-video-wrapper"></div>').parent('.fluid-width-video-wrapper').css('padding-top', (aspectRatio * 100) + "%");
                $this.removeAttr('height').removeAttr('width');

            });
        });

    };


    $(".post-like").on('click', function(e) {
        e.preventDefault();
    });


    /* ---------------------------------------------------- */
    /*	Dialog Windows										*/
    /* ---------------------------------------------------- */

    (function() {

        var dlgLogin = document.querySelector( '[data-login]' ),
            dataLogin = document.getElementById( dlgLogin.getAttribute( 'data-login' ) ),
            dlgL = new DialogFx(dataLogin);
			
		var dlgAccount = document.querySelector('[data-account]'),
            accountDialog = document.getElementById( dlgAccount.getAttribute( 'data-account' ) ),
            dlgA = new DialogFx(accountDialog);

            dlgLogin.addEventListener( 'click', dlgL.toggle.bind(dlgL) );
            dlgAccount.addEventListener( 'click', dlgA.toggle.bind(dlgA) );

    })();

	/* ---------------------------------------------------- */
	/*	Checkboxes and radio buttons    					*/
	/* ---------------------------------------------------- */

	$(function() {

		var form = $('form');

		form.find('input[type="checkbox"]').each(function(){

			if (!$(this).hasClass('tmm-checkbox')) {

				var id = $(this).attr('id'),
					index = $(this).index('input[type="checkbox"]'),
					_this = $(this).get(0),
					next = _this.nextSibling;

				if (id === undefined) {
					id = 'tmm_cb_' + index;
					$(this).attr('id', id);
				}

				if ($(next).length) {
					if (next.nodeType === 3 && $.trim(next.nodeValue) !== '') {
						$(next).wrap('<label for="'+id+'"></label>');
					} else if($(next).prop("tagName") === 'LABEL') {
						$(next).attr('for', id);
					}
				}

				$(this).addClass('tmm-checkbox');
			}

		});

		form.find('input[type="radio"]').each(function(){

			if (!$(this).hasClass('tmm-radio')) {

				var id = $(this).attr('id'),
					index = $(this).index('input[type="radio"]'),
					_this = $(this).get(0),
					next = _this.nextSibling;

				if (id === undefined) {
					id = 'tmm_rb_' + index;
					$(this).attr('id', id);
				}

				if ($(next).length) {
					if (next.nodeType === 3 && $.trim(next.nodeValue) !== '') {
						$(next).wrap('<label for="'+id+'"></label>');
					} else if($(next).prop("tagName") === 'LABEL') {
						$(next).attr('for', id);
					}
				}

				$(this).addClass('tmm-radio');
			}
		});
	});

}(jQuery, window, Modernizr, document));