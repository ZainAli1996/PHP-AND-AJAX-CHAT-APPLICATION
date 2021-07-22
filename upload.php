<?php
if (isset($_FILES['imagekey']['name']) && isset($_POST['message'])) {

	// Insert Image and Message
	$filename = $_FILES['imagekey']['name']; // Get the Uploaded file Name.

	$extension = pathinfo($filename, PATHINFO_EXTENSION); //Get the Extension of uploded file.

	$valid_extensions = array("jpg", "jpeg", "png", "gif");

	if (in_array($extension, $valid_extensions)) { // check if upload file is a valid image file.
		$new_name = rand() . "." . $extension;
		$path = "images/" . $new_name;

		if (move_uploaded_file($_FILES['imagekey']['tmp_name'], $path)) { // Upload the Image File on server path
			// echo '<script>alert("Image and Message Uploaded Successfully.")</script>';
		}

		// Insert Message into Database Along With Image "Start"
		$con = mysqli_connect('localhost', 'root', '', 'chatapp');

		$fromUser = $_POST["fromKey"];
		$toUser = $_POST["toKey"];
		$message = $_POST["message"];
		$Image = $new_name;

		$output = "";

		$InsertQuery = "INSERT INTO `messages`(`FromUser`, `ToUser`, `Message`, `Image`) VALUES ('$fromUser', '$toUser', '$message', '$Image')";

		$query = mysqli_query($con, $InsertQuery);

		if ($query) {
			$output .= "";
		} else {
			$output .= "Error, Failed to insert Image and Message.";
		}
		echo $output;
	} else {
		echo '<script>alert("Invalid File Format, Please Select Correct Image Format.")</script>';
	} // Insert Message into Database Along With Image "End"

} else if (isset($_FILES['imagekey']['name'])) {

	// Insert Only Image
	$filename = $_FILES['imagekey']['name']; // Get the Uploaded file Name.

	$extension = pathinfo($filename, PATHINFO_EXTENSION); //Get the Extension of uploded file.

	$valid_extensions = array("jpg", "jpeg", "png", "gif");

	if (in_array($extension, $valid_extensions)) { // check if upload file is a valid image file.
		$new_name = rand() . "." . $extension;
		$path = "images/" . $new_name;

		if (move_uploaded_file($_FILES['imagekey']['tmp_name'], $path)) { // Upload the Image File on server path
			// echo '<script>alert("Only Image Uploaded Successfully.")</script>';
		}

		// Insert Only Image into Database "Start"
		$con = mysqli_connect('localhost', 'root', '', 'chatapp');

		$fromUser = $_POST["fromKey"];
		$toUser = $_POST["toKey"];
		$Image = $new_name;

		$output = "";

		$InsertQuery = "INSERT INTO `messages`(`FromUser`, `ToUser`, `Image`) VALUES ('$fromUser', '$toUser', '$Image')";

		$query = mysqli_query($con, $InsertQuery);

		if ($query) {
			$output .= "";
		} else {
			$output .= "Error, Failed to insert Only Image.";
		}
		echo $output;
	} else {
		
	} // Insert Only Image into Database "END"

} else {

	// Insert Message into Database Without Image "Start"
	$con = mysqli_connect('localhost', 'root', '', 'chatapp');

	$fromUser = $_POST["fromKey"];
	$toUser = $_POST["toKey"];
	$message = $_POST["message"];

	$output = "";

	$InsertQuery = "INSERT INTO `messages`(`FromUser`, `ToUser`, `Message`) VALUES ('$fromUser', '$toUser', '$message')";

	$query = mysqli_query($con, $InsertQuery);

	if ($query) {
		$output .= "";
	} else {
		$output .= "Error, Failed to insert Only Message.";
	}
	echo $output;

} // Insert Message into Database Without Image "End"
