/*! Luxeritas WordPress Theme - free/libre wordpress platform
 *
 * @copyright Copyright (C) 2015 Thought is free.
 * @link https://thk.kanzae.net/
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPL v2 or later
 * @author LunaNuko
 */

/*
------------------------------------------------------------------
 カルーセルスライダーを表示する
------------------------------------------------------------------ */
function thk_swiper( script, css, widget_id, idx, item_max, show_max, height, heightpx, width, slide_bg, nav, nxt_prv, nav_clr, efect, center, darkness, playtime ) {
	if( document.getElementById('thk-swiper-css') === null ){
		var n = document.createElement('link')
		n.async = true;
		n.defer = true;
		n.rel = 'stylesheet';
		n.id  = 'thk-swiper-css';
		n.href = css;

		if( document.getElementsByTagName('head')[0] !== null ) {
			document.getElementsByTagName('head')[0].appendChild( n );
		}
	}

	var cflow = 'slide'
	,   option_styles = '';

	if( slide_bg !== '' ) {
		option_styles += '\
#' + widget_id + ' .swiper-slide {\
background: ' + slide_bg + ';\
}';
	}

	if( width !== 'auto' ) {
		option_styles += '\
#' + widget_id + ' a.swiper-slide img {\
width: 100%;\
}';
	}
	if( height === 'full' ) {
		option_styles += '\
#' + widget_id + ' a.swiper-slide img {\
height: 100%;\
}';
	}

	if( nxt_prv === 'hover' ) {
		option_styles += '\
#' + widget_id + ' .swiper-button-prev,\
#' + widget_id + ' .swiper-button-next {\
	-webkit-transition: opacity ease 0.5s;\
	-moz-transition: opacity ease 0.5s;\
	-o-transition: opacity ease 0.5s;\
	transition: opacity ease 0.5s;\
	opacity: 0;\
}\
#' + widget_id + ' .swiper-container:hover > .swiper-button-prev,\
#' + widget_id + ' .swiper-container:hover > .swiper-button-next {\
	opacity: 1.0;\
}';
	}

	if( darkness ) {
		option_styles += '\
#' + widget_id + ' .swiper-slide::before {\
content: "";\
position: absolute;\
top: 0;\
bottom: 0;\
left: 0;\
right: 0;\
-webkit-transition: all 0.4s linear;\
-moz-transition: all 0.4s linear;\
transition: all 0.4s linear;\
}\
#' + widget_id + ' .swiper-slide::before {\
background: rgba( 0, 0, 0, 0.4 );\
}';
	}

	if( efect === 'highlight' ) {
		option_styles += '\
#' + widget_id + ' .swiper-slide {\
transform: scale3d( 0.95, 0.95, 0.95 );\
}\
#' + widget_id + ' .swiper-slide::before {\
-webkit-transition: all 0.5s linear;\
-moz-transition: all 0.5s linear;\
transition: all 0.5s linear;\
}\
#' + widget_id + ' .swiper-slide-active,\
#' + widget_id + ' .swiper-title,\
#' + widget_id + ' .swiper-slide:hover {\
-webkit-transition: scale3d( 1.00, 1.00, 1.0 );\
-moz-transition: scale3d( 1.00, 1.00, 1.0 );\
transform: scale3d( 1.00, 1.00, 1.0 );\
}';
	}
	else if( efect === 'flip' ) {
		option_styles += '\
#' + widget_id + ' .swiper-slide:hover {\
-webkit-transition: transform 1s cubic-bezier(0.500, 0, 0.250, 1);\
-webkit-transition: transform 1s cubic-bezier(0.500, -0.500, 0.250, 1.500);\
-moz-transition: transform 1s cubic-bezier(0.500, -0.500, 0.250, 1.500);\
transition: transform 1s cubic-bezier(0.500, -0.500, 0.250, 1.500);\
-webkit-transform: rotateY(361deg);\
-moz-transform: rotateY(361deg);\
transform: rotateY(361deg);\
}';
	}
	else if( efect === 'coverflow' ) {
		cflow = 'coverflow'
	}

	option_styles += '\
#' + widget_id + ' .swiper-pagination-fraction,\
#' + widget_id + ' .swiper-button-prev::before,\
#' + widget_id + ' .swiper-button-next::before {\
	color: ' + nav_clr + ';\
}\
#' + widget_id + ' .swiper-pagination-bullet-active,\
#' + widget_id + ' .swiper-pagination-progress .swiper-pagination-progressbar {\
	background: ' + nav_clr + ';\
}\
#' + widget_id + ' .swiper-slide:hover::before{\
background: rgba( 0, 0, 0, 0.2 );\
}\
#' + widget_id + ' .swiper-slide-active:hover::before,\
#' + widget_id + ' .swiper-slide-active::before {\
background:none;\
}';

	if( option_styles !== '' ) {
		var s = document.createElement('style');
		s.appendChild( document.createTextNode( option_styles.replace(/\t/g, '') ) );
		document.getElementsByTagName('head')[0].appendChild( s );
	}

	if( playtime != 0 ) {
		playtime = { delay: playtime };
	} else {
		playtime = false;
	}

	function getScript( source, callback ) {
		var s = document.createElement('script');
		var p = document.getElementsByTagName('script')[0];
		s.async = 1;

		s.onload = s.onreadystatechange = function( _, isAbort ) {
			if( isAbort || !s.readyState || /loaded|complete/.test( s.readyState ) ) {
				s.onload = s.onreadystatechange = null;
				s = undefined;

				if( !isAbort ) { if( callback ) callback(); }
			}
		};

		s.src = source;
		p.parentNode.insertBefore( s, p );
	}

	getScript( script, function(){
		var s480 = 2
		,   s640 = 3
		,   s768 = 4
		,   s992 = 5
		,   s1199= 7
		,   central = center !== 'order' ? true : false;

		if( s480 > show_max ) s480 = show_max;
		if( s640 > show_max ) s640 = show_max;
		if( s768 > show_max ) s768 = show_max;
		if( s992 > show_max ) s992 = show_max;
		if( s1199 > show_max ) s1199 = show_max;

		var elm = document.querySelector('#' + widget_id + ' .swiper-container'),
		c = elm.style;

		if( nav === 'none' ) {
			c.paddingBottom = '0';
			nav = 'bullets';
		}

		c.maxHeight = 'none';
		c.visibility = 'visible';

		var swiper = new Swiper('#' + widget_id + ' .swiper-container', {
			loop: true,
			parallax: true,
			freeMode: true,
			freeModeSticky: true,
			preloadImages: false,
			updateOnImagesReady: false,
			lazyLoading: true,
			//lazyLoadingInPrevNext: true,
			autoplay: playtime,
			initialSlide: idx,
			centeredSlides: central,
			slidesPerView: show_max,
			loopedSlides: item_max,
			effect: cflow,
			//coverflow: { slideShadows : false },
			paginationClickable: true,
			spaceBetween: 10,
			pagination: { el: '#' + widget_id + ' .swiper-pagination', type: nav, },
			navigation: { nextEl: '#' + widget_id + ' .swiper-button-next', prevEl: '#' + widget_id + ' .swiper-button-prev', },
			//nextButton: '#' + widget_id + ' .swiper-button-next',
			//prevButton: '#' + widget_id + ' .swiper-button-prev',
			//paginationType: nav,
			breakpoints: {
				480: {	// when window width is <= 480px
					slidesPerView: s480,
				},
				640: {	// when window width is <= 640px
					slidesPerView: s640,
				},
				768: {	// when window width is <= 768px
					slidesPerView: s768,
				},
				992: {	// when window width is <= 992px
					slidesPerView: s992,
				},
				1199: {	// when window width is <= 1199px
					slidesPerView: s1199,
				},
			},
		});
	});

	if( height === 'manual' ) {
		var elms, c;

		elms = document.querySelectorAll('#' + widget_id + ' .swiper-slide');
		Object.keys( elms ).forEach( function( index ) {
			c = this[index].style;
			c.height = heightpx + 'px';
		}, elms );

		elms = document.querySelectorAll('#' + widget_id + ' .swiper-title');
		Object.keys( elms ).forEach( function( index ) {
			c = this[index].style;
			c.bottom = '0';
		}, elms );
	}
}
