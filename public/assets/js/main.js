/***************************************************
==================== JS INDEX ======================
****************************************************
01. PreLoader Js
02. Sidebar Js
03. sidepanel-atart
04. magnificPopup video view
05. Wow Js
06. tp-hero-slider
07. tp-faq-slide
08. tp-testimonial-slide
09. tp-testimonial-hero-slider
10. tp-brands-slide
11. tp-brands-slider-insu
12. tp-brand-bus-slide
13. tp-brand-agen-slide
14. tp-testimonial-feedback
15. tp-protfolio-sliders
16. tp-protfolio-sliders-2
17. tp-testimonial-agen-slider
18. mobile-menu-activation
19. Off Canvas Menu
20. range-slider
21.slider-range-min2
22. slider-range-min3
23. slider-range-min4
24. slider-range-min5
25. Counter Js
26. password-visable
27. increment-dreckment-btn
28. magnific-Popup-active
29. pricing-table
30. back-to-top
31. scrrol up
32. search-toggle
33. preloader
34. Ecommerce js
35. Nice Select Js
36. Jquery Appear raidal

****************************************************/

(function ($) {
	"use strict";

	var windowOn = $(window);
	////////////////////////////////////////////////////
	// 01. PreLoader Js
	windowOn.on('load', function () {
		$("#loading").fadeOut(500);
	});

	$('#section-time').onePageNav({
		currentClass: 'current',
		scrollSpeed: 950,
	});

	////////////////////////////////////////////////////
	// 02. Sidebar Js
	$(".tp-menu-bar").on("click", function () {
		$(".tpoffcanvas").addClass("opened");
		$(".body-overlay").addClass("apply");
	});
	$(".close-btn").on("click", function () {
		$(".tpoffcanvas").removeClass("opened");
		$(".body-overlay").removeClass("apply");
	});
	$(".body-overlay").on("click", function () {
		$(".tpoffcanvas").removeClass("opened");
		$(".body-overlay").removeClass("apply");
	});

	////////////////////////////////////////////////////
	// 03. sidepanel-atart
    const panels = document.querySelectorAll(".tp-service2-custom");

    panels.forEach((panel) => {
      panel.addEventListener("click", () => {
        removeActiveClasses();
        panel.classList.add("active");
      });
    });

    function removeActiveClasses() {
      panels.forEach((panel) => {
        panel.classList.remove("active");
      });
    }

	$("[data-background").each(function () {
		$(this).css("background-image", "url( " + $(this).attr("data-background") + "  )");
	});
	
	////////////////////////////////////////////////////
	// 04. magnificPopup video view
	$(".popup-video").magnificPopup({
		type: "iframe",
	});

	////////////////////////////////////////////////////
	// 05. Wow Js
	new WOW().init();

	////////////////////////////////////////////////////
	// 06. tp-hero-slider
	var slider = new Swiper('.tp-hero-slider', {
		slidesPerView: 1,
		spaceBetween: 30,
		loop: true,
		effect: "fade",
		autoplay: {
			delay: 7000,
		  },
		pagination: {
			el: ".tp-hero-pagenation",
			clickable: true,
		  },
	});

	////////////////////////////////////////////////////
	// 07. tp-faq-slide
	var slider = new Swiper('.tp-faq-slide', {
		slidesPerView: 1,
		spaceBetween: 0,
		effect: "fade",
		loop: true,
		pagination: {
			el: ".tp-faq-pagenation",
			clickable: true,
		  },
	});

	////////////////////////////////////////////////////
	// 08. tp-testimonial-slide
	var slider = new Swiper('.tp-testimonial-slide', {
		slidesPerView: 3,
		spaceBetween: 30,
		loop: true,
		freeMode: true,
		autoplay: {
			delay: 4000,
		  },
		breakpoints: {
			'1500': {
				slidesPerView: 4,
			},
			'1200': {
				slidesPerView: 3,
			},
			'992': {
				slidesPerView: 2,
			},
			'768': {
				slidesPerView: 2,
			},
			'576': {
				slidesPerView: 1,
			},
			'0': {
				slidesPerView: 1,
			},
		},
	});

	////////////////////////////////////////////////////
	// 09. tp-testimonial-hero-slider
	var slider = new Swiper('.tp-testimonial-hero-slider', {
		slidesPerView: 1,
		spaceBetween: 30,
		loop: true,
		autoplay: {
			delay: 4000,
			},
		navigation: {
			nextEl: ".tp-testimonial-hero-next",
			prevEl: ".tp-testimonial-hero-prev",
		},
	});
	
	////////////////////////////////////////////////////
	// 10. tp-brands-slide
	var slider = new Swiper('.tp-brands-slide', {
		slidesPerView: 1,
		spaceBetween: 30,
		loop: true,
		freeMode: true,
		autoplay: {
			delay: 4000,
		  },
		breakpoints: {
			'1200': {
				slidesPerView: 5,
			},
			'992': {
				slidesPerView: 4,
			},
			'768': {
				slidesPerView: 3,
			},
			'576': {
				slidesPerView: 2,
			},
			'0': {
				slidesPerView: 2,
			},
		},
	});

	////////////////////////////////////////////////////
	// 11. tp-brands-slider-insu
	var slider = new Swiper('.tp-brands-slider-insu', {
		slidesPerView: 1,
		spaceBetween: 30,
		loop: true,
		freeMode: true,
		navigation: {
			nextEl: ".tp-brands-slider-insu-next",
			prevEl: ".tp-brands-slider-insu-prev",
		},
		autoplay: {
			delay: 4000,
			},
		breakpoints: {
			'1200': {
				slidesPerView: 5,
			},
			'992': {
				slidesPerView: 4,
			},
			'768': {
				slidesPerView: 3,
			},
			'576': {
				slidesPerView: 2,
			},
			'0': {
				slidesPerView: 2,
			},
		},
	});

	////////////////////////////////////////////////////
	// 12. tp-brand-bus-slide
	var slider = new Swiper('.tp-brand-bus-slide', {
		slidesPerView: 1,
		spaceBetween: 30,
		loop: true,
		freeMode: true,
		autoplay: {
			delay: 4000,
			},
		breakpoints: {
			'1400': {
				slidesPerView: 6,
			},
			'1200': {
				slidesPerView: 4,
			},
			'992': {
				slidesPerView: 4,
			},
			'768': {
				slidesPerView: 3,
			},
			'576': {
				slidesPerView: 2,
			},
			'0': {
				slidesPerView: 2,
			},
		},
	});

	////////////////////////////////////////////////////
	// 13. tp-brand-agen-slide
	var slider = new Swiper('.tp-brand-agen-slide', {
		slidesPerView: 1,
		spaceBetween: 30,
		loop: true,
		freeMode: true,
		autoplay: {
			delay: 4000,
			},
		breakpoints: {
			'1200': {
				slidesPerView: 5,
			},
			'992': {
				slidesPerView: 4,
			},
			'768': {
				slidesPerView: 4,
			},
			'576': {
				slidesPerView: 3,
			},
			'0': {
				slidesPerView: 2,
			},
		},
	});

	////////////////////////////////////////////////////
	// 14. tp-testimonial-feedback
	var slider = new Swiper('.tp-testimonial-feedback', {
		slidesPerView: 1,
		spaceBetween: 30,
		loop: true,
		autoplay: {
			delay: 4000,
			},
		breakpoints: {
			'1200': {
				slidesPerView: 2,
			},
			'768': {
				slidesPerView: 1,
			},
		},
	});

	////////////////////////////////////////////////////
	// 15. tp-protfolio-sliders
	var swiper = new Swiper(".tp-protfolio-sliders", {
		slidesPerView: 1,
		spaceBetween: 30,
		loop: true,
		breakpoints: {
			'1200': {
				slidesPerView: 4,
			},
			'991': {
				slidesPerView: 3,
			},
			'768': {
				slidesPerView: 2,
			},
			'0': {
				slidesPerView: 2,
			},
		},
		navigation: {
			nextEl: ".tp-protfolio-agen-next",
			prevEl: ".tp-protfolio-agen-prev",
		},
	  });

	////////////////////////////////////////////////////
	// 16. tp-protfolio-sliders-2
	  var swiper = new Swiper(".tp-protfolio-sliders-2", {
		slidesPerView: 1,
		spaceBetween: 30,
		loop: true,
		breakpoints: {
			'1200': {
				slidesPerView: 3,
			},
			'991': {
				slidesPerView: 3,
			},
			'768': {
				slidesPerView: 3,
			},
			'0': {
				slidesPerView: 2,
			},
		},
		pagination: {
			el: ".tp-protfolio-pagination",
			clickable: true,
		  },
	  });

	  var swiper = new Swiper(".tp-protfolio-sliders-3", {
		slidesPerView: 1,
		spaceBetween: 30,
		loop: true,
		breakpoints: {
			'1200': {
				slidesPerView: 4,
			},
			'991': {
				slidesPerView: 3,
			},
			'768': {
				slidesPerView: 2,
			},
			'576': {
				slidesPerView: 1,
			},
			'0': {
				slidesPerView: 1,
			},
		},
	  });

	////////////////////////////////////////////////////
	// 17. tp-testimonial-agen-slider
	var swiper = new Swiper(".tp-testimonial-agen-slider", {
	slidesPerView: 1,
	spaceBetween: 30,
	effect: "fade",
	loop: true,
	navigation: {
		nextEl: ".tp-testimonial-agen-next",
		prevEl: ".tp-testimonial-agen-prev",
	},
	});

	////////////////////////////////////////////////////
	// 18. mobile-menu-activation
	$(".tp-canvas-open").on("click", function () {
		$(".tp-canvas-menu-wrapper,.tp-canvas-overlay").addClass("active");
	});

	$(".tp-canvas-close,.tp-canvas-overlay").on("click", function () {
		$(".tp-canvas-menu-wrapper,.tp-canvas-overlay").removeClass("active");
	});

	////////////////////////////////////////////////////
	// 19. Off Canvas Menu
	var $offcanvasNav = $(".tp-canvas-main-menu"),
		$offcanvasNavSubMenu = $offcanvasNav.find(".sub-menu");
	$offcanvasNavSubMenu
		.parent()
		.prepend(
		'<span class="menu-expand"><i class="fa fa-angle-down"></i></span>'
		);
	$offcanvasNavSubMenu.slideUp();
	$offcanvasNav.on("click", "li a, li .menu-expand", function (e) {
		var $this = $(this);
		if (
		$this
			.parent()
			.attr("class")
			.match(/\b(tp-canvas-menu-children|has-children|has-sub-menu)\b/) &&
		($this.attr("href") === "#" || $this.hasClass("menu-expand"))
		) {
		e.preventDefault();
		if ($this.siblings("ul:visible").length) {
			$this.siblings("ul").slideUp("slow");
		} else {
			$this.closest("li").siblings("li").find("ul:visible").slideUp("slow");
			$this.siblings("ul").slideDown("slow");
		}
		}
		if (
		$this.is("a") ||
		$this.is("span") ||
		$this.attr("clas").match(/\b(menu-expand)\b/)
		) {
		$this.parent().toggleClass("menu-open");
		} else if (
		$this.is("li") &&
		$this.attr("class").match(/\b('tp-canvas-menu-children')\b/)
		) {
		$this.toggleClass("menu-open");
		}
	});

	////////////////////////////////////////////////////
	// 20. range-slider
	$( function() {
		$( "#slider-range-min" ).slider({
		range: "min",
		value: 21325,
		min: 1,
		max: 51325,
		slide: function( event, ui ) {
			$( "#amount" ).val( "$" + ui.value );
		}
		});
		$( "#amount" ).val( "$" + $( "#slider-range-min" ).slider( "value" ) );
	} );

	////////////////////////////////////////////////////
	// 21.slider-range-min2
	$( function() {
		$( "#slider-range-min2" ).slider({
		range: "min",
		value: 21325,
		min: 1,
		max: 51325,
		slide: function( event, ui ) {
			$( "#amount2" ).val( "$" + ui.value );
		}
		});
		$( "#amount2" ).val( "$" + $( "#slider-range-min2" ).slider( "value" ) );
	} );

	////////////////////////////////////////////////////
	// 22. slider-range-min3
	$( function() {
		$( "#slider-range-min3" ).slider({
		range: "min",
		value: 21325,
		min: 1,
		max: 51325,
		slide: function( event, ui ) {
			$( "#amount3" ).val( "$" + ui.value );
		}
		});
		$( "#amount3" ).val( "$" + $( "#slider-range-min3" ).slider( "value" ) );
	} );

	////////////////////////////////////////////////////
	// 23. slider-range-min4
	$( function() {
		$( "#slider-range-min4" ).slider({
		range: "min",
		value: 21325,
		min: 1,
		max: 51325,
		slide: function( event, ui ) {
			$( "#amount4" ).val( "$" + ui.value );
		}
		});
		$( "#amount4" ).val( "$" + $( "#slider-range-min4" ).slider( "value" ) );
	} );

	////////////////////////////////////////////////////
	// 24. slider-range-min5
	$("#slider-range2").slider({
			range: true,
			min: 0,
			max: 500,
			values: [75, 300],
			slide: function (event, ui) {
				$("#amount5").val("$" + ui.values[0] + " - $" + ui.values[1]);
			}
			});
		$("#amount5").val("$" + $("#slider-range2").slider("values", 0) +
				" - $" + $("#slider-range2").slider("values", 1));


	////////////////////////////////////////////////////
	// 25. Counter Js
	var $CounterUp = $(".counter");
	if ($CounterUp.length > 0) {
		$(".counter").counterUp({
		delay: 10,
		time: 2000,
		});
	}

	var $CounterUp = $(".counter2");
	if ($CounterUp.length > 0) {
		$(".counter2").counterUp({
		delay: 10,
		time: 2000,
		});
	}

	var $CounterUp = $(".footer-counter");
	if ($CounterUp.length > 0) {
		$(".footer-counter").counterUp({
		delay: 10,
		time: 2000,
		});
	}

	////////////////////////////////////////////////////
	// 26. password-visable
	$('#click').on('click', function (){
		$(this).toggleClass('open');
		var x = document.getElementById("myInput");
			if (x.type === "password") {
			   x.type = "text";
			} else {
			   x.type = "password";
			}
	});


	if ($('#myInput').length > 0) {
		function myFunction() {
			var x = document.getElementById("myInput");
			if (x.type === "password") {
			   x.type = "text";
			} else {
			   x.type = "password";
			}
		}
	}


	$('#click2').on('click', function (){
		$(this).toggleClass('open');
		var x = document.getElementById("myInput2");
			if (x.type === "password") {
			   x.type = "text";
			} else {
			   x.type = "password";
			}
	});


	if ($('#myInput2').length > 0) {
		function myFunction() {
			var x = document.getElementById("myInput2");
			if (x.type === "password") {
			   x.type = "text";
			} else {
			   x.type = "password";
			}
		}
	}

	////////////////////////////////////////////////////
	// 27. increment-dreckment-btn
	$('.tp-shop-cart-minus').on('click', function () {
		var $input = $(this).parent().find('input');
		var count = parseInt($input.val()) - 1;
		count = count < 1 ? 1 : count;
		$input.val(count);
		$input.change();
		return false;
	});

	$('.tp-shop-cart-plus').on('click', function () {
		var $input = $(this).parent().find('input');
		$input.val(parseInt($input.val()) + 1);
		$input.change();
		return false;
	});

	////////////////////////////////////////////////////
	// 28. magnific-Popup-active
	$('.tp-shop-product').each(function() {
		$(this).magnificPopup({
			delegate: 'a',
			type: 'image',
			gallery: {
			enabled:true
			}
		});
	});

	/* magnificPopup img view */
	$('.popup-image').magnificPopup({
		type: 'image',
		gallery: {
			enabled: true
		},
		mainClass: 'mfp-with-zoom',
		removalDelay: 500,
	});


	////////////////////////////////////////////////////
	// 29. pricing-table
	function tabtable_active() {

		var e = document.getElementById("filt-monthly"),
			d = document.getElementById("filt-yearly"),
			t = document.getElementById("switcher"),
			m = document.getElementById("monthly"),
			y = document.getElementById("hourly");

		e.addEventListener("click", function () {
			t.checked = false;
			e.classList.add("tp-pricing-active");
			d.classList.remove("tp-pricing-active");
			m.classList.remove("hide");
			y.classList.add("hide");
		});

		d.addEventListener("click", function () {
			t.checked = true;
			d.classList.add("tp-pricing-active");
			e.classList.remove("tp-pricing-active");
			m.classList.add("hide");
			y.classList.remove("hide");
		});

		t.addEventListener("click", function () {
			d.classList.toggle("tp-pricing-active");
			e.classList.toggle("tp-pricing-active");
			m.classList.toggle("hide");
			y.classList.toggle("hide");
		})
	}

	if ($('#filt-monthly').length > 0) { 
		tabtable_active();
	}

	////////////////////////////////////////////////////
	// 30. back-to-top
	var btn = $('#back_to_top');
	var btn_wrapper = $('.back-to-top-wrapper');

	windowOn.scroll(function() {
	if (windowOn.scrollTop() > 300) {
		btn_wrapper.addClass('back-to-top-btn-show');
	} else {
		btn_wrapper.removeClass('back-to-top-btn-show');
	}
	});

	btn.on('click', function(e) {
		e.preventDefault();
		$('html, body').animate({scrollTop:0}, '300');
	});

	if ($('.tp-header-height').length > 0) {
		var headerHeight = document.querySelector(".tp-header-height");      
		var setHeaderHeight = headerHeight.offsetHeight;	
		$(".tp-header-height").each(function () {
			$(this).css({
				'height' : $(this).height()
			});
		});
	}
	////////////////////////////////////////////////////
	// 31. scrrol up
	windowOn.on('scroll', function () {
		var scroll = $(window).scrollTop();
		if (scroll < 100) {
			$("#tp-header-sticky").removeClass("tp-header-sticky");
		} else {
			$("#tp-header-sticky").addClass("tp-header-sticky");
		}
	});

	////////////////////////////////////////////////////
	// 32. search-toggle
	$(".search-click").on("click", function () {
		$(".tp-search-form-toggle,.tp-search-body-overlay").addClass("active");
	});

	$(".tp-search-close,.tp-search-body-overlay").on("click", function () {
		$(".tp-search-form-toggle,.tp-search-body-overlay").removeClass("active");
	});
  	var windowOn = $(window)

	////////////////////////////////////////////////////
	// 33. preloader
	windowOn.on('load',function () {
		$('#loading').fadeOut(500);
	});
	document.onreadystatechange = function() {
		if (document.readyState === "complete") {
			$("#tp-preloader-panel_left").addClass("tp-preloader-panel_left");
			$("#tp-preloader-panel_right").addClass("tp-preloader-panel_right");
			$("#loader").addClass("tp-preloader-loaded-circle");
			$("#tp-preloader-loader-img").addClass("tp-preloader-loaded-img");
			$("#preloader").addClass("tp-preloader-loaded-img");
		}
	}

	if($('.tp-main-menu-content').length && $('.tp-main-menu-mobile').length){
		let navContent = document.querySelector(".tp-main-menu-content").outerHTML;
		let mobileNavContainer = document.querySelector(".tp-main-menu-mobile");
		mobileNavContainer.innerHTML = navContent;


		let arrow = $(".tp-main-menu-mobile .has-dropdown > a");

		arrow.each(function () {
			let self = $(this);
			let arrowBtn = document.createElement("BUTTON");
			arrowBtn.classList.add("dropdown-toggle-btn");
			arrowBtn.innerHTML = "<i class='fal fa-angle-right'></i>";

			self.append(function () {
			return arrowBtn;
			});

			self.find("button").on("click", function (e) {
			e.preventDefault();
			let self = $(this);
			self.toggleClass("dropdown-opened");
			self.parent().toggleClass("expanded");
			self.parent().parent().addClass("dropdown-opened").siblings().removeClass("dropdown-opened");
			self.parent().parent().children(".tp-submenu").slideToggle();
			});

		});
	}

	////////////////////////////////////////////
	// 34. Ecommerce js
	function tp_ecommerce() {
		$('.tp-cart-minus').on('click', function () {
			var $input = $(this).parent().find('input');
			var count = parseInt($input.val()) - 1;
			count = count < 1 ? 1 : count;
			$input.val(count);
			$input.change();
			return false;
		});

		$('.tp-cart-plus').on('click', function () {
			var $input = $(this).parent().find('input');
			$input.val(parseInt($input.val()) + 1);
			$input.change();
			return false;
		});



		$('.cart-minus').on('click', function () {
			var $input = $(this).parent().find('input');
			var count = parseInt($input.val()) - 1;
			count = count < 1 ? 1 : count;
			$input.val(count);
			$input.change();
			return false;
		});

		$('.cart-plus').on('click', function () {
			var $input = $(this).parent().find('input');
			$input.val(parseInt($input.val()) + 1);
			$input.change();
			return false;
		});


		$('#showlogin').on('click', function () {
			$('#checkout-login').slideToggle(900);
		});


		$('#showcoupon').on('click', function () {
			$('#checkout_coupon').slideToggle(900);
		});


		$('#cbox').on('click', function () {
			$('#cbox_info').slideToggle(900);
		});

		$('#ship-box').on('click', function () {
			$('#ship-box-info').slideToggle(1000);
		});
	}
	tp_ecommerce();


	////////////////////////////////////////////////////
	// 35. Nice Select Js
	$('select').niceSelect();
	$('.tp-header-search-category select').niceSelect();

	////////////////////////////////////////////////////
	// 36. Jquery Appear raidal
	if (typeof ($.fn.knob) != 'undefined') {
		$('.knob').each(function () {
		var $this = $(this),
		knobVal = $this.attr('data-rel');

		$this.knob({
		'draw': function () {
			$(this.i).val(this.cv + '%')
		}
		});

		$this.appear(function () {
		$({
			value: 0
		}).animate({
			value: knobVal
		}, {
			duration: 2000,
			easing: 'swing',
			step: function () {
			$this.val(Math.ceil(this.value)).trigger('change');
			}
		});
		}, {
		accX: 0,
		accY: -150,
		});
	});
	}


})(jQuery);