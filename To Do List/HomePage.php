<?php
require('ConnectDatabase.php');
session_start();
  if($_SESSION['User'] != 'Logdin')
  {
    header("location://localhost/To%20Do%20List/index.php");    
    exit();
  }
  if(isset($_GET['logout']))
  {
    session_unset();
    header("location://localhost/To%20Do%20List/index.php");    
    exit();
  }
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home-page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="Css/HomePage.css">
  </head>
  <body>
    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel">Edit details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="HomePage.php" method='post'>
            <div class="modal-body">
              <input type="hidden" name="EditSno" id="EditSno">
              <div class="mb-3">
                <label for="EditTitel" class="form-label">Title</label>
                <input type="text" name="EditTitle" class="form-control" id="EditTitel" placeholder="Enter the list title">
              </div>
              <div class="mb-3">
                <label for="EditDescription" class="form-label">Description</label>
                <input type="text" name="EditDescription" class="form-control" id="EditDescription" placeholder="Enter the list details">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="close btn btn-secondary" data-dismiss="modal">Close</button>
              <input type="submit" class="btn btn-primary" value="Save changes">
            </div>
          </form>
        </div>
      </div>
    </div>

  <!-- Navbar   -->
  <nav class="navbar fixed-top navbar-expand-lg bg-light">
  <div class="container-fluid">
    <a class="navbar-brand"><img src="Logo/Navlogo.jpg" id="Logo" alt="Mansuri"></a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="HomePage.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php">User</a>
        </li>
        <li class="nav-item active"><a class="nav-link" id="Singout">Sing out</a></li>
      </ul>
      <form class="d-flex" action="SearchPage.php" role="search">
        <input name="search" id="Search" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit" id="Search">Search</button>
      </form>
    </div>
  </div>
 </nav>

 <!-- Add List -->
 <div class="input">
    <h3>To Do List</h3>
    <form action="HomePage.php" method='post'>
    <div class="mb-3">
      <label for="Title" class="form-label">Title</label>
      <input type="text" name="Title" class="form-control" id="Titel" placeholder="Enter the list title">
    </div>
    <div class="mb-3">
      <label for="Description" class="form-label">Description</label>
      <input type="text" name="Description" class="form-control" id="Description" placeholder="Enter the list details">
    </div>
    <button type="submit" class="btn btn-primary">Add</button>
    <button type="reset" class="btn btn-secondary">Reset</button>
  </form>
 </div>

 <!-- Tabel -->
 <div class="output">
  <table class="table" id="myTable">
    <thead>
      <tr>
        <th scope="col" class="c1">Sno.</th>
        <th scope="col" class="c2">Title</th>
        <th scope="col" class="c3">Description</th>
        <th scope="col" class="c4">Handle</th>
      </tr>
    </thead>
    <tbody>
      <?php
        //Serial Number
         $i=1;
         while(1)
        {
             $query = mysqli_query($user,"select Sno from Listdetails where Sno like '$i'");
             $rows = mysqli_num_rows($query);
             if($rows == 0)
             {
                $Sno = $i;
                break;
             } 
             $i++;
        }  
        

        //Submit data through form
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
          //Create Data  
          if(isset($_POST['Title']))
          {
              $Title = $_POST['Title'];
              $Description = $_POST['Description'];
              if(!empty($Title) and !empty($Description))
              {
                $query = "insert into Listdetails value ('$Sno','$Title','$Description')";
                if(mysqli_query($user,$query))
                {
                  $Sno++;
                  header("location: //localhost/To%20Do%20List/HomePage.php");
                }
              }
          }
           
          //Update Data
          if(isset($_POST['EditTitle']))
          {
              $EditSno = $_POST['EditSno'];
              $Title = $_POST['EditTitle'];
              $Description = $_POST['EditDescription'];

              if(!empty($EditSno) and !empty($Title) and !empty($Description))
              {
                $query = "update Listdetails set Title = '$Title', Description ='$Description' where Sno = '$EditSno'";
                if(mysqli_query($user,$query))
                {
                  header("location: //localhost/To%20Do%20List/HomePage.php");
                }
              }
          }
        }
           
        //Delete Data
        if(isset($_GET['DeleteElement']))
        {
           $DeleteElement = $_GET['DeleteElement'];
           $i = $DeleteElement;
           $query = "delete from Listdetails where Sno like $DeleteElement";
           mysqli_query($user,$query);
           do
           {
              $query = "update Listdetails set Sno = '$i' where Sno like '".($i+1)."'";
              mysqli_query($user,$query); $i++;
              $query = mysqli_query($user,"select * from Listdetails where Sno like'".($i+1)."'");
              $rows = mysqli_num_rows($query); 
           }while($rows != 0);
           header("location: //localhost/To%20Do%20List/HomePage.php");
        }

        //Read Data
        if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST')
        { 
            $query = "select * from Listdetails";
            $rows = mysqli_query($user,$query);
            if($rows)
            {
              while ($associate = mysqli_fetch_assoc($rows)) 
              {
                  echo "<tr>
                          <td class='c1'>".$associate['Sno']."</td>
                          <td class='c2'>".$associate['Title']."</td>
                          <td class='c3'>".$associate['Description']."</td>
                          <td class='c4'><button class='edit'>Edit</button><button class='delete'>Delete</button></td>
                      </tr>";       
              }
            }
        }
      ?>
     </tbody>
    </table>
 </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
<script>
    document.getElementById('Singout').addEventListener('click',func);

    let deleteclass = document.getElementsByClassName('delete');
    Array.from(deleteclass).forEach(element => {
           element.addEventListener('click',fundelete);
    });

    let editclass = document.getElementsByClassName('edit');
    Array.from(editclass).forEach(element => {
           element.addEventListener('click',funedit);
    });

    let close = document.getElementsByClassName('close');
    Array.from(close).forEach(element => {
           element.addEventListener('click',toggle);
    });

    function func()
    {
      window.location = "//localhost/To%20Do%20List/HomePage.php?logout=true";
    }

    function fundelete(e)
    {
       if(confirm('Do you want to delete data'))
       {
          let element = e.target;
          let parentNode = element.parentNode.parentNode;
          let child = parentNode.children[0].innerHTML;
          window.location = `//localhost/To%20Do%20List/HomePage.php?DeleteElement=${child}`;
       }
    }

    function funedit(e)
    {
      let element = e.target;
      let parentNode = element.parentNode.parentNode;
      let child = parentNode.children[0].innerHTML;
      document.getElementById('EditSno').value = child;
      toggle();
    }

    function toggle()
    {
      $('#editModal').modal('toggle');
    }
</script>
</html>