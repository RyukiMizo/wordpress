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
<div id="template">
<div id="edit-file-name">
<span class="save-button"><span class="dashicons dashicons-marker"></span>&nbsp;<?php echo __( 'Save', 'luxeritas' ); ?></span>
<?php
if( version_compare( $GLOBALS['wp_version'], '4.9', '>=' ) === true ) {
?>
<span class="codemirror-settings-button"><span class="dashicons dashicons-admin-generic"></span>&nbsp;<?php echo __( 'Settings', 'luxeritas' ); ?></span>
<span class="commands-button"><span class="dashicons dashicons-lightbulb"></span>&nbsp;<?php echo __( 'Commands', 'luxeritas' ); ?></span>
<?php
}
$edit_file_name = esc_textarea( thk_convert( str_replace( '/', DSEP, str_replace( dirname( WP_CONTENT_DIR ), '', $file ) ) ) );
if( empty( $edit_file_name ) ) $edit_file_name = 'NULL';
?>
<span class="edit-file-name"><?php echo __( 'File editing', 'luxeritas' ); ?> :&nbsp;&nbsp;<?php echo $edit_file_name; ?></span>

<div id="codemirror-settings" style="display:none">
<table>
<thead>
<tr>
<th style="position:relative;text-align:left;padding:0 0 5px 5px"><?php echo __( 'Settings', 'luxeritas' ); ?>
<span class="dashicons dashicons-no-alt close"></span>
</th>
</tr>
</thead>
<tbody>
<tr><td style="position:relative">
<p>
<input type="checkbox" value="" name="cm_line_numbers"<?php thk_value_check( 'cm_line_numbers', 'checkbox' ); ?> />
<?php echo __( 'Show line numbers', 'luxeritas' ); ?>
</p>
<p>
<input type="checkbox" value="" name="cm_autocomplete"<?php thk_value_check( 'cm_autocomplete', 'checkbox' ); ?> />
<?php echo __( 'Autocomplete', 'luxeritas' ); ?>
<p>
<input type="checkbox" value="" name="cm_auto_indent"<?php thk_value_check( 'cm_auto_indent', 'checkbox' ); ?> />
<?php echo __( 'Auto indent', 'luxeritas' ); ?>
</p>
<p>
<input type="checkbox" value="" name="cm_close_brackets"<?php thk_value_check( 'cm_close_brackets', 'checkbox' ); ?> />
<?php echo __( 'Auto close brackets', 'luxeritas' ); ?>
</p>
<p>
<input type="checkbox" value="" name="cm_lint"<?php thk_value_check( 'cm_lint', 'checkbox' ); ?> />
<?php echo __( 'CSS / Javascript grammar check', 'luxeritas' ); ?>
<p>
<p>
<input type="checkbox" value="" name="cm_active_line"<?php thk_value_check( 'cm_active_line', 'checkbox' ); ?> />
<?php echo __( 'Change background color of active line', 'luxeritas' ); ?>
</p>
<p>
<input type="checkbox" value="" name="cm_line_wrapping"<?php thk_value_check( 'cm_line_wrapping', 'checkbox' ); ?> />
<?php echo __( 'Wrap at the right end', 'luxeritas' ); ?>
</p>
<p class="radio"><?php echo __( 'Indentation character', 'luxeritas' ); ?></p>
<p class="radio">
<input type="radio" value="tabs" name="cm_indent_with_tabs"<?php thk_value_check( 'cm_indent_with_tabs', 'radio', 'tabs' ); ?> />
<span style="margin-right:10px"><?php echo __( 'Tabs', 'luxeritas' ); ?></span>
<input type="radio" value="spaces" name="cm_indent_with_tabs"<?php thk_value_check( 'cm_indent_with_tabs', 'radio', 'spaces' ); ?> />
<?php echo __( 'Spaces', 'luxeritas' ); ?>
</p>
<p>
<input style="width:50px" max="9" min="0" type="number" value="<?php thk_value_check( 'cm_tab_size', 'number' ); ?>" name="cm_tab_size" />
<?php echo __( 'Indent and tab character width', 'luxeritas' ); ?>
<span class="save-button" style="position:absolute;right:10px"><span class="dashicons dashicons-yes"></span>&nbsp;<?php echo __( 'Save settings', 'luxeritas' ); ?></span>
</p>
</td></tr>
</tbody>
</table>
</div><!-- /#codemirror-settings -->

<div id="commands" style="display:none">
<table>
<thead>
<tr><th colspan="2" style="position:relative;text-align:left;padding:0 0 5px 5px"><?php echo __( 'Commands list', 'luxeritas' ); ?>
<span class="dashicons dashicons-no-alt close"></span>
</th>
</tr>
</thead>
<tbody>
<tr><td>Ctrl + Z</td><td><?php echo __( 'Undo', 'luxeritas' ); ?></td></tr>
<tr><td>Ctrl + Y</td><td><?php echo __( 'Redo', 'luxeritas' ); ?></td></tr>
<tr><td>Ctrl + Alt + F</td><td><?php echo __( 'Search', 'luxeritas' ); ?></td></tr>
<tr><td>Ctrl + Alt + D</td><td><?php echo __( 'Replace', 'luxeritas' ); ?></td></tr>
<tr><td>Ctrl + Alt + /</td><td><?php echo __( 'Toggle comment line', 'luxeritas' ); ?></td></tr>
</tbody>
</table>
</div><!-- /#commands -->
</div><!-- /#edit-file-name -->
<textarea cols="70" rows="30" name="newcontent" id="newcontent" class="luxe-edit" aria-describedby="newcontent-description">
<?php echo $content; ?>
</textarea>

<!-- dummy script -->
<div style="display: none">
<div class="editor-notices"></div>
<script type="text/html" id="tmpl-wp-file-editor-notice">
<div class="notice inline notice-{{ data.type || 'info' }} {{ data.alt ? 'notice-alt' : '' }} {{ data.dismissible ? 'is-dismissible' : '' }} {{ data.classes || '' }}">
<# if ( 'php_error' === data.code ) { #>
{{ data.file }} {{ data.line }}{{ data.message }}
<# } else if ( 'file_not_writable' === data.code ) { #>
<# } else { #>
{{ data.message || data.code }}
<# if ( 'lint_errors' === data.code ) { #>
<# var elementId = 'el-' + String( Math.random() ); #>
<input id="{{ elementId }}"  type="checkbox">
<label for="{{ elementId }}"></label>
<# } #>
<# } #>
<# if ( data.dismissible ) { #>
<button type="button" class="notice-dismiss"><span class="screen-reader-text"></span></button>
<# } #>
</div>
</script>
</div>
<!-- /dummy script -->

</div><!-- /#template -->
<script>
jQuery(function($) {
	$('.save-button').click( function() {
		$('#luxe-customize').submit();
	});

	$('.codemirror-settings-button').click( function() {
		$('#codemirror-settings').toggle( 400, 'linear' );
		$('#commands').css( 'display', 'none' );
	});
	$('.commands-button').click( function() {
		$('#commands').toggle( 400, 'linear' );
		$('#codemirror-settings').css( 'display', 'none' );
	});
	$('.close').click( function() {
		$('#codemirror-settings').slideUp( 400, 'linear' );
		$('#commands').slideUp( 400, 'linear' );
	});
});
</script>
