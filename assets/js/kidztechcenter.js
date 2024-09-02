// JavaScript Document
$('.pb-MainSlider').owlCarousel({
	lazyLoad: true,
	mouseDrag:false,
	items:1,
	loop:true,
	autoplay:true,
	autoplayTimeout:10000,
	autoplayHoverPause:true,
	animateIn: 'fadeIn',
	animateOut: 'fadeOut',
	dots:false,
});

$('.ktc-CourseList').owlCarousel({
	nav:true,
	dots:false,
	margin:15,
	loop:true,
	autoplay:true,
	autoplayTimeout:12000,
	autoplayHoverPause:true,
	responsiveClass:true,
	responsive:{
		0 : {
			items:1,
			nav:false,
		},
		480 : {
			items:2,
			nav:false,
		},
		768 : {
			items : 3
		}
	},
	navText : ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
});

$('.account_dash #sidebarCollapse').on('click', function () {
	$('.account_dash #sidebar').toggleClass('active');
});

$('#kid .input-date').datepicker({
  todayBtn: "linked",
  keyboardNavigation: false,
  forceParse: false,
  calendarWeeks: true,
  autoclose: true,
  format: 'yyyy-mm-dd',
});
