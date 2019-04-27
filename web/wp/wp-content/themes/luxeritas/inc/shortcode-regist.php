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
 * thk_shortcode_regist
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_shortcode_regist' ) === false ):
function thk_shortcode_regist( $regist_name, $shortcodes = array(), $code_text = '', $new_or_edit = 'new', $text_format = false ) {
	$ret = false;
	$regist_name_check = $regist_name;

	if( strpos( $regist_name, ' ' ) !== false ) {
		$regist_name_check = substr( $regist_name, 0, strpos( $regist_name, ' ' ) );
	}

	// ショートコード命名規則チェック
	if( strpos( $regist_name, ' ' ) !== false ) {
		if( preg_match( '/^[a-zA-Z_\x7F-\xFF][0-9a-zA-Z_-\x7F-\xFF]*? +.+$/im', $regist_name ) !== 1 ) {
			add_settings_error( 'luxe-custom', $_POST['option_page'], '[' . $regist_name . '] ' . __( 'This shortcode name is not available in WordPress', 'luxeritas' ), 'error' );
			$ret = true;
		}
	}
	else {
		if( preg_match( '/^[a-zA-Z_\x7F-\xFF][0-9a-zA-Z_-\x7F-\xFF]*$/im', $regist_name ) !== 1 ) {
			add_settings_error( 'luxe-custom', $_POST['option_page'], '[' . $regist_name . '] ' . __( 'This shortcode name is not available in WordPress', 'luxeritas' ), 'error' );
			$ret = true;
		}
	}

	// 登録済みのショートコードかをチェック
	if( $new_or_edit === 'new' ) {
		$regist_flag = false;
		$registed = get_theme_phrase_mods();

		foreach( (array)$registed as $key => $val ) {
			if( $key === 'sc-' . $regist_name_check || strpos( $key, 'sc-' . $regist_name_check . ' ' ) !== false ) {
				$regist_flag = true;
				break;
			}
		}

		if( $regist_flag === true ) {
			add_settings_error( 'luxe-custom', $_POST['option_page'], sprintf( '[' . $regist_name_check . '] ' . __( 'This %s has already been registered.', 'luxeritas' ), __( 'shortcode', 'luxeritas' ) ), 'error' );
			$ret = true;
		}
		unset( $registed );
	}

	// サンプル登録の場合はエラーメッセージだけ一旦初期化
	if( isset( $_POST['option_page'] ) && ( $_POST['option_page'] === 'sample_phrase' || $_POST['option_page'] === 'sample_shortcode' ) ) {
		global $wp_settings_errors;
		$wp_settings_errors = array();
	}

	if( $ret !== true ) {
		$json_enc = @json_encode( $shortcodes );
		if( $json_enc !== false ) {
			global $wp_filesystem;

			$filesystem = new thk_filesystem();
			if( $filesystem->init_filesystem( site_url() ) === false ) return false;

			$shortcodes_dir = SPATH . DSEP . 'shortcodes' . DSEP;

			$code_text = trim( $code_text );

			if( $text_format !== false ) {
				$build_func = "<?php\n";

				/*
				 * start シンタックスハイライター用の特殊処理
				 */
				$highlighter_list = thk_syntax_highlighter_list();

				if( isset( $highlighter_list[$regist_name_check] ) ) {
$filter = <<<EOF
add_filter('the_content',function(\$c){
	preg_match_all('/\[${regist_name_check}\].+?\[\/${regist_name_check}\]/ism',\$c,\$m);
	if(isset(\$m[0])){
		foreach((array)\$m[0] as \$v){
			\$s=htmlspecialchars(\$v,ENT_QUOTES|ENT_HTML5,'UTF-8',false);
			\$c=str_replace(\$v,\$s,\$c);
		}
	}
	return \$c;
},9);
EOF;
					$build_func .= str_replace( array( "\n", "\t" ), '', $filter );
				}
				/*
				 * end シンタックスハイライター用の特殊処理
				 */

				if( empty( $shortcodes['php'] ) ) {
					$build_func .= 'add' . '_short' . "code('" . $regist_name_check . "',function(){return <<<EOF\n" . $code_text . "\n";
					$build_func .= "EOF;\n});\n";
				}
				else {
					$build_func .= 'add' . '_short' . "code('" . $regist_name_check . "',function(" . '$args,$contents){' . "\n" . $code_text . "\n";
					$build_func .= 'return $contents;' . "\n});\n";
				}
				$code_text = $build_func;
			}

			if( $wp_filesystem->is_dir( $shortcodes_dir ) === false ) {
				// ディレクトリが存在しなかったら作成
				if( wp_mkdir_p( $shortcodes_dir ) === false ) {
					if( $wp_filesystem->mkdir( $shortcodes_dir, FS_CHMOD_DIR ) === false && $wp_filesystem->is_dir( $shortcodes_dir ) === false ) {
						add_settings_error( 'luxe-custom', $_POST['option_page'], __( 'Could not create directory.', 'luxeritas' ), 'error' );
						$ret = true;
					}
				}
			}
			if( wp_is_writable( $shortcodes_dir ) === true ) {
				$code_text = preg_replace( "/\r\n|\r|\n/", "\n", $code_text );

				if( $filesystem->file_save( $shortcodes_dir . $regist_name_check . '.inc', $code_text ) === false ) {
					// ファイル保存失敗
					add_settings_error( 'luxe-custom', $_POST['option_page'], __( 'Error saving file.', 'luxeritas' ), 'error' );
					$ret = true;
				}
			}
			else {
				// ディレクトリの書き込み権限がない
				add_settings_error( 'luxe-custom', $_POST['option_page'],
					__( 'You do not have permission to create and save files.', 'luxeritas' ) .
					__( 'Please check the owner and permissions of the following file or directory.', 'luxeritas' ) . '<br />' . $shortcodes_dir . $regist_name_check . '.inc'
				, 'error' );
				$ret = true;
			}

			if( $ret === false ) {
				if( set_theme_phrase_mod( 'sc-' . $regist_name, $json_enc ) === false ) {
					$ret = true;
				}
			}
		}
		else {
			$ret = true;
		}
	}
	return $ret;
}
endif;

/*---------------------------------------------------------------------------
 * conditional execution
 *---------------------------------------------------------------------------*/
$_POST = stripslashes_deep( $_POST );

require_once( INC . 'optimize.php' );
global $wp_filesystem;

$filesystem = new thk_filesystem();
if( $filesystem->init_filesystem( site_url() ) === false ) return false;

if( isset( $_FILES['add-file-shortcode']['name'] ) && isset( $_FILES['add-file-shortcode']['tmp_name'] ) ) {
	$json_file = $_FILES['add-file-shortcode']['tmp_name'];
	$json = $wp_filesystem->get_contents( $json_file );
	$a = (array)@json_decode( $json );

	if( !empty( $a ) ) {
		foreach( $a as $key => $val ) {
			$opts = (array)$val;
			$regist_name = $key;
			$shortcodes  = array(
				'label'  => isset( $opts['label'] )  ? (string)$opts['label'] : '',
				'php'    => isset( $opts['php'] )    ? (bool)$opts['php']     : false,
				'close'  => isset( $opts['close'] )  ? (bool)$opts['close']   : false,
				'hide'   => isset( $opts['hide'] )   ? (bool)$opts['hide']    : false,
				'active' => isset( $opts['active'] ) ? (bool)$opts['active']  : false,
			);
			$code_text = isset( $opts['active'] ) ? unserialize( $opts['contents'] ) : '';
			break;
		}

		$err = thk_shortcode_regist( $regist_name, $shortcodes, $code_text );
	}
}
elseif( isset( $_POST['code_save'] ) && isset( $_POST['code_save_item'] ) ) {
	$save = trim( esc_attr( stripslashes( $_POST['code_save_item'] ) ) );
	$save_file = $save;

	if( strpos( $save, ' ' ) !== false ) {
		$save_file = substr( $save, 0, strpos( $save, ' ' ) );
	}

	$contents = '';

	if( file_exists( SPATH . DSEP . 'shortcodes' . DSEP . $save_file . '.inc' ) === true ) {
		$contents = $wp_filesystem->get_contents( SPATH . DSEP . 'shortcodes' . DSEP . $save_file . '.inc' );
	}

	$mods = get_theme_phrase_mods();
	$settings = (array)@json_decode( $mods['sc-' . $save] );
	unset( $mods );

	$shortcodes  = array(
		'label'		=> (string)$settings['label'],
		'php'		=> (bool)$settings['php'],
		'close'		=> (bool)$settings['close'],
		'hide'		=> (bool)$settings['hide'],
		'active'	=> (bool)$settings['active'],
		'contents'	=> serialize( preg_replace( "/\r\n|\r|\n/", "\n", $contents ) )
	);

	$json = json_encode( array( $save => $shortcodes ) );

	$file = $save_file . '.json';
	@ob_start();
	@header( 'Content-Description: File Transfer' );
	@header( 'Content-Type: application/json; charset=' . get_option( 'blog_charset' ) );
	@header( 'Content-Disposition: attachment; filename=' . $file );
	echo $json;
	@ob_end_flush();
	exit;
}
elseif( isset( $_POST['code_delete'] ) && isset( $_POST['code_delete_item'] ) ) {
	$del = trim( esc_attr( $_POST['code_delete_item'] ) );
	remove_theme_phrase_mod( 'sc-' . $del );

	if( strpos( $del, ' ' ) !== false ) {
		$del = substr( $del, 0, strpos( $del, ' ' ) );
	}

	if( file_exists( SPATH . DSEP . 'shortcodes' . DSEP . $del . '.inc' ) === true ) {
		$wp_filesystem->delete( SPATH . DSEP . 'shortcodes' . DSEP . $del . '.inc' );
	}
}
else {
	if( isset( $_POST['code_name'] ) ) {
		$regist_name = trim( esc_attr( $_POST['code_name'] ) );

		$shortcodes  = array(
			'label'  => isset( $_POST['code_label'] )  ? trim( esc_attr( $_POST['code_label'] ) ) : '',
			'php'    => isset( $_POST['code_php'] )    ? (bool)$_POST['code_php']    : false,
			'close'  => isset( $_POST['code_close'] )  ? (bool)$_POST['code_close']  : false,
			'hide'   => isset( $_POST['code_hide'] )   ? (bool)$_POST['code_hide']   : false,
			'active' => isset( $_POST['code_active'] ) ? (bool)$_POST['code_active'] : false,
		);
		$code_text = isset( $_POST['code_text'] ) ? $_POST['code_text'] : '';

		$new_or_edit = isset( $_POST['code_new'] ) && $_POST['code_new'] == 1 ? 'new' : 'edit';

		$err = thk_shortcode_regist( $regist_name, $shortcodes, $code_text, $new_or_edit, true );
	}
}
