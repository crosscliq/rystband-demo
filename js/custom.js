/******************************************************************
*******************************************************************

Template Name: corsica
Theme URI: http://themeforest.ninetofive.me/corsica/
Description: corsica | App landing page
Author: ninetofive
Author URI: http://www.ninetofive.me
Version: 1.0
							
Designed & Handcrafted by Zan from ninetofive.me
									
*******************************************************************
******************************************************************/

$(document).ready(function() { 

	// fade logo

            var scroll_pos = 0;
            $(document).scroll(function() { 
                scroll_pos = $(this).scrollTop();
               console.log(scroll_pos + ' height: ' + ($(window).scrollTop() + $(window).height()) );
                    $(".logo2").css('opacity', scroll_pos/$(window).height()/2);
                
            });

	// Strict
	"use strict";

	//Animated scrolling		   
	$('ul.menu a').click(function() {
		if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
			var $target = $(this.hash);
			$target = $target.length && $target || $('[id=' + this.hash.slice(1) +']');
			if ($target.length) {
				$('ul.menu li a').removeClass('active');
				$(this).addClass('active');
				var targetOffset = $target.offset().top;
				$('html,body').animate({scrollTop: targetOffset}, 1000);
				return false;
			}
		}
	});

	// Scroll Blur
	$(document).on('scroll', function(){
		if ($(document).scrollTop() > 100) {
			$('body').addClass('blur');
		}else{
			$('body').removeClass('blur');
		};
	});

	// Menu
	$('.menu-wrapper').on("click", function() {
		$('.menu').toggleClass('open');
		$('.menu-wrapper h4').toggle();
		$('.menu-wrapper').toggleClass('open');
		$('.menu-top').toggleClass('menu-top-click');
		$('.menu-middle').toggleClass('menu-middle-click');
		$('.menu-bottom').toggleClass('menu-bottom-click');
	});

	// Text Rotator
	$('.rotate').each(function(){
		var index = 0;
		var el = $(this);
		var text = $(this).html().split(",");
		el.html(text[0]);
		setInterval(function() {
			el.animate({
				textShadowBlur:20,
				opacity: 0
				}, 500 , function() {
				index = $.inArray(el.html(), text)
				if((index + 1) == text.length) index = -1
				el.text(text[index + 1]).animate({
					textShadowBlur:0,
					opacity: 1
				}, 500 );
			});
		}, 2500);
	});

	// Slider
	var s_items = $("ul.slider-items").children();
	var s_length = s_items.length-1;
	var s_current = 0;
	$(s_items).each(function(index){
		// Hide All Except First
		if (index != 0) {$(this).hide()};
		// Set Indexes
		$(this).attr('data-id', index);
	})
	$('div.slider.arrow').on("click", function() {
		if ($(this).hasClass('next')) {
			if (s_current < s_length || s_current == 0) {
				$(s_items[s_current]).hide();
				$(s_items[s_current+1]).fadeIn('slow');
				s_current++;
			}else{
				$(s_items[s_current]).hide();
				$(s_items[0]).fadeIn('slow');
				s_current = 0;
			};
		}else{
			if (s_current == 0) {
				$(s_items[s_current]).hide();
				$(s_items[s_length]).fadeIn('slow');
				s_current = s_length;
			}else{
				$(s_items[s_current]).hide();
				$(s_items[s_current-1]).fadeIn('slow');
				s_current--;
			};
		};
	});

	// Mockup Slider
	var m_items = $("ul.mockup-items").children();
	var m_length = m_items.length-1;
	var m_current = 0;
	$(m_items).each(function(index){
		// Hide All Except First
		if (index != 0) {$(this).hide()};
		// Set Indexes
		$(this).attr('data-id', index);
	})
	$('div.slider.mockup.arrow').on("click", function() {
		if ($(this).hasClass('next')) {
			if (m_current < m_length || m_current == 0) {
				$(m_items[m_current]).slideUp();
				setTimeout(function(){
					$(m_items[m_current]).slideDown();
				}, 500);
				m_current++;
			}else{
				$(m_items[m_current]).slideUp();
				setTimeout(function(){
					$(m_items[0]).slideDown();
				}, 500);
				m_current = 0;
			};
		}else{
			if (m_current == 0) {
				$(m_items[m_current]).slideUp();
				setTimeout(function(){
					$(m_items[m_length]).slideDown();
				}, 500);
				m_current = m_length;
			}else{
				$(m_items[m_current]).slideUp();
				setTimeout(function(){
					$(m_items[m_current]).slideDown();
				}, 500);
				m_current--;
			};
		};
	});

	// Signup Fade p
	$('a.signup-more').on("click", function() {
		var btn_value = $(this).data('value');
		$(this).data('value', $(this).text());
		$(this).text(btn_value);
		$('p.signup-more').toggleClass('visible');
	});
	
	// Input
	var placeholder = $("input.signup").val();    
	$("input.signup").on("focusin", function() {
		$(this).removeAttr("value");
	});
	$("input.signup").on("focusout", function() {
		$(this).attr("value",placeholder);
	});

	// Signup Form Submit
	$('a.email').on("click", function() {
		var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		var email = $("input.signup").val();
		var signup = regex.test(email);
		if (signup == true) {
			$.ajax({
				url: '/',
				data: { value: email },
				type: 'POST',
				success:function(data){		
					$('a.email').html('thanks!');
					$('a.email').removeClass('email');
				}
			});
		};
	});

	// Features
	$(".accordion").accordion();
	$(".tabs").tabs();
	$(".progressbar").progressbar({
		value: Math.floor(Math.random() * 100)
	});
});