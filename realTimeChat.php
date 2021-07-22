<?php
session_start();
$con = mysqli_connect('localhost', 'root', '', 'chatapp');

$fromUser = $_POST["fromUser"];
$toUser = $_POST["toUser"];
$Date = $_POST['Dateformat'];
$outout = "";
$SelectQuery = "SELECT * FROM messages WHERE (FromUser = '" . $fromUser . "' AND ToUser = '" . $toUser . "') OR (FromUser = '" . $toUser . "' AND ToUser = '" . $fromUser . "')";
$chats = mysqli_query($con, $SelectQuery);

while ($chat = mysqli_fetch_assoc($chats)) {
    if ($chat["FromUser"] == $fromUser) {

        //Image Nested Loop Start
        if ($chat['Image'] != '') {     // Image is Selected

            //Message Nested Loop Start
            if ($chat['Message'] == '') {      // Message is not Written
                echo "<div style='text-align:right'>
            <div class='content' style='background-color:lightblue; display:inline-block; padding:5px; border-radius:10px; max width:70%;'>
            <img src='images/$chat[Image]' alt='images' height='150px' width='97px' style='border: 1px solid; border-radius: 3px'><br>
            <a class='text-light btn btn-success' style='width:auto; height:auto' href='images/$chat[Image]' download> Download</a>
            <br>
            <span style='margin: 2px;'><b>$Date</b></span>
            </div>
            </div>";
            } else { // Image + Message
                echo "<div style='text-align:right'>
            <p style='background-color:lightblue; word-wrap: break-word; display:inline-block; padding:5px; border-radius:10px; max width:70%;'>" . $chat["Message"] . "<br><img src='images/$chat[Image]' alt='images' height='150' width='97' style='border: 1px solid; border-radius: 3px'><br><a class='text-light btn btn-success'  style='width:auto; height:auto' href='images/$chat[Image]' download>Download</a><br><span style='margin: 2px;'><b>$Date</b></span>" . "</p>    
            </div>";
            } //Message Nested Loop END

        } else {    // Only Message is Written
            echo "<div style='text-align:right'>
            <p style='background-color:lightblue; word-wrap: break-word; display:inline-block; padding:5px; border-radius:10px; max width:70%;'>" . $chat["Message"] . "<br><span style='margin: 2px;'><b>$Date</b></span></p>
            </div>";
        } //Image Nested Loop END


    } else {     // ToUser == $toUser

        //Image Nested Loop Start
        if ($chat['Image'] != '') {     // Image is Selected

            //Message Nested Loop Start
            if ($chat['Message'] == '') {      // Message is not Written
                echo "<div style='text-align:left'>
                <div class='content' style='background-color:yellow; display:inline-block; padding:5px; border-radius:10px; max width:70%;'>
                <img src='images/$chat[Image]' alt='images' height='150px' width='97px' style='border: 1px solid; border-radius: 3px'><br>
                <a class='text-light btn btn-success' width:auto; href='images/$chat[Image]' download>Download</a>
                <br>
                <span style='margin: 2px; text-align:right'><b>$Date</b></span>
                </div>
                </div>";
            } else { // Image + Message
                echo "<div style='text-align:left'>
                <p style='background-color:yellow; word-wrap: break-word; display:inline-block; padding:5px; border-radius:10px; max width:70%;'>" . $chat["Message"] . "<br><img src='images/$chat[Image]' alt='images' height='150' width='97' style='border: 1px solid; border-radius: 3px'><br><a class='text-light btn btn-success'  style='width:auto; height:auto' href='images/$chat[Image]' download>Download</a><br><span><b>$Date</b></span>" . "</p>
                </div>";
            } //Message Nested Loop END

        } else { // Only Message is Written

            echo "<div style='text-align:left'>
            <p style='background-color:yellow; word-wrap: break-word; display:inline-block; padding:5px; border-radius:10px; max width:70%;'>" . $chat["Message"] . "<br><span style='margin: 2px; text-align:right'><b>$Date</b></span></p>
            </div>";
        } //Image Nested Loop END

    }
}
echo $outout;
