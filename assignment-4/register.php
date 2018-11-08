<?php
/**
 * Copyright (C) 2013 peredur.net
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
include_once 'includes/register.inc.php';
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
    </head>
    <body>
        <!-- Registration form to be output if the POST variables are not
        set or if the registration script caused an error. -->
        <h1>Register with us</h1>
        <?php
        if (!empty($error_msg)) {
            echo $error_msg;
        }
        ?>
        <ul>
            <li>Usernames may contain only digits, upper and lower case letters and underscores</li>
            <li>Emails must have a valid email format</li>
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
        <form method="post" name="registration_form" action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" id="form">
            Username: <input type='text' name='username' id='username' /><br>
            Email: <input type="text" name="email" id="email" /><br>
            Password: <input type="password"
                             name="password" 
                             id="password"/><br>
            Confirm password: <input type="password" 
                                     name="confirmpwd" 
                                     id="confirmpwd" /><br>
            Security question: 
            <select name="security_question" id="security_question" form="form">
              <option value="What was your childhood nickname?">What was your childhood nickname?</option>
              <option value="What is the name of your favorite childhood friend?">What is the name of your favorite childhood friend?</option>
              <option value="In what city or town did your mother and father meet?">In what city or town did your mother and father meet?</option>
              <option value="What is the middle name of your oldest child?">What is the middle name of your oldest child?</option>
              <option value="What is your favorite cricket team?">What is your favorite cricket team?</option>
              <option value="What was your favorite sport in high school?">What was your favorite sport in high school?</option>
              <option value="What was your favorite food as a child?">What was your favorite food as a child?</option>
              <option value="What is the first name of the boy or girl that you first kissed?">What is the first name of the boy or girl that you first kissed?</option>
              <option value="What was the make and model of your first car?">What was the make and model of your first car?</option>
              <option value="What was the name of the hospital where you were born?">What was the name of the hospital where you were born?</option>
              <option value="Who is your childhood sports hero?">Who is your childhood sports hero?</option>
              <option value="What school did you attend for sixth grade?">What school did you attend for sixth grade?</option>
            </select> <br>
            Answer to security question:
            <input type="text" name="security_answer" id="security_answer"> <br>
            <input type="button" 
                   value="Register" 
                   onclick="return regformhash(this.form,
                                   this.form.username,
                                   this.form.email,
                                   this.form.password,
                                   this.form.confirmpwd, this.form.security_question, this.form.security_answer);" /> 
        </form>
        <p>Return to the <a href="index.php">login page</a>.</p>
        <p>Forgot password? <a href="forgotpassword.php">Click here pls</a>.</p>
    </body>
</html>
