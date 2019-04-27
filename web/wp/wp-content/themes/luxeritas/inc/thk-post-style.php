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
<style>
<?php
if( get_user_option( 'rich_editing' ) === 'true' ) {
// TinyMCE settings
?>
#thk-mce-settings-form{display:none;position:static}#thk-mce-settings-form td{padding:5px 10px}#thk-mce-settings-form .enter_desc td,#thk-mce-settings-form td.p0{padding:0}body .vtop{vertical-align:top}body .p0-r{padding-right:0}body .p5-r{padding-right:5px!important}#mce_reload_check{position:absolute;max-width:200px;left:9pt;bottom:8px}
<?php
}
// Blogcard & Phrase & Shortcode
?>
#thk-blogcard-form td{white-space:nowrap}body .tiny-blogcard-input{max-width:540px;width:100%;padding:20px;white-space:normal}body .tiny-blogcard-input td{padding:3px;vertical-align:middle}body .tiny-blogcard-input input[type="text"]{width:100%;padding:3px}body .tiny-blogcard-input .tiny-blogcard-insert{display:block;margin:20px 50px 0 auto;padding:2px 10px;color:#fff;background:#00a0dd;box-shadow:0 1px 0 #0063a4;border:1px solid #0063a4;border-radius:3px;white-space:nowrap;cursor:pointer}body .tiny-blogcard-input .tiny-blogcard-insert:focus,body .tiny-blogcard-input .tiny-blogcard-insert:hover{background:#0063a4}body .ui-widget-overlay{background:#000;opacity:.3;z-index:1}#thk-phrase-form,#thk-shortcode-form{display:none;padding:.5em 0}#thk-phrase-form input[type=radio],#thk-shortcode-form input[type=radio]{position:absolute;visibility:hidden;display:none}#thk-phrase-form button,#thk-shortcode-form button,body .thk-phrase-buttons button,body .thk-shortcode-buttons button{-webkit-box-flex:1 0 auto;-ms-flex:1 0 auto;flex:1 0 auto;margin:3px;-moz-box-shadow:inset 0 1px 0 0 #fff;-webkit-box-shadow:inset 0 1px 0 0 #fff;box-shadow:inset 0 1px 0 0 #fff;background:-webkit-gradient(linear,left top,left bottom,color-stop(.05,#f9f9f9),color-stop(1,#e9e9e9));background:-moz-linear-gradient(top,#f9f9f9 5%,#e9e9e9 100%);background:-webkit-linear-gradient(top,#f9f9f9 5%,#e9e9e9 100%);background:-o-linear-gradient(top,#f9f9f9 5%,#e9e9e9 100%);background:-ms-linear-gradient(top,#f9f9f9 5%,#e9e9e9 100%);background:linear-gradient(to bottom,#f9f9f9 5%,#e9e9e9 100%);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#f9f9f9',endColorstr='#e9e9e9',GradientType=0);background-color:#f9f9f9;-moz-border-radius:2px;-webkit-border-radius:2px;border-radius:2px;border:1px solid #dcdcdc;display:inline-block;cursor:pointer;color:#444;font-size:9pt;padding:5px 10px;text-decoration:none;text-shadow:0 1px 0 #fff}#thk-phrase-form button:hover,#thk-shortcode-form button:hover,.thk-shortcode-buttons button:hover{-moz-box-shadow:inset 0 1px 0 0 #fff;-webkit-box-shadow:inset 0 1px 0 0 #fff;box-shadow:inset 0 1px 0 0 #fff;background:-webkit-gradient(linear,left top,left bottom,color-stop(.05,#ededed),color-stop(1,#dfdfdf));background:-moz-linear-gradient(top,#ededed 5%,#dfdfdf 100%);background:-webkit-linear-gradient(top,#ededed 5%,#dfdfdf 100%);background:-o-linear-gradient(top,#ededed 5%,#dfdfdf 100%);background:-ms-linear-gradient(top,#ededed 5%,#dfdfdf 100%);background:linear-gradient(to bottom,#ededed 5%,#dfdfdf 100%);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ededed',endColorstr='#dfdfdf',GradientType=0);background-color:#ededed}#thk-phrase-form #phrase-group,#thk-shortcode-form #shortcode-group,body .thk-phrase-buttons,body .thk-shortcode-buttons{display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;-webkit-flex-wrap:wrap;-ms-flex-wrap:wrap;flex-wrap:wrap;max-width:540px;width:100%;white-space:normal;overflow-x:hidden;overflow-y:scroll}#thk-phrase-form #phrase-group,#thk-shortcode-form #shortcode-group{max-height:205px}body .thk-phrase-buttons,body .thk-shortcode-buttons{max-height:210px}#thk-phrase-form #phrase-group button,#thk-shortcode-form #shortcode-group button,body .thk-phrase-buttons button,body .thk-shortcode-buttons button{text-align:left}body .thk-phrase-input,body .thk-shortcode-input{background:#fff}#fp-code-after,#fp-code-before,#sc-code-after,#sc-code-before{margin:0;padding:.5em 0}#fp-code-after span,#fp-code-before span,#sc-code-after span,#sc-code-before span{display:block;overflow:hidden;white-space:nowrap;margin:0;padding:.3em .5em;background:#eee;background:-moz-linear-gradient(left,#ededed,#fff);background:-webkit-linear-gradient(left,#ededed,#fff);background:linear-gradient(to right,#ededed,#fff)}i.mce-i-thk-blogcard-button,i.mce-i-thk-mce-settings-button,i.mce-i-thk-phrase-button,i.mce-i-thk-shortcode-button{display:block;position:relative;padding:1px!important;width:20px;height:20px;background:#666;border-radius:4px}i.mce-i-thk-blogcard-button:before,i.mce-i-thk-mce-settings-button:before,i.mce-i-thk-phrase-button:before,i.mce-i-thk-shortcode-button:before{display:block;position:absolute;top:1px;bottom:0;left:0;right:0;margin:auto;font:400 18px/1 dashicons;line-height:18px;width:18px;height:18px;color:#fff;border-radius:4px}i.mce-i-thk-phrase-button:before{content:"\f478"}i.mce-i-thk-shortcode-button:before{content:"\f475"}i.mce-i-thk-blogcard-button:before{content:"\f233"}i.mce-i-thk-mce-settings-button:before{content:"\f111"}body .ui-dialog{max-width:100%}body .ui-dialog-titlebar{height:auto;font-size:9pt;line-height:normal}body .ui-button{display:inline-block;font-size:9pt;line-height:28px;height:28px;padding:0 9pt 2px;cursor:pointer;-webkit-appearance:none;border:1px solid #0063a4;border-radius:3px;white-space:nowrap;box-sizing:border-box;color:#fff;background:#00a0dd;box-shadow:0 1px 0 #0063a4;vertical-align:top}body .ui-button:hover{background:#0063a4;border:1px solid #0063a4;box-shadow:0 1px 0 #ae7d55;color:#fff}body .ui-button-icon-only .ui-icon{background-color:#f6f6f6;border:1px solid #c5c5c5;position:absolute;top:50%;left:50%;margin-top:-8px;margin-left:-8px}body .ui-dialog .ui-dialog-titlebar-close{position:absolute;right:.3em;top:50%;width:1pc;margin:-10px 0 0;padding:1px;height:1pc}
<?php
// Emoji
?>
body .thk-emoji-buttons{max-width:312px;width:100%;height:186px;padding:5px;white-space:normal;overflow-x:hidden;overflow-y:scroll}body .thk-emoji-buttons button{padding:2px;border-radius:4px;cursor:pointer}body .thk-emoji-buttons button:hover{background:#ccc}body .thk-emoji-buttons img.emoji{font-size:18px}i.mce-i-thk_emoji{font:normal 20px/1 dashicons;padding:0;vertical-align:top;speak:none;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale;margin-left:-2px;padding-right:2px}i.mce-i-thk_emoji:before{content:"\f328"}
</style>
<script>
var THK_SELECTED_RANGE
,   THK_GET_SELECTED_RANGE = function() {
	try {
		THK_SELECTED_RANGE = window.getSelection().toString();
		if( THK_SELECTED_RANGE === '' || THK_SELECTED_RANGE === null || typeof THK_SELECTED_RANGE === "undefined" ) {
			var ta = $('textarea').get(0);
			THK_SELECTED_RANGE = ta.value.substring( ta.selectionStart, ta.selectionEnd );
		}
	} catch(e) {
		var ta = $('textarea').get(0);
		THK_SELECTED_RANGE = ta.value.substring( ta.selectionStart, ta.selectionEnd );
	}
};
</script>
