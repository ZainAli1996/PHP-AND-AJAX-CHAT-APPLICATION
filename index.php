<?php
session_start();
$con = mysqli_connect('localhost', 'root', '', 'chatapp');

if (isset($_GET['userId'])) {

    $_SESSION['userId'] = $_GET['userId'];
    header('location:chatbox.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN PAGE</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/Style.css">
</head>

<body>
    <div class="container">
        <h1 class="text-center text-primary mt-2">PHP CHAT APPLICATION</h1>
        <div class="card">

            <div class="model-dialog">

                <div class="model-content">
                    <div class="model-header">
                        <h4 class="text-center">PLEASE SELECT YOUR ACCOUNT</h4>
                    </div>
                    <div class="model-body">
                        <ol>
                            <?php
                            $SelectQuery = "SELECT * from users";
                            $users = mysqli_query($con, $SelectQuery);
                            while ($row = mysqli_fetch_array($users)) {

                                echo '<li>
                    <a href="index.php?userId=' . $row['id'] . '">' . $row['User'] . '</a>             
                    </li>';
                            }
                            ?>
                        </ol>
                        <a class="d-flex justify-content-center btn btn-success" href="registration.php">Don't Have Account? Register Here.</a>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>