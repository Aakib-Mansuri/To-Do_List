<?php
  require('ConnectDatabase.php');
  $inputElement = $_GET['inputElement'];
  $inputValue = $_GET['inputValue'];

  if($inputElement == 'Identity')
  {
        if(preg_match('/[0-9]/',$inputValue) and strlen($inputValue) == 10)
        {
              echo '';
        }

        elseif(preg_match('/[a-z0-9]+@[a-z]+\.+[a-z]{2,3}/',$inputValue))
        {
            echo '';
        }
            
        else 
        {
            echo "*enter a valid identity"; 
        }  
  }

  if($inputElement == 'Name')
  {
        if(preg_match('/[A-Za-z ]/',$inputValue))
        {
            echo '';
        }
            
        else 
        {
            echo "*enter a valid name"; 
        }  
  }

  if($inputElement == 'Username')
  {
        $flag = False;
        $query = "select * from Userdetails";
        $rows = mysqli_query($user,$query);

        while($associate=mysqli_fetch_assoc($rows))
        {
            if($associate['Username'] == $inputValue)
            {
                $flag = True; 
            }
        }
    
        if($flag) 
        {
            echo "*username is not available"; 
        }
        
        else 
        {
            if(preg_match('/[a-z]+[0-9_.]/', $inputValue) and strlen($inputValue) > 5)
            {
               echo '';
            }
        
            else 
            {
                echo '*enter a valid username';
            }    
        }  
  }

  if($inputElement == 'Password')
  {
        if(preg_match('/[A-Z]+[a-z]+[0-9\W]/', $inputValue) and strlen($inputValue) > 8)
        {
            echo '';
        }
        
        else 
        {
            echo '*enter a valid password';
        }    
          
  }
 
?>