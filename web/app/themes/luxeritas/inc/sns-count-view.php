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

class cache_control {
	private $_active	= 'sns_post';
	private $_tabs		= array();
	private $_query		= array();
	private $_idarray	= array( 'f' => '!', 'g' => '!', 'l' => '!', 't' => '!', 'h' => '!', 'p' => '!' );

	public function __construct() {
		if( defined( 'TURI' ) === false ) define( 'TURI', get_template_directory_uri() );
		$this->_active = isset( $_GET['active'] ) ? $_GET['active'] : 'sns_post';

		/* ページング用 */
		$paged  = isset( $_GET['paged'] ) ? absint( $_GET['paged'] ) : 1;
		$post_type = $this->_active === 'sns_page' ? 'page' : 'post';

		$args = array(
			'posts_per_page'	=> 30,		// 表示件数
			'paged'			=> $paged,
			'orderby'		=> 'post_date',
			'order'			=> 'DESC',
			'post_type'		=> $post_type,
			'post_status'		=> 'publish'
		);
		$this->_query = new WP_Query( $args );
	}

	public function sns_cache_list() {
		$luxe = null;

		/* SNS カウント数取得 */
		require_once( INC . 'optimize.php' );
		require_once( INC . 'filters.php' );

		global $luxe, $wp_filesystem;

		$filesystem = new thk_filesystem();
		if( $filesystem->init_filesystem( site_url() ) === false ) return false;

		$wp_upload_dir = wp_upload_dir();
		$cache_dir = $wp_upload_dir['basedir'] . '/luxe-sns/';

		$cache_content = array();
		$dirlist = $wp_filesystem->dirlist( $cache_dir );

		$no_img_url = get_theme_mod( 'no_img', null );

		foreach( (array)$dirlist as $filename => $fileinfo ) {
			$content = $wp_filesystem->get_contents( $cache_dir . $filename );
			$cache_array = explode( "\n", $content );
			while( count( $cache_array ) > 7 ) {
				array_pop( $cache_array );
			}
			$url = array_shift( $cache_array );
			$cache_content[$url] = $cache_array;
		}
?>
<div class="tops">
<?php if( $this->_active !== 'sns_home' ) $this->sns_view_pagination(); ?>
</div>
<table class="sns-count-view thead">
<thead>
<th><?php echo $this->_active === 'sns_home' ? 'Feedly' : __( 'Published date', 'luxeritas' ); ?></th>
<th>Facebook</th>
<th>Google+</th>
<th>LinkedIn</th>
<th>Pinterest</th>
<th>Hatena</th>
<th>Pocket</th>
</thead>
</table>
<?php
		$i = 1;
		$eve = '';
		$str_length = '60';

		if( $this->_query->have_posts() ) {
			$no_img_url = get_theme_mod( 'no_img', null );

			while( $this->_query->have_posts() ) {
				$this->_query->the_post();

				$eve = $i % 2 === 0 ? ' eve' : '';
?>
<table class="upper sns-count-view<?php echo $eve; ?>">
<tbody>
<tr>
<td class="thumb">
<?php
				$permalink = $this->_active === 'sns_home' ? THK_HOME_URL : get_permalink();
				$permalink_view = $permalink;
				if( strlen( $permalink ) >= $str_length ) {
					$permalink_view = mb_strimwidth( $permalink, 0, $str_length ) . "...";
				}

				$attachment_id = false;
				$post_thumbnail = has_post_thumbnail();

				if( $post_thumbnail === false && isset( $no_img_url ) ) {
					$attachment_id = thk_get_image_id_from_url( $no_img_url );
					if( $attachment_id !== false ) $post_thumbnail = true;
				}

				if( $post_thumbnail === true ) {
?>
<a href="<?php echo $permalink; ?>" target="_blank"><?php
					if( $attachment_id !== false ) {
						echo wp_get_attachment_image( $attachment_id, 'thumbnail', array() );
					}
					else {
						the_post_thumbnail( 'thumbnail', array() );
					}
?></a>
<?php
				}
				else {
?>
<a href="<?php echo $permalink; ?>" target="_blank"><img src="<?php echo TURI; ?>/images/no-img-75x75.png" class="thumbnail" alt="No Image" title="No Image" width="75" height="75" /></a>
<?php
				}
?>
</td>
<td class="left">
<p><a href="<?php echo $permalink; ?>" target="_blank"><?php echo $permalink_view; ?></a></p>
<p><?php  $this->_active === 'sns_home' ? bloginfo('name') : the_title(); ?></p>
</td>
</tr>
</tbody>
</table>

<table class="lower sns-count-view<?php echo $eve; ?>">
<tbody>
<tr>
<?php
				if( $this->_active === 'sns_home' ) {
					$feedly = 'No cache';
					if( isset( $cache_content[esc_url( get_bloginfo( 'rss2_url' ) )][0] ) ) {
						$cnt = $cache_content[esc_url( get_bloginfo( 'rss2_url' ) )][0];
						$feed_cnt = substr( $cnt, 2, strlen( $cnt ) - 2 );
						$feed_cnt = apply_filters( 'thk_sns_count', $feed_cnt, 'r', $permalink );
						$feedly = $feed_cnt . '</td>';
					}
					$feedly_icon = 	'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAA'.
							'BUAAAAVAgMAAADUeU0FAAAAA3NCSVQICAjb4U/gAAAADFBM'.
							'VEWHvDeqxWDY8vX+/f2WF/1ZAAAABHRSTlP///8AQCqp9AA'.
							'AAFNJREFUCJlj+A8CBxjQqacQakI9iPrnIA+ifrKyg6gnco'.
							'wgakIlQ/0Bhn+OTxjkDzD8ZZ/FwA6k2PJA1D+HHSDB/xMCQ'.
							'Er+P+FjRNIONQy7tSAKAFDeWpJacCTqAAAAAElFTkSuQmCC';
?>
<td class="r-icon" style="background: url('<?php echo $feedly_icon; ?>') 10px 4px no-repeat;"><?php echo $feedly; ?></td>
<?php
				}
				else {
?>
<td class="post-date" style="white-space:nowrap"><?php echo get_the_date(); ?></td>
<?php
				}

				if( isset( $cache_content[$permalink] ) ) {
					$cache_count_array = array();
					foreach( $cache_content[$permalink] as $val ) {
						if( isset( $val[0] ) ) {
							$cache_count_array[$val[0]] = ltrim( strstr( $val, ':' ), ':' );
						}
					}
					$cache_count_array = wp_parse_args( $cache_count_array, $this->_idarray );

					foreach( $cache_count_array as $key => $val ) {
						if( $key === 'f' ) {
							$cnt = '<td class="f-icon">';
						}
						elseif( $key === 'g' ) {
							$cnt = '<td class="g-icon">';
						}
						elseif( $key === 'h' ) {
							$cnt = '<td class="h-icon">';
						}
						elseif( $key === 'l' ) {
							$cnt = '<td class="l-icon">';
						}
						elseif( $key === 't' ) {
							$cnt = '<td class="t-icon">';
						}
						elseif( $key === 'p' ) {
							$cnt = '<td class="p-icon">';
						}
						else {
							echo '<td class="alert-icon">!</td>';
							continue;
						}

						if( ctype_digit( $val ) === true ) {
							echo $cnt, apply_filters( 'thk_sns_count', $val, $key, $permalink ), '</td>';
						}
						else {
							echo '<td class="alert-icon">!</td>';
						}
					}
				}
				else {
					echo '<td colspan="' . count( $this->_idarray ) . '">' . __( 'Not cached', 'luxeritas' ) . '</td>';
				}
?>
</tr>
</tbody>
</table>
<?php
				++$i;
				if( $this->_active === 'sns_home' ) return;
			}
		}
		$this->sns_view_pagination();
	}

	/* ページング */
	public function sns_view_pagination() {
		$paged  = isset( $_GET['paged'] ) ? absint( $_GET['paged'] ) : 1;
		$posts_per_page = $this->_query->get( 'posts_per_page' );

		if( ( !$paged || $paged < 2 ) && $this->_query->found_posts < $posts_per_page ) return;

		$range = 3; //表示する件数
		$showitems = ( $range * 2 ) + 1;

		if( empty( $paged ) ) $paged = 1;

		$pages = $this->_query->max_num_pages;
		if( empty( $pages ) ) $pages = 1;

		if( $pages !== 1 ) {
?>
<div id="paging">
<nav>
<ul class="pagination">
<?php
			if( $paged > 2 && $paged > $range+1 && $showitems < $pages ) {
?>
<li><a href="<?php echo get_pagenum_link( 1 ); ?>">&laquo;</a></li>
<?php
			}
			if( $paged > 1 && $showitems < $pages ) {
?>
<li><a href="<?php echo get_pagenum_link( $paged - 1 ); ?>">&lsaquo;</a></li>
<?php
			}
			for( $i = 1; $i <= $pages; $i++ ) {
				if( $pages !== 1 &&( !( $i >= $paged+$range+1 || $i <= $paged - $range -1 ) || $pages <= $showitems ) ) {
					if( $paged == $i ) {
?>
<li class="active"><span class="current"><?php echo $i; ?></span></li>
<?php
					}
					else {
?>
<li><a href="<?php echo get_pagenum_link( $i ); ?>" class="inactive"><?php echo $i; ?></a></li>
<?php
					}
				}
			}
			if( $paged < $pages && $showitems < $pages ) {
?>
<li><a href="<?php echo get_pagenum_link( $paged + 1 ); ?>">&rsaquo;</a></li>
<?php
			}
			if( $paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages ) {
?>
<li><a href="<?php echo get_pagenum_link( $pages ); ?>">&raquo;</a></li>
<?php
			}
?>
</ul>
</nav>
</div>
<?php
		}
	}
}
