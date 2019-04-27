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
 * カスタムフィールドの値をDBに書き込む
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_post_meta_update' ) === false ):
function thk_post_meta_update( $field_id ) {
	add_action( 'save_post', function() use ( $field_id ) {
		global $post;

		if( isset( $post->ID ) ) {
			$data = isset( $_POST[$field_id] ) && !empty( $_POST[$field_id] ) ? $_POST[$field_id] : '';
			$data_org = get_post_meta( $post->ID, $field_id );

			if( !empty( $data ) && empty( $data_org ) ) {
				/* 保存 */
				add_post_meta( $post->ID, $field_id, $data, true );
			}
			elseif( !empty( $data ) && $data !== $data_org ) {
		        	/* 更新 */
		        	update_post_meta( $post->ID, $field_id, $data );
			}
			else {
		        	/* 削除 */
		        	delete_post_meta( $post->ID, $field_id );
			}
		}
	});
}
endif;

/*---------------------------------------------------------------------------
 * addhead
 *---------------------------------------------------------------------------*/
/* 投稿画面に表示するフォーム */
if( function_exists( 'og_image_meta_box' ) === false ):
function addhead_meta_box() {
	global $post;

	$addhead = get_post_meta( $post->ID, 'addhead', true );
	?>
<p style="margin-bottom:0"><?php echo __( '* If you would like to add &lt;style&gt;, &lt;javascript&gt;, &lt;meta&gt;, &lt;link&gt; and other tags in the head tag in post, please write it here.', 'luxeritas' ); ?></p>
<p style="margin-top:8px"><?php echo __( '* You can change the title by describing &lt;title&gt; ~ &lt;/title&gt;.', 'luxeritas' ); ?></p>
<textarea cols="120" rows="6" name="addhead" id="addhead" style="max-width:100%;width:100%"><?php if( !empty( $addhead ) ) echo $addhead; ?></textarea>
	<?php
}
endif;

/* カスタムフィールドの値をDBに書き込む */
thk_post_meta_update( 'addhead' );

/*---------------------------------------------------------------------------
 * change_description_meta_box
 *---------------------------------------------------------------------------*/
/* 投稿画面に表示するフォーム */
if( function_exists( 'change_description_meta_box' ) === false ):
function change_description_meta_box() {
	global $post;

	$change_desc = get_post_meta( $post->ID, 'change-description', true );
	?>
<p><?php echo __( '* If you would like to change the meta description, please write it here.', 'luxeritas' ); ?></p>
<input type="text" name="change-description" id="change-description" value="<?php if( !empty( $change_desc ) ) echo $change_desc; ?>" style="max-width:100%;width:100%">
	<?php
}
endif;

/* カスタムフィールドの値をDBに書き込む */
thk_post_meta_update( 'change-description' );

/*---------------------------------------------------------------------------
 * add_keywords_meta_box
 *---------------------------------------------------------------------------*/
/* 投稿画面に表示するフォーム */
if( function_exists( 'add_keywords_meta_box' ) === false ):
function add_keywords_meta_box() {
	global $post;

	$add = get_post_meta( $post->ID, 'add-keywords', true );
	?>
<p><?php echo __( '* If there are meta keywords you want to add other than category names and tags, please write them here (comma separated).', 'luxeritas' ); ?></p>
<input type="text" name="add-keywords" id="add-keywords" value="<?php if( !empty( $add ) ) echo $add; ?>" style="max-width:100%;width:100%">
	<?php
}
endif;

/* カスタムフィールドの値をDBに書き込む */
thk_post_meta_update( 'add-keywords' );

/*---------------------------------------------------------------------------
 * amp_custom_meta_box
 *---------------------------------------------------------------------------*/
/* 投稿画面に表示するフォーム */
if( function_exists( 'amp_custom_meta_box' ) === false ):
function amp_custom_meta_box() {
	global $post;

	$add = get_post_meta( $post->ID, 'amp-custom', true );
	?>
<p><?php echo __( '* If you would like to add CSS for AMP in post, please write it here. ( No &lt;style&gt; tag required )', 'luxeritas' ); ?></p>
<textarea cols="120" rows="6" name="amp-custom" id="amp-custom" style="max-width:100%;width:100%"><?php if( !empty( $add ) ) echo $add; ?></textarea>
	<?php
}
endif;

/* カスタムフィールドの値をDBに書き込む */
thk_post_meta_update( 'amp-custom' );

/*---------------------------------------------------------------------------
 * og:image / twitter:image
 *---------------------------------------------------------------------------*/
/* 投稿画面に表示するフォーム */
if( function_exists( 'og_image_meta_box' ) === false ):
function og_image_meta_box() {
	global $post;
	/* 既に値がある場合、その値をフォームに出力 */
	$image = '';
	$og_image = get_post_meta( $post->ID, 'og_img', true );
	$post_thumbnail = has_post_thumbnail();
	$cont = $post->post_content;
	$preg = '/<img.*?src=(["\'])(.+?)\1.*?>/i';

	if( !empty( $og_image ) ) {
		$image = get_post_meta( $post->ID, 'og_img', true );
	}
	elseif( !empty( $post_thumbnail ) ) {
		$img_id = get_post_thumbnail_id();
		$img_arr = wp_get_attachment_image_src( $img_id, 'full');
		$image = $img_arr[0];
	}
	elseif( preg_match( $preg, $cont, $img_url ) ) {
		$image = $img_url[2];
	}
?>
<script>thkImageSelector('og-img', 'og:image / twitter:image');</script>
<div id="og-img-form">
<input id="og-img" type="hidden" name="og_img" value="<?php echo $image; ?>" />
<input id="og-img-set" type="button" class="button" value="<?php echo __( 'Set image', 'luxeritas' ); ?>" />
<input id="og-img-del" type="button" class="button" value="<?php echo __( 'Delete image', 'luxeritas' ); ?>" />
</div>
<?php
	if( !empty( $image ) ) {
?>
<div id="og-img-view" style="max-width:300px"><img src="<?php echo $image; ?>" style="max-width:300px" /></div>
<?php
	}
	else {
?>
<div id="og-img-view" style="max-width:300px"></div>
<?php
	}
}
endif;

/* カスタムフィールドの値をDBに書き込む */
thk_post_meta_update( 'og_img' );

/*---------------------------------------------------------------------------
 * ボックス・CSS・Javascript などの追加
 *---------------------------------------------------------------------------*/
if(
	stripos( $_SERVER['REQUEST_URI'], 'wp-admin/post-new.php' ) !== false ||
	stripos( $_SERVER['REQUEST_URI'], 'wp-admin/post.php' ) !== false ||
	( isset( $_REQUEST['page'] ) && stripos( $_SERVER['REQUEST_URI'], 'luxe' ) !== false )
) {
	// addhead のボックス追加
	add_action( 'add_meta_boxes', function() {
		add_meta_box( 'addhead', __( 'Additional headers', 'luxeritas' ), 'addhead_meta_box', null, 'normal', 'high' );
	}, 10, 2 );

	// change-description のボックス追加
	add_action( 'add_meta_boxes', function() {
		add_meta_box( 'change_description', __( 'Change description', 'luxeritas' ) . ' ( meta description )', 'change_description_meta_box', null, 'normal', 'high' );
	}, 10, 2 );

	// add-keywords のボックス追加
	add_action( 'add_meta_boxes', function() {
		add_meta_box( 'add_keywords', __( 'Add keywords', 'luxeritas' ) . ' ( meta keywords )', 'add_keywords_meta_box', null, 'normal', 'high' );
	}, 10, 2 );

	// amp_custom
	if( get_theme_mod( 'amp_enable', false ) === true ) {
		add_action( 'add_meta_boxes', function() {
			add_meta_box( 'amp_custom', __( 'Additional AMP styles', 'luxeritas' ), 'amp_custom_meta_box', null, 'normal', 'high' );
		}, 10, 3 );
	}

	// og:image / twitter:image のボックス追加
	// 寄稿者の権限は除外（メディア使えないので）
	if( current_user_can( 'edit_published_posts' ) === true ) {
		if( get_theme_mod( 'facebook_ogp_enable', true ) === true || get_theme_mod( 'twitter_card_enable', true ) === true ) {
			add_action( 'add_meta_boxes', function() {
		  		add_meta_box( 'og_image', __( '&quot;og:image / twitter:image&quot;', 'luxeritas' ), 'og_image_meta_box', null, 'normal', 'high' );
			}, 10, 2 );
			/*
			add_action( 'admin_menu', function() {
				add_meta_box( 'og_image', __( '&quot;og:image / twitter:image&quot;', 'luxeritas' ) , 'og_image_meta_box', 'post', 'normal', 'high' );
				add_meta_box( 'og_image', __( '&quot;og:image / twitter:image&quot;', 'luxeritas' ), 'og_image_meta_box', 'page', 'normal', 'high' );
			});
			*/
		}
	}
}
