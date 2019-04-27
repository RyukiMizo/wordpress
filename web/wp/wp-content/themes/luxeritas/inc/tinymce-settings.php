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

wp_enqueue_style( 'wp-color-picker' );
wp_enqueue_script( 'wp-color-picker' );
/*
add_filter( 'mce_external_plugins', function( $plugin_array ) {
	$plugin_array[ 'thk-mce-settings-button' ] = TDEL . '/js/' . 'thk-dummy.js';
	return $plugin_array;
});

add_filter( 'mce_buttons', function( $buttons ) {
	array_push( $buttons, 'thk-mce-settings-button' );
	return $buttons;
}, 99 );
*/
add_filter( 'admin_print_footer_scripts', function() {
//add_action( 'after_wp_tiny_mce', function() {
	$popup_nonce = wp_create_nonce( 'mce_popup' );
?>
<!-- #dialog-form  -->
<div id="thk-mce-settings-form" title="Luxeritas Visual Editor Settings">
<form id="thk-mce-settings">
<p style="white-space:nowrap"><?php echo __( '* These settings will be activated after reloading the screen.', 'luxeritas' ); ?></p>
<table>
<tbody>
<tr>
<td><?php echo __( 'Max width', 'luxeritas' ); ?>: </td>
<td colspan="2" style="white-space:nowrap"><input type="number" min="0" id="mce_max_width" name="mce_max_width" value="<?php thk_value_check( 'mce_max_width', 'number' ); ?>" style="width:100%;max-width:60px" /> px ( <?php echo __( 'When input is 0, 100%', 'luxeritas' ); ?> )</td>
</tr>
<tr>
<td><?php echo __( 'Text color', 'luxeritas' ); ?>: </td>
<td colspan="2"><input class="thk-color-picker" type="text" id="mce_color" name="mce_color" value="<?php thk_value_check( 'mce_color', 'text' ); ?>" /></td>
</tr>
<tr>
<td><?php echo __( 'Background color', 'luxeritas' ); ?>: </td>
<td colspan="2"><input class="thk-color-picker" type="text" id="mce_bg_color" name="mce_bg_color" value="<?php thk_value_check( 'mce_bg_color', 'text' ); ?>" /></td>
</tr>
<tr>
<td class="vtop"><?php echo __( 'Behavior of enter key', 'luxeritas' ); ?>: </td>
<td class="vtop p0-r" style="width:20px"><input type="radio" value="paragraph" name="mce_enter_key"<?php thk_value_check( 'mce_enter_key', 'radio', 'paragraph' ); ?> /></td>
<td class="vtop p0">
<table class="enter_desc">
<tbody>
<tr>
<td class="p5-r">Enter</td><td> = <?php echo __( 'Paragraph', 'luxeritas' ); ?></td>
</tr>
<tr>
<td class="p5-r">Shift + Enter</td><td> = <?php echo __( 'Newline', 'luxeritas' ); ?></td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td>&nbsp;</td>
<td class="vtop p0-r" style="width:20px"><input type="radio" value="linefeed" name="mce_enter_key"<?php thk_value_check( 'mce_enter_key', 'radio', 'linefeed' ); ?> /></td>
<td class="vtop p0">
<table class="enter_desc">
<tbody>
<tr>
<td class="p5-r">Enter</td><td> = <?php echo __( 'Newline', 'luxeritas' ); ?></td>
</tr>
<tr>
<td class="p5-r">Shift + Enter</td><td class="p0"> = <?php echo __( 'Paragraph', 'luxeritas' ); ?></td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td colspan="2"><input type="checkbox" value="" id="mce_menubar" name="mce_menubar"<?php thk_value_check( 'mce_menubar', 'checkbox' ); ?> /> <?php echo __( 'Show Menu bar', 'luxeritas' ); ?></td>
</tr>
</tbody>
</table>
<p id="mce_reload_check"><input type="checkbox" value="" id="mce_reload" name="mce_reload"<?php thk_value_check( 'mce_reload', 'checkbox' ); ?> /> <?php echo __( 'Auto reload after saving', 'luxeritas' ); ?></p>
</form>
</div>

<script>
<?php
if( get_user_option( 'rich_editing' ) === 'true' ) {
?>
try {
jQuery(function($) {
	var mcefm  = $('#thk-mce-settings-form');
	(function($) {
		if( typeof tinymce !== 'undefined' ) {
			tinymce.PluginManager.add( 'thk-mce-settings-button', function( editor, url ) {
				editor.addButton( "thk-mce-settings-button", {
					tooltip: "Luxeritas Visual Editor Settings",
					onclick: function() {
						mcefm.dialog('open').dialog("open");
					}
				});
			});
		}
	})(jQuery);

	mcefm.dialog({
		autoOpen: false,
		height: 'auto',
		width: 'auto',
		maxWidth: 640,
		minWidth: 320,
		modal: true,
		buttons: {  // ダイアログに表示するボタンと処理
			"<?php echo __( 'Save', 'luxeritas' ); ?>": function() {
				jQuery.ajax({
					type: 'POST',
					url: '<?php echo admin_url( "admin-ajax.php" ); ?>',
					data: {
						action:'thk_mce_settings',
						mce_max_width: $('#mce_max_width').val(),
						mce_bg_color: $('#mce_bg_color').val(),
						mce_color: $('#mce_color').val(),
						mce_enter_key: $('input[name=mce_enter_key]:checked').val(),
						mce_menubar: $('#mce_menubar').prop('checked'),
						mce_popup_nonce:'<?php echo $popup_nonce; ?>'
					},
					dataType: 'text',
					async: true,
					cache: false,
					timeout: 10000,
					success: function() {
						if( $('#mce_reload').prop('checked') === true ) {
							location.reload();
						}
					},
					error: function() {
					}
				});
				$(this).dialog('close');
				return true;
			},
			"<?php echo __( 'Cancel', 'luxeritas' ); ?>": function() {
				$(this).dialog('close');
				// ダイアログを閉じたらフォーカスを移す
				setTimeout( function(){ $('iframe').eq(0).focus(); }, 0 );
				setTimeout( function(){ $('textarea').eq(0).focus(); }, 0 );
			},
		},
	});

	// オーバーレイがクリックされたらダイアログを閉じる
	$(document).on( 'click', '.ui-widget-overlay', function() {
		mcefm.dialog('close');
		setTimeout( function(){ $('iframe').eq(0).focus(); }, 0 );
		setTimeout( function(){ $('textarea').eq(0).focus(); }, 0 );
	}); 

	$('.thk-color-picker').wpColorPicker();
	$('.wp-color-result').on('click', function() {
		$("#save").prop("disabled", false);
	});
});
} catch (e) {
	console.error("tinymce.settings.error: " + e.message)
}
<?php
}
?>
</script>
<?php
}, 99 );
