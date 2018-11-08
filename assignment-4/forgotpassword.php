<?php
// include_once 'includes/forgotpassword.inc.php';
include_once 'includes/functions.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Secure Login: Registration Form</title>
        <script type="text/JavaScript" src="js/sha512.js"></script> 
        <script type="text/JavaScript" src="js/forms.js"></script>
        <link rel="stylesheet" href="styles/main.css" />
        <style>
        ul {
          display: none;
        }
        .visible {
          display: initial !important;
        }
        </style>
    </head>
    <body>
        <!-- Registration form to be output if the POST variables are not
        set or if the registration script caused an error. -->
        <h1>Forgot password</h1>
        <!-- <form method="post" name="registration_form" action="" id="form"> -->
            Your Username: <input type='text' name='username' id='username' /><br>
            Your Email: <input type="text" name="email" id="email" /><br>
            
            <ul id="list">
                <h2>Password guide lines:</h2>
                <li>Passwords must be at least 6 characters long</li>
                <li>Passwords must contain
                    <ul>
                        <li>At least one upper case letter (A..Z)</li>
                        <li>At least one lower case letter (a..z)</li>
                        <li>At least one number (0..9)</li>
                    </ul>
                </li>
                <li>Your password and confirmation must match exactly</li>
            </ul>
            <div>
              <span id="security"></span><br>
          </div>
          <button onclick="processClick()">Go!</button>
        <!-- </form> -->
        <p>Return to the <a href="index.php">login page</a>.</p>
        <script type="text/javascript">
          var mode = 'not asked';
          function processClick() {
            if(mode==='not asked') {
              console.log('Not yet asked the quesiton');
              var xhttp = new XMLHttpRequest();
              xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                  console.log(this.responseText);
                  if(this.responseText==="404") {
                    alert("No such user was found.");
                    mode = 'not asked';
                    return;
                  }
                  mode = 'asked but not answered';
                  document.getElementById("security").innerHTML = this.responseText+"<br><input type='text' id='s_ans'/>";
                }
              };
              document.getElementById('username').disabled = true;
              document.getElementById('email').disabled = true;
              var username =document.getElementById('username').value;
              var email =document.getElementById('email').value;
              xhttp.open("GET", "includes/forgotpassword.inc.php?username="+username+"&email="+email, true);
              xhttp.send();
            }
            if(mode==='asked but not answered') {
              console.log('Asked but not answered');
              var xhttp = new XMLHttpRequest();
              xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                  console.log(this.responseText);
                  if(this.responseText==="false") {
                    alert("wrong answer!!!");
                    document.getElementById('username').disabled = false;
                    document.getElementById('email').disabled = false;
                    return;
                  }
                  if(this.responseText==="404") {
                    alert("no such user exists");
                    mode = 'not asked';
                    document.getElementById('username').disabled = false;
                    document.getElementById('email').disabled = false;
                    document.getElementById('username').value = "";
                    document.getElementById('email').value = "";
                    return;
                  }
                  mode = 'answered and resetting';
                  document.getElementById("security").innerHTML = "You may enter your new password here: <br><input type='password' id='password' placeholder='Password here'/><br><input type='password' id='conf' placeholder='Password again'/>";
                }
              };
              var username =document.getElementById('username').value;
              var email =document.getElementById('email').value;
              var security_answer =document.getElementById('s_ans').value;
              document.getElementById('list').classList.add('visible');
              xhttp.open("GET", "includes/forgotpassword.inc.php?username="+username+"&email="+email+"&security_answer="+security_answer, true);
              xhttp.send();
            }
            if(mode==='answered and resetting') {
              var password =document.getElementById('password').value;
              var conf =document.getElementById('conf').value;
              // Check each field has a value
              if (password==='') {
                  alert('You must provide password. Please try again');
                  return false;
              }

              // Check that the password is sufficiently long (min 6 chars)
              // The check is duplicated below, but this is included to give more
              // specific guidance to the user
              if (password.length < 6) {
                  alert('Passwords must be at least 6 characters long.  Please try again');
                  document.getElementById('password').focus();
                  return false;
              }

              // At least one number, one lowercase and one uppercase letter
              // At least six characters
              var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/;
              if (!re.test(password)) {
                  alert('Passwords must contain at least one number, one lowercase and one uppercase letter.  Please try again');
                  return false;
              }

              // Check password and confirmation are the same
              if (password != conf) {
                  alert('Your password and confirmation do not match. Please try again');
                  document.getElementById('password').focus();
                  return false;
              }

              var simple_pass=["passwords",
              "123456",
              "123456789",
              "qwerty",
              "12345678",
              "111111",
              "1234567890",
              "1234567",
              "password",
              "123123",
              "987654321",
              "qwertyuiop",
              "mynoob",
              "123321",
              "666666",
              "18atcskd2w",
              "7777777",
              "1q2w3e4r",
              "654321",
              "555555",
              "3rjs1la7qe",
              "google",
              "1q2w3e4r5t",
              "123qwe",
              "zxcvbnm",
              "1q2w3e"];

              var i;var dist=99999;var p;
              for (i = 0; i < simple_pass.length; i++) {
                  if(dist>distance(password,simple_pass[i])) {
                      dist=distance(simple_pass[i],password);
                      p=simple_pass[i];
                  }
              }
              // alert("nearest simple password is "+ p+" with edit distance "+ dist);
              if(dist<4) {
                  alert("The password is too weak. Please try with another one.");
                  return false;
              }
              console.log('resetting the pwd');
              var xhttp = new XMLHttpRequest();
              xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                  console.log(this.responseText);
                  if(this.responseText==="okay") {
                    alert("Password successfully changed. You will be redirected to login page.");
                    window.location.replace('/phpSecureLogin/index.php');
                    return;
                  }
                  if(this.responseText==="404") {
                    alert("no such user exists");
                    mode = 'not asked';
                    return;
                  }
                  mode = 'all done';
                  document.getElementById("security").innerHTML = "Password replaced";
                }
              };
              var username =document.getElementById('username').value;
              var email =document.getElementById('email').value;
              password = hex_sha512(password);
              document.getElementById('password').value = "";
              document.getElementById('conf').value = "";
              xhttp.open("GET", "includes/forgotpassword.inc.php?username="+username+"&email="+email+"&password="+password, true);
              xhttp.send();
            }
          }
        </script>
    </body>
</html>
