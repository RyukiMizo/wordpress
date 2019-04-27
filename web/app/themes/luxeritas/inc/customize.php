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

class luxe_customize {
	private $_active	= '';
	private $_page		= '';
	private $_tabs		= array();

	public function __construct() {
	}

	public function luxe_custom_form() {
		$this->_page = isset( $_GET['page'] ) ? $_GET['page'] : 'luxe';

		echo '<div class="wrap narrow">';

		if( $this->_page === 'luxe' ) {
			$this->_active = isset( $_GET['active'] ) ? $_GET['active'] : 'seo';

			$this->_tabs = array(
				'seo'		=> 'SEO',
				'ogp'		=> 'OGP',
				'title'		=> __( 'Title', 'luxeritas' ),
				'pagination'	=> __( 'Pagination', 'luxeritas' ),
				'amp'		=> 'AMP',
				'pwa'		=> 'PWA',
				'optimize'	=> __( 'Compression and optimization', 'luxeritas' ),
				'style'		=> 'CSS',
				'script'	=> 'Javascript',
				'search'	=> __( 'Search', 'luxeritas' ),
				'captcha'	=> __( 'CAPTCHA', 'luxeritas' ),
				'copyright'	=> __( 'Copyright', 'luxeritas' ),
				'others'	=> __( 'Others', 'luxeritas' ),
				'version'	=> __( 'Version', 'luxeritas' ),
			);

			echo	'<h2 class="luxe-customize-title">', esc_html( get_admin_page_title() ), '</h2>';
		}
		elseif( $this->_page === 'luxe_man' ) {
			$this->_active = isset( $_GET['active'] ) ? $_GET['active'] : 'editor';

			$this->_tabs = array(
				'editor'	=> __( 'Editor settings', 'luxeritas' ),
				'widget'	=> __( 'Widget management', 'luxeritas' ),
				'thumbnail'	=> __( 'Thumbnail management', 'luxeritas' ),
				'thumregen'	=> __( 'Thumbnail regenerate', 'luxeritas' ),
				'backup'	=> __( 'Backup', 'luxeritas' ),
				'reset'		=> __( 'Reset', 'luxeritas' ),
				'version'	=> __( 'Version', 'luxeritas' ),
			);

			echo	'<h2 class="luxe-customize-title">', esc_html( get_admin_page_title() ), '</h2>';
		}
		elseif( $this->_page === 'luxe_code' ) {
			$this->_active = isset( $_GET['active'] ) ? $_GET['active'] : 'phrase';

			$this->_tabs = array(
				'phrase'		=> __( 'Fixed phrases', 'luxeritas' ),
				'shortcode'		=> __( 'Shortcode', 'luxeritas' ),
				'phrase_sample'		=> __( 'Sample registration', 'luxeritas' ) . ' ( ' . __( 'Fixed phrase', 'luxeritas' ) . ' )',
				'shortcode_sample'	=> __( 'Sample registration', 'luxeritas' ) . ' ( ' . __( 'Shortcode', 'luxeritas' ) . ' )',
			);

			echo	'<h2 class="luxe-customize-title">', esc_html( get_admin_page_title() ), '</h2>';
		}
		elseif( $this->_page === 'luxe_design' ) {
			$this->_active = isset( $_GET['active'] ) ? $_GET['active'] : 'design_select';

			$this->_tabs = array(
				'design_select'	=> __( 'Design Select', 'luxeritas' ),
				'design_create'	=> __( 'Design file creation support', 'luxeritas' ),
				'design_style'	=> 'style.css',
				'design_amp'	=> 'style-amp.css',
			);

			echo	'<h2>' . __( 'Design File Manager', 'luxeritas' ) . '</h2>';
		}
		elseif( $this->_page === 'luxe_sns' ) {
			$this->_active = isset( $_GET['active'] ) ? $_GET['active'] : 'sns_post';

			$this->_tabs = array(
				'sns_post'	=> __( 'Post page', 'luxeritas' ),
				'sns_page'	=> __( 'Static page', 'luxeritas' ),
				'sns_home'	=> __( 'Top page', 'luxeritas' ),
				'sns_setting'	=> __( 'Settings', 'luxeritas' ),
				'sns_csv'	=> 'CSV',
				'sns_get'	=> __( 'All caches restructure', 'luxeritas' ),
			);

			echo	'<h2>SNS ' . __( 'Counter', 'luxeritas' ) . ' ' . __( 'Cache', 'luxeritas' ) . ' ' . __( 'Control', 'luxeritas' ) . '</h2>';
		}
		elseif( $this->_page === 'luxe_fast' ) {
			$this->_active = isset( $_GET['active'] ) ? $_GET['active'] : 'fast';

			$this->_tabs = array(
				'fast'		=> __( 'Speed settings', 'luxeritas' ),
				'htaccess'	=> __( 'htaccess for speed boost', 'luxeritas' ),
			);

			echo	'<h2 class="luxe-customize-title">', esc_html( get_admin_page_title() ), '</h2>';
		}
		else {
			$this->_active = isset( $_GET['active'] ) ? $_GET['active'] : 'edit_style';

			$this->_tabs = array(
				'edit_style'		=> 'style.css',
				'edit_script'		=> 'Javascript',
				'edit_header'		=> 'Head ' . __( 'tag', 'luxeritas' ),
				'edit_footer'		=> __( 'Footer', 'luxeritas' ),
				'edit_analytics_head'	=> __( 'Access Analytics', 'luxeritas' ) . ' ( head )',
				'edit_analytics'	=> __( 'Access Analytics', 'luxeritas' ) . ' ( body )',
				'edit_functions'	=> 'functions.php',
				'edit_amp_body'		=> 'AMP HTML ( body )',
				'edit_amp'		=> __( 'Stylesheet for AMP', 'luxeritas' ),
				'edit_visual'		=> __( 'Visual Editor', 'luxeritas' ),
			);

			echo	'<h2>' . __( 'Child Theme Editor', 'luxeritas' ) . '</h2>';
		}

		settings_errors( 'luxe-custom' );

		echo	'<h2 class="nav-tab-wrapper">';

		foreach( $this->_tabs as $key => $val ) {
			register_setting( $key, $key, 'esc_attr' );
			echo	'<a href="', esc_url( admin_url( 'admin.php?page=' . $this->_page . '&active=' . $key ) ) ,'" ',
				'class="nav-tab', $this->_active === $key ? ' nav-tab-active' : '', '">', esc_html( $val ), '</a>';
		}
		echo	'</h2>';

		$form = false;

		// デフォルトの submit が不要な場合
		if(
			$this->_active !== 'backup'    &&
			$this->_active !== 'htaccess'  &&
			$this->_active !== 'thumregen' &&
			$this->_active !== 'editor'    &&
			$this->_active !== 'version'   &&
			$this->_active !== 'phrase'    &&
			$this->_active !== 'shortcode' &&
			$this->_active !== 'design_select' &&
			$this->_active !== 'design_create' &&
			$this->_active !== 'sns_post'  &&
			$this->_active !== 'sns_page'  &&
			$this->_active !== 'sns_home'  &&
			$this->_active !== 'sns_csv'   &&
			$this->_active !== 'sns_get'
		) $form = true;

		// options.php は経由しないので、nonce のチェックは check_admin_referer でやる
		if( $form === true ) echo '<form id="luxe-customize" method="post" action="">';

		$func = '_' . $this->_active . '_section';
		if( method_exists( $this, $func ) === true ) {
			$this->$func();
		}
		else {
			$this->_empty_section();
		}

		settings_fields( $this->_active );

		ob_start();
		do_settings_sections( $this->_active );
		$settings = ob_get_clean();

		// 子テーマではない時に使えない機能群
		if( TPATH === SPATH ) {
			$dont_child = true;
			if(
				$this->_active !== 'phrase'		&&
				$this->_active !== 'shortcode'		&&
				$this->_active !== 'design_select'	&&
				$this->_active !== 'design_create'	&&
				$this->_active !== 'phrase_sample'
			) $dont_child = false;

			if( $dont_child === true ) {
				echo	'<h3 style="margin:25px 0">'
				,	'<span style="color:red">'
				,	__( 'The theme selected is not the child theme, but the parent theme', 'luxeritas' ), '</span>'
				,	'&nbsp;:<span style="font-weight:normal">&nbsp;&nbsp;'
				,	__( 'This feature can only be used when the child theme is selected.', 'luxeritas' )
				,	'</span></h3>';
			}
		}

		$settings = str_replace( '<h2>', '<fieldset class="luxe-field"><legend><h2 class="luxe-field-title">', $settings );
		$settings = str_replace( '</h2>', '</h2></legend>', $settings );
		echo $settings;

		if( $_GET['page'] === 'luxe_edit' ) {
			submit_button( '', 'primary', 'edit_save', true, array( 'disabled' => 1 ) );
			echo '</form>';
		}
		elseif( $form === true ) {
			submit_button( '', 'primary', 'save', true, array( 'disabled' => 1 ) );
			echo '</form>';
		}
?>
</div>
<?php
		// 画像の設定項目がある場合
		if(
			isset( $_GET['page'] ) && $_GET['page'] === 'luxe' &&
			(
				!isset( $_GET['active'] ) ||
				( isset( $_GET['active'] ) && ( $_GET['active'] === 'seo' || $_GET['active'] === 'ogp' || $_GET['active'] === 'amp' ) )
			)
		) {
?>
<script>
jQuery(document).ready(function($) {
	$("#save").prop("disabled", false);
});
</script>
<?php
		}
		// 画像の設定項目がない場合
		else {
?>
<script>
jQuery(document).ready(function($) {
	$('#luxe-customize').on('keyup change', function() {
		$("#save").prop("disabled", false);
	});
	$('.luxe-field-title').click(function() {
		$(this).parent().nextAll().toggle( 'linear' );
	});
});
</script>
<?php
		}
	}

	public function sections( $args ) {
		get_template_part( 'inc/sections/' . $args['id'] );
		echo '</fieldset>';
	}

	private function _seo_section() {
		$suffix = get_locale() === 'ja' ? ' 関連' : '';
		add_settings_section( 'seo', 'SEO' . $suffix, array( $this, 'sections' ), $this->_active );
	}

	private function _ogp_section() {
		global $luxe;
		$suffix = get_locale() === 'ja' ? ' 関連' : '';
		add_settings_section( 'ogp', 'OGP' . $suffix, array( $this, 'sections' ), $this->_active );
		if( isset( $luxe['fucking_jetpack'] ) ) {
			add_settings_section( 'ogp-jetpack', 'Jetpack', array( $this, 'sections' ), $this->_active );
		}
	}

	private function _amp_section() {
		add_settings_section( 'amp', 'AMP', array( $this, 'sections' ), $this->_active );
	}

	private function _pwa_section() {
		add_settings_section( 'pwa-theme', __( 'Mobile Theme', 'luxeritas' ), array( $this, 'sections' ), $this->_active );
		add_settings_section( 'pwa', 'PWA', array( $this, 'sections' ), $this->_active );
		add_settings_section( 'pwa-manifest', __( 'Manifest', 'luxeritas' ), array( $this, 'sections' ), $this->_active );
	}

	private function _title_section() {
		add_settings_section( 'title', sprintf( __( 'Setting of %s', 'luxeritas' ), 'Title ' . __( 'tag', 'luxeritas' ) ), array( $this, 'sections' ), $this->_active );
	}

	private function _pagination_section() {
		add_settings_section( 'pagination', __( 'Blog pages show at most', 'luxeritas' ), array( $this, 'sections' ), $this->_active );
	}

	private function _optimize_section() {
		add_settings_section( 'optimize-html', __( 'Compression of HTML', 'luxeritas' ), array( $this, 'sections' ), $this->_active );
		add_settings_section( 'optimize-css', __( 'Optimization of CSS', 'luxeritas' ), array( $this, 'sections' ), $this->_active );
		add_settings_section( 'optimize-script', __( 'Optimization of Javascript', 'luxeritas' ), array( $this, 'sections' ), $this->_active );
	}

	private function _style_section() {
		add_settings_section( 'mode-select', __( 'Mode select', 'luxeritas' ), array( $this, 'sections' ), $this->_active );
		add_settings_section( 'css-to-style', __( 'Direct output of external CSS', 'luxeritas' ), array( $this, 'sections' ), $this->_active );
		add_settings_section( 'child-css', __( 'CSS of child theme', 'luxeritas' ), array( $this, 'sections' ), $this->_active );
		add_settings_section( 'fontawesome', __( 'CSS of icon fonts', 'luxeritas' ), array( $this, 'sections' ), $this->_active );
		add_settings_section( 'widget-css', __( 'CSS of widgets', 'luxeritas' ), array( $this, 'sections' ), $this->_active );
	}

	private function _script_section() {
		add_settings_section( 'jquery', 'jQuery', array( $this, 'sections' ), $this->_active );
		add_settings_section( 'bootstrap', 'Bootstrap ' . __( 'Plugins', 'luxeritas' ), array( $this, 'sections' ), $this->_active );
		add_settings_section( 'script', __( 'Other setting of Javascript', 'luxeritas' ), array( $this, 'sections' ), $this->_active );
	}

	private function _search_section() {
		add_settings_section( 'search', sprintf( __( 'Setting of %s', 'luxeritas' ), __( 'Search Widget', 'luxeritas' ) ), array( $this, 'sections' ), $this->_active );
	}

	private function _captcha_section() {
		add_settings_section( 'captcha', sprintf( __( 'Setting of %s', 'luxeritas' ), __( 'CAPTCHA', 'luxeritas' ) ), array( $this, 'sections' ), $this->_active );
		add_settings_section( 'recaptcha', sprintf( __( 'Setting of %s', 'luxeritas' ), 'Google reCAPTCHA ' ), array( $this, 'sections' ), $this->_active );
		add_settings_section( 'securimage', sprintf( __( 'Setting of %s', 'luxeritas' ), 'Securimage PHP CAPTCHA ' ), array( $this, 'sections' ), $this->_active );
	}

	private function _copyright_section() {
		add_settings_section( 'copyright', __( 'Format of copyright', 'luxeritas' ), array( $this, 'sections' ), $this->_active );
	}

	private function _others_section() {
		add_settings_section( 'others', sprintf( __( 'Setting of %s', 'luxeritas' ), __( 'Others', 'luxeritas' ) ), array( $this, 'sections' ), $this->_active );
	}

	private function _editor_section() {
		add_settings_section( 'editor-v-settings', __( 'Visual Editor', 'luxeritas' ), array( $this, 'sections' ), $this->_active );
		add_settings_section( 'editor-t-settings', __( 'Text Editor', 'luxeritas' ), array( $this, 'sections' ), $this->_active );
	}

	private function _widget_section() {
		add_settings_section( 'widget-body', __( 'Widget', 'luxeritas' ), array( $this, 'sections' ), $this->_active );
		add_settings_section( 'widget-area', __( 'Widget Area', 'luxeritas' ), array( $this, 'sections' ), $this->_active );
	}

	private function _thumbnail_section() {
		add_settings_section( 'thumbnail-manage', __( 'Thumbnail management', 'luxeritas' ), array( $this, 'sections' ), $this->_active );
	}

	private function _thumregen_section() {
		add_settings_section( 'regenerate-thumbnail', __( 'Regenerate all thumbnails', 'luxeritas' ), array( $this, 'sections' ), $this->_active );
	}

	private function _backup_section() {
		add_settings_section( 'backup', __( 'Back up or restore Luxeritas all settings', 'luxeritas' ), array( $this, 'sections' ), $this->_active );
		//add_settings_section( 'restore', __( 'Restore Luxeritas', 'luxeritas' ), array( $this, 'sections' ), $this->_active );
		add_settings_section( 'backup-appearance', __( 'Back up or restore Luxeritas appearance settings', 'luxeritas' ), array( $this, 'sections' ), $this->_active );
		add_settings_section( 'backup-child', __( 'Back up Child Theme', 'luxeritas' ), array( $this, 'sections' ), $this->_active );
	}

	private function _reset_section() {
		add_settings_section( 'all_clear', __( 'RESET all the customizations of Luxeritas', 'luxeritas' ), array( $this, 'sections' ), $this->_active );
		add_settings_section( 'sns-cache-cleanup', __( 'Clean up of SNS count cache', 'luxeritas' ), array( $this, 'sections' ), $this->_active );
		add_settings_section( 'blogcard-cache-cleanup', __( 'Clean up of Blog Card cache', 'luxeritas' ), array( $this, 'sections' ), $this->_active );
	}

	private function _htaccess_section() {
		add_settings_section( 'htaccess', __( 'htaccess for speed boost', 'luxeritas' ), array( $this, 'sections' ), $this->_active );
	}

	private function _version_section() {
		add_settings_section( 'version', '', array( $this, 'sections' ), $this->_active );
	}

	private function _phrase_section() {
		add_settings_section( 'phrase-regist', __( 'Registration fixed phrases', 'luxeritas' ), array( $this, 'sections' ), $this->_active );
	}

	private function _shortcode_section() {
		add_settings_section( 'shortcode-regist', __( 'Registration shortcodes', 'luxeritas' ), array( $this, 'sections' ), $this->_active );
	}

	private function _phrase_sample_section() {
		add_settings_section( 'phrase-sample', __( 'Fixed phrases', 'luxeritas' ) . __( ' sample', 'luxeritas' ), array( $this, 'sections' ), $this->_active );
		add_settings_section( 'phrase-luxeritas', __( 'Fixed phrases', 'luxeritas' ) . __( ' For luxeritas only', 'luxeritas' ), array( $this, 'sections' ), $this->_active );
	}

	private function _shortcode_sample_section() {
		add_settings_section( 'shortcode-sample', __( 'Shortcode', 'luxeritas' ) . __( ' sample', 'luxeritas' ), array( $this, 'sections' ), $this->_active );
		add_settings_section( 'shortcode-luxeritas', __( 'Shortcode', 'luxeritas' ) . __( ' For luxeritas only', 'luxeritas' ), array( $this, 'sections' ), $this->_active );
	}

	private function _design_select_section() {
		add_settings_section( 'design-select', '', array( $this, 'sections' ), $this->_active );
	}

	private function _design_create_section() {
		add_settings_section( 'design-create', __( 'Create Zip file', 'luxeritas' ), array( $this, 'sections' ), $this->_active );
	}

	private function _design_style_section() {
		get_template_part( 'inc/design-editor' );
	}

	private function _design_amp_section() {
		$this->_design_style_section();
	}

	private function _sns_setting_section() {
		add_settings_section( 'sns-cache-setting', sprintf( __( 'Setting of %s', 'luxeritas' ), __( 'cache', 'luxeritas' ) ), array( $this, 'sections' ), $this->_active );
		add_settings_section( 'sns-cache-cleanup', __( 'Clean up of SNS count cache', 'luxeritas' ), array( $this, 'sections' ), $this->_active );
	}

	private function _sns_csv_section() {
		add_settings_section( 'sns-cache-csv', __( 'Download CSV', 'luxeritas' ), array( $this, 'sections' ), $this->_active );
	}

	private function _sns_get_section() {
		add_settings_section( 'sns-cache-all-get', __( 'Restructure of all SNS count caches', 'luxeritas' ), array( $this, 'sections' ), $this->_active );
	}

	private function _sns_post_section() {
		get_template_part( 'inc/sns-count-view' );
		$cache_view = new cache_control();
		add_settings_section( 'sns-cache-list', '', array( $cache_view, 'sns_cache_list' ), $this->_active );
	}

	private function _sns_page_section() {
		$this->_sns_post_section();
	}

	private function _sns_home_section() {
		$this->_sns_post_section();
	}

	private function _fast_section() {
		add_settings_section( 'speedup-set', __( 'Setting selection', 'luxeritas' ), array( $this, 'sections' ), $this->_active );
		add_settings_section( 'speedup-items', __( 'Setting items', 'luxeritas' ), array( $this, 'sections' ), $this->_active );
	}

	private function _edit_style_section() {
		get_template_part( 'inc/theme-editor' );
	}

	private function _edit_script_section() {
		$this->_edit_style_section();
	}

	private function _edit_header_section() {
		$this->_edit_style_section();
	}

	private function _edit_footer_section() {
		$this->_edit_style_section();
	}

	private function _edit_analytics_section() {
		$this->_edit_style_section();
	}

	private function _edit_analytics_head_section() {
		$this->_edit_style_section();
	}

	private function _edit_functions_section() {
		$this->_edit_style_section();
	}

	private function _edit_amp_body_section() {
		$this->_edit_style_section();
	}

	private function _edit_amp_section() {
		$this->_edit_style_section();
	}

	private function _edit_visual_section() {
		$this->_edit_style_section();
	}

	private function _empty_section() {
		return;
	}
}
