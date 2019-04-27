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

if( count( get_included_files() ) <= 1 ) {
	$protocol = $_SERVER['SERVER_PROTOCOL'];
	if( ! in_array( $protocol, array( 'HTTP/1.1', 'HTTP/2', 'HTTP/2.0' ) ) ) {
		$protocol = 'HTTP/1.0';
	}
	header( "$protocol 200 OK" );
	define( 'DSEP', DIRECTORY_SEPARATOR );
	require( dirname( __FILE__ ) . DSEP . 'inc' . DSEP . 'index.php' );
	exit;
}

global $luxe;
get_header();
?>
<div id="section"<?php echo $luxe['content_discrete'] === 'indiscrete' ? ' class="grid"' : ''; ?>>
<?php
get_template_part( 'loop' );
?>
</div><!--/#section-->
</main>
<?php thk_call_sidebar(); ?>
</div><!--/#primary-->
<?php echo apply_filters( 'thk_footer', '' ); ?>
