
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Development Area</title>
	<!-- ALL CSS FILES  -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">

</head>
<body>
	
	

	<div class="wrap-table">
        <a id="create_btn" href="#" class="btn btn-success mb-2">Create</a>
		<div class="card shadow">
			<div class="card-body">
				<h2>All Customers</h2>
				<table class="table table-striped">
					<thead>
						<tr>
							<th>#</th>
							<th>Email</th>
							<th>Gender</th>
							<th>Hobbies</th>
							<th>Location</th>
							<th>Photo</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody id="main_content">
                        
					</tbody>
				</table>
			</div>
		</div>
	</div>

    {{-- Create Modal --}}
	<div id="create_modal" class="modal fade">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Add New Customer</h4>
                </div>
                <div class="modal-body">
                    <form id="create_form" action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" class="form-control" type="text" name="email">
                        </div>
                        <div class="form-group">
                            <label for="photo">Photo</label>
                            <input id="photo" class="form-control-file" type="file" name="photo">
                        </div>

                        <label><b>Gender</b></label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" id="male" value="Male">
                            <label class="form-check-label" for="male">
                                Male
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" id="female" value="Female">
                            <label class="form-check-label" for="female">
                                Female
                            </label>
                        </div> 
						<br>


						<label><b>Hobbies</b></label>
						<div class="form-check">
							<input class="form-check-input" type="checkbox" value="Reading" id="reading" name="hobbies[]">
							<label class="form-check-label" for="reading">Reading</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="checkbox" value="Writing" id="writing" name="hobbies[]">
							<label class="form-check-label" for="writing">Writing</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="checkbox" value="Painting" id="painting" name="hobbies[]">
							<label class="form-check-label" for="painting">Painting</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="checkbox" value="Travelling" id="travelling" name="hobbies[]">
							<label class="form-check-label" for="travelling">Travelling</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="checkbox" value="Photography" id="photography" name="hobbies[]">
							<label class="form-check-label" for="photography">Photography</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="checkbox" value="Vediography" id="vediography" name="hobbies[]">
							<label class="form-check-label" for="vediography">Vediography</label>
						</div>


						<select name="location" class="form-select my-4">
							<option selected disabled>- Location -</option>
							<option value="Barisal">Barisal</option>
							<option value="Chittagong">Chittagong</option>
							<option value="Dhaka">Dhaka</option>
							<option value="Khulna">Khulna</option>
							<option value="Mymensingh">Mymensingh</option>
							<option value="Rajshahi">Rajshahi</option>
							<option value="Rangpur">Rangpur</option>
							<option value="Sylhet">Sylhet</option>
						</select>
						
                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" value="Add Now">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

	{{-- View Modal --}}
	<div id="view_modal" class="modal fade">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">				
				<div class="modal-body text-center">
					<img id="photo" style="max-width: 100%; height: 200px;" src="">
					<table class="table mt-3">
						<tr>
							<th>Email</th>
							<td id="email"></td>
						</tr>
						<tr>
							<th>Gender</th>
							<td id="gender"></td>
						</tr>
						<tr>
							<th>Location</th>
							<td id="location"></td>
						</tr>
						<tr>
							<th>Hobbies</th>
							<td id="hobbies"></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>


	{{-- Edit Modal --}}
	<div id="edit_modal" class="modal fade">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">				
				<div class="modal-body">
                    <form id="edit_form" action="" method="POST" enctype="multipart/form-data">
                        @csrf
						<input type="hidden" name="get_id" id="get_id">
                        <div class="form-group">
                            <label for="edit_email">Email</label>
                            <input id="edit_email" class="form-control" type="text" name="edit_email">
                        </div>

                        <div class="form-group">
                            <label for="edit_photo">Photo</label>
                            <input type="hidden" name="old_photo" id="old_photo">
                            <input id="edit_photo" class="form-control-file" type="file" name="new_photo">
                        </div>

                        <label><b>Gender</b></label>
                        <div class="form-check" id="gender"></div>   <br>                  
										
						<div class="form-check" id="edit_hobbies"> </div>

						<select name="edit_location" class="form-select my-4" id="edit_location"> </select>
						
                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" value="Update Profile">
                        </div>
                    </form>
				</div>
			</div>
		</div>
	</div>




	<!-- JS FILES  -->
	<script src="{{ asset('assets/js/jquery-3.4.1.min.js') }}"></script>
	<script src="{{ asset('assets/js/popper.min.js') }}"></script>
	<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script src="{{ asset('assets/js/custom.js') }}"></script>
</body>
</html>