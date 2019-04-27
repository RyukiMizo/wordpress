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

?>
<aside>
<div id="sns-bottoms">
<?php
global $luxe, $awesome;

$title_no_enc = THK_SITENAME . thk_title_separator( '|' ) . THK_DESCRIPTION;
$title        = thk_encode( $title_no_enc );

$fa_google_plus = 'fa-google-plus-g';
$fa_linkedin    = 'fa-linkedin-in';
$fa_smile	= 'fa-smile';

if( $awesome === 4 ) {
	$fa_google_plus = 'fa-google-plus';
	$fa_linkedin    = 'fa-linkedin';
	$fa_smile	= 'fa-smile-o';
}

if( $luxe['sns_bottoms_type'] === 'normal' ) {
?>
<div class="sns-n">
<ul class="snsb clearfix">
<?php if( isset( $luxe['twitter_share_bottoms_button'] ) ) { ?>
<!--twitter-->
<li class="twitter">
<a href="//twitter.com/share" class="twitter-share-button" data-url="<?php echo THK_HOME_URL; ?>" data-text="<?php echo $title_no_enc; ?>">Tweet</a>
<script src="//platform.twitter.com/widgets.js"></script>
</li>
<?php } if( isset( $luxe['facebook_share_bottoms_button'] ) ) { ?>
<!--facebook-->
<li class="facebook">
<div class="fb-like" data-href="<?php echo THK_HOME_URL; ?>" data-layout="button_count" data-action="like" data-size="small" data-show-faces="false" data-share="true"></div>
</li>
<?php } if( isset( $luxe['google_share_bottoms_button'] ) ) { ?>
<!--google+1-->
<li class="google">
<script src="//apis.google.com/js/plusone.js"></script>
<div class="g-plusone" data-size="medium" data-width="120" data-href="<?php echo THK_HOME_URL; ?>"></div>
</li>
<?php } if( isset( $luxe['linkedin_share_bottoms_button'] ) ) { ?>
<!--linkedin-->
<li class="linkedin">
<script src="//platform.linkedin.com/in.js" type="text/javascript"></script>
<script type="IN/Share" data-url="<?php echo THK_HOME_URL; ?>" data-counter="right"></script>
</li>
<?php } if( isset( $luxe['pinit_share_bottoms_button'] ) ) { ?>
<!--pinterest-->
<li class="pinit">
<a data-pin-do="buttonBookmark" data-pin-count="beside" href="https://www.pinterest.com/pin/create/button/"></a>
</li>
<?php } if( isset( $luxe['hatena_share_bottoms_button'] ) ) { ?>
<!--hatena-->
<li class="hatena">
<a href="//b.hatena.ne.jp/entry/<?php echo THK_HOME_URL; ?>" class="hatena-bookmark-button" data-hatena-bookmark-title="<?php echo $title_no_enc; ?>" data-hatena-bookmark-layout="simple-balloon" title="このエントリーをはてなブックマークに追加"><img src="//b.st-hatena.com/images/entry-button/button-only.gif" alt="このエントリーをはてなブックマークに追加" style="border: none;" /></a>
<script type="text/javascript" src="//b.st-hatena.com/js/bookmark_button.js" async="async"></script>
</li>
<?php } if( isset( $luxe['line_share_bottoms_button'] ) ) { ?>
<!--line-->
<li class="line line-pc">
<div class="line-it-button" style="display: none;" data-type="share-a" data-lang="<?php echo get_locale() === 'ja' ? 'ja' : 'en'; ?>"></div>
<script src="//scdn.line-apps.com/n/line_it/thirdparty/loader.min.js" async="async"　defer="defer"></script>
</li>
<li class="line line-sm">
<script src="//media.line.me/js/line-button.js?v=20140411" ></script>
<script>new media_line_me.LineButton({"pc":false,"lang":"ja","type":"a"});</script>
</li>
<?php } if( isset( $luxe['pocket_share_bottoms_button'] ) ) { ?>
<!--pocket-->
<li class="pocket">
<a data-pocket-label="pocket" data-pocket-count="horizontal" class="pocket-btn" data-lang="en"></a>
<script>!function(d,i){if(!d.getElementById(i)){var j=d.createElement("script");j.id=i;j.src="//widgets.getpocket.com/v1/j/btn.js?v=1";var w=d.getElementById(i);d.body.appendChild(j);}}(document,"pocket-btn-js");</script>
</li>
<?php } ?>
</ul>
<div class="clearfix"></div>
</div><!--/.sns-n-->
<?php
}
else {
	$verify = true;
	$id_cnt = array();
	$feed_cnt = null;
	$buttons = array();

	$buttons['twitter']	= isset( $luxe['twitter_share_bottoms_button'] )	? true : false;
	$buttons['facebook']	= isset( $luxe['facebook_share_bottoms_button'] )	? true : false;
	$buttons['google']	= isset( $luxe['google_share_bottoms_button'] )		? true : false;
	$buttons['linkedin']	= isset( $luxe['linkedin_share_bottoms_button'] )	? true : false;
	$buttons['pinit']	= isset( $luxe['pinit_share_bottoms_button'] )		? true : false;
	$buttons['hatena']	= isset( $luxe['hatena_share_bottoms_button'] )		? true : false;
	$buttons['pocket']	= isset( $luxe['pocket_share_bottoms_button'] )		? true : false;
	$buttons['line']	= isset( $luxe['line_share_bottoms_button'] )		? true : false;
	$buttons['rss']		= isset( $luxe['rss_share_bottoms_button'] )		? true : false;
	$buttons['feedly']	= isset( $luxe['feedly_share_bottoms_button'] )		? true : false;

	$vcount = 0;
	foreach( $buttons as $key => $val ) {
		if( $val === true ) ++$vcount;
		if( $vcount === 4 ) $vcurrent = $key;
	}

	$cnt_enable = isset( $luxe['sns_bottoms_count'] ) ? true : false;
	$feed_cnt_enable = isset( $luxe['sns_bottoms_count'] ) && isset( $luxe['feedly_share_bottoms_button'] ) ? true : false;
	$icon_only = false;
	$cls_div = 'sns-c';
	$cls_lst = 'snsb';
	$cls_cnt = 'snscnt';

	if( $luxe['sns_bottoms_type'] === 'color' ) {
		$cls_lst = 'snsb clearfix';
	}
	elseif( $luxe['sns_bottoms_type'] === 'white' ) {
		$cls_div = 'sns-w';
		$cls_lst = 'snsb clearfix';
	}
	elseif( $luxe['sns_bottoms_type'] === 'flatw' ) {
		$cls_div = 'snsf-w';
		$cls_lst = 'snsfb clearfix';
		$cls_cnt = 'snsfcnt';
	}
	elseif( $luxe['sns_bottoms_type'] === 'iconc') {
		$cls_div = 'snsi-c';
		$cls_lst = 'snsib clearfix';
		$cls_cnt = 'snsicnt';
		$icon_only = true;
	}
	elseif( $luxe['sns_bottoms_type'] === 'iconw') {
		$cls_div = 'snsi-w';
		$cls_lst = 'snsib clearfix';
		$cls_cnt = 'snsicnt';
		$icon_only = true;
	}
	else {
		$cls_div = 'snsf-c';
		$cls_lst = 'snsfb clearfix';
		$cls_cnt = 'snsfcnt';
	}

	// SNS ボタン を2段組にする
	$curkey = null;
	$pgraph = null;
	if( isset( $luxe['sns_bottoms_multiple'] ) ) {
		$i = 1;
		$vcount = 0;
		$vbtns  = array();

		foreach( $buttons as $key => $val ) {
			if( $val === true ) {
				++$vcount;
				$vbtns[] = $key;
			}
		}
		$btn_cep = ceil( $vcount / 2 );

		foreach( $vbtns as $val ) {
			if( $i >= $btn_cep ) {
				$curkey = $val;
				break;
			}
			++$i;
		}
		$pgraph = '</ul></div><div class="' . $cls_div . '"><ul class="' . $cls_lst . '">' . "\n";
	}

	// カウント数のキャッシュ取得
	if( isset( $luxe['sns_count_cache_enable'] ) &&
		( isset( $luxe['sns_count_cache_force'] ) || (
		( isset( $luxe['sns_toppage_view'] ) && isset( $luxe['sns_bottoms_count'] ) ) ) )
	) {
		$id_cnt = thk_get_sns_count_cache();
		foreach( (array)$id_cnt as $val ) {
			if( ctype_digit( $val ) === false ) {
				$verify = false;
			}
			else {
				$id_cnt[$key] = apply_filters( 'thk_sns_count', $val, $key, THK_HOME_URL );
			}
		}
		if( isset( $luxe['sns_count_cache_force'] ) || isset( $luxe['feedly_share_bottoms_button'] ) ) {
			$feed_cnt = thk_get_feedly_count_cache();
			if( ctype_digit( $feed_cnt ) === true ) {
				$feed_cnt = apply_filters( 'thk_sns_count', $feed_cnt, 'r', THK_HOME_URL );
			}
		}
	}
	else {
		$id_cnt = array( 'f' => '', 'g' => '', 'h' => '', 'l' => '', 'p' => '' );

		foreach( $id_cnt as $key => $val ) {
			$id_cnt[$key] = '<i class="fa fas fa-spinner fa-spin"></i>';
		}

		if( isset( $luxe['feedly_share_bottoms_button'] ) ) {
			$feed_cnt = '<i class="fa fas fa-spinner fa-spin"></i>';
		}
	}

	$fab = $awesome === 4 ? 'fa ' : 'fab ';
?>
<div class="<?php echo $cls_div; ?>">
<ul class="<?php echo $cls_lst; ?>">
<?php if( $buttons['twitter'] === true ) {
	$far = $awesome === 4 ? 'fa ' : 'far ';
?>
<!--twitter-->
<li class="twitter"><a href="//twitter.com/share?text=<?php echo $title; ?>&amp;url=<?php echo THK_HOME_URL; ?>" title="Tweet" target="_blank" rel="nofollow noopener"><i class="<?php echo $fab; ?>fa-twitter">&nbsp;</i><?php if( $icon_only !== true ): ?><span class="snsname">Twitter</span><?php if( $cnt_enable === true ): ?><span class="<?php echo $cls_cnt; ?> twitter-count"><i class="<?php echo $far, $fa_smile; ?>"></i></span><?php endif; ?><?php endif; ?></a></li>
<?php } if( $curkey === 'twitter' ) echo $pgraph;
	if( $buttons['facebook'] === true ) { ?>
<!--facebook-->
<li class="facebook"><a href="//www.facebook.com/sharer/sharer.php?u=<?php echo THK_HOME_URL; ?>&amp;t=<?php echo $title; ?>" title="Share on Facebook" target="_blank" rel="nofollow noopener"><i class="<?php echo $fab; ?>fa-facebook-f">&nbsp;</i><?php if( $icon_only !== true ): ?><span class="snsname">Facebook</span><?php endif; ?><?php if( $cnt_enable === true ): ?><span class="<?php echo $cls_cnt; ?> facebook-count"><?php echo $id_cnt['f']; ?></span><?php endif; ?></a></li>
<?php } if( $curkey === 'facebook' ) echo $pgraph;
	if( $buttons['google'] === true ) { ?>
<!--google+1-->
<li class="google"><a href="//plus.google.com/share?url=<?php echo THK_HOME_URL; ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" title="Google+" target="_blank" rel="nofollow noopener"><i class="<?php echo $fab, $fa_google_plus; ?>">&nbsp;</i><?php if( $icon_only !== true ): ?><span class="snsname">Google+</span><?php endif; ?><?php if( $cnt_enable === true ): ?><span class="<?php echo $cls_cnt; ?> google-count"><?php echo $id_cnt['g']; ?></span><?php endif; ?></a></li>
<?php } if( $curkey === 'google' ) echo $pgraph;
	if( $buttons['linkedin'] === true ) { ?>
<!--linkedin-->
<li class="linkedin"><a href="//www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo THK_HOME_URL; ?>&amp;title=<?php echo $title; ?>&amp;summary=<?php echo thk_encode( apply_filters( 'thk_create_description', '' ) ); ?>" title="Share on LinkedIn" target="_blank" rel="nofollow noopener"><i class="<?php echo $fab, $fa_linkedin; ?>">&nbsp;</i><?php if( $icon_only !== true ): ?><span class="snsname">LinkedIn</span><?php endif; ?><?php if( $cnt_enable === true ): ?><span class="<?php echo $cls_cnt; ?> linkedin-count"><?php echo $id_cnt['l']; ?></span><?php endif; ?></a></li>
<?php } if( $curkey === 'linkedin' ) echo $pgraph;
	if( $buttons['pinit'] === true ) { ?>
<!--pinit-->
<li class="pinit"><a href="//www.pinterest.com/pin/create/button/?url=<?php echo THK_HOME_URL; ?>" data-pin-do="buttonBookmark" data-pin-custom="true" target="_blank" rel="nofollow noopener"><i class="<?php echo $fab; ?>fa-pinterest-p">&nbsp;</i><?php if( $icon_only !== true ): ?><span class="snsname">Pin it</span><?php endif; ?><?php if( $cnt_enable === true ): ?><span class="<?php echo $cls_cnt; ?> pinit-count"><?php echo $id_cnt['t']; ?></span><?php endif; ?></a></li>
<?php } if( $curkey === 'pinit' ) echo $pgraph;
	if( $buttons['hatena'] === true ) { ?>
<!--hatena-->
<li class="hatena"><a href="//b.hatena.ne.jp/add?mode=confirm&amp;url=<?php echo THK_HOME_URL; ?>&amp;title=<?php echo $title; ?>" title="Bookmark at Hatena" target="_blank" rel="nofollow noopener"><i class="fa fa-hatena">B!</i>&nbsp;<?php if( $icon_only !== true ): ?><span class="snsname">Hatena</span><?php endif; ?><?php if( $cnt_enable === true ): ?><span class="<?php echo $cls_cnt; ?> hatena-count"><?php echo $id_cnt['h']; ?></span><?php endif; ?></a></li>
<?php } if( $curkey === 'hatena' ) echo $pgraph;
	if( $buttons['pocket'] === true ) { ?>
<!--pocket-->
<li class="pocket"><a href="//getpocket.com/edit?url=<?php echo THK_HOME_URL; ?>" title="Pocket: Read it Later" target="_blank" rel="nofollow noopener"><i class="<?php echo $fab; ?>fa-get-pocket">&nbsp;</i><?php if( $icon_only !== true ): ?><span class="snsname">Pocket</span><?php endif; ?><?php if( $cnt_enable === true ): ?><span class="<?php echo $cls_cnt; ?> pocket-count"><?php echo $id_cnt['p']; ?></span><?php endif; ?></a></li>
<?php } if( $curkey === 'pocket' ) echo $pgraph;
	if( $buttons['line'] === true ) { ?>
<!--LINE-->
<li class="line line-pc"><a href="//lineit.line.me/share/ui?url=<?php echo rtrim( $permalink, '/' ) ?>/#/" title="<?php echo __( 'Send to LINE', 'luxeritas' ); ?>" target="_blank" rel="nofollow noopener"><i class="ico-line">&nbsp;</i><?php if( $icon_only !== true ): ?><span class="snsname">LINE</span><?php if( $cnt_enable === true ): ?><span class="<?php echo $cls_cnt; ?>"><i>Send</i></span><?php endif; ?><?php endif; ?></a></li>
<li class="line line-sm"><a href="//line.me/R/msg/text/?<?php echo $title; ?>%0D%0A<?php echo $permalink; ?>" title="<?php echo __( 'Send to LINE', 'luxeritas' ); ?>" target="_blank" rel="nofollow noopener"><i class="ico-line">&nbsp;</i><?php if( $icon_only !== true ): ?><span class="snsname">LINE</span><?php if( $cnt_enable === true ): ?><span class="<?php echo $cls_cnt; ?>"><i>Send</i></span><?php endif; ?><?php endif; ?></a></li>
<?php } if( $curkey === 'line' ) echo $pgraph;
	if( $buttons['rss'] === true ) { ?>
<!--rss-->
<li class="rss"><a href="<?php echo get_bloginfo('rss2_url'); ?>" title="RSS" target="_blank" rel="nofollow noopener"><i class="fa fas fa-rss">&nbsp;</i><?php if( $icon_only !== true ): ?><span class="snsname">RSS</span><?php if( $cnt_enable === true ): ?><span class="<?php echo $cls_cnt; ?> rss-count"><i class="fa fas fa-rss"></i></span><?php endif; ?><?php endif; ?></a></li>
<?php } if( $buttons['feedly'] === true ) { ?>
<!--feedly-->
<li class="feedly"><a href="//feedly.com/index.html#subscription/feed/<?php echo rawurlencode( get_bloginfo('rss2_url') ); ?>" title="Feedly" target="_blank" rel="nofollow noopener"><i class="ico-feedly">&nbsp;</i><?php if( $icon_only !== true ): ?><span class="snsname">Feedly</span><?php endif; ?><?php if( $cnt_enable === true ): ?><span class="<?php echo $cls_cnt; ?> feedly-count"><?php echo $feed_cnt; ?></span><?php endif; ?></a></li>
<?php } ?>
</ul>
<div class="<?php
	echo $cnt_enable === true ? 'sns-count-true ' : '';
	echo $feed_cnt_enable === true ? 'feed-count-true ' : '';
	if( isset( $luxe['sns_count_cache_enable'] ) ) {
		echo $verify === true ? 'sns-cache-true ' : '';
		echo ctype_digit( $feed_cnt ) === true ? 'feed-cache-true ' : '';
	}
?>clearfix"<?php echo $cnt_enable === true ? ' data-luxe-permalink="' . THK_HOME_URL . '"' : ''; ?>></div>
</div>
<?php
}
?>
</div><!--/#sns-bottoms-->
</aside>
