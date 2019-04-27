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

global $luxe, $awesome;

if( isset( $luxe['amp'] ) && isset( $luxe['amp_hidden_comments'] ) ) return;

$far = 'far ';
$fa_id_card = 'fa-id-card';

if( $awesome === 4 ) {
	$far = 'fa ';
	$fa_id_card = 'fa-id-card-o';
}
?>
<div id="comments" class="grid">
<h2 class="discussion"><i class="<?php echo $far, $fa_id_card; ?>"></i><?php echo __( 'Discussion', 'luxeritas' ); ?></h2>
<?php
if( have_comments() ) {

/*---------------------------------------------------------------------------
 * wp_list_comments の callback 関数(コメントリスト表示部分)
 * 中身は /wp-includes/class-walker-comment.php (250行目付近) からの改変 (不要な分岐を排除して schema.org 付与)
 *---------------------------------------------------------------------------*/
if( function_exists('thk_list_comments') === false ):
function thk_list_comments( $comment, $args, $depth ) {
	global $luxe;

	// コメントに書かれた URL を自動でリンクに変換させない場合
	if( isset( $luxe['prevent_comment_links'] ) ) {
		remove_filter( 'comment_text', 'make_clickable', 9 );
	}

	// comment_class からユーザーID ( というか user_nicename ) 削除
	add_filter( 'comment_class', function( $classes ) {
		foreach ( $classes as $key => $val ) {
			if ( stripos( $val, 'comment-author-' ) !== false ) {
				unset( $classes[$key] );
			}
		}
		return $classes;
	}, 10, 1 );

	$comment_class = comment_class( empty( $args['has_children'] ) ? '' : 'parent', $comment, null, false );
?>
<li <?php echo $comment_class; ?> id="comment-<?php comment_ID(); ?>">
<div id="div-comment-<?php comment_ID(); ?>" class="comment-body" itemscope itemtype="https://schema.org/UserComments">
<div class="comment-author vcard">
<?php
	if( 0 != $args['avatar_size'] ) {
		echo str_replace( array( 'http:', 'https:' ), '', get_avatar( $comment, $args['avatar_size'] ) );
	}
?><cite class="fn" itemprop="creator name"><?php
	printf( '%s</cite><span class="says">', get_comment_author_link( $comment ) );
	echo __( 'says:', 'luxeritas' ), '</span>';
?>
</div>
<?php
	if( '0' == $comment->comment_approved ) {
?>
<em class="comment-awaiting-moderation"><?php echo __( 'Your comment is awaiting moderation.', 'luxeritas' ) ?></em>
<br />
<?php
	}
?>
<div class="comment-meta commentmetadata"><time itemprop="commentTime" datetime="<?php echo get_comment_date( 'Y-m-d', $comment ); ?>"></time>
<a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>"><?php
	/* translators: 1: comment date, 2: comment time */
	printf( __( '%1$s at %2$s', 'luxeritas' ), get_comment_date( '', $comment ),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)', 'luxeritas' ), '&nbsp;&nbsp;', '' );
?>
</div>
<div class="comment-text" itemprop="commentText">
<?php
	comment_text( $comment, array_merge( $args, array( 'add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) );

	if( !isset( $args['reply_text'] ) ) {
		ob_start();
			comment_reply_link( array_merge( $args, array(
			'add_below' => 'div-comment',
			'depth'     => $depth,
			'max_depth' => $args['max_depth'],
			'before'    => '<div class="reply">',
			'after'     => '</div>'
		) ) );

		$comment_reply_link = ob_get_clean();
		echo str_replace( '<a ', '<a itemprop="replyToUrl" ', $comment_reply_link );
	}
?>
</div>
</div>
<?php
}
endif;
// callback ここまで

/*---------------------------------------------------------------------------
 * コメントリストの表示
 *---------------------------------------------------------------------------*/
if( $luxe['comment_list_view'] === 'all' ) {
?>
<ol class="comments-list">
<?php
	if( isset( $luxe['pings_reply_button'] ) ) {
		wp_list_comments( array( 'avatar_size' => 55, 'callback' => 'thk_list_comments' ) );
	}
	else {
		wp_list_comments( array( 'reply_text' => '', 'avatar_size' => 55, 'callback' => 'thk_list_comments' ) );
	}
?>
</ol>
<?php
}
else {
	$comments_by_type = separate_comments( $comments );

	if( !empty( $comments_by_type['comment'] ) ) {
		$fa_comments = $awesome === 4 ? 'fa-comments-o' : 'fa-comments';
?>
<h3 class="messages"><i class="<?php echo $far, $fa_comments; ?>"></i><?php echo __( 'New Comments', 'luxeritas' ); ?></h3>
<ol class="comments-list">
<?php
		wp_list_comments( array( 'type' => 'comment', 'avatar_size' => 55, 'callback' => 'thk_list_comments' ) );
?>
</ol>
<?php
	}

	if( $luxe['comment_list_view'] !== 'no_pings' && !empty( $comments_by_type['pings'] ) ) {
?>
<h3 class="messages"><i class="fa fas fa-reply-all"></i><?php echo __( 'New Pnigbacks &amp; Trackbacks', 'luxeritas' ); ?></h3>
<ol class="comments-list">
<?php
		if( isset( $luxe['pings_reply_button'] ) ) {
			wp_list_comments( array( 'type' => 'pings', 'callback' => 'thk_list_comments' ) );
		}
		else {
			wp_list_comments( array( 'type' => 'pings', 'reply_text' => '', 'callback' => 'thk_list_comments' ) );
		}
?>
</ol>
<?php
	}
}

/*---------------------------------------------------------------------------
 * コメントのページネーション
 *---------------------------------------------------------------------------*/
$cpage_count = get_comment_pages_count();
if( $cpage_count > 1 ) {
?>
<div id="c-paging"><nav><ul class="pagination">
<?php
$comments_links = paginate_comments_links( array(
	'prev_next'	=> false,
	'echo'		=> false
) );

$page_num = array();
$page_num_rev = array();
$cpage_opt = get_option('default_comments_page');

$comments_links = preg_replace( '/>(([0-9]|&hellip;)+?)<\/a>/', '>$1#explode#', $comments_links );
$comments_links = preg_replace( '/>(([0-9]|&hellip;)+?)<\/span>/', '>$1#explode#', $comments_links );
$comments_array = explode( '#explode#', $comments_links );
$comments_array = array_filter( $comments_array, 'strlen' );

for( $i = 1; $cpage_count >= $i; ++$i ) {
	$page_num[] = $i;
}

// WordPress のコメント分割で newest か oldest のどちらに設定されてるかでボタンの配置を反転させる
if( $cpage_opt === 'newest' ) {
	$comments_array = array_reverse( $comments_array, false );
	$page_num_rev = array_reverse( $page_num );	// ページ番号反転用
}

$comments_links = '';
foreach( $comments_array as $val ) {
	$num = strip_tags( $val );
	$comments_links .= stripos( $val, 'current' ) !== false ? '<li class="active">' : '<li>';
	if( $cpage_opt === 'newest' && isset( $page_num[$num - 1] ) ) {
		$comments_links .= str_replace( '>' . $page_num[$num - 1], '>' . $page_num_rev[$num - 1], $val );
	}
	else {
		$comments_links .= $val;
	}
	$comments_links .= stripos( $val, 'current' ) !== false ? '</span></li>' : '</a></li>';
}

echo( $comments_links );
?>
</ul></nav></div>
<?php
	}
}
else {
	$fa_comments = $awesome === 4 ? 'fa-comments-o' : 'fa-comments';
?>
<h3 class="messages"><i class="<?php echo $far, $fa_comments; ?>"></i><?php echo __( 'New Comments', 'luxeritas' ); ?></h3>
<p class="no-comments"><?php echo __( 'No comments yet.  Be the first one!', 'luxeritas' ); ?></p>
<?php
}

/*---------------------------------------------------------------------------
 * コメントフォームの表示
 *---------------------------------------------------------------------------*/

// aria-required があれば、required 不要なので消す( メールとコメント欄 )
add_filter( 'comment_form_default_fields', function( $fields ) use( $luxe ) {
	$commenter = wp_get_current_commenter();
	$req = get_option('require_name_email');
	$fields = array(
		'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name', 'luxeritas' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
			    '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" maxlength="245" aria-required="true" /></p>',
		'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email', 'luxeritas' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
			    '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" maxlength="100" aria-describedby="email-notes" aria-required="true" /></p>',
		'url'    => '<p class="comment-form-url"><label for="url">' . __( 'Website', 'luxeritas' ) . '</label> ' .
			    '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" maxlength="200" /></p>',
	);
	return $fields;
}, 7 );

// 画像認証
if( isset( $luxe['captcha_enable'] ) && $luxe['captcha_enable'] !== 'none' ) {
	// reCAPTCHA v3
	if( $luxe['captcha_enable'] === 'recaptcha-v3' && isset( $luxe['recaptcha_site_key'] ) && !empty( $luxe['recaptcha_site_key'] ) ) {
		add_filter( 'comment_form_default_fields', function( $fields ) use( $luxe ) {
			$fields += array(
				'recaptcha' => '<input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">'
			);

			return $fields;
		}, 8 );

		wp_enqueue_script( 'recaptcha-v3', '//www.google.com/recaptcha/api.js?render=' . $luxe['recaptcha_site_key'], array(), false, true );
		wp_add_inline_script( 'recaptcha-v3', 
			'grecaptcha.ready(function(){' .
			'grecaptcha.execute("' . $luxe['recaptcha_site_key'] . '",{action:"homepage"})' .
			'.then(function(token){' .
			'document.getElementById("g-recaptcha-response").value=token;' .
			'});' .
			'});'
		);

	}

	// reCAPTCHA v2
	elseif( $luxe['captcha_enable'] === 'recaptcha' && isset( $luxe['recaptcha_site_key'] ) && !empty( $luxe['recaptcha_site_key'] ) ) {
		add_filter( 'comment_form_default_fields', function( $fields ) use( $luxe ) {
			$fields += array(
				'recaptcha'=> '<p class="comment-form-captcha"><div class="g-recaptcha" ' .
					      'data-theme="' . $luxe['recaptcha_theme'] . '" ' .
					      'data-size="'  . $luxe['recaptcha_size'] . '" ' .
					      'data-type="'  . $luxe['recaptcha_type'] . '" ' .
					      'data-sitekey="' . $luxe['recaptcha_site_key'] . '"></div></p>'
			);
			return $fields;
		}, 8 );
		wp_enqueue_script( 'recaptcha', '//www.google.com/recaptcha/api.js', array(), false, true );
	}

	// Securimage
	elseif( $luxe['captcha_enable'] === 'securimage' ) {
		add_filter( 'comment_form_default_fields', function( $fields ) use( $luxe ) {
			global $awesome;

			$get_pram = '';

			$capopt = array(
				'iw' => 'secimg_image_width',		// image_width
				'ih' => 'secimg_image_height',		// image_height
				'sl' => 'secimg_start_length',		// code_length start
				'el' => 'secimg_end_length',		// code_length end
				'ch' => 'secimg_charset',		// charset
				'fr' => 'secimg_font_ratio',		// font_ratio
				'cl' => 'secimg_color',			// text_color
				'bg' => 'secimg_bg_color',		// image_bg_color
				'pb' => 'secimg_perturbation',		// perturbation
				'nl' => 'secimg_noise_level',		// noise_level
				'nc' => 'secimg_noise_color',		// noise_color
				'ln' => 'secimg_num_lines',		// num_lines
				'lc' => 'secimg_line_color',		// line_color
			);

			foreach( $capopt as $key => $val ) {
				if( isset( $luxe[$val] ) ) {
					$get_pram .= '&amp;' . $key . '=' . ltrim( $luxe[$val], '#' );
				}
			}
			$get_pram = ltrim( $get_pram, '&amp;' );

			$image_width  = isset( $luxe['secimg_image_width'] )  ? $luxe['secimg_image_width']  : 170;
			$image_height = isset( $luxe['secimg_image_height'] ) ? $luxe['secimg_image_height'] : 45;

			$fa_refresh = $awesome === 4 ? 'fa-refresh' : 'fa-sync-alt';

			$fields += array(
				'captcha' => '<p class="comment-form-captcha"><label for="captcha">' . __( 'CAPTCHA', 'luxeritas' ) . ' <span class="required">*</span></label> ' .
					     '<p class="comment-form-captcha-img"><img id="captcha" src="' . TDEL . '/captcha.php?' . $get_pram . '" width="' . $image_width . '" height="' . $image_height . '" alt="CAPTCHA Image" />' .
					     '<a href="#" onclick="document.getElementById' . "('captcha')" . '.src = ' . "'" . TDEL . '/captcha.php?' . $get_pram . "&'" . ' + Math.random(); return false"><i class="fa fas ' . $fa_refresh . '" aria-hidden="true" style="font-size:32px;margin-left:10px;vertical-align:middle"></i></a></p>' .
					     '<input id="captcha_code" type="text" name="captcha_code" value="" size="12" aria-required="true" /></p>'
			);
			return $fields;
		}, 8 );
	}
}
add_filter( 'thk_comment_fields', function( $args ) {
	global $awesome;

	$far = 'far ';
	$fa_comment = 'fa-comment';

	if( $awesome === 4 ) {
		$far = 'fa ';
		$fa_comment = 'fa-commenting-o';
	}

	$args = array(
		'fields' => apply_filters( 'comment_form_default_fields', '' ),
		'title_reply' => '<i class="' . $far . $fa_comment . '"></i>' . __( 'Leave a Reply', 'luxeritas' ),
		'comment_field' => '<p class="comment-form-comment"><label for="comment">' . __( 'Comment', 'luxeritas' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>'
	);
	return $args;
});

if( isset( $luxe['amp'] ) ) {
?>
<div id="amp-comment_link">
<a href="<?php the_permalink(); ?>#respond" rel="nofollow" class="comment-reply-link"><?php echo __( 'To comment', 'luxeritas' ); ?></a>
</div>
<?php
}
else {
	$args = apply_filters( 'thk_comment_fields', '' );
	comment_form( $args );
}
?>
</div><!--/comments-->
