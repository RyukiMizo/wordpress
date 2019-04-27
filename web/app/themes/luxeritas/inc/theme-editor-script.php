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


add_action( 'admin_head', function() {
	$codem_mode = '';
	if( isset( $_GET['active'] ) ) {
		if( $_GET['active'] === 'edit_script' ) {
			$codem_mode = 'javascript';
		}
		elseif( $_GET['active'] === 'edit_functions' || $_GET['active'] === 'edit_header' || $_GET['active'] === 'edit_footer' ) {
			$codem_mode = 'php';
		}
		else {
			$codem_mode = 'css';
		}
	}
	else {
		$codem_mode = 'css';
	}
?>
<script>
/*
jQuery.ajax({
	success: function(){
		var editor = document.getElementById('newcontent');
		var uiOptions = {
			imagePath: '<?php echo TURI; ?>/images/codemirror',
			buttons : ['save','undo','redo','jump'],
			searchMode: 'inline',
			saveCallback : function(){ jQuery('#luxe-customize').submit(); }
		}
		var codeMirrorOptions = {
			mode: '<?php echo $codem_mode; ?>',
			lineNumbers: true,
			indentUnit: 8,
			tabSize: 8,
			enterMode: 'keep',
			lineWrapping: true,
			onChange: function(){
				editor.save();
			}
		}
		new CodeMirrorUI(editor,uiOptions,codeMirrorOptions);

		jQuery(document).ready(function($) {
			$(':button[value="Find"]').addClass('search-button');
			$(':button[value="Find"]').attr({
				title: '<?php echo __( 'Search', 'luxeritas' ); ?>',
				type: 'button'
			});
			$(':button[value="Replace"]').addClass('replace-button');
			$(':button[value="Replace"]').attr({
				title: '<?php echo __( 'Replace', 'luxeritas' ); ?>',
				type: 'button'
			});
			$('a.save').attr({title: '<?php echo __( 'Svae', 'luxeritas' ); ?>'});
			$('a.undo').attr({title: '<?php echo __( 'Undo', 'luxeritas' ); ?>'});
			$('a.redo').attr({title: '<?php echo __( 'Redo', 'luxeritas' ); ?>'});
			$('a.jump').attr({title: '<?php echo __( 'Jump', 'luxeritas' ); ?>'});
			$(function(){
				$('label[title="Regular Expressions"]').each(function(){
					var txt = $(this).html();
					$(this).html(
						txt.replace(/RegEx/,"<?php echo __( 'RegEx', 'luxeritas' ); ?>")
					);
				});
				$('label[title="Replace All"]').each(function(){
					var txt = $(this).html();
					$(this).html(
						txt.replace(/All/,"<?php echo __( 'Replace All', 'luxeritas' ); ?>")
					);
				});
			});
		});
	}
});
*/

</script>
<?php
});
