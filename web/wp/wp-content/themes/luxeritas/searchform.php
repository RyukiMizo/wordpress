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

global $luxe;
?>
<div id="search" itemscope itemtype="http://schema.org/WebSite">
<meta itemprop="url" content="<?php echo THK_HOME_URL; ?>"/>
<form itemprop="potentialAction" itemscope itemtype="http://schema.org/SearchAction" method="get" class="search-form" action="<?php echo THK_HOME_URL; ?>"<?php if( isset( $luxe['add_role_attribute'] ) ) echo ' role="search"'; ?>>
<meta itemprop="target" content="<?php echo THK_HOME_URL; ?>?s={s}"/>
<label>
<input itemprop="query-input" type="search" class="search-field" placeholder="<?php echo __( 'Search for', 'luxeritas' ); ?>" value="<?php echo get_search_query() ?>" name="s" title="<?php echo esc_attr( __( 'Search for', 'luxeritas' ) ); ?>" required />
</label>
<input type="submit" class="search-submit" value="<?php echo esc_attr( __( 'Search', 'luxeritas' ) ); ?>" />
</form>
</div>
