/*! Luxeritas WordPress Theme - free/libre wordpress platform
 *
 * @copyright Copyright (C) 2015 Thought is free.
 * @link https://thk.kanzae.net/
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPL v2 or later
 * @author LunaNuko
 */

/*
------------------------------------------------------------------
 プレビュー画面だけで呼び出すスクリプト
 元の関数をオーバーライドして、SNS のカウント数を全件 0 表示するだけ
------------------------------------------------------------------ */
function get_sns_count( id, sns_class ) {
	jQuery(function($){
		var LUXE_SNS_LIST = {
		        'f': '.facebook-count',
		        'g': '.google-count',
		        'h': '.hatena-count',
		        'l': '.linkedin-count',
		        't': '.pinit-count',
		        'p': '.pocket-count',
		        'r': '.feedly-count'
		}
		$.each( LUXE_SNS_LIST, function( index, val ) {
			$( val ).text( 0 );
		});
	});
}
