<?php
     require('ConnectDatabase.php');
     if($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_GET['validDetails']))
     {
        $Identity = $_POST['Identity'];
        $Name = $_POST['Name'];
        $Username = $_POST['Username'];
        $Password = password_hash($_POST['Password'],PASSWORD_DEFAULT);

        $query = "insert into Userdetails values ('$Identity','$Name','$Username','$Password')";
        if(mysqli_query($user,$query))
        {
            header("location://localhost/To%20Do%20List/index.php");
            exit;
        }
    }  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sing up</title>
    <link rel="stylesheet" href="Css/main.css">
    <style>
        .main
        {
            height: 80vh;
            margin-top: 7vh;
        }
        .f1
        {
            margin-top: 28px;
            height: 300px;
        }
        .input
        {
            margin-top: 10px;
            height: 50px;
        }
        #submit
        {
            margin-top: 40px;
        }
        .p
        {
            font-size: x-small;
            margin-bottom: 5px;
            color: red;
        }
    </style>
</head>
<body>
   <div class="main">
        <h1>Sing up</h1>
        <form action="?validDetails=true" class="f1" method="post" onsubmit="return formSubmit()"> 
            <div class="Identity input">
                <input type="text" name="Identity" id="Identity" onchange="validate('Identity')" placeholder="Mobile Number or Email id" required>
                <p class='p'></p>
            </div>
            <div class="Name input">
                <input type="text" name="Name" id="Name" onchange="validate('Name')" placeholder="Full Name" required>
                <p class='p'></p>
            </div>
            <div class="Username input">
                <input type="text" name="Username" id="Username" onchange="validate('Username')" placeholder="Username" required>
                <p class='p'></p>
            </div>
            <div class="Password input">
                <input type="Password" name="Password" id="Password" onchange="validate('Password')" placeholder="Password" required>
                <p class='p'></p>
            </div>
            <div>
                <input type="submit" id="submit" value="SIGN UP">
            </div> 
        </form>
        <div class="footer">
            <p>Have an account?</p>
            <h3><a href="index.php">Log in</a></h3>
        </div>
   </div>    
</body>
<script>
    function  validate(inputElement) 
    {
       let value = document.getElementById(inputElement).value;
       let http = new XMLHttpRequest();
       http.open('POST',`validation.php?inputElement=${inputElement}&inputValue=${value}`,true);

       http.onload = function ()
       {
            if(this.status = 200)
            {
                let para = document.getElementsByClassName(inputElement)[0].children[1];
                para.innerHTML = this.responseText;
            }
            else
            {
                alert('Server Down....!');
            }
       }

       http.send();
    };

    function formSubmit()
    {
        let flag = false;
        let para = document.getElementsByClassName('p');
        Array.from(para).forEach(element => {
            if(element.innerHTML != '')
            {
                flag = true;
            }
        });

        if(flag)
        {
            alert("Enter a valid details...!");
            return false;
        }

        else
        {
           return true;
        }
    };
</script>
</html>