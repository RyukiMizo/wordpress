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

/*---------------------------------------------------------------------------
 * WordPress の locale から OGP の locale を返す
 *---------------------------------------------------------------------------*/
if( class_exists('thk_locale') === false ):
class thk_locale {
	public function __construct() {
	}

	public function thk_locale_wp_2_ogp( $loc ) {
		$locale_list = array(
			'af'	=> 'af_ZA',
			'ak'	=> 'ak_GH',
			'am'	=> 'am_ET',
			'ar'	=> 'ar_AR',
			'as'	=> 'as_IN',
			'az'	=> 'az_AZ',
			'bel'	=> 'be_BY',
			'bg_BG'	=> 'bg_BG',
			'bn_BD'	=> 'bn_IN',
			'bre'	=> 'br_FR',
			'bs_BA'	=> 'bs_BA',
			'ca'	=> 'ca_ES',
			'ceb'	=> 'cx_PH',
			'ckb'	=> 'cb_IQ',
			'cs_CZ'	=> 'cs_CZ',
			'cy'	=> 'cy_GB',
			'da_DK'	=> 'da_DK',
			'de_DE'	=> 'de_DE',
			'el'	=> 'el_GR',
			'en_US'	=> 'en_US',
			'en_GB'	=> 'en_GB',
			'eo'	=> 'eo_EO',
			'es_ES'	=> 'es_ES',
			'es_AR'	=> 'es_LA',
			'es_CL'	=> 'es_CL',
			'es_CO'	=> 'es_CO',
			'es_GT'	=> 'es_LA',
			'es_MX'	=> 'es_MX',
			'es_PE'	=> 'es_LA',
			'es_PR'	=> 'es_LA',
			'es_VE'	=> 'es_VE',
			'et'	=> 'et_EE',
			'eu'	=> 'eu_ES',
			'fa_IR'	=> 'fa_IR',
			'fi'	=> 'fi_FI',
			'fo'	=> 'fo_FO',
			'fr_FR'	=> 'fr_FR',
			'fr_CA'	=> 'fr_CA',
			'fy'	=> 'fy_NL',
			'ga'	=> 'ga_IE',
			'gl_ES'	=> 'gl_ES',
			'gu'	=> 'gu_IN',
			'hau'	=> 'ha_NG',
			'he_IL'	=> 'he_IL',
			'hi_IN'	=> 'hi_IN',
			'hr'	=> 'hr_HR',
			'hu_HU'	=> 'hu_HU',
			'hy'	=> 'hy_AM',
			'id_ID'	=> 'id_ID',
			'is_IS'	=> 'is_IS',
			'it_IT'	=> 'it_IT',
			'ja'	=> 'ja_JP',
			'jv_ID'	=> 'jv_ID',
			'ka_GE'	=> 'ka_GE',
			'kin'	=> 'rw_RW',
			'kk'	=> 'kk_KZ',
			'km'	=> 'km_KH',
			'kn'	=> 'kn_IN',
			'ko_KR'	=> 'ko_KR',
			'li'	=> 'li_NL',
			'lin'	=> 'ln_CD',
			'lo'	=> 'lo_LA',
			'lt_LT'	=> 'lt_LT',
			'lv'	=> 'lv_LV',
			'mg_MG'	=> 'mg_MG',
			'mk_MK'	=> 'mk_MK',
			'ml_IN'	=> 'ml_IN',
			'mn'	=> 'mn_MN',
			'mr'	=> 'mr_IN',
			'ms_MY'	=> 'ms_MY',
			'ne_NP'	=> 'ne_NP',
			'nb_NO'	=> 'nb_NO',
			'nl_NL'	=> 'nl_NL',
			'nn_NO'	=> 'nn_NO',
			'ory'	=> 'or_IN',
			'pa_IN'	=> 'pa_IN',
			'pl_PL'	=> 'pl_PL',
			'pt_BR'	=> 'pt_BR',
			'pt_PT'	=> 'pt_PT',
			'ps'	=> 'ps_AF',
			'ro_RO'	=> 'ro_RO',
			'ru_RU'	=> 'ru_RU',
			'sa_IN'	=> 'sa_IN',
			'si_LK'	=> 'si_LK',
			'sk_SK'	=> 'sk_SK',
			'sl_SI'	=> 'sl_SI',
			'so_SO'	=> 'so_SO',
			'sq'	=> 'sq_AL',
			'sr_RS'	=> 'sr_RS',
			'srd'	=> 'sc_IT',
			'sv_SE'	=> 'sv_SE',
			'sw'	=> 'sw_KE',
			'szl'	=> 'sz_PL',
			'ta_IN'	=> 'ta_IN',
			'te'	=> 'te_IN',
			'tg'	=> 'tg_TJ',
			'th'	=> 'th_TH',
			'tl'	=> 'tl_PH',
			'tr_TR'	=> 'tr_TR',
			'tt_RU'	=> 'tt_RU',
			'tuk'	=> 'tk_TM',
			'uk'	=> 'uk_UA',
			'ur'	=> 'ur_PK',
			'uz_UZ'	=> 'uz_UZ',
			'vi'	=> 'vi_VN',
			'xho'	=> 'xh_ZA',
			'yor'	=> 'yo_NG',
			'zh_CN'	=> 'zh_CN',
			'zh_HK'	=> 'zh_HK',
		);

		if( isset( $locale_list[$loc] ) ) {
			return $locale_list[$loc];
		}

		$ret = empty( $loc ) ? 'en_US' : str_replace( '-', '_', $loc );
		if( strlen( $ret ) === 2 ) {
			$ret = strtolower( $ret ) . '_' . strtoupper( $ret );
		}

		return $ret;
	}
}
endif;
