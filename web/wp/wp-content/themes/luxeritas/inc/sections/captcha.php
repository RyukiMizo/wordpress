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
<p class="control-title"><?php echo __( 'Image authentication type for comments', 'luxeritas' ); ?></p>
<p class="radio">
<input type="radio" value="recaptcha-v3" name="captcha_enable"<?php thk_value_check( 'captcha_enable', 'radio', 'recaptcha-v3' ); ?> />
<?php printf( __( 'Enable Google reCAPTCHA %s', 'luxeritas' ), 'v3' ); ?>
</p>
<p class="radio">
<input type="radio" value="recaptcha" name="captcha_enable"<?php thk_value_check( 'captcha_enable', 'radio', 'recaptcha' ); ?> />
<?php printf( __( 'Enable Google reCAPTCHA %s', 'luxeritas' ), 'v2' ); ?>
</p>
<p class="radio">
<input type="radio" value="securimage" name="captcha_enable"<?php thk_value_check( 'captcha_enable', 'radio', 'securimage' ); ?> />
<?php echo __( 'Enable Securimage PHP CAPTCHA', 'luxeritas' ); ?>
</p>
<p class="radio">
<input type="radio" value="none" name="captcha_enable"<?php thk_value_check( 'captcha_enable', 'radio', 'none' ); ?> />
<?php echo __( 'Do not use image authentication', 'luxeritas' ); ?>
</p>
</li>
</ul>
