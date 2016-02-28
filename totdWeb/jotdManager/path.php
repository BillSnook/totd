<?php

// Universal function definitions

// Form helper routines
function clean_input( $value ) {

	// If a number, we're clean - no further cleanup needed
	if ( is_numeric( $value ) ) {
		return( $value );
	}
	// Strip slashes if necessary
//	if ( get_magic_quotes_gpc( ) ) {
//		$value = stripslashes( $value );
//	}
    // Make sure no sql-dangerous code gets through
	$value = mysql_real_escape_string( $value );
	// Strip HTML tags, to be sure
	// May need another routine to allow input of HTML
	$value = strip_tags( $value );

	return( $value );
}

// Used to help set the selected option for form menus
function setSelected( $isSelected ) {

	if ( $isSelected )
		return( " selected" );
	else
		return( "" );
}

function normalize_input( $inputField, $placeHolderText ) {

	$cleaned_input = clean_input( $inputField );
	if ( $cleaned_input == $placeHolderText )
		return( '' );
	else
		return( $cleaned_input );
}

function set_value( $nomValue, $altValue ) {

	if ( $nomValue == "" )
		return( $altValue );
	else
		return( $nomValue );
}

function set_color( $nomValue ) {

	if ( $nomValue == "" )
		return( "#808080" );
	else
		return( "#000000" );
}


//  ----    ----


session_name('jotdManager');
session_start();

if ( ! isset( $_SESSION['absolutepath'] ) ) {
	// We expect to first be called from the home page, index.php in the root folder
	$_SESSION['absolutepath'] = substr( $_SERVER["SCRIPT_FILENAME"], 0, strlen( $_SERVER["SCRIPT_FILENAME"] ) - 9 );
	$_SESSION['hosthttppath'] = 'http://' . $_SERVER["HTTP_HOST"] . substr( $_SERVER["SCRIPT_NAME"], 0, strlen( $_SERVER["SCRIPT_NAME"] ) - 9 );
}
/*
$_SESSION['absolutepath'] = "/Users/bill/Sites/MWA/";
$_SESSION['hosthttppath'] = "http://" . $_SERVER["HTTP_HOST"] . "/~bill/MWA/";
*/
require( $_SESSION['absolutepath']."admin/mysql_connect.php" );

require( $_SESSION['absolutepath']."admin/checkUser.php" );

?>