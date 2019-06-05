<!-- UPLOAD FILES in the root directory -->
<!DOCTYPE html>
<html>
<head>
	<title>Attendence</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

</head>
<body onload="getLocation()">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="navbar">
  <a class="navbar-brand" href="#">Jeevan Gyawali</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item active">
      <a class="nav-link" href="../index.php/#demo">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../index.php/#AboutUs">About Me</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../index.php/#Skills">Skills</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../index.php/#resume">Resume</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">My Game</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../index.php/#PP">Photoshop Projects</a>
      </li>
       <li class="nav-item">
        <a class="nav-link" href="../index.php/#ContactMe">Contact Me</a>
      </li>
    </ul>
  </div>
</nav>
 <section id="howto" class="bg-primary text-center">
  <article class="py-2">
    <div>
     <h3 class="display-4 text-white">
      How to Use?
     </h3>  
     <p class="text-white"> Click below to learn </p>
     <a href="howto.php" class="btn btn-warning">Learn Now</a>
  </div>
  </article>
 </section>
<br>
<?php
include("connection.php"); 
     $q1 =  "SELECT * FROM admin ORDER BY admin.id DESC LIMIT 1";
      $result = mysqli_query($con, $q1);
      while($row = mysqli_fetch_assoc($result)){
      $puser_name = $row['puser_name'];
      $pcode = $row['pcode'];
      echo '<h4 class="text-center bg-primary text-white"> Professor "'.$puser_name.'" has uploaded new attendence code "'.$pcode. '" </h4>';
    }
?>

<br>
 <div class="row ml-1">
    <div class="col-lg-6 col-md-6 col-12" ><h4>Admin Panel</h4> <hr>
    	<form  method="post" enctype="multipart/form-data" id="filetoupload">
    	<div class="form-group">
          <label for="code">Professor User Name:</label>
          <input type="text" name="puser_name" class="form-control w-25 " id="puser_name" autocomplete="off" required >
        </div>
         <div class="form-group">
          <label for="code">Professor NET ID:</label>
          <input type="text" name="pnetid" class="form-control w-25 " id="pnetid" autocomplete="off" required >
        </div>
        <div class="form-group">
          <label for="code">Custom Attendence Code:</label>
          <input type="text" name="pcode" class="form-control w-25 " id="pcode" autocomplete="off" required >
        </div>
         <div class="form-group">
              Select File:
          <input type="file" name="file" id="file" required >
        </div>
        <button type="submit" name="pSubmit" class="btn btn-primary">Generate Code</button> 
    </form>
    <br>
    <h4>Check Attendence</h4>
    <hr>
    <form method="post">
      <div class="form-group">
          <label for="code">Professor User Name:</label>   <!-- DROP DOWN MENU  -->
          <?php
          include("connection.php");
          $ql = "SELECT DISTINCT puser_name FROM admin";
          $result = mysqli_query($con, $ql);
          echo "<select name = 'sub1'>";
          while($row = mysqli_fetch_assoc($result)){     
            echo"<option value='".$row['puser_name']."'>".$row['puser_name']."</option>";
          }
          echo "</select>";
          if(isset($_POST["sub1"])){
         $draft= $_POST["sub1"];
         }
          ?>
        </div>


      <div class="form-group">
          <label for="code">Student NET ID:</label>
          <?Php 
          include("connection.php");
          $q2 = "SELECT DISTINCT netid FROM student";
          $result1 = mysqli_query($con, $q2);
            echo "<select name = 'sub2'>";
            while($row = mysqli_fetch_assoc($result1)){     
            echo"<option value='".$row['netid']."'>".$row['netid']."</option>";
          }
          echo "</select>";
          if(isset($_POST["sub2"])){
         $draft1= $_POST["sub2"];
          }

          ?>
        </div>
        <button type="submit" name="ASubmit" id="Button" class="btn btn-primary">Check Attendence</button>
      </form>
    <hr>

    <!-- RETRIEVE TOTAL ATTENDENCE OF STUDENT FRM DATABSE -->
    <?php
    include("connection.php");
    if(isset($_POST["ASubmit"])){
          $q4 = "SELECT * FROM student WHERE puser_name = '$draft' and netid = '$draft1' ";
          $result3 = mysqli_query($con, $q4);
          $present1 = mysqli_num_rows($result3);
          echo "".$draft1." has total attendence of ".$present1."";
          }

    ?>


<?php
include("connection.php"); 
 if(isset ($_POST['pSubmit'])){
  $file = $_FILES ['file'];

  $fileName = $_FILES ['file']['name'];
  $fileTmpName = $_FILES ['file']['tmp_name'];
  $fileSize = $_FILES ['file']['size'];
  $fileError= $_FILES ['file']['error'];
  $fileType = $_FILES ['file']['type'];

  $fileExt = explode('.',$fileName);
  $fileActualExt = strtolower(end($fileExt));

  $allowed = array('jpg','jpeg','png','pdf');

  if(in_array($fileActualExt, $allowed)){
    if($fileError === 0){
     if ($fileSize < 5000000){
      $fileNameNew = uniqid('',true).".".$fileActualExt;
      $fileDestination = 'uploads/'.$fileNameNew;
      move_uploaded_file($fileTmpName, $fileDestination);
     } else {
      echo "Your file is too big! ";  
     }
    }else {
    echo "There was an error uploading your file! ";  
    }
  } else {
    echo "You cannot upload files of this type!";
  }
    $pnetid =$_POST['pnetid'];
    $puser_name=$_POST['puser_name'];
    $pcode=$_POST['pcode'];
    $q= "INSERT INTO admin (puser_name,pnet_id,pcode,folder) VALUES ('".$puser_name."','".$pnetid."','".$pcode."','".$fileDestination."')";
    if( mysqli_query($con, $q)) {
      ?>
      <script>document.getElementById("fileupload").style.visibility= "visible"; </script>
      <?Php
    }
    
  }
  ?>

    </div>
    <div class="col-lg-6 col-md-6 col-12" ><h4>Student Panel </h4><hr>
    	<div>
    	<form method="post">
    	<div class="form-group">
          <label for="code">Professor User Name:</label>
          <input type="text" name="puser_name" class="form-control w-25 " id="puser_name" autocomplete="off" required >
        </div>
    	<div class="form-group">
          <label for="code">Student NET ID:</label>
          <input type="text" name="netid" class="form-control w-25 " id="netid" autocomplete="off" required >
        </div>
        <div class="form-group">
          <label for="code">Attendence Code:</label>
          <input type="text" name="code" class="form-control w-25 " id="code" autocomplete="off" required >
        </div>
        <button type="submit" name="Submit" id="Button" class="btn btn-primary">Submit</button>
    	</form>
    	</div>
      <hr>


  <?PHP
include("connection.php"); 
if(isset ($_POST['Submit'])){
    $netid =$_POST['netid'];
    $puser_name=$_POST['puser_name'];
    $code=$_POST['code'];
    $q= "INSERT INTO student (puser_name,netid,code) VALUES ('".$puser_name."','".$netid."','".$code."')";
    if( mysqli_query($con, $q)) {
      $q1 =  "SELECT * FROM (SELECT * FROM student ORDER BY student.id DESC LIMIT 1) as s INNER JOIN ( SELECT * FROM admin ORDER BY admin.id DESC LIMIT 1) as ad ON s.code = ad.pcode AND s.puser_name = ad.puser_name";

      $q2 = "SELECT * FROM (SELECT * FROM student ORDER BY student.id DESC LIMIT 1) as s1 INNER JOIN (SELECT * FROM student) as s2 ON s1.puser_name = s2.puser_name AND s1.netid = s2.netid" ;


      $result = mysqli_query($con, $q1);
      $result1 = mysqli_query($con, $q2);
      $present = mysqli_num_rows($result1);


      if (mysqli_num_rows($result) > 0){

         echo "<h4> Attendence Successful</h4>";
         echo "Your total attendence is ".$present."";
         echo "<hr>";
            $a1 =  "SELECT * FROM admin ORDER BY admin.id DESC LIMIT 1";
            $result = mysqli_query($con, $a1);
            while($row = mysqli_fetch_assoc($result)){
            $puser_name = $row['puser_name'];
            $folder = $row['folder'];
            echo  '<img src="'.$folder.'" /> ';
            echo '<hr>';
              }
          $delete = " DELETE t1 FROM student t1 INNER JOIN student t2 WHERE t1.id > t2.id AND t1.puser_name=t2.puser_name AND t1.code = t2.code AND t1.netid = t2.netid";

          if (mysqli_query($con, $delete)){
            echo "Any dublicate attendences are removed sucessfully";
           }
      }
      else {
           echo "<h4> Attendence Unsuccessful</h4>";
           echo "<hr>";
           $delete = "DELETE FROM student ORDER BY student.id DESC LIMIT 1";
           if (mysqli_query($con, $delete)){
            echo "Fake Attendence is removed";
           }
      }
    }
    
  }

?>
    </div>
</div>


<!-- CHECK TO SEE IF USER IS IN CLASS OR NOT -->
<script>

function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else { 
    x.innerHTML = "Geolocation is not supported by this browser. Try another browser!!";
  }
}

function showPosition(position) {
  if ((position.coords.latitude > 32.7195900 && position.coords.latitude < 32.7198990) && (position.coords.longitude > -97.1092980 && position.coords.longitude < -97.1092010)) {
   //  document.getElementById("fileupload").style.visibility= "hidden"; 
     alert ("You are in class and you can take your Attendence");
   //  document.getElementById("Button").disabled = false;
   } else {
     alert ("You are not in class and you cannot take your Attendence");
    // document.getElementById("Button").disabled = true;
   }
 
} 

</script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
<!--footer-->
<footer>
  <br>
  <p class="text-center bg-dark text-white">  © copyright jeevangyawali.com 2019  </p>
</footer>
</html>