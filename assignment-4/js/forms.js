/*
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
 function distance(a, b) {
   var t = [], u, i, j, m = a.length, n = b.length;
   if (!m) { return n; }
   if (!n) { return m; }
   for (j = 0; j <= n; j++) { t[j] = j; }
   for (i = 1; i <= m; i++) {
     for (u = [i], j = 1; j <= n; j++) {
       u[j] = a[i - 1] === b[j - 1] ? t[j - 1] : Math.min(t[j - 1], t[j], u[j - 1]) + 1;
     } t = u;
   } return u[n];
 }

function formhash(form, password) {
    // Create a new element input, this will be our hashed password field.
    var p = document.createElement("input");
    // Add the new element to our form.
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);
    // Make sure the plaintext password doesn't get sent.
    password.value = "";

    // Finally submit the form.
    form.submit();
}

function regformhash(form, uid, email, password, conf,sq, sans) {
    // Check each field has a value
    if (uid.value == '' || email.value == '' || password.value == '' || conf.value == '' || sq.value==='' || sans.value==='') {
        alert('You must provide all the requested details. Please try again');
        return false;
    }

    // Check the username
    re = /^\w+$/;
    if(!re.test(form.username.value)) {
        alert("Username must contain only letters, numbers and underscores. Please try again");
        form.username.focus();
        return false;
    }

    // Check that the password is sufficiently long (min 6 chars)
    // The check is duplicated below, but this is included to give more
    // specific guidance to the user
    if (password.value.length < 6) {
        alert('Passwords must be at least 6 characters long.  Please try again');
        form.password.focus();
        return false;
    }

    // At least one number, one lowercase and one uppercase letter
    // At least six characters
    var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/;
    if (!re.test(password.value)) {
        alert('Passwords must contain at least one number, one lowercase and one uppercase letter.  Please try again');
        return false;
    }

    // Check password and confirmation are the same
    if (password.value != conf.value) {
        alert('Your password and confirmation do not match. Please try again');
        form.password.focus();
        return false;
    }
    //document.write(password.value);

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
        if(dist>distance(password.value,simple_pass[i])) {
            dist=distance(simple_pass[i],password.value);
            p=simple_pass[i];
        }
    }
    // alert("nearest simple password is "+ p+" with edit distance "+ dist);
    if(dist<4) {
        alert("The password is too weak. Please try with another one.");
        return false;
    }
    // Create a new element input, this will be our hashed password field.
    var p = document.createElement("input");

    // Add the new element to our form.
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);

    password.value = "";
    conf.value = "";
    sans.value = sans.value.toLowerCase().trim();
    form.submit();
    return true;
}
