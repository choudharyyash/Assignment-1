<?php

/*
 * Copyright (C) 2013 peter
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

include_once 'db_connect.php';
include_once 'psl-config.php';

$error_msg = "";




function console_log( $data ){
  echo '<script>';
  echo 'console.log('. json_encode( $data ) .')';
  echo '</script>';
}
function generateRandomString($length = 3) {
    return substr(str_shuffle(str_repeat($x='0123456789', ceil($length/strlen($x)) )),1,$length);
}


if (isset($_POST['username'], $_POST['email'], $_POST['p'])) {
    // Sanitize and validate the data passed in
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    // $sq = filter_input(INPUT_POST, 'security_question', FILTER_SANITIZE_STRING);
    // $sans = filter_input(INPUT_POST, 'security_answer', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Not a valid email
        $error_msg .= '<p class="error">The email address you entered is not valid</p>';
    }

    $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
    if (strlen($password) != 128) {
        // The hashed pwd should be 128 characters long.
        // If it's not, something really odd has happened
        $error_msg .= '<p class="error">Invalid password configuration.</p>';
    }

    // Username validity and password validity have been checked client side.
    // This should should be adequate as nobody gains any advantage from
    // breaking these rules.
    //

    $prep_stmt = "SELECT id FROM members WHERE email = ? LIMIT 1";
    $stmt = $mysqli->prepare($prep_stmt);

    if ($stmt) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows != 0) {
            // A user with this email address already exists$f="yeah";
            $error_msg .= '<p class="error">A user with this email address already exists.</p>';
        }
    } else {
        $error_msg .= '<p class="error">Database error</p>';
    }

    $prep_stmt = "SELECT id FROM members WHERE username = ? LIMIT 1";
    $stmt = $mysqli->prepare($prep_stmt);
    if ($stmt) {
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            // A user with this email address already exists
            $usr1=$username.generateRandomString();
            while($stmt->num_rows == 1){
              $usr1=$username.generateRandomString();
              $stmt->bind_param('s', $usr1);
              $stmt->execute();
              $stmt->store_result();
            }
            $usr2=$username.generateRandomString();
            while($stmt->num_rows == 1){
              $usr2=$username.generateRandomString();
              $stmt->bind_param('s', $usr2);
              $stmt->execute();
              $stmt->store_result();
            }
            $usr3=$username.generateRandomString();
            while($stmt->num_rows == 1){
              $usr3=$username.generateRandomString();
              $stmt->bind_param('s', $usr3);
              $stmt->execute();
              $stmt->store_result();
            }
            $new=$usr1."  ".$usr2."  ".$usr3;
            $error_msg .= '<p class="error">username  '.$username.'  is unavailable, available usernames are  '.$new.' ';
            echo $password;
        }
    }

    // TODO:
    // We'll also have to account for the situation where the user doesn't have
    // rights to do registration, by checking what type of user is attempting to
    // perform the operation.

    if (empty($error_msg)) {
        // Create a random salt
        $random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));

        // Create salted password
        $password = hash('sha512', $password . $random_salt);

        // Insert the new user into the database
        if ($insert_stmt = $mysqli->prepare("INSERT INTO members (username, email, password, salt, security_question, security_answer) VALUES (?, ?, ?, ?, ?, ?)")) {
            // echo $_POST['security_question'].'    ajdfliajs';
            $insert_stmt->bind_param('ssssss', $username, $email, $password, $random_salt, $_POST['security_question'],
                $_POST['security_answer']);
            // Execute the prepared query.
            if (! $insert_stmt->execute()) {
                echo $mysqli->error;
                // header('Location: ../error.php?err=Registration failure: INSERT');
                exit();
            }
        }
        header('Location: ./register_success.php');
        exit();
    }
}
