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

------------------------
Luxeritas Theme の使い方
------------------------

1. ブラウザキャッシュや Gzip 圧縮による高速化のために、付属の htaccess.txt に書かれている内容を WordPress の .htaccess に "追記" してください(上書きは不可)

   ※ Apache Webserver で運用している場合のみ効果があります。自分が運用しているサーバーの種類が分からなくとも、とりあえず書いておいて損はありません。

2. 自分で作成した favicon.ico を表示したい場合は、
   images/ フォルダ内にある favicon.ico を上書きしてください。

3. 自分で作成したアップルタッチアイコン画像を表示したい場合は、
   images/ フォルダ内にある apple-touch-icon-precomposed.png を上書きしてください。

4. 画像がない場合のデフォルトの og:image や twitter:image を独自の画像に設定したい場合は、images/ フォルダ内にある og.png を上書きしてください。

   ※ ページ単位では、投稿・編集画面で画像を選択できます。

5. ヘッダーに CSS や Javascript を追加したい場合は、add-header.php に追記してください。

6. フッターに CSS や Javascript を追加したい場合は、add-footer.php に追記してください。

7. 記事や固定ページ単位でヘッダーに CSS や Javascript 追加したい場合は、記事投稿(編集)画面で、カスタムフィールドに addhead という名前を追加し、値の部分に CSS や Javascript を書くことで、ヘッダーに追加することもできます。

8. 記事や固定ページ単位で AMP にスタイルを追加したい場合は、記事投稿(編集)画面で、カスタムフィールドに amp-custom という名前を追加し、値の部分にスタイルを書くことで CSS を追加できます

   ※ "amp-custom" の値は <style> </style> で囲まないでください。

9. WordPress 管理画面の「外観 -> カスタマイズ」を選択して、自分の好みに応じてカスタマイズしてみてください。
