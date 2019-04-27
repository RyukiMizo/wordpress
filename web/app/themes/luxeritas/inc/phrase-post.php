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
if( isset( $luxe['add_phrase_button_1'] ) ) {
	add_action( 'media_buttons', function() {
		$label = __( 'Fixed phrase', 'luxeritas' );
?>
<a href="#" id="thk-phrase-action" class="button" title="<?php echo $label; ?>"><span class="thk-phrase-icon"></span><?php echo $label; ?></a>
<?php
	}, 20 );
}
*/

/*---------------------------------------------------------------------------
 * TinyMCE ボタン
 *---------------------------------------------------------------------------*/
/*
if( isset( $luxe['add_phrase_button_2'] ) ) {
	if( get_user_option( 'rich_editing' ) === 'true' ) {
		add_filter( 'mce_external_plugins', function( $plugin_array ) {
			$plugin_array[ 'thk-phrase-button' ] = TDEL . '/js/' . 'thk-dummy.js';
			return $plugin_array;
		});
		add_filter( 'mce_buttons', function( $buttons ) {
			array_push( $buttons, 'thk-phrase-button' );
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
<!-- #dialog-form  -->
<div id="thk-phrase-form" title="<?php echo __( 'Insert fixed phrase', 'luxeritas' ); ?>">
	<form>
	<div id="phrase-group">
<?php
$fp_mods = array();
$values  = array( 'close' => '' );
$admin_mods  = get_theme_phrase_mods();
$popup_nonce = wp_create_nonce( 'phrase_popup' );

foreach( (array)$admin_mods as $key => $val ) {
	if( strpos( $key, 'fp-' ) === 0 ) {
		$fp_mods[substr( $key, 3, strlen( $key ) )] = wp_parse_args( @json_decode( $val ), $values );
	}
}
unset( $admin_mods );

if( empty( $fp_mods ) ) {
?>
<p style="color:red;padding:15px"><?php echo __( 'There is no fixed phrase registered.', 'luxeritas' ); ?></p>
<?php
}
else {
	asort( $fp_mods );
	foreach( (array)$fp_mods as $key => $val ) {
		$fpid = strlen( $key ) . '-' . md5( $key );
?>
<button type="button" id="<?php echo $fpid; ?>" name="fp_selector" value="<?php echo $key; ?>" data-phrase-sep="<?php echo $fpid; ?>" data-phrase-closing="<?php echo $val['close']; ?>" /><?php echo $key; ?></button>
<?php
	}
}
?>
	</div>
	</form>
</div>
<script>
jQuery(function($) {
	$('input[name=sc_selector]').change(function(){
	　　　　$('input[name=fp_selector][value='+$(this).val()+']').prop('checked', true);
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

		tinymce.PluginManager.add( 'thk-phrase-button', function( editor ) {
			var _ugh
			,   toolbar
			,   toolbarEdit
			,   ctrlVisible = false;

			window.setInterval( function() {
				if( _ugh ) ctrlVisible = _ugh._parent._parent._parent.visible();
			}, 100 );

			tinymce.ui.Factory.add( 'ThkPhraseInput', tinymce.ui.Control.extend( {
				init: function(settings) {
					_ugh = this;
					this._super.call( this, settings );
				},

				renderHtml: function() {
					var html = '';
<?php
if( empty( $fp_mods ) ) {
?>
					html += '<p style="color:red;text-align:center;padding:20px"><?php echo __( 'There is no fixed phrase registered.', 'luxeritas' ); ?></p>';
<?php
}
else {
	asort( $fp_mods );
?>
					html += '<div id="' + this._id + '" class="thk-phrase-input"><div class="thk-phrase-buttons">';
	<?php
	foreach( (array)$fp_mods as $key => $val ) {
		$fpid = strlen( $key ) . '-' . md5( $key );
?>
					html += '<button type="button" id="<?php echo $fpid; ?>" value="<?php echo $key; ?>" data-phrase-sep="<?php echo $fpid; ?>" data-phrase-closing="<?php echo $val['close']; ?>"><?php echo $key; ?></button>';
<?php
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
						var insert  = null
						,   code    = $(this).val()
						,   sep     = $(this).attr( 'data-phrase-sep' )
						,   closing = $(this).attr( 'data-phrase-closing' );

						jQuery.ajax({
							type: 'POST',
							url: '<?php echo admin_url( "admin-ajax.php" ); ?>',
							data: {action:'thk_phrase_regist', name:code, fp_popup_nonce:'<?php echo $popup_nonce; ?>'},
							dataType: 'text',
							async: true,
							cache: false,
							timeout: 10000,
							success: function( response ) {
								if( closing == 1 ) {
									var selected = tinymce.activeEditor.selection.getContent();
									if( selected === '' || selected === null || typeof selected === "undefined" ) {
										selected = "<?php echo __( 'Text not selected.', 'luxeritas' ) ?>";
									}
									editor.execCommand( 'mceInsertContent', false, response.replace( "\n<!--" + sep + "-->\n", selected ) );
								} else {
									editor.execCommand( 'mceInsertContent', false, response );
								}
								document.activeElement.blur();
							},
							error: function() {
								document.activeElement.blur();
							}
						});
					});
				},
			}));

			editor.on( 'preinit', function() {
				if( editor.wp && editor.wp._createToolbar ) {
					var insertButtons = ['thk-phrase-input'];
					toolbarEdit = editor.wp._createToolbar( insertButtons, true );
				}
			});

			editor.addCommand( 'thk-phrase-button', function() {
				toolbarOpen = true;
				editor.nodeChanged();
			});

			editor.addButton( 'thk-phrase-button', {
				icon: 'thk-phrase-button',
				title: '<?php echo __( "Fixed phrase", "luxeritas" ); ?>',
				cmd: 'thk-phrase-button',
				stateSelector: '',
			});

			editor.addButton( 'thk-phrase-input', {
				type: 'ThkPhraseInput',
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
		console.error("tinymce.phrase.error: " + e.message)
	}
<?php
}
if( !isset( $luxe['teditor_buttons_d']['thk-phrase'] ) ) {
?>
	var bc    = '#option-'
	,   fpfm  = $('#thk-phrase-form');

	var thk_mce_insert = function( code, insert ) {
		if( code == '' || code == null ) return false;
		if(window.parent.QTags) QTags.insertContent( insert );
	}

	fpfm.dialog({
		autoOpen: false,
		height: 'auto',
		width: 'auto',
		maxWidth: 640,
		minWidth: 300,
		minHeight: false,
		modal: true,
	});

	$('#phrase-group').find('button').on('click', function() {
		var code    = $(this).val()
		,   sep     = $(this).attr( 'data-phrase-sep' )
		,   closing = $(this).attr( 'data-phrase-closing' )

		fpfm.dialog('close');

		jQuery.ajax({
			type: 'POST',
			url: '<?php echo admin_url( "admin-ajax.php" ); ?>',
			data: {action:'thk_phrase_regist', name:code, fp_popup_nonce:'<?php echo $popup_nonce; ?>'},
			dataType: 'text',
			async: true,
			cache: false,
			timeout: 10000,
			success: function( response ) {
				if( closing == 1 ) {
					thk_mce_insert( code, response.replace( "\n<!--" + sep + "-->\n", THK_SELECTED_RANGE) );
				} else {
					thk_mce_insert( code, response );
				}
			},
			error: function() {
				thk_mce_insert( code, '<?php echo __( "Failed to read.", "luxeritas" ); ?>' );
			}
		});

		// フォーカスを移す
		setTimeout( function(){ $('textarea').eq(0).focus(); }, 0 );

		return false;
	});

	if( typeof QTags !== 'undefined' ) {
		var thk_phrase_dialog_open = function() {
			THK_GET_SELECTED_RANGE();
			fpfm.dialog('open');
		}
		QTags.addButton( 'thk-phrase', '<?php echo __( "Fixed phrase", "luxeritas" ); ?>', thk_phrase_dialog_open, '', '', '', 120 );
	}

	// 定型文ボタンがクリックされたらダイアログを表示
	$('#thk-phrase-action').click( function() {
		THK_GET_SELECTED_RANGE();
		fpfm.dialog('open');
		return false;
	});

	// オーバーレイがクリックされたらダイアログを閉じる
	$(document).on( 'click', '.ui-widget-overlay', function() {
		fpfm.dialog('close');
		setTimeout( function(){ $('textarea').eq(0).focus(); }, 0 );
	});
<?php
}
?>
});
</script>
<?php
}, 45 );
