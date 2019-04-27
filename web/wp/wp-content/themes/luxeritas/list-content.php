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

require( INC . 'add-shortcode.php' );
?>
<div class="post" itemprop="headline name">
<?php
if( is_search() === true && isset( $luxe['search_extract'] ) && $luxe['search_extract'] === 'word' ) {
	echo thk_search_excerpt();
}
else {
	the_content();	// 記事全文表示
}
?>
</div><!--/.post-->
<p class="read-more"><?php
	// 記事を読むリンク
	if( !empty( $luxe['read_more_text'] ) ) {
		$length = isset( $luxe['short_title_length'] ) ? $luxe['short_title_length'] : 0;
?><a href="<?php the_permalink(); ?>" class="read-more-link" aria-hidden="true" itemprop="url"><?php echo ( isset( $luxe['read_more_short_title'] ) ) ? read_more_title_add( $luxe['read_more_text'], $length ) : $luxe['read_more_text']; // 記事を読むリンク ?></a><?php
	}
?></p>
