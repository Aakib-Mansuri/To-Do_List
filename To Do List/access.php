<?php
    require('ConnectDatabase.php');
    $inputElement = $_GET['inputElement'];
    $inputValue = $_GET['inputValue'];
    $Username = $_GET['Username'];

    if($inputElement == 'Username')
    {
        $query = "select * from Userdetails where Username like '$inputValue' or Identity like '$inputValue'";
        $query = mysqli_query($user,$query);
        $rows = mysqli_num_rows($query);
        if($rows == 1)
        {
           echo "";
        }

        else 
        {
           echo "*enter a valid username";    
        }
    }

    if($inputElement == 'Password')
    {
        $query = "select * from Userdetails where Username like '$Username' or Identity like '$Username'";
        $query = mysqli_query($user,$query);
        $associate = mysqli_fetch_assoc($query);
        $result = $associate['Password'];
        if(password_verify($inputValue,$result))
        {
           echo "";
        }

        else 
        {
           echo "*enter a valid password";    
        }
    }
?>