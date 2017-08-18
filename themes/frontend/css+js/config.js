/* ---------------------------------------------------------------------- */
/*	Template Settings													  */
/* ---------------------------------------------------------------------- */

	var CONFIG = (function ($, window) {
		
		return {
            /* ---------------------------------------------------- */
            /*	Tweets												*/
            /* ---------------------------------------------------- */

            twitterFeed: {
                "id": '351293746240958465',                 // Twitter Widget ID
                "domId": 'tweet',
                "maxTweets": 1,								// Number of tweets to display
                "enableLinks": true,
                "showUser": false,
                "showTime": true,
                "showRetweet": false,
                "showInteraction": false
            },

			/* ---------------------------------------------------- */
			/*	Contact Form												*/
			/* ---------------------------------------------------- */

			objContactForm: {
				captcha: true,						        // Boolean:  (true/false)
				emailAddress: 'youremail@emaildomain.com'   // Email for contact
			},
            
            /* ---------------------------------------------------- */
			/*	Portfolio Mixitup									*/
			/* ---------------------------------------------------- */
			
			objMixitup : {
				targetSelector: '.mix',
				filterSelector: '.filter',
				buttonEvent: 'click',
				effects: 'translateZ(-360px) stagger(34ms) scale(1.11) fade',	// The effects for all filter operations as a space-separated string. 
				listEffects: null,
				easing: 'cubic-bezier(0.6, -0.28, 0.735, 0.045)',	// A valid CSS3 transition-timing function or shorthand
				layoutMode: 'grid',
				targetDisplayGrid: 'inline-block',
				targetDisplayList: 'block',
				transitionSpeed: 680,
				showOnLoad: 'all',		// Select filter: all, architecture, buildings, bridges
				sortOnLoad: false,		// Boolean: (true/false) - on/off sorting on load
				multiFilter: false,		// Boolean: (true/false)
				resizeContainer: true,
				minHeight: 0,
				perspectiveDistance: '2000',	// the perspective value in CSS units applied to the container during animations, affecting any 3d transform-based effects, default '3000px'
				perspectiveOrigin: '50% 50%',	// the perspective-origin value applied to the container during animations, affecting any 3d transform based effects, default '50% 50%'
				animateGridList: true,			// Boolean: (true/false)
				onMixEnd: null
			},
            
            /* ---------------------------------------------------- */
			/*	Owl Slider										    */
			/* ---------------------------------------------------- */
			
			objOwlCarousel : {
				loop:true,
                margin:10,
                nav:true,
                items: 1,
                animateOut: 'fadeOut',
                animateIn: 'fadeIn'
            },

            /* ---------------------------------------------------- */
            /*	Fixed Menu										    */
            /* ---------------------------------------------------- */

            objFixedMenu: {
                switcher: true      // Boolean: (true/false)
            }
			
		}

	}(jQuery, window));
	
/* ---------------------------------------------------------------------- */
/*	end Template Settings												  */
/* ---------------------------------------------------------------------- */			
		