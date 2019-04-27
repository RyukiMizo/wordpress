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

add_action( 'customize_register', function( $wp_customize ) {
	global $awesome;

	require( INC . 'carray.php' );

	//---------------------------------------------------------------------------
	// サイト情報 / サイトアイコン
	//---------------------------------------------------------------------------
	$wp_customize->add_section( 'title_tagline', array(
		'title'    => __( 'Site Identity / Site Icon', 'luxeritas' ),
		'priority' => 20
	));

	//---------------------------------------------------------------------------
	// 全体レイアウト
	//---------------------------------------------------------------------------
	$wp_customize->add_section( 'layout_section', array(
		'title'		=> __( 'The Entire Layout', 'luxeritas' ),
		'priority'	=> 22
	));

	// コンテナの最大幅
	$wp_customize->add_setting( 'container_max_width', array(
		'default'	=> 1280,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'container_max_width', array(
		'settings'	=> 'container_max_width',
		'label'		=> __( 'The maximum width of the container', 'luxeritas' ),
		'description'	=> __( '* 0 would be full width', 'luxeritas' ) . '<br />' . __( '* ', 'luxeritas' ) . __( 'default value', 'luxeritas' ) . ' 1280px',
		'section'	=> 'layout_section',
		'type'		=> 'number',
		'priority'	=> 5
	));

	// 全体イメージ
	$wp_customize->add_setting( 'overall_image', array(
		'default'	=> 'white',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'overall_image', array(
		'settings'	=> 'overall_image',
		'label'		=> __( 'The entire image', 'luxeritas' ),
		'section'	=> 'layout_section',
		'type'		=> 'select',
		'choices'	=> array(
			'white'		=> __( 'White', 'luxeritas' ),
			'black'		=> __( 'Black', 'luxeritas' )
		),
		'priority'	=> 10
	));

	// 記事一覧の表示方法
	$wp_customize->add_setting( 'list_view', array(
		'default'	=> 'excerpt',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'list_view', array(
		'settings'	=> 'list_view',
		'label'		=> __( 'Display layout of the article list', 'luxeritas' ),
		'section'	=> 'layout_section',
		'type'		=> 'select',
		'choices'	=> array(
			'excerpt'	=> __( 'Excerpt + Thumbnail display', 'luxeritas' ),
			'content'	=> __( 'Full article display (Until more tag)', 'luxeritas' )
		),
		'priority'	=> 15
	));

	// 先頭固定の投稿は本文表示にする
	$wp_customize->add_setting( 'sticky_no_excerpt', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'sticky_no_excerpt', array(
		'settings'	=> 'sticky_no_excerpt',
		'label'		=> __( 'Sticky post to show all content', 'luxeritas' ),
		'description'	=> '<p class="f09em mm23l m0b">' . __( '* Use this feature when you want to show Latest Updates or News as your first post.', 'luxeritas' ) . '</p>',
		'section'	=> 'layout_section',
		'type'		=> 'checkbox',
		'priority'	=> 20
	));

	// ページャーの表示有無
	$wp_customize->add_setting( 'pagination_visible', array(
		'default'	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'pagination_visible', array(
		'settings'	=> 'pagination_visible',
		'label'		=> __( 'Display Pager', 'luxeritas' ),
		'section'	=> 'layout_section',
		'type'		=> 'checkbox',
		'priority'	=> 25
	));

	$wp_customize->add_setting( 'dummy1', array( 'sanitize_callback' => 'thk_sanitize' ) );
	$wp_customize->add_control( 'dummy1', array(
		'settings'	=> 'dummy1',
		'description'	=> '<p class="bold snormal f11em mm23l mm10b">' . __( 'Post page', 'luxeritas' ) . '</p>',
		'section'	=> 'layout_section',
		'type'		=> 'hidden',
		'priority'	=> 32
	));

	// 関連記事の表示有無
	$wp_customize->add_setting( 'related_visible', array(
		'default'	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'related_visible', array(
		'settings'	=> 'related_visible',
		'label'		=> __( 'Display Related Articles', 'luxeritas' ),
		'section'	=> 'layout_section',
		'type'		=> 'checkbox',
		'priority'	=> 35
	));

	// Next/Prev ナビゲーションの表示有無
	$wp_customize->add_setting( 'next_prev_nav_visible', array(
		'default'	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'next_prev_nav_visible', array(
		'settings'	=> 'next_prev_nav_visible',
		'label'		=> __( 'Display Next / Prev Navigation', 'luxeritas' ),
		'description'	=> '<p class="bold snormal f11em mm23l mm10b">' . __( 'Static page', 'luxeritas' ) . '</p>',
		'section'	=> 'layout_section',
		'type'		=> 'checkbox',
		'priority'	=> 40
	));

	// Next/Prev ナビゲーション（固定ページ）の表示有無
	$wp_customize->add_setting( 'next_prev_nav_page_visible', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'next_prev_nav_page_visible', array(
		'settings'	=> 'next_prev_nav_page_visible',
		'label'		=> __( 'Display Next / Prev Navigation', 'luxeritas' ),
		'section'	=> 'layout_section',
		'type'		=> 'checkbox',
		'priority'	=> 45
	));

	// 固定フロントページの記事タイトル表示有無
	$wp_customize->add_setting( 'front_page_post_title', array(
		'default'	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'front_page_post_title', array(
		'settings'	=> 'front_page_post_title',
		'label'		=> __( 'Display post title of static front page', 'luxeritas' ),
		'section'	=> 'layout_section',
		'type'		=> 'checkbox',
		'priority'	=> 50
	));

	//---------------------------------------------------------------------------
	// グリッドレイアウト
	//---------------------------------------------------------------------------
	$wp_customize->add_section( 'grid_section', array(
		'title'		=> __( 'Grid layout', 'luxeritas' ),
		'priority'	=> 22
	));

	// グリッドのタイプ (一覧型トップページ)
	$wp_customize->add_setting( 'grid_home', array(
		'default'	=> 'none',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'grid_home', array(
		'settings'	=> 'grid_home',
		'label'		=> __( 'Top page of list type', 'luxeritas' ),
		'section'	=> 'grid_section',
		'type'		=> 'select',
		'choices'	=> array(
			'none'		=> __( 'Normal style', 'luxeritas' ),
			'tile-1'	=> __( 'Tile type', 'luxeritas' ) . ' ( ' . sprintf( __( 'Up to %s cols', 'luxeritas' ), '1' ) . ' )',
			'tile-2'	=> __( 'Tile type', 'luxeritas' ) . ' ( ' . sprintf( __( 'Up to %s cols', 'luxeritas' ), '2' ) . ' )',
			'tile-3'	=> __( 'Tile type', 'luxeritas' ) . ' ( ' . sprintf( __( 'Up to %s cols', 'luxeritas' ), '3' ) . ' )',
			'tile-4'	=> __( 'Tile type', 'luxeritas' ) . ' ( ' . sprintf( __( 'Up to %s cols', 'luxeritas' ), '4' ) . ' )',
			'card-1'	=> __( 'Card type', 'luxeritas' ) . ' ( ' . sprintf( __( 'Up to %s cols', 'luxeritas' ), '1' ) . ' )',
			'card-2'	=> __( 'Card type', 'luxeritas' ) . ' ( ' . sprintf( __( 'Up to %s cols', 'luxeritas' ), '2' ) . ' )',
			'card-3'	=> __( 'Card type', 'luxeritas' ) . ' ( ' . sprintf( __( 'Up to %s cols', 'luxeritas' ), '3' ) . ' )',
			'card-4'	=> __( 'Card type', 'luxeritas' ) . ' ( ' . sprintf( __( 'Up to %s cols', 'luxeritas' ), '4' ) . ' )',
		),
		'priority'	=> 5
	));

	// 最初の X 件目は通常表示 (一覧型トップページ)
	$wp_customize->add_setting( 'grid_home_first', array(
		'default'	=> 0,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'grid_home_first', array(
		'settings'	=> 'grid_home_first',
		'description'	=> '<p class="m0t">' . __( 'First X post is normal style', 'luxeritas' ) . '</p>',
		'section'	=> 'grid_section',
		'type'		=> 'number',
		'priority'	=> 6
	));

	// 記事一覧中央ウィジェットの差し込み箇所 (一覧型トップページ)
	$wp_customize->add_setting( 'grid_home_widget', array(
		'default'	=> 0,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'grid_home_widget', array(
		'settings'	=> 'grid_home_widget',
		'description'	=> '<p style="margin-top:-8px;">' . __( 'Position of &quot;Middle of Posts List Widget&quot; (Automatic if 0)', 'luxeritas' ) . '</p>',
		'section'	=> 'grid_section',
		'type'		=> 'number',
		'priority'	=> 7
	));

	// グリッドのタイプ (カテゴリページ)
	$wp_customize->add_setting( 'grid_category', array(
		'default'	=> 'none',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'grid_category', array(
		'settings'	=> 'grid_category',
		'label'		=> __( 'Category', 'luxeritas' ),
		'section'	=> 'grid_section',
		'type'		=> 'select',
		'choices'	=> array(
			'none'		=> __( 'Normal style', 'luxeritas' ),
			'tile-1'	=> __( 'Tile type', 'luxeritas' ) . ' ( ' . sprintf( __( 'Up to %s cols', 'luxeritas' ), '1' ) . ' )',
			'tile-2'	=> __( 'Tile type', 'luxeritas' ) . ' ( ' . sprintf( __( 'Up to %s cols', 'luxeritas' ), '2' ) . ' )',
			'tile-3'	=> __( 'Tile type', 'luxeritas' ) . ' ( ' . sprintf( __( 'Up to %s cols', 'luxeritas' ), '3' ) . ' )',
			'tile-4'	=> __( 'Tile type', 'luxeritas' ) . ' ( ' . sprintf( __( 'Up to %s cols', 'luxeritas' ), '4' ) . ' )',
			'card-1'	=> __( 'Card type', 'luxeritas' ) . ' ( ' . sprintf( __( 'Up to %s cols', 'luxeritas' ), '1' ) . ' )',
			'card-2'	=> __( 'Card type', 'luxeritas' ) . ' ( ' . sprintf( __( 'Up to %s cols', 'luxeritas' ), '2' ) . ' )',
			'card-3'	=> __( 'Card type', 'luxeritas' ) . ' ( ' . sprintf( __( 'Up to %s cols', 'luxeritas' ), '3' ) . ' )',
			'card-4'	=> __( 'Card type', 'luxeritas' ) . ' ( ' . sprintf( __( 'Up to %s cols', 'luxeritas' ), '4' ) . ' )',
		),
		'priority'	=> 10
	));

	// 最初の X 件目は通常表示 (カテゴリページ)
	$wp_customize->add_setting( 'grid_category_first', array(
		'default'	=> 0,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'grid_category_first', array(
		'settings'	=> 'grid_category_first',
		'description'	=> '<p class="m0t">' . __( 'First X post is normal style', 'luxeritas' ) . '</p>',
		'section'	=> 'grid_section',
		'type'		=> 'number',
		'priority'	=> 11
	));

	// 記事一覧中央ウィジェットの差し込み箇所 (カテゴリページ)
	$wp_customize->add_setting( 'grid_category_widget', array(
		'default'	=> 0,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'grid_category_widget', array(
		'settings'	=> 'grid_category_widget',
		'description'	=> '<p style="margin-top:-8px;">' . __( 'Position of &quot;Middle of Posts List Widget&quot; (Automatic if 0)', 'luxeritas' ) . '</p>',
		'section'	=> 'grid_section',
		'type'		=> 'number',
		'priority'	=> 12
	));

	// カテゴリページのディスクリプション
	$wp_customize->add_setting( 'grid_category_description', array(
		'default'	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'grid_category_description', array(
		'settings'	=> 'grid_category_description',
		'label'		=> __( 'Insert description at beginning of category list (HTML enabled)', 'luxeritas' ),
		'section'	=> 'grid_section',
		'type'		=> 'checkbox',
		'priority'	=> 13
	));

	// グリッドのタイプ (アーカイブページ)
	$wp_customize->add_setting( 'grid_archive', array(
		'default'	=> 'none',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'grid_archive', array(
		'settings'	=> 'grid_archive',
		'label'		=> __( 'Archive', 'luxeritas' ),
		'section'	=> 'grid_section',
		'type'		=> 'select',
		'choices'	=> array(
			'none'		=> __( 'Normal style', 'luxeritas' ),
			'tile-1'	=> __( 'Tile type', 'luxeritas' ) . ' ( ' . sprintf( __( 'Up to %s cols', 'luxeritas' ), '1' ) . ' )',
			'tile-2'	=> __( 'Tile type', 'luxeritas' ) . ' ( ' . sprintf( __( 'Up to %s cols', 'luxeritas' ), '2' ) . ' )',
			'tile-3'	=> __( 'Tile type', 'luxeritas' ) . ' ( ' . sprintf( __( 'Up to %s cols', 'luxeritas' ), '3' ) . ' )',
			'tile-4'	=> __( 'Tile type', 'luxeritas' ) . ' ( ' . sprintf( __( 'Up to %s cols', 'luxeritas' ), '4' ) . ' )',
			'card-1'	=> __( 'Card type', 'luxeritas' ) . ' ( ' . sprintf( __( 'Up to %s cols', 'luxeritas' ), '1' ) . ' )',
			'card-2'	=> __( 'Card type', 'luxeritas' ) . ' ( ' . sprintf( __( 'Up to %s cols', 'luxeritas' ), '2' ) . ' )',
			'card-3'	=> __( 'Card type', 'luxeritas' ) . ' ( ' . sprintf( __( 'Up to %s cols', 'luxeritas' ), '3' ) . ' )',
			'card-4'	=> __( 'Card type', 'luxeritas' ) . ' ( ' . sprintf( __( 'Up to %s cols', 'luxeritas' ), '4' ) . ' )',
		),
		'priority'	=> 15
	));

	// 最初の X 件目は通常表示 (アーカイブページ)
	$wp_customize->add_setting( 'grid_archive_first', array(
		'default'	=> 0,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'grid_archive_first', array(
		'settings'	=> 'grid_archive_first',
		'description'	=> '<p class="m0t">' . __( 'First X post is normal style', 'luxeritas' ) . '</p>',
		'section'	=> 'grid_section',
		'type'		=> 'number',
		'priority'	=> 16
	));

	// 記事一覧中央ウィジェットの差し込み箇所 (アーカイブページ)
	$wp_customize->add_setting( 'grid_archive_widget', array(
		'default'	=> 0,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'grid_archive_widget', array(
		'settings'	=> 'grid_archive_widget',
		'description'	=> '<p style="margin-top:-8px;">' . __( 'Position of &quot;Middle of Posts List Widget&quot; (Automatic if 0)', 'luxeritas' ) . '</p>',
		'section'	=> 'grid_section',
		'type'		=> 'number',
		'priority'	=> 17
	));

	// 記事一覧中央ウィジェットの幅
	$wp_customize->add_setting( 'posts_list_middle_widget_wide', array(
		'default'	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'posts_list_middle_widget_wide', array(
		'settings'	=> 'posts_list_middle_widget_wide',
		'label'		=> __( 'Middle of Posts List Widget to be full width', 'luxeritas' ),
		'section'	=> 'grid_section',
		'type'		=> 'checkbox',
		'priority'	=> 18
	));

	// タイル型の上下の並び
	$wp_customize->add_setting( 'grid_tile_order', array(
		'default'	=> 'ThumbTM',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'grid_tile_order', array(
		'settings'	=> 'grid_tile_order',
		'label'		=> __( 'Tile type order', 'luxeritas' ),
		'section'	=> 'grid_section',
		'type'		=> 'select',
		'choices'	=> array(
			'ThumbTM'	=> __( 'Thumbnail', 'luxeritas' ) . ' / ' . __( 'Title', 'luxeritas' ) . ' / ' . __( 'Meta', 'luxeritas' ),
			'ThumbMT'	=> __( 'Thumbnail', 'luxeritas' ) . ' / ' . __( 'Meta', 'luxeritas' ) . ' / ' . __( 'Title', 'luxeritas' ),
			'MThumbT'	=> __( 'Meta', 'luxeritas' ) . ' / ' . __( 'Thumbnail', 'luxeritas' ) . ' / ' . __( 'Title', 'luxeritas' ),
			'MTThumb'	=> __( 'Meta', 'luxeritas' ) . ' / ' . __( 'Title', 'luxeritas' ) . ' / ' . __( 'Thumbnail', 'luxeritas' )
		),
		'priority'	=> 20
	));

	// グリッドレイアウトのサムネイル
	$wp_customize->add_setting( 'dummy2', array( 'sanitize_callback' => 'thk_sanitize' ) );
	$wp_customize->add_control( 'dummy2', array(
		'settings'	=> 'dummy2',
		'label'		=> __( 'Thumbnail (Featured Image)', 'luxeritas' ),
		'description'	=> '<p class="f09em">' . __( '* Thumbnails can be set with &quot;thumbnail&quot; item.', 'luxeritas' ) . '</p>',
		'section'	=> 'grid_section',
		'type'		=> 'hidden',
		'priority'	=> 25
	));

	// 記事一覧の抜粋の文字数 (通常スタイル)
	$wp_customize->add_setting( 'excerpt_length', array(
		'default' 	=> 120,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'excerpt_length', array(
		'settings'	=> 'excerpt_length',
		'label'		=> __( 'Number of characters and color density in excerpt on post list', 'luxeritas' ),
		'description'	=> __( 'Normal style', 'luxeritas' ),
		'section'	=> 'grid_section',
		'type'		=> 'number',
		'priority'	=> 30
	));

	// 記事一覧の抜粋を改行するかどうか（通常スタイル）
	$wp_customize->add_setting( 'break_excerpt', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'break_excerpt', array(
		'settings'	=> 'break_excerpt',
		'label'		=> __( 'No line break in excerpt', 'luxeritas' ),
		'section'	=> 'grid_section',
		'type'		=> 'checkbox',
		'priority'	=> 35
	));

	// 記事一覧の抜粋の色濃度 (通常スタイル)
	$wp_customize->add_setting( 'excerpt_opacity', array(
		'default' 	=> 100,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'excerpt_opacity', array(
		'settings'	=> 'excerpt_opacity',
		'section'	=> 'grid_section',
		'type'		=> 'range',
		'priority'	=> 40
	));

	// 記事一覧の抜粋の文字数 (タイル型)
	$wp_customize->add_setting( 'excerpt_length_tile', array(
		'default' 	=> 45,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'excerpt_length_tile', array(
		'settings'	=> 'excerpt_length_tile',
		'description'	=> __( 'Tile type', 'luxeritas' ),
		'section'	=> 'grid_section',
		'type'		=> 'number',
		'priority'	=> 45
	));

	// 記事一覧の抜粋を改行するかどうか（タイル型）
	$wp_customize->add_setting( 'break_excerpt_tile', array(
		'default'	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'break_excerpt_tile', array(
		'settings'	=> 'break_excerpt_tile',
		'label'		=> __( 'No line break in excerpt', 'luxeritas' ),
		'section'	=> 'grid_section',
		'type'		=> 'checkbox',
		'priority'	=> 50
	));

	// 記事一覧の抜粋の色濃度 (タイル型)
	$wp_customize->add_setting( 'excerpt_opacity_tile', array(
		'default' 	=> 60,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'excerpt_opacity_tile', array(
		'settings'	=> 'excerpt_opacity_tile',
		'section'	=> 'grid_section',
		'type'		=> 'range',
		'priority'	=> 55
	));

	// 記事一覧の抜粋の文字数 (カード型)
	$wp_customize->add_setting( 'excerpt_length_card', array(
		'default' 	=> 45,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'excerpt_length_card', array(
		'settings'	=> 'excerpt_length_card',
		'description'	=> __( 'Card type', 'luxeritas' ),
		'section'	=> 'grid_section',
		'type'		=> 'number',
		'priority'	=> 60
	));

	// 記事一覧の抜粋を改行するかどうか（カード型）
	$wp_customize->add_setting( 'break_excerpt_card', array(
		'default'	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'break_excerpt_card', array(
		'settings'	=> 'break_excerpt_card',
		'label'		=> __( 'No line break in excerpt', 'luxeritas' ),
		'section'	=> 'grid_section',
		'type'		=> 'checkbox',
		'priority'	=> 65
	));

	// 記事一覧の抜粋の色濃度 (カード型)
	$wp_customize->add_setting( 'excerpt_opacity_card', array(
		'default' 	=> 60,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'excerpt_opacity_card', array(
		'settings'	=> 'excerpt_opacity_card',
		'section'	=> 'grid_section',
		'type'		=> 'range',
		'priority'	=> 70
	));

	// 投稿・編集画面の抜粋を優先表示
	$wp_customize->add_setting( 'excerpt_priority', array(
		'default' 	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'excerpt_priority', array(
		'settings'	=> 'excerpt_priority',
		'label'		=> __( 'Excerpt on each post will be prioritized and displayed', 'luxeritas' ),
		'description'	=> '<p class="f09em mm23l">' . __( '* Description will always prioritize and display the excerpts from the blog post.', 'luxeritas' ) . '</p>',
		'section'	=> 'grid_section',
		'type'		=> 'checkbox',
		'priority'	=> 75
	));

	// 「記事を読む」の文言 (通常スタイル)
	$wp_customize->add_setting( 'read_more_text', array(
		'default' 	=> __( 'Read more', 'luxeritas' ),
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'read_more_text', array(
		'settings'	=> 'read_more_text',
		'label'		=> '&quot;' . __( 'Read more', 'luxeritas' ) . '&quot; ( ' . __( 'Normal style', 'luxeritas' ) . ' )',
		'description'	=> '<p class="f09em">' . __( '* Can hide the link if kept blank.', 'luxeritas' ) . '</p>',
		'section'	=> 'grid_section',
		'type'		=> 'text',
		'priority'	=> 80
	));

	// 「記事を読む」のリンクに短いタイトル付ける (通常スタイル)
	$wp_customize->add_setting( 'read_more_short_title', array(
		'default'	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'read_more_short_title', array(
		'settings'	=> 'read_more_short_title',
		'label'		=> __( 'Put a short title to the link of &quot;Read more&quot;', 'luxeritas' ),
		'section'	=> 'grid_section',
		'type'		=> 'checkbox',
		'priority'	=> 85
	));

	// 「記事を読む」のタイトルの文字数 (通常スタイル)
	$wp_customize->add_setting( 'short_title_length', array(
		'default' 	=> 16,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'short_title_length', array(
		'settings'	=> 'short_title_length',
		'description'	=> __( 'Number of characters in the short title', 'luxeritas' ),
		'section'	=> 'grid_section',
		'type'		=> 'number',
		'priority'	=> 90
	));

	// 「記事を読む」の文言 (タイル型)
	$wp_customize->add_setting( 'read_more_text_tile', array(
		'default' 	=> __( 'Read more', 'luxeritas' ),
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'read_more_text_tile', array(
		'settings'	=> 'read_more_text_tile',
		'label'		=> '&quot;' . __( 'Read more', 'luxeritas' ) . '&quot; ( ' . __( 'Tile type', 'luxeritas' ) . ' )',
		'description'	=> '<p class="f09em">' . __( '* Can hide the link if kept blank.', 'luxeritas' ) . '</p>',
		'section'	=> 'grid_section',
		'type'		=> 'text',
		'priority'	=> 95
	));

	// 「記事を読む」のリンクに短いタイトル付ける (タイル型)
	$wp_customize->add_setting( 'read_more_short_title_tile', array(
		'default'	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'read_more_short_title_tile', array(
		'settings'	=> 'read_more_short_title_tile',
		'label'		=> __( 'Put a short title to the link of &quot;Read more&quot;', 'luxeritas' ),
		'section'	=> 'grid_section',
		'type'		=> 'checkbox',
		'priority'	=> 100
	));

	// 「記事を読む」のタイトルの文字数 (タイル型)
	$wp_customize->add_setting( 'short_title_length_tile', array(
		'default' 	=> 8,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'short_title_length_tile', array(
		'settings'	=> 'short_title_length_tile',
		'description'	=> __( 'Number of characters in the short title', 'luxeritas' ),
		'section'	=> 'grid_section',
		'type'		=> 'number',
		'priority'	=> 105
	));

	// 「記事を読む」の文言 (カード型)
	$wp_customize->add_setting( 'read_more_text_card', array(
		'default' 	=> __( 'Read more', 'luxeritas' ),
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'read_more_text_card', array(
		'settings'	=> 'read_more_text_card',
		'label'		=> '&quot;' . __( 'Read more', 'luxeritas' ) . '&quot; ( ' . __( 'Card type', 'luxeritas' ) . ' )',
		'description'	=> '<p class="f09em">' . __( '* Can hide the link if kept blank.', 'luxeritas' ) . '</p>',
		'section'	=> 'grid_section',
		'type'		=> 'text',
		'priority'	=> 110
	));

	// 「記事を読む」のリンクに短いタイトル付ける (カード型)
	$wp_customize->add_setting( 'read_more_short_title_card', array(
		'default'	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'read_more_short_title_card', array(
		'settings'	=> 'read_more_short_title_card',
		'label'		=> __( 'Put a short title to the link of &quot;Read more&quot;', 'luxeritas' ),
		'section'	=> 'grid_section',
		'type'		=> 'checkbox',
		'priority'	=> 115
	));

	// 「記事を読む」のタイトルの文字数 (カード型)
	$wp_customize->add_setting( 'short_title_length_card', array(
		'default' 	=> 8,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'short_title_length_card', array(
		'settings'	=> 'short_title_length_card',
		'description'	=> __( 'Number of characters in the short title', 'luxeritas' ),
		'section'	=> 'grid_section',
		'type'		=> 'number',
		'priority'	=> 120
	));

	//---------------------------------------------------------------------------
	// カラム操作
	//---------------------------------------------------------------------------
	$wp_customize->add_section( 'columns_section', array(
		'title'		=> __( 'Column adjustment', 'luxeritas' ),
		'priority'	=> 25
	));

	// カラム数 (全体デフォルト)
	$wp_customize->add_setting( 'column3', array(
		'default'	=> '2column',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'column3', array(
		'settings'	=> 'column3',
		'label'		=> __( 'Number of column', 'luxeritas' ),
		'description'	=> '<p class="f09em">' . __( 'default', 'luxeritas' ) . '</p>',
		'section'	=> 'columns_section',
		'type'		=> 'select',
		'choices'	=> array(
			'1column'	=> '1 ' . __( 'column', 'luxeritas' ),
			'2column'	=> '2 ' . __( 'column', 'luxeritas' ),
			'3column'	=> '3 ' . __( 'column', 'luxeritas' )
		),
		'priority'	=> 5
	));

	// カラム数 (フロントページ)
	$wp_customize->add_setting( 'column_home', array(
		'default'	=> 'default',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'column_home', array(
		'settings'	=> 'column_home',
		//'label'		=> __( 'カラム数 (フロントページ)', 'luxeritas' ),
		'description'	=> '<p class="f09em m0t">' . __( 'Number of columns in each template', 'luxeritas' ) . '</p>',
		'section'	=> 'columns_section',
		'type'		=> 'select',
		'choices'	=> array(
			'default'	=> __( 'Front page', 'luxeritas' ),
			'1column'	=> '1 ' . __( 'column', 'luxeritas' ),
			'2column'	=> '2 ' . __( 'column', 'luxeritas' ),
			'3column'	=> '3 ' . __( 'column', 'luxeritas' )
		),
		'priority'	=> 10
	));

	// カラム数 (投稿ページ)
	$wp_customize->add_setting( 'column_post', array(
		'default'	=> 'default',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'column_post', array(
		'settings'	=> 'column_post',
		//'label'		=> __( 'カラム数 (投稿ページ)', 'luxeritas' ),
		'section'	=> 'columns_section',
		'type'		=> 'select',
		'choices'	=> array(
			'default'	=> __( 'Posts page', 'luxeritas' ),
			'1column'	=> '1 ' . __( 'column', 'luxeritas' ),
			'2column'	=> '2 ' . __( 'column', 'luxeritas' ),
			'3column'	=> '3 ' . __( 'column', 'luxeritas' )
		),
		'priority'	=> 15
	));

	// カラム数 (固定ページ)
	$wp_customize->add_setting( 'column_page', array(
		'default'	=> 'default',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'column_page', array(
		'settings'	=> 'column_page',
		//'label'		=> __( 'カラム数 (固定ページ)', 'luxeritas' ),
		'section'	=> 'columns_section',
		'type'		=> 'select',
		'choices'	=> array(
			'default'	=> __( 'Static page', 'luxeritas' ),
			'1column'	=> '1 ' . __( 'column', 'luxeritas' ),
			'2column'	=> '2 ' . __( 'column', 'luxeritas' ),
			'3column'	=> '3 ' . __( 'column', 'luxeritas' )
		),
		'priority'	=> 20
	));

	// カラム数 (アーカイブページ)
	$wp_customize->add_setting( 'column_archive', array(
		'default'	=> 'default',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'column_archive', array(
		'settings'	=> 'column_archive',
		//'label'		=> __( 'カラム数 (アーカイブページ)', 'luxeritas' ),
		'section'	=> 'columns_section',
		'type'		=> 'select',
		'choices'	=> array(
			'default'	=> __( 'Category', 'luxeritas' ) . ' / ' . __( 'Archive', 'luxeritas' ),
			'1column'	=> '1 ' . __( 'column', 'luxeritas' ),
			'2column'	=> '2 ' . __( 'column', 'luxeritas' ),
			'3column'	=> '3 ' . __( 'column', 'luxeritas' )
		),
		'priority'	=> 25
	));

	// サイドバーの位置 (2カラム)
	$wp_customize->add_setting( 'side_position', array(
		'default'	=> 'right',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'side_position', array(
		'settings'	=> 'side_position',
		'label'		=> __( 'Position of the side bar', 'luxeritas' ),
		'description'	=> __( '2 column', 'luxeritas' ),
		'section'	=> 'columns_section',
		'type'		=> 'select',
		'choices'	=> array(
			'right'		=> __( 'Right sidebar', 'luxeritas' ),
			'left'		=> __( 'Left sidebar', 'luxeritas' )
		),
		'priority'	=> 30
	));

	// サイドバーの位置 (3カラム)
	$wp_customize->add_setting( 'column3_position', array(
		'default'	=> 'center',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'column3_position', array(
		'settings'	=> 'column3_position',
		'description'	=> __( '3 column', 'luxeritas' ),
		'section'	=> 'columns_section',
		'type'		=> 'select',
		'choices'	=> array(
			'center'	=> __( 'Both sides sidebar', 'luxeritas' ),
			'right'		=> __( 'Right sidebar', 'luxeritas' ),
			'left'		=> __( 'Left sidebar', 'luxeritas' )
		),
		'priority'	=> 35
	));

	// 3カラム左右サイドバー反転
	$wp_customize->add_setting( 'column3_reverse', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'column3_reverse', array(
		'settings'	=> 'column3_reverse',
		'label'		=> __( '3 column left and right side bar reversal', 'luxeritas' ),
		'section'	=> 'columns_section',
		'type'		=> 'checkbox',
		'priority'	=> 40
	));

	// コンテンツ領域の分離・結合
	$wp_customize->add_setting( 'content_discrete', array(
		'default'	=> 'discrete',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'content_discrete', array(
		'settings'	=> 'content_discrete',
		'label'		=> __( 'Merge and separate areas', 'luxeritas' ),
		'description'	=> '<p class="bold snormal mm5b">' . __( 'Content area', 'luxeritas' ) . '</p>',
		'section'	=> 'columns_section',
		'type'		=> 'radio',
		'choices'	=> array(
			'discrete'	=> __( 'Separate content area for each element', 'luxeritas' ),
			'indiscrete'	=> __( 'Merge the elements in content area', 'luxeritas' )
		),
		'priority'	=> 45
	));

	// サイドバー領域の分離と結合
	$wp_customize->add_setting( 'side_discrete', array(
		'default'	=> 'indiscrete',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'side_discrete', array(
		'settings'	=> 'side_discrete',
		'label'		=> __( 'Sidebar ', 'luxeritas' ),
		'section'	=> 'columns_section',
		'type'		=> 'radio',
		'choices'	=> array(
			'discrete'	=> __( 'Separate the side bar for each element', 'luxeritas' ),
			'indiscrete'	=> __( 'Merge the elements in side bar', 'luxeritas' )
		),
		'priority'	=> 50
	));

	// コンテンツ領域とサイドバーの分離・結合
	$wp_customize->add_setting( 'content_side_discrete', array(
		'default'	=> 'discrete',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'content_side_discrete', array(
		'settings'	=> 'content_side_discrete',
		'label'		=> __( 'Merge and separate content area and side bar', 'luxeritas' ),
		'section'	=> 'columns_section',
		'type'		=> 'radio',
		'choices'	=> array(
			'discrete'	=> __( 'Separate content area and side bar', 'luxeritas' ),
			'indiscrete'	=> __( 'Merge content area and side bar', 'luxeritas' )
		),
		'priority'	=> 55
	));

	$wp_customize->add_setting( 'dummy3', array( 'sanitize_callback' => 'thk_sanitize' ) );
	$wp_customize->add_control( 'dummy3', array(
		'settings'	=> 'dummy3',
		'description'	=> '<p class="f09em">' . __( '* When they are merged, some configuration of content area will overwrite the side bar configuration.', 'luxeritas' ) . '</p>',
		'section'	=> 'columns_section',
		'type'		=> 'hidden',
		'priority'	=> 60
	));

	//---------------------------------------------------------------------------
	// ヘッダー・フッター
	//---------------------------------------------------------------------------
	$wp_customize->add_section( 'head_foot_section', array(
		'title'		=> __( 'Header ', 'luxeritas' ) . ' / ' . __( 'Footer', 'luxeritas' ),
		'priority'	=> 27
	));

	// タイトルの配置
	$wp_customize->add_setting( 'title_position', array(
		'default'	=> 'left',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'title_position', array(
		'settings'	=> 'title_position',
		'label'		=> __( 'Title layout', 'luxeritas' ),
		'section'	=> 'head_foot_section',
		'type'		=> 'select',
		'choices'	=> array(
			'left'		=> __( 'left', 'luxeritas' ),
			'center'	=> __( 'center', 'luxeritas' ),
			'right'		=> __( 'right', 'luxeritas' )
		),
		'priority'	=> 5
	));

	// ヘッダー margin-top
	$wp_customize->add_setting( 'head_margin_top', array(
		'default'	=> 0,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'head_margin_top', array(
		'settings'	=> 'head_margin_top',
		'label'		=> __( 'Header margin', 'luxeritas' ),
		'description'	=> __( 'Header ', 'luxeritas' ) . __( 'top', 'luxeritas' ) . ' ( 0px )',
		'section'	=> 'head_foot_section',
		'type'		=> 'number',
		'priority'	=> 10
	));

	// ヘッダー padding-top
	$wp_customize->add_setting( 'head_padding_top', array(
		'default'	=> 20,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'head_padding_top', array(
		'settings'	=> 'head_padding_top',
		'label'		=> __( 'Header padding', 'luxeritas' ),
		'description'	=> __( 'Header ', 'luxeritas' ) . __( 'top', 'luxeritas' ) . ' ( 20px )',
		'section'	=> 'head_foot_section',
		'type'		=> 'number',
		'priority'	=> 15
	));

	// ヘッダー padding-right
	$wp_customize->add_setting( 'head_padding_right', array(
		'default'	=> 10,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'head_padding_right', array(
		'settings'	=> 'head_padding_right',
		'description'	=> __( 'Header ', 'luxeritas' ) . __( 'right', 'luxeritas' ) . ' ( 10px )',
		'section'	=> 'head_foot_section',
		'type'		=> 'number',
		'priority'	=> 20
	));

	// ヘッダー padding-bottom
	$wp_customize->add_setting( 'head_padding_bottom', array(
		'default'	=> 20,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'head_padding_bottom', array(
		'settings'	=> 'head_padding_bottom',
		'description'	=> __( 'Header ', 'luxeritas' ) . __( 'bottom', 'luxeritas' ) . ' ( 20px )',
		'section'	=> 'head_foot_section',
		'type'		=> 'number',
		'priority'	=> 25
	));

	// ヘッダー padding-left
	$wp_customize->add_setting( 'head_padding_left', array(
		'default'	=> 10,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'head_padding_left', array(
		'settings'	=> 'head_padding_left',
		'description'	=> __( 'Header ', 'luxeritas' ) . __( 'left', 'luxeritas' ) . ' ( 10px )',
		'section'	=> 'head_foot_section',
		'type'		=> 'number',
		'priority'	=> 30
	));

	// ヘッダーの位置
	$wp_customize->add_setting( 'bootstrap_header', array(
		'default'	=> 'out',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'bootstrap_header', array(
		'settings'	=> 'bootstrap_header',
		'label'		=> __( 'Position of the header', 'luxeritas' ),
		'section'	=> 'head_foot_section',
		'type'		=> 'select',
		'choices'	=> array(
			'in'		=> __( 'Inside the Container', 'luxeritas' ),
			'out'		=> __( 'Outside the Container', 'luxeritas' )
		),
		'priority'	=> 35
	));

	// ヘッダーを枠線で囲む
	$wp_customize->add_setting( 'header_border', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'header_border', array(
		'settings'	=> 'header_border',
		'label'		=> __( 'Surround the header with border', 'luxeritas' ),
		'section'	=> 'head_foot_section',
		'type'		=> 'checkbox',
		'priority'	=> 40
	));

	// ヘッダーを枠線で囲む
	$wp_customize->add_setting( 'header_border_wide', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'header_border_wide', array(
		'settings'	=> 'header_border_wide',
		'label'		=> __( 'Full width for the header border', 'luxeritas' ),
		'description'	=> __( '(Valid only when outside the container)', 'luxeritas' ),
		'section'	=> 'head_foot_section',
		'type'		=> 'checkbox',
		'priority'	=> 45
	));

	// フッターの位置
	$wp_customize->add_setting( 'bootstrap_footer', array(
		'default'	=> 'out',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'bootstrap_footer', array(
		'settings'	=> 'bootstrap_footer',
		'label'		=> __( 'Position of footer', 'luxeritas' ),
		'section'	=> 'head_foot_section',
		'type'		=> 'select',
		'choices'	=> array(
			'in'		=> __( 'Inside the Container', 'luxeritas' ),
			'out'		=> __( 'Outside the Container', 'luxeritas' )
		),
		'priority'	=> 50
	));

	// フッターを枠線で囲む
	$wp_customize->add_setting( 'footer_border', array(
		'default'	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'footer_border', array(
		'settings'	=> 'footer_border',
		'label'		=> __( 'Surround the footer with border', 'luxeritas' ),
		'section'	=> 'head_foot_section',
		'type'		=> 'checkbox',
		'priority'	=> 55
	));

	// コピーライト表示部分の上に枠線つける
	$wp_customize->add_setting( 'copyright_border', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'copyright_border', array(
		'settings'	=> 'copyright_border',
		'label'		=> __( 'Put a line above the copyright area', 'luxeritas' ),
		'section'	=> 'head_foot_section',
		'type'		=> 'checkbox',
		'priority'	=> 60
	));

	// モバイル・スマホでフッターを非表示にする
	$wp_customize->add_setting( 'hide_mobile_footer', array(
		'default'	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'hide_mobile_footer', array(
		'settings'	=> 'hide_mobile_footer',
		'label'		=> __( 'Hide in mobile or smartphone', 'luxeritas' ),
		'section'	=> 'head_foot_section',
		'type'		=> 'checkbox',
		'priority'	=> 65
	));

	// フッターウィジェットエリア表示数
	$wp_customize->add_setting( 'foot_widget', array(
		'default'	=> 3,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'foot_widget', array(
		'settings'	=> 'foot_widget',
		'label'		=> __( 'Footer widget area display', 'luxeritas' ),
		'section'	=> 'head_foot_section',
		'type'		=> 'select',
		'choices'	=> array(
			3	=> __( '3 rows (left, center, and right)', 'luxeritas' ),
			2	=> __( '2 rows (left and right)', 'luxeritas' ),
			1	=> __( 'Horizontal row (center)', 'luxeritas' ),
			0	=> __( 'Hide', 'luxeritas' )
		),
		'priority'	=> 70
	));

	//---------------------------------------------------------------------------
	// コンテンツ領域とサイドバー
	//---------------------------------------------------------------------------
	$wp_customize->add_section( 'cont_side_section', array(
		'title'		=> __( 'Content area and side bar', 'luxeritas' ),
		'description'	=> '<p class="bold f11em mm15b">' . __( 'Content area', 'luxeritas' ) . '</p>',
		'priority'	=> 28
	));

	// コンテンツ領域に枠線をつける
	$wp_customize->add_setting( 'contents_border', array(
		'default' 	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'contents_border', array(
		'settings'	=> 'contents_border',
		'label'		=> __( 'Put border around the content area', 'luxeritas' ),
		'section'	=> 'cont_side_section',
		'type'		=> 'checkbox',
		'priority'	=> 5
	));

	// ページャー表示領域に枠線(コンテンツ領域分離時のみ)
	$wp_customize->add_setting( 'pagination_area_border', array(
		'default' 	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'pagination_area_border', array(
		'settings'	=> 'pagination_area_border',
		'label'		=> __( 'Apply frame border around pagination area', 'luxeritas' ),
		'description'	=> __( '* Only when content area is separated', 'luxeritas' ),
		'section'	=> 'cont_side_section',
		'type'		=> 'checkbox',
		'priority'	=> 6
	));

	// コンテンツ領域枠線の丸み
	$wp_customize->add_setting( 'cont_border_radius', array(
		'default'	=> 0,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'cont_border_radius', array(
		'settings'	=> 'cont_border_radius',
		'label'		=> __( 'Border radius', 'luxeritas' ),
		'section'	=> 'cont_side_section',
		'type'		=> 'number',
		'priority'	=> 10
	));

	// コンテンツ領域 padding-top
	$wp_customize->add_setting( 'cont_padding_top', array(
		'default'	=> 45,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'cont_padding_top', array(
		'settings'	=> 'cont_padding_top',
		'label'		=> __( 'Content area padding', 'luxeritas' ),
		//'description'	=> __( 'Content ', 'luxeritas' ) . __( 'top', 'luxeritas' ) . ' ( 45px )',
		'description'	=> '</span><span><p>' . __( '* The actual width will vary depending on the screen width.', 'luxeritas' ) . '</p></span><span class="description customize-control-description">' . __( 'Content ', 'luxeritas' ) . __( 'top', 'luxeritas' ) . ' ( 45px )</span>',
		'section'	=> 'cont_side_section',
		'type'		=> 'number',
		'priority'	=> 15
	));

	// コンテンツ領域 padding-right
	$wp_customize->add_setting( 'cont_padding_right', array(
		'default'	=> 68,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'cont_padding_right', array(
		'settings'	=> 'cont_padding_right',
		'description'	=> __( 'Content ', 'luxeritas' ) . __( 'right', 'luxeritas' ) . ' ( 68px )',
		'section'	=> 'cont_side_section',
		'type'		=> 'number',
		'priority'	=> 20
	));

	// コンテンツ領域 padding-bottom
	$wp_customize->add_setting( 'cont_padding_bottom', array(
		'default'	=> 45,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'cont_padding_bottom', array(
		'settings'	=> 'cont_padding_bottom',
		'description'	=> __( 'Content ', 'luxeritas' ) . __( 'bottom', 'luxeritas' ) . ' ( 45px )',
		'section'	=> 'cont_side_section',
		'type'		=> 'number',
		'priority'	=> 25
	));

	// コンテンツ領域 padding-left
	$wp_customize->add_setting( 'cont_padding_left', array(
		'default'	=> 68,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'cont_padding_left', array(
		'settings'	=> 'cont_padding_left',
		'description'	=> __( 'Content ', 'luxeritas' ) . __( 'left', 'luxeritas' ) . ' ( 68px )',
		'section'	=> 'cont_side_section',
		'type'		=> 'number',
		'priority'	=> 30
	));

	// サイドバーの幅
	$wp_customize->add_setting( 'side_1_width', array(
		'default'	=> 336,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'side_1_width', array(
		'settings'	=> 'side_1_width',
		'label'		=> __( 'Sidebar Widget width', 'luxeritas' ),
		'description'	=> __( 'Second column', 'luxeritas' ),
		'section'	=> 'cont_side_section',
		'type'		=> 'number',
		'priority'	=> 35
	));

	// サイドバーの幅 (3カラム目)
	$wp_customize->add_setting( 'side_2_width', array(
		'default'	=> 250,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'side_2_width', array(
		'settings'	=> 'side_2_width',
		'description'	=> __( 'Third column', 'luxeritas' ),
		'section'	=> 'cont_side_section',
		'type'		=> 'number',
		'priority'	=> 36
	));

	// サイドバーの位置
	$wp_customize->add_setting( 'dummy4', array( 'sanitize_callback' => 'thk_sanitize' ) );
	$wp_customize->add_control( 'dummy4', array(
		'settings'	=> 'dummy4',
		'label'		=> __( 'Position of the side bar', 'luxeritas' ),
		'description'	=> __( '* You can change the side bar position in the Column adjustment menu.', 'luxeritas' ),
		'section'	=> 'cont_side_section',
		'type'		=> 'hidden',
		'priority'	=> 40
	));

	// モバイル・スマホでサイドバーを非表示にする
	$wp_customize->add_setting( 'hide_mobile_sidebar', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'hide_mobile_sidebar', array(
		'settings'	=> 'hide_mobile_sidebar',
		'label'		=> __( 'Hide in mobile or smartphone', 'luxeritas' ),
		'section'	=> 'cont_side_section',
		'type'		=> 'checkbox',
		'priority'	=> 45
	));

	// サイドバーを枠線で囲む
	$wp_customize->add_setting( 'sidebar_border', array(
		'default'	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'sidebar_border', array(
		'settings'	=> 'sidebar_border',
		'label'		=> __( 'Surround the sidebar with border', 'luxeritas' ),
		'section'	=> 'cont_side_section',
		'type'		=> 'checkbox',
		'priority'	=> 50
	));

	// サイドバー枠線の丸み
	$wp_customize->add_setting( 'side_border_radius', array(
		'default'	=> 0,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'side_border_radius', array(
		'settings'	=> 'side_border_radius',
		'label'		=> __( 'Border radius', 'luxeritas' ),
		'section'	=> 'cont_side_section',
		'type'		=> 'number',
		'priority'	=> 55
	));

	//---------------------------------------------------------------------------
	// ディスカッション
	//---------------------------------------------------------------------------
	$wp_customize->add_section( 'discussion_section', array(
		'title'		=> __( 'Discussion', 'luxeritas' ),
		'description'	=> '<p class="bold f11em mm15b">' . __( 'Post page', 'luxeritas' ) . '</p>',
		'priority'	=> 29
	));

	// コメント欄の表示有無
	$wp_customize->add_setting( 'comment_visible', array(
		'default'	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'comment_visible', array(
		'settings'	=> 'comment_visible',
		'label'		=> __( 'Display Comment', 'luxeritas' ),
		'section'	=> 'discussion_section',
		'type'		=> 'checkbox',
		'priority'	=> 10
	));

	// トラックバック URL の表示有無
	$wp_customize->add_setting( 'trackback_visible', array(
		'default'	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'trackback_visible', array(
		'settings'	=> 'trackback_visible',
		'label'		=> __( 'Display Trackback URL', 'luxeritas' ),
		'description'	=> '<p class="bold snormal f11em mm23l mm10b">' . __( 'Static page', 'luxeritas' ) . '</p>',
		'section'	=> 'discussion_section',
		'type'		=> 'checkbox',
		'priority'	=> 15
	));

	// コメント欄（固定ページ）の表示有無
	$wp_customize->add_setting( 'comment_page_visible', array(
		'default'	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'comment_page_visible', array(
		'settings'	=> 'comment_page_visible',
		'label'		=> __( 'Display Comment', 'luxeritas' ),
		'section'	=> 'discussion_section',
		'type'		=> 'checkbox',
		'priority'	=> 20
	));

	// トラックバック URL（固定ページ）の表示有無
	$wp_customize->add_setting( 'trackback_page_visible', array(
		'default'	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'trackback_page_visible', array(
		'settings'	=> 'trackback_page_visible',
		'label'		=> __( 'Display Trackback URL', 'luxeritas' ),
		'section'	=> 'discussion_section',
		'type'		=> 'checkbox',
		'priority'	=> 25
	));

	// コメント一覧の表示方法
	$wp_customize->add_setting( 'comment_list_view', array(
		'default'	=> 'separate',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'comment_list_view', array(
		'settings'	=> 'comment_list_view',
		'label'		=> __( 'Display layout of the comment list', 'luxeritas' ),
		'section'	=> 'discussion_section',
		'type'		=> 'radio',
		'choices'	=> array(
			'separate'	=> __( 'Display comments and pings separated', 'luxeritas' ),
			'all'		=> __( 'Display comments and pings together', 'luxeritas' ),
			'no_pings'	=> __( 'Do not display pingbacks and trackbacks', 'luxeritas' )
		),
		'priority'	=> 30
	));

	// ピン・トラックバックの返信ボタン
	$wp_customize->add_setting( 'pings_reply_button', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'pings_reply_button', array(
		'settings'	=> 'pings_reply_button',
		'label'		=> __( 'Add reply button to pinback', 'luxeritas' ),
		'section'	=> 'discussion_section',
		'type'		=> 'checkbox',
		'priority'	=> 35
	));

	//---------------------------------------------------------------------------
	// 細部の見た目
	//---------------------------------------------------------------------------
	$wp_customize->add_section( 'view_section', array(
		'title'		=> __( 'Style Details', 'luxeritas' ),
		'priority'	=> 30
	));

	// ヘッダーのキャッチフレーズを変更
	$wp_customize->add_setting( 'header_catchphrase_change', array(
		'default'	=> get_bloginfo('description'),
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'header_catchphrase_change', array(
		'settings'	=> 'header_catchphrase_change',
		'label'		=> __( 'Tagline change on header', 'luxeritas' ),
		'description'	=> '<p class="f09em">' . __( '* To overwrite the tagline on the header to something other than what is set on the Wordpress General Settings.', 'luxeritas' ) . '</p>',
		'section'	=> 'view_section',
		'type'		=> 'text',
		'priority'	=> 35
	));

	// ヘッダーのキャッチフレーズ表示
	$wp_customize->add_setting( 'header_catchphrase_visible', array(
		'default'	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'header_catchphrase_visible', array(
		'settings'	=> 'header_catchphrase_visible',
		'label'		=> __( 'Tagline display on header', 'luxeritas' ),
		'section'	=> 'view_section',
		'type'		=> 'checkbox',
		'priority'	=> 40
	));

	// 「ホーム」の名称
	$wp_customize->add_setting( 'home_text', array(
		'default'	=> __( 'Home', 'luxeritas' ),
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'home_text', array(
		'settings'	=> 'home_text',
		'label'		=> __( 'Text for &quot;Home&quot;', 'luxeritas' ),
		'section'	=> 'view_section',
		'type'		=> 'text',
		'priority'	=> 42
	));

	// PAGE TOP ボタン
	$wp_customize->add_setting( 'page_top_text', array(
		'default'	=> 'PAGE TOP',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'page_top_text', array(
		'settings'	=> 'page_top_text',
		'label'		=> __( 'Text for &quot;PAGE TOP&quot; scroll button', 'luxeritas' ),
		'description'	=> '<p class="f09em">' . __( '* Only icon will be displayed if kept blank.', 'luxeritas' ) . '</p>',
		'section'	=> 'view_section',
		'type'		=> 'text',
		'priority'	=> 45
	));

	// PAGE TOP ボタンのアイコンの種類
	$wp_customize->add_setting( 'page_top_icon', array(
		'default'	=> 'fa_arrow_up',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'page_top_icon', array(
		'settings'	=> 'page_top_icon',
		'label'		=> __( 'Type of &quot;PAGE TOP&quot; button icon', 'luxeritas' ),
		'section'	=> 'view_section',
		'type'		=> 'radio',
		'choices'	=> array(
			'fa_arrow_up'		=> 'fa-arrow-up',
			'fa_caret_up'		=> 'fa-caret-up',
			'fa_chevron_up'		=> 'fa-chevron-up',
			'fa_chevron_circle_up'	=> 'fa-chevron-circle-up',
			'fa_arrow_circle_up'	=> 'fa-arrow-circle-up',
			'fa_angle_double_up'	=> 'fa-angle-double-up'
		),
		'priority'	=> 50
	));

	// PAGE TOP 丸み
	$wp_customize->add_setting( 'page_top_radius', array(
		'default'	=> 0,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'page_top_radius', array(
		'settings'	=> 'page_top_radius',
		'label'		=> __( 'Border radius', 'luxeritas' ),
		'section'	=> 'view_section',
		'type'		=> 'number',
		'priority'	=> 52
	));

	// PAGE TOP 文字色
	$wp_customize->add_setting( 'page_top_color', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'page_top_color', array(
		'settings'	=> 'page_top_color',
		'label'		=> 'PAGE TOP ' . __( 'Text color', 'luxeritas' ),
		'section'	=> 'view_section',
		'priority'	=> 55
	)));

	// PAGE TOP 背景色
	$wp_customize->add_setting( 'page_top_bg_color', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'page_top_bg_color', array(
		'settings'	=> 'page_top_bg_color',
		'label'		=> 'PAGE TOP ' . __( 'Background color', 'luxeritas' ),
		'section'	=> 'view_section',
		'priority'	=> 60
	)));

	//---------------------------------------------------------------------------
	// メタ情報の表示位置
	//---------------------------------------------------------------------------
	$wp_customize->add_section( 'meta_section', array(
		'title'		=> __( 'Display position of meta information', 'luxeritas' ),
		'description'	=> '<p class="bold snormal f11em">' . __( 'Post and Static page', 'luxeritas' ) . '<br /><p class="f09em">' . __( '* If you hide the publish date or the update date, a structured data error will result.', 'luxeritas' ) . '</p><p class="bold snormal f11em">' . __( 'What meta information to dsiplay under the article title', 'luxeritas' ) . '</p>',
		'priority'	=> 31
	));

	// 投稿日時表示
	$wp_customize->add_setting( 'post_date_visible', array(
		'default'	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'post_date_visible', array(
		'settings'	=> 'post_date_visible',
		'label'		=> __( 'Published date and time', 'luxeritas' ),
		'section'	=> 'meta_section',
		'type'		=> 'checkbox',
		'priority'	=> 5
	));

	// 更新日時表示
	$wp_customize->add_setting( 'mod_date_visible', array(
		'default'	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'mod_date_visible', array(
		'settings'	=> 'mod_date_visible',
		'label'		=> __( 'Updated date and time', 'luxeritas' ),
		'section'	=> 'meta_section',
		'type'		=> 'checkbox',
		'priority'	=> 10
	));

	// カテゴリー名表示
	$wp_customize->add_setting( 'category_meta_visible', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'category_meta_visible', array(
		'settings'	=> 'category_meta_visible',
		'label'		=> __( 'Category name', 'luxeritas' ),
		'section'	=> 'meta_section',
		'type'		=> 'checkbox',
		'priority'	=> 15
	));

	// タグ表示
	$wp_customize->add_setting( 'tag_meta_visible', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'tag_meta_visible', array(
		'settings'	=> 'tag_meta_visible',
		'label'		=> __( 'Tag', 'luxeritas' ),
		'section'	=> 'meta_section',
		'type'		=> 'checkbox',
		'priority'	=> 20
	));

	// タクソノミー表示
	$wp_customize->add_setting( 'tax_meta_visible', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'tax_meta_visible', array(
		'settings'	=> 'tax_meta_visible',
		'label'		=> __( 'Taxonomy', 'luxeritas' ),
		'description'	=> '<p class="bold snormal f11em m23t mm10b mm23l">' . __( 'What meta information to dsiplay under article', 'luxeritas' ) . '</p>',
		'section'	=> 'meta_section',
		'type'		=> 'checkbox',
		'priority'	=> 20
	));

	// 投稿日時表示 (記事下)
	$wp_customize->add_setting( 'post_date_u_visible', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'post_date_u_visible', array(
		'settings'	=> 'post_date_u_visible',
		'label'		=> __( 'Published date and time', 'luxeritas' ),
		'section'	=> 'meta_section',
		'type'		=> 'checkbox',
		'priority'	=> 25
	));

	// 更新日時表示 (記事下)
	$wp_customize->add_setting( 'mod_date_u_visible', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'mod_date_u_visible', array(
		'settings'	=> 'mod_date_u_visible',
		'label'		=> __( 'Updated date and time', 'luxeritas' ),
		'section'	=> 'meta_section',
		'type'		=> 'checkbox',
		'priority'	=> 30
	));

	// カテゴリー名表示 (記事下)
	$wp_customize->add_setting( 'category_meta_u_visible', array(
		'default'	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'category_meta_u_visible', array(
		'settings'	=> 'category_meta_u_visible',
		'label'		=> __( 'Category name', 'luxeritas' ),
		'section'	=> 'meta_section',
		'type'		=> 'checkbox',
		'priority'	=> 35
	));

	// タグ表示 (記事下)
	$wp_customize->add_setting( 'tag_meta_u_visible', array(
		'default'	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'tag_meta_u_visible', array(
		'settings'	=> 'tag_meta_u_visible',
		'label'		=> __( 'Tag', 'luxeritas' ),
		'section'	=> 'meta_section',
		'type'		=> 'checkbox',
		'priority'	=> 40
	));

	// タクソノミー表示 (記事下)
	$wp_customize->add_setting( 'tax_meta_u_visible', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'tax_meta_u_visible', array(
		'settings'	=> 'tax_meta_u_visible',
		'label'		=> __( 'Taxonomy', 'luxeritas' ),
		'description'	=> '<hr><p class="bold snormal f11em m23t mm10b mm23l">' . __( 'List type page', 'luxeritas' ) . '</p><p class="bold snormal f11em m23t mm10b mm23l">' . __( 'What meta information to dsiplay under the article title', 'luxeritas' ) . '</p>',
		'section'	=> 'meta_section',
		'type'		=> 'checkbox',
		'priority'	=> 42
	));

	// リストページ 投稿日時表示
	$wp_customize->add_setting( 'list_post_date_visible', array(
		'default'	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'list_post_date_visible', array(
		'settings'	=> 'list_post_date_visible',
		'label'		=> __( 'Published date and time', 'luxeritas' ),
		'section'	=> 'meta_section',
		'type'		=> 'checkbox',
		'priority'	=> 45
	));

	// リストページ 更新日時表示
	$wp_customize->add_setting( 'list_mod_date_visible', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'list_mod_date_visible', array(
		'settings'	=> 'list_mod_date_visible',
		'label'		=> __( 'Updated date and time', 'luxeritas' ),
		'section'	=> 'meta_section',
		'type'		=> 'checkbox',
		'priority'	=> 50
	));

	// リストページ カテゴリー名表示
	$wp_customize->add_setting( 'list_category_meta_visible', array(
		'default'	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'list_category_meta_visible', array(
		'settings'	=> 'list_category_meta_visible',
		'label'		=> __( 'Category name', 'luxeritas' ),
		'section'	=> 'meta_section',
		'type'		=> 'checkbox',
		'priority'	=> 55
	));

	// リストページ タグ表示
	$wp_customize->add_setting( 'list_tag_meta_visible', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'list_tag_meta_visible', array(
		'settings'	=> 'list_tag_meta_visible',
		'label'		=> __( 'Tag', 'luxeritas' ),
		'section'	=> 'meta_section',
		'type'		=> 'checkbox',
		'priority'	=> 60
	));

	// リストページ タクソノミー表示
	$wp_customize->add_setting( 'list_tax_meta_visible', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'list_tax_meta_visible', array(
		'settings'	=> 'list_tax_meta_visible',
		'label'		=> __( 'Taxonomy', 'luxeritas' ),
		'description'	=> '<p class="bold snormal f11em m23t mm10b mm23l">' . __( 'Meta information displayed above excerpt', 'luxeritas' ) . '</p>',
		'section'	=> 'meta_section',
		'type'		=> 'checkbox',
		'priority'	=> 62
	));

	// リストページ 投稿日時表示 (抜粋下)
	$wp_customize->add_setting( 'list_post_date_u_visible', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'list_post_date_u_visible', array(
		'settings'	=> 'list_post_date_u_visible',
		'label'		=> __( 'Published date and time', 'luxeritas' ),
		'section'	=> 'meta_section',
		'type'		=> 'checkbox',
		'priority'	=> 65
	));

	// リストページ 更新日時表示 (抜粋下)
	$wp_customize->add_setting( 'list_mod_date_u_visible', array(
		'default'	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'list_mod_date_u_visible', array(
		'settings'	=> 'list_mod_date_u_visible',
		'label'		=> __( 'Updated date and time', 'luxeritas' ),
		'section'	=> 'meta_section',
		'type'		=> 'checkbox',
		'priority'	=> 70
	));

	// リストページ カテゴリー名表示 (抜粋下)
	$wp_customize->add_setting( 'list_category_meta_u_visible', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'list_category_meta_u_visible', array(
		'settings'	=> 'list_category_meta_u_visible',
		'label'		=> __( 'Category name', 'luxeritas' ),
		'section'	=> 'meta_section',
		'type'		=> 'checkbox',
		'priority'	=> 75
	));

	// リストページ タグ表示 (抜粋下)
	$wp_customize->add_setting( 'list_tag_meta_u_visible', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'list_tag_meta_u_visible', array(
		'settings'	=> 'list_tag_meta_u_visible',
		'label'		=> __( 'Tag', 'luxeritas' ),
		'section'	=> 'meta_section',
		'type'		=> 'checkbox',
		'priority'	=> 80
	));

	// リストページ タクソノミー表示 (抜粋下)
	$wp_customize->add_setting( 'list_tax_meta_u_visible', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'list_tax_meta_u_visible', array(
		'settings'	=> 'list_tax_meta_u_visible',
		'label'		=> __( 'Taxonomy', 'luxeritas' ),
		'section'	=> 'meta_section',
		'type'		=> 'checkbox',
		'priority'	=> 85
	));

	//---------------------------------------------------------------------------
	// サムネイル (アイキャッチ) 
	//---------------------------------------------------------------------------
	$wp_customize->add_section( 'thumbnail_section', array(
		'title'		=> __( 'Thumbnail (Featured Image)', 'luxeritas' ),
		'description'	=> '<p class="bold f11em mm15b">' . __( 'Thumbnail dispay on/off', 'luxeritas' ) . '</p>',
		'priority'	=> 32
	));

	// サムネイルを表示する
	$wp_customize->add_setting( 'thumbnail_visible', array(
		'default' 	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'thumbnail_visible', array(
		'settings'	=> 'thumbnail_visible',
		'label'		=> __( 'Display thumbnail', 'luxeritas' ),
		'section'	=> 'thumbnail_section',
		'type'		=> 'checkbox',
		'priority'	=> 5
	));

	// No Image のサムネイルを表示する
	$wp_customize->add_setting( 'noimage_visible', array(
		'default' 	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'noimage_visible', array(
		'settings'	=> 'noimage_visible',
		'label'		=> __( 'Thumbnail display when No Image', 'luxeritas' ),
		'section'	=> 'thumbnail_section',
		'type'		=> 'checkbox',
		'priority'	=> 10
	));

	// サムネイルに枠線つける
	$wp_customize->add_setting( 'thumbnail_border', array(
		'default' 	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'thumbnail_border', array(
		'settings'	=> 'thumbnail_border',
		'label'		=> __( 'Add border', 'luxeritas' ),
		'section'	=> 'thumbnail_section',
		'type'		=> 'checkbox',
		'priority'	=> 12
	));

	// 画像に対するテキスト(抜粋)の配置
	$wp_customize->add_setting( 'thumbnail_layout', array(
		'default' 	=> 'right',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'thumbnail_layout', array(
		'settings'	=> 'thumbnail_layout',
		'label'		=> __( 'Where to place the text (excerpt) around the image', 'luxeritas' ),
		'description'	=> '<p class="f09em">' . __( '* It will always wrap around the image in small devices.', 'luxeritas' ) . '</p>',
		'section'	=> 'thumbnail_section',
		'type'		=> 'radio',
		'choices'	=> array(
			'right'	=> __( 'Text right to image (do not allow the text wrap below the image)', 'luxeritas' ),
			'flow'	=> __( 'Text right to image (allow the text wrap below the image)', 'luxeritas' ),
			'under'	=> __( 'Text below the image', 'luxeritas' ) . ' ( ' . __( 'Normal style', 'luxeritas' ) . ' )',
		),
		'priority'	=> 15
	));

	/*
	 * サムネイルの表示サイズ初期処理
	 */
	$_image_sizes = thk_get_image_sizes();
	$thumbnail_is_size_choices = array();

	foreach( $_image_sizes as $key => $val ) {
		if( $key === 'thumb100' && isset( $val['width'] ) && isset( $val['height'] ) ) {
			$thumbnail_is_size_choices['thumb100'] = '1small ( ' . $_image_sizes['thumb100']['width'] . ' x ' . $_image_sizes['thumb100']['height'] . 'px crop )';
		}
		elseif( $key === 'thumbnail' && isset( $val['width'] ) && isset( $val['height'] ) ) {
			$thumbnail_is_size_choices['thumbnail'] = '2normal ( ' . $_image_sizes['thumbnail']['width'] . ' x ' . $_image_sizes['thumbnail']['height'] . 'px crop )';
		}
		elseif( $key === 'medium' && isset( $val['width'] ) && isset( $val['height'] ) ) {
			$thumbnail_is_size_choices['medium'] = '3medium ( ' . $_image_sizes['medium']['width'] . ' x ' . $_image_sizes['medium']['height'] . 'px )';
		}
		elseif( $key === 'thumb320' && isset( $val['width'] ) && isset( $val['height'] ) ) {
			$thumbnail_is_size_choices['thumb320'] = '4tile ( ' . $_image_sizes['thumb320']['width'] . ' x ' . $_image_sizes['thumb320']['height'] . 'px crop )';
		}
		elseif( $key === 'large' && isset( $val['width'] ) && isset( $val['height'] ) ) {
			$thumbnail_is_size_choices['large'] = '5large ( ' . $_image_sizes['large']['width'] . ' x ' . $_image_sizes['large']['height'] . 'px )';
		}
	}
	unset( $_image_sizes );
	asort( $thumbnail_is_size_choices );

	foreach( $thumbnail_is_size_choices as $key => $val ) {
		$thumbnail_is_size_choices[$key] = ltrim( $val, '12345' );
	}

	require( INC . 'defaults.php' );
	$conf = new defConfig();
	$defs = $conf->user_thumbs_default_variables();
	$mods = wp_parse_args( get_option( 'theme_mods_' . THEME ), $defs );

	if( isset( $mods['thumb_u1_a'] ) && $mods['thumb_u1_a'] === true && isset( $mods['thumb_u1'] ) && isset( $mods['thumb_u1_w'] ) && isset( $mods['thumb_u1_h'] ) && isset( $mods['thumb_u1_c'] ) ) {
		$thumbnail_is_size_choices['user_thumb_1'] = $mods['thumb_u1'] . ' ( ' . $mods['thumb_u1_w'] . ' x ' . $mods['thumb_u1_h'] . 'px';
		$thumbnail_is_size_choices['user_thumb_1'] .= $mods['thumb_u1_c'] === true ? ' crop )' : ' )';
	}
	if( isset( $mods['thumb_u2_a'] ) && $mods['thumb_u2_a'] === true && isset( $mods['thumb_u2'] ) && isset( $mods['thumb_u2_w'] ) && isset( $mods['thumb_u2_h'] ) && isset( $mods['thumb_u2_c'] ) ) {
		$thumbnail_is_size_choices['user_thumb_2'] = $mods['thumb_u2'] . ' ( ' . $mods['thumb_u2_w'] . ' x ' . $mods['thumb_u2_h'] . 'px';
		$thumbnail_is_size_choices['user_thumb_2'] .= $mods['thumb_u2_c'] === true ? ' crop )' : ' )';
	}
	if( isset( $mods['thumb_u3_a'] ) && $mods['thumb_u3_a'] === true && isset( $mods['thumb_u3'] ) && isset( $mods['thumb_u3_w'] ) && isset( $mods['thumb_u3_h'] ) && isset( $mods['thumb_u3_c'] ) ) {
		$thumbnail_is_size_choices['user_thumb_3'] = $mods['thumb_u3'] . ' ( ' . $mods['thumb_u3_w'] . ' x ' . $mods['thumb_u3_h'] . 'px';
		$thumbnail_is_size_choices['user_thumb_3'] .= $mods['thumb_u3_c'] === true ? ' crop )' : ' )';
	}
	unset( $mods );

	// サムネイルの表示サイズ (通常スタイル)
	$wp_customize->add_setting( 'thumbnail_is_size', array(
		'default' 	=> 'thumbnail',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'thumbnail_is_size', array(
		'settings'	=> 'thumbnail_is_size',
		'label'		=> __( 'Thumbnail display size', 'luxeritas' ),
		'description'	=> '<p>' . __( '* To use thumbnails of your own size, please set user thumbnails on thumbnail management.', 'luxeritas' ) . '</p><p class="m0b">' . __( 'Normal style', 'luxeritas' ) . '</p>',
		'section'	=> 'thumbnail_section',
		'type'		=> 'select',
		'choices'	=> $thumbnail_is_size_choices,
		'priority'	=> 20
	));

	// サムネイルの表示サイズ (タイル型)
	$wp_customize->add_setting( 'thumbnail_is_size_tile', array(
		'default' 	=> 'thumb320',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'thumbnail_is_size_tile', array(
		'settings'	=> 'thumbnail_is_size_tile',
		'description'	=> '<p class="m0b m0t">' . __( 'Tile type', 'luxeritas' ) . ' ( ' . __( 'Grid layout', 'luxeritas' ) . ' )' . '</p>',
		'section'	=> 'thumbnail_section',
		'type'		=> 'select',
		'choices'	=> $thumbnail_is_size_choices,
		'priority'	=> 21
	));

	// 幅いっぱい width: 100% (タイル型)
	$wp_customize->add_setting( 'thumbnail_tile_width_full', array(
		'default' 	=> false,
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'thumbnail_tile_width_full', array(
		'settings'	=> 'thumbnail_tile_width_full',
		'label'		=> __( 'Full width', 'luxeritas' ) . ' ( PC )',
		'section'	=> 'thumbnail_section',
		'type'		=> 'checkbox',
		'priority'	=> 22
	));

	// 幅いっぱい width: 100% (タイル型・スマホ)
	$wp_customize->add_setting( 'thumbnail_tile_width_full_s', array(
		'default' 	=> false,
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'thumbnail_tile_width_full_s', array(
		'settings'	=> 'thumbnail_tile_width_full_s',
		'label'		=> __( 'Full width', 'luxeritas' ) . ' ( ' . __( 'smartphone', 'luxeritas' ) . ' )',
		'section'	=> 'thumbnail_section',
		'type'		=> 'checkbox',
		'priority'	=> 23
	));

	// 中央寄せ align: center (タイル型)
	$wp_customize->add_setting( 'thumbnail_tile_align_center', array(
		'default' 	=> true,
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'thumbnail_tile_align_center', array(
		'settings'	=> 'thumbnail_tile_align_center',
		'label'		=> __( 'Align center', 'luxeritas' ) . ' ( PC )',
		'section'	=> 'thumbnail_section',
		'type'		=> 'checkbox',
		'priority'	=> 24
	));

	// 中央寄せ align: center (タイル型・スマホ)
	$wp_customize->add_setting( 'thumbnail_tile_align_center_s', array(
		'default' 	=> false,
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'thumbnail_tile_align_center_s', array(
		'settings'	=> 'thumbnail_tile_align_center_s',
		'label'		=> __( 'Align center', 'luxeritas' ) . ' ( ' . __( 'smartphone', 'luxeritas' ) . ' )',
		'section'	=> 'thumbnail_section',
		'type'		=> 'checkbox',
		'priority'	=> 25
	));

	// サムネイルの表示サイズ (カード型)
	$wp_customize->add_setting( 'thumbnail_is_size_card', array(
		'default' 	=> 'thumb100',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'thumbnail_is_size_card', array(
		'settings'	=> 'thumbnail_is_size_card',
		'description'	=> '<p class="m0b m0t">' . __( 'Card type', 'luxeritas' ) . ' ( ' . __( 'Grid layout', 'luxeritas' ) . ' )' . '</p>',
		'section'	=> 'thumbnail_section',
		'type'		=> 'select',
		'choices'	=> $thumbnail_is_size_choices,
		'priority'	=> 26
	));

	// サムネイルの No Image 画像
	$wp_customize->add_setting( 'no_img', array(
		'default'	=> get_template_directory_uri() . '/images/no-img.png',
		'sanitize_callback' => 'thk_sanitize_url'
	));
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'no_img', array(
		'settings'	=> 'no_img',
		'label'		=> 'No Image',
		'section'	=> 'thumbnail_section',
		'priority'	=> 27
	)));

	//---------------------------------------------------------------------------
	// 文字種 (Font family)
	//---------------------------------------------------------------------------
	$wp_customize->add_section( 'font_family_section', array(
		'title'		=> __( 'Font family', 'luxeritas' ),
		'priority'	=> 33
	));

	// ローマ字優先
	$wp_customize->add_setting( 'font_priority', array(
		'default' 	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'font_priority', array(
		'settings'	=> 'font_priority',
		'label'		=> __( 'Prioritize Latin fonts', 'luxeritas' ),
		'section'	=> 'font_family_section',
		'type'		=> 'checkbox',
		'priority'	=> 10
	));

	// ローマ字フォント (アルファベット)
	$wp_customize->add_setting( 'font_alphabet', array(
		'default' 	=> 'segoe-helvetica',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'font_alphabet', array(
		'settings'	=> 'font_alphabet',
		'label'		=> __( 'Latin fonts', 'luxeritas' ),
		'section'	=> 'font_family_section',
		'type'		=> 'radio',
		'choices'	=> array(
			'none'			=> __( 'Not specified', 'luxeritas' ),
			'roboto'		=> __( '[ Web font ]', 'luxeritas' ) . ' Roboto',
			'robotoslab'		=> __( '[ Web font ]', 'luxeritas' ) . ' Roboto Slab',
			'opensans'		=> __( '[ Web font ]', 'luxeritas' ) . ' Open Sans',
			'sourcesanspro'		=> __( '[ Web font ]', 'luxeritas' ) . ' Source Sans Pro',
			'notosans'		=> __( '[ Web font ]', 'luxeritas' ) . ' Noto Sans',
			'nunito'		=> __( '[ Web font ]', 'luxeritas' ) . ' Nunito',
			'merriweather'		=> __( '[ Web font ]', 'luxeritas' ) . ' Merriweather',
			'vollkorn'		=> __( '[ Web font ]', 'luxeritas' ) . ' Vollkorn',
			'sortsmillgoudy'	=> __( '[ Web font ]', 'luxeritas' ) . ' Sorts Mill Goudy',
			'segoe-helvetica'	=> 'Segoe UI + Helvetica',
			'verdana-helvetica'	=> 'Verdana + Helvetica',
			'arial'			=> 'Arial',
		),
		'priority'	=> 15
	));

	// 日本語フォント
	$wp_customize->add_setting( 'font_japanese', array(
		'default' 	=> 'meiryo-sanfrancisco',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'font_japanese', array(
		'settings'	=> 'font_japanese',
		'label'		=> __( 'Japanese fonts', 'luxeritas' ),
		'section'	=> 'font_family_section',
		'type'		=> 'radio',
		'choices'	=> array(
			'none'			=> __( 'Not specified', 'luxeritas' ),
			'notosansjapanese'	=> __( '[ Web font ]', 'luxeritas' ) . ' Noto Sans JP',
			'notoserifjapanese'	=> __( '[ Web font ]', 'luxeritas' ) . ' Noto Serif JP',
			'kosugi'		=> __( '[ Web font ]', 'luxeritas' ) . ' Kosugi',
			'kosugimaru'		=> __( '[ Web font ]', 'luxeritas' ) . ' Kosugi Maru',
			'mplus1p'		=> __( '[ Web font ]', 'luxeritas' ) . ' M PLUS 1p',
			'roundedmplus1c'	=> __( '[ Web font ]', 'luxeritas' ) . ' M PLUS Rounded 1c',
			'sawarabigothic'	=> __( '[ Web font ]', 'luxeritas' ) . ' ' . __( 'Sawarabi Gothic', 'luxeritas' ),
			'sawarabimincho'	=> __( '[ Web font ]', 'luxeritas' ) . ' ' . __( 'Sawarabi Mincho', 'luxeritas' ),
			'yu-sanfrancisco'	=> __( 'Yu', 'luxeritas' ) . ' + San Francisco',
			'meiryo-sanfrancisco'	=> __( 'Meiryo', 'luxeritas' ) . ' + San Francisco',
			'msp-sanfrancisco'	=> __( 'MS PGothic', 'luxeritas' ) . ' + San Francisco',
			'yu-hiragino'		=> __( 'Yu', 'luxeritas' ) . ' + ' . __( 'Hiragino', 'luxeritas' ),
			'meiryo-hiragino'	=> __( 'Meiryo', 'luxeritas' ) . ' + ' . __( 'Hiragino', 'luxeritas' ),
			'msp-hiragino'		=> __( 'MS PGothic', 'luxeritas' ) . ' + ' . __( 'Hiragino', 'luxeritas' ),
			'yu-osaka'		=> __( 'Yu', 'luxeritas' ) . ' + Osaka',
			'meiryo-osaka'		=> __( 'Meiryo', 'luxeritas' ) . ' + Osaka',
			'msp-osaka'		=> __( 'MS PGothic', 'luxeritas' ) . ' + Osaka',
		),
		'priority'	=> 20
	));

	//---------------------------------------------------------------------------
	// 文字サイズ
	//---------------------------------------------------------------------------
	$wp_customize->add_section( 'font_size_section', array(
		'title'		=> __( 'Font size', 'luxeritas' ),
		'priority'	=> 34
	));

	// 基準値
	$wp_customize->add_setting( 'font_size_scale', array(
		'default'	=> 62.5,
		'sanitize_callback' => 'thk_sanitize_float'
	));
	$wp_customize->add_control( 'font_size_scale', array(
		'settings'	=> 'font_size_scale',
		'label'		=> __( 'Scale', 'luxeritas' ),
		'description'	=> __( 'default', 'luxeritas' ) . ' : 62.5%',
		'section'	=> 'font_size_section',
		'type'		=> 'number',
		'priority'	=> 5
	));

	// Body
	$wp_customize->add_setting( 'font_size_body', array(
		'default'	=> 14,
		'sanitize_callback' => 'thk_sanitize_float'
	));
	$wp_customize->add_control( 'font_size_body', array(
		'settings'	=> 'font_size_body',
		'label'		=> 'Body',
		'description'	=> __( 'default', 'luxeritas' ) . ' : 14px / 1.4rem',
		'section'	=> 'font_size_section',
		'type'		=> 'number',
		'priority'	=> 10
	));

	// サイトタイトル
	$wp_customize->add_setting( 'font_size_site_title', array(
		'default'	=> 28,
		'sanitize_callback' => 'thk_sanitize_float'
	));
	$wp_customize->add_control( 'font_size_site_title', array(
		'settings'	=> 'font_size_site_title',
		'label'		=> __( 'Site Title', 'luxeritas' ),
		'description'	=> __( 'default', 'luxeritas' ) . ' : 28px / 2.8rem',
		'section'	=> 'font_size_section',
		'type'		=> 'number',
		'priority'	=> 15
	));

	// サイトキャッチフレーズ
	$wp_customize->add_setting( 'font_size_desc', array(
		'default'	=> 14,
		'sanitize_callback' => 'thk_sanitize_float'
	));
	$wp_customize->add_control( 'font_size_desc', array(
		'settings'	=> 'font_size_desc',
		'label'		=> __( 'Catchphrase', 'luxeritas' ),
		'description'	=> __( 'default', 'luxeritas' ) . ' : 14px / 1.4rem',
		'section'	=> 'font_size_section',
		'type'		=> 'number',
		'priority'	=> 20
	));

	// 抜粋
	$wp_customize->add_setting( 'font_size_excerpt', array(
		'default'	=> 14,
		'sanitize_callback' => 'thk_sanitize_float'
	));
	$wp_customize->add_control( 'font_size_excerpt', array(
		'settings'	=> 'font_size_excerpt',
		'label'		=> __( 'Post excerpt', 'luxeritas' ),
		'description'	=> __( 'default', 'luxeritas' ) . ' : 14px / 1.4rem',
		'section'	=> 'font_size_section',
		'type'		=> 'number',
		'priority'	=> 25
	));

	// 記事本文
	$wp_customize->add_setting( 'font_size_post', array(
		'default'	=> 16,
		'sanitize_callback' => 'thk_sanitize_float'
	));
	$wp_customize->add_control( 'font_size_post', array(
		'settings'	=> 'font_size_post',
		'label'		=> __( 'Post content', 'luxeritas' ),
		'description'	=> __( 'default', 'luxeritas' ) . ' : 16px / 1.6rem',
		'section'	=> 'font_size_section',
		'type'		=> 'number',
		'priority'	=> 30
	));

	// 記事タイトル
	$wp_customize->add_setting( 'font_size_post_title', array(
		'default'	=> 28,
		'sanitize_callback' => 'thk_sanitize_float'
	));
	$wp_customize->add_control( 'font_size_post_title', array(
		'settings'	=> 'font_size_post_title',
		'label'		=> __( 'Post title', 'luxeritas' ) . ' : H1',
		'description'	=> __( 'default', 'luxeritas' ) . ' : 28px / 2.8rem',
		'section'	=> 'font_size_section',
		'type'		=> 'number',
		'priority'	=> 35
	));

	// 記事内 H2
	$wp_customize->add_setting( 'font_size_post_h2', array(
		'default'	=> 24,
		'sanitize_callback' => 'thk_sanitize_float'
	));
	$wp_customize->add_control( 'font_size_post_h2', array(
		'settings'	=> 'font_size_post_h2',
		'label'		=> __( 'Post content : ', 'luxeritas' ) . ' H2',
		'description'	=> __( 'default', 'luxeritas' ) . ' : 24px / 2.4rem',
		'section'	=> 'font_size_section',
		'type'		=> 'number',
		'priority'	=> 40
	));

	// 記事内 H3
	$wp_customize->add_setting( 'font_size_post_h3', array(
		'default'	=> 22,
		'sanitize_callback' => 'thk_sanitize_float'
	));
	$wp_customize->add_control( 'font_size_post_h3', array(
		'settings'	=> 'font_size_post_h3',
		'label'		=> __( 'Post content : ', 'luxeritas' ) . ' H3',
		'description'	=> __( 'default', 'luxeritas' ) . ' : 22px / 2.2rem',
		'section'	=> 'font_size_section',
		'type'		=> 'number',
		'priority'	=> 45
	));

	// 記事内 H4
	$wp_customize->add_setting( 'font_size_post_h4', array(
		'default'	=> 18,
		'sanitize_callback' => 'thk_sanitize_float'
	));
	$wp_customize->add_control( 'font_size_post_h4', array(
		'settings'	=> 'font_size_post_h4',
		'label'		=> __( 'Post content : ', 'luxeritas' ) . ' H4',
		'description'	=> __( 'default', 'luxeritas' ) . ' : 18px / 1.8rem',
		'section'	=> 'font_size_section',
		'type'		=> 'number',
		'priority'	=> 50
	));

	// 記事内 H5
	$wp_customize->add_setting( 'font_size_post_h5', array(
		'default'	=> 16,
		'sanitize_callback' => 'thk_sanitize_float'
	));
	$wp_customize->add_control( 'font_size_post_h5', array(
		'settings'	=> 'font_size_post_h5',
		'label'		=> __( 'Post content : ', 'luxeritas' ) . ' H5',
		'description'	=> __( 'default', 'luxeritas' ) . ' : 16px / 1.6rem',
		'section'	=> 'font_size_section',
		'type'		=> 'number',
		'priority'	=> 55
	));

	// 記事内 H6
	$wp_customize->add_setting( 'font_size_post_h6', array(
		'default'	=> 16,
		'sanitize_callback' => 'thk_sanitize_float'
	));
	$wp_customize->add_control( 'font_size_post_h6', array(
		'settings'	=> 'font_size_post_h6',
		'label'		=> __( 'Post content : ', 'luxeritas' ) . ' H6',
		'description'	=> __( 'default', 'luxeritas' ) . ' : 16px / 1.6rem',
		'section'	=> 'font_size_section',
		'type'		=> 'number',
		'priority'	=> 60
	));

	// 記事内 li
	$wp_customize->add_setting( 'font_size_post_li', array(
		'default'	=> 14,
		'sanitize_callback' => 'thk_sanitize_float'
	));
	$wp_customize->add_control( 'font_size_post_li', array(
		'settings'	=> 'font_size_post_li',
		'label'		=> __( 'Post content : ', 'luxeritas' ) . ' li',
		'description'	=> __( 'default', 'luxeritas' ) . ' : 14px / 1.4rem',
		'section'	=> 'font_size_section',
		'type'		=> 'number',
		'priority'	=> 65
	));

	// 記事内 pre
	$wp_customize->add_setting( 'font_size_post_pre', array(
		'default'	=> 14,
		'sanitize_callback' => 'thk_sanitize_float'
	));
	$wp_customize->add_control( 'font_size_post_pre', array(
		'settings'	=> 'font_size_post_pre',
		'label'		=> __( 'Post content : ', 'luxeritas' ) . ' pre',
		'description'	=> __( 'default', 'luxeritas' ) . ' : 14px / 1.4rem',
		'section'	=> 'font_size_section',
		'type'		=> 'number',
		'priority'	=> 70
	));

	// 記事内 blockquote
	$wp_customize->add_setting( 'font_size_post_blockquote', array(
		'default'	=> 14,
		'sanitize_callback' => 'thk_sanitize_float'
	));
	$wp_customize->add_control( 'font_size_post_blockquote', array(
		'settings'	=> 'font_size_post_blockquote',
		'label'		=> __( 'Post content : ', 'luxeritas' ) . ' blockquote',
		'description'	=> __( 'default', 'luxeritas' ) . ' : 14px / 1.4rem',
		'section'	=> 'font_size_section',
		'type'		=> 'number',
		'priority'	=> 75
	));

	// メタ情報
	$wp_customize->add_setting( 'font_size_meta', array(
		'default'	=> 14,
		'sanitize_callback' => 'thk_sanitize_float'
	));
	$wp_customize->add_control( 'font_size_meta', array(
		'settings'	=> 'font_size_meta',
		'label'		=> __( 'Meta Infomation', 'luxeritas' ),
		'description'	=> __( 'default', 'luxeritas' ) . ' : 14px / 1.4rem',
		'section'	=> 'font_size_section',
		'type'		=> 'number',
		'priority'	=> 80
	));

	// パンくずリンク
	$wp_customize->add_setting( 'font_size_breadcrumb', array(
		'default'	=> 13,
		'sanitize_callback' => 'thk_sanitize_float'
	));
	$wp_customize->add_control( 'font_size_breadcrumb', array(
		'settings'	=> 'font_size_breadcrumb',
		'label'		=> __( 'Breadcrumb menu link', 'luxeritas' ),
		'description'	=> __( 'default', 'luxeritas' ) . ' : 13px / 1.3rem',
		'section'	=> 'font_size_section',
		'type'		=> 'number',
		'priority'	=> 85
	));

	// グローバルナビ（ヘッダーナビ）
	$wp_customize->add_setting( 'font_size_gnavi', array(
		'default'	=> 14,
		'sanitize_callback' => 'thk_sanitize_float'
	));
	$wp_customize->add_control( 'font_size_gnavi', array(
		'settings'	=> 'font_size_gnavi',
		'label'		=> __( 'Global Nav (Header Nav)', 'luxeritas' ),
		'description'	=> __( 'default', 'luxeritas' ) . ' : 14px / 1.4rem',
		'section'	=> 'font_size_section',
		'type'		=> 'number',
		'priority'	=> 90
	));

	// コメント一覧
	$wp_customize->add_setting( 'font_size_comments', array(
		'default'	=> 14,
		'sanitize_callback' => 'thk_sanitize_float'
	));
	$wp_customize->add_control( 'font_size_comments', array(
		'settings'	=> 'font_size_comments',
		'label'		=> __( 'Comments', 'luxeritas' ),
		'description'	=> __( 'default', 'luxeritas' ) . ' : 14px / 1.4rem',
		'section'	=> 'font_size_section',
		'type'		=> 'number',
		'priority'	=> 95
	));

	// サイドバー
	$wp_customize->add_setting( 'font_size_side', array(
		'default'	=> 14,
		'sanitize_callback' => 'thk_sanitize_float'
	));
	$wp_customize->add_control( 'font_size_side', array(
		'settings'	=> 'font_size_side',
		'label'		=> __( 'Sidebar ', 'luxeritas' ),
		'description'	=> __( 'default', 'luxeritas' ) . ' : 14px / 1.4rem',
		'section'	=> 'font_size_section',
		'type'		=> 'number',
		'priority'	=> 100
	));

	// サイドバー h3
	$wp_customize->add_setting( 'font_size_side_h3', array(
		'default'	=> 18,
		'sanitize_callback' => 'thk_sanitize_float'
	));
	$wp_customize->add_control( 'font_size_side_h3', array(
		'settings'	=> 'font_size_side_h3',
		'label'		=> __( 'Sidebar ', 'luxeritas' ) . ' : H3',
		'description'	=> __( 'default', 'luxeritas' ) . ' : 18px / 1.8rem',
		'section'	=> 'font_size_section',
		'type'		=> 'number',
		'priority'	=> 105
	));

	// サイドバー h4
	$wp_customize->add_setting( 'font_size_side_h4', array(
		'default'	=> 18,
		'sanitize_callback' => 'thk_sanitize_float'
	));
	$wp_customize->add_control( 'font_size_side_h4', array(
		'settings'	=> 'font_size_side_h4',
		'label'		=> __( 'Sidebar ', 'luxeritas' ) . ' : H4',
		'description'	=> __( 'default', 'luxeritas' ) . ' : 18px / 1.8rem',
		'section'	=> 'font_size_section',
		'type'		=> 'number',
		'priority'	=> 110
	));

	// フッター
	$wp_customize->add_setting( 'font_size_foot', array(
		'default'	=> 14,
		'sanitize_callback' => 'thk_sanitize_float'
	));
	$wp_customize->add_control( 'font_size_foot', array(
		'settings'	=> 'font_size_foot',
		'label'		=> __( 'Footer', 'luxeritas' ),
		'description'	=> __( 'default', 'luxeritas' ) . ' : 14px / 1.4rem',
		'section'	=> 'font_size_section',
		'type'		=> 'number',
		'priority'	=> 115
	));

	// フッタータイトル
	$wp_customize->add_setting( 'font_size_foot_h4', array(
		'default'	=> 18,
		'sanitize_callback' => 'thk_sanitize_float'
	));
	$wp_customize->add_control( 'font_size_foot_h4', array(
		'settings'	=> 'font_size_foot_h4',
		'label'		=> __( 'Footer', 'luxeritas' ) . ' : H4',
		'description'	=> __( 'default', 'luxeritas' ) . ' : 18px / 1.8rem',
		'section'	=> 'font_size_section',
		'type'		=> 'number',
		'priority'	=> 120
	));

	//---------------------------------------------------------------------------
	// 文字色
	//---------------------------------------------------------------------------
	$wp_customize->add_section( 'color_section', array(
		'title'		=> __( 'Text color', 'luxeritas' ),
		'priority'	=> 35
	));

	// 文字色 ( Body )
	$wp_customize->add_setting( 'body_color', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'body_color', array(
		'settings'	=> 'body_color',
		'label'		=> __( 'Text color', 'luxeritas' ) . ' ( Body )',
		'section'	=> 'color_section',
		'priority'	=> 10
	)));

	// リンク色 ( Body )
	$wp_customize->add_setting( 'body_link_color', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'body_link_color', array(
		'settings'	=> 'body_link_color',
		'label'		=> __( 'Link color', 'luxeritas' ) . ' ( Body )',
		'section'	=> 'color_section',
		'priority'	=> 15
	)));

	// リンクホバー色 ( Body )
	$wp_customize->add_setting( 'body_hover_color', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'body_hover_color', array(
		'settings'	=> 'body_hover_color',
		'label'		=> __( 'Link hover color', 'luxeritas' ) . ' ( Body )',
		'section'	=> 'color_section',
		'priority'	=> 20
	)));

	// ヘッダー文字色
	$wp_customize->add_setting( 'head_color', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'head_color', array(
		'settings'	=> 'head_color',
		'label'		=> __( 'Header ', 'luxeritas' ) . __( 'Text color', 'luxeritas' ),
		'section'	=> 'color_section',
		'priority'	=> 35
	)));

	// ヘッダーリンク色
	$wp_customize->add_setting( 'head_link_color', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'head_link_color', array(
		'settings'	=> 'head_link_color',
		'label'		=> __( 'Header ', 'luxeritas' ) . __( 'Link color', 'luxeritas' ),
		'section'	=> 'color_section',
		'priority'	=> 40
	)));

	// ヘッダーリンクホバー色
	$wp_customize->add_setting( 'head_hover_color', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'head_hover_color', array(
		'settings'	=> 'head_hover_color',
		'label'		=> __( 'Header ', 'luxeritas' ) . __( 'Link hover color', 'luxeritas' ),
		'section'	=> 'color_section',
		'priority'	=> 45
	)));

	// フッター文字色
	$wp_customize->add_setting( 'foot_color', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'foot_color', array(
		'settings'	=> 'foot_color',
		'label'		=> __( 'Footer ', 'luxeritas' ) . __( 'Text color', 'luxeritas' ),
		'section'	=> 'color_section',
		'priority'	=> 55
	)));

	// フッターリンク色
	$wp_customize->add_setting( 'foot_link_color', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'foot_link_color', array(
		'settings'	=> 'foot_link_color',
		'label'		=> __( 'Footer ', 'luxeritas' ) . __( 'Link color', 'luxeritas' ),
		'section'	=> 'color_section',
		'priority'	=> 60
	)));

	// フッターホバーリンク色
	$wp_customize->add_setting( 'foot_hover_color', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'foot_hover_color', array(
		'settings'	=> 'foot_hover_color',
		'label'		=> __( 'Footer ', 'luxeritas' ) . __( 'Link hover color', 'luxeritas' ),
		'section'	=> 'color_section',
		'priority'	=> 65
	)));

	//---------------------------------------------------------------------------
	// 背景色・枠線色
	//---------------------------------------------------------------------------
	$wp_customize->add_section( 'bg_color_section', array(
		'title'		=> __( 'Background color', 'luxeritas' ) . ' / ' . __( 'Border color', 'luxeritas' ),
		'priority'	=> 40
	));

	// 背景色 ( Body )
	$wp_customize->add_setting( 'body_bg_color', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'body_bg_color', array(
		'settings'	=> 'body_bg_color',
		'label'		=> __( 'Background color', 'luxeritas' ) . ' ( Body )',
		'section'	=> 'bg_color_section',
		'priority'	=> 25
	)));

	// 背景透過 ( Body )
	$wp_customize->add_setting( 'body_transparent', array(
		'default'	=> 100,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'body_transparent', array(
		'settings'	=> 'body_transparent',
		'label'		=> __( 'Background transparent', 'luxeritas' ) . ' ( Body )',
		'section'	=> 'bg_color_section',
		'type'		=> 'range',
		'priority'	=> 27
	));

	// コンテンツ領域背景色
	$wp_customize->add_setting( 'cont_bg_color', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cont_bg_color', array(
		'settings'	=> 'cont_bg_color',
		'label'		=> __( 'Content area ', 'luxeritas' ) . __( 'Background color', 'luxeritas' ),
		'section'	=> 'bg_color_section',
		'priority'	=> 30
	)));

	// コンテンツ領域枠線色
	$wp_customize->add_setting( 'cont_border_color', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cont_border_color', array(
		'settings'	=> 'cont_border_color',
		'label'		=> __( 'Content area ', 'luxeritas' ) . __( 'Border color', 'luxeritas' ),
		'section'	=> 'bg_color_section',
		'priority'	=> 35
	)));

	// コンテンツ領域背景透過
	$wp_customize->add_setting( 'cont_transparent', array(
		'default'	=> 100,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'cont_transparent', array(
		'settings'	=> 'cont_transparent',
		'label'		=> __( 'Content area ', 'luxeritas' ) . __( 'Background transparent', 'luxeritas' ),
		'section'	=> 'bg_color_section',
		'type'		=> 'range',
		'priority'	=> 37
	));

	// サイドバー背景色
	$wp_customize->add_setting( 'side_bg_color', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'side_bg_color', array(
		'settings'	=> 'side_bg_color',
		'label'		=> __( 'Sidebar ', 'luxeritas' ) . __( 'Background color', 'luxeritas' ),
		'section'	=> 'bg_color_section',
		'priority'	=> 40
	)));

	// サイドバー枠線色
	$wp_customize->add_setting( 'side_border_color', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'side_border_color', array(
		'settings'	=> 'side_border_color',
		'label'		=> __( 'Sidebar ', 'luxeritas' ) . __( 'Border color', 'luxeritas' ),
		'section'	=> 'bg_color_section',
		'priority'	=> 42
	)));

	// サイドバー背景透過
	$wp_customize->add_setting( 'side_transparent', array(
		'default'	=> 100,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'side_transparent', array(
		'settings'	=> 'side_transparent',
		'label'		=> __( 'Sidebar ', 'luxeritas' ) . __( 'Background transparent', 'luxeritas' ),
		'section'	=> 'bg_color_section',
		'type'		=> 'range',
		'priority'	=> 43
	));

	// ヘッダー背景色
	$wp_customize->add_setting( 'head_bg_color', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'head_bg_color', array(
		'settings'	=> 'head_bg_color',
		'label'		=> __( 'Header ', 'luxeritas' ) . __( 'Background color', 'luxeritas' ),
		'section'	=> 'bg_color_section',
		'priority'	=> 45
	)));

	// ヘッダー枠線色
	$wp_customize->add_setting( 'head_border_color', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'head_border_color', array(
		'settings'	=> 'head_border_color',
		'label'		=> __( 'Header ', 'luxeritas' ) . __( 'Border color', 'luxeritas' ),
		'section'	=> 'bg_color_section',
		'priority'	=> 50
	)));

	// ヘッダー背景透過
	$wp_customize->add_setting( 'head_transparent', array(
		'default'	=> 100,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'head_transparent', array(
		'settings'	=> 'head_transparent',
		'label'		=> __( 'Header ', 'luxeritas' ) . __( 'Background transparent', 'luxeritas' ),
		'section'	=> 'bg_color_section',
		'type'		=> 'range',
		'priority'	=> 52
	));

	// フッター背景色
	$wp_customize->add_setting( 'foot_bg_color', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'foot_bg_color', array(
		'settings'	=> 'foot_bg_color',
		'label'		=> __( 'Footer ', 'luxeritas' ) . __( 'Background color', 'luxeritas' ),
		'section'	=> 'bg_color_section',
		'priority'	=> 55
	)));

	// フッター枠線色
	$wp_customize->add_setting( 'foot_border_color', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'foot_border_color', array(
		'settings'	=> 'foot_border_color',
		'label'		=> __( 'Footer ', 'luxeritas' ) . __( 'Border color', 'luxeritas' ),
		'section'	=> 'bg_color_section',
		'priority'	=> 60
	)));

	// フッター背景透過
	$wp_customize->add_setting( 'foot_transparent', array(
		'default'	=> 100,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'foot_transparent', array(
		'settings'	=> 'foot_transparent',
		'label'		=> __( 'Footer ', 'luxeritas' ) . __( 'Background transparent', 'luxeritas' ),
		'section'	=> 'bg_color_section',
		'type'		=> 'range',
		'priority'	=> 65
	));

	// コピーライト背景色
	$wp_customize->add_setting( 'copyright_bg_color', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'copyright_bg_color', array(
		'settings'	=> 'copyright_bg_color',
		'label'		=> __( 'Copyright area ', 'luxeritas' ) . __( 'Background color', 'luxeritas' ),
		'section'	=> 'bg_color_section',
		'priority'	=> 70
	)));

	// コピーライト枠線色
	$wp_customize->add_setting( 'copyright_border_color', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'copyright_border_color', array(
		'settings'	=> 'copyright_border_color',
		'label'		=> __( 'Copyright area ', 'luxeritas' ) . __( 'Border color', 'luxeritas' ),
		'section'	=> 'bg_color_section',
		'priority'	=> 75
	)));

	//---------------------------------------------------------------------------
	// 背景・タイトル・ロゴ画像
	//---------------------------------------------------------------------------
	$wp_customize->add_section( 'img_section', array(
		'title'		=> __( 'Images (Background / Title / Logo)', 'luxeritas' ),
		'priority'	=> 45
	));

	// タイトル画像
	$wp_customize->add_setting( 'title_img', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_url'
	));
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'title_img', array(
		'settings'	=> 'title_img',
		'label'		=> __( 'Use image as title', 'luxeritas' ),
		'section'	=> 'img_section',
		'priority'	=> 10
	)));

	// ワンポイントロゴ
	$wp_customize->add_setting( 'one_point_img', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_url'
	));
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'one_point_img', array(
		'settings'	=> 'one_point_img',
		'label'		=> __( 'One point logo image', 'luxeritas' ),
		'description'	=> __( '* Display one point image to the left of the site title.', 'luxeritas' ),
		'section'	=> 'img_section',
		'priority'	=> 12
	)));

	// 背景画像
	$wp_customize->add_setting( 'body_bg_img', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_url'
	));
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'body_bg_img', array(
		'settings'	=> 'body_bg_img',
		'label'		=> __( 'Background image', 'luxeritas' ),
		'section'	=> 'img_section',
		'priority'	=> 15
	)));

	// 背景画像透過
	$wp_customize->add_setting( 'body_img_transparent', array(
		'default'	=> 0,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'body_img_transparent', array(
		'settings'	=> 'body_img_transparent',
		'label'		=> __( 'Background image transparent', 'luxeritas' ),
		'section'	=> 'img_section',
		'type'		=> 'range',
		'priority'	=> 20
	));

	// 背景画像を固定
	$wp_customize->add_setting( 'body_img_fixed', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'body_img_fixed', array(
		'settings'	=> 'body_img_fixed',
		'label'		=> __( 'Fixed background', 'luxeritas' ),
		'section'	=> 'img_section',
		'type'		=> 'checkbox',
		'priority'	=> 25
	));

	// 背景画像を垂直位置
	$wp_customize->add_setting( 'body_img_vertical', array(
		'default'	=> 'top',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'body_img_vertical', array(
		'settings'	=> 'body_img_vertical',
		'label'		=> __( 'Background image layout', 'luxeritas' ),
		'section'	=> 'img_section',
		'type'		=> 'select',
		'choices'	=> array(
			'top'		=> 'Top',
			'middle'	=> 'Middle',
			'bottom'	=> 'Bottom'
		),
		'priority'	=> 30
	));

	// 背景画像の左右位置
	$wp_customize->add_setting( 'body_img_horizontal', array(
		'default'	=> 'left',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'body_img_horizontal', array(
		'settings'	=> 'body_img_horizontal',
		'section'	=> 'img_section',
		'type'		=> 'select',
		'choices'	=> array(
			'left'		=> 'Left',
			'center'	=> 'Center',
			'right'		=> 'Right'
		),
		'priority'	=> 32
	));

	// 背景画像の配置方法 ( repeat )
	$wp_customize->add_setting( 'body_img_repeat', array(
		'default'	=> 'repeat',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'body_img_repeat', array(
		'settings'	=> 'body_img_repeat',
		'section'	=> 'img_section',
		'type'		=> 'select',
		'choices'	=> array(
			'repeat'	=> 'repeat',
			'no-repeat'	=> 'no-repeat'
		),
		'priority'	=> 33
	));

	// 背景画像の配置方法 ( size )
	$wp_customize->add_setting( 'body_img_size', array(
		'default'	=> 'auto',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'body_img_size', array(
		'settings'	=> 'body_img_size',
		'section'	=> 'img_section',
		'type'		=> 'select',
		'choices'	=> array(
			'auto'		=> 'auto',
			'contain'	=> 'contain',
			'cover'		=> 'cover',
			'adjust'	=> '100% auto',
			'adjust2'	=> 'auto 100%',
			'adjust3'	=> '100% 100%'
		),
		'priority'	=> 35
	));

	// サイドバー背景画像
	$wp_customize->add_setting( 'side_bg_img', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_url'
	));
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'side_bg_img', array(
		'settings'	=> 'side_bg_img',
		'label'		=> __( 'Sidebar ', 'luxeritas' ) . __( 'Background image', 'luxeritas' ),
		'section'	=> 'img_section',
		'priority'	=> 40
	)));

	// ヘッダー背景画像
	$wp_customize->add_setting( 'head_bg_img', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_url'
	));
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'head_bg_img', array(
		'settings'	=> 'head_bg_img',
		'label'		=> __( 'Header ', 'luxeritas' ) . __( 'Background image', 'luxeritas' ),
		'description'	=> __( '* In responsive style, we recommend you to use the Logo Image setting below this page, rather than using background as logo.', 'luxeritas' ),
		'section'	=> 'img_section',
		'priority'	=> 45
	)));

	// ヘッダー背景画像を横いっぱいに
	$wp_customize->add_setting( 'head_img_width_max', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'head_img_width_max', array(
		'settings'	=> 'head_img_width_max',
		'label'		=> __( 'Full width', 'luxeritas' ),
		'section'	=> 'img_section',
		'type'		=> 'checkbox',
		'priority'	=> 50
	));

	// ヘッダー背景画像を固定 (無理、やめた)
/*
	$wp_customize->add_setting( 'head_img_fixed', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'head_img_fixed', array(
		'settings'	=> 'head_img_fixed',
		'label'		=> __( 'Fixed background', 'luxeritas' ),
		'section'	=> 'img_section',
		'type'		=> 'checkbox',
		'priority'	=> 51
	));
*/

	// ヘッダー背景画像を垂直位置
	$wp_customize->add_setting( 'head_img_vertical', array(
		'default'	=> 'top',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'head_img_vertical', array(
		'settings'	=> 'head_img_vertical',
		'label'		=> __( 'Header background image layout', 'luxeritas' ),
		'description'	=> __( '* display area of ​​the image , please adjust the width and height in the &quot;Header padding&quot; of &quot;Header / Footer&quot;.', 'luxeritas' ) . '<br />' . __( '* Please check the look in mobile phones by yourself :-)', 'luxeritas' ),
		'section'	=> 'img_section',
		'type'		=> 'select',
		'choices'	=> array(
			'top'		=> 'Top',
			'middle'	=> 'Middle',
			'bottom'	=> 'Bottom'
		),
		'priority'	=> 55
	));

	// ヘッダー背景画像の左右位置
	$wp_customize->add_setting( 'head_img_horizontal', array(
		'default'	=> 'left',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'head_img_horizontal', array(
		'settings'	=> 'head_img_horizontal',
		'section'	=> 'img_section',
		'type'		=> 'select',
		'choices'	=> array(
			'left'		=> 'Left',
			'center'	=> 'Center',
			'right'		=> 'Right'
		),
		'priority'	=> 60
	));

	// ヘッダー背景画像の配置方法 ( repeat )
	$wp_customize->add_setting( 'head_img_repeat', array(
		'default'	=> 'repeat',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'head_img_repeat', array(
		'settings'	=> 'head_img_repeat',
		'section'	=> 'img_section',
		'type'		=> 'select',
		'choices'	=> array(
			'repeat'	=> 'repeat',
			'no-repeat'	=> 'no-repeat'
		),
		'priority'	=> 65
	));

	// ヘッダー背景画像の配置方法 ( size )
	$wp_customize->add_setting( 'head_img_size', array(
		'default'	=> 'auto',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'head_img_size', array(
		'settings'	=> 'head_img_size',
		'section'	=> 'img_section',
		'type'		=> 'select',
		'choices'	=> array(
			'auto'		=> 'auto',
			'contain'	=> 'contain',
			'cover'		=> 'cover',
			'adjust'	=> '100% auto',
			'adjust2'	=> 'auto 100%',
			'adjust3'	=> '100% 100%'
		),
		'priority'	=> 70
	));

	// ロゴ画像
	$wp_customize->add_setting( 'logo_img', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_url'
	));
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'logo_img', array(
		'settings'	=> 'logo_img',
		'label'		=> __( 'Logo image', 'luxeritas' ),
		'section'	=> 'img_section',
		'priority'	=> 75
	)));

	// ロゴ画像の位置
	$wp_customize->add_setting( 'logo_img_up', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'logo_img_up', array(
		'settings'	=> 'logo_img_up',
		'label'		=> __( 'On top of the global navigation', 'luxeritas' ),
		'section'	=> 'img_section',
		'type'		=> 'checkbox',
		'priority'	=> 80
	));

	//---------------------------------------------------------------------------
	// パンくずリンク
	//---------------------------------------------------------------------------
	$wp_customize->add_section( 'breadcrumb_section', array(
		'title'		=> __( 'Breadcrumb link', 'luxeritas' ),
		'priority'	=> 47
	));

	// パンくずリンクの配置
	$wp_customize->add_setting( 'breadcrumb_view', array(
		'default'	=> 'outer',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'breadcrumb_view', array(
		'settings'	=> 'breadcrumb_view',
		'label'		=> __( 'Position of breadcrumb link', 'luxeritas' ),
		'section'	=> 'breadcrumb_section',
		'type'		=> 'select',
		'choices'	=> array(
			'outer'		=> __( 'Outside of the content area', 'luxeritas' ),
			'inner'		=> __( 'Inside of the content area', 'luxeritas' ),
			'none'		=> __( 'Do not show', 'luxeritas' )
		),
		'priority'	=> 5
	));

	// パンくずリンク上下パディング
	$wp_customize->add_setting( 'breadcrumb_top_buttom_padding', array(
		'default'	=> 10,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'breadcrumb_top_buttom_padding', array(
		'settings'	=> 'breadcrumb_top_buttom_padding',
		'label'		=> __( 'Padding of breadcrumb menu for above and below', 'luxeritas' ) . ' ( px )',
		'description'	=> ' ( ' . __( 'default value', 'luxeritas' ) . ' 10px )',
		'section'	=> 'breadcrumb_section',
		'type'		=> 'number',
		'priority'	=> 10
	));

	// パンくずリンク左右パディング
	$wp_customize->add_setting( 'breadcrumb_left_right_padding', array(
		'default'	=> 10,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'breadcrumb_left_right_padding', array(
		'settings'	=> 'breadcrumb_left_right_padding',
		'label'		=> __( 'Padding of breadcrumb menu for left and right', 'luxeritas' ) . ' ( px )',
		'description'	=> ' ( ' . __( 'default value', 'luxeritas' ) . ' 10px )',
		'section'	=> 'breadcrumb_section',
		'type'		=> 'number',
		'priority'	=> 15
	));

	// パンくずリンク文字色
	$wp_customize->add_setting( 'breadcrumb_color', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'breadcrumb_color', array(
		'settings'	=> 'breadcrumb_color',
		'label'		=> __( 'Breadcrumb menu link color', 'luxeritas' ),
		'section'	=> 'breadcrumb_section',
		'priority'	=> 20
	)));

	// パンくずリンク背景色
	$wp_customize->add_setting( 'breadcrumb_bg_color', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'breadcrumb_bg_color', array(
		'settings'	=> 'breadcrumb_bg_color',
		'label'		=> __( 'Breadcrumb menu background color', 'luxeritas' ),
		'section'	=> 'breadcrumb_section',
		'priority'	=> 25
	)));

	// パンくずリンクに枠線
	$wp_customize->add_setting( 'breadcrumb_border', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'breadcrumb_border', array(
		'settings'	=> 'breadcrumb_border',
		'label'		=> __( 'Surround the breadcrumb menu with border', 'luxeritas' ),
		'section'	=> 'breadcrumb_section',
		'type'		=> 'checkbox',
		'priority'	=> 30
	));

	// パンくずリンク枠線の丸み
	$wp_customize->add_setting( 'breadcrumb_radius', array(
		'default'	=> 0,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'breadcrumb_radius', array(
		'settings'	=> 'breadcrumb_radius',
		'label'		=> __( 'Border radius', 'luxeritas' ),
		'section'	=> 'breadcrumb_section',
		'type'		=> 'number',
		'priority'	=> 35
	));

	// パンくずリンク枠線色
	$wp_customize->add_setting( 'breadcrumb_border_color', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'breadcrumb_border_color', array(
		'settings'	=> 'breadcrumb_border_color',
		'label'		=> __( 'Breadcrumb menu border color', 'luxeritas' ),
		'section'	=> 'breadcrumb_section',
		'priority'	=> 40
	)));

	//---------------------------------------------------------------------------
	// グローバルナビ (ヘッダーナビ)
	//---------------------------------------------------------------------------
	$wp_customize->add_section( 'gnavi_section', array(
		'title'		=> __( 'Global Nav (Header Nav)', 'luxeritas' ),
		'priority'	=> 50
	));

	// グローバルナビの表示有無
	$wp_customize->add_setting( 'global_navi_visible', array(
		'default'	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'global_navi_visible', array(
		'settings'	=> 'global_navi_visible',
		'label'		=> __( 'Display Global Navigation', 'luxeritas' ),
		'section'	=> 'gnavi_section',
		'type'		=> 'checkbox',
		'priority'	=> 5
	));

	// グローバルナビの位置
	$wp_customize->add_setting( 'global_navi_position', array(
		'default'	=> 'under',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'global_navi_position', array(
		'settings'	=> 'global_navi_position',
		'label'		=> __( 'The position of the Global Nav', 'luxeritas' ),
		'section'	=> 'gnavi_section',
		'type'		=> 'select',
		'choices'	=> array(
			'under'		=> __( 'Below header  ( Normal )', 'luxeritas' ),
			'upper'		=> __( 'Above header', 'luxeritas' )
		),
		'priority'	=> 10
	));

	// モバイルのメニュー種類
	$wp_customize->add_setting( 'global_navi_mobile_type', array(
		'default'	=> 'luxury',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'global_navi_mobile_type', array(
		'settings'	=> 'global_navi_mobile_type',
		'label'		=> __( 'Type of mobile menu', 'luxeritas' ),
		'section'	=> 'gnavi_section',
		'type'		=> 'select',
		'choices'	=> array(
			'luxury'	=> __( 'Luxury version', 'luxeritas' ),
			'global'	=> __( 'Global menu only', 'luxeritas' )
		),
		'priority'	=> 11
	));

	// モバイルメニュー開閉方法
	$wp_customize->add_setting( 'global_navi_open_close', array(
		'default'	=> 'individual',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'global_navi_open_close', array(
		'settings'	=> 'global_navi_open_close',
		'label'		=> __( 'How to open and close the mobile menu', 'luxeritas' ),
		'section'	=> 'gnavi_section',
		'type'		=> 'select',
		'choices'	=> array(
			'individual'	=> __( 'Individually opening and closing the parent and child', 'luxeritas' ),
			'all'		=> __( 'All opening and closing', 'luxeritas' )
		),
		'priority'	=> 12
	));

	// ナビをスクロールで最上部に固定する
	$wp_customize->add_setting( 'global_navi_sticky', array(
		'default'	=> 'none',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'global_navi_sticky', array(
		'settings'	=> 'global_navi_sticky',
		'label'		=> __( 'Make it sticky', 'luxeritas' ),
		'description'	=> __( '* may not work properly with old Android (2.x system)', 'luxeritas' ),
		'section'	=> 'gnavi_section',
		'type'		=> 'select',
		'choices'	=> array(
			'none'	=> __( 'Not make it sticky', 'luxeritas' ),
			'all'	=> __( 'Make it sticky', 'luxeritas' ),
			'smart'	=> __( 'Make it sticky on small devices', 'luxeritas' ),
			'pc'	=> __( 'Make it sticky on PC', 'luxeritas' )
		),
		'priority'	=> 15
	));

	// スクロールで固定したとき影を付ける (影の濃さ)
	$wp_customize->add_setting( 'global_navi_shadow', array(
		'default'	=> 0,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'global_navi_shadow', array(
		'settings'	=> 'global_navi_shadow',
		'label'		=> __( 'Sticky options', 'luxeritas' ),
		'description'	=> __( 'Shadow density when sticky', 'luxeritas' ),
		'section'	=> 'gnavi_section',
		'type'		=> 'range',
		'priority'	=> 20
	));

	// スクロールで固定したとき半透明にする
	$wp_customize->add_setting( 'global_navi_translucent', array(
		'default'	=> false,
		'label'		=> __( 'Make it sticky', 'luxeritas' ),
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'global_navi_translucent', array(
		'settings'	=> 'global_navi_translucent',
		'label'		=> __( 'Semi transparent when sticky', 'luxeritas' ),
		'section'	=> 'gnavi_section',
		'type'		=> 'checkbox',
		'priority'	=> 21
	));

	// 上スクロールの時だけ固定表示
	$wp_customize->add_setting( 'global_navi_scroll_up_sticky', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'global_navi_scroll_up_sticky', array(
		'settings'	=> 'global_navi_scroll_up_sticky',
		'label'		=> __( 'Sticky only when scrolling up', 'luxeritas' ),
		'section'	=> 'gnavi_section',
		'type'		=> 'checkbox',
		'priority'	=> 23
	));

	// 横幅の大きさ
	$wp_customize->add_setting( 'global_navi_auto_resize', array(
		'default'	=> 'auto',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'global_navi_auto_resize', array(
		'settings'	=> 'global_navi_auto_resize',
		'label'		=> __( 'Size of width', 'luxeritas' ),
		'section'	=> 'gnavi_section',
		'type'		=> 'select',
		'choices'	=> array(
			'auto'	=> __( 'Automatically resize the width', 'luxeritas' ),
			'full'	=> __( 'Automatically resize the width', 'luxeritas' ) . '( ' . __( 'full width', 'luxeritas' ) . ' )',
			'same'	=> __( 'All the same width', 'luxeritas' ),
		),
		'priority'	=> 30
	));

	// 中央寄せ
	$wp_customize->add_setting( 'global_navi_center', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'global_navi_center', array(
		'settings'	=> 'global_navi_center',
		'label'		=> __( 'Align center', 'luxeritas' ),
		'section'	=> 'gnavi_section',
		'type'		=> 'checkbox',
		'priority'	=> 32
	));

	// セパレーター（区切り線）を付ける
	$wp_customize->add_setting( 'global_navi_sep', array(
		'default'	=> 'none',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'global_navi_sep', array(
		'settings'	=> 'global_navi_sep',
		'label'		=> __( 'Separator line', 'luxeritas' ),
		'section'	=> 'gnavi_section',
		'type'		=> 'radio',
		'choices'	=> array(
			'none'	=> __( 'None', 'luxeritas' ),
			'sep'	=> __( 'Add separator line', 'luxeritas' ),
			'both'	=> __( 'Add separator line including both ends', 'luxeritas' ),
		),
		'priority'	=> 35
	));

	// ナビ文字色
	$wp_customize->add_setting( 'gnavi_color', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'gnavi_color', array(
		'settings'	=> 'gnavi_color',
		'label'		=> __( 'Navigation ', 'luxeritas' ) . __( 'Text color', 'luxeritas' ),
		'section'	=> 'gnavi_section',
		'priority'	=> 40
	)));

	// ナビバー背景色
	$wp_customize->add_setting( 'gnavi_bar_bg_color', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'gnavi_bar_bg_color', array(
		'settings'	=> 'gnavi_bar_bg_color',
		'label'		=> __( 'Navigation bar ', 'luxeritas' ) . __( 'Background color', 'luxeritas' ),
		'section'	=> 'gnavi_section',
		'priority'	=> 45
	)));

	// ナビ背景色
	$wp_customize->add_setting( 'gnavi_bg_color', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'gnavi_bg_color', array(
		'settings'	=> 'gnavi_bg_color',
		'label'		=> __( 'Navigation ', 'luxeritas' ) . __( 'Background color', 'luxeritas' ),
		'section'	=> 'gnavi_section',
		'priority'	=> 50
	)));

	// ナビホバー文字色
	$wp_customize->add_setting( 'gnavi_hover_color', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'gnavi_hover_color', array(
		'settings'	=> 'gnavi_hover_color',
		'label'		=> __( 'Navigation ', 'luxeritas' ) . __( 'Link hover color', 'luxeritas' ),
		'section'	=> 'gnavi_section',
		'priority'	=> 52
	)));

	// ナビホバー背景色
	$wp_customize->add_setting( 'gnavi_bg_hover_color', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'gnavi_bg_hover_color', array(
		'settings'	=> 'gnavi_bg_hover_color',
		'label'		=> __( 'Navigation ', 'luxeritas' ) . __( 'Link hover background color', 'luxeritas' ),
		'section'	=> 'gnavi_section',
		'priority'	=> 55
	)));

	// ナビカレント文字色
	$wp_customize->add_setting( 'gnavi_current_color', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'gnavi_current_color', array(
		'settings'	=> 'gnavi_current_color',
		'label'		=> __( 'Navigation ', 'luxeritas' ) . __( 'Current color', 'luxeritas' ),
		'section'	=> 'gnavi_section',
		'priority'	=> 57
	)));

	// ナビカレント背景色
	$wp_customize->add_setting( 'gnavi_bg_current_color', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'gnavi_bg_current_color', array(
		'settings'	=> 'gnavi_bg_current_color',
		'label'		=> __( 'Navigation ', 'luxeritas' ) . __( 'Current background color', 'luxeritas' ),
		'section'	=> 'gnavi_section',
		'priority'	=> 60
	)));

	// ナビ上の線の色
	$wp_customize->add_setting( 'gnavi_border_top_color', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'gnavi_border_top_color', array(
		'settings'	=> 'gnavi_border_top_color',
		'label'		=> __( 'Color of the lines above the Nav', 'luxeritas' ),
		'section'	=> 'gnavi_section',
		'priority'	=> 65
	)));

	// ナビ下の線の色
	$wp_customize->add_setting( 'gnavi_border_bottom_color', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'gnavi_border_bottom_color', array(
		'settings'	=> 'gnavi_border_bottom_color',
		'label'		=> __( 'Color of the line bottom to the Nav', 'luxeritas' ),
		'section'	=> 'gnavi_section',
		'priority'	=> 70
	)));

	// セパレーター（区切り線）の色
	$wp_customize->add_setting( 'gnavi_separator_color', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'gnavi_separator_color', array(
		'settings'	=> 'gnavi_separator_color',
		'label'		=> __( 'Color of the separator line', 'luxeritas' ),
		'section'	=> 'gnavi_section',
		'priority'	=> 75
	)));

	// ナビ上の線の太さ
	$wp_customize->add_setting( 'gnavi_border_top_width', array(
		'default'	=> 1,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'gnavi_border_top_width', array(
		'settings'	=> 'gnavi_border_top_width',
		'label'		=> __( 'Thickness of the line above the Nav', 'luxeritas' ) . ' ( px )',
		'section'	=> 'gnavi_section',
		'type'		=> 'number',
		'priority'	=> 80
	));

	// ナビ下の線の太さ
	$wp_customize->add_setting( 'gnavi_border_bottom_width', array(
		'default'	=> 1,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'gnavi_border_bottom_width', array(
		'settings'	=> 'gnavi_border_bottom_width',
		'label'		=> __( 'Thickness of the line bottom to the Nav', 'luxeritas' ) . ' ( px )',
		'section'	=> 'gnavi_section',
		'type'		=> 'number',
		'priority'	=> 85
	));

	// ナビ上下パディング
	$wp_customize->add_setting( 'gnavi_top_buttom_padding', array(
		'default'	=> 16,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'gnavi_top_buttom_padding', array(
		'settings'	=> 'gnavi_top_buttom_padding',
		'label'		=> __( 'Padding of Nav for above and below', 'luxeritas' ) . ' ( px )',
		'section'	=> 'gnavi_section',
		'type'		=> 'number',
		'priority'	=> 90
	));

	// ナビバー上下パディング
	$wp_customize->add_setting( 'gnavi_bar_top_buttom_padding', array(
		'default'	=> 0,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'gnavi_bar_top_buttom_padding', array(
		'settings'	=> 'gnavi_bar_top_buttom_padding',
		'label'		=> __( 'Padding of Navigation bar for above and below', 'luxeritas' ) . ' ( px )',
		'section'	=> 'gnavi_section',
		'type'		=> 'number',
		'priority'	=> 95
	));

	//---------------------------------------------------------------------------
	// ヘッダー上の帯状メニュー
	//---------------------------------------------------------------------------
	$wp_customize->add_section( 'head_band_section', array(
		'title'		=> __( 'Header Band Menu', 'luxeritas' ),
		'description'	=> '<p class="f09em">' . __( '* Menu settings is under &quot;Appearance -&gt; Menus&quot;.  Please create and save your desired menu,and make sure to select for the location &quot;Header Band Menu&quot;.', 'luxeritas' ) . '</p>',
		'priority'	=> 55
	));

	// ヘッダーの上に帯状のメニューを表示
	$wp_customize->add_setting( 'head_band_visible', array(
		'default'	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'head_band_visible', array(
		'settings'	=> 'head_band_visible',
		'label'		=> __( 'Display the band menu above the header', 'luxeritas' ),
		'section'	=> 'head_band_section',
		'type'		=> 'checkbox',
		'priority'	=> 0
	));

	// ヘッダーの上の帯状メニューを常に横幅いっぱいにする
	$wp_customize->add_setting( 'head_band_wide', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'head_band_wide', array(
		'settings'	=> 'head_band_wide',
		'label'		=> __( 'Band menu to be full width', 'luxeritas' ),
		'section'	=> 'head_band_section',
		'type'		=> 'checkbox',
		'priority'	=> 5
	));

	// 帯状メニューを固定表示にする
	$wp_customize->add_setting( 'head_band_fixed', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'head_band_fixed', array(
		'settings'	=> 'head_band_fixed',
		'label'		=> __( 'Make band menu sticky', 'luxeritas' ),
		'description'	=> '<p class="f09em mm23l">' . __( '* may not work properly with old Android (2.x system)', 'luxeritas' ) . '</p>',
		'section'	=> 'head_band_section',
		'type'		=> 'checkbox',
		'priority'	=> 10
	));

	// 帯状メニューの高さ
	$wp_customize->add_setting( 'head_band_height', array(
		'default'	=> 28,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'head_band_height', array(
		'settings'	=> 'head_band_height',
		'label'		=> __( 'Appearance of band menu', 'luxeritas' ),
		'description'	=> __( 'Height of band menu', 'luxeritas' ) . ' ( px )',
		'section'	=> 'head_band_section',
		'type'		=> 'number',
		'priority'	=> 15
	));

	// 帯状メニュー文字色
	$wp_customize->add_setting( 'head_band_color', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'head_band_color', array(
		'settings'	=> 'head_band_color',
		'label'		=> __( 'Band menu ', 'luxeritas' ) . __( 'Text color', 'luxeritas' ),
		'section'	=> 'head_band_section',
		'priority'	=> 20
	)));

	// 帯状メニューリンクホバー色
	$wp_customize->add_setting( 'head_band_hover_color', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'head_band_hover_color', array(
		'settings'	=> 'head_band_hover_color',
		'label'		=> __( 'Band menu ', 'luxeritas' ) . __( 'Link hover color', 'luxeritas' ),
		'section'	=> 'head_band_section',
		'priority'	=> 25
	)));

	// 帯状メニュー背景色
	$wp_customize->add_setting( 'head_band_bg_color', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'head_band_bg_color', array(
		'settings'	=> 'head_band_bg_color',
		'label'		=> __( 'Band menu ', 'luxeritas' ) . __( 'Background color', 'luxeritas' ),
		'section'	=> 'head_band_section',
		'priority'	=> 30
	)));

	// 帯状メニューの下線の色
	$wp_customize->add_setting( 'head_band_border_bottom_color', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'head_band_border_bottom_color', array(
		'settings'	=> 'head_band_border_bottom_color',
		'label'		=> __( 'Color of the line bottom of the band menu', 'luxeritas' ),
		'section'	=> 'head_band_section',
		'priority'	=> 35
	)));

	// 帯状メニューの下線の太さ
	$wp_customize->add_setting( 'head_band_border_bottom_width', array(
		'default'	=> 1,
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'head_band_border_bottom_width', array(
		'settings'	=> 'head_band_border_bottom_width',
		'label'		=> __( 'Thickness of the line bottom of the band menu', 'luxeritas' ) . ' ( px )',
		'section'	=> 'head_band_section',
		'type'		=> 'number',
		'priority'	=> 40
	));

	// 帯状メニューに検索ボックス
	$wp_customize->add_setting( 'head_band_search', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'head_band_search', array(
		'settings'	=> 'head_band_search',
		'label'		=> __( 'Display Search Box', 'luxeritas' ),
		'section'	=> 'head_band_section',
		'type'		=> 'checkbox',
		'priority'	=> 41
	));

	// 帯状メニューに検索ボックス文字色
	$wp_customize->add_setting( 'head_search_color', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'head_search_color', array(
		'settings'	=> 'head_search_color',
		'label'		=> __( 'Search Box ', 'luxeritas' ) . __( 'Text color', 'luxeritas' ),
		'section'	=> 'head_band_section',
		'priority'	=> 42
	)));

	// 帯状メニューに検索ボックス背景色
	$wp_customize->add_setting( 'head_search_bg_color', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'head_search_bg_color', array(
		'settings'	=> 'head_search_bg_color',
		'label'		=> __( 'Search Box ', 'luxeritas' ) . __( 'Background color', 'luxeritas' ),
		'section'	=> 'head_band_section',
		'priority'	=> 43
	)));

	// 帯状メニューに検索ボックス背景透過
	$wp_customize->add_setting( 'head_search_transparent', array(
		'default'	=> 30,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'head_search_transparent', array(
		'settings'	=> 'head_search_transparent',
		'label'		=> __( 'Search Box ', 'luxeritas' ) . __( 'Background transparent', 'luxeritas' ),
		'section'	=> 'head_band_section',
		'type'		=> 'range',
		'priority'	=> 44
	));

	// フォローボタンの表示方法
	$wp_customize->add_setting( 'head_band_follow_icon', array(
		'default' 	=> 'icon_name',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'head_band_follow_icon', array(
		'settings'	=> 'head_band_follow_icon',
		'label'		=> __( 'Display style of social buttons', 'luxeritas' ),
		'section'	=> 'head_band_section',
		'type'		=> 'radio',
		'choices'	=> array(
			'icon_only'	=> __( 'Icon only', 'luxeritas' ),
			'icon_name'	=> __( 'Icon + SNS name', 'luxeritas' )
		),
		'priority'	=> 45
	));

	// フォローボタンをカラーにする
	$wp_customize->add_setting( 'head_band_follow_color', array(
		'default' 	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'head_band_follow_color', array(
		'settings'	=> 'head_band_follow_color',
		'label'		=> __( 'Apply color on the follow buttons', 'luxeritas' ),
		'section'	=> 'head_band_section',
		'type'		=> 'checkbox',
		'priority'	=> 50
	));

	// Twitter フォローボタン表示
	$wp_customize->add_setting( 'head_band_twitter', array(
		'default' 	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'head_band_twitter', array(
		'settings'	=> 'head_band_twitter',
		'label'		=> 'Twitter ' . __( 'follow button display', 'luxeritas' ),
		'section'	=> 'head_band_section',
		'type'		=> 'checkbox',
		'priority'	=> 55
	));

	// Twitter ID
	$wp_customize->add_setting( 'follow_twitter_id', array(
		'default' 	=> null,
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'follow_twitter_id', array(
		'settings'	=> 'follow_twitter_id',
		'label'		=> 'Twitter ID',
		'description'	=> __( '* ', 'luxeritas' ) . 'http://twitter.com/<span style="font-weight:bold">XXXXX</span><br />' . __( '&nbsp;&nbsp;&nbsp;Enter the XXXXX part', 'luxeritas' ),
		'section'	=> 'head_band_section',
		'type'		=> 'text',
		'priority'	=> 60
	));

	// Facebook フォローボタン表示
	$wp_customize->add_setting( 'head_band_facebook', array(
		'default' 	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'head_band_facebook', array(
		'settings'	=> 'head_band_facebook',
		'label'		=> 'Facebook ' . __( 'follow button display', 'luxeritas' ),
		'section'	=> 'head_band_section',
		'type'		=> 'checkbox',
		'priority'	=> 65
	));

	// Facebook ID
	$wp_customize->add_setting( 'follow_facebook_id', array(
		'default' 	=> null,
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'follow_facebook_id', array(
		'settings'	=> 'follow_facebook_id',
		'label'		=> 'Facebook ID',
		'description'	=> __( '* ', 'luxeritas' ) . 'http://www.facebook.com/<span style="font-weight:bold">XXXXX</span><br />' . __( '&nbsp;&nbsp;&nbsp;Enter the XXXXX part', 'luxeritas' ),
		'section'	=> 'head_band_section',
		'type'		=> 'text',
		'priority'	=> 70
	));

	// Instagram フォローボタン表示
	$wp_customize->add_setting( 'head_band_instagram', array(
		'default' 	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'head_band_instagram', array(
		'settings'	=> 'head_band_instagram',
		'label'		=> 'Instagram ' . __( 'follow button display', 'luxeritas' ),
		'section'	=> 'head_band_section',
		'type'		=> 'checkbox',
		'priority'	=> 75
	));

	// Instagram ID
	$wp_customize->add_setting( 'follow_instagram_id', array(
		'default' 	=> null,
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'follow_instagram_id', array(
		'settings'	=> 'follow_instagram_id',
		'label'		=> 'Instagram ID',
		'description'	=> __( '* ', 'luxeritas' ) . 'https://www.instagram.com/<span style="font-weight:bold">XXXXX</span><br />' . __( '&nbsp;&nbsp;&nbsp;Enter the XXXXX part', 'luxeritas' ),
		'section'	=> 'head_band_section',
		'type'		=> 'text',
		'priority'	=> 80
	));

	// Pinterest フォローボタン表示
	$wp_customize->add_setting( 'head_band_pinit', array(
		'default' 	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'head_band_pinit', array(
		'settings'	=> 'head_band_pinit',
		'label'		=> 'Pinterest ' . __( 'follow button display', 'luxeritas' ),
		'section'	=> 'head_band_section',
		'type'		=> 'checkbox',
		'priority'	=> 85
	));

	// Pinterest ID
	$wp_customize->add_setting( 'follow_pinit_id', array(
		'default' 	=> null,
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'follow_pinit_id', array(
		'settings'	=> 'follow_pinit_id',
		'label'		=> 'Pinterest ID',
		'description'	=> __( '* ', 'luxeritas' ) . 'https://www.pinterest.com/<span style="font-weight:bold">XXXXX</span><br />' . __( '&nbsp;&nbsp;&nbsp;Enter the XXXXX part', 'luxeritas' ),
		'section'	=> 'head_band_section',
		'type'		=> 'text',
		'priority'	=> 90
	));

	// はてなブックマーク フォローボタン表示
	$wp_customize->add_setting( 'head_band_hatena', array(
		'default' 	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'head_band_hatena', array(
		'settings'	=> 'head_band_hatena',
		'label'		=> __( 'Hatena Bookmark', 'luxeritas' ) . ' ' . __( 'follow button display', 'luxeritas' ),
		'section'	=> 'head_band_section',
		'type'		=> 'checkbox',
		'priority'	=> 95
	));

	// はてなブックマーク ID
	$wp_customize->add_setting( 'follow_hatena_id', array(
		'default' 	=> null,
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'follow_hatena_id', array(
		'settings'	=> 'follow_hatena_id',
		'label'		=> __( 'Hatena Bookmark', 'luxeritas' ) . ' ID',
		'description'	=> __( '* ', 'luxeritas' ) . 'http://b.hatena.ne.jp/<span style="font-weight:bold">XXXXX</span><br />' . __( '&nbsp;&nbsp;&nbsp;Enter the XXXXX part', 'luxeritas' ),
		'section'	=> 'head_band_section',
		'type'		=> 'text',
		'priority'	=> 100
	));

	// Google+ フォローボタン表示
	$wp_customize->add_setting( 'head_band_google', array(
		'default' 	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'head_band_google', array(
		'settings'	=> 'head_band_google',
		'label'		=> 'Google+ ' . __( 'follow button display', 'luxeritas' ),
		'section'	=> 'head_band_section',
		'type'		=> 'checkbox',
		'priority'	=> 105
	));

	// Google+ ID
	$wp_customize->add_setting( 'follow_google_id', array(
		'default' 	=> null,
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'follow_google_id', array(
		'settings'	=> 'follow_google_id',
		'label'		=> 'Google+ ID',
		'description'	=> __( '* ', 'luxeritas' ) . 'http://plus.google.com/<span style="font-weight:bold">XXXXX</span><br />' . __( '&nbsp;&nbsp;&nbsp;Enter the XXXXX part', 'luxeritas' ),
		'section'	=> 'head_band_section',
		'type'		=> 'text',
		'priority'	=> 110
	));

	// Youtube フォローボタン表示
	$wp_customize->add_setting( 'head_band_youtube', array(
		'default' 	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'head_band_youtube', array(
		'settings'	=> 'head_band_youtube',
		'label'		=> 'Youtube ' . __( 'follow button display', 'luxeritas' ),
		'section'	=> 'head_band_section',
		'type'		=> 'checkbox',
		'priority'	=> 115
	));

	// Youtube ID',
	$wp_customize->add_setting( 'follow_youtube_channel_id', array(
		'default' 	=> null,
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'follow_youtube_channel_id', array(
		'settings'	=> 'follow_youtube_channel_id',
		'label'		=> 'Youtube ID',
		'description'	=> __( '* ', 'luxeritas' ) . 'http://www.youtube.com/channel/<span style="font-weight:bold">XXXXX</span><br />' . __( '&nbsp;&nbsp;&nbsp;Enter the XXXXX part', 'luxeritas' ),
		'section'	=> 'head_band_section',
		'type'		=> 'text',
		'priority'	=> 120
	));

	// Youtube ID ( old )',
	$wp_customize->add_setting( 'follow_youtube_id', array(
		'default' 	=> null,
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'follow_youtube_id', array(
		'settings'	=> 'follow_youtube_id',
		'label'		=> 'Youtube ID ( old )',
		'description'	=> __( '* ', 'luxeritas' ) . 'http://www.youtube.com/user/<span style="font-weight:bold">XXXXX</span><br />' . __( '&nbsp;&nbsp;&nbsp;Enter the XXXXX part', 'luxeritas' ),
		'section'	=> 'head_band_section',
		'type'		=> 'text',
		'priority'	=> 125
	));

	// LINE フォローボタン表示
	$wp_customize->add_setting( 'head_band_line', array(
		'default' 	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'head_band_line', array(
		'settings'	=> 'head_band_line',
		'label'		=> 'LINE ' . __( 'follow button display', 'luxeritas' ),
		'section'	=> 'head_band_section',
		'type'		=> 'checkbox',
		'priority'	=> 130
	));

	// LINE ID
	$wp_customize->add_setting( 'follow_line_id', array(
		'default' 	=> null,
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'follow_line_id', array(
		'settings'	=> 'follow_line_id',
		'label'		=> 'LINE ID',
		'description'	=> __( '* ', 'luxeritas' ) . 'http://line.naver.jp/ti/p/<span style="font-weight:bold">XXXXX</span><br />' . __( '&nbsp;&nbsp;&nbsp;Enter the XXXXX part', 'luxeritas' ),
		'section'	=> 'head_band_section',
		'type'		=> 'text',
		'priority'	=> 135
	));

	// RSS ボタン表示
	$wp_customize->add_setting( 'head_band_rss', array(
		'default' 	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'head_band_rss', array(
		'settings'	=> 'head_band_rss',
		'label'		=> 'RSS ' . __( 'button display', 'luxeritas' ),
		'section'	=> 'head_band_section',
		'type'		=> 'checkbox',
		'priority'	=> 140
	));

	// Feedly ボタン表示
	$wp_customize->add_setting( 'head_band_feedly', array(
		'default' 	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'head_band_feedly', array(
		'settings'	=> 'head_band_feedly',
		'label'		=> 'Feedly ' . __( 'button display', 'luxeritas' ),
		'section'	=> 'head_band_section',
		'type'		=> 'checkbox',
		'priority'	=> 145
	));

	//---------------------------------------------------------------------------
	// 目次
	//---------------------------------------------------------------------------
	$wp_customize->add_section( 'toc_section', array(
		'title'		=> __( 'Table of Contents', 'luxeritas' ),
		'description'	=> '<p class="bold">' . __( 'Create the table of contents based on the heading tag in the post.', 'luxeritas' ) . '</p>',
		'priority'	=> 58
	));

	// 目次の自動挿入
	$wp_customize->add_setting( 'toc_auto_insert', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'toc_auto_insert', array(
		'settings'	=> 'toc_auto_insert',
		'label'		=> __( 'Automatically insert the TOC', 'luxeritas' ),
		'section'	=> 'toc_section',
		'type'		=> 'checkbox',
		'priority'	=> 10
	));

	// 目次用のスタイル適用
	$wp_customize->add_setting( 'toc_css', array(
		'default'	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'toc_css', array(
		'settings'	=> 'toc_css',
		'label'		=> __( 'Apply style', 'luxeritas' ),
		'section'	=> 'toc_section',
		'type'		=> 'checkbox',
		'priority'	=> 15
	));

	// AMP でも目次を表示する
	$wp_customize->add_setting( 'toc_amp', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'toc_amp', array(
		'settings'	=> 'toc_amp',
		'label'		=> __( 'Automatically insert the TOC also in AMP page', 'luxeritas' ),
		'section'	=> 'toc_section',
		'type'		=> 'checkbox',
		'priority'	=> 20
	));

	// 目次の見出しの数
	$wp_customize->add_setting( 'toc_number_of_headings', array(
		'default'	=> 1,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'toc_number_of_headings', array(
		'settings'	=> 'toc_number_of_headings',
		'label'		=> __( 'Show when: (number of headings)', 'luxeritas' ),
		'section'	=> 'toc_section',
		'type'		=> 'number',
		'priority'	=> 25
	));

	$wp_customize->add_setting( 'dummy5', array( 'sanitize_callback' => 'thk_sanitize' ) );
	$wp_customize->add_control( 'dummy5', array(
		'settings'	=> 'dummy5',
		'description'	=> '<p class="bold snormal f11em mm23l mm10b">' . __( 'Post type to display', 'luxeritas' ) . '</p>',
		'section'	=> 'toc_section',
		'type'		=> 'hidden',
		'priority'	=> 30
	));

	// 目次を表示するポストタイプ（投稿ページ）
	$wp_customize->add_setting( 'toc_single_enable', array(
		'default'	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'toc_single_enable', array(
		'settings'	=> 'toc_single_enable',
		'label'		=> __( 'Post page', 'luxeritas' ),
		'section'	=> 'toc_section',
		'type'		=> 'checkbox',
		'priority'	=> 35
	));

	// 目次を表示するポストタイプ（固定ページ）
	$wp_customize->add_setting( 'toc_page_enable', array(
		'default'	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'toc_page_enable', array(
		'settings'	=> 'toc_page_enable',
		'label'		=> __( 'Static page', 'luxeritas' ),
		'section'	=> 'toc_section',
		'type'		=> 'checkbox',
		'priority'	=> 40
	));

	// 目次を表示する階層
	$wp_customize->add_setting( 'toc_hierarchy', array(
		'default'	=> '3',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'toc_hierarchy', array(
		'settings'	=> 'toc_hierarchy',
		'label'		=> __( 'Heading hierarchy to display', 'luxeritas' ),
		'section'	=> 'toc_section',
		'type'		=> 'radio',
		'choices'	=> array(
			'2'	=> 'H2',
			'3'	=> 'H2 - H3',
			'4'	=> 'H2 - H4',
			'5'	=> 'H2 - H5',
			'6'	=> 'H2 - H6',
		),
		'priority'	=> 45
	));

	// 目次をの飛び先の位置調整（高さ）
	$wp_customize->add_setting( 'toc_jump_position', array(
		'default'	=> 0,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'toc_jump_position', array(
		'settings'	=> 'toc_jump_position',
		'label'		=> __( 'Position of jump destination (Height)', 'luxeritas' ),
		'section'	=> 'toc_section',
		'type'		=> 'number',
		'priority'	=> 47
	));

	$wp_customize->add_setting( 'dummy6', array( 'sanitize_callback' => 'thk_sanitize' ) );
	$wp_customize->add_control( 'dummy6', array(
		'settings'	=> 'dummy6',
		'description'	=> '<p class="snormal f11em mm23l mm10b"><hr />' . __( 'Items below this do not apply to widgets', 'luxeritas' ) . '<hr class="m10t" /></p>',
		'section'	=> 'toc_section',
		'type'		=> 'hidden',
		'priority'	=> 50
	));

	// 目次の開始状態
	$wp_customize->add_setting( 'toc_start_status', array(
		'default'	=> 'open',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'toc_start_status', array(
		'settings'	=> 'toc_start_status',
		'label'		=> __( 'Start status', 'luxeritas' ),
		'section'	=> 'toc_section',
		'type'		=> 'radio',
		'choices'	=> array(
			'open'	=> __( 'Open state', 'luxeritas' ),
			'close'	=> __( 'Closed state', 'luxeritas' ),
		),
		'priority'	=> 55
	));

	// 目次のタイトル
	$wp_customize->add_setting( 'toc_title', array(
		'default'	=> 'Contents',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'toc_title', array(
		'settings'	=> 'toc_title',
		'label'		=> __( 'Title', 'luxeritas' ),
		'section'	=> 'toc_section',
		'type'		=> 'text',
		'priority'	=> 60
	));

	// 目次の表示ボタン名
	$wp_customize->add_setting( 'toc_show_button', array(
		'default'	=> 'Show',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'toc_show_button', array(
		'settings'	=> 'toc_show_button',
		'label'		=> __( 'Show button', 'luxeritas' ),
		'section'	=> 'toc_section',
		'type'		=> 'text',
		'priority'	=> 65
	));

	// 目次の非表示ボタン名
	$wp_customize->add_setting( 'toc_hide_button', array(
		'default'	=> 'Hide',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'toc_hide_button', array(
		'settings'	=> 'toc_hide_button',
		'label'		=> __( 'Hide button', 'luxeritas' ),
		'section'	=> 'toc_section',
		'type'		=> 'text',
		'priority'	=> 70
	));

	// 目次の幅
	$wp_customize->add_setting( 'toc_width', array(
		'default'	=> 'auto',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'toc_width', array(
		'settings'	=> 'toc_width',
		'label'		=> __( 'Width', 'luxeritas' ),
		'section'	=> 'toc_section',
		'type'		=> 'radio',
		'choices'	=> array(
			'auto'	=> __( 'Auto', 'luxeritas' ),
			'100'	=> '100%',
		),
		'priority'	=> 75
	));

	// 目次の文字色
	$wp_customize->add_setting( 'toc_color', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'toc_color', array(
		'settings'	=> 'toc_color',
		'label'		=> __( 'Text color', 'luxeritas' ),
		'section'	=> 'toc_section',
		'priority'	=> 80
	)));

	// 目次の背景色
	$wp_customize->add_setting( 'toc_bg_color', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'toc_bg_color', array(
		'settings'	=> 'toc_bg_color',
		'label'		=> __( 'Background color', 'luxeritas' ),
		'section'	=> 'toc_section',
		'priority'	=> 85
	)));

	// 目次の枠線色
	$wp_customize->add_setting( 'toc_border_color', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'toc_border_color', array(
		'settings'	=> 'toc_border_color',
		'label'		=> __( 'Border color', 'luxeritas' ),
		'section'	=> 'toc_section',
		'priority'	=> 90
	)));

	// 目次の表示/非表示ボタン文字色
	$wp_customize->add_setting( 'toc_button_color', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'toc_button_color', array(
		'settings'	=> 'toc_button_color',
		'label'		=> __( 'Button', 'luxeritas' ) . ' ' . __( 'Text color', 'luxeritas' ),
		'section'	=> 'toc_section',
		'priority'	=> 95
	)));

	// 目次の表示/非表示ボタン背景色
	$wp_customize->add_setting( 'toc_button_bg_color', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'toc_button_bg_color', array(
		'settings'	=> 'toc_button_bg_color',
		'label'		=> __( 'Button', 'luxeritas' ) . ' ' . __( 'Background color', 'luxeritas' ),
		'section'	=> 'toc_section',
		'priority'	=> 100
	)));

	//---------------------------------------------------------------------------
	// アニメーション
	//---------------------------------------------------------------------------
	$wp_customize->add_section( 'animation_section', array(
		'title'		=> __( 'Animation', 'luxeritas' ),
		'description'	=> __( 'Enable animation effects', 'luxeritas' ),
		'priority'	=> 60
	));

	// サイト名のズーム効果
	$wp_customize->add_setting( 'anime_sitename', array(
		'default'	=> 'none',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'anime_sitename', array(
		'settings'	=> 'anime_sitename',
		'label'		=> __( 'Site name', 'luxeritas' ),
		'section'	=> 'animation_section',
		'type'		=> 'radio',
		'choices'	=> array(
			'none'		=> __( 'Without animation effect', 'luxeritas' ),
			'zoomin'	=> __( 'Zoom in', 'luxeritas' ),
			'zoomout'	=> __( 'Zoom out', 'luxeritas' ),
		),
		'priority'	=> 10
	));

	// 記事一覧サムネイルのズーム効果
	$wp_customize->add_setting( 'anime_thumbnail', array(
		'default'	=> 'none',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'anime_thumbnail', array(
		'settings'	=> 'anime_thumbnail',
		'label'		=> __( 'Posts List thumbnail', 'luxeritas' ),
		'section'	=> 'animation_section',
		'type'		=> 'radio',
		'choices'	=> array(
			'none'		=> __( 'Without animation effect', 'luxeritas' ),
			'zoomin'	=> __( 'Zoom in', 'luxeritas' ),
			'zoomout'	=> __( 'Zoom out', 'luxeritas' ),
		),
		'priority'	=> 15
	));

	// SNS シェアボタンのズーム効果
	$wp_customize->add_setting( 'anime_sns_buttons', array(
		'default'	=> 'none',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'anime_sns_buttons', array(
		'settings'	=> 'anime_sns_buttons',
		'label'		=> __( 'SNS share buttons', 'luxeritas' ),
		'section'	=> 'animation_section',
		'type'		=> 'radio',
		'choices'	=> array(
			'none'		=> __( 'Without animation effect', 'luxeritas' ),
			'upward'	=> __( 'Upward movement', 'luxeritas' ),
			'zoomin'	=> __( 'Zoom in', 'luxeritas' ),
			'zoomout'	=> __( 'Zoom out', 'luxeritas' ),
		),
		'priority'	=> 20
	));

	// グローバルナビの上方移動効果
	$wp_customize->add_setting( 'anime_global_navi', array(
		'default'	=> 'none',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'anime_global_navi', array(
		'settings'	=> 'anime_global_navi',
		'label'		=> __( 'Global Nav', 'luxeritas' ),
		'section'	=> 'animation_section',
		'type'		=> 'radio',
		'choices'	=> array(
			'none'		=> __( 'Without animation effect', 'luxeritas' ),
			'upward'	=> __( 'Upward movement', 'luxeritas' ),
		),
		'priority'	=> 25
	));

	//---------------------------------------------------------------------------
	// Lazy Load (画像の遅延読み込み)
	//---------------------------------------------------------------------------
	$wp_customize->add_section( 'lazyload_section', array(
		'title'		=> 'Lazy Load (' . __( 'Lazy loading of image', 'luxeritas' ) . ')',
		'description'	=> '<p class="normal">' . __( '* This feature uses Intersection Observer API.', 'luxeritas' ) . '</p>',
		'priority'	=> 79
	));

	// 各種サムネイル画像の Lazy Load 有効化
	$wp_customize->add_setting( 'lazyload_thumbs', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'lazyload_thumbs', array(
		'settings'	=> 'lazyload_thumbs',
		'label'		=> __( 'Enable Lazy Load for various thumbnail images', 'luxeritas' ),
		'section'	=> 'lazyload_section',
		'type'		=> 'checkbox',
		'priority'	=> 10
	));

	// 投稿・固定ページの Lazy Load 有効化
	$wp_customize->add_setting( 'lazyload_contents', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'lazyload_contents', array(
		'settings'	=> 'lazyload_contents',
		'label'		=> __( 'Enable Lazy Load for post contents', 'luxeritas' ),
		'section'	=> 'lazyload_section',
		'type'		=> 'checkbox',
		'priority'	=> 15
	));

	// サイドバーの Lazy Load 有効化
	$wp_customize->add_setting( 'lazyload_sidebar', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'lazyload_sidebar', array(
		'settings'	=> 'lazyload_sidebar',
		'label'		=> __( 'Enable Lazy Load for sidebar', 'luxeritas' ),
		'description'	=> '<p class="mm23l m0b f09em">' . __( '* The scroll follow sidebar may become strange movement.', 'luxeritas' ) . '</p>',
		'section'	=> 'lazyload_section',
		'type'		=> 'checkbox',
		'priority'	=> 20
	));

	// フッターの Lazy Load 有効化
	$wp_customize->add_setting( 'lazyload_footer', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'lazyload_footer', array(
		'settings'	=> 'lazyload_footer',
		'label'		=> __( 'Enable Lazy Load for footer', 'luxeritas' ),
		'section'	=> 'lazyload_section',
		'type'		=> 'checkbox',
		'priority'	=> 25
	));

	// アバターの Lazy Load 有効化
	$wp_customize->add_setting( 'lazyload_avatar', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'lazyload_avatar', array(
		'settings'	=> 'lazyload_avatar',
		'label'		=> __( 'Enable Lazy Load for Gravatar', 'luxeritas' ),
		'section'	=> 'lazyload_section',
		'type'		=> 'checkbox',
		'priority'	=> 30
	));

	// noscript を付けるかどうか
	$wp_customize->add_setting( 'lazyload_noscript', array(
		'default'	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'lazyload_noscript', array(
		'settings'	=> 'lazyload_noscript',
		'label'		=> __( 'Display images even if Javascript is disabled', 'luxeritas' ),
		'section'	=> 'lazyload_section',
		'type'		=> 'checkbox',
		'priority'	=> 35
	));

	// Lazy Load エフェクト・効果
	$wp_customize->add_setting( 'lazyload_effect', array(
		'default'	=> 'fadeIn',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'lazyload_effect', array(
		'settings'	=> 'lazyload_effect',
		'label'		=> __( 'Effect', 'luxeritas' ),
		'section'	=> 'lazyload_section',
		'type'		=> 'radio',
		'choices'	=> array(
			'fadeIn'	=> __( 'Fade-in', 'luxeritas' ),
			'show'		=> __( 'Show (No effect)', 'luxeritas' )
		),
		'priority'	=> 40
	));

	//---------------------------------------------------------------------------
	// 画像ギャラリーの設定
	//---------------------------------------------------------------------------
	$wp_customize->add_section( 'gallery_section', array(
		'title'		=> __( 'Image gallery', 'luxeritas' ),
		'priority'	=> 80
	));

	// 画像ギャラリーの種類
	$wp_customize->add_setting( 'gallery_type', array(
		'default'	=> 'none',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'gallery_type', array(
		'settings'	=> 'gallery_type',
		'label'		=> __( 'Type of image gallery', 'luxeritas' ),
		'section'	=> 'gallery_section',
		'type'		=> 'radio',
		'choices'	=> array(
			'tosrus'	=> 'Tosrus ( ' . __( 'Responsive', 'luxeritas' ) . ' / ' . __( 'Most Recommended', 'luxeritas' ) . ' )',
			'lightcase'	=> 'Lightcase ( ' . __( 'Responsive', 'luxeritas' ) . ' / ' . __( 'Recommend', 'luxeritas' ) . ' )',
			'fluidbox'	=> 'Fluidbox ( ' . __( 'Responsive', 'luxeritas' ) . ' / ' . __( 'Recommend', 'luxeritas' ) . ' / ' . __( 'Cannot coexist with &quot;Lazy Load&quot;', 'luxeritas' ) . ' )',
			'none'		=> __( 'Do not use the image gallery', 'luxeritas' )
		),
		'priority'	=> 10
	));

	//---------------------------------------------------------------------------
	// 外部リンクの設定
	//---------------------------------------------------------------------------
	$wp_customize->add_section( 'external_link_section', array(
		'title'		=> __( 'External link', 'luxeritas' ),
		'priority'	=> 85
	));

	// 記事内の外部リンクに class="external" 付ける
	$wp_customize->add_setting( 'add_class_external', array(
		'default'	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'add_class_external', array(
		'settings'	=> 'add_class_external',
		'label'		=> sprintf( __( 'Add %s in the external links of the article', 'luxeritas' ), ' class="external" ' ),
		'section'	=> 'external_link_section',
		'type'		=> 'checkbox',
		'priority'	=> 10
	));

	// 記事内の外部リンクにアイコン付ける
	$wp_customize->add_setting( 'add_external_icon', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'add_external_icon', array(
		'settings'	=> 'add_external_icon',
		'label'		=> sprintf( __( 'Add %s in the external links of the article', 'luxeritas' ), __( ' icon ', 'luxeritas' ) ),
		'section'	=> 'external_link_section',
		'type'		=> 'checkbox',
		'priority'	=> 20
	));

	// 外部リンクアイコンのタイプ
	$wp_customize->add_setting( 'external_icon_type', array(
		'default'	=> 'normal',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'external_icon_type', array(
		'settings'	=> 'external_icon_type',
		'label'		=> __( 'Type of external link icon', 'luxeritas' ),
		'section'	=> 'external_link_section',
		'type'		=> 'radio',
		'choices'	=> array(
			'normal'	=> 'fa-external-link',
			'square'	=> 'fa-external-link-square'
		),
		'priority'	=> 30
	));

	// 外部リンクアイコンの色
	$wp_customize->add_setting( 'external_icon_color', array(
		'default'	=> null,
		'sanitize_callback' => 'thk_sanitize_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'external_icon_color', array(
		'settings'	=> 'external_icon_color',
		'label'		=> __( 'The color of external link icon', 'luxeritas' ),
		'section'	=> 'external_link_section',
		'priority'	=> 40
	)));

	// 記事内の外部リンクに target="_blank" 付ける
	$wp_customize->add_setting( 'add_target_blank', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'add_target_blank', array(
		'settings'	=> 'add_target_blank',
		'label'		=> sprintf( __( 'Add %s in the external links of the article', 'luxeritas' ), ' target="_blank" ' ),
		'section'	=> 'external_link_section',
		'type'		=> 'checkbox',
		'priority'	=> 50
	));

	// 記事内の外部リンクに rel="nofollow" 付ける
	$wp_customize->add_setting( 'add_rel_nofollow', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'add_rel_nofollow', array(
		'settings'	=> 'add_rel_nofollow',
		'label'		=> sprintf( __( 'Add %s in the external links of the article', 'luxeritas' ), ' rel="nofollow" ' ),
		'description'	=> '<p class="mm23l f09em">' . __( '* Not recommended! (such nofollow link in your articles could be a breach in manners.)', 'luxeritas' ) . '</p>',
		'section'	=> 'external_link_section',
		'type'		=> 'checkbox',
		'priority'	=> 50
	));

	//---------------------------------------------------------------------------
	// author (記事投稿者) の設定
	//---------------------------------------------------------------------------
	$wp_customize->add_section( 'author_section', array(
		'title'		=> __( 'Author (post contributor)', 'luxeritas' ),
		'priority'	=> 90
	));
	// author (記事投稿者) を表示
	$wp_customize->add_setting( 'author_visible', array(
		'default'	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'author_visible', array(
		'settings'	=> 'author_visible',
		'label'		=> __( 'Display author (post contributor)', 'luxeritas' ),
		'description'	=> '<p class="mm23l f09em">' . __( '* If you hide the author, a structured data error will result..', 'luxeritas' ) . '</p>',
		'section'	=> 'author_section',
		'type'		=> 'checkbox',
		'priority'	=> 10
	));
	// author に張る URL の選択
	$wp_customize->add_setting( 'author_page_type', array(
		'default'	=> 'auth',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'author_page_type', array(
		'settings'	=> 'author_page_type',
		'label'		=> __( 'URL spanned the author', 'luxeritas' ),
		'section'	=> 'author_section',
		'type'		=> 'radio',
		'choices'	=> array(
			'auth'		=> __( 'Link to the contributor archive page', 'luxeritas' ),
			'other'		=> __( 'Link to the URL you desire', 'luxeritas' )
		),
		'priority'	=> 15
	));
	// 自分で作成したプロフィールページの URL
	$wp_customize->add_setting( 'thk_author_url', array(
		'default' 	=> home_url('/'),
		'sanitize_callback' => 'thk_sanitize_url'
	));
	$wp_customize->add_control( 'thk_author_url', array(
		'settings'	=> 'thk_author_url',
		'label'		=> __( 'The URL you desire!', 'luxeritas' ),
		'section'	=> 'author_section',
		'type'		=> 'text',
		'priority'	=> 20
	));

	//---------------------------------------------------------------------------
	// ブログカード
	//---------------------------------------------------------------------------
	$wp_customize->add_section( 'blogcard_section', array(
		'title'		=> __( 'Blog Card', 'luxeritas' ),
		'priority'	=> 93
	));

	// ブログカードの有効化/無効化
	$wp_customize->add_setting( 'blogcard_enable', array(
		'default'	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'blogcard_enable', array(
		'settings'	=> 'blogcard_enable',
		'label'		=> __( 'Eanable Blog Card', 'luxeritas' ),
		'section'	=> 'blogcard_section',
		'type'		=> 'checkbox',
		'priority'	=> 5
	));

	// URL 直書きをブログカード化する
	$wp_customize->add_setting( 'blogcard_embedded', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'blogcard_embedded', array(
		'settings'	=> 'blogcard_embedded',
		'label'		=> __( 'Make embedded URL a blog card', 'luxeritas' ),
		'description'	=> '<p class="mm23l f09em">' . __( '* If you check this, Some oEmbed features of WordPress will not be usable.', 'luxeritas' ) . '</p>',
		'section'	=> 'blogcard_section',
		'type'		=> 'checkbox',
		'priority'	=> 7
	));

	// ブログカードの最大幅
	$wp_customize->add_setting( 'blogcard_max_width', array(
		'default'	=> 540,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'blogcard_max_width', array(
		'settings'	=> 'blogcard_max_width',
		'label'		=> __( 'The maximum width of the blog card', 'luxeritas' ),
		'description'	=> __( '* 0 would be full width', 'luxeritas' ) . '<br />' . __( '* default value 540', 'luxeritas' ) . 'px',
		'section'	=> 'blogcard_section',
		'type'		=> 'number',
		'priority'	=> 10
	));

	// ブログカードの丸み
	$wp_customize->add_setting( 'blogcard_radius', array(
		'default'	=> 0,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'blogcard_radius', array(
		'settings'	=> 'blogcard_radius',
		'label'		=> __( 'Border radius of Card', 'luxeritas' ),
		'section'	=> 'blogcard_section',
		'type'		=> 'number',
		'priority'	=> 15
	));

	// ブログカードに影
	$wp_customize->add_setting( 'blogcard_shadow', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'blogcard_shadow', array(
		'settings'	=> 'blogcard_shadow',
		'label'		=> __( 'Shadow on the card', 'luxeritas' ),
		'section'	=> 'blogcard_section',
		'type'		=> 'checkbox',
		'priority'	=> 20
	));

	// ブログカードの画像位置
	$wp_customize->add_setting( 'blogcard_img_position', array(
		'default'	=> 'right',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'blogcard_img_position', array(
		'settings'	=> 'blogcard_img_position',
		'label'		=> __( 'Image position', 'luxeritas' ),
		'section'	=> 'blogcard_section',
		'type'		=> 'radio',
		'choices'	=> array(
			'right'		=> __( 'Right', 'luxeritas' ),
			'left'		=> __( 'Left', 'luxeritas' )
		),
		'priority'	=> 25
	));

	// ブログカードの画像に枠線を付ける
	$wp_customize->add_setting( 'blogcard_img_border', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'blogcard_img_border', array(
		'settings'	=> 'blogcard_img_border',
		'label'		=> __( 'Surround the image with border', 'luxeritas' ),
		'section'	=> 'blogcard_section',
		'type'		=> 'checkbox',
		'priority'	=> 30
	));

	// ブログカードの画像に影を付ける
	$wp_customize->add_setting( 'blogcard_img_shadow', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'blogcard_img_shadow', array(
		'settings'	=> 'blogcard_img_shadow',
		'label'		=> __( 'Shadow on the image', 'luxeritas' ),
		'section'	=> 'blogcard_section',
		'type'		=> 'checkbox',
		'priority'	=> 35
	));

	// ブログカードの画像の丸み
	$wp_customize->add_setting( 'blogcard_img_radius', array(
		'default'	=> 0,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'blogcard_img_radius', array(
		'settings'	=> 'blogcard_img_radius',
		'label'		=> __( 'Border radius of image', 'luxeritas' ),
		'section'	=> 'blogcard_section',
		'type'		=> 'number',
		'priority'	=> 40
	));

	// ブログカードのキャッシュ保持期間
	$wp_customize->add_setting( 'blogcard_cache_expire', array(
		'default'	=> 2592000,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'blogcard_cache_expire', array(
		'settings'	=> 'blogcard_cache_expire',
		'label'		=> __( 'Cache expiration time', 'luxeritas' ),
		'section'	=> 'blogcard_section',
		'type'		=> 'select',
		'choices'	=> array(
			86400		=> sprintf( __( '%s day', 'luxeritas' ), 1 ),
			259200		=> sprintf( __( '%s day', 'luxeritas' ), 3 ),
			604800		=> sprintf( __( '%s week', 'luxeritas' ), 1 ),
			1209600		=> sprintf( __( '%s week', 'luxeritas' ), 2 ),
			2592000		=> sprintf( __( '%s month', 'luxeritas' ), 1 ),
			5184000		=> sprintf( __( '%s month', 'luxeritas' ), 2 ),
			7948800		=> sprintf( __( '%s month', 'luxeritas' ), 3 ),
			15811200	=> __( 'half year', 'luxeritas' )
		),
		'priority'	=> 45
	));

	//---------------------------------------------------------------------------
	// SNS シェアボタン (1)
	//---------------------------------------------------------------------------
	$wp_customize->add_section( 'sns_section', array(
		'title'		=> __( 'SNS share buttons', 'luxeritas' ) . ' (1)',
		'priority'	=> 95
	));

	// SNS のカウントをキャッシュする
	$wp_customize->add_setting( 'sns_count_cache_enable', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'sns_count_cache_enable', array(
		'settings'	=> 'sns_count_cache_enable',
		'label'		=> __( 'Eanable cache for SNS counter', 'luxeritas' ) . ' (' . __( 'Recommend', 'luxeritas' ) . ')',
		'description'	=> '<p class="mm23l f09em">' . __( '* will not function if normal SNS button is selected.', 'luxeritas' ) . '</p><p class="mm23l f09em">' . __( '* by enabling cache, the SNS counter will work even on WAF enabled servers.', 'luxeritas' ) . '</p>',
		'section'	=> 'sns_section',
		'type'		=> 'checkbox',
		'priority'	=> 5
	));

	// ブログで SNS カウントを非表示にしていても、カウント数を取得してキャッシュする
	$wp_customize->add_setting( 'sns_count_cache_force', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'sns_count_cache_force', array(
		'settings'	=> 'sns_count_cache_force',
		'label'		=> __( 'Count and cache the SNS counts even NO display is selected.', 'luxeritas' ),
		'section'	=> 'sns_section',
		'type'		=> 'checkbox',
		'priority'	=> 6
	));

	// SNS カウントキャッシュ再構築までのインターバル
	$wp_customize->add_setting( 'sns_count_cache_expire', array(
		'default'	=> 600,
		'sanitize_callback' => 'thk_sanitize_integer'
	));
	$wp_customize->add_control( 'sns_count_cache_expire', array(
		'settings'	=> 'sns_count_cache_expire',
		'label'		=> __( 'Interval for cache restructure', 'luxeritas' ),
		'section'	=> 'sns_section',
		'type'		=> 'select',
		'choices'	=> array(
			60	=> sprintf( __( '%s seconds', 'luxeritas' ), 60 ),
			600	=> sprintf( __( '%s minutes', 'luxeritas' ), 10 ),
			1800	=> sprintf( __( '%s minutes', 'luxeritas' ), 30 ),
			3600	=> sprintf( __( '%s hour', 'luxeritas' ), 1 ),
			10800	=> sprintf( __( '%s hours', 'luxeritas' ), 3 ),
			21600	=> sprintf( __( '%s hours', 'luxeritas' ), 6 ),
			43200	=> sprintf( __( '%s hours', 'luxeritas' ), 12 ),
			86400	=> sprintf( __( '%s day', 'luxeritas' ), 1 )
		),
		'priority'	=> 7
	));

	// 週間自動キャッシュ整理
	$wp_customize->add_setting( 'sns_count_weekly_cleanup', array(
		'default'	=> 'dust',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'sns_count_weekly_cleanup', array(
		'settings'	=> 'sns_count_weekly_cleanup',
		'label'		=> __( 'Weekly cache cleaning', 'luxeritas' ),
		'section'	=> 'sns_section',
		'type'		=> 'select',
		'choices'	=> array(
			'dust'	=> __( 'Delete trash considered cache', 'luxeritas' ),
			'all'	=> __( 'Delete all cache', 'luxeritas' ),
			'none'	=> __( 'Do nothing', 'luxeritas' )
		),
		'priority'	=> 8
	));

	// 記事上の SNS ボタンの種類と配置
	$wp_customize->add_setting( 'sns_tops_type', array(
		'default'	=> 'color',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'sns_tops_type', array(
		'settings'	=> 'sns_tops_type',
		'label'		=> __( 'SNS button above article type and layout', 'luxeritas' ),
		'section'	=> 'sns_section',
		'type'		=> 'select',
		'choices'	=> array(
			'normal'	=> __( 'Normal button', 'luxeritas' ),
			'color'		=> __( 'Color type', 'luxeritas' ),
			'white'		=> __( 'White type', 'luxeritas' ),
			'flatc'		=> __( 'Variable width flat type', 'luxeritas' ) . ' (' . __( 'Color', 'luxeritas' ) . ')',
			'flatw'		=> __( 'Variable width flat type', 'luxeritas' ) . ' (' . __( 'White', 'luxeritas' ) . ')',
			'iconc'		=> __( 'Nameless icon type', 'luxeritas' ) . ' (' . __( 'Color', 'luxeritas' ) . ')',
			'iconw'		=> __( 'Nameless icon type', 'luxeritas' ) . ' (' . __( 'White', 'luxeritas' ) . ')'
		),
		'priority'	=> 10
	));
	// 記事上の SNS ボタンの配置
	$wp_customize->add_setting( 'sns_tops_position', array(
		'default'	=> 'left',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'sns_tops_position', array(
		'settings'	=> 'sns_tops_position',
		'section'	=> 'sns_section',
		'type'		=> 'select',
		'choices'	=> array(
			'left'		=> __( 'left', 'luxeritas' ),
			'center'	=> __( 'center', 'luxeritas' ),
			'right'		=> __( 'right', 'luxeritas' )
		),
		'priority'	=> 15
	));
	// 記事上の SNS ボタン表示
	$wp_customize->add_setting( 'sns_tops_enable', array(
		'default'	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'sns_tops_enable', array(
		'settings'	=> 'sns_tops_enable',
		'label'		=> __( 'Display SNS button above the articles', 'luxeritas' ),
		'section'	=> 'sns_section',
		'type'		=> 'checkbox',
		'priority'	=> 18
	));
	// 記事上の SNS カウント表示
	$wp_customize->add_setting( 'sns_tops_count', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'sns_tops_count', array(
		'settings'	=> 'sns_tops_count',
		'label'		=> __( 'Show the counts on SNS buttons(above)', 'luxeritas' ),
		'section'	=> 'sns_section',
		'type'		=> 'checkbox',
		'priority'	=> 20
	));

	// 記事上 SNS ボタン2段組表示
	$wp_customize->add_setting( 'sns_tops_multiple', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'sns_tops_multiple', array(
		'settings'	=> 'sns_tops_multiple',
		'label'		=> __( 'Show SNS Button in 2 rows(above)', 'luxeritas' ),
		'section'	=> 'sns_section',
		'type'		=> 'checkbox',
		'priority'	=> 25
	));

	// 記事下の SNS ボタンの種類
	$wp_customize->add_setting( 'sns_bottoms_type', array(
		'default'	=> 'color',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'sns_bottoms_type', array(
		'settings'	=> 'sns_bottoms_type',
		'label'		=> __( 'SNS button beneath article type and layout', 'luxeritas' ),
		'section'	=> 'sns_section',
		'type'		=> 'select',
		'choices'	=> array(
			'normal'	=> __( 'Normal button', 'luxeritas' ),
			'color'		=> __( 'Color type', 'luxeritas' ),
			'white'		=> __( 'White type', 'luxeritas' ),
			'flatc'		=> __( 'Variable width flat type', 'luxeritas' ) . ' (' . __( 'Color', 'luxeritas' ) . ')',
			'flatw'		=> __( 'Variable width flat type', 'luxeritas' ) . ' (' . __( 'White', 'luxeritas' ) . ')',
			'iconc'		=> __( 'Nameless icon type', 'luxeritas' ) . ' (' . __( 'Color', 'luxeritas' ) . ')',
			'iconw'		=> __( 'Nameless icon type', 'luxeritas' ) . ' (' . __( 'White', 'luxeritas' ) . ')'
		),
		'priority'	=> 30
	));
	// 記事下の SNS ボタンの配置
	$wp_customize->add_setting( 'sns_bottoms_position', array(
		'default'	=> 'left',
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'sns_bottoms_position', array(
		'settings'	=> 'sns_bottoms_position',
		'section'	=> 'sns_section',
		'type'		=> 'select',
		'choices'	=> array(
			'left'		=> __( 'left', 'luxeritas' ),
			'center'	=> __( 'center', 'luxeritas' ),
			'right'		=> __( 'right', 'luxeritas' )
		),
		'priority'	=> 35
	));
	// 記事下の SNS ボタン表示
	$wp_customize->add_setting( 'sns_bottoms_enable', array(
		'default'	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'sns_bottoms_enable', array(
		'settings'	=> 'sns_bottoms_enable',
		'label'		=> __( 'Display SNS button below the articles', 'luxeritas' ),
		'section'	=> 'sns_section',
		'type'		=> 'checkbox',
		'priority'	=> 40
	));
	// 記事下の SNS カウント表示
	$wp_customize->add_setting( 'sns_bottoms_count', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'sns_bottoms_count', array(
		'settings'	=> 'sns_bottoms_count',
		'label'		=> __( 'Show the counts on SNS buttons (below article)', 'luxeritas' ),
		'section'	=> 'sns_section',
		'type'		=> 'checkbox',
		'priority'	=> 45
	));

	// 記事下 SNS ボタン2段組表示
	$wp_customize->add_setting( 'sns_bottoms_multiple', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'sns_bottoms_multiple', array(
		'settings'	=> 'sns_bottoms_multiple',
		'label'		=> __( 'Show SNS Button in 2 rows (below article)', 'luxeritas' ),
		'section'	=> 'sns_section',
		'type'		=> 'checkbox',
		'priority'	=> 50
	));

	// 記事下の SNS シェアメッセージ
	$wp_customize->add_setting( 'sns_bottoms_msg', array(
		'default'	=> __( 'Please share this if you liked it!', 'luxeritas' ),
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'sns_bottoms_msg', array(
		'settings'	=> 'sns_bottoms_msg',
		'label'		=> __( 'Tagline for the SNS buttons under articles', 'luxeritas' ),
		'section'	=> 'sns_section',
		'type'		=> 'text',
		'priority'	=> 55
	));
	// リスト型のトップページ下に SNS ボタン表示
	$wp_customize->add_setting( 'sns_toppage_view', array(
		'default'	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'sns_toppage_view', array(
		'settings'	=> 'sns_toppage_view',
		'label'		=> __( 'Dispplay SNS button at the bottom of top page list', 'luxeritas' ),
		'section'	=> 'sns_section',
		'type'		=> 'checkbox',
		'priority'	=> 60
	));
	// 固定ページの SNS ボタン表示
	$wp_customize->add_setting( 'sns_page_view', array(
		'default'	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'sns_page_view', array(
		'settings'	=> 'sns_page_view',
		'label'		=> __( 'Display SNS button on static pages', 'luxeritas' ),
		'section'	=> 'sns_section',
		'type'		=> 'checkbox',
		'priority'	=> 65
	));
	// 画像ホバー時の Pinterest 保存ボタン表示
	$wp_customize->add_setting( 'pinit_hover_button', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'pinit_hover_button', array(
		'settings'	=> 'pinit_hover_button',
		'label'		=> __( 'Display Save button of Pinterest at image hover', 'luxeritas' ),
		'section'	=> 'sns_section',
		'type'		=> 'checkbox',
		'priority'	=> 70
	));
	// Facebook app_id
	$wp_customize->add_setting( 'sns_fb_appid', array(
		'default' 	=> null,
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'sns_fb_appid', array(
		'settings'	=> 'sns_fb_appid',
		'label'		=> __( 'Facebook settings', 'luxeritas' ),
		'description'	=> '<p class="f08em" style="margin-top:0;margin-bottom:0">' . __( '* Required when acquiring a count value of 5 digits or more.', 'luxeritas' ) . '</p><p class="f09em" style="margin-top:15px;margin-bottom:0">App ID ( <a href="https://developers.facebook.com/apps/" target="_blank" rel="noopener">Get ID</a> )</p>',
		'section'	=> 'sns_section',
		'type'		=> 'text',
		'priority'	=> 75
	));
	// Facebook app_secret
	$wp_customize->add_setting( 'sns_fb_appsec', array(
		'default' 	=> null,
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'sns_fb_appsec', array(
		'settings'	=> 'sns_fb_appsec',
		'description'	=> '<p class=" f09em" style="margin-top:0;margin-bottom:0">App Secret ( <a href="https://developers.facebook.com/apps/" target="_blank" rel="noopener">Get Secret</a> )</p>',
		'section'	=> 'sns_section',
		'type'		=> 'password',
		'priority'	=> 80
	));
	// Facebook App Token
	$wp_customize->add_setting( 'sns_fb_apptoken', array(
		'default' 	=> null,
		'sanitize_callback' => 'thk_sanitize'
	));
	$wp_customize->add_control( 'sns_fb_apptoken', array(
		'settings'	=> 'sns_fb_apptoken',
		'description'	=> '<p class="f09em" style="margin-top:0;margin-bottom:0">App Token ( <a href="https://developers.facebook.com/tools/accesstoken/" target="_blank" rel="noopener">Get Token</a> )</p>',
		'section'	=> 'sns_section',
		'type'		=> 'password',
		'priority'	=> 85
	));

	//---------------------------------------------------------------------------
	// SNS シェアボタン (2)
	//---------------------------------------------------------------------------
	$wp_customize->add_section( 'sns_section_2', array(
		'title'		=> __( 'SNS share buttons', 'luxeritas' ) . ' (2)',
		'description'	=> '<span style="font-weight:bold;font-size:1.1em">' . __( 'Display / non-display SNS button above articles', 'luxeritas' ) . '</span>',
		'priority'	=> 96
	));

	// Twitter ボタン表示
	$wp_customize->add_setting( 'twitter_share_tops_button', array(
		'default'	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'twitter_share_tops_button', array(
		'settings'	=> 'twitter_share_tops_button',
		'label'		=> sprintf( __( '%s button display', 'luxeritas' ), 'Twitter ' ),
		'section'	=> 'sns_section_2',
		'type'		=> 'checkbox',
		'priority'	=> 10
	));

	// Facebook ボタン表示
	$wp_customize->add_setting( 'facebook_share_tops_button', array(
		'default'	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'facebook_share_tops_button', array(
		'settings'	=> 'facebook_share_tops_button',
		'label'		=> sprintf( __( '%s button display', 'luxeritas' ), 'Facebook ' ),
		'section'	=> 'sns_section_2',
		'type'		=> 'checkbox',
		'priority'	=> 15
	));

	// Google+ ボタン表示
	$wp_customize->add_setting( 'google_share_tops_button', array(
		'default'	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'google_share_tops_button', array(
		'settings'	=> 'google_share_tops_button',
		'label'		=> sprintf( __( '%s button display', 'luxeritas' ), 'Google+ ' ),
		'section'	=> 'sns_section_2',
		'type'		=> 'checkbox',
		'priority'	=> 20
	));

	// LinkedIn ボタン表示
	$wp_customize->add_setting( 'linkedin_share_tops_button', array(
		'default'	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'linkedin_share_tops_button', array(
		'settings'	=> 'linkedin_share_tops_button',
		'label'		=> sprintf( __( '%s button display', 'luxeritas' ), 'LinkedIn ' ),
		'section'	=> 'sns_section_2',
		'type'		=> 'checkbox',
		'priority'	=> 25
	));

	// Pinterest ボタン表示
	$wp_customize->add_setting( 'pinit_share_tops_button', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'pinit_share_tops_button', array(
		'settings'	=> 'pinit_share_tops_button',
		'label'		=> sprintf( __( '%s button display', 'luxeritas' ), 'Pinterest ' ),
		'section'	=> 'sns_section_2',
		'type'		=> 'checkbox',
		'priority'	=> 27
	));

	// はてブ ボタン表示
	$wp_customize->add_setting( 'hatena_share_tops_button', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'hatena_share_tops_button', array(
		'settings'	=> 'hatena_share_tops_button',
		'label'		=> sprintf( __( '%s button display', 'luxeritas' ), __( 'Hatena Bookmark', 'luxeritas' ) . ' ' ),
		'section'	=> 'sns_section_2',
		'type'		=> 'checkbox',
		'priority'	=> 30
	));

	// Pocket ボタン表示
	$wp_customize->add_setting( 'pocket_share_tops_button', array(
		'default'	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'pocket_share_tops_button', array(
		'settings'	=> 'pocket_share_tops_button',
		'label'		=> sprintf( __( '%s button display', 'luxeritas' ), 'Pocket ' ),
		'section'	=> 'sns_section_2',
		'type'		=> 'checkbox',
		'priority'	=> 35
	));

	// LINE ボタン表示
	$wp_customize->add_setting( 'line_share_tops_button', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'line_share_tops_button', array(
		'settings'	=> 'line_share_tops_button',
		'label'		=> sprintf( __( '%s button display', 'luxeritas' ), 'LINE ' ),
		'section'	=> 'sns_section_2',
		'type'		=> 'checkbox',
		'priority'	=> 37
	));

	// RSS ボタン表示
	$wp_customize->add_setting( 'rss_share_tops_button', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'rss_share_tops_button', array(
		'settings'	=> 'rss_share_tops_button',
		'label'		=> sprintf( __( '%s button display', 'luxeritas' ), 'RSS ' ),
		'section'	=> 'sns_section_2',
		'type'		=> 'checkbox',
		'priority'	=> 40
	));

	// Feedly ボタン表示
	$wp_customize->add_setting( 'feedly_share_tops_button', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'feedly_share_tops_button', array(
		'settings'	=> 'feedly_share_tops_button',
		'label'		=> sprintf( __( '%s button display', 'luxeritas' ), 'Feedly ' ),
		'description'	=> '<p class="mm23l mm10b f11em bold snormal">' . __( 'Display / non-display SNS button below articles', 'luxeritas' ) . '</p>',
		'section'	=> 'sns_section_2',
		'type'		=> 'checkbox',
		'priority'	=> 45
	));

	// Twitter ボタン表示
	$wp_customize->add_setting( 'twitter_share_bottoms_button', array(
		'default'	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'twitter_share_bottoms_button', array(
		'settings'	=> 'twitter_share_bottoms_button',
		'label'		=> sprintf( __( '%s button display', 'luxeritas' ), 'Twitter ' ),
		'section'	=> 'sns_section_2',
		'type'		=> 'checkbox',
		'priority'	=> 50
	));

	// Facebook ボタン表示
	$wp_customize->add_setting( 'facebook_share_bottoms_button', array(
		'default'	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'facebook_share_bottoms_button', array(
		'settings'	=> 'facebook_share_bottoms_button',
		'label'		=> sprintf( __( '%s button display', 'luxeritas' ), 'Facebook ' ),
		'section'	=> 'sns_section_2',
		'type'		=> 'checkbox',
		'priority'	=> 55
	));

	// Google+ ボタン表示
	$wp_customize->add_setting( 'google_share_bottoms_button', array(
		'default'	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'google_share_bottoms_button', array(
		'settings'	=> 'google_share_bottoms_button',
		'label'		=> sprintf( __( '%s button display', 'luxeritas' ), 'Google+ ' ),
		'section'	=> 'sns_section_2',
		'type'		=> 'checkbox',
		'priority'	=> 60
	));

	// LinkedIn ボタン表示
	$wp_customize->add_setting( 'linkedin_share_bottoms_button', array(
		'default'	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'linkedin_share_bottoms_button', array(
		'settings'	=> 'linkedin_share_bottoms_button',
		'label'		=> sprintf( __( '%s button display', 'luxeritas' ), 'LinkedIn ' ),
		'section'	=> 'sns_section_2',
		'type'		=> 'checkbox',
		'priority'	=> 65
	));

	// Pinterest ボタン表示
	$wp_customize->add_setting( 'pinit_share_bottoms_button', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'pinit_share_bottoms_button', array(
		'settings'	=> 'pinit_share_bottoms_button',
		'label'		=> sprintf( __( '%s button display', 'luxeritas' ), 'Pinterest ' ),
		'section'	=> 'sns_section_2',
		'type'		=> 'checkbox',
		'priority'	=> 65
	));

	// はてブ ボタン表示
	$wp_customize->add_setting( 'hatena_share_bottoms_button', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'hatena_share_bottoms_button', array(
		'settings'	=> 'hatena_share_bottoms_button',
		'label'		=> sprintf( __( '%s button display', 'luxeritas' ), __( 'Hatena Bookmark', 'luxeritas' ) . ' ' ),
		'section'	=> 'sns_section_2',
		'type'		=> 'checkbox',
		'priority'	=> 70
	));

	// Pocket ボタン表示
	$wp_customize->add_setting( 'pocket_share_bottoms_button', array(
		'default'	=> true,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'pocket_share_bottoms_button', array(
		'settings'	=> 'pocket_share_bottoms_button',
		'label'		=> sprintf( __( '%s button display', 'luxeritas' ), 'Pocket ' ),
		'section'	=> 'sns_section_2',
		'type'		=> 'checkbox',
		'priority'	=> 75
	));

	// LINE ボタン表示
	$wp_customize->add_setting( 'line_share_bottoms_button', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'line_share_bottoms_button', array(
		'settings'	=> 'line_share_bottoms_button',
		'label'		=> sprintf( __( '%s button display', 'luxeritas' ), 'LINE ' ),
		'section'	=> 'sns_section_2',
		'type'		=> 'checkbox',
		'priority'	=> 77
	));

	// RSS ボタン表示
	$wp_customize->add_setting( 'rss_share_bottoms_button', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'rss_share_bottoms_button', array(
		'settings'	=> 'rss_share_bottoms_button',
		'label'		=> sprintf( __( '%s button display', 'luxeritas' ), 'RSS ' ),
		'section'	=> 'sns_section_2',
		'type'		=> 'checkbox',
		'priority'	=> 80
	));

	// Feedly ボタン表示
	$wp_customize->add_setting( 'feedly_share_bottoms_button', array(
		'default'	=> false,
		'sanitize_callback' => 'thk_sanitize_boolean'
	));
	$wp_customize->add_control( 'feedly_share_bottoms_button', array(
		'settings'	=> 'feedly_share_bottoms_button',
		'label'		=> sprintf( __( '%s button display', 'luxeritas' ), 'Feedly ' ),
		'section'	=> 'sns_section_2',
		'type'		=> 'checkbox',
		'priority'	=> 85
	));

	//---------------------------------------------------------------------------
	// 追加 CSS
	//---------------------------------------------------------------------------
	/*
	$wp_customize->add_section( 'custom_css', array(
		'title'		=> __( 'Additional CSS', 'luxeritas' ),
		'description'	=> '<p class="snormal f11em mm23l mm10b"><hr />' . __( 'We do not recommend using this feature with Luxeritas Theme. Please use the child theme editing function.', 'luxeritas' ) . '<hr class="m10t" /></p>',
		'priority'	=> 200
	));
	*/
});

/*---------------------------------------------------------------------------
 * カスタマイズ画面の CSS
 *---------------------------------------------------------------------------*/
add_action( 'customize_controls_print_styles', function() {
	wp_register_style( 'thk_admin_menu_css', get_template_directory_uri() . '/css/admin-custom-menu.css', false, false );
        wp_enqueue_style( 'thk_admin_menu_css' );
});

/*---------------------------------------------------------------------------
 * sanitize
 *---------------------------------------------------------------------------*/
// 文字列型
if( function_exists('thk_sanitize') === false ):
function thk_sanitize( $value ) {
	if( is_string( $value ) === true ) {
		//return htmlspecialchars( $value );
		return esc_attr( $value );
	}
	return $value;
}
endif;

// INT型
if( function_exists('thk_sanitize_integer') === false ):
function thk_sanitize_integer( $value ) {
	if( ctype_digit( $value ) ) {
		return (int)$value;
	}
	return 0;
}
endif;

// FLOAT型
if( function_exists('thk_sanitize_float') === false ):
function thk_sanitize_float( $value ) {
	if( is_numeric( $value ) ) {
		return (float)$value;
	}
	return 0;
}
endif;

// BOOL型
if( function_exists('thk_sanitize_boolean') === false ):
function thk_sanitize_boolean( $value ) {
	if( $value === true ) {
		return true;
	}
	return false;
}
endif;

// URL
if( function_exists('thk_sanitize_url') === false ):
function thk_sanitize_url( $value ) {
	return esc_url_raw( $value );
}
endif;

// 色コード
if( function_exists('thk_sanitize_color') === false ):
function thk_sanitize_color( $value ) {
	return sanitize_hex_color( maybe_hash_hex_color( $value ) );
}
endif;
