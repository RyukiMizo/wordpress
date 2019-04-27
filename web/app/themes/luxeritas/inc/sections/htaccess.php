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

require_once( INC . 'optimize.php' );
global $wp_filesystem;

$filesystem = new thk_filesystem();
if( $filesystem->init_filesystem( site_url() ) === false ) return false;

$file_name = get_locale() === 'ja' ? '/htaccess.txt' : '/htaccess_en.txt';

$htaccess = 'File Not Found' . "\n" . TPATH . $file_name;
if( file_exists( TPATH . $file_name ) ) {
	$htaccess = $wp_filesystem->get_contents( TPATH . $file_name );
	$htaccess = thk_convert( $htaccess );
?>
<p><?php echo __( 'By adding the below lines on your .htaccess, it will enable Gzip compression and browser cache and will boost rendering speed.', 'luxeritas' ); ?></p>
<p><?php echo __( '<span class="bold">Do not overwrite/replace with your .htaccess, but ADD these lines !</span>', 'luxeritas' ); ?></p>
<?php
}
?>
<textarea rows="100" class="htaccess" readonly>
<?php echo esc_textarea( $htaccess ); ?>
</textarea>
