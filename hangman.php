<?php

require('PasswordHash.php');
require('db.php');
require('functions.php');
// require('updateWins.php');
$content = "";
$activepage = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user,$password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "<br />";
    die();
}

session_start();

if (isset($_GET['endsession'])) {
	$_SESSION = array();
 	$params = session_get_cookie_params();
 	setcookie(session_name(), '', time() - 42000,
 	$params["path"],
 	$params["domain"], $params["secure"],
 	$params["httponly"]);
}

if (isset($_GET['endsession'])) {
	 $_SESSION = array();
 	$params = session_get_cookie_params();
 	setcookie(session_name(), '', time() - 42000,
 	$params["path"],
 	$params["domain"], $params["secure"],
 	$params["httponly"]);
 }
 
if(!isset($_SESSION['auth'])) {
    $_SESSION['auth'] = false;
    $_SESSION['username'] = '';
}

require('templates.php');


if (isset($_GET['register'])) {
    $activepage .= $gameactive;
	$content .= $registerForm;
} else if (isset($_POST['signup'])) {
    $activepage .= $gameactive;
	$errorFlag = false;
    if($_POST['password'] != $_POST['password2']) {
        $errorFlag = true;
        $content .= $passwordMatchError;
    }

    if(isUsernameTaken($_POST['username'])) {
        $errorFlag = true;
        $content .= $usernameTakenError;
    }

    if (!$errorFlag) {
    		$errorFlag = !createUser($_POST['username'], $_POST['password'], $_POST['firstName'], $_POST['lastName'], 0, 0);

        if (!$errorFlag) {
            $content .= $userCreated;
        }
        else {
            $content .= $registrationError;
        }
    }

    if(!$errorFlag) 
        $content .= $mainContent;
    else
        $content .= $registerForm;
} else if (isset($_POST['username'])) {
    $activepage .= $gameactive;
	if (checkAuth($_POST['username'], $_POST['password'])) {
        $_SESSION['auth'] = true;
        $_SESSION['username'] = $_POST['username'];
        $content .= $mainContent;
    } else {
        $content .= $loginError;
        $content .= $mainContent;
    }

} else if (isset($_GET['leaderboard']) && $_SESSION['username'] != "") {
	$activepage .= $leaderboardactive;
	// updateWins($_SESSION['username']);
	showLeaderboard();
} else {
	$activepage .= $gameactive;
	$content .= $mainContent;
}

if ($_SESSION['auth'] === true)
    $login = $loggedInNav;
else
    $login = $navbarHeader;


if (isset($_GET['leaderboard']) && $_SESSION['username'] == "") {
	echo '<script language="javascript">alert("You must log in to view the leaderboard!")</script>';
} 
?>


<!doctype html>
<html lang="en">
    <head>
        <title>Hangman</title>
        <meta charset="utf-8">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    </head>
    <body onload='resetGame ( "Easy" )'>
        	<?=$activepage?>
			<?=$login?>
        	<?=$content?>
        	<script src="hangman.js"></script>
        	<script src="http://code.jquery.com/jquery-2.1.3.min.js"></script>
        	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    </body>
</html>
