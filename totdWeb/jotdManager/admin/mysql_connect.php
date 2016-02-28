<?php	// mysql_connect.php -- A script to connect to sql for us

	include( "mysql_cred_user.php" );

	// Make the connection
	$prdbc = @mysql_connect( DB_HOST, DB_USER, DB_PASS );
    if ( $prdbc ) {
        // Select the database
        if ( ! @mysql_select_db( DB_NAME) ) {
//            header("Location: startup/initDB.php");
            DIE ( 'Could not select the database: ' . mysql_error() );
            exit;
        }
    } else {
//        header("Location: startup/initDB.php");
        DIE ( 'Could not connect to the database: ' . mysql_error() );
        exit;
    }

?>