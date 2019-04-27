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

$v_buttons_default_1 = thk_mce_buttons_1();
$v_buttons_default_2 = thk_mce_buttons_2();
$v_buttons_default_d = thk_mce_buttons_d();

$v_buttons_array_1 = get_theme_admin_mod( 'veditor_buttons_1' );
$v_buttons_array_2 = get_theme_admin_mod( 'veditor_buttons_2' );
$v_buttons_array_d = array();

$v_buttons_default_all = $v_buttons_default_1 + $v_buttons_default_2 + $v_buttons_default_d;

if( !empty( $v_buttons_array_1 ) ) {
	foreach( $v_buttons_default_all as $key => $val ) {
		if( isset( $v_buttons_array_1[$key] ) ) {
			$v_buttons_array_1[$key] = $val;
		}
	}
}
elseif( $v_buttons_array_1 === false ) {
	$v_buttons_array_1 = $v_buttons_default_1;
}

if( !empty( $v_buttons_array_2 ) ) {
	foreach( (array)$v_buttons_default_all as $key => $val ) {
		if( isset( $v_buttons_array_2[$key] ) ) {
			$v_buttons_array_2[$key] = $val;
		}
	}
}
elseif( $v_buttons_array_2 === false ) {
	$v_buttons_array_2 = $v_buttons_default_2;
}

foreach( $v_buttons_default_all as $key => $val ) {
	if( !isset( $v_buttons_array_1[$key] ) && !isset( $v_buttons_array_2[$key] ) ) {
		$v_buttons_array_d[$key] = $val;
	}
}

$editor_settings_nonce = wp_create_nonce( 'settings_nonce' );
?>
<style>
.drop-down {
	padding: 14px 8px;
	height: 18px;
	width: 90px;
	border: 1px solid #ddd;
	font-size: 12px;
	cursor: move;
}
ul[id^=v_buttons_] {
	min-height: 40px;
	padding: 10px;
	letter-spacing: -.4em;
	background: #fff;
	border: 1px solid #ddd;
}
ul[id^=v_buttons_] li {
	display: inline-block;
	margin: 0;
	padding: 3px 6px 3px 8px;
	letter-spacing: normal;
	vertical-align: middle;
	background: #fff;
	border: 1px solid transparent;
	cursor: move;
}
ul[id^=v_buttons_] .cover {
	position: relative;
	display: inline-block;
	opacity: .8;
}
ul[id^=v_buttons_] .cover::after {
	display: block;
	content: "";
	position: absolute;
	top: 0;
	left: 0;
	height: 100%;
	width: 100%;
}
ul#v_buttons_1 {
	padding-bottom: 0;
	margin-bottom: 0;
	border-bottom: 0;
}
ul#v_buttons_2 {
	padding-top: 0;
	margin-top: 0;
	border-top: 0;
}
ul#v_buttons_d {
	position: relative;
	margin-top: 5px;
}
body li.sortable-drag,
body li.sortable-ghost,
body li.sortable-chosen {
	cursor: move!important;
}
body li.sortable-chosen {
	color: #fff;
	background: #8ecdf0;
	cursor: move;
}
body li.sortable-ghost, body li.sortable-ghost i, body li.sortable-ghost i::before, body li.sortable-ghost input {
	color: transparent;
	background: transparent;
	border: 0;
	box-shadow: none;
}
body li.sortable-ghost {
	border: 1px solid #ddd;
}
i.mce-i-thk-blogcard-button, i.mce-i-thk-mce-settings-button, i.mce-i-thk-phrase-button, i.mce-i-thk-shortcode-button {
	display: inline-block;
	position: relative;
	padding: 1px!important;
	width: 20px;
	height: 20px;
	background: #666;
	border-radius: 4px;
}
i.mce-i-thk-blogcard-button:before, i.mce-i-thk-mce-settings-button:before, i.mce-i-thk-phrase-button:before, i.mce-i-thk-shortcode-button:before {
	display: block;
	position: absolute;
	top: 1px;
	bottom: 0;
	left: 0;
	right: 0;
	margin: auto;
	font: 400 18px/1 dashicons;
	line-height: 18px;
	width: 18px;
	height: 18px;
	color: #fff;
	border-radius: 4px;
}
i.mce-i-thk_emoji {
	font: normal 20px/1 dashicons;
	padding: 0;
	vertical-align: top;
	speak: none;
	-webkit-font-smoothing: antialiased;
	-moz-osx-font-smoothing: grayscale;
	margin-left: -2px;
	padding-right: 2px;
}
i.mce-i-thk-phrase-button:before {
	content: "\f478";
}
i.mce-i-thk-shortcode-button:before {
	content: "\f475";
}
i.mce-i-thk-blogcard-button:before {
	content: "\f233";
}
i.mce-i-thk_emoji:before {
	content: "\f328";
}
i.mce-i-thk-mce-settings-button:before {
	content: "\f111";
}
#v_editor_save_msg {
	position: absolute;
	bottom: -10px;
	left: -3px;
	display: none;
	margin-left: 5px;
	padding: 5px 20px 5px 20px;
	color: #fff;
	background: #ef9c99;
	border-radius: 99px 0 99px 0;
	white-space: nowrap;
	z-index: 10;
}
</style>

<p><?php echo __( '* You can set display / hide / sort of buttons by drag & drop.', 'luxeritas' ); ?></p>
<ul id="v_buttons_1" class="mce-toolbar">
<?php
if( !empty( $v_buttons_array_1 ) ) {
	foreach( $v_buttons_array_1 as $key => $val ) {
		if( $val !== true ) {
?>
<li data-button="<?php echo $key; ?>"><?php echo $val; ?></li>
<?php
		}
	}
}
?>
</ul>
<ul id="v_buttons_2" class="mce-toolbar">
<?php
if( !empty( $v_buttons_array_2 ) ) {
	foreach( $v_buttons_array_2 as $key => $val ) {
		if( $val !== true ) {
?>
<li data-button="<?php echo $key; ?>"><?php echo $val; ?></li>
<?php
		}
	}
}
?>
</ul>
<p style="margin-bottom:0;margin-left:5px"><span class="dashicons dashicons-trash"></span> <?php echo __( 'Trash can', 'luxeritas' ) ?></p>
<ul id="v_buttons_d" class="mce-toolbar">
<?php
if( !empty( $v_buttons_array_d ) ) {
	foreach( (array)$v_buttons_array_d as $key => $val ) {
		if( $val !== true ) {
?>
<li data-button="<?php echo $key; ?>"><?php echo $val; ?></li>
<?php
		}
	}
}
?>
<li id="v_editor_save_msg"><span class="dashicons dashicons-marker"></span> <?php echo __( 'Saved', 'luxeritas' ); ?></li>
</ul>
<p>
<button type="button" name="v_editor_save" id="v_editor_save" class="button button-primary"><?php echo __( 'Save', 'luxeritas' ); ?></button>
<button type="button" name="v_editor_default" id="v_editor_default" class="button button-secondary"><?php echo __( 'Restore initial settings', 'luxeritas' ); ?></button>
</p>

<script>
Sortable.create( v_buttons_1, {
	group: {
		name: "v-editor",
	},
});
Sortable.create( v_buttons_2, {
	group: {
		name: "v-editor",
	},
});
Sortable.create( v_buttons_d, {
	group: {
		name: "v-editor",
	},
});

jQuery(function($) {
	$('#v_editor_save').on('click', function() {
		var buttons_1 = $('#v_buttons_1 li').map(function(){
			return $(this).data('button');
		}).toArray()
		,   buttons_2 = $('#v_buttons_2 li').map(function(){
			return $(this).data('button');
		}).toArray();

		jQuery.ajax({
			type: 'POST',
			url: '<?php echo admin_url( "admin-ajax.php" ); ?>',
			data: {action:'v_editor_settings', buttons_1:buttons_1, buttons_2:buttons_2, editor_settings_nonce:'<?php echo $editor_settings_nonce; ?>'},
			dataType: 'text',
			async: true,
			cache: false,
			timeout: 10000,
			success: function( response ) {
				$('#v_editor_save_msg').fadeIn(1000).delay(2000).fadeOut(1500);
			},
			error: function() {
				alert("Processing ajax failed.");
			}
		});
	});

	$('#v_editor_default').on('click', function() {
		jQuery.ajax({
			type: 'POST',
			url: '<?php echo admin_url( "admin-ajax.php" ); ?>',
			data: {action:'v_editor_restore', editor_settings_nonce:'<?php echo $editor_settings_nonce; ?>'},
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
