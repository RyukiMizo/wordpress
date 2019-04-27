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

if( class_exists( 'thk_zip_compress' ) === false ):
class thk_zip_compress {
	public function __construct() {
	}

	/*---------------------------------------------------------------------------
	 * ディレクトリごと ZIP 圧縮
	 *---------------------------------------------------------------------------*/
	public function all_zip( $path, $zip ) {
		if( class_exists( 'ZipArchive' ) === false ) {
			return( __( 'In the PHP environment you are using, ZipArchive could not be handled.', 'luxeritas' ) );
		}
		$z = new ZipArchive();
		$iniset = 'ini' . '_set';
		$iniset( 'max_execution_time', 0 );
		$path = rtrim( str_replace( DSEP, '/', $path ), '/' );
		$zip  = str_replace( DSEP, '/', $zip );

		if( $z->open( $zip, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE ) === true ) {
			$this->add_zip( $z, $path, '' );
			$z->close();
		}
		else {
			return( __( 'Temporary file creation failed.', 'luxeritas' ) . '<br />' . $zip );
		}
		return true;
	}

	/*---------------------------------------------------------------------------
	 * ファイルをストリームに追加 (ディレクトリの場合は再帰的に配下を追加していく)
	 *---------------------------------------------------------------------------*/
	private function add_zip( $z, $path, $zip ) {
		$zip  = ltrim( $zip, '/' );

		if( is_dir( $zip ) === false ) {
			$z->addEmptyDir( $zip );
		}

		foreach( (array)$this->get_file_list( $path ) as $val ) {
			$val = str_replace( DSEP, '/', $val );
			if( is_dir( $path . '/' . $val ) === true ) {
				$this->add_zip( $z, $path . '/' . $val, $zip . '/' . $val );
			}
			else {
				$z->addFile( $path . '/' . $val, $zip . '/' . $val );
			}
		}
	}

	/*---------------------------------------------------------------------------
	 * ディレクトリ内のファイル一覧取得
	 *---------------------------------------------------------------------------*/
	private function get_file_list( $path ) {
		$ret = array();
		if( is_dir( $path ) === true ) {
			foreach( (array)glob( $path . '/' . '*' ) as $val ) {
				$ret[] = basename( $val );
			}
		}
		return $ret;
	}
}
endif;
