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

class create_pwd_files {
	public function __construct() {
	}

	public function create_manifest() {
		global $luxe;

		require( INC . 'locale.php' );
		$getlocale = new thk_locale();
		$locale = $getlocale->thk_locale_wp_2_ogp( get_locale() );

		$start_url_id = 0;
		$home_url = home_url('/');
		$show_on_front = get_option( 'show_on_front' );

		if( $show_on_front === 'page' ) {
			$start_url_id = get_option( 'page_on_front' );
		}

		$start_url = $home_url;

		if( isset( $luxe['pwa_start_url'] ) && $luxe['pwa_start_url'] !== $start_url_id ) {
			$start_url = isset( $luxe['pwa_start_url'] ) ? get_permalink( $luxe['pwa_start_url'] ) : '';
		}
		if( empty( $start_url ) )  {
			$start_url = $home_url;
		}

		$manifest = array();
		$manifest['name']		= isset( $luxe['pwa_name'] ) ? $luxe['pwa_name'] : get_bloginfo('name');
		$manifest['short_name']		= isset( $luxe['pwa_short_name'] ) ? $luxe['pwa_short_name'] : $manifest['name'];
		$manifest['description']	= isset( $luxe['pwa_description'] ) ? $luxe['pwa_description'] : get_bloginfo( 'description' );
		$manifest['start_url']		= $start_url;
		$manifest['display']		= isset( $luxe['pwa_display'] ) ? $luxe['pwa_display'] : 'minimal-ui';
		$manifest['lang']		= $locale;
		$manifest['dir']		= 'auto';
		$manifest['orientation']	= isset( $luxe['pwa_orientation'] ) ? $luxe['pwa_orientation'] : 'any';
		$manifest['background_color']	= isset( $luxe['pwa_bg_color'] ) ? $luxe['pwa_bg_color'] : '#ffffff';
		$manifest['theme_color']	= isset( $luxe['pwa_theme_color'] ) ? $luxe['pwa_theme_color'] : '#4285f4';
		$manifest['icons']		= array();

		$icon_32 = get_site_icon_url( 32 );
		if( !empty( $icon_32 ) ) {
			$ftype = wp_check_filetype( $icon_32 );
			$type = isset( $ftype['type'] ) && $ftype['type'] !== false ? $ftype['type'] : $this->get_mime_type_from_extension( $icon_32 );
			$manifest['icons'][] = array(
				'src'	=> $icon_32,
				'type'	=> $type,
				'sizes'	=> '32x32'
			);
		}
		$icon_150 = get_site_icon_url( 150 );
		if( !empty( $icon_150 ) ) {
			$ftype = wp_check_filetype( $icon_150 );
			$type = isset( $ftype['type'] ) && $ftype['type'] !== false ? $ftype['type'] : $this->get_mime_type_from_extension( $icon_150 );
			$manifest['icons'][] = array(
				'src'	=> $icon_150,
				'type'	=> $type,
				'sizes'	=> '150x150'
			);
		}
		$icon_192 = get_site_icon_url( 192 );
		if( !empty( $icon_192 ) ) {
			$ftype = wp_check_filetype( $icon_192 );
			$type = isset( $ftype['type'] ) && $ftype['type'] !== false ? $ftype['type'] : $this->get_mime_type_from_extension( $icon_192 );
			$manifest['icons'][] = array(
				'src'	=> $icon_192,
				'type'	=> $type,
				'sizes'	=> '192x192'
			);
		}
		else {
			$manifest['icons'][] = array(
				'src'	=> TURI . '/images/icon-192x192.png',
				'type'	=> 'image/png',
				'sizes'	=> '192x192'
			);
		}
		$icon_270 = get_site_icon_url( 270 );
		if( !empty( $icon_270 ) ) {
			$ftype = wp_check_filetype( $icon_270 );
			$type = isset( $ftype['type'] ) && $ftype['type'] !== false ? $ftype['type'] : $this->get_mime_type_from_extension( $icon_270 );
			$manifest['icons'][] = array(
				'src'	=> $icon_270,
				'type'	=> $type,
				'sizes'	=> '270x270'
			);
		}
		$icon_512 = get_site_icon_url( 512 );
		if( !empty( $icon_512 ) ) {
			$ftype = wp_check_filetype( $icon_512 );
			$type = isset( $ftype['type'] ) && $ftype['type'] !== false ? $ftype['type'] : $this->get_mime_type_from_extension( $icon_512 );
			$manifest['icons'][] = array(
				'src'	=> $icon_512,
				'type'	=> $type,
				'sizes'	=> '512x512'
			);
		}
		else {
			$manifest['icons'][] = array(
				'src'	=> TURI . '/images/icon-512x512.png',
				'type'	=> 'image/png',
				'sizes'	=> '512x512'
			);
		}

		$ret = json_encode( $manifest );

		if( $ret === false ) $ret = '';

		return $ret;
	}

	public function create_service_worker() {
		global $luxe;

		if( !isset( $luxe['pwa_offline_enable'] ) ) {
			return 'console.log( "PWA: not allow cache and offline" );';
		}

		$start_url_id = 0;
		$home_url = home_url('/');
		$show_on_front = get_option( 'show_on_front' );

		if( $show_on_front === 'page' ) {
			$start_url_id = $show_on_front;
		}


		$start_url = $home_url;

		if( isset( $luxe['pwa_start_url'] ) && $luxe['pwa_start_url'] !== $start_url_id ) {
			$start_url = isset( $luxe['pwa_start_url'] ) ? get_permalink( $luxe['pwa_start_url'] ) : '';
		}
		if( empty( $start_url ) )  {
			$start_url = $home_url;
		}

		$offline_url = $home_url;

		if( isset( $luxe['pwa_offline_page'] ) && $luxe['pwa_offline_page'] !== $start_url_id ) {
			$offline_url = isset( $luxe['pwa_offline_page'] ) ? get_permalink( $luxe['pwa_offline_page'] ) : '';
		}
		if( empty( $offline_url ) )  {
			$offline_url = $home_url;
		}

		$icon_192 = get_site_icon_url( 192 );
		if( empty( $icon_192 ) ) $icon_192 = TURI . '/images/icon-192x192.png';

		$ver = '';
		$curent = wp_get_theme();
		if( TPATH !== SPATH ) {
			$parent = wp_get_theme( $curent->get('Template') );
			$ver = $parent->get('Version');
		}
		else {
			$ver = $curent->get('Version');
		}

		$ret = <<< SCRIPT
(function() {
	"use strict";
	var c = "Luxeritas {$ver} PWA - {$_SERVER['SERVER_NAME']}"
	,   s = "{$start_url}"
	,   o = "{$offline_url}"
	,   i = "{$icon_192}"
	,   f = [ s, o, i ]
	,   n = [ /\/wp-admin/, /\/wp-login/, /preview=true/ ];

	function r(e) {
		return !this.match(e)
	}

	// Install
	try {
		self.addEventListener("install", function(e) {
			console.log("PWA: service worker installation"), e.waitUntil(
				caches.open(c).then(function(e) {
					return console.log("PWA: service worker caching dependencies");
					f.map(function(s) {
						return cache.add(s).catch(function (r) {
							return console.log('PWA: ' + String(r) + ' ' + s);
						});
					});
				})
			)
		});
	} catch (e) {
		console.error("pwa.install.error: " + e.message)
	}

	// Activate
	try {
		self.addEventListener("activate", function(e) {
			return console.log("PWA: service worker activation"), e.waitUntil(caches.keys().then(function(l) {
				return Promise.all(l.map(function(k) {
					if (k !== c) return console.log("PWA: old cache removed", k), caches.delete(k)
				}))
			})), self.clients.claim()
		});
	} catch (e) {
		console.error("pwa.activate.error: " + e.message)
	}

	// Fetch
	try {
		self.addEventListener("fetch", function(e) {
			n.every(r, e.request.url) ? e.request.url.match(/^(http|https):\/\//i) && new URL(e.request.url).origin === location.origin && ("GET" === e.request.method ? "navigate" === e.request.mode && navigator.onLine ? e.respondWith(fetch(e.request).then(function(t) {
				return caches.open(c).then(function(a) {
					return a.put(e.request, t.clone()), t
				})
			})) : e.respondWith(caches.match(e.request).then(function(t) {
				return t || fetch(e.request).then(function(t) {
					return caches.open(c).then(function(a) {
						return a.put(e.request, t.clone()), t
					})
				})
			}).catch(function() {
				return caches.match(o)
			})) : e.respondWith(fetch(e.request).catch(function() {
				return caches.match(o)
			}))) : console.log("PWA: Current request is excluded from cache.")
		});
	} catch (e) {
		console.error("pwa.fetch.error: " + e.message)
	}
})();

SCRIPT;
		return $ret;
	}

	public function create_register_service_worker() {
		global $luxe;

		$serviceworker_script = home_url('/') . 'luxe-serviceworker.js';

		$ret = <<< SCRIPT
try {
	"serviceWorker" in navigator && window.addEventListener("load", function() {
		navigator.serviceWorker.register("{$serviceworker_script}").then(function(e) {
			console.log("PWA: service worker registered"), e.update()
		}).catch(function(e) {
			console.log("PWA: registration failed with " + e)
		}), window.addEventListener("beforeinstallprompt", function(e) {

SCRIPT;
		if( isset( $luxe['pwa_install_button'] ) ) {
			$ret .= 'console.log("PWA: beforeinstallprompt Event fired"), e.prompt()' . "\n";
		}
		else {
			$ret .= 'console.log("PWA: beforeinstallprompt Event prevented"), e.preventDefault(), !1' . "\n";
		}

		$ret .= <<< SCRIPT
		})
	})
} catch (e) {}

SCRIPT;
		return $ret;
	}

	public function get_mime_type_from_extension( $img ) {
		$ret  = 'image/png';
		$info = pathinfo( $img );

		if( !empty( $info['extension'] ) ) {
			$ext = $info['extension'];
			$extensions = array( 'png' => true, 'jpeg' => true, 'jpe' => true, 'jpg' => true, 'gif' => true, 'webp' => true, 'bmp' => true, 'ico' => true, 'svg' => true );

			if( !isset( $extensions[$ext] ) ) {
				if( stripos( $ext, '?' ) !== false ) {
					$ext = substr( $ext, 0, stripos( $ext, '?' ) );
				}
				else {
					$ext = preg_replace( '/([a-zA-Z]+).*/i', '$1', $ext );
				}
			}
			if( isset( $extensions[$ext] ) ) {
				if( $ext === 'svg' ) $ext = 'svg+xml';
				$ret = 'image/' . $ext;
			}
		}
		return $ret;
	}
}
