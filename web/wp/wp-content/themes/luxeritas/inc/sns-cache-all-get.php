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

class sns_cache_all_get {
	public function __construct() {
	}

	public function sns_cache_list() {
		$id_array = array( -99, -100 );

		$query = new WP_Query( array(
			'posts_per_page'	=> -1,	// 全件
			'post_type'		=> array( 'post', 'page'),
			'orderby'		=> 'ID',
			'order'			=> 'DESC',
			'post_status'		=> 'publish'
		));

		// 投稿・固定ページ取得
		while( $query->have_posts() ) {
			$query->the_post();
			$id_array[] = get_the_ID();
		}
		$ids = implode( ',', $id_array );
		$post_count = count( $id_array );
		unset( $query, $id_array );

		add_action( 'admin_head', function() use( $ids, $post_count ) {
			$security = 'luxe_reget_sns';
			$ajax_nonce = wp_create_nonce( $security );
?>
<script>
jQuery(document).ready(function($){
	var ids = [<?php echo $ids; ?>];
	var icount = 1;
	var post_count = <?php echo $post_count; ?>;
	var snsLog = $('#log-view');
	var snsItm = $('#post-items');
	var snsPrg = $('#progress');
	snsLog.append( '<?php echo __( 'Processing started.', 'luxeritas' ), "\\n---\\n"; ?>' );

	function RegetProcess() {
		++icount;
		if( icount > post_count ) {
			snsItm.text( post_count + ' / ' + post_count );
			snsPrg.css( 'width', '100%' );
			snsPrg.css( 'background', '#b3d39b' );
			snsLog.append( '<?php echo "---\\n", __( 'Processing is completed', 'luxeritas' ), "\\n"; ?>' );
			snsLog.scrollTop( snsLog[0].scrollHeight );
		} else {
			RegetSns(ids.shift());
		}
	}

	function RegetSns(id) {
		$.ajax({
			type: 'POST',
			cache: false,
			url: ajaxurl,
			data: {action:'regetsnscount', id:id, <?php echo $security; ?>:true, luxe_nonce:'<?php echo $ajax_nonce; ?>' },
			success: function(response) {
				snsItm.text( icount + ' / ' + post_count + ' ( ' + Math.floor( icount / post_count * 100 * Math.pow( 10, 2 ) ) / Math.pow( 10, 2 ) + '% )' );
				snsPrg.css( 'width', Math.floor( icount * 100 / post_count * Math.pow( 10, 1 ) ) / Math.pow( 10, 1 ) + '%' );
				snsLog.append( response + "\n" );
				snsLog.scrollTop( snsLog[0].scrollHeight );
				RegetProcess();
			},
			error: function(response) {
				RegetProcess();
			}
		});
	}

	RegetSns(ids.shift());
});
</script>
<?php
		}, 97 );
	}
}
