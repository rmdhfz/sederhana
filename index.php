<!DOCTYPE html>
<html>
<head>
	<title>Sederhana</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- import bootstrap -->
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" media="screen, projection">
</head>
<body>
	<center>
		<h1>Aplikasi Sederhana - CRUD (Create Read Update Delete) - PHP Native</h1>
		<button type="button" class="btn btn-sm btn-flat btn-primary waves-effect" data-toggle="modal" data-target="#modal-siswa" data-backdrop="static" data-keyboard="false">
			Add Data
		</button><hr><br>
	</center>
	<div class="container">
		<table id="table-siswa" class="table table-striped table-responsive" style="width: 100%;">
			<thead>
				<tr>
					<th>No</th>
					<th>Name</th>
					<th>Email</th>
					<th>Date</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					require_once 'connect.php';
					$query = mysqli_query($con, "SELECT * FROM siswa");
					if($query){
						$no = 1;
						while($object = mysqli_fetch_object($query)){ ?>
							<tr>
								<td><?php echo $no;?></td>
								<td><?php echo $object->name;?></td>
								<td><?php echo $object->email;?></td>
								<td><?php echo $object->created_at;?></td>
								<td>
									<a id="edit" data-id="<?php echo $object->id;?>" class="btn btn-warning btn-sm">Edit</a>
									<a id="delete" data-id="<?php echo $object->id;?>" class="btn btn-danger btn-sm">Delete</a>
								</td>
							</tr>
						<?php $no++; } ?>
					 <?php } ?>
			</tbody>
		</table>
	</div>

	<div id="modal-siswa" tabindex="-1" role="dialog" class="modal fade modal-flex">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Form Siswa</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="container-fluid">
						<form id="form-siswa" accept-charset="utf-8" autocomplete="off" method="post">
							<input type="hidden" name="id" id="id">
							<div class="form-group row">
								<label class="col-sm-2 col-form-label">
									Name
								</label>
								<div class="col-sm-10">
									<input type="text" name="name" id="name" class="form-control" required="1" placeholder="enter your name" minlength="3" maxlength="35">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 col-form-label">
									Email
								</label>
								<div class="col-sm-10">
									<input type="email" name="email" id="email" class="form-control" required="1" placeholder="enter your email" minlength="4" maxlength="35">
								</div>
							</div>
							<button type="submit" name="submit_" id="submit_" value="true" hidden="1"></button>
						</form>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" onclick="$('#submit_').click()" class="btn btn-sm btn-primary waves-effect waves-light btn-block">Submit</button>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- import js -->
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		const FormSiswa = $("#form-siswa");
		FormSiswa.submit(function(event) {
			event.preventDefault();
			const data = $(this).serialize();
			const con = confirm("Are you sure submit this data ?");
			if (con) {
				if (data) {
					let url, id = $("#id").val();
					if (id) {
						url = "update.php";
					}else{
						url = "save.php";
					}
					$.post(url, data, function(resp) {
						if (resp) {
							alert(resp);
							/*reload*/
							window.location.reload(false);
						}
					});
				}
			}else{
				console.log("Cancel submit");
			}
		});

		/*get byid*/
		$("#table-siswa").on('click', '#edit', function(event) {
			event.preventDefault();
			const id = $(this).data('id');
			if (id) {
				$.post('getById.php', {id: id}, function(resp) {
					if (resp) {
						let response = $.parseJSON(resp),
							data = response.data;
							if (data) {
								$("#modal-siswa").modal('show');
								$("#id").val(data.id);
								$("#name").val(data.name);
								$("#email").val(data.email);
							}
					}
				});
			}
		});

		/*delete*/
		$("#table-siswa").on('click', '#delete', function(event) {
			event.preventDefault();
			const con = confirm("Are you sure to delete this data ?");
			if (con) {
				/*confirm*/
				const id = $(this).data('id');
				if (id) {
					$.post('delete.php', {id: id}, function(resp) {
						if (resp) {
							alert(resp);
							window.location.reload(false); // reload
						}
					});
				}
			}else{
				console.log("cancel delete");
			}
		});
	});
</script>
</html>