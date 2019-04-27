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
settings_fields( 'phrase' );
?>
<ul>
<li>
<input type="button" class="button secondary add-phrase" value="<?php echo __( 'Add New', 'luxeritas' ); ?>" name="" onclick="thkEditBtn(this)" />
<label class="button secondary"><?php echo __( 'Import', 'luxeritas' ); ?>
<input type="file" id="add-file-phrase" name="add-file-phrase" style="display:none" />
</label>
</li>
</ul>
</form>
<script>
var cname = ''
,   close = ''
,   sep = '';

function thkEditBtn( b ) {
	cname = b.getAttribute('name');
	close = b.getAttribute('data-phrase-close');
	sep = b.getAttribute('data-phrase-sep');
}
function thkDeleteBtn(button) {
	cname = button.getAttribute('name');
}
function thkFileSaveBtn(button) {
	cname = button.getAttribute('name');
}
</script>

<p class="f09em m10-b"><?php printf( __( '* %s names with the same name can not be registered.', 'luxeritas' ), __( 'Label', 'luxeritas' ) ); ?></p>
<?php
$values = array( 'close' => false );
$yes = '<i class="dashicons dashicons-yes"></i>';
$no  = '-';
$fp_mods = get_phrase_list( 'phrase' );

if( !empty( $fp_mods ) ) {
	ksort( $fp_mods );
?>
<table id="thk-phrase-table" class="wp-list-table widefat striped">
<colgroup span="1" style="width:auto;" />
<colgroup span="1" style="width:90px;" />
<colgroup span="1" style="width:auto;" />
<thead>
<tr>
<th scope="col" class="manage-column column-title column-primary al-l"><?php echo __( 'Label', 'luxeritas' ); ?></th>
<th scope="col" class="manage-column al-c"><?php echo __( 'Enclosing', 'luxeritas' ); ?></th>
<th class="al-c"></th>
</tr>
</thead>
<tbody id="the-list">
<?php
	foreach( (array)$fp_mods as $key => $val ) {
		$values = wp_parse_args( @json_decode( $val ), $values );
?>
<tr>
<td class="column-primary">
<?php echo $key; ?>
<p><button type="button" class="toggle-row"></button></p>
</td>
<td data-colname="<?php echo __( 'Enclose', 'luxeritas' ); ?>" class="amp-cbox"><?php echo $values['close'] !== false ? $yes : $no ; ?></td>
<td class="phrase-operation">
<input type="button" class="edit-phrase" value="<?php echo __( 'Edit', 'luxeritas' ); ?>" name="<?php echo $key; ?>" data-phrase-sep="<?php echo "\n<!--" . strlen( $key ) . '-' . md5( $key ) . "-->\n"; ?>" data-phrase-close="<?php echo $values['close']; ?>" onclick="thkEditBtn(this)" />
<input type="button" class="delete-phrase" value="<?php echo __( 'Delete', 'luxeritas' ); ?>" name="<?php echo $key; ?>" onclick="thkDeleteBtn(this)" />
<input type="button" class="file-save-phrase" value="<?php echo __( 'Export', 'luxeritas' ); ?>" name="<?php echo $key; ?>" onclick="thkFileSaveBtn(this)" />
</td>
</tr>
<?php
	}
}
?>
</tbody>
</table>

<?php
add_action( 'admin_footer', function() {
	$popup_nonce = wp_create_nonce( 'phrase_popup' );
?>
<!-- #dialog-form  -->
<div id="thk-code-form" title="<?php echo __( 'Fixed phrase Edit', 'luxeritas' ); ?>">
	<form id="dialog-form">
		<p id="code-regist-err" style="color:red"></p>
		<?php settings_fields( 'phrase' ); ?>
		<table>
			<tr>
				<td><?php echo __( 'Label', 'luxeritas' ), ' ( ', __( 'required', 'luxeritas' ), ' )'; ?></td>
				<td><input type="text" id="thk-code-name" name="code_name" value="" size="30" /></td>
			</tr>
			<tr>
		                <td colspan="2"><?php echo __( 'Fixed phrase', 'luxeritas' ); ?></td>
			</tr>
			<tr>
				<td colspan="2"><textarea id="thk-code-text" name="code_text" rows="12" cols="80"></textarea></td>
			</tr>
			<tr id="thk-code-close-area" style="display:none">
				<td colspan="2"><textarea id="thk-code-text-close" name="code_text_close" rows="6" cols="80"></textarea></td>
			</tr>
			<tr>
		                <td colspan="2"><input type="checkbox" id="thk-code-close" value="1" name="code_close" /> <?php echo __( 'Enclosing', 'luxeritas' ); ?></td>
			</tr>
		</table>
		<input type="hidden" id="thk-code-new" name="code_new" value="1" />
	</form>
</div>

<div style="display:none">
<form id="delete-form">
	<?php settings_fields( 'phrase' ); ?>
	<input type="hidden" id="thk-code-delete" name="code_delete_item" value="" />
	<input type="hidden" name="code_delete" value="1" />
</form>
<form id="file-save-form">
	<?php settings_fields( 'phrase' ); ?>
	<input type="hidden" id="thk-code-save" name="code_save_item" value="" />
	<input type="hidden" name="code_save" value="1" />
</form>
</div>

<script>
jQuery(function($) {
	var fp = '#thk-code-'
	,   fm = $(fp + 'form')
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
				if( $(fp + 'name').val() === '' ) {
					err.text( '<?php echo __( "Required items are not entered", "luxeritas" ); ?>' );
					return false;
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
	$('.file-save-phrase').click( function() {
		var target = document.getElementById("file-save-form");
		$(fp + 'save').val(cname);
		target.method = "post";
		target.submit();
	});

	// import
	$("#add-file-phrase").change(function () {
		$(this).closest("#add-form").submit();
	});

	// 削除ボタンがクリックされたら確認ダイアログを表示
	$('.delete-phrase').click( function() {
		var res = confirm( '<?php echo __( "You are about to delete the selected item. Is it OK?", "luxeritas" ); ?>' );
		var target = document.getElementById("delete-form");
		if( res === true ) {
			$(fp + 'delete').val(cname);
			target.method = "post";
			target.submit();
		}
	});

	// 囲み型の切り替え
	$('#thk-code-close').change( function() {
		if( $('#thk-code-close').prop('checked') === true ) {
			$(fp + 'text').attr( 'rows', 6 );
			$(fp + 'close-area').css( 'display', 'table-row' );
		} else {
			$(fp + 'text').attr( 'rows', 12 );
			$(fp + 'close-area').css( 'display', 'none' );
		}
	});

	// 新規追加 or 編集ボタンがクリックされたらダイアログを表示
	$('.edit-phrase, .add-phrase').click( function() {
		var action = 'edit';
		if( $(this).attr('class').indexOf('add-phrase') != -1 ) {
			action = 'add';
		}

		fm.dialog('open');
		fm.find(fp + 'name').val(cname);
		fm.find(fp + 'text').val('');
		err.text('');

		if( action === 'add' ) {
			fm.find(fp + 'new').val(1);
			fm.find(fp + 'name').prop('readonly', false);
			fm.find(fp + 'text-close').val('');
			fm.find(fp + 'text').attr( 'rows', 12 );
			fm.find(fp + 'close-area').css( 'display', 'none' );
			fm.find(fp + 'close').prop('checked', false)
			$('.ui-button').button('enable');
		}
		else {
			$('.ui-dialog-buttonset .ui-button:first').button('disable');
			fm.find(fp + 'new').val(0);
			fm.find(fp + 'name').prop('readonly', true);
			if( close == 1 ) {
				fm.find(fp + 'close').prop('checked', true);
				fm.find(fp + 'text').attr( 'rows', 6 );
				fm.find(fp + 'close-area').css( 'display', 'table-row' );
			} else {
				fm.find(fp + 'close').prop('checked', false);
				fm.find(fp + 'text').attr( 'rows', 12 );
				fm.find(fp + 'close-area').css( 'display', 'none' );
			}

			jQuery.ajax({
				type: 'POST',
				url: '<?php echo admin_url( "admin-ajax.php" ); ?>',
				data: {action:'thk_phrase_regist', name:cname, close:close, fp_popup_nonce:'<?php echo $popup_nonce; ?>'},
				dataType: 'text',
				async: true,
				cache: false,
				timeout: 10000,
				success: function( response ) {
					strs = response.split(sep);
					$(fp + 'text').val( strs[0] );
					$(fp + 'text-close').val( strs[1] );
					save_enable = true;
				},
				error: function() {
					$(fp + 'text').val( '<?php echo __( "Failed to read.", "luxeritas" ); ?>' );
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
