<?php
  if(isset($_GET['access']))
  {
    session_start();
    $_SESSION['User'] = 'Logdin';
    header("location:http://localhost/To%20Do%20List/HomePage.php");
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="Css/main.css">
</head>
<body>
   <div class="main">
        <h1>Login</h1>
        <form action="?access=valid" method="post" class="f1" onsubmit="return validate()">
            <div class="Username">
                <label for="Username">Username</label><br>
                <input type="text" name="Username" onchange="checkaccess('Username')" id="Username" placeholder="Phone number, username, email id" required>
                <p style='color:red;margin-top:5px;font-size:small;'></p>
            </div>
            <div class="Password">
                <label for="Password">Password</label><br>
                <input type="Password" name="Password" onchange="checkaccess('Password')" id="Password" placeholder="Enter your password" required>
                <p style='color:red;margin-top:5px;font-size:small;'></p>
            </div>
            <div>
                <input type='submit' id='submit' value='LOG IN' style='margin-top:30px;'>
            </div>
        </form>
        <div class="footer">
            <p>Or Sing Up Using</p>
            <h4><a href="Sign-up.php">SIGN UP</a></h4>
        </div>
   </div>    
</body>
<script>
    function checkaccess(inputElement) 
    {
       let inputValue = document.getElementById(inputElement).value;
       let para = document.getElementsByClassName(inputElement)[0].children[3];

       let userpara = document.getElementsByClassName('Username')[0].children[3];
       let Username = document.getElementById('Username').value;

       if(inputElement == 'Password' && (userpara.innerHTML != '' )||(Username == ''))
       {
          para.innerHTML = '*enter a valid details';
          userpara.innerHTML = '';
       }

       else
       {
            let http = new XMLHttpRequest();
            http.open('POST',`access.php?Username=${Username}&inputElement=${inputElement}&inputValue=${inputValue}`,true);    
            http.onload = function ()
            {
                    if(this.status == 200)
                    {
                        para.innerHTML = this.responseText;
                    }

                    else
                    {
                        para.innerHTML = '*technical error';
                    }
            }
            http.send();
       }
    }

    function validate() 
    {
       let passpara = document.getElementsByClassName('Password')[0].children[3];
       let userpara = document.getElementsByClassName('Username')[0].children[3];
       if(userpara.innerHTML == '' && passpara.innerHTML == '')
       {
          return true;
       }

       else
       {
          alert('Enter the valid details...!');
          return false;
       }
    }
</script>
</html>