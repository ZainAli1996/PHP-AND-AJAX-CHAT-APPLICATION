<?php
session_start();
$con = mysqli_connect('localhost', 'root', '', 'chatapp');

if(isset($_POST['RegisterMe'])){

$User = mysqli_real_escape_string($con, $_POST['uName']);

$insertquery = "INSERT into `users` (User) values('$User')";
$query = mysqli_query($con, $insertquery);

  if($query){
    ?>
      <script>
      alert("You Have REGISTERED Successfully.");
      </script>
    <?php 

     ?>
        <script>
          location.replace("index.php");
        </script>
    <?php
    }else{
    ?>
        <script>
        alert("REGISTRATION was FAILED.");
        </script>
    <?php 
  
    ?>
          <script>
            location.replace("registration.php");
          </script>
    <?php
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  </head>
<body>
<div class="container w-50">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <h1 class="text-center text-primary mt-4 mb-4">REGISTER YOUR ACCOUNT</h1>
        <p><b>Please fill in this form to create an account.</b></p>
        <hr>
        <div class="form-row">
            <div class="col-md-6">
                <label for="fullname">Full Name</label>
                <input type="text" class="form-control" placeholder="Enter Full Name" id="uName" name="uName" required>
            </div>

        <input type="submit" name="RegisterMe" class="mt-3 btn btn-success" value="REGISTER NOW">
        <h6 class="mt-3 text-center">Already Have Account? <a href="index.php"><b>LOG-IN HERE</b></a></h6>
    </form>
</div>
</body>
</html>