<?php
	$PageTitle="jotdManagement";
    // Additional local styles for pagehead.php
	$LocalStyle="";
    // Additional local scripts used in content files--
	$LocalScript = '<script src="settings/setupajlib.js"></script>';

    define( 'JOKE_ADD', "Add New Joke" );
    define( 'JOKE_UPD', "Update Joke" );

	include( "path.php" );
	
	$bannerPane = 'bannerPane';

	$htmlbodytagadd = ' onload="';
	$htmlbodytagadd .= "setHostPath('".$_SESSION['hosthttppath']."');";
	if ( $logged ) {
		$htmlbodytagadd .= "setupBanner( '$bannerPane' );";		// Start banner refresh check to repeat every ten seconds
	} else {
		$htmlbodytagadd .= "setPasswordFocus();";
	}
	$htmlbodytagadd .= "window.scrollTo(0,1);";
    $htmlbodytagadd .= '"';

	include( $_SESSION['absolutepath']."pagehead.php" );

	if ( $logged ) {
        if ( isset( $_REQUEST['form_type'] ) ) {	// If a submission has occurred, we would like to save the new data or update info
            $formType = clean_input( $_REQUEST['form_type'] );
            $joke_text = clean_input( $_REQUEST['joke_text'] );
            if ( JOKE_ADD == $formType ) {
                $query = "INSERT INTO jokes ( joke_text ) VALUES ( '$joke_text' )";
                $insert_result = @mysql_query( $query );
            }
            if ( JOKE_UPD == $formType ) {
                $jid = clean_input( $_REQUEST['id'] );
//                $errmsg = "edit joke_text: " . $joke_text . " for id: " . $jid;
                $query = "UPDATE jokes SET joke_text = '$joke_text' WHERE id = " . $jid;
                $insert_result = @mysql_query( $query );
            }
        }
        if ( isset($_REQUEST['delete_id']) ) {      // Check for delete_id
            // Delete existing entry
            $delete_id = clean_input( $_REQUEST['delete_id'] );
            $query = "DELETE FROM jokes WHERE id = " . $delete_id;
            $del_result = @mysql_query( $query );
        }
?>

<!-- begin page body which defines all content and divs -->
<div id="page-body">
    <div class="tabViewSpace">
        <div id="mainPane">
            <br/>
<?php

        if ( isset($_REQUEST['edit_id']) ) {				// If edit_id with id of joke entry to edit/update
            // Edit existing entry
            $edit_id = strip_tags( mysql_real_escape_string( $_REQUEST['edit_id'] ) );
            // Then select the appropriate data
            $query = "SELECT * FROM jokes WHERE id = " . $edit_id;
            $jokes_result = @mysql_query( $query );
            if ( $jokes_result ) {
                if ( mysql_num_rows( $jokes_result ) == 1 ) {		// We expect one
                    // Update joke
                    $formType = JOKE_UPD;
                    $joke_row = mysql_fetch_array( $jokes_result );
                    $oldJoke = $joke_row['joke_text'];
					$oldJoke = stripslashes( $oldJoke );
?>

            <fieldset>
            <legend><?=$formType?></legend>
            <table>
                <form action = "<?=$_SERVER[PHP_SELF]?>" method = "post">
                    <tr>
                        <td><b>Edit Joke:</b></td>
                        <td>
							<textarea name = "joke_text" rows = "10" cols = "80" value="" /><?=$oldJoke?></textarea>
						</td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><input type = "submit" name = "submit" value = "<?=$formType?>" /></td>
                            <input type = "hidden" name="id" value="<?=$edit_id?>" />
                            <input type = "hidden" name="form_type" value="<?=$formType?>" />
                    </tr>
                </form>
            </table>
            </fieldset>

<?php
                }
                mysql_free_result( $jokes_result );
            }
        } else if ( isset($_REQUEST['new_id']) ) {          // Else no edit_id - check for new_id to add new joke
            // Create new entry
            $formType = JOKE_ADD;
?>

            <fieldset>
            <legend><?=$formType?></legend>
            <table>
                <form action = "<?=$_SERVER[PHP_SELF]?>" method = "post">
                    <tr>
                        <td><b>New Joke:</b></td>
                        <td>
							<textarea name = "joke_text" rows = "10" cols = "80" value="" /></textarea>
						</td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><input type = "submit" name = "submit" value = "<?=$formType?>" /></td>
                            <input type = "hidden" name="form_type" value="<?=$formType?>" />
                    </tr>
                </form>
            </table>
            </fieldset>

<?php
        } else {                                            // Else display all jokes
            // No params, show all jokes
            $query = "SELECT * FROM jokes";
            $jokes_result = @mysql_query( $query );
             // First check if one user is being setup (else all users)
            if ( $jokes_result ) {
                if ( mysql_num_rows( $jokes_result ) > 0 ) {		// We expect at least one
                    echo('
                <table border="1" cellspacing="0" cellpadding="4">
                    <tr>
                        <td>
                            ID
                        </td>
                        <td>
                            Joke
                        </td>
                        <td width="20">
                            <a href="index.php?new_id=0">
                                Add A Joke
                            </a>
                        </td>
                    </tr>
                    ');
                    while ( $joke_row = mysql_fetch_array( $jokes_result ) ) {
						 $nextJoke = $joke_row['joke_text'];
						 $nextJoke = stripslashes( $nextJoke );
                        echo('
                    <tr bgcolor="'.$bgclr.'">
                        <td>
                            '.$joke_row['id'].'
                        </td>
                        <td>
                            '.$nextJoke.'
                        </td>
                        <td>
                            <a href="index.php?edit_id='.$joke_row['id'].'">Edit</a>
                        ');
//                            |
//                            <a href="index.php?delete_id='.$joke_row['id'].'" onClick="return(checkOkToDelete())">Delete</a>
                        echo('
                        </td>
                    </tr>
                        ');
                    }
                } else {
                    echo('
                    <tr>
                        <td colspan="3">
                            The user search has failed: there are no jokes yet.<br/>Please create some soon!
                            <br/>
                            <a href="index.php?new_id=0">
                                Add one now!
                            </a>
                            <br/>
                        </td>
                    </tr>
                    ');
                }
                mysql_free_result( $jokes_result );
            } else {
                echo('
                    <tr>
                        <td colspan="3">
                            The joke search has failed: ' . mysql_error() . '<br/>Please contact the network administrator.<br/><br/>
                        </td>
                    </tr>
                ');
            }
        }
        echo('
            </table>
        </div>
    </div>
    <br/>
    <br/>
</div>
        ');
    }
	include( $_SESSION['absolutepath']."pagefoot.php" );
?>