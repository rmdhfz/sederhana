<?php 
	if ($_POST) {
		$id = $_POST['id'];
		if ($id) {
			$name = $_POST['name'];
			$email = $_POST['email'];
			if ($name && $email) {
				require_once 'connect.php';
				try {
					$sql = "UPDATE siswa SET name = '$name', email = '$email' WHERE id = '$id'";
					if (!$con->query($sql)) {
						echo $con->error;
					}else{
						echo json_encode("Berhasil update data siswa");
					}
				} catch (Exception $ex) {
					echo $ex;
				}
			}
		}else{
			http_response_code(400); // bad request
		}
	}else{
		http_response_code(405); // method not allowed
	}

 ?>