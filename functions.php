<?php

function isUsernameTaken($username) {
    global $pdo;
    //this query gets a count of users who already have the provided username
    $query = "SELECT COUNT(*) FROM customers WHERE username = :username";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    //return TRUE if there was a query error; this makes it seem like the user exists when it might now
    if($count === FALSE) {
        return TRUE;
    }

    if ($count > 0)
        return TRUE;
    else
        return FALSE;
}
function createUser($username, $password, $firstname, $lastname, $wins, $losses) {
    global $pdo;
    //Salt and hash the provided password
    $hasher = new PasswordHash(8, FALSE);
    $hash = $hasher->HashPassword($password);

    //this query inserts the new user record into the table with the salted and hashed password
    $query = "INSERT INTO customers (username, password, first_name, last_name, wins, losses) VALUES (:username, :password, :first_name, :last_name, :wins, :losses)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":password", $hash);
    $stmt->bindParam(":first_name", $firstname);
    $stmt->bindParam(":last_name", $lastname);
    $stmt->bindParam(":wins", $wins);
    $stmt->bindParam(":losses", $losses);

    return $stmt->execute();
}

function checkAuth($username, $password) {
    global $pdo;
    //This query gets the password hash from the user table for the user attempting to login
    $query = "SELECT password FROM customers WHERE username = :username";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();
    $result = $stmt->fetchColumn();

    if ($result === FALSE)
        return FALSE;

    //Hash the provided password and compare to the hash from the database
    $hasher = new PasswordHash(8, FALSE);

    return $hasher->CheckPassword($password, $result);
}

function getWins ($username) {
	global $pdo;
	$query = "SELECT wins FROM customers WHERE username = '$username'";
   $stmt = $pdo->prepare($query);
   $stmt->execute();
   $result = $stmt->fetchColumn();
   if ($result === FALSE)
        return FALSE;
   return $result;
}

function getLosses ($username) {
	global $pdo;
	$query = "SELECT losses FROM customers WHERE username = '$username'";
   $stmt = $pdo->prepare($query);
   $stmt->execute();
   $result = $stmt->fetchColumn();
   if ($result === FALSE)
        return FALSE;
   return $result;
}

function updateWins ($username) {
	echo '<script language="javascript">alert("You !")</script>';
	global $pdo;
	$sql = "UPDATE customers SET wins = wins + 1 WHERE username = '$username'";
   $stmt = $pdo->prepare($sql);
   $stmt->execute();
}

function updateLosses ($username) {
	global $pdo;
	$sql = "UPDATE customers SET losses = losses + 1 WHERE username = '$username'";
   $stmt = $pdo->prepare($sql);
   $stmt->execute();
}

function showLeaderboard () {
	global $pdo;
	
	echo '<div class="container"><br><br><br><br><br><br><br>';
   echo '<table class="table table-striped" style="border: solid 1px black;">';
	echo "<tr><th>Username</th><th>Wins</th><th>Losses</th></tr>";

	class TableRows extends RecursiveIteratorIterator { 
		 function __construct($it) { 
			  parent::__construct($it, self::LEAVES_ONLY); 
		 }

		 function current() {
			  return "<td style='width:150px;border:1px solid black;'>" . parent::current(). "</td>";
		 }

		 function beginChildren() { 
			  echo "<tr>"; 
		 } 

		 function endChildren() { 
			  echo "</tr>" . "\n";
		 } 
	} 

	try {
		 $stmt = $pdo->prepare("SELECT username, wins, losses FROM customers ORDER BY wins DESC"); 
		 $stmt->execute();

		 // set the resulting array to associative
		 $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 
		 foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) { 
			  echo $v;
		 }
	}
	catch(PDOException $e) {
		 echo "Error: " . $e->getMessage();
	}
	$conn = null;
	echo "</table></div>";
}