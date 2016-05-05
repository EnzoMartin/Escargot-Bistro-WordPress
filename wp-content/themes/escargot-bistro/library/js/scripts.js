/*
 * Bones Scripts File
 * Author: Eddie Machado
 *
 * This file should contain any js scripts you want to add to the site.
 * Instead of calling it in the header or throwing it inside wp_head()
 * this file will be called automatically in the footer so as not to
 * slow the page load.
 *
 * There are a lot of example functions and tools in here. If you don't
 * need any of it, just remove it. They are meant to be helpers and are
 * not required. It's your world baby, you can do whatever you want.
*/


/*
 * Get Viewport Dimensions
 * returns object with viewport dimensions to match css in width and height properties
 * ( source: http://andylangton.co.uk/blog/development/get-viewport-size-width-and-height-javascript )
*/
function updateViewportDimensions() {
	var w=window,d=document,e=d.documentElement,g=d.getElementsByTagName('body')[0],x=w.innerWidth||e.clientWidth||g.clientWidth,y=w.innerHeight||e.clientHeight||g.clientHeight;
	return { width:x,height:y };
}
// setting the viewport width
var viewport = updateViewportDimensions();


/*
 * Throttle Resize-triggered Events
 * Wrap your actions in this function to throttle the frequency of firing them off, for better performance, esp. on mobile.
 * ( source: http://stackoverflow.com/questions/2854407/javascript-jquery-window-resize-how-to-fire-after-the-resize-is-completed )
*/
var waitForFinalEvent = (function () {
	var timers = {};
	return function (callback, ms, uniqueId) {
		if (!uniqueId) { uniqueId = "Don't call this twice without a uniqueId"; }
		if (timers[uniqueId]) { clearTimeout (timers[uniqueId]); }
		timers[uniqueId] = setTimeout(callback, ms);
	};
})();

// how long to wait before deciding the resize has stopped, in ms. Around 50-100 should work ok.
var timeToWaitForLast = 100;


/*
 * Here's an example so you can see how we're using the above function
 *
 * This is commented out so it won't work, but you can copy it and
 * remove the comments.
 *
 *
 *
 * If we want to only do it on a certain page, we can setup checks so we do it
 * as efficient as possible.
 *
 * if( typeof is_home === "undefined" ) var is_home = $('body').hasClass('home');
 *
 * This once checks to see if you're on the home page based on the body class
 * We can then use that check to perform actions on the home page only
 *
 * When the window is resized, we perform this function
 * $(window).resize(function () {
 *
 *    // if we're on the home page, we wait the set amount (in function above) then fire the function
 *    if( is_home ) { waitForFinalEvent( function() {
 *
 *	// update the viewport, in case the window size has changed
 *	viewport = updateViewportDimensions();
 *
 *      // if we're above or equal to 768 fire this off
 *      if( viewport.width >= 768 ) {
 *        console.log('On home page and window sized to 768 width or more.');
 *      } else {
 *        // otherwise, let's do this instead
 *        console.log('Not on home page, or window sized to less than 768.');
 *      }
 *
 *    }, timeToWaitForLast, "your-function-identifier-string"); }
 * });
 *
 * Pretty cool huh? You can create functions like this to conditionally load
 * content and other stuff dependent on the viewport.
 * Remember that mobile devices and javascript aren't the best of friends.
 * Keep it light and always make sure the larger viewports are doing the heavy lifting.
 *
*/


/*
 * Put all your regular jQuery in here.
*/
jQuery(document).ready(function($) {

	;(function($,win){
		'use strict';

		/**
		 * Simple Banner constructor
		 * @param element
		 * @param options
		 * @constructor
		 */
		var Simplebanner = function(element,options){
			this.element = element;
			this._paused = false;
			this._timer = {};
			this._currentBanner = {};
			this._newBanner = {};
			this._bannerWidth = 0;
			this._bannerCount = 0;
			this.options = $.extend({
				arrows:true,
				indicators:true,
				pauseOnHover:true,
				autoRotate:true,
				rotateTimeout:5000,
				animTime:300
			},options);

			this.init();
		};

		/**
		 * Initializer
		 */
		Simplebanner.prototype.init = function(){
			var $banners = this.element.find('.bannerList li');
			this._bannerCount = $banners.length;
			this._bannerWidth = $banners.outerWidth();

			if(!this._bannerWidth){
				this._bannerWidth = this.element.width();
			}
			this._currentBanner = $banners.first().addClass('current');

			if(this.options.indicators){
				this.buildIndicators();
			} else {
				this.element.addClass('hiddenIndicators');
			}
			if(!this.options.arrows){
				this.element.addClass('hiddenArrows');
			}
			if(this._bannerCount > 1 && this.options.autoRotate){
				this.toggleTimer();
			}

			this.bindEvents();
		};

		/**
		 * This sets the basic events based off the options selected
		 */
		Simplebanner.prototype.bindEvents = function(){
			var self = this;
			if(self.options.indicators){
				self.element.find('.bannerIndicator').on({
					'click':function(){
						var $this = $(this);
						if(!$this.hasClass('active')){
							var slideIndex = $this.index();
							self._newBanner = self.element.find('.bannerList li:eq(' + slideIndex + ')');
							self.goToBanner(slideIndex);
						}
					}
				});
			}

			if(self.options.arrows){
				self.element.find('.bannerControlsWpr').on({
					'click':function(){
						if($(this).hasClass('bannerControlsPrev')){
							self.previousBanner();
						} else {
							self.nextBanner();
						}
					}
				});
			}

			if(self.options.pauseOnHover && self.options.autoRotate){
				self.element.on({
					'mouseenter':function(){
						self.toggleTimer(true);
					},
					'mouseleave':function(){
						self.toggleTimer(false);
					}
				});
			}
		};

		/**
		 * Goes to the next banner - loops back to the first banner
		 */
		Simplebanner.prototype.nextBanner = function(){
			if(this._currentBanner.next().length){
				this._newBanner = this._currentBanner.next();
			} else {
				this._newBanner = this.element.find('.bannerList li:first');
			}

			this.goToBanner(this._newBanner.index());
		};

		/**
		 * Goes to the previous banner - loops back to the last banner
		 */
		Simplebanner.prototype.previousBanner = function(){
			if(this._currentBanner.prev().length){
				this._newBanner = this._currentBanner.prev();
			} else {
				this._newBanner = this.element.find('.bannerList li:last');
			}

			this.goToBanner(this._newBanner.index());
		};

		/**
		 * Goes to a specific slide - This is called by both the Previous and Next methods as well as the Indicator buttons
		 * @param slideIndex
		 */
		Simplebanner.prototype.goToBanner = function(slideIndex){
			var self = this;
			self._currentBanner.removeClass('current');
			self.element.find('.bannerIndicators .current').removeClass('current');
			self._currentBanner = self._newBanner;
			self._currentBanner.addClass('current');
			self.element.find('.bannerIndicators li:eq(' + slideIndex + ')').addClass('current');
			self.element.find('.bannerList').stop(false,true).animate({
				'marginLeft':-slideIndex * self._bannerWidth
			},self.options.animTime);
		};

		/**
		 * Create the correct amount of indicators based off total banners
		 */
		Simplebanner.prototype.buildIndicators = function(){
			var self = this;
			var indicatorUl = self.element.find('.bannerIndicators ul');
			self.element.find('.bannerList li').each(function(){
				indicatorUl.append('<li class="bannerIndicator"></li>');
			});

			indicatorUl.find('li:first').addClass('current');
		};

		/**
		 * Starts or stops the timer for going to the next banner
		 * @param timer
		 */
		Simplebanner.prototype.toggleTimer = function(timer){
			var self = this;
			clearTimeout(self._timer);
			if(!timer){
				self._timer = setTimeout(function(){
					self.nextBanner();
					self.toggleTimer(false);
				},self.options.rotateTimeout);
			}
		};

		/**
		 * jQuery wrapper method
		 * @param options
		 * @returns {boolean|jQuery}
		 */
		$.fn.simplebanner = function(options){
			var method = false;
			var ret = false;
			var args = [];

			if(typeof options === 'string'){
				args = [].slice.call(arguments,0);
			}

			this.each(function(){
				var self = $(this);
				var instance = self.data('bannerInstance');

				if(!self.attr('id')){
					self.attr('id','simpleBanner-' + ($.fn.simplebanner._instances.length + 1));
				}

				if(instance && options){
					if(typeof options === 'object'){
						ret = $.extend(instance.options,options);
					} else if(options === 'options'){
						ret = instance.options;
					} else if(typeof instance[options] === 'function'){
						ret = instance[options].apply(instance,args.slice(1));
					} else {
						throw new Error('Simple Banner has no option/method named "' + method + '"');
					}
				} else {
					instance = new Simplebanner(self,options || {});
					self.data('bannerInstance',instance);
					$.fn.simplebanner._instances.push(instance);
				}
			});
			return ret || this;
		};
	
		$.fn.simplebanner._instances = [];
	}($,window));

	var $carousel = $('#home-carousel');

	if($carousel.find('.item').length > 1){
		$carousel.simplebanner();
	}
}); /* end of as page load scripts */
