<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="author" content="Muhamad Nauval Azhar">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="description" content="This is a login page template based on Bootstrap 5">
	<title>Kost Apps</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>

<body>
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-sm-center h-100">
				<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
					<div class="text-center my-5">
						<img src="https://mamikos.com/assets/logo/svg/logo_mamikos_green.svg" alt="logo" width="100">
					</div>
					<div class="card shadow-lg">
						<div class="card-body p-5">
							<h1 class="fs-4 card-title fw-bold mb-4">Login</h1>
							<form method="POST" class="needs-validation" novalidate="" autocomplete="off">
								<div class="mb-3">
									<label class="mb-2 text-muted" for="email">E-Mail Address</label>
									<input id="email" type="email" class="form-control" name="email" value="" required autofocus>
									<div class="invalid-feedback">
										Email is invalid
									</div>
								</div>

								<div class="mb-3">
									<div class="mb-2 w-100">
										<label class="text-muted" for="password">Password</label>
									</div>
									<input id="password" type="password" class="form-control" name="password" required>
								    <div class="invalid-feedback">
								    	Password is required
							    	</div>
								</div>

								<div class="d-flex align-items-center">
									<button type="button" class="btn btn-primary ms-auto" id="btn-login">
										Login
									</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    
	<script>
        checkAuth();
        function login(email, password)
        {
            $('#btn-login').addClass('disabled');
            return $.ajax({
                type: 'POST',
                url: "{{config('app.url')}}/api/v1/auth/login",
                data: {
                    email: email,
                    password: password
                },
                success: function (response){

					if(response.data.user.user_type === 'owner'){
						localStorage.setItem('access_token', response.data.access_token);
                    	window.location.replace("{{url('/dashboard')}}");
					}else{
						$('#btn-login').removeClass('disabled');
						alert('You are not owner');
					}
                   
                },
                error: function (response) {
                    $('#btn-login').removeClass('disabled');
                    alert('Failed login');
                }
            });
        }

        function checkAuth()
        {
            var data = localStorage.getItem('access_token');

            if(data !== null){
                window.location.replace("{{url('/dashboard')}}");
            }
        }

        $(document).on('click', '#btn-login', function(){
            login($('#email').val(), $('#password').val());
        });
    </script>
</body>
</html>