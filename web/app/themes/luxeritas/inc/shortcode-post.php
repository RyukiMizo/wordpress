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

/*---------------------------------------------------------------------------
 * メディアボタン横
 *---------------------------------------------------------------------------*/
/*
if( isset( $luxe['add_post_shortcode_button_1'] ) ) {
	add_action( 'media_buttons', function() {
		$label = __( 'Shortcode', 'luxeritas' );
?>
<a href="#" id="thk-shortcode-action" class="button" title="<?php echo $label; ?>"><span class="thk-shortcode-icon"></span><?php echo $label; ?></a>
<?php
	}, 20 );
}
*/

/*---------------------------------------------------------------------------
 * TinyMCE ボタン
 *---------------------------------------------------------------------------*/
/*
if( isset( $luxe['add_post_shortcode_button_2'] ) ) {
	if( get_user_option( 'rich_editing' ) === 'true' ) {
		add_filter( 'mce_external_plugins', function( $plugin_array ) {
			$plugin_array[ 'thk-shortcode-button' ] = TDEL . '/js/' . 'thk-dummy.js';
			return $plugin_array;
		});
		add_filter( 'mce_buttons', function( $buttons ) {
			array_push( $buttons, 'thk-shortcode-button' );
			return $buttons;
		});
	}
}
*/

/*---------------------------------------------------------------------------
 * フッター（メイン処理）
 *---------------------------------------------------------------------------*/
add_action( 'admin_print_footer_scripts', function() {
//add_action( 'after_wp_tiny_mce', function() {
	global $luxe;
?>
<div id="thk-shortcode-form" title="<?php echo __( 'Insert Shortcode', 'luxeritas' ); ?>">
	<form>
	<div id="shortcode-group">
<?php
$values = array( 'label' => '', 'close' => '', 'hide' => '', 'active' => '' );
$admin_mods = get_theme_phrase_mods();
$sc_mods = array();
$active_flag = false;

foreach( (array)$admin_mods as $key => $val ) {
	if( strpos( $key, 'sc-' ) === 0 ) {
		$sc_mods[substr( $key, 3, strlen( $key ) )] = wp_parse_args( @json_decode( $val ), $values );
	}
}
unset( $admin_mods );

foreach( (array)$sc_mods as $key => $val ) {
	if( $active_flag === false ) {
		if( !empty( $sc_mods[$key]['active'] ) ) $active_flag = true;
	}
}

if( $active_flag === false ) {
?>
<p style="color:red;padding:15px"><?php echo __( 'There is no active shortcode.', 'luxeritas' ); ?></p>
<?php
}
else {
	asort( $sc_mods );
	foreach( (array)$sc_mods as $key => $val ) {
		$values = $val;
		if( isset( $values['active'] ) ) {
	?>
<button type="button" id="<?php echo $key; ?>" name="sc_selector" value="<?php echo $key; ?>" data-shortcode-closing="<?php echo $values['close']; ?>" /><?php echo $values['label']; ?></button>
	<?php
		}
	}
}
?>
	</div>
	</form>
</div>

<script>
jQuery(function($) {
	$('input[name=sc_selector]').change(function(){
	　　　　$('input[name=sc_selector][value='+$(this).val()+']').prop('checked', true);
	});

<?php
if( get_user_option( 'rich_editing' ) === 'true' ) {
?>
	try {
	( function( tinymce ) {
		if( typeof tinyMCE === "undefined" ) return;

		var $ = window.jQuery
		,   toolbarOpen = false
		,   toolbarOpts = {};

		tinymce.PluginManager.add( 'thk-shortcode-button', function( editor ) {
			var _ugh
			,   toolbar
			,   toolbarEdit
			,   ctrlVisible = false;

			window.setInterval( function() {
				if( _ugh ) ctrlVisible = _ugh._parent._parent._parent.visible();
			}, 100 );

			tinymce.ui.Factory.add( 'ThkShortcodeInput', tinymce.ui.Control.extend( {
				init: function(settings) {
					_ugh = this;
					this._super.call( this, settings );
				},

				renderHtml: function() {
					var html = '';
<?php
foreach( (array)$sc_mods as $key => $val ) {
	if( $active_flag === false ) {
		if( !empty( $sc_mods[$key]['active'] ) ) $active_flag = true;
	}
}

if( $active_flag === false ) {
?>
					html += '<p style="color:red;text-align:center;padding:20px"><?php echo __( 'There is no active shortcode.', 'luxeritas' ); ?></p>';
<?php
}
else {
	asort( $sc_mods );
?>
					html += '<div id="' + this._id + '" class="thk-shortcode-input"><div class="thk-shortcode-buttons">';
<?php
	foreach( (array)$sc_mods as $key => $val ) {
		$values = $val;
		if( isset( $values['active'] ) ) {
	?>
					html += '<button type="button" id="<?php echo $key; ?>" value="<?php echo $key; ?>" data-shortcode-closing="<?php echo $values['close']; ?>"><?php echo $values['label']; ?></button>';
<?php
		}
	}
}
?>
					html += '</div></div>';
					return html;
				},

				postRender: function() {
					var el = $( this.getEl() );
					el.find('button').on('click', function() {
						toolbarOpen = true;
						var code      = $(this).val()
						,   has_space = code
						,   insert    = '[' + code + ']'
						,   closing   = $(this).attr( 'data-shortcode-closing' );

						if( closing == 1 ) {
							if( code.indexOf(' ') != -1 ) {
								has_space = code.substring( 0, code.indexOf(' ') );
							}
							insert = '[' + code + ']' + tinymce.activeEditor.selection.getContent() + '[/' + has_space + ']';
						}
						editor.execCommand( 'mceInsertContent', false, insert );
						document.activeElement.blur();
					});
				},
			}));

			editor.on( 'preinit', function() {
				if( editor.wp && editor.wp._createToolbar ) {
					var insertButtons = ['thk-shortcode-input'];
					toolbarEdit = editor.wp._createToolbar( insertButtons, true );
				}
			});

			editor.addCommand( 'thk-shortcode-button', function() {
				toolbarOpen = true;
				editor.nodeChanged();
			});

			editor.addButton( 'thk-shortcode-button', {
				icon: 'thk-shortcode-button',
				title: '<?php echo __( "Shortcode", "luxeritas" ); ?>',
				cmd: 'thk-shortcode-button',
				stateSelector: '',
			});

			editor.addButton( 'thk-shortcode-input', {
				type: 'ThkShortcodeInput',
			});

			var toolbarOpenLastTime = new Date().getTime();

			editor.on( 'wptoolbar', function( event ) {
				var now = new Date().getTime();
				if( now - toolbarOpenLastTime < 100 && toolbarOpen === false ) {
					toolbarOpen = true;
				}
				if( toolbarOpen === true ) {
					toolbarOpenLastTime = new Date().getTime();
					toolbarOpen = false;
					event.toolbar = toolbarEdit;
				}
			});
		});
	})( window.tinymce );
	} catch (e) {
		console.error("tinymce.shortcode.error: " + e.message)
	}
<?php
}
if( !isset( $luxe['teditor_buttons_d']['thk-shortcode'] ) ) {
?>
	var bc    = '#option-'
	,   scfm  = $('#thk-shortcode-form');

	scfm.dialog({
		autoOpen: false,
		height: 'auto',
		width: 'auto',
		maxWidth: 640,
		minWidth: 300,
		minHeight: false,
		modal: true,
	});

	$('#shortcode-group').find('button').on('click', function() {
		var code    = $(this).val()
		,   has_space = code
		,   insert  = '[' + code + ']'
		,   closing = $(this).attr( 'data-shortcode-closing' );

		if( code == '' || code == null ) return false;

		scfm.dialog('close');

		if( closing == 1 ) {
			if( code.indexOf(' ') != -1 ) {
				has_space = code.substring( 0, code.indexOf(' ') );
			}
			insert = '[' + code + ']' + THK_SELECTED_RANGE + '[/' + has_space + ']';
		} else {
			insert = THK_SELECTED_RANGE + insert;
		}

		if( window.parent.QTags ) QTags.insertContent( insert );

		// フォーカスを移す
		setTimeout( function(){ $('textarea').eq(0).focus(); }, 0 );

		return false;
	});

	if( typeof QTags !== 'undefined' ) {
		var thk_shortcode_dialog_open = function() {
			THK_GET_SELECTED_RANGE();
			scfm.dialog('open');
			scfm.find('input').prop('checked', false);
		}
		QTags.addButton( 'thk-shortcode', '<?php echo __( "Shortcode", "luxeritas" ); ?>', thk_shortcode_dialog_open, '', '', '', 121 );
	}

	// ショートコードボタンがクリックされたらダイアログを表示
	$('#thk-shortcode-action').click( function() {
		THK_GET_SELECTED_RANGE();
		scfm.dialog('open');
		return false;
	});

	// オーバーレイがクリックされたらダイアログを閉じる
	$(document).on( 'click', '.ui-widget-overlay', function() {
		scfm.dialog('close');
		setTimeout( function(){ $('textarea').eq(0).focus(); }, 0 );
	});
<?php
}
?>
});
</script>
<?php
}, 45 );
