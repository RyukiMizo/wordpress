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

settings_fields( 'phrase_sample' );

$fp_mods = get_phrase_list( 'phrase', false );
?>
<ul>
<li>
<p class="control-title">HTML Tags</p>
<p class="checkbox">
<?php $phrase_name = __( 'Quote', 'luxeritas' ); ?>
<input type="checkbox" value="" name="phrase_blockquote_sample"<?php echo isset( $fp_mods[$phrase_name] ) ? ' checked disabled' : ''; ?> />
<?php echo $phrase_name; ?> ( blockquote )
</p>
<p class="checkbox">
<?php $phrase_name = __( 'Preformatted text', 'luxeritas' ); ?>
<input type="checkbox" value="" name="phrase_pre_sample"<?php echo isset( $fp_mods[$phrase_name] ) ? ' checked disabled' : ''; ?> />
<?php echo $phrase_name; ?> ( pre )
</p>
<p class="checkbox">
<?php $phrase_name = __( 'Bulleted list', 'luxeritas' ); ?>
<input type="checkbox" value="" name="phrase_ul_sample"<?php echo isset( $fp_mods[$phrase_name] ) ? ' checked disabled' : ''; ?> />
<?php echo $phrase_name; ?> ( ul )
</p>
<p class="checkbox">
<?php $phrase_name = __( 'Numbered list', 'luxeritas' ); ?>
<input type="checkbox" value="" name="phrase_ol_sample"<?php echo isset( $fp_mods[$phrase_name] ) ? ' checked disabled' : ''; ?> />
<?php echo $phrase_name; ?> ( ol )
</p>
<p class="checkbox">
<?php $phrase_name = __( 'Heading 2', 'luxeritas' ); ?>
<input type="checkbox" value="" name="phrase_h2_sample"<?php echo isset( $fp_mods[$phrase_name] ) ? ' checked disabled' : ''; ?> />
<?php echo $phrase_name; ?> ( h2 )
</p>
<p class="checkbox">
<?php $phrase_name = __( 'Heading 3', 'luxeritas' ); ?>
<input type="checkbox" value="" name="phrase_h3_sample"<?php echo isset( $fp_mods[$phrase_name] ) ? ' checked disabled' : ''; ?> />
<?php echo $phrase_name; ?> ( h3 )
</p>
<p class="checkbox">
<?php $phrase_name = __( 'Heading 4', 'luxeritas' ); ?>
<input type="checkbox" value="" name="phrase_h4_sample"<?php echo isset( $fp_mods[$phrase_name] ) ? ' checked disabled' : ''; ?> />
<?php echo $phrase_name; ?> ( h4 )
</p>

<p class="control-title"><?php echo __( 'Others', 'luxeritas' ); ?></p>
<p class="checkbox">
<?php $phrase_name = 'Google Adsense'; ?>
<input type="checkbox" value="" name="phrase_adsense_sample"<?php echo isset( $fp_mods[$phrase_name] ) ? ' checked disabled' : ''; ?> />
<?php echo $phrase_name; ?> ( <?php echo __( 'Please edit contents after registration.', 'luxeritas' ); ?> )
</p>
</li>
</ul>
