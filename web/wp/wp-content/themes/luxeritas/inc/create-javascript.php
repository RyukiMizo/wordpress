<?php
/**
 * Luxeritas WordPress Theme - free/libre wordpress platform
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * @copyright Copyright (C) 2015 Thought is free.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPL v2 or later
 * @author LunaNuko
 * @link https://thk.kanzae.net/
 * @translators rakeem( http://rakeem.jp/ )
 */

class create_Javascript {
	private $_tdel   = null;
	private $_js_dir = null;
	private $_depend = array();

	public function __construct() {
		$this->_tdel   = pdel( get_template_directory_uri() );
		$this->_js_dir = TPATH . DSEP . 'js' . DSEP;

		// Javascript の依存チェック用配列
		$this->_depend = array(
			'stickykit'=> $this->_js_dir . 'jquery.sticky-kit.min.js',
			'sscroll'  => $this->_js_dir . 'smoothScroll.min.js',
			'autosize' => $this->_js_dir . 'autosize.min.js',
		);
		foreach( $this->_depend as $key => $val ) {
			if( file_exists( $val ) === false ) unset( $this->_depend[$key] );
		}
	}

	/*
	------------------------------------
	 非同期 CSS の読み込み
	------------------------------------ */
	public function create_css_load_script( $url, $media = null ) {
		$ret = '';

		if( file_exists( TPATH . DSEP . 'style.async.min.css' ) === true && filesize( TPATH . DSEP . 'style.async.min.css' ) <= 0 ) {
			return $ret;
		}

		$ret .= <<< SCRIPT
(function(d){
	var n = d.createElement('link');
	n.async = true;
	n.defer = true;

SCRIPT;
		if( $media !== null ) $ret .= "n.media = " . $media . "';";

		$ret .= <<< SCRIPT
	n.rel  = 'stylesheet';
	n.href = '{$url}?v={$_SERVER['REQUEST_TIME']}';
	if( d.getElementsByTagName('head')[0] !== null ) {
		d.getElementsByTagName('head')[0].appendChild( n );
	}
})(document);

SCRIPT;
		return $ret;
	}

	/*
	------------------------------------
	 いろいろ
	------------------------------------ */
	public function create_luxe_various_script( $is_preview = false ) {
		global $luxe, $awesome;

		require_once( INC . 'colors.php' );
		thk_default_set();

		$ret = '';
		$broken = false;
		$home = THK_HOME_URL;
		$side_1_width = isset( $luxe['side_1_width'] ) ? $luxe['side_1_width'] : 366;

		$ca = new carray();

		$imp = $ca->thk_hex_imp_style();
		$imp_close = $ca->thk_hex_imp_style_close();

		$fa_plus_square  = '\f0fe';
		$fa_minus_square = '\f146';

		if( $awesome === 4 ) {
			$fa_plus_square  = '\f196';
			$fa_minus_square = '\f147';
		}

		if(
			stripos( $imp, '!;' ) === false ||
			stripos( $imp_close, '!' ) === false
		) {
			$broken = true;
		}
		else {
			$imp = str_replace( '!;', $imp_close, $imp );
		}

		$conf = new defConfig();
		$colors_class = new thk_colors();

		$defaults = $conf->default_variables();
		$default_colors = $conf->over_all_default_colors();
		unset( $conf );

		$bg_color = isset( $luxe['body_bg_color'] ) ? $luxe['body_bg_color'] : $default_colors[$luxe['overall_image']]['contbg'];
		$inverse = $colors_class->get_text_color_matches_background( $bg_color );

		$rgb = $colors_class->colorcode_2_rgb( $inverse );

		$brap_rgba = 'background: rgba(' . $rgb['r'] . ',' . $rgb['g'] . ',' . $rgb['b'] . ', .5 )';

		$ret .= <<< SCRIPT
jQuery(document).ready(function($) {
(function(w,d) {
	// Show an element
	var show = function( e ) {
		if( e !== null && typeof e !== 'undefined' ) e.style.display = 'block';
	};
	// Hide an element
	var hide = function( e ) {
		if( e !== null && typeof e !== 'undefined' ) e.style.display = 'none';
	};

	// スクロールイベント登録
	var listen_scroll = function( e ) {
		try {
			w.addEventListener( 'scroll', e, false );
		} catch (e) {
			w.attachEvent( 'onscroll', e );
		}
	};
	// スクロールイベント解除
	var detach_scroll = function( e ) {
		try {
			w.removeEventListener( 'scroll', e, false );
		} catch (e) {
			w.detachEvent( 'onscroll', e );
		}
	}

try {  /* page.top */
	var tbn = $("#page-top")		// トップに戻るボタン
	,   scleve = ("scroll", function() {	// スクロール監視
		var b = w.pageYOffset;

		//スクロールが500に達したらボタン表示
		if (b > 500) {
			tbn.fadeIn()
		} else {
			tbn.fadeOut()
		}
		// モバイル用グローバルナビの監視
		if (d.getElementById("ovlay") !== null) {
			var a = d.documentElement
			,   s = d.querySelector("#layer #nav");
			if (s !== null) {
				a = s
			} else {
				var f = d.getElementById("sform")
				,   g = d.getElementById("side");
				if (f !== null && f.style.display === "block") {
					return
				} else {
					if (g !== null) {
						a = g
					}
				}
			}
			var f = $("#layer").get(0).offsetTop + a.clientHeight,
				c = $("#layer").get(0).offsetTop - d.documentElement.clientHeight;
			if (b > f || b < c) {
				remove_ovlay()
			}
		}
	});
	listen_scroll(scleve);

	//トップに戻るでトップに戻る
	tbn.click(function() {
		$("html, body").animate({
			scrollTop: 0
		}, 500);
		return false
	})
} catch (e) {
	console.error("page.top.error: " + e.message)
};

	/* 以下 グローバルナビ */

	function remove_ovlay() {
		var a = [
			'sidebar',
			'sform',
			'ovlay',
			'ovlay-style'
		];

		a.forEach( function( val ) {
			var f = d.getElementById(val);
			if( f !== null ) {
				if( val === 'sidebar' || val === 'sform' ) {
					f.removeAttribute('style');
				} else {
					//d.getElementById(val).remove();
					$('#' + val).remove();
				}
			}
		}); d.body.removeAttribute('style');
	}

SCRIPT;

		if( isset( $luxe['global_navi_visible'] ) ) {
				$ret .= <<< SCRIPT
try{ /* global.nav */
	$('#nav li').hover( function() {
		var t = $('>ul', this);
		t.css( 'display', 'table');
		t.css( 'width', t.outerWidth() + 'px');
		t.stop(false,true).css( 'display', 'none');	// hide() だと次の toggle() がアニメにならない。なんで？
		//t.stop().slideDown(300);
		t.stop(true,true).toggle(300);
	}, function() {
		$('>ul', this).stop(true,true).slideUp(250);
		//$('>ul', this).stop().toggle(300);
	});
} catch(e) { console.error( 'global.nav.error: ' + e.message ); }

try{ /* mibile.nav */

SCRIPT;

			if( $luxe['global_navi_mobile_type'] !== 'luxury' ) {
				$ret .= <<< SCRIPT

	// モバイルメニュー (メニューオンリー版)
	var nav = $('#nav')
	,   men = $('.menu ul')
	,   mob = $('.mobile-nav')
	,   navid = d.getElementById('nav');

	mob.click(function() {
		var scltop = 0;

		if( d.getElementById('bwrap') !== null ) {
			remove_ovlay();
		} scltop = w.pageYOffset;

		/*
		$('body').append(
			'<div id=\"ovlay\">' +
			'<div id=\"bwrap\"></div>' +
			'<div id=\"close\"><i class=\"fa fas fa-times\"></i></div>' +
			'<div id=\"layer\" style=\"\"><div id=\"nav\">' + ( navid !== null ? navid.innerHTML : '' ) + '</div>' +
			'</div>' );
		*/
		var l = d.createElement('div');
		l.innerHTML =
			'<div id=\"ovlay\">' +
			'<div id=\"bwrap\"></div>' +
			'<div id=\"close\"><i class=\"fa fas fa-times\"></i></div>' +
			'<div id=\"layer\" style=\"\"><div id=\"nav\">' + ( navid !== null ? navid.innerHTML : '' ) + '</div>' +
			'</div>';
		;
		d.body.appendChild( l );

		var s = d.createElement('style');
		s.id = 'ovlay-style';
		s.innerText =
			'#bwrap{height:' + d.body.clientHeight + 'px;{$brap_rgba};}' +
			'#layer{top:' + scltop + 'px;}'

SCRIPT;
				if( $luxe['global_navi_open_close'] === 'individual' ) {
					$ret .= <<< SCRIPT
		+
		'#layer li[class*=\"children\"] li a::before{content:\"-\";}' +
		'#layer li[class*=\"children\"] a::before,' +
		'#layer li li[class*=\"children\"] > a::before{content:\"\\{$fa_plus_square}\";font-weight:400}' +
		'#layer li li[class*=\"children\"] li a::before{content:\"\\\\0b7\";}'

SCRIPT;
				}
				else {
					$ret .= <<< SCRIPT
		+
		'#layer li[class*=\"children\"] a{padding-left:20px;}' +
		'#layer li[class*=\"children\"] ul{display:block}' +
		'#layer li ul > li[class*=\"children\"] > a{padding-left:35px;}'

SCRIPT;
				}

				$ret .= <<< SCRIPT
		;
		d.getElementsByTagName('head')[0].appendChild( s );

		//$('#layer ul').show();
		show( d.querySelector('#layer ul') );
		//$('#layer .mobile-nav').hide();
		hide( d.querySelector('#layer .mobile-nav') );

SCRIPT;
				if( $luxe['global_navi_open_close'] === 'individual' ) {
					$ret .= <<< SCRIPT

		//$('#layer ul ul').hide();
		hide( d.querySelector('#layer ul ul') );
		$('#layer ul li[class*=\"children\"] > a').click( function(e) {
			var tgt = $(e.target).parent('li')
			,   tga = tgt.attr('class').match(/item-[0-9]+/)
			,   tgc = tgt.children('ul');

			tgc.toggle( 400, 'linear' );

			if( d.getElementById(tga + '-minus') !== null ) {
				//d.getElementById(tga + '-minus').remove();
				$('#' + tga + '-minus').remove();
			} else {
				/*
				$('#ovlay').append(
					'<div id=\"' + tga + '-minus\"><style>' +
					'#layer li[class$=\"' + tga + '\"] > a::before,' +
					'#layer li[class*=\"' + tga + ' \"] > a::before,' +
					'#layer li li[class$=\"' + tga + '\"] > a::before,' +
					'#layer li li[class*=\"' + tga + ' \"] > a::before{content:\"\\{$fa_minus_square}\";}' +
					'</style></div>'
				);
				*/
				var l = d.createElement('div');
				l.innerHTML =
					'<div id=\"' + tga + '-minus\"><style>' +
					'#layer li[class$=\"' + tga + '\"] > a::before,' +
					'#layer li[class*=\"' + tga + ' \"] > a::before,' +
					'#layer li li[class$=\"' + tga + '\"] > a::before,' +
					'#layer li li[class*=\"' + tga + ' \"] > a::before{content:\"\\{$fa_minus_square}\";}' +
					'</style></div>'
				;
				d.getElementById('ovlay').appendChild( l );
			} e.preventDefault();
		});

SCRIPT;
				}
				$ret .= <<< SCRIPT
		$('#layer').animate( {
			'marginTop' : '0'
		}, 500 );

		$('#bwrap, #close').click( function() {
			$('#layer').animate( {
				//'marginTop' : '-' + d.documentElement.clientHeight + 'px'
				'marginTop' : '-' + d.getElementById('layer').offsetHeight + 'px'
			}, 500);

			setTimeout(function(){
				remove_ovlay();
			}, 550 );
		});

	}).css('cursor','pointer');

SCRIPT;
			}
			else {
				$ret .= <<< SCRIPT

	function no_scroll() {  // スクロール禁止
		// PC
		var sclev = 'onwheel' in d ? 'wheel' : 'onmousewheel' in d ? 'mousewheel' : 'DOMMouseScroll';
		$(window).on( sclev, function(e) {
			e.preventDefault();
		});
		// スマホ
		$(window).on( 'touchmove.noScroll', function(e) {
			e.preventDefault();
		});
	} function go_scroll() { // スクロール復活 
		// PC
		var sclev = 'onwheel' in d ? 'wheel' : 'onmousewheel' in d ? 'mousewheel' : 'DOMMouseScroll';
		$(window).off(sclev);
		// スマホ
		$(window).off('.noScroll');
	}

	// モバイルメニュー ( Luxury 版 )
	var nav = $('#nav')
	,   mom = $('.mob-menu')
	,   mos = $('.mob-side')
	,   prv = $('.mob-prev')
	,   nxt = $('.mob-next')
	,   srh = $('.mob-search')
	,   men = $('.menu ul')
	,   mob = $('.mobile-nav')
	,   prvid = d.getElementById('data-prev')
	,   nxtid = d.getElementById('data-next')
	,   navid = d.getElementById('nav')
	,   mobmn = 'style=\"margin-top:-' + d.documentElement.clientHeight + 'px;\"><div id=\"nav\">' + ( navid !== null ? navid.innerHTML : '' ) + '</div>' +
			'<style>#layer #nav{top:0;}#layer #nav-bottom{border:0;}</style>'
	,   sdbar = ''
	,   sform = '>';

	if( d.getElementById('sidebar') !== null ) {
		sdbar = 'style=\"height:' + d.getElementById('sidebar').offsetHeight + 'px;width:1px\">' +
			'<style>#sidebar{overflow:hidden;background:#fff;padding:1px;border: 3px solid #ddd;border-radius:5px;}#side,div[id*=\"side-\"]{margin:0;padding:0;}</style>'
	}

	// モバイルメニューの動き
	mom.click(function(){
		mobile_menu( 'mom', mobmn );
	}).css('cursor','pointer');

	mos.click(function(){
		mobile_menu( 'mos', sdbar );
	}).css('cursor','pointer');

	srh.click(function(){
		mobile_menu( 'srh', sform );
	}).css('cursor','pointer');

	if( prvid !== null ) {
		prv.click(function(){
			//location.href = $('#data-prev').attr('data-prev');
			location.href = prvid.getAttribute('data-prev');
		}).css('cursor','pointer');
	} else {
		prv.css('opacity', '.4').css('cursor', 'not-allowed');
	} if( nxtid !== null ) {
		nxt.click(function(){
			//location.href = $('#data-next').attr('data-next');
			location.href = nxtid.getAttribute('data-next');
		}).css('cursor','pointer');
	} else {
		nxt.css('opacity', '.4').css('cursor', 'not-allowed');
	} function mobile_menu( cpoint, layer ) {

		if( d.getElementById('bwrap') !== null ) {
			remove_ovlay();
		} var scltop = w.pageYOffset;

		/*
		$('body').append(
			'<div id=\"ovlay\">' +
			'<div id=\"bwrap\"></div>' +
			'<div id=\"close\"><i class=\"fa fas fa-times\"></i></div>' +
			'<div id=\"layer\" ' + layer + '</div>' +
			'</div>' );
		*/
		var l = d.createElement('div');
		l.innerHTML =
			'<div id=\"ovlay\">' +
			'<div id=\"bwrap\"></div>' +
			'<div id=\"close\"><i class=\"fa fas fa-times\"></i></div>' +
			'<div id=\"layer\" ' + layer + '</div>' +
			'</div>';
		;
		d.body.appendChild( l );

		var s = d.createElement('style');
		s.id = 'ovlay-style';
		s.innerText =
			'#bwrap{height:' + d.body.clientHeight + 'px;{$brap_rgba};}' +
			'#layer{top:' + scltop + 'px;}'

SCRIPT;
				if( $luxe['global_navi_open_close'] === 'individual' ) {
					$ret .= <<< SCRIPT
		+
		'#layer li[class*=\"children\"] li a::before{content:\"-\";}' +
		'#layer li[class*=\"children\"] a::before,' +
		'#layer li li[class*=\"children\"] > a::before{content:\"\\{$fa_plus_square}\";font-weight:400}' +
		'#layer li li[class*=\"children\"] li a::before{content:\"\\\\0b7\";}'

SCRIPT;
				}
				else {
					$ret .= <<< SCRIPT
		+
		'#layer li[class*=\"children\"] a{padding-left:20px;}' +
		'#layer li[class*=\"children\"] ul{display:block}' +
		'#layer li ul > li[class*=\"children\"] > a{padding-left:35px;}'

SCRIPT;
				}

				$ret .= <<< SCRIPT
		;
		d.getElementsByTagName('head')[0].appendChild( s );

		//$('#layer ul').show();
		show( d.querySelector('#layer ul') );
		//$('#layer .mobile-nav').hide();
		hide( d.querySelector('#layer .mobile-nav') );

		if( cpoint === 'mos') {
			var winwh  = d.documentElement.clientWidth
			,   width  = {$side_1_width}
			,   sarray = {
				'width'    : width + 'px',
				'position' : 'absolute',
				'right'    : winwh + 'px',
				'top'      : w.pageYOffset + 'px',
				'z-index'  : '1100'
			};

			if( width > winwh ) {
				width = winwh - 6;
			} Object.keys( sarray ).forEach( function( index ) {
				var val = this[index];
				$('#sidebar').css( index, val );
			}, sarray );
		}

SCRIPT;
			if( $luxe['global_navi_open_close'] === 'individual' ) {
				$ret .= <<< SCRIPT
		//$('#layer ul ul').hide();
		hide( d.querySelector('#layer ul ul') );
		$('#layer ul li[class*=\"children\"] > a').click( function(e) {
			var tgt = $(e.target).parent('li')
			,   tga = tgt.attr('class').match(/item-[0-9]+/)
			,   tgc = tgt.children('ul');

			tgc.toggle( 400, 'linear' );

			if( d.getElementById(tga + '-minus') !== null ) {
				//d.getElementById(tga + '-minus').remove();
				$('#' + tga + '-minus').remove();
			} else {
				/*
				$('#ovlay').append(
					'<div id=\"' + tga + '-minus\"><style>' +
					'#layer li[class$=\"' + tga + '\"] > a::before,' +
					'#layer li[class*=\"' + tga + ' \"] > a::before,' +
					'#layer li li[class$=\"' + tga + '\"] > a::before,' +
					'#layer li li[class*=\"' + tga + ' \"] > a::before{content:\"\\{$fa_minus_square}\";}' +
					'</style></div>'
				);
				*/
				var l = d.createElement('div');
				l.innerHTML =
					'<div id=\"' + tga + '-minus\"><style>' +
					'#layer li[class$=\"' + tga + '\"] > a::before,' +
					'#layer li[class*=\"' + tga + ' \"] > a::before,' +
					'#layer li li[class$=\"' + tga + '\"] > a::before,' +
					'#layer li li[class*=\"' + tga + ' \"] > a::before{content:\"\\{$fa_minus_square}\";}' +
					'</style></div>'
				;
				d.getElementById('ovlay').appendChild( l );
			} e.preventDefault();
		});

SCRIPT;
			}
			$ret .= <<< SCRIPT
		var lay = $('#layer');

		if( cpoint === 'mom' ) {
			lay.animate( {
				'marginTop' : '0'
			}, 500 );
		} else if( cpoint === 'mos' ) {
			$('#sidebar').animate( {
				'right' : '3px'
			}, 500 );
		} else if( cpoint === 'srh' ) {
			$('html, body').scrollTop( 0 );
			no_scroll();
			$('html, body').css('overflow', 'hidden');
			$('#sform').css( 'top', '-100%' );
			//$('#sform').show();
			show( d.getElementById('sform') );
			$('#sform').animate( {
				'top' : '80px'
			}, 500 );

			setTimeout(function() {
				$('#sform .search-field').focus();
				$('#sform .search-field').click();
			}, 200 );
		} $('#bwrap, #close').click( function(e) {
			if( cpoint === 'mom') {
				lay.animate( {
					//'marginTop' : '-' + d.documentElement.clientHeight + 'px'
					'marginTop' : '-' + d.getElementById('layer').offsetHeight + 'px'
				}, 500);
			} else if( cpoint === 'mos') {
				$('#sidebar').animate( {
					'marginRight' : '-' + d.documentElement.clientWidth + 'px'
				}, 500 );
			} else if( cpoint === 'srh') {
				$('#sform').animate( {
					'bottom' : '-200%'
				}, 500 );
			} setTimeout(function() {
				if( cpoint === 'srh' ) {
					go_scroll();
					$('html, body').css('overflow', 'auto');
					$('body, html').scrollTop( scltop );
				} remove_ovlay();
			}, 550 );
		});
	}

SCRIPT;
			}
			$ret .= "} catch(e) { console.error( 'mibile.nav.error: ' + e.message ); }\n";
		}

$ret .= "try{\n"; /* offset.set */
		$ret .= 'var offset = 0;';
		/* スムーズスクロール と 追従スクロール の offset 値 */
		if( isset( $this->_depend['sscroll'] ) || isset( $this->_depend['stickykit'] ) ) {
			if( isset( $luxe['head_band_visible'] ) && isset( $luxe['head_band_fixed'] ) ) {
				// 帯メニュー固定時の高さをプラス
				$ret .= "offset += $('.band').height();";
			}

			if( isset( $luxe['global_navi_sticky'] ) && $luxe['global_navi_sticky'] !== 'none' && $luxe['global_navi_sticky'] !== 'smart' ) {
				// グローバルナビ固定時の高さをプラス
				$ret .= "if( d.getElementById('nav') !== null ) {";
				$ret .= "offset += d.getElementById('nav').offsetHeight;";
				$ret .= "}";
			}
		}
		// アドミンバーの高さをプラス
		$ret .= <<< SCRIPT
if( d.getElementById('wpadminbar') !== null ) {
	offset += d.getElementById('wpadminbar').offsetHeight;
}
SCRIPT;
$ret .= "} catch(e) { console.error( 'offset.set.error: ' + e.message ); }\n";

		/* スムーズスクロール */
		if( isset( $this->_depend['sscroll'] ) ) {
			// Intersection Observer 有効時には使えない
			if( !isset( $luxe['lazyload_thumbs'] ) && !isset( $luxe['lazyload_contents'] ) && !isset( $luxe['lazyload_sidebar'] ) && !isset( $luxe['lazyload_footer'] ) ) {
				/* source & download: https://www.cssscript.com/smooth-scroll-vanilla-javascript/ */
				$ret .= <<< SCRIPT
try{
	document.querySelectorAll('a[href^="#"]').forEach( function (anchor) {
		if( anchor.getAttribute('href') !== "#" ) {
			anchor.addEventListener('click', function () {
				smoothScroll.scrollTo(this.getAttribute('href'), 500);
			});
		}
	});
} catch(e) { console.error( 'smooth.scroll.error: ' + e.message ); }

SCRIPT;
			}
		}

$ret .= "try{\n"; /* stick.watch */

		/* 追従スクロール */
		if( isset( $this->_depend['stickykit'] ) ) {
			$stick_init_y = 0;
			$stick_init_y = isset( $luxe['global_navi_scroll_up_sticky'] ) ? 0 : 'offset';

			$ret .= <<< SCRIPT
	var stkwch  = false
	,   skeep   = $('#side-scroll')
	,   sHeight = 0;

	function stick_primary( top ) {
		if( skeep.css('max-width') !== '32767px' ) {
			//skeep.stick_in_parent({parent:'#primary',offset_top:top,spacer:0,inner_scrolling:0,recalc_every:1});
			skeep.stick_in_parent({parent:'#primary',offset_top:top,spacer:0,inner_scrolling:0});
		}
	} stick_primary( {$stick_init_y} );

	// 非同期系のブログパーツがあった場合に追従領域がフッターを突き抜けてしまうのでその予防策
	// ＆ 追従領域がコンテンツより下にあった場合にフッターまでスクロールできない現象の対策
	function stick_watch() {
		var i		// setInterval
		,   s		// 現在の #side の高さ
		,   j = 0;	// インターバルのカウンター

		if( d.getElementById('sidebar') !== null ) {
			i = setInterval( function() {
				if( skeep.css('max-width') !== '32767px' ) {
					if( d.getElementById('side') !== null ) {
						if( typeof d.getElementById('side').children[0] !== 'undefined' ) {
							// #side aside の高さ（こっち優先）
							s = d.getElementById('side').children[0].offsetHeight
						} else {
							// #side の高さ
							s = d.getElementById('side').offsetHeight;
						}
					}

					if( s >= sHeight ) {
						sHeight = s;
						d.getElementById('sidebar').style.minHeight=s + 'px';
						stick_primary( {$stick_init_y} );
						//skeep.trigger('sticky_kit:recalc');
					}

					++j;
					if( j >= 100 ) {
						clearInterval( i ); // PC 表示の時に30秒間だけ監視( 300ms * 100 )
					}
				}
			}, 300);
		}
	}
 if( skeep.css('max-width') !== '32767px' ) {
		stick_watch();
	} var skptim = null	// リサイズイベント負荷軽減用
	,     skprsz = ('resize', function() {
		if( d.getElementById('sidebar') !== null ) {
			if( skptim === null ) {
				skptim = setTimeout( function() {
					sHeight = 0;
					d.getElementById('sidebar').style.minHeight='';
					if( skeep.css('max-width') !== '32767px' ) {
						stick_watch();
					} else {
						skeep.trigger('sticky_kit:detach');
					}
					skptim = null;
				}, 100 );
			}
		}
	});

	// リサイズイベント登録
	try {
		w.addEventListener( 'resize', skprsz, false );
	} catch (e) {
		w.attachEvent( 'onresize', skprsz );
	}

SCRIPT;
		}

		/* グローバルナビTOP固定 */
		if(
			isset( $this->_depend['stickykit'] ) && isset( $luxe['global_navi_visible'] ) &&
			isset( $luxe['global_navi_sticky'] ) && $luxe['global_navi_sticky'] !== 'none'
		) {
			$nav_sticky = <<< NAV_STICKY
	top = 0;
	if( d.getElementById('wpadminbar') !== null ) {
		top += d.getElementById('wpadminbar').offsetHeight;
	}

NAV_STICKY;
			if( isset( $luxe['head_band_visible'] ) && isset( $luxe['head_band_fixed'] ) ) {
				// 帯メニュー固定時の高さをプラス
				$nav_sticky .= "top += $('.band').height();";
			}

			$nav_sticky .= <<< NAV_STICKY
	thk_unpin( nav );
	mnav = $('.mobile-nav').css('display');
	e = d.getElementById('nav');
	r = ( e !== null ? e.getBoundingClientRect() : '' );
	y = w.pageYOffset;
	hidfgt = r.top + y;	// #nav のY座標 (この位置からナビ固定)
	navhid  = top - ( e !== null ? e.offsetHeight : 0 ) - 1; // グローバルナビの高さ分マイナス(リサイズイベント用)

NAV_STICKY;

			// グローバルナビを上スクロールの時だけ固定する場合
			if( isset( $luxe['global_navi_scroll_up_sticky'] ) ) {
				$nav_sticky .= <<< NAV_STICKY
	hidfgb = hidfgt + ( e !== null ? e.offsetHeight : 0 );	// 上スクロールの時だけ固定する場合は、#nav の bottom 部分を Y座標にする

	if( y > hidfgb ) {
		skeep.trigger('sticky_kit:detach');
		stick_primary( top );
		thk_pin( nav, navhid, '' );
		nav.addClass('pinf');	// pin first の略。最初の一発目の position:fixed 挿入時に上スクロール判定されるために不自然な動きになるのを防ぐ
	}

	stkeve = ('scroll', function(){
		if( resz === false ) {
			//if( stktim === null ) {
			//	stktim = setTimeout( function() {
					p = $('.pin')[0];
					y = w.pageYOffset;
					navhid = top - d.getElementById('nav').offsetHeight - 1; // ナビの高さ分マイナス(スクロールイベント用)

					if( ( typeof p === 'undefined' && y <= hidfgb ) || ( typeof p !== 'undefined' && y <= hidfgt ) ) {
						thk_unpin( nav );
					} else if( typeof p === 'undefined' && y > hidfgb ) {
						skeep.trigger('sticky_kit:detach');
						stick_primary( top );
						thk_pin( nav, navhid, '' );
						nav.addClass('pinf');
					} else if( typeof p !== 'undefined' ) {
						var sdscrl = $('#side-scroll')
						,   sdstop = sdscrl.css('top')
						,   difpos = nowpos - y;

						nowpos = y;

						if( difpos > 10 ) { // スクロールアップ時にナビ表示
							if( nav.css('top') !== top + 'px' ) {
								if( typeof $('.pinf')[0] === 'undefined' ) {
									thk_pin( nav, top );
									// 追従スクロールの高さ調整
									if( typeof sdscrl[0] !== 'undefined' ) {
										if( sdstop === top + 'px' && skeep.css('max-width') !== '32767px' ) {
											// ナビの transition .25s の後に実行
											skeep.animate({ 'top' : offset + 'px' }, 250 );
											skeep.trigger('sticky_kit:recalc');
											/*
											setTimeout( function(){
												skeep.trigger('sticky_kit:detach');
												stick_primary( offset );
											}, 250 );
											*/
										}
									}
								}
								else {
									nav.removeClass('pinf');
								}
							}
						} else if( difpos < -60 ) { // スクロールダウンでナビを画面上に隠す
							if( nav.css('top') !== navhid + 'px' ) { // !== navhid だとカクッとなるので条件厳しく
								thk_pin( nav, navhid );
								// 追従スクロールの高さ調整
								if( typeof sdscrl[0] !== 'undefined' ) {
									if( sdstop !==  top + 'px' && skeep.css('max-width') !== '32767px' ) {
										skeep.animate({ 'top' : top + 'px' }, 250 );
										/*
										skeep.trigger('sticky_kit:detach');
										stick_primary( top );
										*/
									}
								}
							}
						}
					} else if( typeof p === 'undefined' ) {
						if( nav.css('top') !== navhid + 'px' ) {
							if( skeep.css('max-width') !== '32767px' ) {
								skeep.animate({ 'top' : top + 'px' }, 250 );
								/*
								skeep.trigger('sticky_kit:detach');
								stick_primary( top );
								*/
							}
							thk_pin( nav, navhid );
						}
					}
					//stktim = null;
				//}, stkint );
			//}
		}
	});

NAV_STICKY;
			}
			// グローバルナビを常に固定する場合
			else {
				$nav_sticky .= <<< NAV_STICKY
	if( y > hidfgt ) {
		thk_pin( nav, top, '' );
	}

	if( resz === false ) {
		stkeve = ('scroll', function(){
			p = $('.pin')[0];

			if( w.pageYOffset <= hidfgt ) {
				thk_unpin( nav );
			} else if( typeof p === 'undefined' ) {
				thk_pin( nav, top, '' );
			}
		});
	}

NAV_STICKY;
			}

			$block_if_else = "
				{$nav_sticky};
				if( mob.css( 'display' ) !== 'none' ) {
					listen_scroll( stkeve );
				} else {
					thk_unpin( nav );
					detach_scroll( stkeve );
				}
			\n";

			$stick = '';

			if( $luxe['global_navi_sticky'] === 'smart' ) {
				$stick .= $block_if_else;
			} elseif( $luxe['global_navi_sticky'] === 'pc' ) {
				$stick .= str_replace( "!== 'none'", "=== 'none'", $block_if_else );
			} else {
				$stick .= $nav_sticky . 'listen_scroll( stkeve );';
			}

			$ret .= <<< SCRIPT
	var e, r, p, y
	,   top = 0
	,   navhid = 0
	,   mnav
	,   hidfgt
	,   hidfgb
	,   resz = false	// リサイズイベントかどうかの判別
	,   nowpos = 0		// スクロール位置
	/* ,   stktim = null	// スクロールイベント負荷軽減用 */
	/* ,   stkint = 200	// インターバル(PC では少し速く:100、モバイルでは少し遅く:200) */
	,   stkeve;

	function thk_nav_stick() {
		{$stick}
	}

	thk_nav_stick();

	$(window).resize( function() {
		resz = true;
		/*
		if( skeep.css('max-width') !== '32767px' ) {
			stkint = 50;
		} else {
			stkint = 200;
		}
		*/
		thk_nav_stick();
		resz = false;
	});

	function thk_pin( o, sp, trs, cls ) {
		if( typeof trs === 'undefined' ) trs = 'all .25s ease-in-out';
		if( typeof cls === 'undefined' ) cls = 'pin';
		o.css({
			'transition': trs,
SCRIPT;

			if( isset( $luxe['head_band_fixed'] ) ) {
				$ret .= "'top': sp - d.getElementById('head-band').offsetHeight + 'px',";
			}
			else {
				$ret .= "'top': sp + 'px',";
			}

			$ret .= <<< SCRIPT
			'position': 'fixed',
			'top': sp + 'px',
			'width': o.width() + 'px'
		});
		o.addClass( cls );
		$('body').css('marginTop', d.getElementById('nav').offsetHeight + 'px');
	} function thk_unpin( o ) {
		/* o.css({ 'transition': '', 'top': sp + '', 'position': '' }); */
		o.removeAttr('style');
		o.removeClass('pin');
		$('body').removeAttr('style');
	}

SCRIPT;
		}

$ret .= "} catch(e) { console.error( 'stick.watch.error: ' + e.message ); }\n";

		if( $luxe['gallery_type'] === 'tosrus' && $is_preview === false ) {
			/* Tosrus */
			$ret .= <<< SCRIPT
try{ /* tosrus */
	$("a[data-rel^=tosrus]").tosrus({
		caption : {
			add : true,
			attributes : ["data-title","title", "alt", "rel"]
		},
		pagination : {
			add : true,
		},
		infinite : true,
		wrapper : {
			onClick: "close"
		}
	});
} catch(e) { console.error( 'tosrus.error: ' + e.message ); }

SCRIPT;
		}

		if( $luxe['gallery_type'] === 'lightcase' && $is_preview === false ) {
			/* Lightcase */
			$ret .= "try{\n"; /* lightcase */
			$ret .= "$('a[data-rel^=lightcase]').lightcase();\n";
			$ret .= "} catch(e) { console.error( 'lightcase.error: ' + e.message ); }\n";
		}

		if( $luxe['gallery_type'] === 'fluidbox' && $is_preview === false ) {
			/* Fluidbox */
			$ret .= "try{\n"; /* fluidbox */
			$ret .= "$(function () {;\n";
			$ret .= "$('.post a[data-fluidbox]').fluidbox();;\n";
			$ret .= "});;\n";
			$ret .= "} catch(e) { console.error( 'fluidbox.error: ' + e.message ); }\n";
		}

		if( isset( $luxe['head_band_search'] ) ) {
			/* 帯メニュー検索ボックスのサイズと色の変更 */
			$ret .= <<< SCRIPT
try{ /* head.band.search */
	var subm = $('#head-search button[type=submit]')
	,   text = $('#head-search input[type=text]')
	,   menu = $('.band-menu ul');

	if( text.css('display') != 'block' ) {
		text.click( function() {
			subm.css('color','#bbb');
			menu.css('right','210px');
			text.css('width','200px');
			text.css('color','#000');
			text.css('background-color','rgba(255, 255, 255, 1.0)');
			text.prop('placeholder','');

		});
		text.blur( function() {
			subm.removeAttr('style');
			menu.removeAttr('style');
			text.removeAttr('style');
			text.prop('placeholder','Search …');
		});
	}
} catch(e) { console.error( 'head.band.search.error: ' + e.message ); }

SCRIPT;
		}

		if( is_customize_preview() === true ) {
			// カスタマイズプレビューだと get_theme_mod で値を直接取ってこないとダメですた
			$luxe['awesome_load_css'] = get_theme_mod('awesome_load_css');
		}
		if( $luxe['awesome_load_css'] !== 'none' ) {
			/* placeholder にアイコンフォントを直接書くと、Nu Checker で Warning 出るので、jQuery で置換 */
			$ret .= <<< SCRIPT
(function() {
    var b = 'placeholder="',
        c = b + " &#xf002; ",
        a = $("#search label");
    if (typeof a[0] !== "undefined") {
        if (a.html().indexOf(b + " ") === -1) {
            $(".search-field").replaceWith(a.html().replace(b, c))
        }
    }
})();

SCRIPT;
		}

		if( isset( $luxe['autocomplete'] ) ) {
			/* 検索ボックスのオートコンプリート (Google Autocomplete) */
			$ret .= <<< SCRIPT
		(function() {
try{ /* autocomplete */
			$('.search-field, .head-search-field').autocomplete({
				source: function(request, response){
					$.ajax({
						url: "//www.google.com/complete/search",
						data: {
							hl: 'ja',
							ie: 'utf_8',
							oe: 'utf_8',
							client: 'firefox', // For XML: use toolbar, For JSON: use firefox, For JSONP: use firefox
							q: request.term
						},
						dataType: "jsonp",
						type: "GET",
						success: function(data) {
							response(data[1]);
						}
					});
				},
				delay: 300
			});
} catch(e) { console.error( 'autocomplete.error: ' + e.message ); }
		})();

SCRIPT;
		}

		if( isset( $this->_depend['autosize'] ) ) {
			/* コメント欄の textarea 自動伸縮 */
			$ret .= "try{\n"; /* comment.autosize */
			$ret .= "autosize($('textarea#comment'));\n";
			$ret .= "} catch(e) { console.error( 'comment.autosize.error: ' + e.message ); }\n";
		}

		$site = array();
		$wt = $ca->thk_id();
		$wt_selecter  = "$('#" . $wt . "')";
		$wta_selecter = "$('#" . $wt . " a')";
		$foot_prefix  = '#wp-';
		$wt_array  = $ca->thk_hex_array();
		$wt_txt  = array();
		$ins_func = $ca->ins_luxe();
		$csstext_array = $ca->csstext_imp();
		$site_array = $ca->thk_site_name();

		$css_txt  = 'cssText';
		$wt_txt[] = THK_COPY;

		if( strlen( $wt ) === 3 ) {
			if( $wt[2] !== 'k' )     $broken = true;
			elseif( $wt[1] !== 'h' ) $broken = true;
			elseif( $wt[0] !== 't' ) $broken = true;
		}
		else {
			$broken = true;
		}

		foreach( $wt_array as $val ) $wt_txt[] = $ca->hex_2_bin( $val );
		if(
			( is_array( $wt_txt ) && count( $wt_txt ) >= 5  ) && (
				stripos( $wt_txt[0], 'http' )  === false ||
				stripos( $wt_txt[1], 'style' ) === false ||
				stripos( $wt_txt[2], 'luxeritas' ) === false
			)
		) $broken = true;

		foreach( $site_array as $val ) $site[] = $ca->hex_2_bin( $val );
		if( is_array( $site ) && count( $site ) >= 4 && stripos( $site[0], 'luxeritas' ) === false ) {
			$broken = true;
		}

		foreach( $csstext_array as $key => $val ) {
			$csstext[] = $ca->hex_2_bin( $val );
			if( stripos( $csstext[$key], '!;' ) === false ) {
				$broken = true;
			}
			else {
				$csstext[$key] = str_replace( '!;', $imp_close, $csstext[$key] );
			}
		}

		$ret .= <<< SCRIPT
try{
	var cint = false
	,   c = thk_get_yuv()
	,   i = '{$csstext[0]}'
	,   b = '{$csstext[1]}'
	,   l = '{$csstext[2]}color:' + c[0] + '{$imp_close}'
	,   s = d.createElement('style');

	(function() {
		var h = w.location.href
		,   x  = {$wt_selecter}
		,   a = {$wta_selecter}
		,   g = d.getElementById('{$site[2]}')
		,   t = ( g !== null ? g.children : '' )
		,   f = false
		,   k = false
		,   j = 0;

		for( j = 0; j < t.length; j++ ){
			if( t[j].tagName.toLowerCase() !== '{$site[2]}' ) t[j].parentNode.removeChild(t[j]);
		} g = d.getElementsByTagName('{$site[2]}'); t = ( typeof g[0] !== 'undefined' ? g[0].children : '' );
		for( j = 0; j < t.length; j++ ){
			if( t[j].id.toLowerCase() !== '{$site[4]}' && t[j].id.toLowerCase() !== '{$site[3]}' ) t[j].parentNode.removeChild(t[j]);
		} t = d.body.children;
		for( j = 0; j < t.length; j++ ) {
			if( t[j].id.toLowerCase() === '{$site[2]}' ) k = true; continue;
		} if( k === true ) {
			for( j = 0; j < t.length; j++ ) {
				if( t[j].id.toLowerCase() === '{$site[2]}' ) {
					f = true; continue;
				} if( f === true ) {
					if( '#' + t[j].id.toLowerCase() !== '{$foot_prefix}{$site[2]}' ) t[j].parentNode.removeChild(t[j]);
					if( '#' + t[j].id.toLowerCase() === '{$foot_prefix}{$site[2]}' ) break;
				}
			}
		} else {
			for( j = 0; j < t.length; j++ ) {
				if( t[j].className.toLowerCase() === 'container' ) {
					f = true; continue;
				} if( f === true ) {
					if( '#' + t[j].id.toLowerCase() !== '{$foot_prefix}{$site[2]}' ) t[j].parentNode.removeChild(t[j]);
					if( '#' + t[j].id.toLowerCase() === '{$foot_prefix}{$site[2]}' ) break;
				}
			}
		} var id = '{$wt}';
		setInterval( function() {
			if( document.getElementById(id) !== null ) {
				var luxhtml = document.getElementById(id).innerHTML;
				if( luxhtml.indexOf('{$site[0]}') != -1 && luxhtml.indexOf('{$site[1]}') != -1 ) {
					if( document.getElementById(id).parentNode.getAttribute('id') === '{$site[3]}' ) {
						x.css({'{$css_txt}': b + l });
						a.css({'{$css_txt}': i + l });
					} else {
						{$ins_func};
					}
				} else {
					{$ins_func};
				}
			} else {
				{$ins_func};
			} if( d.getElementById('{$site[2]}') === null || d.getElementsByTagName('{$site[2]}').length <= 0 || $('#{$site[2]}').css('display') == 'none' || $('{$site[2]}').css('display') == 'none' ) {
				{$ins_func};
			}
		}, 1000 );
	 })(); function {$ins_func} {
		if( cint === false ) {
			var	txt = '{$wt_txt[1]}'
			,	apd = d.createElement('div');
			if( d.getElementById('{$site[3]}') !== null ) {
				var rep = d.getElementById('{$site[3]}').innerHTML;
				txt = txt.replace('><', '>' + rep + '<');
				//d.getElementById('{$site[3]}').remove();
				$('#{$site[3]}').remove();
			} apd.innerHTML = txt + b  + l + '{$wt_txt[2]}{$wt_txt[0]}{$wt_txt[3]}' + i  + l + '{$wt_txt[4]}'; d.body.appendChild( apd );
			cint = true;
		}
	} function thk_dummy(){}
} catch(e) {
	console.error( 'html.body.error: ' + e.message );
	var c = [], n = d.body; n.parentNode.removeChild( n );
}
	function thk_get_yuv() {
		var yuv = 255
		,   k = null
		,   e = ""
		,   i = "rgba(0, 0, 0, 0)"
		,   h = "transparent"
		,   g = "none"
		,   j = "background-color"
		,   m = $("body").css(j)
		,   c = $("#{$site[2]}").css(j)
		,   b = $("{$site[2]}").css(j)
		,   a = $("#{$site[3]}").css(j);
		if (a != i && a != h && a != g) {
			k = a
		} else {
			if (b != i && b != h && b != g) {
				k = b
			} else {
				if (c != i && c != h && c != g) {
					k = c
				} else {
					k = m
				}
			}
		}
		if (k != i && k != h && k != g) {
			if (typeof(k) != "undefined") {
				e = k.split(",")
			}
		} else {
			e = ["255", "255", "255", "0"]
		}
		if (e.length >= 3) {
			e[0] = e[0].replace(/rgba\(/g, "").replace(/rgb\(/g, "");
			e[1] = e[1].replace(/ /g, "");
			e[2] = e[2].replace(/\)/g, "").replace(/ /g, "");
			yuv = 0.299 * e[0] + 0.587 * e[1] + 0.114 * e[2]
		}
		return yuv >= 128 ? ['black', 'white'] : ['white', 'black']
	};
	s.id = '{$wt}c';
	s.innerText = '{$imp}color:' + c[0] + '{$imp_close}}';
	document.getElementsByTagName('head')[0].appendChild( s );
	setInterval( function() {
		if( document.getElementById(s.id) === null ) {
			document.getElementsByTagName('head')[0].appendChild( s );
		}
	}, 1000 );
})(window,document);
});

/* IE8以下、Firefox2 以下で getElementsByClassName 使えない時用 */
if (typeof(document.getElementsByClassName) == "undefined") {
	document.getElementsByClassName = function(o) {
		var q = new Array(),
			p = document;
		if (p.all) {
			var m = p.all
		} else {
			var m = p.getElementsByTagName("*")
		}
		for (var l = j = 0, k = m.length; l < k; l++) {
			var n = m[l].className.split(/\s/);
			for (var i = n.length - 1; i >= 0; i--) {
				if (n[i] === o) {
					q[j] = m[l];
					j++;
					break
				}
			}
		}
		return q
	}
};

SCRIPT;

		if( $broken !== false ) {
			if( is_admin() === true ) {
				return false;
			}
			else {
				wp_die( __( 'This theme is broken.', 'luxeritas' ) );
			}
		}
		return $ret;
	}

	/*
	------------------------------------
	 SNS のカウント数読み込み
	------------------------------------ */
	public function create_sns_count_script( $is_preview = false ) {
		global $luxe;
		$ret = '';
		$ajaxurl = admin_url( 'admin-ajax.php' );

		$ret .= <<< SCRIPT
function get_sns_count(e, d) {
	var c = document.getElementsByClassName("sns-count-true")
	,   b = c[0].getAttribute("data-luxe-permalink")
	,   a = window.location.search;
	jQuery.ajax({
		type: "GET",
		url: "{$ajaxurl}",
		data: {
			action: "thk_sns_real",
			sns: e,
			url: b
		},
		dataType: "text",
		async: true,
		cache: false,
		timeout: 10000,
		success: function(f) {
			if (isFinite(f) && f !== "") {
				jQuery(d).text(String(f).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, '$1,'))
			} else {
				if (typeof(f) === "string" && f !== "") {
					var g = f.slice(0, 11);
					jQuery(d).text(g)
				} else {
					if (a.indexOf("preview=true") !== -1) {
						jQuery(d).text(0)
					} else {
						jQuery(d).text("!")
					}
				}
			}
		},
		error: function() {
			jQuery(d).text("!")
		}
	})
};
(function(b, d) {
	function c() {
		if (d.getElementsByClassName("sns-count-true").length > 0 && d.getElementsByClassName("sns-cache-true").length < 1) {
			var e = {
				f: ".facebook-count",
				g: ".google-count",
				h: ".hatena-count",
				l: ".linkedin-count",
				t: ".pinit-count",
				p: ".pocket-count"
			};
			Object.keys(e).forEach(function(f) {
				var g = this[f];
				get_sns_count(f, g)
			}, e)
		}
		if (d.getElementsByClassName("feed-count-true").length > 0 && d.getElementsByClassName("feed-cache-true").length < 1) {
			get_sns_count("r", ".feedly-count")
		}
	}
	if (b.addEventListener) {
		b.addEventListener("load", c, false)
	} else {
		if (b.attachEvent) {
			var a = function() {
				if (b.readyState == "complete") {
					b.detachEvent("onload", a);
					c()
				}
			};
			b.attachEvent("onload", a);
			(function() {
				try {
					b.documentElement.doScroll("left")
				} catch (e) {
					setTimeout(arguments.callee, 10);
					return
				}
				b.detachEvent("onload", a);
				c()
			})()
		} else {
			c()
		}
	}
})(window, document);

SCRIPT;
		return $ret;
	}
}
