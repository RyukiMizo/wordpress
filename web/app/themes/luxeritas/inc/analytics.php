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

if( class_exists( 'thk_analytics' ) === false ):
class thk_analytics {
	public function __construct() {
	}

	public function analytics( $add_php_file = 'add-analytics.php' ) {
		global $luxe;

		$f = TDEL === SDEL ? TPATH . DSEP : SPATH . DSEP;
		ob_start();
		if( file_exists( $f . $add_php_file ) === true ) {
			require( $f . $add_php_file );
		}
		$analytics = trim( ob_get_clean() );

		if( !empty( $analytics ) ) {
			if( isset( $luxe['amp'] ) ) {
				$amplink  = thk_get_amp_permalink( get_queried_object_id() );
				$amptitle = wp_get_document_title();

				preg_match( '/(UA-[0-9]+?-[0-9]+)/ism', $analytics, $ua );
				// img タグを埋め込んでトラッキングするタイプのアクセス解析は <noscript> 等を外して amp-pixel に置換
				$analytics = preg_replace( '/<img[^>]+?src=([\'|\"][^>]+?[\'|\"])[^>]*?>/ism', '<amp-pixel src=$1></amp-pixel>', $analytics );
				$analytics = thk_amp_not_allowed_tag_replace( $analytics );
				$analytics = thk_amp_tag_replace( $analytics );
				// プロトコルが https じゃない場合は、amp-pixel を width="1" height="1" の amp-img に置換
				$analytics = preg_replace( '/<amp-pixel[^>]+?src=([\'|\"]http\:\/\/[^>]+?[\'|\"])[^>]*?><\/amp-pixel>/ism', '<amp-img src=$1 width="1" height="1" alt=""></amp-img>', $analytics );

				// Google Analytics が記述されていたら amp-analytics に置換
				if( !empty( $ua[1] ) ) {
					$analytics .= <<<AMP_ANALYTICS
<amp-analytics type="googleanalytics" id="analytics1">
<script type="application/json">
{
  "vars": {
    "account": "{$ua[1]}"
  },
  "triggers": {
    "trackPageviewWithAmpdocUrl": {
      "on": "visible",
      "request": "pageview",
      "vars": {
        "title": "{$amptitle}",
        "ampdocUrl": "{$amplink}"
      }
    }
  }
}
</script>
</amp-analytics>
AMP_ANALYTICS;
				}
			}
			$analytics .= "\n";
		}
		return $analytics;
	}
}
endif;
