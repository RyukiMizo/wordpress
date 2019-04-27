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

class thk_regenerate_thumbs {
	public function __construct() {
	}

	public function regen_thumbs() {
		$get_posts = get_posts( array(
			'posts_per_page'	=> -1,	// 全件
			'post_type'		=> 'attachment',
			'orderby'		=> 'ID',
			'order'			=> 'DESC',
			'post_status'		=> null,
			'post_parent'		=> null
		));
		$attachments = array();
		$ids = '';

		foreach( $get_posts as $val ) {
			if( stripos( $val->post_mime_type, 'image/' ) === 0 ) {
				$attachments[] = $val->ID;
			}
		}
		unset( $get_posts );

		$attachments = array_unique( $attachments );
		$post_count = count( $attachments );

		if( !empty( $attachments ) ) {
			$ids = implode( ',', $attachments );
			add_action( 'admin_head', function() use( $ids, $post_count ) {
				$security = 'luxe_regen_thumb';
				$ajax_nonce = wp_create_nonce( $security );
?>
<script>
jQuery(document).ready(function($){
	var ids = [<?php echo $ids; ?>];
	var icount = 1;
	var post_count = <?php echo $post_count; ?>;
	var regenLog = $('#log-view');
	var regenItm = $('#post-items');
	var regenPrg = $('#progress');
	regenLog.append( '<?php echo __( 'Processing started.', 'luxeritas' ), "\\n---\\n"; ?>' );

	function RegenProcess() {
		++icount;
		if( icount > post_count ) {
			regenItm.text( post_count + ' / ' + post_count );
			regenPrg.css( 'width', '100%' );
			regenPrg.css( 'background', '#b3d39b' );
			regenLog.append( '<?php echo "---\\n", __( 'Processing is completed', 'luxeritas' ), "\\n"; ?>' );
			regenLog.scrollTop( regenLog[0].scrollHeight );
		} else {
			RegenThumbs(ids.shift());
		}
	}

	function RegenThumbs(id) {
		$.ajax({
			type: 'POST',
			cache: false,
			url: ajaxurl,
			data: {action:'regeneratethumbnail', id:id, <?php echo $security; ?>:1, luxe_nonce:'<?php echo $ajax_nonce; ?>', del:<?php echo isset( $_POST['thumb_delete'] ) ? 1 : 0; ?> },
			success: function( response ) {
				regenItm.text( icount + ' / ' + post_count + ' ( ' + Math.floor( icount / post_count * 100 * Math.pow( 10, 2 ) ) / Math.pow( 10, 2 ) + '% )' );
				regenPrg.css( 'width', Math.floor( icount * 100 / post_count * Math.pow( 10, 1 ) ) / Math.pow( 10, 1 ) + '%' );
				regenLog.append( response + "\n" );
				regenLog.scrollTop( regenLog[0].scrollHeight );
				RegenProcess();
			},
			error: function( response ) {
				RegenProcess();
			}
		});
	}

	RegenThumbs(ids.shift());
});
</script>
<?php
			}, 97 );
		}
	}
}
