/*! Luxeritas WordPress Theme - free/libre wordpress platform
 *
 * @copyright Copyright (C) 2015 Thought is free.
 * @link https://thk.kanzae.net/
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPL v2 or later
 * @author LunaNuko
 */

/*
---------------------------------------------
 記事投稿・編集画面・その他管理画面で画像選択
--------------------------------------------- */
function thkImageSelector( id, title ) {
	jQuery(document).ready(function($){
		if( typeof( _wpMediaViewsL10n ) === 'undefined' ) return;
		if( typeof( _thkImageViewsL10n ) === 'undefined' ) return;

		var custom_uploader
		,   s = document.createElement('style');

		// 日付選択のスタイル
		s.id = 'thkImageSelector';
		s.innerText = 'select#media-attachment-date-filters{width:100%;max-width:100%;}';
		document.getElementsByTagName('head')[0].appendChild( s );

		id = '#' + id;

		$(id + '-set').click(function(e) {
			$(id).addClass('image');

			e.preventDefault();
			if( custom_uploader ) {
				custom_uploader.open();
				return;
			}
			custom_uploader = wp.media({
				title: title + ' ' + _wpMediaViewsL10n.select,

				library: {
					type: 'image' // 選択できるものを image だけにする
				},
				button: {
					text: _thkImageViewsL10n.setImage
				},
				multiple: false // true だと、複数の画像を選択可
			}); 
			custom_uploader.on('select', function() {
				var images = custom_uploader.state().get('selection');

				images.each(function(file){
					// 選択した画像をプレビューとして表示
					$(id + '-view').html(
						'<img src="' + file.toJSON().url + '" alt="' + title + '" width="1" height="1" ' +
						'style="max-width:100%;width:auto;height:auto" />'
					);
					// 選択した画像の URL をカスタムフィールドの値として渡す
					$('.image').val( file.toJSON().url );
					$(id).removeClass('image');
				});
			}); 
			custom_uploader.open();
		}); 

		$(id + '-del').click(function(e) {
			$(id).addClass('image');
			// 削除ボタン押されたら、プレビュー画像消す
			$(id + '-view').html( null );
			// 削除ボタン押されたら、カスタムフィールドに null 渡す
			$('.image').val( null );
			$(id).removeClass('image');
		}); 
	});
}
