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

$_is_search = is_search();

if( $_is_search === true ) {
?>
<div id="list" itemscope itemtype="https://schema.org/SearchResultsPage">
<?php
}
else {
?>
<div id="list" class="ngrid">
<?php
}

global $luxe;

$b_flag = true;
$s_flag = true;

if( $_is_search === true ) {
	if( $luxe['content_discrete'] === 'discrete' ) {
		if( $b_flag === true ) {
			?><div class="toc<?php echo $luxe['content_discrete'] === 'discrete' ? ' grid ' : ' '; ?>clearfix"><?php
			if( $luxe['breadcrumb_view'] === 'inner' ) get_template_part( 'breadcrumb' );
			thk_search_result();
			$b_flag = false;
			?></div><?php
		}
	}
}

// 記事一覧上部ウィジェット
if( is_active_sidebar('posts-list-upper') === true ) {
?>
<div class="posts-list-upper-widget toc<?php echo $luxe['content_discrete'] === 'discrete' ? ' grid ' : ' '; ?>clearfix">
<?php
	dynamic_sidebar( 'posts-list-upper' );
?>
</div><!--/.posts-list-upper-widget-->
<?php
}

// カテゴリの説明文
if( is_category() === true && is_paged() === false && isset( $luxe['grid_category_description'] ) ) {
	$category_description = get_term_field( 'description', get_query_var( 'cat' ), 'category', 'raw' );
	if( !empty( $category_description ) ) {
?>
<div class="category-description toc<?php echo $luxe['content_discrete'] === 'discrete' ? ' grid ' : ' '; ?>clearfix">
<?php
		//echo category_description();
		echo $category_description;
?>
</div><!--/.category-description-->
<?php
	}
}

if( have_posts() === true ) {
	$i = 1;
	$m = 0;

	if( is_active_sidebar('posts-list-middle') === true ) {
		global $wp_query;

		if( isset( $luxe['grid_widget'] ) ) {
			// 記事中央ウィジェットの配置
			$m = $luxe['grid_widget'];
		}
		else {
			// 記事中央ウィジェットの配置 (自動計算)
			$m = (int)floor( (int)$wp_query->post_count / 2 );
		}
	}

	while( have_posts() === true ) {
		the_post();
?>
<div class="toc<?php echo $luxe['content_discrete'] === 'discrete' ? ' grid ' : ' '; ?>clearfix">
<?php
		if( $luxe['breadcrumb_view'] === 'inner' && $b_flag === true ) {
			get_template_part( 'breadcrumb' );
			$b_flag = false;
		}

		if( $_is_search === true ) {
			if( $luxe['content_discrete'] === 'indiscrete' && $s_flag === true ) {
				thk_search_result();
				$s_flag = false;
			}
		}
?>
<section>
<h2 class="entry-title" itemprop="headline name"><a href="<?php the_permalink(); ?>" class="entry-link" itemprop="url"><?php the_title(); ?></a></h2>
<?php
		unset( $luxe['meta_under'] );
		get_template_part('meta');

		// ソースに無駄があるけど、速度的にこっちのが速いので if 分岐多段にした
		if( $luxe['list_view'] === 'excerpt' ) {
			if( !isset( $luxe['sticky_no_excerpt'] ) ) {		// sticky_post も含めて全部抜粋で表示する場合
				get_template_part('list-excerpt');	// 抜粋表示
			}
			elseif( is_sticky() === true ) {		// sticky_post の場合
				get_template_part('list-content');	// 記事全文表示
			}
			else {
				get_template_part('list-excerpt');	// 抜粋表示
			}
		}
		else {
			get_template_part('list-content');	// 記事全文表示
		}
?>
</section>
</div><!--/.toc-->
<?php

		// 記事一覧の中央ウィジェット
		if( $i === $m && function_exists('dynamic_sidebar') === true && is_active_sidebar('posts-list-middle') === true ) {
?>
<div class="posts-list-middle-widget toc<?php echo $luxe['content_discrete'] === 'discrete' ? ' grid ' : ' '; ?>clearfix">
<?php
			dynamic_sidebar( 'posts-list-middle' );
?>
</div><!--/.posts-list-middle-widget-->
<?php
		}
		++$i;
	} // end while()
}
else {
?>
<article>
<div id="core" class="grid">
<?php
if( $luxe['breadcrumb_view'] === 'inner' ) get_template_part( 'breadcrumb' );
?>
<div itemprop="mainEntityOfPage" id="post">
<p><?php echo __('Sorry, the requested post was not found.', 'luxeritas'); ?></p>
</div><!--/post-->
</div><!--/#core-->
</article>
<?php
} // end have_posts()

// 記事一覧下部ウィジェット
if( function_exists('dynamic_sidebar') === true && is_active_sidebar('posts-list-under') === true ) {
?>
<div class="posts-list-under-widget toc<?php echo $luxe['content_discrete'] === 'discrete' ? ' grid ' : ' '; ?>clearfix">
<?php
	dynamic_sidebar( 'posts-list-under' );
?>
</div><!--/.posts-list-under-widget-->
<?php
}

// ページネーションや SNS ボタンのエリア
$bottom_area = false;
$_is_home = is_home();

if( ( isset( $luxe['pagination_visible'] ) && apply_filters( 'thk_pagination', true ) === true ) || ( $_is_home === true && isset( $luxe['sns_toppage_view'] ) ) ) {
	$bottom_area = true;
}

if( $bottom_area === true ) {
?>
<div id="bottom-area" class="toc<?php echo $luxe['content_discrete'] === 'discrete' ? ' grid ' : ' '; ?>clearfix">
<?php
}

// ページネーション
if( isset( $luxe['pagination_visible'] ) ) {
	echo apply_filters( 'thk_pagination', null );
}

// SNS ボタン
if( $_is_home === true && isset( $luxe['sns_toppage_view'] ) ) {
	get_template_part('sns-front');
}

if( $bottom_area === true ) {
?>
</div>
<?php
}
?>
</div><!--/#list-->
