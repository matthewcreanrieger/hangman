var easy = [ 'APPLE', 'RABBIT', 'COMPUTER', 'JAPAN', 'AMERICA', 'CHRISTMAS', 'CAT', 'LEMON', 'CAKE' ];
var medium = [ 'APPROCIATE', 'DONATION', 'OBSESSED', 'RATIONAL', 'GYM', 'TSUNAMI', 'KETTLE', 'TURKEY', 'TYPHOON' ];
var hard = [ 'JAZZ', 'IMPECCABLE', 'SALIENT', 'ZENITH', 'MYRIAD', 'JUBILANT', 'INSULAR', 'FORSAKE', 'DEMURE' ];
var imgs = [ 'assets/0.png', 'assets/1.png', 'assets/2.png', 'assets/3.png', 'assets/4.png', 'assets/5.png', 'assets/6.png' ];
var letters = document.getElementById ( 'letters' ) .childNodes;
var wins;
var losses;
var listID;
var match;
var rights;
var wrongs;

function resetGame ( difficulty ) {
	//reset info and img
	listID = difficulty;
	rights = wrongs = 0;
	document.getElementById ( 'img' ) .src = imgs [ wrongs ];
	
	//reset choices
	for ( var i = 0; i < letters.length; i++ ) {
		letters [ i ] .disabled = false;
		$ ( letters [ i ] ) .removeClass ( 'btn-success' ) .removeClass ( 'btn-danger' );
	}
	
	//reset word
	$ ( '#easy' ) .removeClass ( 'btn-success' );
	$ ( '#medium' ) .removeClass ( 'btn-warning' );
	$ ( '#hard' ) .removeClass ( 'btn-danger' );
	if ( difficulty === 'Easy' ) {
		word = easy [ Math.floor ( Math.random () * easy.length ) ];
		$ ( '#easy' ) .addClass ( 'btn-success' );
	}
	if ( difficulty === 'Medium' ) {
		word = medium [ Math.floor ( Math.random () * medium.length ) ];
		$ ( '#medium' ) .addClass ( 'btn-warning' );
	}
	if ( difficulty === 'Hard' ) {
		word = hard [ Math.floor ( Math.random () * hard.length ) ];
		$ ( '#hard' ) .addClass ( 'btn-danger' );
	}
	
	//reset underscore display
	match = "";
	for ( var i = 0; i < word.length; i++ ) 
		match += '_ ';
	$ ( '#answer' ) .html ( match );
}

function choice ( letter ) {
	letter.disabled = true;
	
	//assume incorrect choice
	var correct = false;
	$ ( letter ) .addClass ( 'btn-danger' );
	
	//check if correct choice
	for ( var i = 0; i < word.length; i++ ) {
		if ( word.charAt ( i ) === letter.innerHTML ) {
			correct = true;
			++rights;
			match = match.replaceAt ( i * 2, letter.innerHTML );
			$ ( '#answer' ) .html ( match );
			$ ( letter ) .removeClass ( 'btn-danger' ) .addClass ( 'btn-success' );
		}
	}
	
	//check for win
	if ( rights === word.length ) {
			//CALL PHP SCORE FUNCTION
			for ( var i = 0; i < letters.length; i++ ) 
				letters [ i ] .disabled = true;
			wins = document.getElementById ( 'wins' ) .innerHTML;
			wins = wins.substr ( 6, wins.length );
			$ ( '#wins' ) .html ( 'Wins: ' + ++wins );
			$.get( "http://riegerm2.cse252.spikeshroud.com/CSE252/semesterproject/semesterproject/updateWins.php", function( data ) {});
			alert ( 'You Win!' );
	}
	
	//check for loss
	if ( correct === false ) {
		document.getElementById ( 'img' ) .src = imgs [ ++wrongs ];
		if ( wrongs === 6 ) {
			for ( var i = 0; i < letters.length; i++ ) 
				letters [ i ] .disabled = true;
			match = "";
			for ( var i = 0; i < word.length; i++ )
				match += word.charAt ( i ) + " ";
			$ ( '#answer' ) .html ( match );
			losses = document.getElementById ( 'losses' ) .innerHTML;
			losses = losses.substr ( 8, losses.length );
			$ ( '#losses' ) .html ( 'Losses: ' + ++losses );
			$.get( "http://riegerm2.cse252.spikeshroud.com/CSE252/semesterproject/semesterproject/updateLosses.php", function( data ) {});
			alert ( 'You Lose' );
		}
	}
}

function $ ( id ) { return document.getElementById ( id ); }

String.prototype.replaceAt = function ( index, character ) { return this.substr ( 0, index ) + character + this.substr ( index + character.length ); }