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


$curent = wp_get_theme();
if( TDEL !== SDEL ) $parent = wp_get_theme( $curent->get('Template') );
?>
<fieldset>
<div class="luxe-info">
<div class="screenshots">
<?php
if( TDEL !== SDEL && file_exists( SPATH . '/screenshot.jpg' ) === true ) {
?>
<div class="screenshot"><img src="<?php echo SURI . '/screenshot.jpg'; ?>" alt="" /></div>
<?php
}
elseif( TDEL !== SDEL && file_exists( SPATH . '/screenshot.png' ) === true ) {
?>
<div class="screenshot"><img src="<?php echo SURI . '/screenshot.png'; ?>" alt="" /></div>
<?php
}
elseif( TDEL === SDEL && file_exists( TPATH . '/screenshot.jpg' ) === true ) {
?>
<div class="screenshot"><img src="<?php echo TURI . '/screenshot.jpg'; ?>" alt="" /></div>
<?php
}
elseif( TDEL === SDEL && file_exists( TPATH . '/screenshot.png' ) === true ) {
?>
<div class="screenshot"><img src="<?php echo TURI . '/screenshot.png'; ?>" alt="" /></div>
<?php
}
else {
?>
<div class="screenshot blank"></div>
<?php
}
?>
</div>

<div class="info">
<span class="current-label"><?php echo __( 'Current Theme', 'luxeritas' ); ?></span>
<legend><h2 class="name"><?php echo $curent->get('Name'); ?><span class="version"><?php printf( __( 'Version: %s', 'luxeritas' ), $curent->get('Version') ); ?></span></h2>

<?php if( TDEL !== SDEL ) { ?>
<p class="parent-theme"><?php printf( __( 'This is a child theme of %s.', 'luxeritas' ), '<strong>' . $parent->get('Name') . '</strong>' ); ?></p>

<span class="current-label"><?php echo __( 'Parent Theme', 'luxeritas' ); ?></span>
<legend><h2 class="name"><?php echo $parent->get('Name'); ?><span class="version"><?php printf( __( 'Version: %s', 'luxeritas' ), $parent->get('Version') ); ?></span></h2>
<?php } ?>

<h3 class="author">
<?php printf( __( 'By %s', 'luxeritas' ), '<a href="' . $curent->get('AuthorURI') . '" target="_blank">' . $curent->get('Author') . '</a>' ); ?>
</h3>
<p class="description"><?php echo $curent->get('Description'); ?></p>
<p class="tags"><span><?php echo __( 'Tags', 'luxeritas' ); ?></span>: <?php foreach( $curent->get('Tags') as $val ) echo $val . ', '; ?></p>

</div>
</div>
