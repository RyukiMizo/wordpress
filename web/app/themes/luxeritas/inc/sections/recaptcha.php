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

?>
<ul>
<li>
<p class="label-title"><?php echo 'Site key'; ?></p>
<input type="text" value="<?php thk_value_check( 'recaptcha_site_key', 'text' ); ?>" name="recaptcha_site_key" />
</li>
<li>
<p class="label-title"><?php echo 'Secret key'; ?></p>
<input type="password" value="<?php thk_value_check( 'recaptcha_secret_key', 'text' ); ?>" name="recaptcha_secret_key" />
<p class="f09em"><?php echo __( '* To use Google reCAPCHA, you will need Site Key and Secrect Key. Please go to <a href="https://www.google.com/recaptcha" target="_blank">Google reCAPTCHA</a> page and get yours.', 'luxeritas' ); ?></p>
<p class="f09em m25-b"><?php echo __( '* It might take some time till you are abel to use the feature after getting your keys.', 'luxeritas' ); ?></p>
</li>
<li>
<p class="control-title"><?php printf( __( 'Setting of %s', 'luxeritas' ), 'v3 ' ); ?></p>
<p class="label-title"><?php echo __( 'Position of reCAPTCHA button and Page Top button', 'luxeritas' ); ?></p>
<select name="recaptcha_v3_ptop">
<option value="none"<?php thk_value_check( 'recaptcha_v3_ptop', 'select', 'none' ); ?>><?php echo __( 'Do nothing', 'luxeritas' ); ?></option>
<option value="left"<?php thk_value_check( 'recaptcha_v3_ptop', 'select', 'left' ); ?>><?php echo __( 'Slide the Page Top button to the left', 'luxeritas' ); ?></option>
<option value="top"<?php thk_value_check( 'recaptcha_v3_ptop', 'select', 'top' ); ?>><?php echo __( 'Slide the Page Top button up', 'luxeritas' ); ?></option>
</select>
<p class="f09em m25-b"><span class="bg-gray"><?php echo __( '* Hiding the reCAPTCHA button (Privacy &amp; Terms) violates the terms.', 'luxeritas' ); ?></span></p>
</li>
<li>
<p class="control-title"><?php printf( __( 'Setting of %s', 'luxeritas' ), 'v2 ' ); ?></p>
<p class="label-title"><?php echo __( 'Theme', 'luxeritas' ); ?></p>
<select name="recaptcha_theme">
<option value="light"<?php thk_value_check( 'recaptcha_theme', 'select', 'light' ); ?>><?php echo __( 'light', 'luxeritas' ); ?></option>
<option value="dark"<?php thk_value_check( 'recaptcha_theme', 'select', 'dark' ); ?>><?php echo __( 'dark', 'luxeritas' ); ?></option>
</select>
</li>
<li>
<p class="label-title"><?php echo __( 'Size', 'luxeritas' ); ?></p>
<select name="recaptcha_size">
<option value="normal"<?php thk_value_check( 'recaptcha_size', 'select', 'normal' ); ?>><?php echo __( 'normal', 'luxeritas' ); ?></option>
<option value="compact"<?php thk_value_check( 'recaptcha_size', 'select', 'compact' ); ?>><?php echo __( 'compact', 'luxeritas' ); ?></option>
</select>
</li>
<li>
<p class="label-title"><?php echo __( 'Type of authentication', 'luxeritas' ); ?></p>
<select name="recaptcha_type">
<option value="image"<?php thk_value_check( 'recaptcha_type', 'select', 'image' ); ?>><?php echo __( 'image', 'luxeritas' ); ?></option>
<option value="audio"<?php thk_value_check( 'recaptcha_type', 'select', 'audio' ); ?>><?php echo __( 'audio', 'luxeritas' ); ?></option>
</select>
</li>
</ul>
