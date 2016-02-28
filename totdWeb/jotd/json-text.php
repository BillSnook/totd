<?php

    function clean_input( $value ) {
        
        // If a number, we're clean - no further cleanup needed
        if ( is_numeric( $value ) ) {
            return( $value );
        }
        // Strip slashes if necessary
        if ( get_magic_quotes_gpc( ) ) {
            $value = stripslashes( $value );
        }
        // Make sure no sql-dangerous code gets through
        $value = mysql_real_escape_string( $value );
        // Strip HTML tags, to be sure
        // May need another routine to allow input of HTML
        $value = strip_tags( $value );
        
        return( $value );
    }
    
    $joke_idx = clean_input( $_REQUEST['jidx'] );
    if ( $joke_idx ) {
        $idx = $joke_idx;
    } else {
//        $today = time();
//        $millenium = strtotime("2000-01-01");
//        $idx = round(abs($today-$millenium)/60/60/24);
        $idx = 0;
    }
//    $newidx = $idx;

	require( "../jotdManager/admin/mysql_connect.php" );
    
    $query = "SELECT id FROM jokes";
    $jokes_result = @mysql_query( $query );
    if ( $jokes_result ) {
        $cnt = mysql_num_rows( $jokes_result );
        $newidx = ($idx % $cnt) + 1;  // Zero-based index modulo the size of the joke database to one-based index
//        echo("idx: " . $idx . ", cnt: " . $cnt . ", newidx: " . $newidx . "<br/>");
        mysql_free_result( $jokes_result );

        $query = "SELECT id, joke_text FROM jokes WHERE id = " . $newidx;
        $jokes_result = @mysql_query( $query );
        if ( $jokes_result ) {
            $numRows = mysql_num_rows( $jokes_result );
            if ( $numRows >= 1 ) {		// We expect at least one
                $makeJSON = "[{";
//                echo('[{');
                while ( $joke_row = mysql_fetch_array( $jokes_result ) ) {
                    $idx = $joke_row['id'];
                    $joke = $joke_row['joke_text'];
                    $joke = str_replace("\\'", "'", $joke);
                    $joke = str_replace("\r\n", "  ", $joke);
                    $makeJSON = $makeJSON . '"idx":"' . $idx . '","jotd":"' . $joke . '"';
//                    echo('"idx":"' . $idx . '","jotd":"' . $joke . '"');
                    if ( $numRows > 1 ) {
                        $numRows--;
                        $makeJSON = $makeJSON . '},{';
//                        echo('},{');
                    }
                }
                $makeJSON = $makeJSON . "}]";
                echo( $makeJSON );
//                echo('}]');
            } else {
                echo('{"jotd":"Empty joke table."}');
            }
            mysql_free_result( $jokes_result );
        } else {
            echo('{"jotd":"No joke table."}');
        }
    } else {
        echo('{"jotd":"No jokes table."}');
    }

?>
