jQuery( function($) {
	var words = [];
	var stc = $.SuperTextConverter();
	words = $("#search-result").val().replace( /^\s+|\s+$/g, "" ).replace( /\s+/g, " " ).split(" ");
	for( i in words ) {
		if( words[i] != "" ) {
			$("section").highlight( words[i] );
			if( words[i] != stc.toHankaku( words[i] ) ) $("section").highlight( stc.toHankaku( words[i] ) );
			if( words[i] != stc.toHiragana( words[i] ) ) $("section").highlight( stc.toHiragana( words[i] ) );
			if( words[i] != stc.toKatakana( words[i] ) ) $("section").highlight( stc.toKatakana( words[i] ) );
			if( words[i] != stc.killHankakuKatakana( words[i] ) ) $("section").highlight( stc.killHankakuKatakana( words[i] ) );
			if( words[i] != stc.toHiragana( stc.killHankakuKatakana( words[i] ) ) ) $("section").highlight( stc.toHiragana( stc.killHankakuKatakana( words[i] ) ) );
		}
	}
});
