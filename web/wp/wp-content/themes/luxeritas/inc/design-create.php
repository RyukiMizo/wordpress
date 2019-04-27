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

class thk_create_design {
	private $_filesystem;

	public function __construct() {
	}

	public function create_design() {
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
		$temp = wp_tempnam( 'luxe_design' );
		$tmp_dir = $temp . 'thk' . DSEP;
		$dst_dir = $tmp_dir . $_POST['design_name'] . DSEP;
		$img_dir = $dst_dir . 'images' . DSEP;

		if( file_exists( $temp ) === false ) {
			echo	'<div class="error"><p>',
				__( 'Failed to create temporary file with PHP. Check the setting of &quot;upload_tmp_dir&quot; in PHP.', 'luxeritas' ) . '<br />' . $temp,
				'</p></div>';
			return false;
		}
		else {
			require_once( INC . 'optimize.php' );

			global $wp_filesystem;

			$this->filesystem = new thk_filesystem();
			if( $this->filesystem->init_filesystem( site_url() ) === false ) return false;
			$wp_filesystem->delete( $temp );

			if( $wp_filesystem->mkdir( $tmp_dir ) === true ) {
				if( $wp_filesystem->mkdir( $dst_dir ) === true ) {
					/*
					$license = TPATH . DSEP . 'license.txt';
					if( file_exists( $license ) === true ) {
						@copy( $license, $dst_dir . 'license.txt' );
					}
					*/
					$wp_upload_dir = wp_upload_dir();
					$json = '';

					// images ディレクトリ作成
					if( file_exists( $img_dir ) === false ) {
						$wp_filesystem->mkdir( $img_dir );
					}

					/***
						Appearance settings
					 ***/
					// 外観カスタマイズの json ファイル作成
					if( isset( $_POST['design_custom'] ) ) {
						require( INC . 'appearance-settings.php' );
						$mods = get_theme_mods();
						$appearance_design = Appearance::design();

						foreach( (array)$mods as $key => $val ) {
							if( isset( Appearance::$images[$key] ) ) {
								$img = str_replace( $wp_upload_dir['baseurl'], $wp_upload_dir['basedir'], $val );
								if( file_exists( $img ) === true ) {
									@copy( $img, $img_dir . basename( $img ) );
								}
								unset( $mods[$key] );
							}
							elseif(
								!isset( $appearance_design[$key] )	||
								is_array( $val )			||
								is_numeric( $key )			||
								$key === 'custom_css_post_id'
							) {
								unset( $mods[$key] );
							}
						}
						$json = trim( json_encode( $mods ) );
						if( $json === false || $json === 'false' || $json === '[]' ) $json = '';

					}
					$json_file = $dst_dir . 'luxe-appearance.json';
					if( $this->filesystem->file_save( $json_file, $json ) === false ) return false;

					/***
						Design File が適用済みの場合は image ディレクトリをコピー
					 ***/
					if( isset( $_POST['design_active'] ) ) {
						global $luxe;

						if( isset( $luxe['design_file'] ) ) {
							$design_img = SPATH . DSEP . 'design' . DSEP . $luxe['design_file'] . DSEP . 'images';
							if( $wp_filesystem->is_dir( $design_img ) === true ) {
								copy_dir( $design_img, $dst_dir . 'images' );
							}
						}
					}

					/***
						スタイルシート
					 ***/
					$this->create_css( $dst_dir );		// style.css
					$this->create_css( $dst_dir, true );	// style-amp.css


					/***
						TinyMCE stylesheet
					 ***/
					$tinymce_file = $dst_dir . 'editor-style.css';
					$tinymce_data = '/* TinyMCE stylesheet */' . "\n";

					if( $this->filesystem->file_save( $tinymce_file, $tinymce_data ) === false ) return false;


					/***
						Screenshot ファイル
					 ***/
					if( isset( $_POST['screenshot'] ) ) {
						$img = str_replace( $wp_upload_dir['baseurl'], $wp_upload_dir['basedir'], $_POST['screenshot'] );

						$mime = 'png';
						if( is_callable( 'getimagesize' ) === true ) {
							if( file_exists( $img ) === true ) $img_info = getimagesize( $img );
							if( isset( $img_info['mime'] ) ) {
								$mime = str_replace( 'jpeg', 'jpg', str_replace( 'image/', '', $img_info['mime'] ) );
							}
						}
						@copy( $img, $dst_dir . 'screenshot.' . $mime );
					}
					thk_zip_file_download( $tmp_dir, $_POST['design_name'] . '.zip', true );
				}
				else {
					echo '<div class="error"><p>' . $dst_dir . '</p></div>';
					return false;
				}
			}
			else {
				echo '<div class="error"><p>' . $tmp_dir . '</p></div>';
				return false;
			}
		}
	}

	public function create_css( $dst_dir, $amp = false ) {
		global $luxe, $wp_filesystem;

		$styles = '';
		$css = 'style.css';	// ファイル名
		if( $amp === true ) $css = 'style-amp.css';

		$dst = $dst_dir . $css;

		/***
			適用済みの Design File
		 ***/
		if( isset( $_POST['design_active'] ) ) {
			$com = 1;	// 削除対象のコメント数

			if( isset( $luxe['design_file'] ) ) {
				$design_file = SPATH . DSEP . 'design' . DSEP . $luxe['design_file'] . DSEP . $css;

				if( file_exists( $design_file ) === true ) {
					$styles_tmp = $wp_filesystem->get_contents( $design_file );
					$styles = $this->comment_delete( $styles_tmp, 1 );
				}
			}
		}

		/***
			Child stylesheet
		 ***/
		if( isset( $_POST['design_child'] ) ) {
			$com = 3;		// 削除対象のコメント数（通常: 3、AMP: 2）
			if( $amp === true ) $com = 2;

			$src = SPATH . DSEP . $css;

			if( empty( $styles ) ) {
				if( $this->style_copy( $src, $dst, $com, $amp ) ) return false;
			}
			else {
				$styles_tmp = $wp_filesystem->get_contents( $src );
				$styles_tmp = $this->comment_delete( $styles_tmp, $com );

				if( !empty( $styles_tmp ) ) {
					$styles .= "\n\n" . '/* Child stylesheet */' . "\n" . $styles_tmp;
				}
			}
		}

		$styles = $this->add_first_comment( trim( $styles ), $amp );

		if( $this->filesystem->file_save( $dst, $styles ) === false ) return false;

		return true;
	}

	public function style_copy( $src, $dst, $line, $amp = false ) {
		global $wp_filesystem;

		$save = '';

		// スタイルシートの中身取得
		if( file_exists( $src ) === true ) {
			$save .= $wp_filesystem->get_contents( $src );
		}
		else {
			return false;
		}

		$save = $this->comment_delete( $save, $line );
		if( !empty( $save ) ) $save = '/* Child stylesheet */' . "\n" . $save;
		$save = $this->add_first_comment( $save, $amp );

		if( $this->filesystem->file_save( $dst, $save ) === false ) return false;

		return true;
	}

	public function comment_delete( $contents, $line ) {
		// スタイルシートに書かれている最初のコメントを削除
		$contents = preg_replace( '{/\*.+?\*/}ism', '', $contents, $line );
		$contents = trim( $contents );

		return $contents;
	}

	public function add_first_comment( $contents, $amp = false ) {
		$comment = '';

		if( $amp === true ) {
			$comment = '/* Stylesheet for Luxeritas design file (AMP) */' . "\n";
		}
		else {
			$comment = '/* Stylesheet for Luxeritas design file */' . "\n";
		}

		if( !empty( $contents ) ) {
			$contents = $comment . "\n" . $contents . "\n";
		}
		else {
			$contents = $comment;
		}

		return $contents;
	}
}
