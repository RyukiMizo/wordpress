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
<p><?php echo __( 'Web site start year', 'luxeritas' ); ?>: &nbsp;
<input id="copyright_since" type="number" value="<?php thk_value_check( 'copyright_since', 'number' ); ?>" name="copyright_since" /></p>
</li>
<li>
<p><?php echo __( 'Author name', 'luxeritas' ); ?>: &nbsp;
<input type="text" value="<?php thk_value_check( 'copyright_auth', 'text' ); ?>" name="copyright_auth" /></p>
</li>
<li>
<p><?php echo __( 'Format', 'luxeritas' ); ?>:</p>
<p class="radio">
<input type="radio" value="ccsra" name="copyright_type"<?php thk_value_check( 'copyright_type', 'radio', 'ccsra' ); ?> />
Copyright &copy; <span class="since"><?php thk_value_check( 'copyright_since', 'text' ); ?></span>-<?php echo date('Y'); ?> <span itemprop="copyrightHolder name"><?php thk_value_check( 'copyright_auth', 'text' ); ?></span> All Rights Reserved.
</p>
<p class="radio">
<input type="radio" value="ccsa" name="copyright_type"<?php thk_value_check( 'copyright_type', 'radio', 'ccsa' ); ?> />
Copyright &copy; <span class="since"><?php thk_value_check( 'copyright_since', 'text' ); ?></span> <span itemprop="copyrightHolder name"><?php thk_value_check( 'copyright_auth', 'text' ); ?></span> All Rights Reserved.
</p>
<p class="radio">
<input type="radio" value="cca" name="copyright_type"<?php thk_value_check( 'copyright_type', 'radio', 'cca' ); ?> />
Copyright &copy; <span itemprop="copyrightHolder name"><?php thk_value_check( 'copyright_auth', 'text' ); ?></span> All Rights Reserved.
</p>
<p class="radio">
<input type="radio" value="ccsr" name="copyright_type"<?php thk_value_check( 'copyright_type', 'radio', 'ccsr' ); ?> />
Copyright &copy; <span class="since"><?php thk_value_check( 'copyright_since', 'text' ); ?></span>-<?php echo date('Y'); ?> <span itemprop="copyrightHolder name"><?php thk_value_check( 'copyright_auth', 'text' ); ?></span>
</p>
<p class="radio">
<input type="radio" value="ccs" name="copyright_type"<?php thk_value_check( 'copyright_type', 'radio', 'ccs' ); ?> />
Copyright &copy; <span class="since"><?php thk_value_check( 'copyright_since', 'text' ); ?></span> <span itemprop="copyrightHolder name"><?php thk_value_check( 'copyright_auth', 'text' ); ?></span>
</p>
<p class="radio">
<input type="radio" value="cc" name="copyright_type"<?php thk_value_check( 'copyright_type', 'radio', 'cc' ); ?> />
Copyright &copy; <span itemprop="copyrightHolder name"><?php thk_value_check( 'copyright_auth', 'text' ); ?></span>
</p>
<p class="radio">
<input type="radio" value="csr" name="copyright_type"<?php thk_value_check( 'copyright_type', 'radio', 'csr' ); ?> />
&copy; <span class="since"><?php thk_value_check( 'copyright_since', 'text' ); ?></span>-<?php echo date('Y'); ?> <span itemprop="copyrightHolder name"><?php thk_value_check( 'copyright_auth', 'text' ); ?></span>
</p>
<p class="radio">
<input type="radio" value="cs" name="copyright_type"<?php thk_value_check( 'copyright_type', 'radio', 'cs' ); ?> />
&copy; <span class="since"><?php thk_value_check( 'copyright_since', 'text' ); ?></span> <span itemprop="copyrightHolder name"><?php thk_value_check( 'copyright_auth', 'text' ); ?></span>
</p>
<p class="radio">
<input type="radio" value="c" name="copyright_type"<?php thk_value_check( 'copyright_type', 'radio', 'c' ); ?> />
&copy; <span itemprop="copyrightHolder name"><?php thk_value_check( 'copyright_auth', 'text' ); ?></span>
</p>
<p class="radio">
<input type="radio" value="free" name="copyright_type"<?php thk_value_check( 'copyright_type', 'radio', 'free' ); ?> />
<?php echo __( 'Free Format', 'luxeritas' ); ?>
</p>
</li>
<li>
<p><?php echo __( 'Free Format', 'luxeritas' ); ?>:</p>
<p><textarea name="copyright_text" cols="60" rows="3"><?php thk_value_check( 'copyright_text', 'textarea' ); ?></textarea></p>
</li>
</ul>
<script>
jQuery(function($){
	$('textarea[name="copyright_text"]').focusin(function() {
		$('input[value="free"]').prop('checked', true);
	});
	$('#copyright_since').change(function() {
		$('.since').text($('#copyright_since').val());
	});
});
</script>
