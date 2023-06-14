<?php
  $user = mysqli_connect('localhost','root','');
  if($user)
  {
    $query = "create database ToDoList";
    if(mysqli_query($user,$query))
    {
        $user = mysqli_connect('localhost','root','','ToDoList');
        $query = "create table Userdetails
        (
          Identity varchar(100),
          Name varchar(50),
          Username varchar(50) primary key,
          Password varchar(255)
        )";
        if(mysqli_query($user,$query))
        {
            $query = "create table ListDetails
            (
              Sno int(5) primary key,
              Title varchar(20),
              Description varchar(50)
            )";
            if(mysqli_query($user,$query))
            {
              echo "All set-up done";
            }
        }
    }
  }
?>

