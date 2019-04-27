/*! Luxeritas WordPress Theme - free/libre wordpress platform
 *
 * @copyright Copyright (C) 2015 Thought is free.
 * @link https://thk.kanzae.net/
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPL v2 or later
 * @author LunaNuko
 */

/*
-------------------------------------------------------
 ログイン時に管理バーが見えてる時の位置調整用スクリプト
------------------------------------------------------- */
if( typeof( document.getElementsByClassName ) === 'undefined' ){
	document.getElementsByClassName = function(t){
		var elems = new Array();
		if( document.all ) {
			var allelem = document.all;
		} else {
			var allelem = document.getElementsByTagName("*");
		} for( var i = j = 0, l = allelem.length; i < l; i++ ) {
			var names = allelem[i].className.split( /\s/ );
			for( var k = names.length - 1; k >= 0; k-- ) {
				if( names[k] === t ) {
					elems[j] = allelem[i];
					j++;
					break;
				}
			}
		}
		return elems;
	};
}

function adbarPosition() {
	var adBarEl
	,   adBarHt
	,   adBarBg
	,   bandClasses;

	adBarElm = document.getElementById('wpadminbar');
	adBarHt = adBarElm.offsetHeight;

	if( typeof window.getComputedStyle !== 'undefined' ) {
		if( document.getElementById('wp-admin-bar-top-secondary') !== null ) {
			adBarBg = window.getComputedStyle(adBarElm).backgroundColor;
			document.getElementById('wp-admin-bar-top-secondary').style.backgroundColor = adBarBg;
		}
	}

	bandClasses = document.getElementsByClassName('band');
	if( bandClasses.length > 0 ) {
		bandClasses[0].style.top = adBarHt + 'px';
	}
}

if( document.getElementById('wpadminbar') !== null ) {
	var bandResize
	,   bandTimeId = null;

	adbarPosition();

	bandResize = ('resize', function() {
		if( bandTimeId === null ) {
			bandTimeId = setTimeout( function() {
				adbarPosition();
				bandTimeId = null;
			}, 200 );
		}
	});

	if( typeof window.addEventListener !== 'undefined' ) {
		window.addEventListener( 'resize', bandResize, false );
	} else if( typeof window.attachEvent !== 'undefined' ) {
		window.attachEvent( 'onresize', bandResize );
	}
}
