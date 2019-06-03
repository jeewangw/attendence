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
        <a class="nav-link" href="#demo">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#AboutUs">About Me</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#Skills">Skills</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#resume">Resume</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="cycle_run/index.html">My Game</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#PP">Photoshop Projects</a>
      </li>
       <li class="nav-item">
        <a class="nav-link" href="#ContactMe">Contact Me</a>
      </li>
    </ul>
  </div>
</nav>

<br>
 <div class="row ml-1">
    <div class="col-lg-6 col-md-6 col-12" >Admin Panel <hr>
    	<form method="post">
    	<div class="form-group">
          <label for="code">User Name:</label>
          <input type="text" name="puser_name" class="form-control w-25 " id="puser_name" autocomplete="off" required >
        </div>
         <div class="form-group">
          <label for="code">UTA NET ID:</label>
          <input type="text" name="pnetid" class="form-control w-25 " id="pnetid" autocomplete="off" required >
        </div>
        <div class="form-group">
          <label for="code">Custom Attendence Code:</label>
          <input type="text" name="pcode" class="form-control w-25 " id="pcode" autocomplete="off" required >
        </div>
        <button type="submit" name="pSubmit" class="btn btn-primary">Generate Code</button>
    </form>
    <hr>


<?php
include("connection.php"); 
     $q1 =  "SELECT * FROM admin ORDER BY admin.id DESC LIMIT 1";
      $result = mysqli_query($con, $q1);
      while($row = mysqli_fetch_assoc($result)){
      $puser_name = $row['puser_name'];
      $pcode = $row['pcode'];
      echo '<h4 > Professor "'.$puser_name.'" has uploaded new attendence code "'.$pcode. '" </h4>';
      echo '<hr>';
    }


 if(isset ($_POST['pSubmit'])){
    $pnetid =$_POST['pnetid'];
    $puser_name=$_POST['puser_name'];
    $pcode=$_POST['pcode'];
    $q= "INSERT INTO admin (puser_name,pnet_id,pcode) VALUES ('".$puser_name."','".$pnetid."','".$pcode."')";
    if( mysqli_query($con, $q)) {
    }
    
  }
  ?>

    </div>
    <div class="col-lg-6 col-md-6 col-12" >Student Panel <hr>
    	<div>
    	<form method="post">
    	<div class="form-group">
          <label for="code">Admin User Name:</label>
          <input type="text" name="puser_name" class="form-control w-25 " id="puser_name" autocomplete="off" required >
        </div>
    	<div class="form-group">
          <label for="code">UTA NET ID:</label>
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
          $delete = " DELETE t1 FROM student t1 INNER JOIN student t2 WHERE t1.id > t2.id AND t1.code = t2.code AND t1.netid = t2.netid";

          if (mysqli_query($con, $delete)){
            echo "Fake Attendence is removed";
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