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

class thk_colors {
	public function __construct() {
	}

	// カラーコードを RGB に分割する
	public function colorcode_2_rgb( $colorcode ){
		$ret = array( 'r' => 255, 'g' => 255, 'b' => 255 );

		if( stripos( $colorcode, '#'  ) !== false ) {
			$colorcode = str_replace( '#', '', $colorcode );

			if( ctype_xdigit( $colorcode ) && strlen( $colorcode ) >= 6 ) {
				$ret['r'] = hexdec( substr( $colorcode, 0, 2 ) );
				$ret['g'] = hexdec( substr( $colorcode, 2, 2 ) );
				$ret['b'] = hexdec( substr( $colorcode, 4, 2 ) );
			}
		}

		return $ret;
	}

	// カラーコードを反転させた色を取得する
	public function get_inverse_text_color( $colorcode ){
		$colorcode = str_replace( '#', '', $colorcode );
		$inverse = hexdec( $colorcode ) ^ hexdec( 'ffffff' );
		return sprintf( '#%06x', $inverse );
	}

	// 背景色に対して、見やすい文字色を取得する (輝度で判定する場合)
	public function get_text_color_matches_background( $colorcode, $black_and_white = false, $yuv = true ){
		$rgb = $this->colorcode_2_rgb( $colorcode );

		$lum   = 135;	// 輝度信号 Y の白黒分岐点 (128 ～ 135)
		$level = 125;	// W3C が定義してる明度差の基準値 (125)

		$irgb = array();
		$inverse = '#000000';
		$diff = 0;

		if( $yuv !== true ) {
			// ITU-R BT.709 (1125/60/2:1)
			// HD( High Definition ) 高解像度・ハイビジョン映像
			$y = 0.2126 * $rgb['r'] + 0.7152 * $rgb['g'] + 0.0722 * $rgb['b'];
		}
		else {
			// YUV 、ITU-R BT.709 (1250/50/2:1)
			// SD( Standard Definition ) 標準解像度・標準映像
			$y = 0.299 * $rgb['r'] + 0.587 * $rgb['g'] + 0.114 * $rgb['b'];
		}

		// 白黒以外で反転色が見やすい色の場合
		if( $black_and_white !== false ) {
			$inverse = $this->get_inverse_text_color( $colorcode );	// カラーコード反転
			$irgb = $this->colorcode_2_rgb( $inverse );

			if( $yuv !== true ) {
				$iy = 0.2126 * $irgb['r'] + 0.7152 * $irgb['g'] + 0.0722 * $irgb['b'];
			}
			else {
				$iy = 0.299 * $irgb['r'] + 0.587 * $irgb['g'] + 0.114 * $irgb['b'];
			}

			$diff = ( $y >= $iy ) ? $y - $iy : $iy - $y;	// 明度差算出

			// 反転色が明度差の基準値以内の場合は反転色を返す
			if( $diff >= $level ) {
				return $inverse;
			}
		}

		return ( $y >= $lum ) ? '#000000' : '#ffffff';
	}

	// 背景色に対して、見やすい文字色を取得する (コントラストで判定する場合)
	public function get_text_color_matches_background_cont( $colorcode, $per = 50 ){
		return ( hexdec( $colorcode ) > 0xffffff * ( $per / 100 ) ) ? '#000000 ' : '#ffffff';
	}

	// SNS の色配列
	public function sns_colors() {
		return array(
			'twitter'	=> '#55acee',
			'facebook'	=> '#3b5998',
			'pinit'		=> '#bd081c',
			'hatena'	=> '#3c7dd1',
			'google'	=> '#dd4b39',
			'youtube'	=> '#ae3a34',
			'line'		=> '#00c300',
			'rss'		=> '#fe9900',
			'feedly'	=> '#87bd33',
		);
	}

	// 原色名の配列
	public function primary_colors() {
		return array(
			'#000000' => 'black',
			'#696969' => 'dimgray',
			'#808080' => 'gray',
			'#a9a9a9' => 'darkgray',
			'#c0c0c0' => 'silver',
			'#d3d3d3' => 'lightgrey',
			'#dcdcdc' => 'gainsboro',
			'#ffffff' => 'white',
			'#fffafa' => 'snow',
			'#f8f8ff' => 'ghostwhite',
			'#f5f5f5' => 'whitesmoke',
			'#fffaf0' => 'floralwhite',
			'#faf0e6' => 'linen',
			'#faebd7' => 'antiquewhite',
			'#ffefd5' => 'papayawhip',
			'#ffebcd' => 'blanchedalmond',
			'#ffe4c4' => 'bisque',
			'#ffe4b5' => 'moccasin',
			'#ffdead' => 'navajowhite',
			'#ffdab9' => 'peachpuff',
			'#ffe4e1' => 'mistyrose',
			'#fff0f5' => 'lavenderblush',
			'#fff5ee' => 'seashell',
			'#fdf5e6' => 'oldlace',
			'#fffff0' => 'ivory',
			'#f0fff0' => 'honeydew',
			'#f5fffa' => 'mintcream',
			'#f0ffff' => 'azure',
			'#f0f8ff' => 'aliceblue',
			'#e6e6fa' => 'lavender',
			'#778899' => 'lightslategray',
			'#708090' => 'slategray',
			'#2f4f4f' => 'darkslategray',
			'#b0c4de' => 'lightsteelblue',
			'#4682b4' => 'steelblue',
			'#4169e1' => 'royalblue',
			'#191970' => 'midnightblue',
			'#000080' => 'navy',
			'#00008b' => 'darkblue',
			'#0000cd' => 'mediumblue',
			'#0000ff' => 'blue',
			'#1e90ff' => 'dodgerblue',
			'#6495ed' => 'cornflowerblue',
			'#00bfff' => 'deepskyblue',
			'#87cefa' => 'lightskyblue',
			'#87ceeb' => 'skyblue',
			'#add8e6' => 'lightblue',
			'#b0e0e6' => 'powderblue',
			'#afeeee' => 'paleturquoise',
			'#e0ffff' => 'lightcyan',
			'#00ffff' => 'cyan',
			'#00ffff' => 'aqua',
			'#40e0d0' => 'turquoise',
			'#48d1cc' => 'mediumturquoise',
			'#00ced1' => 'darkturquoise',
			'#20b2aa' => 'lightseagreen',
			'#5f9ea0' => 'cadetblue',
			'#008b8b' => 'darkcyan',
			'#008080' => 'teal',
			'#2e8b57' => 'seagreen',
			'#006400' => 'darkgreen',
			'#008000' => 'green',
			'#228b22' => 'forestgreen',
			'#3cb371' => 'mediumseagreen',
			'#8fbc8f' => 'darkseagreen',
			'#66cdaa' => 'mediumaquamarine',
			'#7fffd4' => 'aquamarine',
			'#98fb98' => 'palegreen',
			'#90ee90' => 'lightgreen',
			'#00ff7f' => 'springgreen',
			'#00fa9a' => 'mediumspringgreen',
			'#7cfc00' => 'lawngreen',
			'#7fff00' => 'chartreuse',
			'#adff2f' => 'greenyellow',
			'#00ff00' => 'lime',
			'#32cd32' => 'limegreen',
			'#9acd32' => 'yellowgreen',
			'#6b8e23' => 'olivedrab',
			'#808000' => 'olive',
			'#556b2f' => 'darkolivegreen',
			'#bdb76b' => 'darkkhaki',
			'#eee8aa' => 'palegoldenrod',
			'#fff8dc' => 'cornsilk',
			'#f5f5dc' => 'beige',
			'#ffffe0' => 'lightyellow',
			'#fafad2' => 'lightgoldenrodyellow',
			'#fffacd' => 'lemonchiffon',
			'#f5deb3' => 'wheat',
			'#deb887' => 'burlywood',
			'#d2b48c' => 'tan',
			'#f0e68c' => 'khaki',
			'#ffff00' => 'yellow',
			'#ffd700' => 'gold',
			'#ffa500' => 'orange',
			'#f4a460' => 'sandybrown',
			'#ff8c00' => 'darkorange',
			'#daa520' => 'goldenrod',
			'#cd853f' => 'peru',
			'#b8860b' => 'darkgoldenrod',
			'#d2691e' => 'chocolate',
			'#a0522d' => 'sienna',
			'#8b4513' => 'saddlebrown',
			'#800000' => 'maroon',
			'#8b0000' => 'darkred',
			'#a52a2a' => 'brown',
			'#b22222' => 'firebrick',
			'#cd5c5c' => 'indianred',
			'#bc8f8f' => 'rosybrown',
			'#e9967a' => 'darksalmon',
			'#f08080' => 'lightcoral',
			'#fa8072' => 'salmon',
			'#ffa07a' => 'lightsalmon',
			'#ff7f50' => 'coral',
			'#ff6347' => 'tomato',
			'#ff4500' => 'orangered',
			'#ff0000' => 'red',
			'#dc143c' => 'crimson',
			'#c71585' => 'mediumvioletred',
			'#ff1493' => 'deeppink',
			'#ff69b4' => 'hotpink',
			'#db7093' => 'palevioletred',
			'#ffc0cb' => 'pink',
			'#ffb6c1' => 'lightpink',
			'#d8bfd8' => 'thistle',
			'#ff00ff' => 'magenta',
			'#ff00ff' => 'fuchsia',
			'#ee82ee' => 'violet',
			'#dda0dd' => 'plum',
			'#da70d6' => 'orchid',
			'#ba55d3' => 'mediumorchid',
			'#9932cc' => 'darkorchid',
			'#9400d3' => 'darkviolet',
			'#8b008b' => 'darkmagenta',
			'#800080' => 'purple',
			'#4b0082' => 'indigo',
			'#483d8b' => 'darkslateblue',
			'#8a2be2' => 'blueviolet',
			'#9370db' => 'mediumpurple',
			'#6a5acd' => 'slateblue',
			'#7b68ee' => 'mediumslateblue'
		);
	}

	// 洋色名の配列
	public function western_colors() {
		return array(
			'#ef857d' => 'coral red',
			'#ea5550' => 'poppy red',
			'#ea5550' => 'red',
			'#ea5549' => 'tomato red',
			'#ea553a' => 'vermilion',
			'#ea5532' => 'scarlet',
			'#ed6d35' => 'carrot orange',
			'#ed6d46' => 'chinese red',
			'#bd6856' => 'terracotta',
			'#98605e' => 'cocoa brown',
			'#6b3f31' => 'mahogany',
			'#6c3524' => 'chocolate',
			'#6a1917' => 'marron',
			'#622d18' => 'sepia',
			'#7b5544' => 'coffee',
			'#8f6552' => 'brown',
			'#bb5535' => 'burnt sienna',
			'#e6bfb2' => 'amber rose',
			'#e8d3ca' => 'beige rose',
			'#f3a68c' => 'salmon pink',
			'#e29676' => 'sahara',
			'#e6bfab' => 'ash rose',
			'#fbdac8' => 'shell pink',
			'#fdede4' => 'baby pink',
			'#fce4d6' => 'nail pink',
			'#e17b34' => 'raw sienna',
			'#bc611e' => 'caramel',
			'#f6b483' => 'sunset',
			'#be8f68' => 'cinnamon',
			'#bf783e' => 'tan',
			'#e9dacb' => 'champagne',
			'#fbd8b5' => 'peach',
			'#946c45' => 'cafe au lait',
			'#ee7800' => 'orange',
			'#f7b977' => 'apricot',
			'#c2894b' => 'amber',
			'#ac6b25' => 'bronze',
			'#e8c59c' => 'vanilla',
			'#c49a6a' => 'cork',
			'#6f5436' => 'burnt umber',
			'#866629' => 'raw umber',
			'#fad09e' => 'flesh',
			'#f6ae54' => 'golden yellow',
			'#f3981d' => 'mandarin orange',
			'#f39800' => 'marigold',
			'#f6e5cc' => 'ecru beige',
			'#eae1cf' => 'oyster',
			'#ba8b40' => 'ochre',
			'#c5a05a' => 'khaki',
			'#caac71' => 'buff',
			'#fac559' => 'saffron yellow',
			'#e5a323' => 'pumpkin',
			'#c4972f' => 'yellow ocher',
			'#f2d58a' => 'blond',
			'#eedcb3' => 'beige',
			'#ead7a4' => 'biscuit',
			'#ffe9a9' => 'leghorn',
			'#ffedab' => 'sunshine yellow',
			'#fff3b8' => 'cream yellow',
			'#fdd35c' => 'naples yellow',
			'#e9bc00' => 'topaz',
			'#fcc800' => 'chrome yellow',
			'#e3d7a3' => 'cream',
			'#ece093' => 'straw',
			'#edde7b' => 'jasmine yellow',
			'#c1ab05' => 'antique gold',
			'#72640c' => 'olive',
			'#665a1a' => 'olive drab',
			'#ffdc00' => 'jaune brillant',
			'#ffdc00' => 'yellow',
			'#eddc44' => 'citrus',
			'#fff799' => 'limelight',
			'#fff462' => 'canary yellow',
			'#fff462' => 'mimosa',
			'#fff352' => 'lemon yellow',
			'#e0de94' => 'melon yellow',
			'#e3e548' => 'chartreuse yellow',
			'#eaeea2' => 'lime yellow',
			'#e6eb94' => 'lime green',
			'#d9e367' => 'chartreuse green',
			'#d1de4c' => 'lettuce green',
			'#5f6527' => 'olive green',
			'#777e41' => 'moss green',
			'#7b8d42' => 'grass green',
			'#9cbb1c' => 'spring green',
			'#9fc24d' => 'leaf green',
			'#f0f6da' => 'white lily',
			'#dbebc4' => 'asparagus green',
			'#618e34' => 'citron green',
			'#65ab31' => 'meadow green',
			'#a7d28d' => 'apple green',
			'#578a3d' => 'ivy green',
			'#417038' => 'spinach green',
			'#387d39' => 'cactus',
			'#bee0c2' => 'sky green',
			'#79c06e' => 'spearmint',
			'#89c997' => 'mint green',
			'#37a34a' => 'parrot green',
			'#009944' => 'summer green',
			'#bee0ce' => 'opal green',
			'#a4d5bd' => 'spray green',
			'#004d25' => 'bottle green',
			'#3cb37a' => 'cobalt green',
			'#00984f' => 'evergreen',
			'#009854' => 'malachite green',
			'#00a960' => 'green',
			'#00a968' => 'emerald green',
			'#288c66' => 'forest green',
			'#00885a' => 'viridian',
			'#006948' => 'holly green',
			'#005c42' => 'billiard green',
			'#00533f' => 'chrome green',
			'#54917f' => 'antique green',
			'#a5c9c1' => 'water green',
			'#a3d6cc' => 'ice green',
			'#00947a' => 'turquoise green',
			'#00ac97' => 'sea green',
			'#00ac9a' => 'peppermint green',
			'#00a497' => 'peacock green',
			'#2cb4ad' => 'nile blue',
			'#418b89' => 'saxe blue',
			'#3c7170' => 'slate green',
			'#006a6c' => 'teal green',
			'#88bfbf' => 'aqua green',
			'#67b5b7' => 'aquamarine',
			'#009e9f' => 'peacock blue',
			'#009b9f' => 'turquoise',
			'#00a3a7' => 'capri blue',
			'#25b7c0' => 'cambridge blue',
			'#00afcc' => 'turquoise blue',
			'#82cddd' => 'horizon blue',
			'#a1d8e2' => 'summer shower',
			'#a1d8e6' => 'horizon blue',
			'#008db7' => 'cerulean blue',
			'#007199' => 'duck blue',
			'#006888' => 'marine blue',
			'#00608d' => 'madonna blue',
			'#0073a8' => 'egyptian blue',
			'#bbe2f1' => 'baby blue',
			'#a0d8ef' => 'sky blue',
			'#719bad' => 'shadow blue',
			'#00a1e9' => 'cyan',
			'#409ecc' => 'yacht blue',
			'#68a9cf' => 'chalk blue',
			'#88b5d3' => 'pigeon blue',
			'#a4c1d7' => 'smoke blue',
			'#bbdbf3' => 'frosty blue',
			'#006eb0' => 'bleu acide',
			'#0068b7' => 'cobalt blue',
			'#0068b7' => 'sapphire blue',
			'#0075c2' => 'spectrum blue',
			'#0075c2' => 'blue',
			'#4496d3' => 'zenith blue',
			'#68a4d9' => 'heavenly blue',
			'#bcc7d7' => 'orchid gray',
			'#bccddb' => 'powder blue',
			'#b2cbe4' => 'light blue',
			'#a2c2e6' => 'baby blue',
			'#a3b9e0' => 'day dream',
			'#94adda' => 'salvia blue',
			'#7a99cf' => 'hyacinth blue',
			'#6c9bd2' => 'hyacinth',
			'#001e43' => 'midnight blue',
			'#202f55' => 'navy blue',
			'#192f60' => 'prussian blue',
			'#192f60' => 'iron blue',
			'#043c78' => 'indigo',
			'#003f8e' => 'ink blue',
			'#26499d' => 'oriental blue',
			'#4753a2' => 'ultramarine blue',
			'#434da2' => 'ultramarine',
			'#8d93c8' => 'wistaria',
			'#a4a8d4' => 'blue lavender',
			'#4d4398' => 'pannsy',
			'#5a4498' => 'violet',
			'#9079b6' => 'heliotrope',
			'#47266e' => 'deep royal purple',
			'#56256e' => 'grape',
			'#915da3' => 'mauve',
			'#c7a5cc' => 'iris',
			'#d1bada' => 'lilac',
			'#cab8d9' => 'lavender',
			'#b79fcb' => 'crocus',
			'#a688bd' => 'lavender mauve',
			'#9b72b0' => 'purple',
			'#7f1184' => 'royal purple',
			'#6b395f' => 'raisin',
			'#6c2463' => 'plum',
			'#841a75' => 'raspberry',
			'#9a0d7c' => 'framboise',
			'#a50082' => 'dahlia purple',
			'#af0082' => 'orchid purple',
			'#9f166a' => 'raspberry red',
			'#d9aacd' => 'orchid',
			'#e0b5d3' => 'lilla',
			'#e6afcf' => 'rose tendre',
			'#da81b2' => 'orchid pink',
			'#d04f97' => 'cyclamen pink',
			'#e4007f' => 'magenta',
			'#e62f8b' => 'bougainvillaea',
			'#c70067' => 'ruby',
			'#941f57' => 'claret',
			'#d83473' => 'azalee',
			'#dc6b9a' => 'cosmos',
			'#de82a7' => 'lotus pink',
			'#e3adc1' => 'old orchid',
			'#debecc' => 'rose mist',
			'#e5c1cd' => 'rose dragee',
			'#eb6ea0' => 'cherry pink',
			'#e95388' => 'opera',
			'#ea618e' => 'rose red',
			'#b0778c' => 'old lilac',
			'#6e4a55' => 'cocoa',
			'#b33e5c' => 'wine red',
			'#942343' => 'garnet',
			'#c82c55' => 'cochineal red',
			'#e73562' => 'strawberry',
			'#e73562' => 'ruby red',
			'#d70035' => 'carmine',
			'#e8383d' => 'signal red',
			'#6c2735' => 'burgundy',
			'#6c272d' => 'bordeaux',
			'#da536e' => 'camellia',
			'#e95464' => 'rose',
			'#f19ca7' => 'rose pink',
			'#f5b2b2' => 'pink',
			'#f5b2ac' => 'flamingo pink',
			'#e29399' => 'old rose',
			'#e3acae' => 'pink almond',
			'#e6c0c0' => 'rose dust',
			'#ffffff' => 'white',
			'#fafdff' => 'snow white',
			'#fef9fb' => 'pink white',
			'#fffff9' => 'milky white',
			'#fff9f5' => 'amber white',
			'#f7f6fb' => 'lavender ice',
			'#f7f6f5' => 'pearl white',
			'#f8f4e6' => 'ivory',
			'#f5ecf4' => 'powder pink',
			'#efefef' => 'silver white',
			'#e8ece9' => 'frosty gray',
			'#eeeaec' => 'silver pink',
			'#eee9e6' => 'beige cameo',
			'#eee7e0' => 'ecru',
			'#ede4e1' => 'pink beige',
			'#e6eae6' => 'frosty white',
			'#eae8e1' => 'oyster white',
			'#d3d6dd' => 'wisteria mist',
			'#d4d9df' => 'cloud',
			'#d4d9dc' => 'moon gray',
			'#d4dcd3' => 'china clay',
			'#dcd6d2' => 'sand beige',
			'#d3d3d8' => 'orchid mist',
			'#d4d9d6' => 'reed gray',
			'#cbd0d3' => 'sky gray',
			'#bcbace' => 'lavender gray',
			'#c9caca' => 'silver',
			'#c9c9c4' => 'pearl gray',
			'#c9c9c2' => 'sand gray',
			'#c0c5c2' => 'marble gray',
			'#bfbec5' => 'opal gray',
			'#8da0b6' => 'french gray',
			'#b4aeb1' => 'mist',
			'#b5b5ae' => 'ash blond',
			'#abb1b5' => 'fog',
			'#b4ada9' => 'beige gray',
			'#afafb0' => 'silver gray',
			'#aaaab0' => 'storm gray',
			'#abb1ad' => 'green fog',
			'#9fa09e' => 'ash gray',
			'#9d8e87' => 'rose gray',
			'#9f9f98' => 'elephant skin',
			'#898989' => 'battleship gray',
			'#898880' => 'stone gray',
			'#7e837f' => 'moss gray',
			'#7d7b83' => 'dove gray',
			'#7d7d7d' => 'gray',
			'#736d71' => 'steel gray',
			'#666c67' => 'ivy gray',
			'#626063' => 'slate gray',
			'#594e52' => 'graphite',
			'#4e454a' => 'charcoal gray',
			'#504946' => 'taupe',
			'#24140e' => 'lamp black',
			'#000000' => 'black'
		);
	}
}
