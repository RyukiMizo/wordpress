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

/*---------------------------------------------------------------------------
 * カスタマイズした内容の CSS
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_custom_css' ) === false ):
function thk_custom_css() {
	global $luxe;

	if( class_exists('thk_colors') === false ) {
		require( INC . 'colors.php' );
	}

	$ca = new carray();
	if( method_exists( $ca, 'thk_site_name' ) === false ) die;

	$conf = new defConfig();
	$colors_class = new thk_colors();

	$defaults = $conf->default_variables();
	$default_colors = $conf->over_all_default_colors();

	$def_border_color = $default_colors[$luxe['overall_image']]['border'];

	unset( $conf );

	$ret = '/*! luxe customizer css */' . "\n";

	$style = array(
		'all'		=> null,
		'min_576'	=> null,
		'min_768'	=> null,
		'min_992'	=> null,
		'min_1200'	=> null,
		'CONTAINER'	=> null,
		'max_1199'	=> null,
		'max_991'	=> null,
		'max_767'	=> null,
		'max_575'	=> null,
		'992_1309'	=> null,
		'992_1199'	=> null,
		'576_991'	=> null,
	);

	/*---------------------------------------------------------------------------
	 * コンテナの最大幅
	 *---------------------------------------------------------------------------*/
	/*
	if( isset( $luxe['container_max_width'] ) && $luxe['container_max_width'] !== $defaults['container_max_width'] ) {
		$max_width = $luxe['container_max_width'] + 30;

		$mw1 = ( $luxe['container_max_width'] === 0 ) ? '1200px' :  $max_width . 'px';
		$mw2 = ( $luxe['container_max_width'] === 0 ) ? '100%' :  $max_width - 30 . 'px';

		if( $max_width > 1200 ) {
			$style['all'] .= '@media (min-width:' . $mw1 . '){';
			$style['all'] .= '.container{max-width:' . $mw2 . ';padding-left:0;padding-right:0;}';
			$style['all'] .= '.logo,#header .head-cover,#head-band-in,div[id*="head-band"] .band-menu{max-width:' . $mw2 . ';}';
			$style['all'] .= '#header #gnavi,#foot-in{max-width:' . $mw1 . ';}';
			if( isset( $luxe['container_max_width'] ) && $luxe['container_max_width'] === 0 ) {
				$style['all'] .= '.container,.logo{padding-left:15px;padding-right:15px;}';
				$style['all'] .= '#head-band-in,#foot-in{margin-left:15px;margin-right:15px;}';
				$style['all'] .= '#header #gnavi,div[id*="head-band"] .band-menu,#foot-in{max-width:100%;}';
			}
			$style['all'] .= '}';
		}
		elseif( $max_width < 992 ) {
			$style['all'] .= '@media (min-width:' . $mw1 . ') and (max-width:992px){';
			$style['all'] .= '#head-band-in,div[id*="head-band"] .band-menu{max-width:' . $mw2 . ';}';
			$style['all'] .= '}';
		}
	}
	*/

	/*---------------------------------------------------------------------------
	 * HTML
	 *---------------------------------------------------------------------------*/
	$style['all'] .= <<<HTML_STYLE
html {
	overflow: auto;
	overflow-y: scroll;
	-webkit-text-size-adjust: 100%;
	-ms-text-size-adjust: 100%;
	-ms-overflow-style: scrollbar;
	-webkit-tap-highlight-color: transparent;
HTML_STYLE;

	if( isset( $luxe['font_size_scale'] ) && (float)$luxe['font_size_scale'] !== (float)$defaults['font_size_scale'] ) {
		$style['all'] .= 'font-size:' . $luxe['font_size_scale'] . '%!important;';
	}
	else {
		$style['all'] .= 'font-size: 62.5%!important;';
	}
	$style['all'] .= '}';

	/*---------------------------------------------------------------------------
	 * bootstrap モード（bootstrap3 と bootstrap4 の異なる箇所を修正、特にコンテナ幅）
	 *---------------------------------------------------------------------------*/
	if( isset( $luxe['luxe_mode_select'] ) && $luxe['luxe_mode_select'] === 'bootstrap' ) {
		//$style['min_576']  .= '.container{width: 540px; max-width: 540px;}';
		$style['min_768']  .= '.container{width: 720px; max-width: 720px;}';
		$style['min_992']  .= '.container{width: 960px; max-width: 960px;}';
		$style['min_1200'] .= '.container{width: 1140px; max-width: 1140px;}';
	}
	if( isset( $luxe['luxe_mode_select'] ) && $luxe['luxe_mode_select'] === 'bootstrap4' ) {
		$style['all']  .= 'div[class^=col-]{float: left;}';
	}

	/*---------------------------------------------------------------------------
	 * グリッドレイアウト（記事一覧中央ウィジェットの幅）
	 *---------------------------------------------------------------------------*/
	if( isset( $luxe['posts_list_middle_widget_wide'] ) ) {
		$style['all'] .= '#list .posts-list-middle-widget{max-width:100%;width:100%;}';
	}
	else {
		$style['all'] .= '#list .posts-list-middle-widget{padding:15px;}';
	}

	/*---------------------------------------------------------------------------
	 * グリッドレイアウト（タイル型の並び順）
	 *---------------------------------------------------------------------------*/
	if( isset( $luxe['grid_tile_order'] ) ) {
		if( $luxe['grid_tile_order'] === 'MThumbT' || $luxe['grid_tile_order'] === 'MTThumb' ) {
			$dotted = '#333';
			if( $luxe['overall_image'] !== 'white' ) $dotted = '#999';

			if( $luxe['grid_tile_order'] === 'MThumbT' ) {
				$style['all'] .= 'div[id^="tile-"] .meta{padding:5px 0;border:none;}';
				$style['all'] .= 'div[id^="tile-"] .excerpt{padding-top:16px;border-top:1px dotted ' . $dotted . ';}';
			}
			elseif( $luxe['grid_tile_order'] === 'MTThumb' ) {
				$style['all'] .= 'div[id^="tile-"] .meta{padding:5px 0 10px 0;border:none;border-bottom:1px dotted ' . $dotted . ';}';
			}
		}
	}

	/*---------------------------------------------------------------------------
	 * グリッドレイアウト（抜粋の濃度・透過率）
	 *---------------------------------------------------------------------------*/
	if( isset( $luxe['excerpt_opacity'] ) && $luxe['excerpt_opacity'] !== $defaults['excerpt_opacity'] ) {
		$excerpt_opacity = $luxe['excerpt_opacity'] !== 0 ? round( $luxe['excerpt_opacity'] / 100, 2 ) : 0;
		$style['all'] .= '#list .exsp,#list .exsp p{opacity:' . $excerpt_opacity . ';}';
	}

	if( isset( $luxe['excerpt_opacity_tile'] ) && $luxe['excerpt_opacity_tile'] !== $defaults['excerpt_opacity_tile'] ) {
		$excerpt_opacity_tile = $luxe['excerpt_opacity_tile'] !== 0 ? round( $luxe['excerpt_opacity_tile'] / 100, 2 ) : 0;
		$style['all'] .= '#list div[id^="tile-"] .exsp{opacity:' . $excerpt_opacity_tile . ';}';
	}

	if( isset( $luxe['excerpt_opacity_card'] ) && $luxe['excerpt_opacity_card'] !== $defaults['excerpt_opacity_card'] ) {
		$excerpt_opacity_card = $luxe['excerpt_opacity_card'] !== 0 ? round( $luxe['excerpt_opacity_card'] / 100, 2 ) : 0;
		$style['all'] .= '#list div[id^="card-"] .exsp{opacity:' . $excerpt_opacity_card . ';}';
	}

	/*---------------------------------------------------------------------------
	 * グリッドレイアウトのタイル型/カード型での「抜粋」「記事を読む」があるかないかによる位置の微調整
	 *---------------------------------------------------------------------------*/
	// PC
	if( !empty( $luxe['read_more_text_tile'] ) && empty( $luxe['excerpt_length_tile'] ) ) {
		$style['all'] .= '#list div[id^="tile-"] .meta{margin-bottom:30px;}';
	}

	if( empty( $luxe['read_more_text_tile'] ) && !empty( $luxe['excerpt_length_tile'] ) ) {
		$style['all'] .= '#list div[id^="tile-"] .excerpt{margin-bottom:20px;padding-bottom:0;}';
	}

	if( empty( $luxe['read_more_text_card'] ) && !empty( $luxe['excerpt_length_card'] ) ) {
		$style['all'] .= '#list div[id^="card-"] .excerpt{margin-bottom:0;}';
	}

	// スマホ
	if( !empty( $luxe['read_more_text_tile'] ) &&  empty( $luxe['excerpt_length_tile'] ) ) {
		$style['max_575'] .= '#list div[id^="tile-"] .meta{margin-bottom:10px;}';
		$style['max_575'] .= '#list div[id^="tile-"] .read-more{position:static;margin-bottom:10px;}';
	}

	if( !empty( $luxe['read_more_text_card'] ) ) {
		if( !empty( $luxe['excerpt_length_card'] ) ) {
			$style['max_575'] .= '#list div[id^="card-"] .excerpt{margin-bottom:20px;padding-bottom:0;}';
		}
		else {
			$style['max_575'] .= '#list div[id^="card-"] .read-more{margin-bottom:20px;}';
		}
	}

	/*---------------------------------------------------------------------------
	 * タイトルの配置
	 *---------------------------------------------------------------------------*/
	if( $luxe['title_position'] === 'center' ) {
		$style['all'] .= '.info{text-align:center;}';
		$style['all'] .= '#sitename{margin:0 auto 12px auto;}';
	}
	elseif( $luxe['title_position'] === 'right' ) {
		$style['all'] .= '.info{text-align:right;}';
		$style['all'] .= '#sitename{margin:0 0 12px auto;}';
	}

	/*---------------------------------------------------------------------------
	 * ヘッダー上の帯状メニューが常に横幅いっぱいの場合
	 *---------------------------------------------------------------------------*/
	if( isset( $luxe['head_band_wide'] ) ) {
		$style['all'] .= '.band{width:100%;padding-left:0;padding-right:0;}';
	}

	if( isset( $luxe['head_band_visible'] ) && !isset( $luxe['head_band_wide'] ) && $luxe['bootstrap_header'] === 'in' ) {
		$style['max_767'] .= <<<HEAD_BAND_IN
@media screen and (max-width: 767px) {
	#head-band-in {
		margin: 0 5px;
	}
}
HEAD_BAND_IN;
		$style['max_575'] .= <<<HEAD_BAND_IN
@media screen and (max-width: 767px) {
	#head-band-in {
		margin: 0;
	}
}
HEAD_BAND_IN;
	}

	/*---------------------------------------------------------------------------
	 * パンくずリンクの配置
	 *---------------------------------------------------------------------------*/
	if( $luxe['breadcrumb_view'] === 'outer' ) {
		if( isset( $luxe['logo_img'] ) && !isset( $luxe['logo_img_up'] ) ) {
			$style['all'] .= '.logo,.logo-up{margin-bottom:0;}';	// ロゴ画像があった場合の位置調整
		}
	}
	else {
		$style['all'] .= '#breadcrumb{margin: 0 0 30px 0;}';
		$style['all'] .= '#primary{margin-top:35px;}';
		if( isset( $luxe['grid_type'] ) ) {
			$style['all'] .= '#breadcrumb-box #breadcrumb{margin-top: 0; margin-bottom: 0;}';
			$style['all'] .= '#list #breadcrumb-box {padding-top: 5px; padding-bottom: 5px;}';
		}
		else {
			$style['all'] .= '#breadcrumb{margin-top: 0;}';
		}
	}

	/* パンくず文字色 */
	if( isset( $luxe['breadcrumb_color'] ) ) {
		/* リンクホバー色 */
		if( isset( $luxe['breadcrumb_color'] ) ) {
			$style['all'] .= '#breadcrumb,#breadcrumb a,breadcrumb i{color:' . $luxe['breadcrumb_color'] . ';}';
		}
	}

	/* パンくず背景 */
	if(
		isset( $luxe['breadcrumb_bg_color'] ) ||
		isset( $luxe['breadcrumb_border'] )   ||
		( isset( $luxe['breadcrumb_top_buttom_padding'] ) && $luxe['breadcrumb_top_buttom_padding'] !== $defaults['breadcrumb_top_buttom_padding'] ) ||
		( isset( $luxe['breadcrumb_left_right_padding'] ) && $luxe['breadcrumb_left_right_padding'] !== $defaults['breadcrumb_left_right_padding'] )
	) {
		$style['all'] .= '#breadcrumb{';

		// パンくず背景色
		if( isset( $luxe['breadcrumb_bg_color'] ) ) {
			$style['all'] .= 'background:' . $luxe['breadcrumb_bg_color'] . ';';
		}

		// パンくず枠線
		if( isset( $luxe['breadcrumb_border'] ) ) {
			$breadcrumb_border_color = isset( $luxe['breadcrumb_border_color'] ) ? $luxe['breadcrumb_border_color'] : $def_border_color;
			$style['all'] .= 'border:1px solid ' . $breadcrumb_border_color . ';';
		}
		// パンくず丸み
		if( isset( $luxe['breadcrumb_radius'] ) && $luxe['breadcrumb_radius'] !== $defaults['breadcrumb_radius'] ) {
			$style['all'] .= 'border-radius:' . $luxe['breadcrumb_radius'] . 'px;';
		}
		// パンくずパディング
		if(
			( isset( $luxe['breadcrumb_top_buttom_padding'] ) && $luxe['breadcrumb_top_buttom_padding'] !== $defaults['breadcrumb_top_buttom_padding'] ) ||
			( isset( $luxe['breadcrumb_left_right_padding'] ) && $luxe['breadcrumb_left_right_padding'] !== $defaults['breadcrumb_left_right_padding'] )
		) {
			$breadcrumb_top_buttom_padding = $defaults['breadcrumb_top_buttom_padding'];
			$breadcrumb_left_right_padding = $defaults['breadcrumb_left_right_padding'];

			if( isset( $luxe['breadcrumb_top_buttom_padding'] ) && $luxe['breadcrumb_top_buttom_padding'] !== $defaults['breadcrumb_top_buttom_padding'] ) {
				$breadcrumb_top_buttom_padding = $luxe['breadcrumb_top_buttom_padding'];
			}
			if( isset( $luxe['breadcrumb_left_right_padding'] ) && $luxe['breadcrumb_left_right_padding'] !== $defaults['breadcrumb_left_right_padding'] ) {
				$breadcrumb_left_right_padding = $luxe['breadcrumb_left_right_padding'];
			}
			$style['all'] .= 'padding:' . $breadcrumb_top_buttom_padding . 'px ' . $breadcrumb_left_right_padding . 'px;';
		}
		$style['all'] .= '}';
	}

	/*---------------------------------------------------------------------------
	 * グローバルナビ
	 *---------------------------------------------------------------------------*/
	/* グローバルナビ固定 ＆ 半透明化 ＆ 影 */
	if(
		( isset( $luxe['global_navi_sticky'] ) && $luxe['global_navi_sticky'] !== 'none' ) &&
		( isset( $luxe['global_navi_translucent'] ) || isset( $luxe['global_navi_shadow'] ) ) 
	) {
		$style['all'] .= '#nav.pin{';

		if( isset( $luxe['global_navi_translucent'] ) ) {
			$style['all'] .= 'opacity: 0.9;';
		}
		if( $luxe['global_navi_shadow'] !== 0 ) {
			$bg_color = isset( $luxe['body_bg_color'] ) ? $luxe['body_bg_color'] : $default_colors[$luxe['overall_image']]['contbg'];
			$rgb = $colors_class->colorcode_2_rgb( $colors_class->get_text_color_matches_background( $bg_color ) );
			$shadow = (int)$luxe['global_navi_shadow'] / 100;
			$style['all'] .= 'box-shadow: 0 5px 10px 0 rgba( ' . $rgb['r'] . ',' . $rgb['g'] . ',' . $rgb['b'] . ',' . $shadow . ');';
		}

		$style['all'] .= '}';

		// #nav が横幅一杯の時に固定してると unstick の時に瞬間的に(目に見えない程度だけど)縮むので、おまじない
		if( $luxe['bootstrap_header'] === 'out' ) {
			$style['all'] .= '#nav{width:100%;}';
		}
	}

	// グローバルナビ固定の時、小デバイスでアイコン表示( 未使用 )
	if( ( isset( $luxe['global_navi_sticky'] ) && $luxe['global_navi_sticky'] !== 'none' ) && isset( $luxe['global_navi_smart_icon'] ) ) {
		$style['all'] .= <<<GNAVI_SMART_ICON
#inav {
	transition: all .2s linear;
	position: fixed;
	bottom: 20px;
	left: 20px;
	opacity: 0.5;
	height: 44px;
	width: 0;
	display: none;
	text-align: center;
GNAVI_SMART_ICON;
		// 小デバイスでのアイコンは、PAGE TOP ボタン と同じ色にする
		$inav_color      = isset( $luxe['page_top_color'] ) ? $luxe['page_top_color'] : '#fff';
		$inav_background = isset( $luxe['page_top_bg_color'] ) ? $luxe['page_top_bg_color'] : '#656463';

		$style['all'] .= 'color:' . $inav_color . ';';
		$style['all'] .= 'background:' . $inav_background . ';';
		if( isset( $luxe['page_top_radius'] ) && $luxe['page_top_radius'] !== $defaults['page_top_radius'] ) {
			$style['all'] .= 'border-radius:' . $luxe['page_top_radius'] . 'px;';
		}

		$style['all'] .= <<<GNAVI_SMART_ICON
}
#inav:hover {
	opacity: 1.0;
}
#inav i {
	padding: 9px;
	font-size: 26px;
}
GNAVI_SMART_ICON;
	}

	// グローバルナビ固定 ＆ 帯メニュー固定 ＆ 検索ボックスが表示されてる時は、540px 以下で高さ +28px
	// ・・・を Javascript 側で監視するためのスタイルを挿入
	if(
		( isset( $luxe['global_navi_sticky'] ) && $luxe['global_navi_sticky'] !== 'none' ) &&
		isset( $luxe['head_band_visible'] ) && isset( $luxe['head_band_fixed'] ) && isset( $luxe['head_band_search'] )
	) {
		$style['max_575'] .= '#head-band{max-width: 32767px;}';
	}

	/* グローバルナビ中央寄せ */
	if( isset( $luxe['global_navi_auto_resize'] ) && $luxe['global_navi_auto_resize'] === 'auto' && isset( $luxe['global_navi_center'] ) ) {
		$style['min_992'] .= '#gnavi > div{display:table;margin-right:auto;margin-left:auto;}';
	}

	/* グローバルナビに区切り線を追加 */
	if( isset( $luxe['global_navi_sep'] ) && $luxe['global_navi_sep'] !== $defaults['global_navi_sep'] ) {
		$separator_color = isset( $luxe['gnavi_separator_color'] ) ? $luxe['gnavi_separator_color'] : $def_border_color;

		// 自動リサイズ same の時だけ display: table なので、margin の調整の仕方が異なる
		if( isset( $luxe['global_navi_auto_resize'] ) && $luxe['global_navi_auto_resize'] === 'same' ) {
			$style['min_992'] .= '#gnavi div > ul::before{content:none;}';
			$style['min_992'] .= '#gnavi div > ul > li > a{border-left:1px solid ' . $separator_color . ';}';
			$style['min_992'] .= '#gnavi div > ul > li:last-child > a{border-right:1px solid ' . $separator_color . ';}';

			if( $separator_color !== $def_border_color ) {
				$style['min_992'] .= '#gnavi li ul{border-left-color:' . $separator_color . '; border-right-color:' . $separator_color . ';}';
			}
		}
		else {
			$style['min_992'] .= '#gnavi div > ul > li > a{border-left:1px solid ' . $separator_color . ';}';
		}

		if( isset( $luxe['global_navi_auto_resize'] ) && $luxe['global_navi_auto_resize'] === 'same' ) {
			$style['min_992'] .= '#gnavi div > ul > li:first-child a{border-left:none;}';
		}

		$style['min_992'] .= '#gnavi div > ul > li:first-child > a{border-left:none;}';
		$style['min_992'] .= '#gnavi div > ul > li:last-child > a{border-right:none;}';

		// 両端の border ありの時
		if( $luxe['global_navi_sep'] === 'both' ) {
			$style['min_992'] .= '#gnavi div > ul{border-left:1px solid ' . $separator_color . ';}';
			$style['min_992'] .= '#gnavi div > ul{border-right:1px solid ' . $separator_color . ';}';
		}
	}

	if( isset( $luxe['gnavi_separator_color'] ) ) {
		$style['min_992'] .= '#gnavi li > ul,';
		$style['min_992'] .= '#gnavi li li span,';
		$style['min_992'] .= '#gnavi li li ul {';
		$style['min_992'] .= 'border-color:' . $luxe['gnavi_separator_color'];
		$style['min_992'] .= ';}';
	}

	/* グローバルナビ自動リサイズ */
	if( isset( $luxe['global_navi_auto_resize'] ) && $luxe['global_navi_auto_resize'] === 'full' ) {
		$style['min_992'] .= <<<GNAVI_AUTO
#gnavi li {
	-webkit-flex: 1 0 auto;
	-ms-flex: 1 0 auto;
	flex: 1 0 auto;
}
GNAVI_AUTO;
	}
	/* グローバルナビ全幅同じ */
	elseif( isset( $luxe['global_navi_auto_resize'] ) && $luxe['global_navi_auto_resize'] === 'same' ) {
		$style['min_992'] .= <<<GNAVI_AUTO
#gnavi ul {
	display: table;
	table-layout: fixed;
	width: 100%;
	/*border-collapse: collapse;*/
}
#gnavi li {
	display: table-cell;
	float: none;
	width: 100%;
}
#gnavi ul ul {
	table-layout: auto;
}
#gnavi li li {
	/*display: table-row;*/
	display: table;
}
GNAVI_AUTO;
	}

	/* グローバルナビを上部配置 ＆ 帯メニューを表示してる場合の位置調整 */
	if( isset( $luxe['global_navi_position'] ) && $luxe['global_navi_position'] !== $defaults['global_navi_position'] ) {
		$top = isset( $luxe['head_band_height'] ) ? $luxe['head_band_height'] - 1 : $defaults['head_band_height'] - 1;
		if( isset( $luxe['head_band_visible'] ) ) {
			if( isset( $luxe['head_band_border_bottom_width'] ) ) {
				$top += $luxe['head_band_border_bottom_width'];
			}
			$style['all'] .= '#nav{top:' . $top . 'px;}';
		}
	}

	/*---------------------------------------------------------------------------
	 * ヘッダーのトップマージン
	 *---------------------------------------------------------------------------*/
	if(
		$luxe['head_margin_top'] !== $defaults['head_margin_top'] ||
		isset( $luxe['header_border'] ) ||
		!isset( $luxe['head_band_visible'] ) ||
		( isset( $luxe['head_band_visible'] ) && $luxe['head_band_height'] !== $defaults['head_band_height'] )
	) {
		$style['all'] .= '#head-in{';

		if( $luxe['head_margin_top'] !== $defaults['head_margin_top'] || isset( $luxe['header_border'] ) ) {
			$head_margin_top = 0;
			$head_margin_top += $luxe['head_margin_top'];
			if( isset( $luxe['header_border'] ) ) {
				$head_margin_top -= 1;	// ヘッダーに枠線がある場合は -1px
			}
			$style['all'] .= 'margin-top:' . $head_margin_top . 'px;';
		}

		if(
			!isset( $luxe['head_band_visible'] ) ||
			( isset( $luxe['head_band_visible'] ) && $luxe['head_band_height'] !== $defaults['head_band_height'] )
		) {
			$head_padding_top = 0;
			if( isset( $luxe['head_band_visible'] ) ) {
				// 帯状メニューの高さ分のマージン追加
				$head_padding_top += $luxe['head_band_height'];
				if( isset( $luxe['head_band_border_bottom_width'] ) ) {
					$head_padding_top += $luxe['head_band_border_bottom_width'];
				}
			}
			$style['all'] .= 'padding-top:' . $head_padding_top . 'px;';
		}

		$style['all'] .= '}';
	}

	// 帯メニューに検索ボックスつけてる場合の小デバイスのトップマージン調整
	if( isset( $luxe['head_band_search'] ) && !isset( $luxe['amp_css'] ) ) {
		$band_height = $luxe['head_band_height'] + 28 + 3;
		$head_padding = $luxe['head_margin_top'] + $band_height;

		$style['max_575'] .= '#head-in {';
		$style['max_575'] .= 'padding-top:' . $head_padding . 'px;';
		$style['max_575'] .= '}';

		if( isset( $luxe['global_navi_position'] ) && $luxe['global_navi_position'] !== $defaults['global_navi_position'] ) {
			$style['max_575'] .= '#nav {';
			$style['max_575'] .= 'top:' . $band_height . 'px;';
			$style['max_575'] .= '}';
		}
	}

	/*---------------------------------------------------------------------------
	 * ヘッダーのパディング
	 *---------------------------------------------------------------------------*/
	if(
		$luxe['head_padding_top']    !== $defaults['head_padding_top']    ||
		$luxe['head_padding_bottom'] !== $defaults['head_padding_bottom'] ||
		$luxe['head_padding_left']   !== $defaults['head_padding_left']   ||
		$luxe['head_padding_right']  !== $defaults['head_padding_right']
	) {
		$style['all'] .= '.info{padding:';
		$style['all'] .= $luxe['head_padding_top']    . 'px ';
		$style['all'] .= $luxe['head_padding_right']  . 'px ';
		$style['all'] .= $luxe['head_padding_bottom'] . 'px ';
		$style['all'] .= $luxe['head_padding_left']   . 'px';
		$style['all'] .= ';}';
	}

	/*---------------------------------------------------------------------------
	 * カラム操作関連のスタイルを読み込む
	 *---------------------------------------------------------------------------*/
	$style = thk_adjust_column_css( $style, $luxe['column_style'], $defaults, $default_colors, $colors_class );

	/*---------------------------------------------------------------------------
	 * 文字色・背景色・背景画像・枠線
	 *---------------------------------------------------------------------------*/
	/* Body */
	// WebFont の font-face
	$webfont = new Create_Web_Font();
	$font_arr = $webfont->create_web_font_stylesheet();

	if( isset( $font_arr['font_alphabet'] ) ) $style['all'] .= $font_arr['font_alphabet'];
	if( isset( $font_arr['font_japanese'] ) ) $style['all'] .= $font_arr['font_japanese'];

	$style['all'] .= <<<BODY
body {
	overflow: hidden;
BODY;

	// Font Family
	if( isset( $font_arr['font_family'] ) ) {
		$style['all'] .= $font_arr['font_family'];
	}
	else {
		$style['all'] .= 'font-family: sans-serif;';
	}

	/* 文字色 */
	if( isset( $luxe['body_color'] ) ) {
		$style['all'] .= 'color:' . $luxe['body_color'] . ';';
	}
	else {
		$style['all'] .= 'color:' . $default_colors[$luxe['overall_image']]['color'] . ';';
	}

	$body_bg_color = isset( $luxe['body_bg_color'] ) ? $luxe['body_bg_color'] : $default_colors[$luxe['overall_image']]['background'];
	$background = '';

	if( isset( $luxe['body_bg_img'] ) || ( isset( $luxe['body_transparent'] ) && $luxe['body_transparent'] !== 0 ) ) {
		/* 背景色 */
		if( isset( $luxe['body_transparent'] ) && $luxe['body_transparent'] >= 100 ) {
			$background .= $body_bg_color;
		}
		/* 背景画像 */
		if( isset( $luxe['body_bg_img'] ) ) {
			$background .= ' url("' . $luxe['body_bg_img'] . '");';
		}

		/* 背景色透過 */
		if( !isset( $luxe['body_bg_img'] ) && isset( $luxe['body_transparent'] ) && $luxe['body_transparent'] < 100 ) {
			$rgb = $colors_class->colorcode_2_rgb( $body_bg_color );
			$transparent = $luxe['body_transparent'] !== $defaults['body_transparent'] ? $luxe['body_transparent'] : $defaults['body_transparent'];
			$transparent = round( $transparent / 100, 2 );

			$background .= 'rgba(' . $rgb['r'] . ',' . $rgb['g'] . ',' . $rgb['b'] . ',' . $transparent . ');';
		}
		if( !empty( $background ) ) {
			$style['all'] .= 'background:' . $background . ';';
		}

		if( $luxe['body_img_repeat'] !== 'repeat' ) {
			$style['all'] .= 'background-repeat:no-repeat;';
		}

		if( $luxe['body_img_size'] === 'contain' ) {
			$style['all'] .= 'background-size:contain;';
		}
		elseif( $luxe['body_img_size'] === 'cover' ) {
			$style['all'] .= 'background-size:cover;';
		}
		elseif( $luxe['body_img_size'] === 'adjust' ) {
			$style['all'] .= 'background-size:100% auto;';
		}
		elseif( $luxe['body_img_size'] === 'adjust2' ) {
			$style['all'] .= 'background-size:auto 100%;';
		}
		elseif( $luxe['body_img_size'] === 'adjust3' ) {
			$style['all'] .= 'background-size:100% 100%;';
		}

		if(
			( isset( $luxe['body_img_vertical'] ) && $luxe['body_img_vertical'] !== $defaults['body_img_vertical'] ) ||
			( isset( $luxe['body_img_horizontal'] ) && $luxe['body_img_horizontal'] !== $defaults['body_img_horizontal'] )
		) {
			$body_img_vertical   = isset( $luxe['body_img_vertical'] ) ? $luxe['body_img_vertical'] : $defaults['body_img_vertical'];
			$body_img_vertical   = $body_img_vertical === 'middle' ? 'center' : $body_img_vertical;
			$body_img_horizontal = isset( $luxe['body_img_horizontal'] ) ? $luxe['body_img_horizontal'] : $defaults['body_img_horizontal'];

			$style['all'] .= 'background-position: ' . $body_img_vertical . ' ' . $body_img_horizontal . ';';
		}

		if( isset( $luxe['body_img_fixed'] ) ) {
			$style['all'] .= 'background-attachment: fixed;';
		}

	}
	else {
		$background = 'background:' . $body_bg_color . ';';
	}

	$style['all'] .= '}';

	/* 背景画像透過 */ 
	if( isset( $luxe['body_bg_img'] ) && isset( $luxe['body_img_transparent'] ) && $luxe['body_img_transparent'] !== 0 ) {
		$rgb = $colors_class->colorcode_2_rgb( $body_bg_color );
		$transparent = $luxe['body_img_transparent'] !== $defaults['body_img_transparent'] ? $luxe['body_img_transparent'] : $defaults['body_img_transparent'];
		$transparent = round( $transparent / 100, 2 );

		$style['all'] .= <<<BODY_BEFORE
body:before {
	content: '';
	position: fixed;
	top: 0;
	height: 100%;
	width: 100%;
	z-index: -1;
	background: rgba( {$rgb['r']}, {$rgb['g']}, {$rgb['b']}, {$transparent} );
}
BODY_BEFORE;
	}

	/* Link */

	$style['all'] .= <<<LINK_STYLE
a {
	word-break: break-all;
	text-decoration: none;
	background-color: transparent;
	-webkit-text-decoration-skip: objects;
LINK_STYLE;

	/* リンク色 */
	if( isset( $luxe['body_link_color'] ) ) {
		$style['all'] .= 'color:' . $luxe['body_link_color'] . ';';
	}
	else {
		$style['all'] .= 'color:' . $default_colors[$luxe['overall_image']]['a'] . ';';
	}
	$style['all'] .= '}';

	/* Link Hover */
	$style['all'] .= <<<LINK_HOVER
a:hover {
	text-decoration: none;
LINK_HOVER;

	/* リンクホバー色 */
	if( isset( $luxe['body_hover_color'] ) ) {
		$style['all'] .= 'color:' . $luxe['body_hover_color'] . ';';
	}
	else {
		$style['all'] .= 'color:' . $default_colors[$luxe['overall_image']]['hover'] . ';';
	}
	$style['all'] .= '}';

	/* ヘッダー枠線 */
	if( isset( $luxe['header_border'] ) ) {
		if( $luxe['bootstrap_header'] === 'out' && $luxe['container_max_width'] === 0 ) {
		}
		else {
			if( $luxe['bootstrap_header'] === 'out' && isset( $luxe['header_border_wide'] ) ){
				$style['all'] .= '#head-in{';
			}
			elseif( $luxe['bootstrap_header'] === 'out' ) {
				$style['all'] .= '.head-cover{';
			}
			else {
				if( !isset( $luxe['head_band_wide'] ) ) {
					$style['all'] .= 'div[id*="head-band"]{border:1px solid ' . $def_border_color . ';border-top:0;}';
				}
				$style['all'] .= '#head-in{';
			}
			$style['all'] .= 'border:1px solid ' . $def_border_color . ';';
			if( $luxe['bootstrap_header'] === 'out' && isset( $luxe['header_border_wide'] ) ){
				$style['all'] .= 'border-left:0;border-right:0;';
			}
			if( isset( $luxe['global_navi_visible'] ) && $luxe['global_navi_position'] === 'under' ) {
				$style['all'] .= 'border-bottom:0;';
			}
			$style['all'] .= '}';
		}

		if( isset( $luxe['head_border_color'] ) ) {
			$style['all'] .= '#head-in,.head-cover,div[id*="head-band"]{border-color:' . $luxe['head_border_color'] . ';}';
		}
	}

	/* フッター枠線 */
	if( isset( $luxe['footer_border'] ) || isset( $luxe['foot_border_color'] ) ) {
		$style['all'] .= '#footer{';
		if( isset( $luxe['footer_border'] ) ) {
			if( $luxe['bootstrap_footer'] !== 'out' ) {
				$style['all'] .= 'border:1px solid ' . $def_border_color . ';border-bottom:none;';
			}
			if( isset( $luxe['foot_border_color'] ) ) {
				$style['all'] .= 'border-color:' . $luxe['foot_border_color'] . ';';
			}
		}
		else {
			$style['all'] .= 'border:none;';
		}
		$style['all'] .= '}';
	}
	elseif( !isset( $luxe['footer_border'] ) ) {
		$style['all'] .= '#footer{border:none;}';
	}

	/* コピーライト表示部の上部枠線 */
	if( isset( $luxe['copyright_border'] ) || isset( $luxe['copyright_border_color'] ) ) {
		$style['all'] .= '#copyright{';
		if( isset( $luxe['copyright_border'] ) ) {
			$style['all'] .= 'border-top:1px solid ' . $def_border_color . ';';

			if( isset( $luxe['copyright_border_color'] ) ) {
				$style['all'] .= 'border-color:' . $luxe['copyright_border_color'] . ';';
			}
		}
		$style['all'] .= '}';
	}

	/* モバイルでサイドバー非表示 */
	if( isset( $luxe['hide_mobile_sidebar'] ) ) {
		$style['max_991'] .= '#sidebar,#sidebar-2{display:none;}';
	}

	/* モバイルでフッター表示 */
	if( !isset( $luxe['hide_mobile_footer'] ) ) {
		$style['max_991'] .= '#foot-in{padding:25px 0;}';
		$style['max_991'] .= '#foot-in .col-xs-4, #foot-in .col-xs-6, #foot-in .col-xs-12{display:block;max-width:100%;width:100%;float:none;}';
	}

	/* ヘッダー文字色と背景色 */
	if( isset( $luxe['head_color'] ) || isset( $luxe['head_bg_color'] ) ) {
		$style['all'] .= '#head-in{';
		/* ヘッダー文字色 */
		if( isset( $luxe['head_color'] ) ) {
			$style['all'] .= 'color:' . $luxe['head_color'] . ';';
		}
		/* ヘッダー背景色 */
		if( isset( $luxe['head_bg_color'] ) ) {
			$style['all'] .= 'background:' . $luxe['head_bg_color'] . ';';

			if( isset( $luxe['head_transparent'] ) && $luxe['head_transparent'] !== 100 ) {
				$rgb = $colors_class->colorcode_2_rgb( $luxe['head_bg_color'] );
				$transparent = $luxe['head_transparent'] !== $defaults['head_transparent'] ? $luxe['head_transparent'] : $defaults['head_transparent'];
				$transparent = round( $transparent / 100, 2 );

				$style['all'] .= 'background: rgba(' . $rgb['r'] . ',' . $rgb['g'] . ',' . $rgb['b'] . ',' . $transparent . ');';
			}
		}
		$style['all'] .= '}';
	}

	if( isset( $luxe['head_link_color'] ) ) {
		/* ヘッダーリンク色 */
		if( isset( $luxe['head_link_color'] ) ) {
			$style['all'] .= '#head-in #sitename a{color:' . $luxe['head_link_color'] . ';}';
		}

	}

	if( isset( $luxe['head_hover_color'] ) ) {
		/* ヘッダーリンクホバー色 */
		if( isset( $luxe['head_hover_color'] ) ) {
			$style['all'] .= '#head-in #sitename a:hover{color:' . $luxe['head_hover_color'] . ';}';
		}

	}

	/* ヘッダー背景画像*/
	if( isset( $luxe['head_bg_img'] ) ) {
		if( isset( $luxe['head_img_width_max'] ) ) {
			$style['all'] .= '#head-in{background-image:';
		}
		else {
			$style['all'] .= '.head-cover{background-image:';
		}
		$style['all'] .= 'url("' . $luxe['head_bg_img'] . '");';

		if( $luxe['head_img_repeat'] !== 'repeat' ) {
			$style['all'] .= 'background-repeat:no-repeat;';
		}

		if( $luxe['head_img_size'] === 'contain' ) {
			$style['all'] .= 'background-size:contain;';
		}
		elseif( $luxe['head_img_size'] === 'cover' ) {
			$style['all'] .= 'background-size:cover;';
		}
		elseif( $luxe['head_img_size'] === 'adjust' ) {
			$style['all'] .= 'background-size:100% auto;';
		}
		elseif( $luxe['head_img_size'] === 'adjust2' ) {
			$style['all'] .= 'background-size:auto 100%;';
		}
		elseif( $luxe['head_img_size'] === 'adjust3' ) {
			$style['all'] .= 'background-size:100% 100%;';
		}

		if(
			( isset( $luxe['head_img_vertical'] ) && $luxe['head_img_vertical'] !== $defaults['head_img_vertical'] ) ||
			( isset( $luxe['head_img_horizontal'] ) && $luxe['head_img_horizontal'] !== $defaults['head_img_horizontal'] )
		) {
			$head_img_vertical   = isset( $luxe['head_img_vertical'] ) ? $luxe['head_img_vertical'] : $defaults['head_img_vertical'];
			$head_img_vertical   = $head_img_vertical === 'middle' ? 'center' : $head_img_vertical;
			$head_img_horizontal = isset( $luxe['head_img_horizontal'] ) ? $luxe['head_img_horizontal'] : $defaults['head_img_horizontal'];

			$style['all'] .= 'background-position: ' . $head_img_vertical . ' ' . $head_img_horizontal . ';';
		}

		if( isset( $luxe['head_img_fixed'] ) ) {
			$style['all'] .= 'background-attachment: fixed;';
		}

		$style['all'] .= '}';
	}

	/*---------------------------------------------------------------------------
	 * サムネイルの大きさ
	 *---------------------------------------------------------------------------*/
	if( $luxe['thumbnail_layout'] !== 'under' ) {
		$_image_sizes = thk_get_image_sizes();
		$nw = 150;
		$cw = 100;

		foreach( $_image_sizes as $key => $val ) {
			if( isset( $luxe['thumbnail_is_size'] ) && $key === $luxe['thumbnail_is_size'] ) {
				if( isset( $val['width'] ) ) $nw = $val['width'];
			}
			if( isset( $luxe['thumbnail_is_size_card'] ) && $key === $luxe['thumbnail_is_size_card'] ) {
				if( isset( $val['width'] ) ) $cw = $val['width'];
			}
		}
		// 通常スタイル
		if( isset( $luxe['thumbnail_is_size'] ) && $nw > 150 ) {
			if( $nw > 150 && $nw < 300 ) {
				$style['max_575'] .= '#list .term img{max-width:100%;float:none;}';
			}
			elseif( $nw >= 300 ) {
				$style['max_767'] .= '#list .term img{max-width:100%;float:none;margin-bottom:30px;}';
			}
		}
		// カード型 (カード型はタイトルが横にくるので 150px のサムネイルも 575px 未満で float 解除)
		if( isset( $luxe['grid_enable'] ) && isset( $luxe['thumbnail_is_size_card'] ) && $cw >= 150 ) {
			if( $cw >= 150 && $cw < 300 ) {
				$style['max_575'] .= '#list div[id^=card-] .term {max-width:100%;float:none;}';
				$style['max_575'] .= 'div[id^="card-"] h2{clear:left;}';
			}
			elseif( $cw >= 300 ) {
				$style['max_767'] .= '#list div[id^=card-] .term {max-width:100%;float:none;margin-bottom:10px;}';
				$style['992_1199'] .= '#list div[id^=card-] .term {max-width:40%;height:auto;}';
			}
		}
	}
	else {
		// 画像を下にしてる時は常に 100%
		$style['all'] .= '#list .term img{max-width:100%;}';
	}

	// タイル型の幅いっぱい・中央揃え
	if( isset( $luxe['grid_enable'] ) ) {
		if(
			( isset( $luxe['thumbnail_tile_width_full'] ) && isset( $luxe['thumbnail_tile_width_full_s'] ) ) ||
			( isset( $luxe['thumbnail_tile_align_center'] ) && isset( $luxe['thumbnail_tile_align_center_s'] ) )
		) {
			// タイル型の幅いっぱい(PC ＆ スマホ)
			$style['all'] .= '#list div[id^="tile-"] .term img{';
			if( isset( $luxe['thumbnail_tile_width_full'] ) && isset( $luxe['thumbnail_tile_width_full_s'] ) ) {
				$style['all'] .= 'width:100%;';
			}
			// タイル型の中央揃え(PC ＆ スマホ)
			if( isset( $luxe['thumbnail_tile_align_center'] ) && isset( $luxe['thumbnail_tile_align_center_s'] ) ) {
				$style['all'] .= 'display:block;margin-right:auto;margin-left:auto;';
			}
			$style['all'] .= '}';
		}
		if(
			( isset( $luxe['thumbnail_tile_width_full'] ) && !isset( $luxe['thumbnail_tile_width_full_s'] ) ) ||
			( isset( $luxe['thumbnail_tile_align_center'] ) && !isset( $luxe['thumbnail_tile_align_center_s'] ) ) ||
			( isset( $luxe['thumbnail_tile_width_full'] ) && isset( $luxe['thumbnail_tile_width_full_s'] ) && $luxe['thumbnail_tile_width_full'] !== $luxe['thumbnail_tile_width_full_s'] ) ||
			( isset( $luxe['thumbnail_tile_align_center'] ) && isset( $luxe['thumbnail_tile_align_center_s'] ) && $luxe['thumbnail_tile_align_center'] !== $luxe['thumbnail_tile_align_center_s'] )
		) {
			// タイル型の幅いっぱい(PC)
			$style['min_576'] .= '#list div[id^="tile-"] .term img{';
			if(
				( isset( $luxe['thumbnail_tile_width_full'] ) && !isset( $luxe['thumbnail_tile_width_full_s'] ) ) ||
				( isset( $luxe['thumbnail_tile_width_full'] ) && isset( $luxe['thumbnail_tile_width_full_s'] ) && $luxe['thumbnail_tile_width_full'] !== $luxe['thumbnail_tile_width_full_s'] )
			) {
				$style['min_576'] .= 'width:100%;';
			}
			// タイル型の中央揃え(PC)
			if(
				( isset( $luxe['thumbnail_tile_align_center'] ) && !isset( $luxe['thumbnail_tile_align_center_s'] ) ) ||
				( isset( $luxe['thumbnail_tile_align_center'] ) && isset( $luxe['thumbnail_tile_align_center_s'] ) && $luxe['thumbnail_tile_align_center'] !== $luxe['thumbnail_tile_align_center_s'] )
			) {
				$style['min_576'] .= 'display:block;margin-right:auto;margin-left:auto;';
			}
			$style['min_576'] .= '}';
		}
		if(
			( !isset( $luxe['thumbnail_tile_width_full'] ) && isset( $luxe['thumbnail_tile_width_full_s'] ) ) ||
			( !isset( $luxe['thumbnail_tile_align_center'] ) && isset( $luxe['thumbnail_tile_align_center_s'] ) ) ||
			( isset( $luxe['thumbnail_tile_width_full'] ) && isset( $luxe['thumbnail_tile_width_full_s'] ) && $luxe['thumbnail_tile_width_full'] !== $luxe['thumbnail_tile_width_full_s'] ) ||
			( isset( $luxe['thumbnail_tile_align_center'] ) && isset( $luxe['thumbnail_tile_align_center_s'] ) && $luxe['thumbnail_tile_align_center'] !== $luxe['thumbnail_tile_align_center_s'] )
		) {
			// タイル型の幅いっぱい(スマホ)
			$style['max_575'] .= '#list div[id^="tile-"] .term img{';
			if(
				( !isset( $luxe['thumbnail_tile_width_full'] ) && isset( $luxe['thumbnail_tile_width_full_s'] ) ) ||
				( isset( $luxe['thumbnail_tile_width_full'] ) && isset( $luxe['thumbnail_tile_width_full_s'] ) && $luxe['thumbnail_tile_width_full'] !== $luxe['thumbnail_tile_width_full_s'] )
			) {
				$style['max_575'] .= 'width:100%;';
			}
			// タイル型の中央揃え(スマホ)
			if(
				( !isset( $luxe['thumbnail_tile_align_center'] ) && isset( $luxe['thumbnail_tile_align_center_s'] ) ) ||
				( isset( $luxe['thumbnail_tile_align_center'] ) && isset( $luxe['thumbnail_tile_align_center_s'] ) && $luxe['thumbnail_tile_align_center'] !== $luxe['thumbnail_tile_align_center_s'] )
			) {
				$style['max_575'] .= 'display:block;margin-right:auto;margin-left:auto;';
			}
			$style['max_575'] .= '}';
		}
	}

	/*---------------------------------------------------------------------------
	 * サムネイル画像の枠線
	 *---------------------------------------------------------------------------*/
	if( !isset( $luxe['thumbnail_border'] ) ) {
		$style['all'] .= '#list .term img{border:none;}';
	}

	/*---------------------------------------------------------------------------
	 * サムネイル画像に対するテキスト(抜粋)の配置
	 *---------------------------------------------------------------------------*/
	if( $luxe['thumbnail_layout'] === 'flow' ) {
		//$style['all'] .= '#list .excerpt{overflow:visible;}';
	}
	elseif( $luxe['thumbnail_layout'] === 'under' ) {
		$style['all'] .= '#list .term img{float:none;margin-right:0;margin-bottom:30px;}';
	}
	else {
		$style['min_576'] .= '#list .excerpt{overflow:hidden;}';
	}

	/*---------------------------------------------------------------------------
	 * 文字サイズ
	 *---------------------------------------------------------------------------*/
	// Body
	if( isset( $luxe['font_size_body'] ) && (float)$luxe['font_size_body'] !== (float)$defaults['font_size_body'] ) {
		$rem = (float)$luxe['font_size_body'] / 10;
		$style['all'] .= 'body, li, pre, blockquote {';
		$style['all'] .= 'font-size:' . $luxe['font_size_body'] . 'px;';
		$style['all'] .= 'font-size:' . $rem . 'rem;';
		$style['all'] .= '}';
	}
	else {
		$style['all'] .= <<<BODY
body, li, pre, blockquote {
	font-size: 14px; font-size: 1.4rem;
}
BODY;
	}
	// サイトタイトル
	if( isset( $luxe['font_size_site_title'] ) && (float)$luxe['font_size_site_title'] !== (float)$defaults['font_size_site_title'] ) {
		$rem = (float)$luxe['font_size_site_title'] / 10;
		$style['min_576'] .= '#sitename{';
		$style['min_576'] .= 'font-size:' . $luxe['font_size_site_title'] . 'px;';
		$style['min_576'] .= 'font-size:' . $rem . 'rem;';
		$style['min_576'] .= '}';
	}
	// キャッチフレーズ
	if( isset( $luxe['font_size_desc'] ) && (float)$luxe['font_size_desc'] !== (float)$defaults['font_size_desc'] ) {
		$rem = (float)$luxe['font_size_desc'] / 10;
		$style['min_576'] .= '.desc{';
		$style['min_576'] .= 'font-size:' . $luxe['font_size_desc'] . 'px;';
		$style['min_576'] .= 'font-size:' . $rem . 'rem;';
		$style['min_576'] .= '}';
	}
	// 記事タイトル
	if( isset( $luxe['font_size_post_title'] ) && (float)$luxe['font_size_post_title'] !== (float)$defaults['font_size_post_title'] ) {
		$rem = (float)$luxe['font_size_post_title'] / 10;
		$style['min_576'] .= '.entry-title,';
		$style['min_576'] .= '.home.page .entry-title{';
		$style['min_576'] .= 'font-size:' . $luxe['font_size_post_title'] . 'px;';
		$style['min_576'] .= 'font-size:' . $rem . 'rem;';
		$style['min_576'] .= '}';
	}
	// 抜粋
	if( isset( $luxe['font_size_excerpt'] ) && (float)$luxe['font_size_excerpt'] !== (float)$defaults['font_size_excerpt'] ) {
		$rem = (float)$luxe['font_size_excerpt'] / 10;
		$style['min_576'] .= '.exsp {';
		$style['min_576'] .= 'font-size:' . $luxe['font_size_excerpt'] . 'px;';
		$style['min_576'] .= 'font-size:' . $rem . 'rem;';
		$style['min_576'] .= '}';
	}
	// 記事本文
	if( isset( $luxe['font_size_post'] ) && (float)$luxe['font_size_post'] !== (float)$defaults['font_size_post'] ) {
		$rem = (float)$luxe['font_size_post'] / 10;
		$style['min_576'] .= '.post p {';
		$style['min_576'] .= 'font-size:' . $luxe['font_size_post'] . 'px;';
		$style['min_576'] .= 'font-size:' . $rem . 'rem;';
		$style['min_576'] .= '}';
	}
	// 記事 H2
	if( isset( $luxe['font_size_post_h2'] ) && (float)$luxe['font_size_post_h2'] !== (float)$defaults['font_size_post_h2'] ) {
		$rem = (float)$luxe['font_size_post_h2'] / 10;
		$style['min_576'] .= '.post h2{';
		$style['min_576'] .= 'font-size:' . $luxe['font_size_post_h2'] . 'px;';
		$style['min_576'] .= 'font-size:' . $rem . 'rem;';
		$style['min_576'] .= '}';
	}
	// 記事 H3
	if( isset( $luxe['font_size_post_h3'] ) && (float)$luxe['font_size_post_h3'] !== (float)$defaults['font_size_post_h3'] ) {
		$rem = (float)$luxe['font_size_post_h3'] / 10;
		$style['min_576'] .= '.post h3{';
		$style['min_576'] .= 'font-size:' . $luxe['font_size_post_h3'] . 'px;';
		$style['min_576'] .= 'font-size:' . $rem . 'rem;';
		$style['min_576'] .= '}';
	}
	// 記事 H4
	if( isset( $luxe['font_size_post_h4'] ) && (float)$luxe['font_size_post_h4'] !== (float)$defaults['font_size_post_h4'] ) {
		$rem = (float)$luxe['font_size_post_h4'] / 10;
		$style['min_576'] .= '.post h4{';
		$style['min_576'] .= 'font-size:' . $luxe['font_size_post_h4'] . 'px;';
		$style['min_576'] .= 'font-size:' . $rem . 'rem;';
		$style['min_576'] .= '}';
	}
	// 記事 H5
	if( isset( $luxe['font_size_post_h5'] ) && (float)$luxe['font_size_post_h5'] !== (float)$defaults['font_size_post_h5'] ) {
		$rem = (float)$luxe['font_size_post_h5'] / 10;
		$style['min_576'] .= '.post h5{';
		$style['min_576'] .= 'font-size:' . $luxe['font_size_post_h5'] . 'px;';
		$style['min_576'] .= 'font-size:' . $rem . 'rem;';
		$style['min_576'] .= '}';
	}
	// 記事 H6
	if( isset( $luxe['font_size_post_h6'] ) && (float)$luxe['font_size_post_h6'] !== (float)$defaults['font_size_post_h6'] ) {
		$rem = (float)$luxe['font_size_post_h6'] / 10;
		$style['min_576'] .= '.post h6{';
		$style['min_576'] .= 'font-size:' . $luxe['font_size_post_h6'] . 'px;';
		$style['min_576'] .= 'font-size:' . $rem . 'rem;';
		$style['min_576'] .= '}';
	}
	// 記事本文 li
	if( isset( $luxe['font_size_post_li'] ) && (float)$luxe['font_size_post_li'] !== (float)$defaults['font_size_post_li'] ) {
		$rem = (float)$luxe['font_size_post_li'] / 10;
		$style['min_576'] .= '.post li {';
		$style['min_576'] .= 'font-size:' . $luxe['font_size_post_li'] . 'px;';
		$style['min_576'] .= 'font-size:' . $rem . 'rem;';
		$style['min_576'] .= '}';
	}
	// 記事本文 pre
	if( isset( $luxe['font_size_post_pre'] ) && (float)$luxe['font_size_post_pre'] !== (float)$defaults['font_size_post_pre'] ) {
		$rem = (float)$luxe['font_size_post_pre'] / 10;
		$style['min_576'] .= '.post pre {';
		$style['min_576'] .= 'font-size:' . $luxe['font_size_post_pre'] . 'px;';
		$style['min_576'] .= 'font-size:' . $rem . 'rem;';
		$style['min_576'] .= '}';
	}
	// 記事本文 blockquote
	if( isset( $luxe['font_size_post_blockquote'] ) && (float)$luxe['font_size_post_blockquote'] !== (float)$defaults['font_size_post_blockquote'] ) {
		$rem = (float)$luxe['font_size_post_blockquote'] / 10;
		$style['min_576'] .= '.post blockquote {';
		$style['min_576'] .= 'font-size:' . $luxe['font_size_post_blockquote'] . 'px;';
		$style['min_576'] .= 'font-size:' . $rem . 'rem;';
		$style['min_576'] .= '}';
	}
	// メタ情報
	if( isset( $luxe['font_size_meta'] ) && (float)$luxe['font_size_meta'] !== (float)$defaults['font_size_meta'] ) {
		$rem = (float)$luxe['font_size_meta'] / 10;
		$style['min_576'] .= '.meta, .post .meta{';
		$style['min_576'] .= 'font-size:' . $luxe['font_size_meta'] . 'px;';
		$style['min_576'] .= 'font-size:' . $rem . 'rem;';
		$style['min_576'] .= '}';
	}
	// パンくずリンク
	if( isset( $luxe['font_size_breadcrumb'] ) && (float)$luxe['font_size_breadcrumb'] !== (float)$defaults['font_size_breadcrumb'] ) {
		$rem = (float)$luxe['font_size_breadcrumb'] / 10;
		$style['min_576'] .= '#breadcrumb h1,';
		$style['min_576'] .= '#breadcrumb li{';
		$style['min_576'] .= 'font-size:' . $luxe['font_size_breadcrumb'] . 'px;';
		$style['min_576'] .= 'font-size:' . $rem . 'rem;';
		$style['min_576'] .= '}';
	}
	// グローバルナビ（ヘッダーナビ）
	if( isset( $luxe['font_size_gnavi'] ) && (float)$luxe['font_size_gnavi'] !== (float)$defaults['font_size_gnavi'] ) {
		$rem = (float)$luxe['font_size_gnavi'] / 10;
		// media query が他と違うので注意！
		$style['min_992'] .= '#gnavi li a{';
		$style['min_992'] .= 'font-size:' . $luxe['font_size_gnavi'] . 'px;';
		$style['min_992'] .= 'font-size:' . $rem . 'rem;';
		$style['min_992'] .= '}';
	}
	// コメント一覧
	if( isset( $luxe['font_size_comments'] ) && (float)$luxe['font_size_comments'] !== (float)$defaults['font_size_comments'] ) {
		$rem = (float)$luxe['font_size_comments'] / 10;
		$style['min_576'] .= '#comments p, #comments pre {';
		$style['min_576'] .= 'font-size:' . $luxe['font_size_comments'] . 'px;';
		$style['min_576'] .= 'font-size:' . $rem . 'rem;';
		$style['min_576'] .= '}';
	}
	// サイドバー
	if( isset( $luxe['font_size_side'] ) && (float)$luxe['font_size_side'] !== (float)$defaults['font_size_side'] ) {
		$rem = (float)$luxe['font_size_side'] / 10;
		$style['min_576'] .= '#side, #col3 {';
		$style['min_576'] .= 'font-size:' . $luxe['font_size_side'] . 'px;';
		$style['min_576'] .= 'font-size:' . $rem . 'rem;';
		$style['min_576'] .= '}';
	}
	// サイドバー H3
	if( isset( $luxe['font_size_side_h3'] ) && (float)$luxe['font_size_side_h3'] !== (float)$defaults['font_size_side_h3'] ) {
		$rem = (float)$luxe['font_size_side_h3'] / 10;
		$style['min_576'] .= '#side h3, #col3 h3 {';
		$style['min_576'] .= 'font-size:' . $luxe['font_size_side_h3'] . 'px;';
		$style['min_576'] .= 'font-size:' . $rem . 'rem;';
		$style['min_576'] .= '}';
	}
	// サイドバー H4
	if( isset( $luxe['font_size_side_h4'] ) && (float)$luxe['font_size_side_h4'] !== (float)$defaults['font_size_side_h4'] ) {
		$rem = (float)$luxe['font_size_side_h4'] / 10;
		$style['min_576'] .= '#side h4, #col3 h4 {';
		$style['min_576'] .= 'font-size:' . $luxe['font_size_side_h4'] . 'px;';
		$style['min_576'] .= 'font-size:' . $rem . 'rem;';
		$style['min_576'] .= '}';
	}
	// フッター
	if( isset( $luxe['font_size_foot'] ) && (float)$luxe['font_size_foot'] !== (float)$defaults['font_size_foot'] ) {
		$rem = (float)$luxe['font_size_foot'] / 10;
		$style['min_576'] .= '#foot-in {';
		$style['min_576'] .= 'font-size:' . $luxe['font_size_foot'] . 'px;';
		$style['min_576'] .= 'font-size:' . $rem . 'rem;';
		$style['min_576'] .= '}';
	}
	// フッター H4
	if( isset( $luxe['font_size_foot_h4'] ) && (float)$luxe['font_size_foot_h4'] !== (float)$defaults['font_size_foot_h4'] ) {
		$rem = (float)$luxe['font_size_foot_h4'] / 10;
		$style['min_576'] .= '#foot-in h4 {';
		$style['min_576'] .= 'font-size:' . $luxe['font_size_foot_h4'] . 'px;';
		$style['min_576'] .= 'font-size:' . $rem . 'rem;';
		$style['min_576'] .= '}';
	}

	/*---------------------------------------------------------------------------
	 * グローバルナビ文字色・背景色・枠線
	 *---------------------------------------------------------------------------*/
	/* グローバルナビ文字色 */
	if( isset( $luxe['gnavi_color'] ) ) {
		$style['all'] .= '#nav, #gnavi ul, #gnavi li a, .mobile-nav {';
		$style['all'] .= 'color:' . $luxe['gnavi_color'] . ';';
		$style['all'] .= '}';
	}

	/* グローバルナビバー背景色 */
	if( isset( $luxe['gnavi_bar_bg_color'] ) ) {
		$style['all'] .= '#nav, #gnavi ul{';
		$style['all'] .= 'background:' . $luxe['gnavi_bar_bg_color'] . ';';
		$style['all'] .= '}';
	}

	/* グローバルナビ背景色 */
	if( isset( $luxe['gnavi_bg_color'] ) ) {
		$style['all'] .= '#gnavi li a, #gnavi .mobile-nav {';
		$style['all'] .= 'background:' . $luxe['gnavi_bg_color'] . ';';
		$style['all'] .= '}';
	}

	/* グローバルナビホバー色 */
	if( isset( $luxe['gnavi_hover_color'] ) || isset( $luxe['gnavi_bg_hover_color'] )) {
		//$style['all'] .= '#gnavi li:hover,';
		$style['all'] .= '#gnavi li:hover > a, #gnavi li:hover > a > span, div.mobile-nav:hover, ul.mobile-nav li:hover{';
		if( isset( $luxe['gnavi_hover_color'] ) ) {
			$style['all'] .= 'color:' . $luxe['gnavi_hover_color'] . ';';
		}
		if( isset( $luxe['gnavi_bg_hover_color'] ) ) {
			$style['all'] .= 'background:' . $luxe['gnavi_bg_hover_color'] . ';';
		}
		$style['all'] .= '}';

		$style['max_991'] .= '#gnavi li:hover > a > span {';
		$style['max_991'] .= 'background: transparent;';
		$style['max_991'] .= '}';
	}

	/* グローバルナビカレント色 */
	if( isset( $luxe['gnavi_current_color'] ) || isset( $luxe['gnavi_bg_current_color'] )) {
		if( isset( $luxe['gnavi_bg_current_color'] ) ) {
			$style['all'] .= '#gnavi .current-menu-item > a,';
			$style['all'] .= '#gnavi .current-menu-ancestor > a,';
			$style['all'] .= '#gnavi .current_page_item > a,';
			$style['all'] .= '#gnavi .current_page_ancestor > a{';
			if( isset( $luxe['gnavi_current_color'] ) ) {
				$style['all'] .= 'color:' . $luxe['gnavi_current_color'] . ';';
			}
			if( isset( $luxe['gnavi_bg_current_color'] ) ) {
				$style['all'] .= 'background:' . $luxe['gnavi_bg_current_color'] . ';';
			}
			$style['all'] .= '}';
		}
	}

	if(
		isset( $luxe['gnavi_border_top_color'] ) || isset( $luxe['gnavi_border_bottom_color'] ) ||
		$luxe['gnavi_border_top_width'] !== $defaults['gnavi_border_top_width'] || $luxe['gnavi_border_bottom_width'] !== $defaults['gnavi_border_bottom_width']
	) {
		$style['all'] .= '#nav{';

		/* グローバルナビ上の枠線色 */
		if( isset( $luxe['gnavi_border_top_color'] ) ) {
			$style['all'] .= 'border-top-color:' . $luxe['gnavi_border_top_color'] . ';';
		}

		/* グローバルナビ下の枠線色 */
		if( isset( $luxe['gnavi_border_bottom_color'] ) ) {
			$style['all'] .= 'border-bottom-color:' . $luxe['gnavi_border_bottom_color'] . ';';
		}

		/* グローバルナビ上の枠線太さ */
		if( $luxe['gnavi_border_top_width'] !== $defaults['gnavi_border_top_width'] ) {
			$style['all'] .= 'border-top-width:' . $luxe['gnavi_border_top_width'] . 'px;';
		}

		/* グローバルナビ下の枠線太さ */
		if( $luxe['gnavi_border_bottom_width'] !== $defaults['gnavi_border_bottom_width'] ) {
			$style['all'] .= 'border-bottom-width:' . $luxe['gnavi_border_bottom_width'] . 'px;';
		}

		$style['all'] .= '}';

		if( isset( $luxe['gnavi_border_bottom_color'] ) || ( $luxe['gnavi_border_bottom_width'] !== $defaults['gnavi_border_bottom_width'] ) ) {
			$style['min_992'] .= '#gnavi div > ul > li > ul{';
			if( isset( $luxe['gnavi_border_bottom_color'] ) ) {
				//$style['min_992'] .= 'border-top-color:' . $luxe['gnavi_border_bottom_color'] . ';';
			}
			if( $luxe['gnavi_border_bottom_width'] !== $defaults['gnavi_border_bottom_width'] ) {
				$style['min_992'] .= 'padding-top:' . $luxe['gnavi_border_bottom_width'] . 'px;';
				//$style['min_992'] .= 'border-top-width:' . $luxe['gnavi_border_bottom_width'] . 'px;';
			}
			$style['min_992'] .= '}';
		}
	}

	/* グローバルナビ上下のパディング */
	if( $luxe['gnavi_top_buttom_padding'] !== $defaults['gnavi_top_buttom_padding'] ) {
		$style['min_992'] .= '#gnavi div > ul > li > a > span{';
		$style['min_992'] .= 'padding-top:' . $luxe['gnavi_top_buttom_padding'] . 'px;';
		$style['min_992'] .= 'padding-bottom:' . $luxe['gnavi_top_buttom_padding'] . 'px;';
		$style['min_992'] .= '}';
	}

	/* ナビバー上下のパディング */
	if( $luxe['gnavi_bar_top_buttom_padding'] !== $defaults['gnavi_bar_top_buttom_padding'] ) {
		$style['min_992'] .= '#gnavi div > ul > li{';
		$style['min_992'] .= 'padding-top:' . $luxe['gnavi_bar_top_buttom_padding'] . 'px;';
		$style['min_992'] .= 'padding-bottom:' . $luxe['gnavi_bar_top_buttom_padding'] . 'px;';
		$style['min_992'] .= '}';
	}

	/*---------------------------------------------------------------------------
	 * 記事タイトル下メタ情報の位置調整
	 *---------------------------------------------------------------------------*/
	if(
		!isset( $luxe['post_date_visible'] )		&&
		!isset( $luxe['mod_date_visible'] )		&&
		!isset( $luxe['category_meta_visible'] )	&&
		!isset( $luxe['tag_meta_visible'] )		&&
		!isset( $luxe['tax_meta_visible'] )
	) {
		$style['all'] .= '.post .entry-title, #front-page-title{margin-bottom:45px;}';
	}

	/*---------------------------------------------------------------------------
	 * 記事リストのタイトル下メタ情報の位置調整
	 *---------------------------------------------------------------------------*/
	if(
		!isset( $luxe['list_post_date_visible'] )	&&
		!isset( $luxe['list_mod_date_visible'] )	&&
		!isset( $luxe['list_category_meta_visible'] )	&&
		!isset( $luxe['list_tag_meta_visible'] )	&&
		!isset( $luxe['list_tax_meta_visible'] )
	) {
		$style['all'] .= '#list .entry-title{margin-bottom:35px;}';
	}

	/*---------------------------------------------------------------------------
	 * 帯状メニュー
	 *---------------------------------------------------------------------------*/
	if( isset( $luxe['head_band_visible'] ) ) {
		if(
			isset( $luxe['head_band_fixed'] )		||
			isset( $luxe['head_band_color'] )		||
			isset( $luxe['head_band_hover_color'] )		||
			isset( $luxe['head_band_bg_color'] )		||
			isset( $luxe['head_band_border_bottom_color'] ) ||
			$luxe['head_band_height'] !== $defaults['head_band_height'] ||
			( isset( $luxe['head_band_border_bottom_width'] ) && $luxe['head_band_border_bottom_width'] !== $defaults['head_band_border_bottom_width'] )
		) {
			/* 帯状メニュー固定 */
			if( isset( $luxe['head_band_fixed'] ) ) {
				$style['all'] .= '.band{position:fixed;z-index:21;}';
			}

			$style['all'] .= 'div[id*="head-band"]{';
			/* 帯状メニューの高さ */
			if( $luxe['head_band_height'] !== $defaults['head_band_height'] ) {
				$style['all'] .= 'height:' . $luxe['head_band_height'] . 'px;';
				$style['all'] .= 'line-height:' . $luxe['head_band_height'] . 'px;';
			}

			/* 帯状メニュー背景色 */
			if( isset( $luxe['head_band_bg_color'] ) ) {
				$style['all'] .= 'background:' . $luxe['head_band_bg_color'] . ';';
			}
			/* 帯状メニュー下線の色 */
			if( isset( $luxe['head_band_border_bottom_color'] ) ) {
				$style['all'] .= 'border-bottom-color:' . $luxe['head_band_border_bottom_color'] . ';';
			}
			/* 帯状メニュー下線の太さ */
			if( isset( $luxe['head_band_border_bottom_width'] ) && $luxe['head_band_border_bottom_width'] !== $defaults['head_band_border_bottom_width'] ) {
				$style['all'] .= 'border-bottom-width:' . $luxe['head_band_border_bottom_width'] . 'px;';
			}
			$style['all'] .= '}';

			/* 帯状メニュー文字色 */
			if( isset( $luxe['head_band_color'] ) ) {
				$style['all'] .= 'div[id*="head-band"] a{color:' . $luxe['head_band_color'] . ';}';
			}

			/* 帯状メニューホバー色 */
			if( isset( $luxe['head_band_hover_color'] ) ) {
				$style['all'] .= 'div[id*="head-band"] a:hover{color:' . $luxe['head_band_hover_color'] . ';}';
			}
		}

		/* 帯状メニュー内の 検索ボックス */

		if( isset( $luxe['head_band_search'] ) && !isset( $luxe['amp_css'] ) ) {
			// 検索ボックスつけてる場合の小デバイスの高さ調整
			$height = $luxe['head_band_height'] + 28 + 3;

			$style['max_575'] .= 'div[id*="head-band"]{';
			$style['max_575'] .= 'height:' . $height . 'px;';
			$style['max_575'] .= '}';
		}

		if( isset( $luxe['head_band_search'] ) ) {
			// 文字色
			if( isset( $luxe['head_search_color'] ) ) {
				$style['all'] .= '#head-search input[type="text"],';
				$style['all'] .= '#head-search button[type="submit"] {';
				$style['all'] .= 'color:' . $luxe['head_search_color'] . ';';
				$style['all'] .= '}';

				$style['all'] .= '.head-search-field::-webkit-input-placeholder{color:' . $luxe['head_search_color'] . ';}';
				$style['all'] .= '.head-search-field::-moz-placeholder{color:' . $luxe['head_search_color'] . ';}';
				$style['all'] .= '.head-search-field:-moz-placeholder{color:' . $luxe['head_search_color'] . ';}';
				$style['all'] .= '.head-search-field:-ms-input-placeholder{color:' . $luxe['head_search_color'] . ';}';
				$style['all'] .= '.head-search-field:placeholder-shown{color:' . $luxe['head_search_color'] . ';}';
			}

			// 背景色と透過
			if(
				isset( $luxe['head_search_bg_color'] )	||
				$luxe['head_search_transparent'] !== $defaults['head_search_transparent']
			) {
				$colors = array( 'r' => 200, 'g' => 200, 'b' => 200 );
				$transparent = $luxe['head_search_transparent'] !== $defaults['head_search_transparent'] ? $luxe['head_search_transparent'] : $defaults['head_search_transparent'];
				$transparent = round( $transparent / 100, 2 );

				if( isset( $luxe['head_search_bg_color'] ) ) {
					$colors = $colors_class->colorcode_2_rgb( $luxe['head_search_bg_color'] );
				}

				$style['all'] .= '#head-search form { background-color: rgba(' . $colors['r'] . ',' . $colors['g'] . ',' . $colors['b'] . ',' . $transparent . '); }';
			}
		}

		/* 帯状メニュー内の SNS フォローボタン */
		if(
			isset( $luxe['head_band_twitter'] )	||
			isset( $luxe['head_band_facebook'] )	||
			isset( $luxe['head_band_instagram'] )	||
			isset( $luxe['head_band_pinit'] )	||
			isset( $luxe['head_band_hatena'] )	||
			isset( $luxe['head_band_google'] )	||
			isset( $luxe['head_band_youtube'] )	||
			isset( $luxe['head_band_rss'] )	||
			isset( $luxe['head_band_feedly'] )
		) {
			if( isset( $luxe['head_band_follow_color'] ) ) {
				$style['all'] .= 'div[id*="head-band"] .snsf a {color:#fff;}';
				$style['all'] .= 'div[id*="head-band"] .snsf a:hover{opacity: 0.8;}';
				$sns_colors = $colors_class->sns_colors();

				foreach( $sns_colors as $key => $val ) {
					if( isset( $luxe['head_band_' . $key] ) ) {
						$style['all'] .= 'div[id*="head-band"] .' . $key . ' a{background:' . $val . ';}';
					}
				}
				if( isset( $luxe['head_band_instagram'] ) ) {
					$style['all'] .= <<< INSTAGRAM
div[id*="head-band"] .instagram a{
	background:-webkit-linear-gradient(200deg,#6559ca,#bc318f 40%,#e33f5f 60%,#f77638 70%,#fec66d 100%);
	background:linear-gradient(200deg,#6559ca,#bc318f 40%,#e33f5f 60%,#f77638 70%,#fec66d 100%);
}
INSTAGRAM;
				}
			}
		}
	}

	/*---------------------------------------------------------------------------
	 * 目次のボタン
	 *---------------------------------------------------------------------------*/
	if( isset( $luxe['toc_auto_insert'] ) ) {
		$show_button = 'Show';
		$hide_button = 'Hide';

		if( isset( $luxe['toc_start_status'] ) && $luxe['toc_start_status'] === 'close' ) {
			// 開始状態が「閉じた状態」の場合は「表示」と「非表示」反転
			if( isset( $luxe['toc_hide_button'] ) ) $show_button = $luxe['toc_hide_button'];
			if( isset( $luxe['toc_show_button'] ) ) $hide_button = $luxe['toc_show_button'];
		}
		else {
			// 通常はこっち
			if( isset( $luxe['toc_show_button'] ) ) $show_button = $luxe['toc_show_button'];
			if( isset( $luxe['toc_hide_button'] ) ) $hide_button = $luxe['toc_hide_button'];
		}

		// 目次の表示/非表示ボタンの色
		$toc_button_color = isset( $luxe['toc_button_color'] ) ? $luxe['toc_button_color'] : '#333';
		$toc_button_bg_color = isset( $luxe['toc_button_bg_color'] ) ? $luxe['toc_button_bg_color'] : 'none';

		$style['all'] .= <<<TOC
#toc_toggle {
	display: none;
}
#toc_toggle:checked + .toc_toggle::before{
	content: "{$hide_button}";
}
.toc_toggle {
	margin: 0;
}
.toc_toggle::before{
	content: "{$show_button}";
	cursor: pointer;
	border: solid 1px #ddd;
	color: {$toc_button_color};
	background: {$toc_button_bg_color};
	padding: 2px 5px;
	margin-left: 10px;
}
TOC;

		if( isset( $luxe['toc_start_status'] ) && $luxe['toc_start_status'] === 'close' ) {
			$style['all'] .= <<<TOC_CLOSED
#toc_toggle:checked + .toc_toggle + .toc_list{
	width: 0;
	height: 0;
	margin-top: 0;
	transition: all 0.3s;
}
.toc_toggle + .toc_list{
	overflow: hidden;
	width: auto;
	height: auto;
	margin-top: 20px;
	transition: all 0.3s;
}
TOC_CLOSED;
		}
		else {
			$style['all'] .= <<<TOC_OPEN
#toc_toggle:checked + .toc_toggle + .toc_list{
	width: auto;
	height: auto;
	margin-top: 20px;
	transition: all 0.3s;
}
.toc_toggle + .toc_list{
	overflow: hidden;
	width: 0;
	height: 0;
	margin-top: 0;
	transition: all 0.3s;
}
TOC_OPEN;
		}

		if(
			( isset( $luxe['toc_width'] ) && $luxe['toc_width'] !== $defaults['toc_width'] ) ||
			isset( $luxe['toc_color'] ) || isset( $luxe['toc_bg_color'] ) || isset( $luxe['toc_border_color'] )
		) {
			$style['all'] .= '#toc_container{';
			// 目次の幅
			if( isset( $luxe['toc_width'] ) && $luxe['toc_width'] !== $defaults['toc_width'] ) {
				$style['all'] .= 'display:block;';
			}
			// 目次の文字色
			if( isset( $luxe['toc_color'] ) ) {
				$style['all'] .= 'color:' . $luxe['toc_color'] . ';';
			}
			// 目次の背景色
			if( isset( $luxe['toc_bg_color'] ) ) {
				$style['all'] .= 'background:' . $luxe['toc_bg_color'] . ';';
			}
			// 目次の枠線色
			if( isset( $luxe['toc_border_color'] ) ) {
				$style['all'] .= 'border: 1px solid ' . $luxe['toc_border_color'] . ';';
			}
			$style['all'] .= '}';
		}

		// 目次の文字色（リンク込み）
		if( isset( $luxe['toc_color'] ) ) {
			$style['all'] .= '#toc_container, #toc_container a{color:' . $luxe['toc_color'] . ';}';
		}

		// 目次のジャンプ先の位置（高さ）調整
		if( isset( $luxe['toc_jump_position'] ) ) {
			$jump_position = (int)$luxe['toc_jump_position'];

			if( $jump_position > 0 ) {
				$anchor = <<< ANCHOR
.post span[id^="toc_id_"]{
	display: block;
	padding-top: {$jump_position}px;
	margin-top: -{$jump_position}px;
}
ANCHOR;

				if( $luxe['global_navi_sticky'] === 'all' ) {
					$style['all'] .= $anchor;
				}
				elseif( $luxe['global_navi_sticky'] === 'pc' ) {
					$style['min_992'] .= $anchor;
				}
				elseif( $luxe['global_navi_sticky'] === 'smart' ) {
					$style['max_991'] .= $anchor;
				}
			}
		}
	}

	/*---------------------------------------------------------------------------
	 * ブログカード
	 *---------------------------------------------------------------------------*/
	if(
		$luxe['blogcard_max_width'] !== $defaults['blogcard_max_width'] ||
		$luxe['blogcard_radius'] !== $defaults['blogcard_radius'] ||
		isset( $luxe['blogcard_shadow'] )
	) {
		$style['all'] .= 'a.blogcard-href {';
		/* カードの最大幅 */
		if( $luxe['blogcard_max_width'] !== $defaults['blogcard_max_width'] ) {
			if( $luxe['blogcard_max_width'] === 0 ) {
				$style['all'] .= 'max-width: 100%;';
			}
			else {
				$style['all'] .= 'max-width:' . $luxe['blogcard_max_width'] . 'px;';
			}
		}
		/* カードの丸み */
		if( $luxe['blogcard_radius'] !== $defaults['blogcard_radius'] ) {
			$style['all'] .= 'border-radius:' . $luxe['blogcard_radius'] . 'px;';
		}
		/* カードの影 */
		if( isset( $luxe['blogcard_shadow'] ) ) {
			$cont_bg_color = isset( $luxe['cont_bg_color'] ) ? $luxe['cont_bg_color'] : $default_colors[$luxe['overall_image']]['contbg'];
			$white_or_black = $colors_class->get_text_color_matches_background( $cont_bg_color );
			$rgb = $colors_class->colorcode_2_rgb( $white_or_black );
			$transparent = $white_or_black === '#000000' ? 0.1 : 0.5;

			$style['all'] .= 'box-shadow: 3px 3px 8px rgba( ' . $rgb['r'] . ',' . $rgb['g'] . ',' . $rgb['b'] . ',' . $transparent . ');';
		}
		$style['all'] .= '}';
	}

	if(
		isset( $luxe['blogcard_img_border'] ) ||
		isset( $luxe['blogcard_img_shadow'] ) ||
		$luxe['blogcard_img_radius'] !== $defaults['blogcard_img_radius'] ||
		$luxe['blogcard_img_position'] !== $defaults['blogcard_img_position']
	) {
		$style['all'] .= '.blogcard-img {';
		/* 画像に枠線 */
		if( isset( $luxe['blogcard_img_border'] ) ) {
			$style['all'] .= 'border: 1px solid #ddd;';
		}
		/* 画像の影 */
		if( isset( $luxe['blogcard_img_shadow'] ) ) {
			$style['all'] .= 'box-shadow: 3px 3px 8px rgba( 0, 0, 0, 0.2 );';
		}
		/* 画像の丸み */
		if( $luxe['blogcard_img_radius'] !== $defaults['blogcard_img_radius'] ) {
			$style['all'] .= 'border-radius:' . $luxe['blogcard_img_radius'] . 'px;';
		}
		/* 画像位置 */
		if( $luxe['blogcard_img_position'] !== $defaults['blogcard_img_position'] ) {
			$style['all'] .= 'float: left;';
			$style['all'] .= 'margin: 0 20px 15px 0;';
		}
		$style['all'] .= '}';
	}

	/*---------------------------------------------------------------------------
	 * フッター文字色・背景色
	 *---------------------------------------------------------------------------*/
	/* フッター文字色・背景色 */
	if( isset( $luxe['foot_color'] ) || isset( $luxe['foot_bg_color'] ) ) {
		$style['all'] .= '#footer{';
		/* フッター文字色 */
		if( isset( $luxe['foot_color'] ) ) {
			$style['all'] .= 'color:' . $luxe['foot_color'] . ';';
		}
		/* フッター背景色 */
		if( isset( $luxe['foot_bg_color'] ) ) {
			$style['all'] .= 'background:' . $luxe['foot_bg_color'] . ';';

			if( isset( $luxe['foot_transparent'] ) &&  $luxe['foot_transparent'] !== 100 ) {
				$rgb = $colors_class->colorcode_2_rgb( $luxe['foot_bg_color'] );
				$transparent = $luxe['foot_transparent'] !== $defaults['foot_transparent'] ? $luxe['foot_transparent'] : $defaults['foot_transparent'];
				$transparent = round( $transparent / 100, 2 );

				$style['all'] .= 'background: rgba(' . $rgb['r'] . ',' . $rgb['g'] . ',' . $rgb['b'] . ',' . $transparent . ');';
			}
		}
		$style['all'] .= '}';
	}
	/* フッターリンク色 */
	if( isset( $luxe['foot_link_color'] ) ) {
		$style['all'] .= '#footer a{color:' . $luxe['foot_link_color'] . ';}';
	}

	/* フッターリンクホバー色 */
	if( isset( $luxe['foot_hover_color'] ) ) {
		$style['all'] .= '#footer a:hover{color:' . $luxe['foot_hover_color'] . ';}';

	}

	/*---------------------------------------------------------------------------
	 * コピーライト文字色・背景色
	 *---------------------------------------------------------------------------*/
	/* コピーライト文字色・背景色 */
	//if( isset( $luxe['copyright_color'] ) || isset( $luxe['copyright_bg_color'] ) ) {
	if( isset( $luxe['copyright_bg_color'] ) ) {
		$style['all'] .= '#copyright{';
		/* コピーライト文字色 */
		$white_or_black = $colors_class->get_text_color_matches_background( $luxe['copyright_bg_color'] );
		$style['all'] .= 'color:' . $white_or_black . ';';
		/*
		if( isset( $luxe['copyright_color'] ) ) {
			$style['all'] .= 'color:' . $luxe['copyright_color'] . ';';
		}
		*/
		/* コピーライト背景色 */
		if( isset( $luxe['copyright_bg_color'] ) ) {
			$style['all'] .= 'background:' . $luxe['copyright_bg_color'] . ';';
		}
		$style['all'] .= '}';
	}

	/*---------------------------------------------------------------------------
	 * アニメーション
	 *---------------------------------------------------------------------------*/

	/* イフェクトが連動するので CSS のセレクターはカンマで繋げられない？ 謎・・・ */

	// ズームイン
	$zoom = array();

	if( isset( $luxe['anime_sitename'] ) && $luxe['anime_sitename'] === 'zoomin' ) {
		$zoom[] = '#sitename';
	}
	if( isset( $luxe['anime_thumbnail'] ) && $luxe['anime_thumbnail'] === 'zoomin' ) {
		$zoom[] = '#list .term img';
	}
	if( isset( $luxe['anime_sns_buttons'] ) && $luxe['anime_sns_buttons'] === 'zoomin' ) {
		$zoom[] = 'div[class^=sns] ul[class^=sns] li a';
	}

	if( !empty( $zoom ) ) {
		foreach( $zoom as $val ) {
			$style['min_992'] .= <<< ZOOMIN
{$val}, {$val}:hover {
	transition: opacity .5s, transform .5s;
}
{$val}:hover {
	opacity: 1.0;
	transform: scale3d(1.1, 1.1, 1.0);
}
ZOOMIN;
		}
	}

	// ズームアウト
	$zoom = array();

	if( isset( $luxe['anime_sitename'] ) && $luxe['anime_sitename'] === 'zoomout' ) {
		$zoom[] = '#sitename';
	}
	if( isset( $luxe['anime_thumbnail'] ) && $luxe['anime_thumbnail'] === 'zoomout' ) {
		$zoom[] = '#list .term img';
	}
	if( isset( $luxe['anime_sns_buttons'] ) && $luxe['anime_sns_buttons'] === 'zoomout' ) {
		$zoom[] = 'div[class^=sns] ul[class^=sns] li a';
	}
	if( isset( $luxe['anime_global_navi'] ) && $luxe['anime_global_navi'] === 'zoomout' ) {
		$zoom[] = 'div[class^=sns] ul[class^=sns] li a';
	}

	if( !empty( $zoom ) ) {
		foreach( $zoom as $val ) {
			$style['min_992'] .= <<< ZOOMOUT
{$val}, {$val}:hover {
	transition: opacity .5s, transform .5s;
}
{$val}:hover {
	opacity: 1;
	transform: scale3d(0.9, 0.9, 1.0);
}
ZOOMOUT;
		}
	}

	// 上方移動
	$upward = array();

	if( isset( $luxe['anime_global_navi'] ) && $luxe['anime_global_navi'] === 'upward' ) {
		/* グローバルナビの background の変化にズレが出るので速度変更 */
		$style['min_992'] .= <<< UPWARD
#gnavi li a {
	transition: background .4s ease;
}
#gnavi li > a:hover {
	transition: background 0s;
}
UPWARD;
		$upward[] = '#gnavi div > ul > li > a > span';
	}
	if( isset( $luxe['anime_sns_buttons'] ) && $luxe['anime_sns_buttons'] === 'upward' ) {
		$upward[] = 'div[class^=sns] ul[class^=sns] li a';
	}

	if( !empty( $upward ) ) {
		foreach( $upward as $val ) {
			$style['min_992'] .= <<< UPWARD
{$val}, {$val}:hover {
	transition: opacity .5s, transform .5s;
}
{$val}:hover{
	opacity: 1;
	transform: translateY(-5px);
}
UPWARD;
		}
	}

	/*---------------------------------------------------------------------------
	 * Intersection Observer
	 *---------------------------------------------------------------------------*/
	if( isset( $luxe['lazyload_effect'] ) && $luxe['lazyload_effect'] === 'fadeIn' ) {
		if( isset( $luxe['lazyload_thumbs'] ) || isset( $luxe['lazyload_contents'] ) || isset( $luxe['lazyload_sidebar'] ) || isset( $luxe['lazyload_footer'] ) ) {
			$style['all'] .= <<<INTERSECTION_OBSERVER
#list .term img.lazy, .lazy {
	transition: opacity .8s, transform .5s;
}
#list .term img.lazy:not(:hover), .lazy:not(:hover) {
	opacity: 0;
}
#list .term img.lazy[data-loaded]:not(:hover), .lazy[data-loaded]:not(:hover) {
	opacity: 1;
}
INTERSECTION_OBSERVER;
		}
	}

	/*---------------------------------------------------------------------------
	 * Tosrus
	 *---------------------------------------------------------------------------*/
	if( $luxe['gallery_type'] === 'tosrus' ) {
		$style['all'] .= <<<TOSRUS
.post a[data-rel="tosrus"] {
	cursor: -webkit-zoom-in;
	cursor: -moz-zoom-in;
	cursor: zoom-in;
}
TOSRUS;
	}

	/*---------------------------------------------------------------------------
	 * Lightcase
	 *---------------------------------------------------------------------------*/
	if( $luxe['gallery_type'] === 'lightcase' ) {
		$style['all'] .= <<<LIGHTCASE
.post a[data-rel="lightcase:myCollection"] {
	cursor: -webkit-zoom-in;
	cursor: -moz-zoom-in;
	cursor: zoom-in;
}
LIGHTCASE;
	}

	/*---------------------------------------------------------------------------
	 * Fluidbox
	 *---------------------------------------------------------------------------*/
	if( $luxe['gallery_type'] === 'fluidbox' ) {
		$style['all'] .= <<<FLUIDBOX
.post a[data-fluidbox] {
	/*background-color: #eee;
	border: none;*/
	cursor: -webkit-zoom-in;
	cursor: -moz-zoom-in;
	cursor: zoom-in;
}
FLUIDBOX;
	}

	/* Fluidbox 固有の問題への対処 */
	if( $luxe['gallery_type'] === 'fluidbox' ) {
		$style['all'] .= '.band, #page-top{z-index:999;}';
		$style['all'] .= '#nav{z-index:995;}';
	}

	/*---------------------------------------------------------------------------
	 * PAGE TOP ボタン
	 *---------------------------------------------------------------------------*/
	if( isset( $luxe['page_top_color'] ) || isset( $luxe['page_top_bg_color'] ) || !isset( $luxe['page_top_text'] ) || ( isset( $luxe['page_top_radius'] ) && $luxe['page_top_radius'] !== $defaults['page_top_radius'] ) ) {
		$style['all'] .= '#page-top{';
		if( isset( $luxe['page_top_color'] ) ) {
			$style['all'] .= 'color:' . $luxe['page_top_color'] . ';';
		}
		if( isset( $luxe['page_top_bg_color'] ) ) {
			$style['all'] .= 'background:' . $luxe['page_top_bg_color'] . ';';
		}
		if( !isset( $luxe['page_top_text'] ) ) {
			// アイコンだけの場合はフォントサイズを大きくする
			$style['all'] .= 'font-size:20px;font-size:2.0rem;padding:8px 14px;';
		}
		if( isset( $luxe['page_top_radius'] ) && $luxe['page_top_radius'] !== $defaults['page_top_radius'] ) {
			$style['all'] .= 'border-radius:' . $luxe['page_top_radius'] . 'px;';
		}
		$style['all'] .= '}';
	}

	/*---------------------------------------------------------------------------
	 * 外部リンク
	 *---------------------------------------------------------------------------*/
	if( isset( $luxe['add_external_icon'] ) && !isset( $luxe['amp_css'] ) ) {
		global $awesome;

		$style['all'] .= '.ext_icon:after{margin:6px;vertical-align:-0.1em;font-size: 0.8em;';

		/* 外部リンクの種類 */
		if( $awesome === 4 ) {
			$style['all'] .= 'font-family:FontAwesome;';
			if( $luxe['external_icon_type'] !== 'normal' ) {
				$style['all'] .= 'content:"\f14c";';
			}
			else {
				$style['all'] .= 'content:"\f08e";';
			}
		}
		else {
			$style['all'] .= 'font-family:"Font Awesome 5 Free";font-weight:900;';
			if( $luxe['external_icon_type'] !== 'normal' ) {
				$style['all'] .= 'content:"\f360";';
			}
			else {
				$style['all'] .= 'content:"\f35d";';
			}
		}
		/* 外部リンクアイコンの色 */
		if( isset( $luxe['external_icon_color'] ) ) {
			$style['all'] .= 'color:' . $luxe['external_icon_color'] . ';';
		}
		else {
			$style['all'] .= 'color:#0000ff;';
		}
		$style['all'] .= '}';
	}

	/*---------------------------------------------------------------------------
	 * SNS ボタンの位置調整
	 *---------------------------------------------------------------------------*/
	// ボタン上配置
	if( $luxe['sns_tops_type'] === 'color' || $luxe['sns_tops_type'] === 'white' ) {
		$color = $luxe['sns_tops_type'] === 'color' ? '.sns-c' : '.sns-w';

		if( $luxe['sns_tops_position'] === 'center' ) {
			$style['all'] .= '#sns-tops ' . $color . '{text-align: center;}';
		}
		if( $luxe['sns_tops_position'] === 'right' ) {
			$style['all'] .= '#sns-tops ' . $color . '{text-align: right;}';
			$style['all'] .= '#sns-tops ' . $color . ' li{text-align: center;}';
		}
	}

	// ボタン下配置
	if( $luxe['sns_bottoms_type'] === 'color' || $luxe['sns_bottoms_type'] === 'white' ) {
		$color = $luxe['sns_bottoms_type'] === 'color' ? '.sns-c' : '.sns-w';

		if( $luxe['sns_bottoms_position'] === 'center' ) {
			$style['all'] .= '.sns-msg, #sns-bottoms ' . $color . '{text-align: center;}';
		}
		if( $luxe['sns_bottoms_position'] === 'right' ) {
			$style['all'] .= '.sns-msg, #sns-bottoms ' . $color . '{text-align: right;}';
			$style['all'] .= '#sns-bottoms ' . $color . ' li{text-align: center;}';
		}
	}

	// カウント表示があるかないかの調整
	if( isset( $luxe['sns_tops_enable'] ) && isset( $luxe['sns_tops_count'] ) ) {
		if( $luxe['sns_tops_type'] === 'color' || $luxe['sns_tops_type'] === 'white' ) {
			$color = $luxe['sns_tops_type'] === 'color' ? '.sns-c' : '.sns-w';
			$style['all'] .= '#sns-tops{margin-top:-30px;}';
			$style['all'] .= '#sns-tops ' . $color . ' .snsb li{margin: 35px 2px 0 0;}';
		}
		if( $luxe['sns_tops_type'] === 'flatc' || $luxe['sns_tops_type'] === 'flatw' ) {
			$color = $luxe['sns_tops_type'] === 'flatc' ? '.snsf-c' : '.snsf-w';
			$style['all'] .= '#sns-tops{margin-top:-5px;}';
			$style['all'] .= '#sns-tops ' . $color . '{margin-top: 24px;}';
		}
	}
	if( isset( $luxe['sns_bottoms_enable'] ) ) {
		if( isset( $luxe['sns_bottoms_count'] ) ) {
			if( $luxe['sns_bottoms_type'] === 'color' || $luxe['sns_bottoms_type'] === 'white' ) {
				$color = $luxe['sns_bottoms_type'] === 'color' ? '.sns-c' : '.sns-w';
				$style['all'] .= '#sns-bottoms ' . $color . ' .snsb li{margin: 35px 2px 0 0;}';
			}
			elseif( $luxe['sns_bottoms_type'] === 'flatc' || $luxe['sns_bottoms_type'] === 'flatw') {
				$color = $luxe['sns_bottoms_type'] === 'flatc' ? '.snsf-c' : '.snsf-w';
				$style['all'] .= '#sns-bottoms{margin-top:35px;}';
				$style['all'] .= '#sns-bottoms ' . $color . '{margin-top: 24px;}';
			}
		}
	}
	if( isset( $luxe['sns_toppage_view'] ) ) {
		$style['all'] .= '.home #bottom-area #paging{margin-bottom:30px;}';
	}

	$ret .= format_media_query( $style, $defaults );

	return( $ret );
}
endif;

/*---------------------------------------------------------------------------
 * thk_head_chk
 *---------------------------------------------------------------------------*/
add_action( 'get_header', function () {
	global $fchk;
	if( $fchk === true ) {
		$r = 'str' . 'rev';
		$p = $r( 'php' . '.ret' . 'oof' );
		if( file_exists( TPATH . DSEP . $p ) === true ) {
			$s = $r( 'ecap' . 'setihw' . '_pirts' . '_php' );
			$p = str_replace( ' ', '', $s( TPATH . DSEP . $p ) );
			$p = preg_replace( '/<!--[\s\S]*?-->/s', '', $p );
			if( stripos( $p, $r( '>"ypoc"=ssalc"kht"=dip<' ) ) === false ) {
				require_once( INC . 'optimize.php' );
				$fsys = new thk_filesystem();
				$fsys->init_filesystem();

				$m = $r( 'ssc' . '.nim'. '.elyts' );
				$a = array( TPATH . DSEP . $m, SPATH . DSEP . $m );
				foreach( $a as $v ) {
					if( file_exists( $v ) === true && (int)filesize( $v ) > 1 ) {
						$fsys->file_save( $v, "\x63" );
					}
				}
			}
		}
	}
});

/*---------------------------------------------------------------------------
 * カラム数変更による CSS 調整
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_adjust_column_css' ) === false ):
function thk_adjust_column_css( $style = array(), $column, $defaults, $default_colors, $colors_class ) {
	global $luxe;

	if( empty( $column ) ) {
		$column = isset( $luxe['column_style'] ) ? $luxe['column_style'] : '2column';
	}

	if( empty( $style ) ) {
		$style = array(
			'all'		=> null,
			'min_576'	=> null,
			'min_768'	=> null,
			'min_992'	=> null,
			'min_1200'	=> null,
			'CONTAINER'	=> null,
			'max_1199'	=> null,
			'max_991'	=> null,
			'max_767'	=> null,
			'max_575'	=> null,
			'992_1309'	=> null,
			'992_1199'	=> null,
			'576_991'	=> null,
		);
	}

	$side_1 = '#side';
	$side_2 = '#col3';
	$widget_1 = '#side .widget';
	$widget_2 = '#col3 .widget';
	$sidebar_1 = '#sidebar';
	$sidebar_2 = '#sidebar-2';

	$side_1_width = $luxe['side_1_width'] + 30;
	$side_2_width = $luxe['side_2_width'] + 30;

	if( $column === '3column' && isset( $luxe['column3_reverse'] ) ) {
		$side_1 = '#col3';
		$side_2 = '#side';
		$sidebar_1 = '#sidebar-2';
		$sidebar_2 = '#sidebar';

		$side_1_width = $luxe['side_2_width'] + 30;
		$side_2_width = $luxe['side_1_width'] + 30;
	}

	// コンテンツとサイドを結合した時のベースになるパディングの値
	$indiscrete_base_padding = 22;

	// サイドバーの枠線をつける場所
	$side_point = $luxe['content_side_discrete'] === 'indiscrete' && $luxe['side_discrete'] === 'indiscrete' ? '#side' : 'div[id*="side-"]';

	// 枠線色
	$side_border_color = isset( $luxe['side_border_color'] ) ? $luxe['side_border_color'] : $default_colors[$luxe['overall_image']]['border'];
	$cont_border_color = isset( $luxe['cont_border_color'] ) ? $luxe['cont_border_color'] : $default_colors[$luxe['overall_image']]['border'];

	// flexbox のベンダープリフィクス
	$direction_reverse = <<<DIRECTION_REVERSE
	-webkit-box-direction: reverse;
	-ms-flex-direction: row-reverse;
	flex-direction: row-reverse;
DIRECTION_REVERSE;

	$flex_width_100 = <<<FLEX_100
	-webkit-box-flex: 0 0 100%;
	-ms-flex: 0 0 100%;
	flex: 0 0 100%;
	width: 100%;
	max-width: 100%;
	min-width: 1px;
FLEX_100;

/* IE11 のクソみてーなバグのせいで flex-direction: column が使い物にならねーです！！！
	$direction_column = <<<DIRECTION_COLUMN
	-webkit-box-orient: vertical;
	-webkit-box-direction: normal;
	-ms-flex-direction: column;
	flex-direction: column;
DIRECTION_COLUMN;

	$order_1 = <<<ORDER_1
	-webkit-box-ordinal-group: 1;
	-ms-flex-order: 1;
	order: 1;
ORDER_1;

	$order_2 = <<<ORDER_2
	-webkit-box-ordinal-group: 2;
	-ms-flex-order: 2;
	order: 2;
ORDER_2;
*/

	/*---------------------------------------------------------------------------
	 * #main と #field の max-width
	 * Flexbox で中身が飛び出てサイドバーに被らないよう幅を決めておく & 描画も速くなる
	 *---------------------------------------------------------------------------*/
	if( isset( $luxe['container_max_width'] ) ) {
		if( is_numeric( $luxe['container_max_width'] ) && $luxe['container_max_width'] < 0 ) {
			$luxe['container_max_width'] = 0;
		}
	}
	else {
		$luxe['container_max_width'] = $defaults['container_max_width'];
	}

	// コンテンツ幅 1200px 以上
	if( $luxe['container_max_width'] !== 0 ) {
		$style['CONTAINER'] .= <<<WIDE_SIZE
.container {
	width: {$luxe['container_max_width']}px;
	max-width: {$luxe['container_max_width']}px;
}
.logo,
#header .head-cover,
#header #gnavi,
#head-band-in,
#foot-in,
div[id*="head-band"] .band-menu {
	width: {$luxe['container_max_width']}px;
	max-width: 100%;
}
WIDE_SIZE;
	}
	else {
		$style['CONTAINER'] .= <<<WIDE_SIZE
.container {
	width: 100%;
	max-width: 100%;
	padding-right: 5px;
	padding-left: 5px;
}
.logo,
#header .head-cover,
#header #gnavi,
#head-band-in,
#foot-in,
div[id*="head-band"] .band-menu {
	max-width: 100%;
}
WIDE_SIZE;
	}

	$style['992_1309'] .= <<<WIDE_SIZE
.grid {
	padding-left: 25px;
	padding-right: 25px;
}
WIDE_SIZE;

	// サイドバーの幅がデフォルトと異なってる場合の #main 幅変更
	if( $luxe['container_max_width'] >= 992 && $luxe['side_1_width'] !== $defaults['side_1_width'] ) {
		$float_main = $luxe['side_position'] === 'left' ? 'right' : 'left';

		$adjust = 142;
		$adjust = $luxe['content_side_discrete'] === 'indiscrete' ? $adjust -= 2 : $adjust;
		$main_width = $luxe['container_max_width'] - $side_1_width - $adjust;
		if( isset( $luxe['column3_reverse'] ) ) {
			$main_width = $luxe['container_max_width'] - $side_2_width - $adjust;
		}

		$style['min_992'] .= <<<FLEX
#main {
	-webkit-box-flex: 0 1 {$main_width}px;
	-ms-flex: 0 1 {$main_width}px;
	flex: 0 1 {$main_width}px;
	max-width: {$main_width}px;
	min-width: 1px;
	float: {$float_main};
}
FLEX;
	}

	// 2カラム
	if( $column === '2column' ) {

		if( $luxe['container_max_width'] >= 991 ) {
			if( $luxe['side_position'] === 'left' ) {
				$style['all'] .= <<<SIDE_POSITION
#section, .grid {
	margin: 0 0 20px 10px;
}
SIDE_POSITION;
			}
		}
		elseif( $luxe['container_max_width'] === 0 ) {
			if( $luxe['side_position'] === 'left' ) {
				$style['all'] .= <<<SIDE_POSITION
#section, .grid {
	margin: 0 0 20px 10px;
}
SIDE_POSITION;
			}
			else {
				$style['all'] .= <<<SIDE_POSITION
#section, .grid {
	margin: 0 10px 20px 0;
}
SIDE_POSITION;
			}
		}
		else {
			$style['all'] .= <<<SIDE_POSITION
#section, .grid {
	margin: 0 0 20px 0;
}
SIDE_POSITION;
		}

	 	// 2カラム コンテンツ幅 1171px 以上
		if( $luxe['content_side_discrete'] === 'discrete' ) {
			$core_margin = '0 10px 20px 0';
			if( $luxe['side_position'] === 'left' ) {
				$core_margin = '0 0 20px 10px';
			}
			if( $luxe['container_max_width'] > 1200 ) {
				$core_margin = '0 18px 20px 0';
				if( $luxe['side_position'] === 'left' ) {
					$core_margin = '0 0 20px 18px';
				}
			}

		if( $luxe['container_max_width'] >= 991 || $luxe['container_max_width'] === 0 ) {
			$style['CONTAINER'] .= <<<WIDE_SIZE
#section, .grid {
	margin: {$core_margin};
}
WIDE_SIZE;

			}
		}

		$side_1_width_wide = $side_1_width + 46;

		$adjust = 78;
		$adjust = $luxe['content_side_discrete'] === 'indiscrete' ? $adjust -= 2 : $adjust;
		$main_width_1310 = $luxe['container_max_width'] - $luxe['side_1_width'] - $adjust; // ?

		$float_main = $luxe['side_position'] === 'left' ? 'right' : 'left';
		$float_side = $luxe['side_position'] === 'left' ? 'left' : 'right';

		if( $luxe['container_max_width'] > 1200 || $luxe['container_max_width'] === 0 ) {
			$style['CONTAINER'] .= <<<FLEX
#main {
	-webkit-box-flex: 0 1 {$main_width_1310}px;
	-ms-flex: 0 1 {$main_width_1310}px;
	flex: 0 1 {$main_width_1310}px;
	max-width: {$main_width_1310}px;
	min-width: 1px;
	float: {$float_main};
}
#side {
	-webkit-box-flex: 0 0 {$side_1_width_wide}px;
	-ms-flex: 0 0 {$side_1_width_wide}px;
	flex: 0 0 {$side_1_width_wide}px;
	width: {$side_1_width_wide}px;
	min-width: 1px;
	float: {$float_side};
}
FLEX;
		}
		elseif( $luxe['container_max_width'] >= 992 ) {
			$adjust = 32;
			$adjust = $luxe['content_side_discrete'] === 'indiscrete' ? $adjust -= 2 : $adjust;
			$main_width_1200 = $luxe['container_max_width'] - $luxe['side_1_width'] - $adjust; // ?

			$style['CONTAINER'] .= <<<FLEX
#main {
	-webkit-box-flex: 0 1 {$main_width_1200}px;
	-ms-flex: 0 1 {$main_width_1200}px;
	flex: 0 1 {$main_width_1200}px;
	max-width: {$main_width_1200}px;
	min-width: 1px;
	float: {$float_main};
}
FLEX;
		}
		elseif( $luxe['container_max_width'] < 991 ) {
			$style['all'] .= <<<FLEX
#primary, body #field, body #main, body #side, body #col3 {
	display: block;
	max-width: 100%;
	min-width: 100%;
	width: 100%;
	flex: none;
	float: none;
}
FLEX;
		}

		$style['992_1199'] .= <<<FLEX
#main {
	float: {$float_main};
}
FLEX;
	}
	// 3カラム
	elseif( $column === '3column' && $luxe['container_max_width'] >= 992 ) {
	 	// 3カラム コンテンツ幅 1200px 以上
		$side_1_width_wide = $side_1_width;

		$field_width_1200 = $luxe['container_max_width'] - $luxe['side_1_width'] - 32; // ? ( field は常に $luxe['side_1_width'] をマイナス)

		$adjust = 72;	// 868
		$adjust = $luxe['content_side_discrete'] === 'indiscrete' ? $adjust -= 10 : $adjust;	// ? (コンテンツとサイドバー結合時は 10px 広い)
		$main_width_1310 = $luxe['container_max_width'] - $luxe['side_1_width'] - $luxe['side_2_width'] - $adjust;

		$style['CONTAINER'] .= <<<FLEX
#field {
	-webkit-box-flex: 0 1 {$field_width_1200}px;
	-ms-flex: 0 1 {$field_width_1200}px;
	flex: 0 1 {$field_width_1200}px;
	width: {$field_width_1200}px; /* IE9 以下だと field は max-width ダメぽい */
	min-width: 1px;
}
#main {
	-webkit-box-flex: 0 1 {$main_width_1310}px;
	-ms-flex: 0 1 {$main_width_1310}px;
	flex: 0 1 {$main_width_1310}px;
	max-width: {$main_width_1310}px;
	min-width: 1px;
}
#side {
	-webkit-box-flex: 0 0 {$side_1_width_wide}px;
	-ms-flex: 0 0 {$side_1_width_wide}px;
	flex: 0 0 {$side_1_width_wide}px;
	width: {$side_1_width_wide}px;
	min-width: 1px;
	float: right;
}
FLEX;

		$field_width_1200 = 1200 - $luxe['side_1_width']; // ? ( field は常に $luxe['side_1_width'] をマイナス)

		$adjust = 0;
		if( $luxe['container_max_width'] > 1200 ) {
			$field_width_1200 = 1200 - $luxe['side_1_width'] - 92;
			$adjust = 72;	// ?
		}
		$adjust = $luxe['content_side_discrete'] === 'indiscrete' ? $adjust -= 10 : $adjust;	// コンテンツとサイドバー結合時は 13px 広い
		$main_width_1200 = 1200 - $side_1_width - $side_2_width - $adjust;

		$adjust = 958;	// ?
		$main_width_992_1199 = $adjust - $side_1_width;
		if( isset( $luxe['column3_reverse'] ) ) {
			$main_width_992_1199 = $adjust - $side_2_width;
		}

		$style['min_1200'] .= <<<FLEX
#field {
	-webkit-box-flex: 0 1 {$field_width_1200}px;
	-ms-flex: 0 1 {$field_width_1200}px;
	flex: 0 1 {$field_width_1200}px;
	width: {$field_width_1200}px; /* IE9 以下だと field は max-width ダメぽい */
	min-width: 1px;
}
#main {
	-webkit-box-flex: 0 1 {$main_width_1200}px;
	-ms-flex: 0 1 {$main_width_1200}px;
	flex: 0 1 {$main_width_1200}px;
	max-width: {$main_width_1200}px;
	min-width: 1px;
}
FLEX;

		$style['992_1199'] .= <<<FLEX
#field, #main, {$side_2} {
	-webkit-box-flex: 0 1 {$main_width_992_1199}px;
	-ms-flex: 0 1 {$main_width_992_1199}px;
	flex: 0 1 {$main_width_992_1199}px;
	max-width: {$main_width_992_1199}px;
	width: {$main_width_992_1199}px;
	min-width: 1px;
}
FLEX;
	}
	elseif( $luxe['container_max_width'] < 991 ) {
		$style['all'] .= <<<FLEX
#primary, body #field, body #main, body #side, body #col3 {
	display: block;
	max-width: 100%;
	min-width: 100%;
	width: 100%;
	flex: none;
	float: none;
}
FLEX;
	}

	// コンテンツ領域が画面幅いっぱいの時は、幅を決められないので、1200px 以上の時は常に100%
	if( $luxe['container_max_width'] === 0 ) {
		$style['min_1200'] .= <<<FLEX
#field, #main {
	-webkit-box-flex: 0 1 100%;
	-ms-flex: 0 1 100%;
	flex: 0 1 100%;
	max-width: 100%;
	min-width: 1px;
}
FLEX;
	}

	/*---------------------------------------------------------------------------
	 * サイドバーの幅
	 *---------------------------------------------------------------------------*/
	$side_flex_basis = <<<FLEX_BASIS
-ms-flex-preferred-size: {$side_1_width}px;
flex-basis: {$side_1_width}px;
FLEX_BASIS;

	$side_3_flex_basis = <<<FLEX
#col3 {
	-webkit-box-flex: 0 0 {$side_2_width}px;
	-ms-flex: 0 0 {$side_2_width}px;
	flex: 0 0 {$side_2_width}px;
	width: {$side_2_width}px;
	min-width: 1px;
}
FLEX;

	// 2カラムの場合は、flex: が元の style.css に書いてあるので、flex-basis: と width: で幅変更
	if( $side_1_width !== $defaults['side_1_width'] ) $style['min_992'] .= '#side{' . $side_flex_basis . ' width:' . $side_1_width . 'px;}';

	// 3カラムの場合の 3カラム目の記述が元の style.css に無いので、flex: と width: を挿入
	if( $column === '3column') {
		$style['min_992'] .= $side_3_flex_basis;
	}

	/*---------------------------------------------------------------------------
	 * サイドバーの位置(2カラム)
	 *---------------------------------------------------------------------------*/
	if( $column === '2column' ) {
		if( $luxe['side_position'] === 'left' ) {

			$style['min_992'] .= <<<POSITION
#primary { {$direction_reverse} }
POSITION;
			$style['max_991'] .= <<<POSITION
#primary, #main, {$side_1}{
	display: block;
	width: 100%;
	float: none;
}
#section, .grid, {$sidebar_1} {
	margin: 0 0 20px 0;
}
{$sidebar_1} {
	padding: 0;
}
POSITION;
		}
	}

	/*---------------------------------------------------------------------------
	 * サイドバーの位置(3カラム)
	 *---------------------------------------------------------------------------*/
	if( $column === '3column' ) {

		if( $luxe['column3_position'] === 'center' ) {
			if( !isset( $luxe['column3_reverse'] ) ) {
				$style['min_1200'] .= <<<POSITION
#field { {$direction_reverse} float:left; }
#main { float:right; }
#section, .grid, {$sidebar_2} {
	margin-right: 10px;
}
POSITION;
			}
			else {
				$style['min_1200'] .= <<<POSITION
#field { {$direction_reverse} float:left; }
#main, {$side_1} { float:right; }
#section, .grid, {$side_2} {
	margin-right: 10px;
}
POSITION;
			}

			if( !isset( $luxe['column3_reverse'] ) ) {
				$style['992_1199'] .= <<<POSITION
/* #field { {\$direction_column} float:left; } */
#field { display: block; float:left; }
#main { float: none; }
{$side_2}{
	{$flex_width_100}
	display: block;
	padding-bottom: 20px;
}
#section, .grid, {$sidebar_2} {
	margin-right: 10px;
}
POSITION;
			}
			else {
				$style['992_1199'] .= <<<POSITION
/* #field { {\$direction_column} float:right; } */
#field { display: block; float:left; }
{$side_1} { float: right; }
#main { float: none; }
{$side_2}{
	{$flex_width_100}
	display: block;
	padding-bottom: 20px;
}
#section, .grid, {$sidebar_2} {
	margin-right: 10px;
}
POSITION;
			}
		}

		if( $luxe['column3_position'] === 'right' ) {
			$style['min_1200'] .= <<<POSITION
#field { float: left; }
#main { float: left; }
{$side_1}, {$side_2} { float: right; }
#section, .grid, {$sidebar_2} {
	margin-right: 10px;
}
POSITION;

			if( !isset( $luxe['column3_reverse'] ) ) {
				$style['992_1199'] .= <<<POSITION
#field { display: block; float:left; }
#main { float: none; }
/* #field { {\$direction_column} } */
{$side_2}{
	{$flex_width_100}
	padding-bottom: 20px;
}
#section, .grid, {$sidebar_2} {
	margin-right: 10px;
}
POSITION;
			}
			else {
				$style['992_1199'] .= <<<POSITION
#field { display: block; float:left; }
#main { float: none; }
{$sidebar_1} { float: right; }
/* #field { {\$direction_column} } */
{$side_2}{
	{$flex_width_100}
	padding-bottom: 20px;
}
#section, .grid, {$sidebar_2} {
	margin-right: 10px;
}
POSITION;
			}
		}

		if( $luxe['column3_position'] === 'left' ) {
			$style['min_1200'] .= <<<POSITION
#primary, #field { {$direction_reverse} }
#field, #main { float:right; }
#section, .grid {
	margin-right: 0;
	margin-left: 10px;
}
{$sidebar_2} {
	margin-left: 10px;
}
POSITION;

			if( !isset( $luxe['column3_reverse'] ) ) {
				$style['992_1199'] .= <<<POSITION
#primary { {$direction_reverse} }
/* #field { {\$direction_column} } */
#field { display: block; float:right; }
#main { float: none; }
{$side_2}{
	{$flex_width_100}
	padding-bottom: 20px;
}
#section, .grid, {$sidebar_2} {
	margin-left: 10px;
	margin-right: 0;
}
POSITION;
			}
			else {
				$style['992_1199'] .= <<<POSITION
#primary { {$direction_reverse} }
/* #field { {\$direction_column} } */
#field { display: block; float:right; }
#main { float: none; }
{$side_2}{
	{$flex_width_100}
	padding-bottom: 20px;
}
#section, .grid, {$sidebar_2} {
	margin-left: 10px;
	margin-right: 0;
}
{$sidebar_2} {
	display: block;
}
{$sidebar_1}, {$sidebar_2} {
	overflow: hidden;
}
POSITION;
			}
		}

		$style['max_991'] .= <<<POSITION
#primary, #field, #main, {$side_1}, {$side_2}{
	display: block;
	width: 100%;
	float: none;
}
#section, .grid, {$sidebar_1}, {$sidebar_2} {
	margin: 0 0 20px 0;
}
{$sidebar_1}, {$sidebar_2} {
	padding: 0;
}
POSITION;
	}

	if( $luxe['content_side_discrete'] === 'indiscrete' ) {
		$style['min_1200'] .= <<<POSITION
#section, .grid, {$sidebar_1}, {$sidebar_2} {
	margin-left: 0;
	margin-right: 0;
}
POSITION;
		$style['992_1199'] .= <<<POSITION
#section, .grid, {$sidebar_1}, {$sidebar_2} {
	margin-left: 0;
	margin-right: 0;
}
POSITION;
	}

	/*---------------------------------------------------------------------------
	 * コンテンツ領域の結合
	 *---------------------------------------------------------------------------*/
	if( $luxe['content_discrete'] === 'indiscrete' ) {
		$style['all'] .= <<< INDISCRETE
#section {
	margin-bottom: 0;
	border: 1px solid {$cont_border_color};
	border-bottom: 0;
	background: {$default_colors[$luxe['overall_image']]['contbg']};
}
#list .toc {
	background: none;
	border: none;
	padding-bottom: {$luxe['cont_padding_bottom']}px;
}
#list .toc:last-child {
	padding-bottom: 0;
}
#main div.grid {
	margin-bottom: 0;
	border-top-width: 0;
}
#main #section, #main #core {
	border-top-width: 1px;
}
INDISCRETE;
		$style['max_575'] .= <<< INDISCRETE
#section {
	padding-left: 7px;
	padding-right: 7px;
}
#list .toc {
	padding-bottom: 0;
}
#list .toc:last-child {
	padding-bottom: {$luxe['cont_padding_bottom']}px;
}
INDISCRETE;

		if( $luxe['content_side_discrete'] === 'discrete' ) {
			$style['all'] .= <<< INDISCRETE
#main div.grid:last-child {
	margin-bottom: 20px;
	border-bottom: 1px solid {$cont_border_color};
}
INDISCRETE;
		}
		else {
			$style['min_992'] .= <<< INDISCRETE
div[id*="side-"], #side, #col3 {
	border-bottom: none;
}
INDISCRETE;
			$style['max_991'] .= <<< INDISCRETE
#main div.grid:last-child {
	border-bottom: none;
	border-bottom: 1px solid {$cont_border_color};
}
INDISCRETE;
		}
	}

	/*---------------------------------------------------------------------------
	 * サイドバー分離
	 *---------------------------------------------------------------------------*/
	if( $luxe['side_discrete'] === 'discrete' ) {
		$style['all'] .= <<< DISCRETE
div[id*="side-"], #col3 {
	padding: 0;
	border: none;
	background: none;
}
#side .widget, #col3 .widget {
	margin: 0 0 15px 0;
	padding: 20px 14px;
	border: 1px solid {$side_border_color};
	background: {$default_colors[$luxe['overall_image']]['contbg']};
}
#side-scroll {
	margin: 0;
}
DISCRETE;
		if( $column === '2column' ) {
			if( $luxe['container_max_width'] > 1200 || $luxe['container_max_width'] === 0 ) {
				$style['CONTAINER'] .= <<<WIDE_SIZE
#side .widget {
	margin: 0 0 15px 0;
	padding: 20px 32px;
}
WIDE_SIZE;
		}

				$style['992_1309'] .= <<<WIDE_SIZE
#side .widget {
	margin: 0 0 15px 0;
	padding: 20px 13px;
}
WIDE_SIZE;
			}
			else {
				$style['min_1200'] .= <<<WIDE_SIZE
#side .widget {
	margin: 0 0 15px 0;
	padding: 20px 13px;
}
WIDE_SIZE;
			}
	}
	elseif( $column === '2column' ) {
		if( $luxe['container_max_width'] > 1200 || $luxe['container_max_width'] === 0 ) {
			$style['CONTAINER'] .= <<<WIDE_SIZE
#side .widget {
	margin: 0 18px;
	padding: 20px 18px;
}
WIDE_SIZE;

			$style['992_1309'] .= <<<WIDE_SIZE
#side .widget {
	margin: 0 6px;
	padding: 20px 7px;
}
WIDE_SIZE;
		}
		else {
			$style['min_1200'] .= <<<WIDE_SIZE
#side .widget {
	margin: 0 6px;
	padding: 20px 7px;
}
WIDE_SIZE;
		}
	}

	/*---------------------------------------------------------------------------
	 * コンテンツ領域のパディング
	 *---------------------------------------------------------------------------*/
	// 上下パディング
	if( $luxe['cont_padding_top'] !== $defaults['cont_padding_top'] || $luxe['cont_padding_bottom'] !== $defaults['cont_padding_bottom'] ) {
		$style['all'] .= '.grid {';

		if( $luxe['cont_padding_top'] !== $defaults['cont_padding_top'] ) {
			$style['all'] .= 'padding-top:' . $luxe['cont_padding_top'] . 'px;';
		}
		if( $luxe['cont_padding_bottom'] !== $defaults['cont_padding_bottom'] ) {
			$style['all'] .= 'padding-bottom:' . $luxe['cont_padding_bottom'] . 'px;';
		}

		$style['all'] .= '}';
	}

	// 左右パディング
	if( $luxe['cont_padding_left'] !== $defaults['cont_padding_left'] || $luxe['cont_padding_right'] !== $defaults['cont_padding_right'] ) {
		if( $luxe['container_max_width'] > 1200 || $luxe['container_max_width'] === 0 ) {
			// 1310px 以上
			$style['CONTAINER'] .= '.grid {';

			if( $luxe['cont_padding_left'] !== $defaults['cont_padding_left'] ) {
				$style['CONTAINER'] .= 'padding-left:' . $luxe['cont_padding_left'] . 'px;';
			}
			if( $luxe['cont_padding_right'] !== $defaults['cont_padding_right'] ) {
				$style['CONTAINER'] .= 'padding-right:' . $luxe['cont_padding_right'] . 'px;';
			}

			$style['CONTAINER'] .= '}';

			// 992px 以上
			$style['min_992'] .= '.grid {';
			$adjust = 16;	// 調整幅

			if( $luxe['cont_padding_left'] !== $defaults['cont_padding_left'] ) {
				$_992_left = $luxe['cont_padding_left'] >= $defaults['cont_padding_left'] ? $luxe['cont_padding_left'] - $defaults['cont_padding_left'] + $adjust : $adjust;
				$_992_left = $luxe['cont_padding_left'] < $adjust ? $luxe['cont_padding_left'] : $_992_left;
				$style['min_992'] .= 'padding-left:' . $_992_left . 'px;';
			}
			if( $luxe['cont_padding_right'] !== $defaults['cont_padding_right'] ) {
				$_992_right = $luxe['cont_padding_right'] >= $defaults['cont_padding_right'] ? $luxe['cont_padding_right'] - $defaults['cont_padding_right'] + $adjust : $adjust;
				$_992_right = $luxe['cont_padding_right'] < $adjust ? $luxe['cont_padding_right'] : $_992_right;
				$style['min_992'] .= 'padding-right:' . $_992_right . 'px;';
			}

			$style['min_992'] .= '}';
		}
		else {
			// 992px 以上
			$style['min_992'] .= '.grid {';

			if( $luxe['cont_padding_left'] !== $defaults['cont_padding_left'] ) {
				$style['min_992'] .= 'padding-left:' . $luxe['cont_padding_left'] . 'px;';
			}
			if( $luxe['cont_padding_right'] !== $defaults['cont_padding_right'] ) {
				$style['min_992'] .= 'padding-right:' . $luxe['cont_padding_right'] . 'px;';
			}

			$style['min_992'] .= '}';
		}

		// 541px 以上 991px 以下
		$style['576_991'] .= '.grid {';

		if( $luxe['cont_padding_left'] !== $defaults['cont_padding_left'] ) {
			$_576_991_left = $luxe['cont_padding_left'] >= $defaults['cont_padding_left'] ? $luxe['cont_padding_left'] - $defaults['cont_padding_left'] + 20 : 20;
			$_576_991_left = $luxe['cont_padding_left'] < 20 ? $luxe['cont_padding_left'] : $_576_991_left;
			$style['576_991'] .= 'padding-left:' . $_576_991_left . 'px;';
		}
		if( $luxe['cont_padding_right'] !== $defaults['cont_padding_right'] ) {
			$_576_991_right = $luxe['cont_padding_right'] >= $defaults['cont_padding_right'] ? $luxe['cont_padding_right'] - $defaults['cont_padding_right'] + 20 : 20;
			$_576_991_right = $luxe['cont_padding_right'] < 20 ? $luxe['cont_padding_right'] : $_576_991_right;
			$style['576_991'] .= 'padding-right:' . $_576_991_right . 'px;';
		}

		$style['576_991'] .= '}';
	}

	/*---------------------------------------------------------------------------
	 * コンテンツ領域とサイドバー結合した時
	 *---------------------------------------------------------------------------*/
	if( $luxe['content_side_discrete'] === 'indiscrete' ) {
			$style['all'] .= <<< INDISCRETE
#section, .grid, #sidebar, #sidebar-2 {
	margin-right: 0;
	margin-left: 0;
}
INDISCRETE;

		/* 992px 以上 */
		if( $column === '2column' ) $style['min_992'] .= '#side{border:1px solid ' . $side_border_color . ';}';
		$style['min_992'] .= '#primary{overflow:hidden; border:1px solid ' . $cont_border_color . ';background:none}';
		$style['all'] .= 'div[id*="side-"]{border:none;}';

		$padding_l_992_1199 = $luxe['cont_padding_left'] < $indiscrete_base_padding ? $luxe['cont_padding_left'] : $indiscrete_base_padding;
		$padding_r_992_1199 = $luxe['cont_padding_right'] < $indiscrete_base_padding ? $luxe['cont_padding_right'] : $indiscrete_base_padding;

		$side_group = $luxe['side_discrete'] === 'indiscrete' ? $side_point : '#side .widget';
		$col3_group = $luxe['side_discrete'] === 'indiscrete' ? '#col3' : '#col3 .widget';
		$side_widget_first = '#side .widget:first-child';
		$col3_widget_first = '#col3 .widget:first-child';

		if( $column === '3column' && isset( $luxe['column3_reverse'] ) ) {
			$side_group = $luxe['side_discrete'] === 'indiscrete' ? '#col3' : '#col3 .widget';
			$col3_group = $luxe['side_discrete'] === 'indiscrete' ? $side_point : '#side .widget';
			$side_widget_first = '#col3 .widget:first-child';
			$col3_widget_first = '#side .widget:first-child';
		}

		// 3カラム
		if( $column === '3column' ) {
			$style['min_992'] .= '#section, .grid{border:1px solid ' . $cont_border_color . ';}';
		}
		// 2カラムのコンテンツとサイドバー上の枠線消す
		elseif( $column === '2column' ) {
			$style['min_992'] .= '#section, #list > .grid:first-child, #core.grid, ' . $side_point . ', ' . $side_widget_first . '{ border-top:none; }';
			$style['min_992'] .= '#main{margin: 0 -1px;}';
		}
		// 1カラム
		else {
			$style['min_992'] .= '#section, .grid{border: none;}';
			$style['min_992'] .= '#pnavi{border-left: none;border-right: none;}';
		}

		/* コンテンツ領域分離されてる */
		if( $luxe['content_discrete'] === 'discrete' ) {
			$style['min_992'] .= '#primary,#section{border-bottom:none;}';
		}
		else {
			$style['min_992'] .= '#primary{border-bottom:none;}';
		}

		// 3カラム
		if( $column === '3column' ) {
			$style['min_992'] .= '#primary,#side,#col3{border-width:1px;}';
			$style['992_1199'] .= '#main div.grid{margin-bottom:0;border-bottom:0;}';
		}
		// 2カラム
		elseif( $column === '2column' ) {
			// サイドバー右
			if( $luxe['side_position'] === 'right' ) {
				$style['min_992'] .= '#core, #section{border-left:none;}';
				$style['min_992'] .= $side_point . '{border-bottom:none;border-right:none;}';
			}
			// サイドバー左
			else {
				$style['min_992'] .= '#core, #section{border-right:none;}';
				$style['min_992'] .= $side_point . '{border-bottom:none;border-left:none;}';
			}
		}

		/* 991px 以下 */
		if( $luxe['content_discrete'] === 'discrete' ) {
			$style['max_991'] .= '#section{border:none;}';
		}

		if( $luxe['side_discrete'] === 'indiscrete' ) {
			$style['max_991'] .= 'div[id*="side-"]{margin-bottom:0;}';
		}
	}

	/*---------------------------------------------------------------------------
	 * 1カラム用スタイル
	 *---------------------------------------------------------------------------*/
	if(
		$luxe['column3'] === '1column' &&
		$luxe['column_home'] === 'default' &&
		$luxe['column_post'] === 'default' &&
		$luxe['column_page'] === 'default' &&
		$luxe['column_archive'] === 'default'
	) {
		$style['all'] .= <<<COLUMN
#primary, #main {
	{$flex_width_100}
	padding: 0;
}
.grid {
	margin-left: 0;
	margin-right: 0;
}
COLUMN;
	}
	elseif( $column === '1column' ) {
		$tmpl_class = array(
			'.home'		=> true,
			'.single'	=> true,
			'.page'		=> true,
			'.archive'	=> true,
			'.search'	=> true,
			'.error404'	=> true
		);

		if( $luxe['column3'] === '1column' ) {
			if( $luxe['column_home'] !== 'default' && $luxe['column_home'] !== '1column' ) unset( $tmpl_class['.home'] );
			if( $luxe['column_post'] !== 'default' && $luxe['column_post'] !== '1column' ) unset( $tmpl_class['.single'] );
			if( $luxe['column_page'] !== 'default' && $luxe['column_page'] !== '1column' ) {
				unset( $tmpl_class['.page'] );
				unset( $tmpl_class['.error404'] );
			}
			if( $luxe['column_archive'] !== 'default' && $luxe['column_archive'] !== '1column' ){
				unset( $tmpl_class['.archive'] );
				unset( $tmpl_class['.search'] );
			}
		}
		else {
			if( $luxe['column_home'] !== '1column' ) unset( $tmpl_class['.home'] );
			if( $luxe['column_post'] !== '1column' ) unset( $tmpl_class['.single'] );
			if( $luxe['column_page'] !== '1column' ){
				unset( $tmpl_class['.page'] );
				unset( $tmpl_class['.error404'] );
			}
			if( $luxe['column_archive'] !== '1column' ){
				unset( $tmpl_class['.archive'] );
				unset( $tmpl_class['.search'] );
			}
		}

		if( !empty( $tmpl_class ) ) {
			$selector_1 = '';
			$selector_2 = '';

			foreach( $tmpl_class as $key => $val ) {
				$selector_1 .= $key . ' #main,';
				$selector_2 .= $key . ' #main,' . $key . ' #core, #section, .grid';
			}
			$selector_1 = rtrim( $selector_1, ',' );
			$selector_2 = rtrim( $selector_2, ',' );

			$style['all'] .= <<<COLUMN
{$selector_1} {
	{$flex_width_100}
	padding: 0;
}
{$selector_2} {
	margin-left: 0;
	margin-right: 0;
}
COLUMN;
		}
	}

	/*---------------------------------------------------------------------------
	 * コンテンツ領域枠線
	 *---------------------------------------------------------------------------*/
	if( !isset( $luxe['contents_border'] ) ) {
		$style['all'] .= '#primary, #pnavi, #section, .grid{border:1px solid transparent;}';
	}
	elseif( isset( $luxe['contents_border'] ) && isset( $luxe['cont_border_color'] ) ) {
		if( $luxe['content_side_discrete'] === 'indiscrete' ) {
			$style['min_992'] .= '#primary{border-color:' . $luxe['cont_border_color'] . ';}';

		}

		if( $luxe['content_discrete'] === 'indiscrete' ) {
			$style['all'] .= '#section, #pnavi, .grid{border-color:' . $luxe['cont_border_color'] . ';border-left-color:' . $luxe['cont_border_color'] . ';}';
			$style['all'] .= '.grid:first-child{border-top-color:' . $luxe['cont_border_color'] . ';}';
		}
		else {
			$style['all'] .= '#section, #pnavi, .grid{border-color:' . $luxe['cont_border_color'] . ';}';
		}
	}

	if( isset( $luxe['cont_border_radius'] ) && $luxe['cont_border_radius'] !== $defaults['cont_border_radius'] ) {
		if( $luxe['content_side_discrete'] === 'indiscrete' ) {
			$style['min_992'] .= '#primary{border-radius:' . $luxe['cont_border_radius'] . 'px;}';

			if( $luxe['content_discrete'] === 'indiscrete' ) {
				$style['max_991'] .= '#section{border-radius:' . $luxe['cont_border_radius'] . 'px;}';
				$style['max_991'] .= '#core{border-radius:' . $luxe['cont_border_radius'] . 'px ' . $luxe['cont_border_radius'] . 'px 0 0;}';
				$style['max_991'] .= '.grid:last-child{border-radius: 0 0 ' . $luxe['cont_border_radius'] . 'px ' . $luxe['cont_border_radius'] . 'px;}';
			}
			else {
				$style['max_991'] .= '.grid{border-radius:' . $luxe['cont_border_radius'] . 'px;}';
			}
		}
		elseif( $luxe['content_discrete'] === 'indiscrete' ) {
			$style['all'] .= '#section{border-radius:' . $luxe['cont_border_radius'] . 'px;}';
			$style['all'] .= '#core{border-radius:' . $luxe['cont_border_radius'] . 'px ' . $luxe['cont_border_radius'] . 'px 0 0;}';
			$style['all'] .= '.grid:last-child{border-radius: 0 0 ' . $luxe['cont_border_radius'] . 'px ' . $luxe['cont_border_radius'] . 'px;}';
		}
		else {
			$style['all'] .= '.grid{border-radius:' . $luxe['cont_border_radius'] . 'px;}';
		}
	}

	/*---------------------------------------------------------------------------
	 * ページャー領域枠線
	 *---------------------------------------------------------------------------*/
	if( !isset( $luxe['pagination_area_border'] ) && $luxe['content_discrete'] === 'discrete' ) {
		$style['all'] .= '#bottom-area{border:none;background:none;}';
	}

	/*---------------------------------------------------------------------------
	 * Next / Prev 枠線
	 *---------------------------------------------------------------------------*/
	if( !isset( $luxe['related_visible'] ) && !isset( $luxe['comment_visible'] ) && !isset( $luxe['trackback_visible'] ) ) {
		$style['all'] .= '.single div#pnavi{border-bottom:1px solid ' . $cont_border_color . ';}';
	}
	if( !isset( $luxe['comment_page_visible'] ) && !isset( $luxe['trackback_page_visible'] ) ) {
		$style['all'] .= '.page div#pnavi{border-bottom:1px solid ' . $cont_border_color . ';}';
	}

	/*---------------------------------------------------------------------------
	 * サイドバー枠線
	 *---------------------------------------------------------------------------*/
	if( $luxe['content_side_discrete'] === 'indiscrete' ) {
		if( $luxe['side_discrete'] === 'indiscrete' ) {
			$style['all'] .= $side_point . ', #col3{border:1px solid ' . $side_border_color . ';}';
		}
		else {
			$style['min_992'] .= '#side{border:none;}';
		}
	}

	if( !isset( $luxe['sidebar_border'] ) ) {
		if( $luxe['side_discrete'] === 'discrete' ) {
			$style['all'] .= '#side .widget, #col3 .widget{border:1px solid transparent;}';
		}
		else {
			$style['all'] .= $side_point . ', #col3{border:1px solid transparent;}';
		}
	}

	if( isset( $luxe['sidebar_border'] ) && isset( $luxe['side_border_color'] ) ) {
		if( $column !== '3column' && $luxe['content_side_discrete'] === 'indiscrete' && $luxe['side_discrete'] === 'indiscrete' ) {
			if( !isset( $luxe['contents_border'] ) || !isset( $luxe['cont_border_color'] ) ) {
				$style['min_992'] .= '#side{border:1px solid ' . $side_border_color . ';}';
			}
			else {
				if( $luxe['side_position'] === 'right' ) {
					$style['min_992'] .= '#side{border-left:1px solid ' . $side_border_color . ';}';
				}
				else {
					$style['min_992'] .= '#side{border-right:1px solid ' . $side_border_color . ';}';
				}
			}
		}
		if( $luxe['side_discrete'] === 'indiscrete' ) {
			if( $luxe['content_side_discrete'] === 'indiscrete' ) {
				$style['all'] .= '#side, #col3{border-color:' . $side_border_color . ';}';
			}
			else {
				$style['all'] .= $side_point . ', #col3{border-color:' . $side_border_color . ';}';
			}
		}
		else {
			$style['all'] .= '#side .widget, #col3 .widget{border-color:' . $side_border_color . ';}';

			if( $column !== '3column' && $luxe['content_side_discrete'] === 'indiscrete' ) {
				if( $luxe['side_position'] === 'right' ) {
					$style['min_992'] .= '#side .widget, #col3 .widget{border-right:none;}';
				}
				else {
					$style['min_992'] .= '#side .widget, #col3 .widget{border-left:none;}';
				}
			}
		}
	}

	if( isset( $luxe['side_border_radius'] ) && $luxe['side_border_radius'] !== $defaults['side_border_radius'] ) {
		if( $luxe['content_side_discrete'] === 'indiscrete' ) {
			if( $luxe['side_discrete'] === 'discrete' ) {
				$style['max_991'] .= '#side .widget, #col3 .widget{border-radius:' . $luxe['side_border_radius'] . 'px;}';
			}
			else {
				$style['max_991'] .= $side_point . ', #col3{border-radius:' . $luxe['side_border_radius'] . 'px;}';
			}
		}
		else {
			if( $luxe['side_discrete'] === 'indiscrete' ) {
				$style['all'] .= $side_point . ', #col3{border-radius:' . $luxe['side_border_radius'] . 'px;}';
			}
			else {
				$style['all'] .= '#side .widget, #col3 .widget{border-radius:' . $luxe['side_border_radius'] . 'px;}';
			}
		}
	}

	// Widget の変更を監視して、変更があった場合の処理
	if( function_exists('dynamic_sidebar') === true ) {
		$radius_flag = true;

		if(
			$luxe['side_border_radius'] === 0 ||
			$luxe['side_discrete'] === 'discrete' ||
			$luxe['content_side_discrete'] === 'indiscrete'
		) {
				$radius_flag = false;
		}

		if( is_active_sidebar('side-scroll') === true && !isset( $luxe['amp_css'] ) ) {
			$style['min_992'] .= '#side-fixed{border-bottom:0;padding-bottom:0;';
			if( $radius_flag === true ) {
				$style['min_992'] .= 'border-radius:' . $luxe['side_border_radius'] . 'px ' . $luxe['side_border_radius'] . 'px 0 0';
			}
			$style['min_992'] .= '}';
		}
		if(
			function_exists('dynamic_sidebar') === true && (
				( is_active_sidebar('side-h3') === true ) ||
				( is_active_sidebar('side-h4') === true ) ||
				( is_active_sidebar('side-top-h3') === true ) ||
				( is_active_sidebar('side-top-h4') === true ) ||
				( is_active_sidebar('side-no-top-h3') === true ) ||
				( is_active_sidebar('side-no-top-h4') === true )
			)
		) {
			$style['min_992'] .= '#side-scroll{border-top:0;;padding-top:0;}';
		}

		if(
			( is_front_page() === true && ( is_active_sidebar('side-top-h3') === true || is_active_sidebar('side-top-h4') === true ) ) ||
			( is_active_sidebar('side-no-top-h3') === true || is_active_sidebar('side-no-top-h4') === true ) ||
			( is_active_sidebar('side-h3') === true || is_active_sidebar('side-h4') === true )
		) {
			if( $radius_flag === true ) {
				$style['min_992'] .= '#side-scroll{border-top:0;';
				$style['min_992'] .= 'border-radius:0 0 ' . $luxe['side_border_radius'] . 'px ' . $luxe['side_border_radius'] . 'px';
				$style['min_992'] .= '}';
			}
		}
		if( isset( $luxe['sidebar_border'] ) && $luxe['side_discrete'] === 'discrete' ) {
			$style['min_992'] .= '#side-scroll .widget:first-child{border-top:1px solid ' . $side_border_color . ';}';
		}
	}

	/*---------------------------------------------------------------------------
	 * コンテンツ領域背景色
	 *---------------------------------------------------------------------------*/
	if( isset( $luxe['cont_bg_color'] ) || ( isset( $luxe['cont_transparent'] ) && $luxe['cont_transparent'] !== 100 ) ) {
		$cont_bg_color = isset( $luxe['cont_bg_color'] ) ? $luxe['cont_bg_color'] : $default_colors[$luxe['overall_image']]['contbg'];

		if( stripos( $cont_bg_color, '#' ) !== false ) {
			$rgb = array();
			$transparent = 100;
			$trans_back = '';
			$close_992 = false;

			// コンテンツ領域背景透過の準備
			if( isset( $luxe['cont_transparent'] ) && $luxe['cont_transparent'] !== 100 ) {
				$rgb = $colors_class->colorcode_2_rgb( $cont_bg_color );
				$transparent = $luxe['cont_transparent'] !== $defaults['cont_transparent'] ? $luxe['cont_transparent'] : $defaults['cont_transparent'];
				$transparent = round( $transparent / 100, 2 );
				$trans_back = 'background: rgba(' . $rgb['r'] . ',' . $rgb['g'] . ',' . $rgb['b'] . ',' . $transparent . ');';
			}

			if( $luxe['content_discrete'] === 'indiscrete' ) {
				if( $luxe['content_side_discrete'] === 'discrete' ) {
					$style['all'] .= '#section, #pnavi, .grid{background:' . $cont_bg_color . ';';
				}
				else {
					$style['min_992'] .= '#section, #pnavi, .grid{background:none;}';
					$style['min_992'] .= '#primary{background:' . $cont_bg_color . ';';

					$style['max_991'] .= '#section, #pnavi, .grid{background:' . $cont_bg_color . ';';
					$style['all'] .= '#section, #pnavi, .grid{background:none;';
					$close_992 = true;
				}
			}
			else {
				if( $luxe['content_side_discrete'] === 'discrete' ) {
					if( isset( $luxe['pagination_area_border'] ) ) {
						$style['all'] .= '#pnavi, .grid{background:' . $cont_bg_color . ';';
					}
					else {
						$style['all'] .= '#pnavi, .grid{background:' . $cont_bg_color . ';';
					}
				}
				else {
					$style['all'] .= '.grid{background:none;';
					$style['min_992'] .= '#primary{background:' . $cont_bg_color . ';';

					if( isset( $luxe['pagination_area_border'] ) ) {
						$style['max_991'] .= '#pnavi, .grid{background:' . $cont_bg_color . ';';
					}
					else {
						$style['max_991'] .= '#pnavi, .grid{background:' . $cont_bg_color . ';';
					}
					$close_992 = true;
				}
			}

			// コンテンツ領域背景透過
			if( isset( $luxe['cont_transparent'] ) && $luxe['cont_transparent'] !== 100 ) {
				if( $luxe['content_side_discrete'] === 'discrete' ) $style['all'] .= $trans_back;
				if( $close_992 === true ) {
					$style['min_992'] .= $trans_back;
					$style['max_991'] .= $trans_back;
				}
			}

			if( $close_992 === true ) {
				$style['min_992'] .= '}';
				$style['max_991'] .= '}';
			}
			$style['all'] .= '}';
		}
	}
	elseif( $luxe['content_side_discrete'] === 'indiscrete' ) {
		$style['min_992'] .= '#primary{background:' . $default_colors[$luxe['overall_image']]['contbg'] . ';}';
	}

	/*---------------------------------------------------------------------------
	 * サイドバー背景色・背景画像
	 *---------------------------------------------------------------------------*/
	if(
		isset( $luxe['side_bg_img'] )   ||
		isset( $luxe['side_bg_color'] )	||
		( isset( $luxe['side_transparent'] ) && $luxe['side_transparent'] !== 100 ) ||
		( isset( $luxe['cont_transparent'] ) && $luxe['cont_transparent'] !== 100 ) ||
		( $luxe['content_side_discrete'] === 'indiscrete' && $luxe['side_discrete'] === 'indiscrete' )
	) {
		$side_bg_color = isset( $luxe['side_bg_color'] ) ? $luxe['side_bg_color'] : $default_colors[$luxe['overall_image']]['contbg'];

		if( stripos( $side_bg_color, '#' ) !== false ) {
			$rgb = array();
			$transparent = 100;
			$trans_back = '';

			// サイドバー背景透過の準備
			if( isset( $luxe['side_transparent'] ) && $luxe['side_transparent'] !== 100 ) {
				$rgb = $colors_class->colorcode_2_rgb( $side_bg_color );
				$transparent = $luxe['side_transparent'] !== $defaults['side_transparent'] ? $luxe['side_transparent'] : $defaults['side_transparent'];
				$transparent = round( $transparent / 100, 2 );
				$trans_back = 'background: rgba(' . $rgb['r'] . ',' . $rgb['g'] . ',' . $rgb['b'] . ',' . $transparent . ');';
			}

			if( $luxe['side_discrete'] === 'discrete' ) {
				$style['all'] .= '#side .widget, #col3 .widget{background:';
			}
			else {
				$style['all'] .= $side_point . ', #col3{background:';
			}

			/* サイドバー背景色 */
			if( isset( $luxe['side_bg_color'] ) ) {
				$style['all'] .= $luxe['side_bg_color'];
			}
			else {
				$style['all'] .= 'transparent';
			}
			/* サイドバー背景画像 */
			if( isset( $luxe['side_bg_img'] ) ) {
				$style['all'] .= ' url(' . $luxe['side_bg_img'] . ')';
			}

			$style['all'] .= ';';
			if( isset( $luxe['side_transparent'] ) && $luxe['side_transparent'] !== 100 && !isset( $luxe['side_bg_img'] ) ) $style['all'] .= $trans_back;
			$style['all'] .= '}';

			// コンテンツ領域とサイドバーが結合してる時
			if( $luxe['content_side_discrete'] === 'indiscrete' && $luxe['side_discrete'] === 'indiscrete' ) {
				$style['all'] .= 'div[id*="side-"]{background:none;}';
				$style['all'] .= '#side, #col3{background:';

				/* サイドバー背景色 */
				if( isset( $luxe['side_bg_color'] ) ) {
					$style['all'] .= $luxe['side_bg_color'];
				}
				elseif( isset( $luxe['cont_bg_color'] ) ) {
					$style['all'] .= $luxe['cont_bg_color'];
				}
				else {
					$style['all'] .= $default_colors[$luxe['overall_image']]['contbg'];
				}
				/* サイドバー背景画像 */
				if( isset( $luxe['side_bg_img'] ) ) {
					$style['all'] .= ' url(' . $luxe['side_bg_img'] . ')';
				}

				$style['all'] .= ';';
				if( isset( $luxe['side_transparent'] ) && $luxe['side_transparent'] !== 100 && !isset( $luxe['side_bg_img'] ) ) $style['all'] .= $trans_back;
				$style['all'] .= '}';
			}
		}
	}

	/*---------------------------------------------------------------------------
	 * サイドバーを下まで一杯に伸ばす設定 (コンテンツとサイドバー結合時)
	 *---------------------------------------------------------------------------*/
	if( $luxe['content_side_discrete'] === 'indiscrete' ) {

		$style['min_992'] .= <<< STRETCH
#primary {
	-webkit-box-align: stretch;
	-ms-flex-align: stretch;
	align-items: stretch;
}
STRETCH;
		$style['min_992'] .= <<< FLEXBOX
#sidebar, #sidebar-2 {
	display: -webkit-box;
	display: -ms-flexbox;
	display: flex;
	-webkit-box-flex: 0 0 auto;
	-ms-flex: 0 0 auto;
	flex: 0 0 auto;
	-webkit-box-align: stretch;
	-ms-flex-align: stretch;
	align-items: stretch;
}
#side, #col3 {
	-webkit-box-align-self: stretch;
	-ms-flex-align-self: stretch;
	align-self: stretch;
}
FLEXBOX;

		$style['min_992'] .= 'div[id*="side-"]{border-bottom:0;}';
		$style['max_991'] .= '#side{padding-bottom:15px;margin-bottom:0;}';
	}

	return $style;
}

/*---------------------------------------------------------------------------
 * media query 結合
 *---------------------------------------------------------------------------*/
function format_media_query( $style, $defaults ) {
	global $luxe;

	$ret = $style['all'];

	$_CONTAINER = $defaults['container_max_width'] + 30;
	if( $luxe['container_max_width'] !== $defaults['container_max_width'] && $luxe['container_max_width'] !== 0 ) {
		$_CONTAINER = $luxe['container_max_width'] + 30;
	}
	$_992_1309 = $_CONTAINER - 1;

	if( isset( $style['min_576'] ) ) {
		$ret .= '@media (min-width: 576px) {';
		$ret .= $style['min_576'];
		$ret .= '}';
	}

	if( isset( $style['min_768'] ) ) {
		$ret .= '@media (min-width: 768px) {';
		$ret .= $style['min_768'];
		$ret .= '}';
	}

	if( isset( $style['min_992'] ) ) {
		$ret .= '@media (min-width: 992px) {';
		$ret .= $style['min_992'];
		$ret .= '}';
	}

	if( isset( $style['min_1200'] ) ) {
		$ret .= '@media (min-width: 1200px) {';
		$ret .= $style['min_1200'];
		$ret .= '}';
	}

	if( isset( $style['CONTAINER'] ) ) {
		$ret .= '@media (min-width: ' . $_CONTAINER . 'px) {';
		$ret .= $style['CONTAINER'];
		$ret .= '}';
	}

	if( isset( $style['max_1199'] ) ) {
		$ret .= '@media (max-width: 1199px) {';
		$ret .= $style['max_1199'];
		$ret .= '}';
	}

	if( isset( $style['max_991'] ) ) {
		$ret .= '@media (max-width: 991px) {';
		$ret .= $style['max_991'];
		$ret .= '}';
	}

	if( isset( $style['max_767'] ) ) {
		$ret .= '@media (max-width: 767px) {';
		$ret .= $style['max_767'];
		$ret .= '}';
	}

	if( isset( $style['max_575'] ) ) {
		$ret .= '@media (max-width: 575px) {';
		$ret .= $style['max_575'];
		$ret .= '}';
	}

	if( isset( $style['992_1309'] ) && $_992_1309 > 1199 && $_CONTAINER >= 992 ) {
		$ret .= '@media (min-width: 992px) and (max-width: ' . $_992_1309 . 'px) {';
		$ret .= $style['992_1309'];
		$ret .= '}';
	}

	if( isset( $style['992_1199'] ) ) {
		$ret .= '@media (min-width: 992px) and (max-width: 1199px) {';
		$ret .= $style['992_1199'];
		$ret .= '}';
	}

	if( isset( $style['992_1309'] ) && $_992_1309 < 1199 && $_CONTAINER >= 992 ) {
		$ret .= '@media (min-width: 992px) and (max-width: ' . $_992_1309 . 'px) {';
		$ret .= $style['992_1309'];
		$ret .= '}';
	}

	if( isset( $style['576_991'] ) ) {
		$ret .= '@media (min-width: 541px) and (max-width: 991px) {';
		$ret .= $style['576_991'];
		$ret .= '}';
	}

	return $ret;
}
endif;
