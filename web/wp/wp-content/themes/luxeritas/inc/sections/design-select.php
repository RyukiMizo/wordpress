<?php
/**
 * Luxeritas WordPress thk-design - free/libre wordpress platform
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
<div style="margin:20px 0 25px 0">
<div style="float:left;margin-right:10px">
<form enctype="multipart/form-data" id="luxe-customize" method="post" action="">
<?php
settings_fields( 'design_upload' );
?>
<label class="button secondary"><?php echo __( 'Add New', 'luxeritas' ); ?>
<input type="file" id="design-upload" name="design-upload" style="display:none" />
</label>
</form>
</div>

<div style="float:left">
<form id="luxe-customize" method="post" action="">
<?php
settings_fields( 'backup_appearance' );
?>
<?php
submit_button( __( 'Appearance Backup', 'luxeritas' ), 'secondary', 'backup_appearance', false, array() );
?>
</form>
</div>

<div>
<form enctype="multipart/form-data" id="luxe-customize" method="post" action="">
<?php
settings_fields( 'restore_appearance' );
?>
<label class="button secondary"><?php echo __( 'Appearance Restore', 'luxeritas' ); ?>
<input type="file" id="luxe-restore-appearance" name="luxe-restore-appearance" style="display:none" />
</label>
<div style="display:none">
<?php
submit_button( __( 'Appearance Restore', 'luxeritas' ), 'secondary', 'restore', false, array() );
?>
</div>
</form>
</div>
</div>

<script>
jQuery( function($) {
	$("#design-upload").change(function () {
		$(this).closest("form").submit();
	});
	$("#luxe-restore-appearance").change(function () {
		$(this).closest("form").submit();
	});
});
</script>

<p><span style="color:red"><?php echo __( '(Caution) Settings of appearance customization will be rewritten to the value specified in the design file. (Image, various ID etc excluded)', 'luxeritas' ); ?></span></p>
<p class="m25-b"><a href="<?php echo esc_url( admin_url( 'admin.php?page=luxe_man&active=backup' ) ); ?>"><?php echo __( 'Recommend that you backup appearance customization before changing.', 'luxeritas' ); ?></a></p>
<ul>
<li>
<?php
settings_fields( 'design_select' );
?>
<div class="thk-design-browser rendered">
<div class="thk-designs wp-clearfix">
<?php
if( function_exists( 'thk_design_screenshot' ) === false ):
function thk_design_screenshot( $design_path ) {
	$screenshot_basename = $design_path . DSEP . 'screenshot';

	$locale = get_locale();
	$screenshot = $screenshot_basename . '-' . $locale . '.png';

	if( file_exists( $screenshot ) === false ) {
		$screenshot = str_replace( '.png', '.jpg', $screenshot );
		if( file_exists( $screenshot ) === false ) {
			$screenshot = str_replace( '.jpg', '.gif', $screenshot );
			if( file_exists( $screenshot ) === false ) {
				$screenshot = $screenshot_basename . '.png';
				if( file_exists( $screenshot ) === false ) {
					$screenshot = str_replace( '.png', '.jpg', $screenshot );
					if( file_exists( $screenshot ) === false ) {
						$screenshot = str_replace( '.jpg', '.gif', $screenshot );
						if( file_exists( $screenshot ) === false ) {
							$screenshot = TDEL . '/images/no-img-600x450.png';
						}
					}
				}
			}
		}
	}
	return str_replace( DSEP, '/', str_replace( SPATH, SDEL, $screenshot ) );
}
endif;

$dirs = glob( SPATH . DSEP . 'design' . DSEP . '*' );

$design_name = isset( $luxe['design_file'] ) ? $luxe['design_file'] : '."/\[]:;|=,';
$design_path = SPATH . DSEP . 'design' . DSEP . $design_name;

// 有効化されてるデザイン
if( isset( $luxe['design_file'] ) && is_dir( $design_path ) === true ) {
	if( is_dir( $design_path ) === true ) {
		$screenshot = thk_design_screenshot( $design_path );

		echo	'<div class="thk-design active">'
		,	'<div class="thk-design-screenshot"><img src="', $screenshot, '" alt="', $design_name, '" /></div>'
		,	'<div class="thk-design-id-container">'
		,	'<h2 class="thk-design-name">', $design_name, '</h2>'
		,	'<div class="thk-design-actions">';

		if( $design_name === 'default-template' ) {
			echo	'<form style="display:inline-block" method="post" action="">'
			,	'<input type="hidden" name="design_reset" value="', $design_name, '" />';
			settings_fields( 'design_reset' );
			submit_button( __( 'Reset', 'luxeritas' ), 'reset', $design_name, false, array( 'onClick' => 'return thk_reset_confirm()' ) );
			echo	'</form>';
		}

		echo	'<form style="display:inline-block" method="post" action="">'
		,	'<input type="hidden" name="design_delete" value="', $design_name, '" />';
		settings_fields( 'design_delete' );
		submit_button( __( 'Delete', 'luxeritas' ), 'delete', $design_name, false, array( 'onClick' => 'return thk_delete_confirm()' ) );
		echo	'</form>'
		,	'</div></div></div>';

		$key = array_search( $design_path, $dirs );
		if( $key !== false ) {
			unset( $dirs[$key] );
		}
	}
}

$active = empty( $luxe['design_file'] ) || ( !empty( $luxe['design_file'] ) && is_dir( $design_path ) === false ) ? ' active' : '';

// デフォルトデザイン
echo	'<div class="thk-design', $active, '">'
,	'<div class="thk-design-screenshot"><img src="', TDEL, '/images/default-design.png" alt="', 'Luxeritas default', '" /></div>'
,	'<div class="thk-design-id-container">'
,	'<h2 class="thk-design-name">', 'Luxeritas ( ', __( 'Initialization of appearance', 'luxeritas' ), ' )</h2>';

if( isset( $luxe['design_file'] ) && is_dir( $design_path ) === true ) {
	echo	'<div class="thk-design-actions">'
	,	'<form style="display:inline-block" method="post" action="">'
	,	'<input type="hidden" name="design_select" value="" />';
	settings_fields( 'design_select' );
	submit_button( __( 'Activate', 'luxeritas' ), 'primary', 'Luxeritas default', false, array( 'onClick' => 'return thk_change_confirm()' ) );
	echo	'</form>'
	,	'</div>';
}
elseif( isset( $luxe['design_file'] ) && is_dir( $design_path ) === false ) {
	remove_theme_mod( 'design_file' );
}

echo	'</div></div>';

// 無効化されてるデザイン
foreach( (array)$dirs as $val ) {
	$design_name = basename( $val );

	if( is_dir( $val ) === true ) {
		$screenshot = thk_design_screenshot( $val );

		echo	'<div class="thk-design">'
		,	'<div class="thk-design-screenshot"><img src="', $screenshot, '" alt="', $design_name, '" /></div>'
		,	'<div class="thk-design-id-container">'
		,	'<h2 class="thk-design-name">', $design_name, '</h2>'
		,	'<div class="thk-design-actions">'
		,	'<form style="display:inline-block" method="post" action="">'
		,	'<input type="hidden" name="design_select" value="', $design_name, '" />';
		settings_fields( 'design_select' );
		submit_button( __( 'Activate', 'luxeritas' ), 'primary', $design_name, false, array( 'onClick' => 'return thk_change_confirm()' ) );
		echo	'</form>'
		,	'<form style="display:inline-block" method="post" action="">'
		,	'<input type="hidden" name="design_delete" value="', $design_name, '" />';
		settings_fields( 'design_delete' );
		submit_button( __( 'Delete', 'luxeritas' ), 'delete', $design_name, false, array( 'onClick' => 'return thk_delete_confirm()' ) );
		echo	'</form>'
		,	'</div></div></div>';
	}
}
?>
<script>
function thk_change_confirm() {
	if( window.confirm( "<?php echo __( 'Rewrite the setting of appearance customization. Is it OK?', 'luxeritas' ); ?>" ) ) {
		return true;
	}
	return false;
}
function thk_delete_confirm() {
	if( window.confirm( "<?php echo __( 'You are about to delete the design file. Is it OK?', 'luxeritas' ); ?>" ) ) {
		return true;
	}
	return false;
}
function thk_reset_confirm() {
	if( window.confirm( "<?php echo __( 'Reset stylesheet of the design file.. Is it OK?', 'luxeritas' ); ?>" ) ) {
		return true;
	}
	return false;
}
</script>
</div>
</div>
</li>
</ul>
