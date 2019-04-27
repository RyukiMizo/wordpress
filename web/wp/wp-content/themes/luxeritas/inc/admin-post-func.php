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

require( INC . 'post-meta-boxes.php');
require( INC . 'post-side-boxes.php' );

/*---------------------------------------------------------------------------
 * admin init
 *---------------------------------------------------------------------------*/
add_action( 'admin_init', function() {
	global $luxe;

	// TinyMCE init
	if( current_user_can( 'edit_posts' ) === true && get_user_option( 'rich_editing' ) === 'true' ) {
		$path = TPATH !== SPATH ? SPATH : TPATH;

		// エディタ CSS のタイムスタンプチェック
		if( file_exists( $path . DSEP . 'editor-style.css' ) === true && file_exists( $path . DSEP . 'editor-style.min.css' ) === true ) {
			$etime = filemtime( $path . DSEP . 'editor-style.css' );
			if( $etime !== filemtime( $path . DSEP . 'editor-style.min.css' ) ) {
				global $wp_filesystem;
				require_once( INC . 'compress.php' );
				thk_create_editor_style();
				$filesystem = new thk_filesystem();
				$filesystem->init_filesystem();
				$wp_filesystem->touch( $path . DSEP . 'editor-style.min.css', $etime );
			}
		}

		require( INC . 'tinymce-before-init.php' );
	}
}, 9 );

/*---------------------------------------------------------------------------
 * admin head
 *---------------------------------------------------------------------------*/
add_action( 'admin_head', function() {
	global $luxe;

	// 投稿画面のボタン挿入(クイックタグ)
	$teditor_buttons_d = get_theme_admin_mod( 'teditor_buttons_d' );
	if( !empty( $teditor_buttons_d ) ) {
		$luxe['teditor_buttons_d'] = $teditor_buttons_d;
	}

	require( INC . 'quicktags.php' );
	require( INC . 'thk-post-style.php' );

	// 定型文の挿入ボタン
	require( INC . 'phrase-post.php' );

	// ショートコードの挿入ボタン
	require( INC . 'shortcode-post.php' );

	// ブログカードの挿入ボタン
	if( isset( $luxe['blogcard_enable'] ) ) {
		require( INC . 'blogcard-post-func.php' );
	}
}, 100 );

/*---------------------------------------------------------------------------
 * タブの入力ができるようにする
 *---------------------------------------------------------------------------*/
//add_action( 'admin_footer', function() {
add_action( 'admin_print_footer_scripts', function() {
?>
<script>
var textareas = document.getElementsByTagName('textarea');
var count = textareas.length;
for( var i = 0; i < count; i++ ) {
	textareas[i].onkeydown = function(e){
		if( e.keyCode === 9 || e.which === 9 ) {
			e.preventDefault();
			var s = this.selectionStart;
			this.value = this.value.substring( 0, this.selectionStart ) + "\t" + this.value.substring( this.selectionEnd );
			this.selectionEnd = s + 1;
		}
	}
}
</script>
<?php
}, 99 );
