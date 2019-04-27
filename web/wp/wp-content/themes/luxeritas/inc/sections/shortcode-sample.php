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

settings_fields( 'shortcode_sample' );

$sc_mods = get_phrase_list( 'shortcode', false, true );
?>
<ul>
<li>
<p class="control-title"><?php echo __( 'Tutorial', 'luxeritas' ); ?></p>
<p class="checkbox">
<input type="checkbox" value="" name="shortcode_simple_line_output_sample"<?php echo isset( $sc_mods['simple_line_output'] ) ? ' checked disabled' : ''; ?> />
<?php echo '1. ' . __( 'Sample that simply displays a character string', 'luxeritas' ); ?>
</p>
<p class="checkbox">
<input type="checkbox" value="" name="shortcode_enclosing_shortcode_sample"<?php echo isset( $sc_mods['enclosing_shortcode'] ) ? ' checked disabled' : ''; ?> />
<?php echo '2. ' . __( 'Sample using enclosing shortcode', 'luxeritas' ); ?>
</p>
<p class="checkbox">
<input type="checkbox" value="" name="shortcode_shortcode_param_sample"<?php echo isset( $sc_mods['shortcode_param'] ) ? ' checked disabled' : ''; ?> />
<?php echo '3. ' . __( 'Sample to display argument given to shortcode', 'luxeritas' ); ?>
</p>

<p class="control-title"><?php echo __( 'Others', 'luxeritas' ); ?></p>
<p class="checkbox">
<input type="checkbox" value="" name="shortcode_ads_sample"<?php echo isset( $sc_mods['ads'] ) ? ' checked disabled' : ''; ?> />
Google Adsense ( <?php echo __( 'Please edit contents after registration.', 'luxeritas' ); ?> )<br />
<span class="f09em" style="margin-left:25px"><?php echo __( '* This adsense shortcode is hidden on the preview screen.', 'luxeritas' ); ?></span>
</p>
</li>
</li>
</ul>
