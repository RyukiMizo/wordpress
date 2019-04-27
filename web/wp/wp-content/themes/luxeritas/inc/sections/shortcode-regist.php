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
<form enctype="multipart/form-data" id="add-form" method="post" action="">
<?php
settings_fields( 'shortcode' );
?>
<ul>
<li>
<input type="button" class="button secondary add-shortcode" value="<?php echo __( 'Add New', 'luxeritas' ); ?>" name="" onclick="thkEditBtn(this)" />
<label class="button secondary"><?php echo __( 'Import', 'luxeritas' ); ?>
<input type="file" id="add-file-shortcode" name="add-file-shortcode" style="display:none" />
</label>
</li>
</ul>
</form>
<script>
var cname = ''
,   cexnm = ''
,   label = ''
,   php   = ''
,   close = ''
,   activ = ''
,   hide  = '';

function thkEditBtn( b ) {
	cname = b.getAttribute('name');
	cexnm = cname;
	if( cname.indexOf(' ') != -1 ) {
		cexnm = cname.substring( 0, cname.indexOf(' ') );
	}
	label = b.getAttribute('data-shortcode-label');
	php   = b.getAttribute('data-shortcode-php');
	close = b.getAttribute('data-shortcode-close');
	activ = b.getAttribute('data-shortcode-active');
	hide  = b.getAttribute('data-shortcode-hide');
}
function thkDeleteBtn(button) {
	cname = button.getAttribute('name');
}
function thkFileSaveBtn(button) {
	cname = button.getAttribute('name');
}
</script>

<p class="f09em m10-b"><?php printf( __( '* %s names with the same name can not be registered.', 'luxeritas' ), __( 'Shortcode', 'luxeritas' ) ); ?></p>
<p class="f09em m10-b"><?php echo __( '* Import is self responsible, please import only from the trustworthy file.', 'luxeritas' ); ?></p>
<p class="f09em m10-b"><?php echo __( '* Shortcode is stored in shortcodes directory of the child theme.', 'luxeritas' ); ?></p>
<p class="f09em m10-b"><?php echo __( '* Except for Luxeritas special shortcode, you can use it for other themes by porting the contents stored in the shortcodes directory to functions.php.', 'luxeritas' ); ?></p>
<?php

$values  = array( 'label' => '', 'php' => false, 'close' => false, 'hide' => false, 'active' => false );
$yes = '<i class="dashicons dashicons-yes"></i>';
$no  = '-';
$sc_mods = get_phrase_list( 'shortcode' );

foreach( (array)$sc_mods as $key => $val ) {
	$sc_mods[$key] = wp_parse_args( @json_decode( $val ), $values );
}

if( !empty( $sc_mods ) ) {
	asort( $sc_mods );
?>
<table id="thk-phrase-table" class="wp-list-table widefat striped">
<colgroup span="1" style="width:auto;" />
<colgroup span="4" style="width:90px;" />
<colgroup span="1" style="width:auto;" />
<thead>
<tr style="background:white">
<th scope="col" class="manage-column column-title column-primary al-l"><?php echo __( 'Label', 'luxeritas' ); ?> [<?php echo __( 'Shortcode', 'luxeritas' ); ?>]</th>
<th scope="col" class="manage-column al-c"><?php echo __( 'Activate', 'luxeritas' ); ?></th>
<th scope="col" class="manage-column al-c"><?php echo __( 'Hide', 'luxeritas' ); ?></th>
<th scope="col" class="manage-column al-c">PHP</th>
<th scope="col" class="manage-column al-c"><?php echo __( 'Enclose', 'luxeritas' ); ?></th>
<th class="al-c"></th>
</tr>
</thead>
<tbody id="the-list">
<?php
	foreach( (array)$sc_mods as $key => $val ) {
		//$values = wp_parse_args( @json_decode( $val ), $values );
		$key_exa = $key;
		if( strpos( $key, ' ' ) !== false ) {
			$key_exa = substr( $key, 0, strpos( $key, ' ' ) );
		}
?>
<tr>
<td class="column-primary">
<p style="margin:3px"><?php echo $val['label']; ?></p>
<pre class="pre-shortcode">[<?php echo $key_exa; ?>]</pre>
<p><button type="button" class="toggle-row"></button></p>
<div class="shortcode-operation">
<input type="button" class="edit-shortcode" value="<?php echo __( 'Edit', 'luxeritas' ); ?>" data-shortcode-label="<?php echo $val['label']; ?>" data-shortcode-php="<?php echo $val['php']; ?>" data-shortcode-close="<?php echo $val['close']; ?>" data-shortcode-hide="<?php echo $val['hide']; ?>" data-shortcode-active="<?php echo $val['active']; ?>" name="<?php echo $key; ?>" onclick="thkEditBtn(this)" />
<input type="button" class="delete-shortcode" value="<?php echo __( 'Delete', 'luxeritas' ); ?>" name="<?php echo $key; ?>" onclick="thkDeleteBtn(this)" />
<input type="button" class="file-save-shortcode" value="<?php echo __( 'Export', 'luxeritas' ); ?>" name="<?php echo $key; ?>" onclick="thkFileSaveBtn(this)" />
</div>
</td>
<td data-colname="<?php echo __( 'Activate', 'luxeritas' ); ?>" class="amp-cbox"><?php echo $val['active'] !== false ? $yes : $no ; ?></td>
<td data-colname="<?php echo __( 'Hide', 'luxeritas' ); ?>" class="amp-cbox"><?php echo $val['hide']   !== false ? $yes : $no ; ?></td>
<td data-colname="PHP" class="amp-cbox"><?php echo $val['php']    !== false ? $yes : $no ; ?></td>
<td data-colname="<?php echo __( 'Enclose', 'luxeritas' ); ?>" class="amp-cbox"><?php echo $val['close']  !== false ? $yes : $no ; ?></td>
<td class="shortcode-operation">
<input type="button" class="edit-shortcode" value="<?php echo __( 'Edit', 'luxeritas' ); ?>" data-shortcode-label="<?php echo $val['label']; ?>" data-shortcode-php="<?php echo $val['php']; ?>" data-shortcode-close="<?php echo $val['close']; ?>" data-shortcode-hide="<?php echo $val['hide']; ?>" data-shortcode-active="<?php echo $val['active']; ?>" name="<?php echo $key; ?>" onclick="thkEditBtn(this)" />
<input type="button" class="delete-shortcode" value="<?php echo __( 'Delete', 'luxeritas' ); ?>" name="<?php echo $key; ?>" onclick="thkDeleteBtn(this)" />
<input type="button" class="file-save-shortcode" value="<?php echo __( 'Export', 'luxeritas' ); ?>" name="<?php echo $key; ?>" onclick="thkFileSaveBtn(this)" />
</td>
</tr>
<?php
	}
?>
</tbody>
</table>
<?php
}

add_action( 'admin_footer', function() {
	$popup_nonce = wp_create_nonce( 'shortcode_popup' );
?>
<!-- #dialog-form  -->
<div id="thk-code-form" title="<?php echo __( 'Shortcode Edit', 'luxeritas' ); ?>">
	<form id="dialog-form">
		<p id="code-regist-err" style="color:red"></p>
		<?php settings_fields( 'shortcode' ); ?>
		<table>
		<tbody>
			<tr>
				<td><?php echo __( 'Label', 'luxeritas' ); ?></td>
				<td><input type="text" id="thk-code-label" name="code_label" value="" size="30" /></td>
			</tr>
			<tr>
				<td><?php echo __( 'Shortcode', 'luxeritas' ), ' ( ', __( 'required', 'luxeritas' ), ' )'; ?></td>
				<td><input type="text" id="thk-code-name" name="code_name" value="" size="30" readonly /></td>
			</tr>
		</tbody>
		</table>
		<table>
		<tbody>
			<tr>
		                <td colspan="2">Contents</td>
			</tr>
			<tr>
				<td colspan="2">
<pre id="thk-code-func-before" style="display:none;"><code>function( $args, $contents ) {</code></pre>
				<textarea style="margin:0" id="thk-code-text" name="code_text" rows="12" cols="80"></textarea>
<pre id="thk-code-func-after" style="display:none;"><code>	retrun $contents;
}</code></pre>
				</td>
			</tr>
			<tr>
		                <td colspan="2"><input type="checkbox" id="thk-code-php" value="1" name="code_php" /> PHP Code</td>
			</tr>
			<tr>
		                <td colspan="2"><input type="checkbox" id="thk-code-close" value="1" name="code_close" /> <?php echo __( 'Enclose', 'luxeritas' ); ?></td>
			</tr>
			<tr>
				<td colspan="2"><hr style="margin:15px 0" /></td>
			</tr>
			<tr>
		                <td colspan="2"><input type="checkbox" id="thk-code-hide" value="1" name="code_hide" /> <?php echo __( 'Hide', 'luxeritas' ); ?></td>
			</tr>
			<tr>
		                <td colspan="2"><input type="checkbox" id="thk-code-active" value="1" name="code_active" /> <?php echo __( 'Activate', 'luxeritas' ); ?></td>
			</tr>
		</tbody>
		</table>
		<input type="hidden" id="thk-code-new" name="code_new" value="1" />
	</form>
</div>

<div style="display:none">
<form id="delete-form">
	<?php settings_fields( 'shortcode' ); ?>
	<input type="hidden" id="thk-code-delete" name="code_delete_item" value="" />
	<input type="hidden" name="code_delete" value="1" />
</form>
<form id="file-save-form">
	<?php settings_fields( 'shortcode' ); ?>
	<input type="hidden" id="thk-code-save" name="code_save_item" value="" />
	<input type="hidden" name="code_save" value="1" />
</form>
</div>

<script>
jQuery(function($) {
	var sc = '#thk-code-'
	,   fm = $(sc + 'form')
	,   save_enable = false
	,   err = $('#code-regist-err');

	fm.dialog({
		autoOpen: false,
		height: 'auto',
		width: 'auto',
		maxWidth: 800,
		minWidth: 300,
		modal: true,
		buttons: {  // ダイアログに表示するボタンと処理
			"<?php echo __( 'Save', 'luxeritas' ); ?>": function() {
				var target = document.getElementById("dialog-form");

				target.method = "post";
				if( $(sc + 'name').val().indexOf(' ') != -1 ) {
					if( $(sc + 'name').val().match(/^[a-zA-Z_\x7F-\xFF][0-9a-zA-Z_-\x7F-\xFF]*? +.+$/gi ) == null ) {
						err.text( '<?php echo __( "This shortcode name is not available in WordPress", "luxeritas" ); ?>' );
						return false;
					}
				}
				else {
					if( $(sc + 'name').val().match(/^[a-zA-Z_\x7F-\xFF][0-9a-zA-Z_-\x7F-\xFF]*$/gi ) == null ) {
						err.text( '<?php echo __( "This shortcode name is not available in WordPress", "luxeritas" ); ?>' );
						return false;
					}
				}
				target.submit();
				$(this).dialog('close');
			},
			"<?php echo __( 'Cancel', 'luxeritas' ); ?>": function() {
				$(this).dialog('close');
			}
		},
	});

	// export
	$('.file-save-shortcode').click( function() {
		var target = document.getElementById("file-save-form");
		$(sc + 'save').val(cname);
		target.method = "post";
		target.submit();
	});

	// import
	$("#add-file-shortcode").change(function () {
		$(this).closest("#add-form").submit();
	});

	// 削除ボタンがクリックされたら確認ダイアログを表示
	$('.delete-shortcode').click( function() {
		var res = confirm( '<?php echo __( "You are about to delete the selected item. Is it OK?", "luxeritas" ); ?>' );
		var target = document.getElementById("delete-form");
		if( res === true ) {
			$(sc + 'delete').val(cname);
			target.method = "post";
			target.submit();
		}
	});

	// PHP Code の切り替え
	$(sc + 'php').change( function() {
		if( $(sc + 'php').prop('checked') === true ) {
			$(sc + 'func-before').show();
			$(sc + 'func-after').show();
		} else {
			$(sc + 'func-before').hide();
			$(sc + 'func-after').hide();
		}
	});


	// 新規追加 or 編集ボタンがクリックされたらダイアログを表示
	$('.edit-shortcode, .add-shortcode').click( function() {
		var action = 'edit';
		if( $(this).attr('class').indexOf('add-shortcode') != -1 ) {
			action = 'add';
		}

		fm.dialog('open');
		fm.find(sc + 'label').val(label);
		fm.find(sc + 'name').val(cname);
		fm.find(sc + 'text').val('');
		err.text('');

		if( action === 'add' ) {
			fm.find(sc + 'new').val(1);
			fm.find(sc + 'name').prop('readonly', false);
			fm.find(sc + 'php').prop('checked', false);
			fm.find(sc + 'close').prop('checked', false);
			fm.find(sc + 'hide').prop('checked', false);
			fm.find(sc + 'active').prop('checked', true);
			fm.find(sc + 'func-before').hide();
			fm.find(sc + 'func-after').hide();
			$('.ui-button').button('enable');
		}
		else {
			$('.ui-dialog-buttonset .ui-button:first').button('disable');
			fm.find(sc + 'new').val(0);
			fm.find(sc + 'name').prop('readonly', true);
			if( php == 1 ) {
				fm.find(sc + 'php').prop('checked', true);
				fm.find(sc + 'func-before').show();
				fm.find(sc + 'func-after').show();
			} else {
				fm.find(sc + 'php').prop('checked', false);
				fm.find(sc + 'func-before').hide();
				fm.find(sc + 'func-after').hide();
			}
			if( close == 1 ) {
				fm.find(sc + 'close').prop('checked', true);
			} else {
				fm.find(sc + 'close').prop('checked', false);
			}
			if( hide == 1 ) {
				fm.find(sc + 'hide').prop('checked', true);
			} else {
				fm.find(sc + 'hide').prop('checked', false);
			}
			if( activ == 1 ) {
				fm.find(sc + 'active').prop('checked', true);
			} else {
				fm.find(sc + 'active').prop('checked', false);
			}

			jQuery.ajax({
				type: 'POST',
				url: '<?php echo admin_url( "admin-ajax.php" ); ?>',
				data: {action:'thk_shortcode_regist', name:cexnm, php:php, sc_popup_nonce:'<?php echo $popup_nonce; ?>'},
				dataType: 'text',
				async: true,
				cache: false,
				timeout: 10000,
				success: function( response ) {
					$('textarea').val( response );
					save_enable = true;
				},
				error: function() {
					$('textarea').val( '<?php echo __( "Failed to read.", "luxeritas" ); ?>' );
				}
			});
		}
		return false;
	});

	// 値が変更されたら保存ボタン活性化
	$('form').on( "keyup change", function() {
		if( save_enable === true ) {
			$('.ui-button').button('enable');
		}
	});

	// オーバーレイがクリックされたらダイアログを閉じる
	$(document).on( 'click', '.ui-widget-overlay', function() {
		fm.dialog('close');
		setTimeout( function(){ $('iframe').eq(0).focus(); }, 0 );
		setTimeout( function(){ $('textarea').eq(0).focus(); }, 0 );
	}); 
});

// タブの入力ができるようにする
var textareas = document.getElementsByTagName('textarea');
var count = textareas.length;
for( var i = 0; i < count; i++ ) {
	textareas[i].onkeydown = function(e){
		if( e.keyCode === 9 || e.which === 9 ) {
			e.preventDefault();
			var s = this.selectionStart;
			this.value = this.value.substring( 0, this.selectionStart ) + "\t" + this.value.substring( this.selectionEnd );
			this.selectionEnd = s + 1;
		}
	}
}
</script>
<?php
});
