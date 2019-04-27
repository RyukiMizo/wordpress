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

if( function_exists('thk_http_response_code') === false ):
function thk_http_response_code( $code = null ) {
	$ret = 'Unknown http status code';

	if( is_numeric( $code ) === true ) {
		$t = (string)$code;

		if( $t[0] === '1' ) {
			switch( $code ) {
				case 100: $ret = 'Continue'; break;
				case 101: $ret = 'Switching Protocols'; break;
				case 102: $ret = 'Processing'; break;
				default: break;
			}
		}
		elseif( $t[0] === '2' ) {
			switch( $code ) {
				case 200: $ret = 'OK'; break;
				case 201: $ret = 'Created'; break;
				case 202: $ret = 'Accepted'; break;
				case 203: $ret = 'Non-Authoritative Information'; break;
				case 204: $ret = 'No Content'; break;
				case 205: $ret = 'Reset Content'; break;
				case 206: $ret = 'Partial Content'; break;
				case 207: $ret = 'Multi-Status'; break;
				case 208: $ret = 'Already Reported'; break;
				case 226: $ret = 'IM Used'; break;
				default: break;
			}
		}
		elseif( $t[0] === '3' ) {
			switch( $code ) {
				case 300: $ret = 'Multiple Choices'; break;
				case 301: $ret = 'Moved Permanently'; break;
				case 302: $ret = 'Moved Temporarily'; break;
				case 303: $ret = 'See Other'; break;
				case 304: $ret = 'Not Modified'; break;
				case 305: $ret = 'Use Proxy'; break;
				case 306: $ret = 'Switch Proxy'; break;
				case 307: $ret = 'Temporary Redirect'; break;
				case 308: $ret = 'Permanent Redirect'; break;
				default: break;
			}
		}
		elseif( $t[0] === '4' ) {
			switch( $code ) {
				case 400: $ret = 'Bad Request'; break;
				case 401: $ret = 'Unauthorized'; break;
				case 402: $ret = 'Payment Required'; break;
				case 403: $ret = 'Forbidden'; break;
				case 404: $ret = 'Not Found'; break;
				case 405: $ret = 'Method Not Allowed'; break;
				case 406: $ret = 'Not Acceptable'; break;
				case 407: $ret = 'Proxy Authentication Required'; break;
				case 408: $ret = 'Request Time-out'; break;
				case 409: $ret = 'Conflict'; break;
				case 410: $ret = 'Gone'; break;
				case 411: $ret = 'Length Required'; break;
				case 412: $ret = 'Precondition Failed'; break;
				case 413: $ret = 'Request Entity Too Large'; break;
				case 414: $ret = 'Request-URI Too Large'; break;
				case 415: $ret = 'Unsupported Media Type'; break;
				case 416: $ret = 'Range Not Satisfiable'; break;
				case 417: $ret = 'Expectation Failed'; break;
				case 418: $ret = "I'm a teapot"; break;
				case 421: $ret = 'Misdirected Request'; break;
				case 422: $ret = 'Unprocessable Entity'; break;
				case 423: $ret = 'Locked'; break;
				case 424: $ret = 'Failed Dependency'; break;
				case 426: $ret = 'Upgrade Required'; break;
				case 428: $ret = 'Precondition Required'; break;
				case 429: $ret = 'Too Many Requests'; break;
				case 431: $ret = 'Request Header Fields Too Large'; break;
				case 451: $ret = 'Unavailable For Legal Reasons'; break;
				default: break;
			}
		}
		elseif( $t[0] === '5' ) {
			switch( $code ) {
				case 500: $ret = 'Internal Server Error'; break;
				case 501: $ret = 'Not Implemented'; break;
				case 502: $ret = 'Bad Gateway'; break;
				case 503: $ret = 'Service Unavailable'; break;
				case 504: $ret = 'Gateway Time-out'; break;
				case 505: $ret = 'HTTP Version not supported'; break;
				case 506: $ret = 'Variant Also Negotiates'; break;
				case 507: $ret = 'Insufficient Storage'; break;
				case 508: $ret = 'Loop Detected'; break;
				case 510: $ret = 'Not Extended'; break;
				case 511: $ret = 'Network Authentication Required'; break;
				default: break;
			}
		}
	}
	return $ret;
}
endif;
