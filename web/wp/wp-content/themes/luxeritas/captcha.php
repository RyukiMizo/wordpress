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

if(
	!isset( $_SERVER['HTTP_REFERER'] ) ||
	( isset( $_SERVER['HTTP_REFERER'] ) && stripos( $_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST'] ) === false )
) {
	$func = 'base' . '64' . '_decode';
	header("Content-type: image/gif");
	echo $func('R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==');
	exit;
}

/**
 * Project:     Securimage: A PHP class for creating and managing form CAPTCHA images<br />
 * File:        securimage_show.php<br />
 *
 * Copyright (c) 2013, Drew Phillips
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 *
 *  - Redistributions of source code must retain the above copyright notice,
 *    this list of conditions and the following disclaimer.
 *  - Redistributions in binary form must reproduce the above copyright notice,
 *    this list of conditions and the following disclaimer in the documentation
 *    and/or other materials provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * Any modifications to the library should be indicated clearly in the source code
 * to inform users that the changes are not a part of the original software.<br /><br />
 *
 * If you found this script useful, please take a quick moment to rate it.<br />
 * http://www.hotscripts.com/rate/49400.html  Thanks.
 *
 * @link http://www.phpcaptcha.org Securimage PHP CAPTCHA
 * @link http://www.phpcaptcha.org/latest.zip Download Latest Version
 * @link http://www.phpcaptcha.org/Securimage_Docs/ Online Documentation
 * @copyright 2013 Drew Phillips
 * @author Drew Phillips <drew@drew-phillips.com>
 * @version 3.5.2 (Feb 15, 2014)
 * @package Securimage
 *
 */

require_once dirname(__FILE__) . '/securimage/securimage.php';

$img = new Securimage();

$img->use_transparent_text = false;
$img->text_transparency_percentage = 0;
$img->image_type = 2;

$img->image_width	= isset( $_GET['iw'] ) ? $_GET['iw'] : 170;
$img->image_height	= isset( $_GET['ih'] ) ? $_GET['ih'] : 45;

$captcha_start_length	= isset( $_GET['sl'] ) ? $_GET['sl'] : 4;
$captcha_end_length	= isset( $_GET['el'] ) ? $_GET['el'] : 6;
$img->code_length	= rand( $captcha_start_length, $captcha_end_length );

$img->font_ratio	= isset( $_GET['fr'] ) && is_numeric( $_GET['fr'] ) === true ? $_GET['fr'] : 75;
if( $img->font_ratio == 0 ) {
	$img->font_ratio = 0.1;
}
if( $img->font_ratio == 100 ) {
	$img->font_ratio = 0.99;
}
else{
	$img->font_ratio = $img->font_ratio / 100;
}

$text_color		= isset( $_GET['cl'] ) ? '#' . $_GET['cl'] : '#000000';
$image_bg_color		= isset( $_GET['bg'] ) ? '#' . $_GET['bg'] : '#d3d3d3';
$img->text_color	= new Securimage_Color( $text_color );
$img->image_bg_color	= new Securimage_Color( $image_bg_color );

$img->perturbation	= isset( $_GET['pb'] ) && is_numeric( $_GET['pb'] ) === true ? $_GET['pb'] / 100 : 0.75;
$img->noise_level	= isset( $_GET['nl'] ) && is_numeric( $_GET['nl'] ) === true ? round( $_GET['nl'] / 10 ) : 6;

$noise_color		= isset( $_GET['nc'] ) ? '#' . $_GET['nc'] : '#808080';
$img->noise_color	= new Securimage_Color( $noise_color );

$img->num_lines		= isset( $_GET['ln'] ) ? $_GET['ln'] : 0;

$line_color		= isset( $_GET['lc'] ) ? '#' . $_GET['lc'] : '#f5f5f5';
$img->line_color	= new Securimage_Color( $line_color );

if( isset( $_GET['ch'] ) ) {
	switch( $_GET['ch'] ) {
		case 'numeric':
			$img->charset = '0123456789';
			break;
		case 'alpha':
			$img->charset = 'abcdefghklmnopqrstuvwyzABCDEFGHIJKLMNPQRSTUVWXYZ';
			break;
		case 'alpha_upper':
			$img->charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
			break;
		case 'alpha_lower':
			$img->charset = 'abcdefghklmnopqrstuvwyz';
			break;
		case 'alphanum':
			$img->charset = 'abcdefghkmnprstuvwyzABCDEFGHIJKLMNPQRSTUVWXYZ23456789';
			break;
		case 'alphanum_upper':
			$img->charset = 'ABCDEFGHIJKLMNPQRSTUVWXYZ23456789';
			break;
		case 'alphanum_lower':
		default:
			$img->charset = 'abcdefghkmnprstuvwyz23456789';
			break;
	}
}

$img->show();  // outputs the image and content headers to the browser
