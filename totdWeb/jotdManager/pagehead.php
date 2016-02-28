<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?=$PageTitle?></title>
<meta name="publisher" content="jotdManager"/>
<meta name="language" content="English"/>
<meta name="copyright" content="2015"/>
<meta name="robots" content="index, follow, noodp, noydir"/>
<!-- width=device-width,initial-scale=1.0,user-scalable=no -->
<meta name="viewport" content="width=device-width">

<link rel="stylesheet" type="text/css" href="<?=$_SESSION['hosthttppath']?>style.css" />
<link rel="stylesheet" type="text/css" media="only screen and (max-device-width: 480px)" href="<?=$_SESSION['hosthttppath']?>small_mobile.css" />

<?=$LocalStyle?>
<?=$LocalScript?>
</head>

<body <?=$htmlbodytagadd?> >

<div id="container">

	<div id="header">
<?php
    if ( $logged ) {
//        if ( ! empty( $_SESSION['tab'] ) ) 
//        	echo( "Current tab: ".$_SESSION['tab'] );
//        else 
//        	echo( "No current tab" );
		if ( ! isset( $bannerPane ) ) {
			$bannerPane = "nullBanner";
		}

//		echo( '$htmlbodytagadd is [' . $htmlbodytagadd . ']' );

        echo( '<div class="greetings">' );
		if ( ! isset( $workOptionsBar ) ) {
			echo(
                 '<span class="greetSpan"><a href="'.$_SESSION['hosthttppath'].'settings/settings.php" class="nav-tools" onclick"resetFormState();">Settings</a></span>'
			);
			if ( ! empty( $_SERVER['HTTP_REFERER'] ) ) {
				echo(
                     '<span class="greetSpan"><a href="'.$_SERVER['HTTP_REFERER'].'" class="nav-tools" onclick"resetFormState();">Back</a></span>'
				);
			}
			echo(
                 '<span class="greetSpan"><a href="'.$_SESSION['hosthttppath'].'index.php" class="nav-tools" onclick"resetFormState();">Home</a></span>'.
                 '<span><a href="'.$_SESSION['hosthttppath'].'admin/logout.php" class="nav-tools" onclick"resetFormState();">Log out</a></span>'
			);
		} else {
			echo(
                 '<a href="" class="nav-tools" onclick="window.close();return false;">Close this window.</a>'
			);
		}
        echo( '</div><div class="clear"></div>' );
        echo( '<div class="greetings">' );
		echo(
             '<div id="Clock"><span id="liveclock"></span></div>'.
             '<script type="text/javascript">setup_clock()</script>'.
             '<div id="Info">Login: '
		);
		if ( isset( $_SESSION['FullName'] ) ) {
        	echo( $_SESSION['FullName'] );
		} else {
        	echo( $_SESSION['UserName'] );
		}
        echo('</div>');

        echo('</div>'); // greetings
		
		// Only display banner if logged in!
//		echo(
//             '<div class="clear"></div>'.
//             '<div class="greetings">'.
//             '<div id="Banner"><span id="'.$bannerPane.'" class="msg-type">&nbsp;</span></div>'.
//             '</div>'
//		);
    } else {		// Else not logged in now
        echo( '<div class="greetings">' );
		if ( isset( $_SESSION['FullName'] ) ) {
			echo( 'Welcome back, ' . $_SESSION['FullName'] );
		} else {
			if ( isset( $username ) ) {
				echo( 'Welcome back, ' . $username );
			} else {
				echo( 'Welcome to the jotd Web Application' );
			}
		}
		echo( ' &nbsp; &nbsp; Please Log In.' );
		echo( '</div><div class="clear"></div>' );
		echo(
             '<div class="greetings">'.
             '<div id="Clock"><span id="liveclock"></span></div>'.
             '<div class="clear"></div>'.
             '<script type="text/javascript">setup_clock()</script>'.
             '</div>'
		);
		
	}
?>
	</div><!-- end of div header -->
<?php
    if ( ! $logged ) {      // If not logged in, display login page with form
        echo('
		<div id="page-body">
		 <table width="90%" height="200" align="center" border="0" cellpadding="0" cellspacing="0">
		  <tr>
		   <td class="main">
        ');
	include( $_SESSION['absolutepath']."admin/login.php" );
        echo('
		   </td>
		  </tr>
		 </table>
		 <br />
		</div>
        ');
	}
?>