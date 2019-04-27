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

$t_buttons_array_1 = thk_txt_buttons_1();
$t_buttons_array_d = get_theme_admin_mod( 'teditor_buttons_d' );

foreach( (array)$t_buttons_array_d as $key => $val ) {
	if( isset( $t_buttons_array_1[$key] ) ) {
		$t_buttons_array_d[$key] = $t_buttons_array_1[$key];
	}
}

$editor_settings_nonce = wp_create_nonce( 'settings_nonce' );
?>
<style>
ul[id^=t_buttons_] {
	min-height: 40px;
	padding: 10px 10px 5px 10px;
	letter-spacing: -.4em;
	background: #fff;
	border: 1px solid #ddd;
}
ul[id^=t_buttons_] li {
	display: inline-block;
	margin: 0;
	padding: 0;
	letter-spacing: normal;
	vertical-align: middle;
	background: #fff;
	border: 1px solid transparent;
}
ul[id^=t_buttons_] .cover {
	position: relative;
	display: inline-block;
}
ul[id^=t_buttons_] .cover::after {
	display: block;
	content: "";
	position: absolute;
	top: 0;
	left: 0;
	height: 100%;
	width: 100%;
}
ul#t_buttons_1 li {
	cursor: move;
}
ul#t_buttons_1 input[type=button] {
	cursor: move;
}
ul#t_buttons_1 li.sortable-chosen {
	color: #fff;
	background: #f6b280;
	cursor: move;
}
ul#t_buttons_1 li.sortable-ghost, ul#t_buttons_1 li.sortable-ghost i, ul#t_buttons_1 li.sortable-ghost i::before {
	color: transparent;
	background: transparent;
}
ul#t_buttons_d li.sortable-chosen,
ul#t_buttons_d input[type=button] {
	cursor: default;
}
ul#t_buttons_d input[type=button]::after {
	cursor: default;
}
body li.sortable-ghost {
	border: 1px solid #ddd;
}
.remove, ul[id^=t_buttons_] .dashicons-before:before {
	color: #666;
	vertical-align: middle;
	font-size: 26px;
	margin: 0;
	cursor: pointer;
}
.remove {
	margin: 5px 10px 0 -5px;
}
#t_editor_save_msg {
	position: absolute;
	bottom: -10px;
	left: -3px;
	display: none;
	margin-left: 5px;
	padding: 5px 20px 5px 20px;
	color: #fff;
	background: #8ecdf0;
	border-radius: 99px 0 99px 0;
	white-space: nowrap;
	z-index: 10;
}
</style>

<p><?php echo __( '* You can set display / non-display of button with drag &amp; drop. ( Sort is not possible )', 'luxeritas' ); ?></p>
<ul id="t_buttons_1" class="quicktags-toolbar">
<?php
foreach( $t_buttons_array_1 as $key => $val ) {
	if( $val !== true ) {
?>
<li data-button="<?php echo $key; ?>"<?php if( isset( $t_buttons_array_d[$key] ) ) echo ' style="display:none"' ?>><?php echo $val; ?></li>
<?php
	}
}
?>
</ul>
<p style="margin-bottom:0;margin-left:5px"><span class="dashicons dashicons-trash"></span> <?php echo __( 'Trash can', 'luxeritas' ) ?></p>
<ul id="t_buttons_d" class="quicktags-toolbar">
<?php
if( !empty( $t_buttons_array_d ) ) {
	foreach( (array)$t_buttons_array_d as $key => $val ) {
		$val = str_replace( '<input', '<input disabled', $val );
?>
<li data-button="<?php echo $key; ?>"><?php echo $val; ?><span class="remove dashicons dashicons-arrow-up"></span></li>
<?php
	}
}
?>
<li id="t_editor_save_msg"><span class="dashicons dashicons-marker"></span> <?php echo __( 'Saved', 'luxeritas' ); ?></li>
</ul>
<p style="white-space:nowrap">
<button type="button" name="t_editor_save" id="t_editor_save" class="button button-primary"><?php echo __( 'Save', 'luxeritas' ); ?></button>
<button type="button" name="t_editor_default" id="t_editor_default" class="button button-secondary"><?php echo __( 'Restore initial settings', 'luxeritas' ); ?></button>
</p>

<script>
Sortable.create( t_buttons_1, {
	group: {
		name: "t-editor",
		pull: function () {
			return "clone";
		}
	},
	sort: false,
	animation: 100,
});
var editableList = Sortable.create( t_buttons_d, {
	group: {
		name: "t-editor-d",
		put: ["t-editor"],
	},
	filter: ".remove",
	onAdd: function (evt) {
		var el = editableList.closest(evt.item)
		,   hidden = $(evt.item).data().button;
		el.innerHTML = el.innerHTML.replace( '<input', '<input disabled');
		el.innerHTML += '<span class="remove dashicons dashicons-arrow-up"></span>';
		$('#t_buttons_1' +  ' [data-button^=' + hidden + ']').hide();
	},
	onFilter: function (evt) {
		var el = editableList.closest(evt.item)
		,   hidden = $(evt.item).data().button;
		el && el.parentNode.removeChild(el);
		$('#t_buttons_1' +  ' [data-button^=' + hidden + ']').show();
	},
	animation: 100,
});

jQuery(function($) {
	$('#t_editor_save').on('click', function() {
		var buttons_d = $('#t_buttons_d li').map(function(){
			return $(this).data('button');
		}).toArray();

		jQuery.ajax({
			type: 'POST',
			url: '<?php echo admin_url( "admin-ajax.php" ); ?>',
			data: {action:'t_editor_settings', buttons_d:buttons_d, editor_settings_nonce:'<?php echo $editor_settings_nonce; ?>'},
			dataType: 'text',
			async: true,
			cache: false,
			timeout: 10000,
			success: function( response ) {
				$('#t_editor_save_msg').fadeIn(1000).delay(2000).fadeOut(1500);
			},
			error: function() {
				alert("Processing ajax failed.");
			}
		});
	});

	$('#t_editor_default').on('click', function() {
		jQuery.ajax({
			type: 'POST',
			url: '<?php echo admin_url( "admin-ajax.php" ); ?>',
			data: {action:'t_editor_restore', editor_settings_nonce:'<?php echo $editor_settings_nonce; ?>'},
			dataType: 'text',
			async: true,
			cache: false,
			timeout: 10000,
			success: function( response ) {
				location.reload(false);
			},
			error: function() {
				alert("Processing ajax failed.");
			}
		});
	});
});
</script>
