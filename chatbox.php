<?php
session_start();
$con = mysqli_connect('localhost', 'root', '', 'chatapp');

$SelectQuery = "SELECT * FROM users WHERE id='" . $_SESSION['userId'] . "'";
$query = mysqli_query($con, $SelectQuery);
$row = mysqli_fetch_assoc($query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>My ChatBox</title>
    <link rel="stylesheet" href="css/ChatBoxStyle.css">
</head>

<body>
    <div class="container mt-2">
        <div class="row">
            <div class="col-md-4">
                <p>Hi <b><?php echo $row["User"]; ?></b></p>

                <input type="text" id="fromUser" value=<?php echo $row["id"]; ?> hidden />
                <p>Send Message to:</p>
                <ul>
                    <?php

                    $SelectQuery = "SELECT * FROM users";
                    $Msgs = mysqli_query($con, $SelectQuery);
                    while ($Msg = mysqli_fetch_assoc($Msgs)) {

                        echo '<li>
                        <a href="?toUser=' . $Msg['id'] . '">' . $Msg['User'] . '</a>             
                        </li>';
                    }
                    ?>
                </ul>
                <a class="btn btn-primary" href="index.php">Go Back</a>
            </div>

            <div class="col-mg-4">
                <!-- START  -->
                <div class="model-dialog">

                    <div class="model-content mb-1">
                        <div class="model-header">
                            <h4 class="ml-1">
                                <?php

                                if (isset($_GET["toUser"])) {

                                    $SelectQuery = "SELECT * FROM users WHERE id = '" . $_GET["toUser"] . "'";
                                    $userName = mysqli_query($con, $SelectQuery);
                                    $uName = mysqli_fetch_assoc($userName);
                                    echo '<input type="text" value=' . $_GET["toUser"] . ' id="toUser" hidden/>';
                                    echo $uName["User"];
                                } else {
                                    $SelectQuery = "SELECT * FROM users";
                                    $userName = mysqli_query($con, $SelectQuery);
                                    $uName = mysqli_fetch_assoc($userName);
                                    $_SESSION["toUser"] = $uName["id"];
                                    echo '<input type="text" value=' . $_SESSION["toUser"] . ' id="toUser" hidden/>';
                                    echo $uName["User"];
                                }
                                ?>

                            </h4>
                        </div>

                        <div class="model-body bg-light" id="msgBody" style="height:400px; width:400px; overflow-y:scroll; overflow-x:hidden;">

                        </div>

                        <div class="model-footer">
                            <div id="main">
                                <div id="content">
                                    <form id="submit_form">
                                        <div class="form-group">
                                            <textarea id="message" class="form-control" style="height:70px"></textarea>
                                            <input class="mt-2 ml-1" type="file" name="file" id="upload_file" />
                                            <button type="button" id="send" class="btn btn-primary mt-1 mb-1 ml-4" style="height:70%">Send</button>
                                            <span class="text-danger ml-1">Allowed File Type - jpg, jpeg, png, gif</span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END -->
            </div>

            <div class="col-mg-4">

            </div>
        </div>
    </div>
    <!-- AJAX-QUERY START-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

<script type="text/javascript">
    $(document).ready(function() {

        load();

        // Auto Scroll Start
        setTimeout(function() {
            $('#msgBody').scrollTop($('#msgBody').prop('scrollHeight'));
        }, 200)
        // Auto Scroll END

        // Interval Fucntion Start
        setInterval(function() {
            load();
        }, 1000);
        // Interval Fucntion END

        var fromUser = "";
        var toUser = "";
        var msg = "";
        var img = "";
        var imgFile = "";

        $("#send").on("click", function() {
            var fd = new FormData();

            fromUser = $("#fromUser").val();
            toUser = $("#toUser").val();
            msg = $("#message").val();
            img = $('#upload_file').val();
            imgFile = $('#upload_file')[0].files[0];

            if (img != '') { //Image Is Selected 

                if (msg == '') { // Message is not Written

                    // Insert Image Only
                    fd.append("fromKey", fromUser);
                    fd.append("toKey", toUser);
                    fd.append("imagekey", imgFile);

                    $.ajax({
                        url: "upload.php",
                        type: "POST",
                        data: fd,
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            $("#upload_file").val('');

                            // Auto Scroll Start
                            setTimeout(function() {
                                $('#msgBody').scrollTop($('#msgBody').prop('scrollHeight'));
                            }, 200)
                            // Auto Scroll END
                        }
                    });

                } else { // Message is Written

                    // Insert Message With Image
                    fd.append("fromKey", fromUser);
                    fd.append("toKey", toUser);
                    fd.append("message", msg);
                    fd.append("imagekey", imgFile);

                    $.ajax({
                        url: "upload.php",
                        type: "POST",
                        data: fd,
                        contentType: false,
                        processData: false,
                        success: function(data) {

                            $("#upload_file").val('');

                            // Auto Scroll Start
                            setTimeout(function() {
                                $('#msgBody').scrollTop($('#msgBody').prop('scrollHeight'));
                            }, 200)
                            // Auto Scroll END

                        }
                    });
                }

            } else if (msg != "") { // Message is Written

                // Insert Message Without Image 
                $.ajax({
                    url: "upload.php",
                    method: "POST",
                    data: {
                        fromKey: fromUser,
                        toKey: toUser,
                        message: msg
                    },
                    success: function(data) {

                        $("message").val("");

                        // Auto Scroll Start
                        setTimeout(function() {
                            $('#msgBody').scrollTop($('#msgBody').prop('scrollHeight'));
                        }, 200)
                        // Auto Scroll END

                    }
                });

            } else { // No Action Has Performed
                alert('Cannot Send Empty Message');
            }
        });

    }); // Document.ready function END

    //Current Date Format Start
    var MyDate = new Date();
    var format = "";
    format = MyDate.getDate() + "/";
    format += MyDate.getMonth() + "/";
    format += MyDate.getFullYear();
    //Current Date Formate END

    function load() { // Define
        $.ajax({
            url: "realTimeChat.php",
            method: "POST",
            data: {
                fromUser: $("#fromUser").val(),
                toUser: $("#toUser").val(),
                Dateformat: format // Key Decleration of Date 
            },

            success: function(data) {
                $("#msgBody").html(data);
            }
        });
    }
</script>
<!-- AJAX-QUERY END-->

</html>