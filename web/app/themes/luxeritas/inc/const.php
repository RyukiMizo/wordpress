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

define( 'THK_HOME_URL',	home_url('/') );
define( 'THK_HOME_PATH', thk_get_home_path() );
define( 'THK_SITENAME',	get_bloginfo( 'name' ) );
define( 'THK_DESCRIPTION', get_bloginfo( 'description' ) );
define( 'TURI', get_template_directory_uri() );
define( 'TDEL', pdel( TURI ) );
define( 'SURI', get_stylesheet_directory_uri() );
define( 'SDEL', pdel( SURI ) );
const THK_COPY = 'https://thk.kanzae.net/';
