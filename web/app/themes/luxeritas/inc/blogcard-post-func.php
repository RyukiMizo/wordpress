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
add_action( 'media_buttons', function() {
	$label = __( 'Blog Card', 'luxeritas' );
?>
<a href="#" id="thk-blogcard-action" class="button" title="<?php echo $label; ?>"><span class="thk-blog-card-icon"></span><?php echo $label; ?></a>
<?php
}, 20 );
*/

/*---------------------------------------------------------------------------
 * フッター（メイン処理）
 *---------------------------------------------------------------------------*/
add_action( 'admin_print_footer_scripts', function() {
//add_action( 'after_wp_tiny_mce', function() {
	global $luxe;
?>
<!-- #dialog-form  -->
<div id="thk-blogcard-form" style="display:none" title="<?php echo __( 'Insert Blog Card', 'luxeritas' ); ?>">
    <form>
        <table id="form1">
            <tr>
                <td>URL</td>
                <td><input type="text" id="thk-blogcard-url" name="thk-blogcard-url" value="" size="30" /></td>
            </tr>
            <tr>
                <td><?php echo __( 'Link Text', 'luxeritas' ); ?></td>
                <td><input type="text" id="thk-blogcard-str" name="thk-blogcard-str" value="" size="30" /></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="checkbox" id="thk-blogcard-target" name="thk-blogcard-target" value="" /><?php echo __( 'Open link in a new tab', 'luxeritas' ); ?></td>
            </tr>
        </table>
    </form>
</div>

<script>
jQuery(function($) {
<?php
if( get_user_option( 'rich_editing' ) === 'true' ) {
?>
	try {
	( function( tinymce ) {
		if( typeof tinyMCE === "undefined" ) return;

		var $ = window.jQuery
		,   toolbarOpen = false
		,   toolbarOpts = {};

		tinymce.PluginManager.add( 'thk-blogcard-button', function( editor ) {
			var _ugh
			,   toolbar
			,   toolbarEdit
			,   ctrlVisible = false;

			window.setInterval( function() {
				if( _ugh ) ctrlVisible = _ugh._parent._parent._parent.visible();
			}, 100 );

			tinymce.ui.Factory.add( 'ThkBlogcardInput', tinymce.ui.Control.extend( {
				init: function(settings) {
					_ugh = this;
					this._super.call( this, settings );
				},

				renderHtml: function() {
					var html = '';
					html += '<div id="' + this._id + '" class="tiny-blogcard-input">';
					html += '<table id="tiny-blogcard">';
					html += '<tr>';
					html += '<td>URL</td>';
					html += '<td><input type="text" class="tiny-blogcard-url" name="tiny-blogcard-url" value="" size="30" /></td>';
					html += '</tr>';
					html += '<tr>';
					html += '<td><?php echo __( 'Link Text', 'luxeritas' ); ?></td>';
					html += '<td><input type="text" class="tiny-blogcard-str" name="tiny-blogcard-str" value="" size="30" /></td>';
					html += '</tr>';
					html += '<tr>';
					html += '<td></td>';
					html += '<td><input type="checkbox" class="tiny-blogcard-target" name="tiny-blogcard-target" value="" /><?php echo __( 'Open link in a new tab', 'luxeritas' ); ?></td>';
					html += '</tr>';
					html += '</table>';
					html += '<input type="button" class="tiny-blogcard-insert" value="<?php echo __( 'Insert', 'luxeritas' ); ?>" />';
					html += '</div>';
					return html;
				},

				postRender: function() {
					var el = $( this.getEl() );
					el.find('.tiny-blogcard-insert').on('click keydown', function() {
						toolbarOpen = true;
						var pnt = '#' + $(this).parent().attr('id')
						,   url = $(pnt + ' .tiny-blogcard-url').val()
						,   str = $(pnt + ' .tiny-blogcard-str').val()
						,   tgt = $(pnt + ' .tiny-blogcard-target').prop('checked');

						if( str == '' ) str = url;
						var insert = '<a href="' + url + '" data-blogcard="1">' + str + '</a>';

						if( tgt == true ) insert = '<a href="' + url + '" data-blogcard="1" target="_blank" rel="noopener">' + str + '</a>';

						editor.execCommand( 'mceInsertContent', false, insert );

						url = $('.tiny-blogcard-url').val('');
						str = $('.tiny-blogcard-str').val('');
						tgt = $('.tiny-blogcard-target').prop('checked', false);
						document.activeElement.blur();
					});
				},
			}));

			editor.on( 'preinit', function() {
				if( editor.wp && editor.wp._createToolbar ) {
					var insertButtons = ['tiny-blogcard-input'];
					toolbarEdit = editor.wp._createToolbar( insertButtons, true );
				}
			});

			editor.addCommand( 'thk-blogcard-button', function() {
				toolbarOpen = true;
				editor.nodeChanged();
				$('#tiny-blogcard-url').focus();
			});

			editor.addButton( 'thk-blogcard-button', {
				icon: 'thk-blogcard-button',
				title: '<?php echo __( "Blog Card", "luxeritas" ); ?>',
				cmd: 'thk-blogcard-button',
				stateSelector: '',
			});

			editor.addButton( 'tiny-blogcard-input', {
				type: 'ThkBlogcardInput',
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
		console.error("tinymce.blogcard.error: " + e.message)
	}
<?php
}
if( !isset( $luxe['teditor_buttons_d']['thk-blogcard'] ) ) {
?>
	var bc = '#thk-blogcard-'
	,   fm = $(bc + 'form');

	fm.dialog({
		autoOpen: false,
		width: 'auto',
		maxWidth: 370,
		modal: true,
		buttons: {  // ダイアログに表示するボタンと処理
			"<?php echo __( 'Add Link', 'luxeritas' ); ?>": function() {
				var mce = null
				,   url = $(bc + 'url').val()
				,   str = $(bc + 'str').val()
				,   tgt = $(bc + 'target').prop('checked');
				if( str == '' ) str = url;
				var insert = '<a href="' + url + '" data-blogcard="1">' + str + '</a>';

				if( tgt == true ) insert = '<a href="' + url + '" data-blogcard="1" target="_blank" rel="noopener">' + str + '</a>';

				if( url == '' || url == null ) return false;

				if(window.parent.QTags) QTags.insertContent( insert );

				$(this).dialog('close');
				// フォーカスを移す
				setTimeout( function(){ $('textarea').eq(0).focus(); }, 0 );
			},
			"<?php echo __( 'Cancel', 'luxeritas' ); ?>": function() {
				$(this).dialog('close');
				// ダイアログを閉じたらフォーカスを移す
				setTimeout( function(){ $('textarea').eq(0).focus(); }, 0 );
			}
		},
	});

	if( typeof QTags !== 'undefined' ) {
		var thk_blogcard_dialog_open = function() {
			THK_GET_SELECTED_RANGE();
			fm.dialog('open').dialog("open");
		}
		QTags.addButton( 'thk-blogcard', '<?php echo __( "Blog Card", "luxeritas" ); ?>', thk_blogcard_dialog_open, '', '', '', 122 );
	}

	// ブログカードボタンがクリックされたらダイアログを表示
	$(bc + 'action').click( function() {
		fm.dialog('open');
		return false;
	});

	// オーバーレイがクリックされたらダイアログを閉じる
	$(document).on( 'click', '.ui-widget-overlay', function() {
		fm.dialog('close');
		setTimeout( function(){ $('textarea').eq(0).focus(); }, 0 );
	}); 
<?php
}
?>
});
</script>
<?php
}, 45 );
