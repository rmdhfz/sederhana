<?php 
	if ($_POST) {
		require_once 'connect.php';
		try {
			$name = $_POST['name'];
			$email = $_POST['email'];
			$sql = "INSERT INTO siswa (name, email) VALUES ('$name', '$email')";
			if (!$con->query($sql)) {
				echo $con->error;
			}else{
				echo json_encode("Berhasil insert data siswa");
			}
		} catch (Exception $ex){
			echo $ex;
		}
	}else{
		http_response_code(405); // method not allowed
	}
 ?>