<?php
include_once 'db_connect.php';
include_once 'functions.php';
// include_once 'db_connect.php';
// var_dump($_GET);
if (isset($_GET['username'], $_GET['email']) && !isset($_GET['security_answer']) && !isset($_GET['password'])) {
    // Sanitize and validate the data passed i
    $username = filter_input(INPUT_GET, 'username', FILTER_SANITIZE_STRING);
    // $sq = filter_input(INPUT_POST, 'security_question', FILTER_SANITIZE_STRING);
    // $sans = filter_input(INPUT_POST, 'security_answer', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_GET, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Not a valid email
    }

	$prep_stmt = "SELECT username, security_question FROM members WHERE username = ? AND email = ? LIMIT 1";
	$stmt = $mysqli->prepare($prep_stmt);
	// var_dump($mysqli);
	if ($stmt) {
		// echo $username;
	    $stmt->bind_param('ss', $username, $email);
	    $res = $stmt->execute();
   		$stmt->bind_result($username, $security_question);
	    $stmt->store_result();
	    // echo $mysqli->error;
	    if ($stmt->num_rows == 0) {
	        // A user with this email address already exists$f="yeah";
	        echo '404';
	        die();
	    } else {
	    	while ($stmt->fetch()) {
		     // Because $name and $countryCode are passed by reference, their value
		     // changes on every iteration to reflect the current row
		     echo "<pre>";
		     echo "$security_question\n";
		     echo "</pre>";
		   }
	    }
	} else {
		echo 'db erro';
	    die();
	}
	
} else if (isset($_GET['username'], $_GET['email'], $_GET['security_answer']) && !isset($_GET['password'])) {
	$username = filter_input(INPUT_GET, 'username', FILTER_SANITIZE_STRING);
    // $sq = filter_input(INPUT_POST, 'security_question', FILTER_SANITIZE_STRING);
    $sans = filter_input(INPUT_GET, 'security_answer', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_GET, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Not a valid email
    }

	$prep_stmt = "SELECT username, security_answer FROM members WHERE username = ? AND email = ? LIMIT 1";
	$stmt = $mysqli->prepare($prep_stmt);
	// var_dump($mysqli);
	if ($stmt) {
		// echo $username;
	    $stmt->bind_param('ss', $username, $email);
	    $res = $stmt->execute();
   		$stmt->bind_result($username, $security_answer);
	    $stmt->store_result();
	    // echo $mysqli->error;
	    if ($stmt->num_rows == 0) {
	        echo '404';
	        die();
	    } else {
	    	while ($stmt->fetch()) {
		     // Because $name and $countryCode are passed by reference, their value
		     // changes on every iteration to reflect the current row
		     if($security_answer == $sans) {
				 echo "true";
				 return;
			 } else {
				 echo "false";
				 return;
			 }
		   }
	    }
	} else {
		echo 'db erro';
	    die();
	}
} else if (isset($_GET['username'], $_GET['email'], $_GET['password'])) {
	$username = filter_input(INPUT_GET, 'username', FILTER_SANITIZE_STRING);
    // $sq = filter_input(INPUT_POST, 'security_question', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_GET, 'password', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_GET, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
	// Create a random salt
	$random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));
	// Create salted password
	$password = hash('sha512', $password . $random_salt);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Not a valid email
    }

	$prep_stmt = "UPDATE members SET password = ?, salt = ? WHERE username = ? AND email = ? LIMIT 1";
	$stmt = $mysqli->prepare($prep_stmt);
	// var_dump($mysqli);
	if ($stmt) {
		// echo $username;
	    $stmt->bind_param('ssss', $password, $random_salt, $username, $email);
	    $res = $stmt->execute();
	    $stmt->store_result();
	    // echo $mysqli->error;
	    if ($mysqli->error) {
	        echo '404';
	        die();
	    } else {
			echo "okay";
			return;
	    }
	} else {
		echo 'db erro';
	    die();
	}
}
