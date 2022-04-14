<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Admin | Groceries Sales and Inventory System</title>
 	

<?php include('./header.php'); ?>
<?php include('./db_connect.php'); ?>
<?php 
session_start();
if(isset($_SESSION['login_id']))
header("location:index.php?page=home");

$query = $conn->query("SELECT * FROM system_settings limit 1")->fetch_array();
		foreach ($query as $key => $value) {
			if(!is_numeric($key))
				$_SESSION['setting_'.$key] = $value;
		}
?>

</head>
<style>
	@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Poppins", sans-serif;
}

	body{
		width: 100%;
	    height: calc(100%);
  		display: flex;
  		justify-content: center;
  		align-items: center;
  		padding: 10px;
	    background-image:url('background-1.jpg');
		background-size: cover;
  		background-repeat: no-repeat;
  		min-height: 100vh;
  		min-width: 100vw;	
	}

	#login-right{
		max-width: 700px;
  		width: 100%;
  		padding: 25px 30px;
  		border-radius: 5px;
	}
	
	#login-right .card{
		margin: auto;
		background: #fdf001;
		border:2px black solid;
		text-align: center;
	}

	.logo {
    margin: auto;
    font-size: 8rem;
    background: white;
    padding: .5em 0.8em;
    border-radius: 50% 50%;
    color: #000000b3;
	}

	.btn{
		width:100%;
		background-color:#000;
		color:#FFF;
	}

	.h1{
		color:#000;
	}
	.img{;
		margin-top:50px
	}

</style>

<body>
  <main id="main">
  		<div id="login-right">
  			<div class="card col-md-8">
				  <div class="card-body">
					  <img src="logo-1.png" width="60%" height="60%">
					  <h1>LOGIN<h1>
					  <form id="login-form" >
						  <div class="form-group">
  							<input type="text" id="username" name="username" class="form-control" placeholder="USERNAME" >
  						</div>
  						<div class="form-group">
  							<input type="password" id="password" name="password" class="form-control" placeholder="PASSWORD" >
  						</div>
						<div class="form-group">
							<button class="form-control btn">SIGN IN</button>
  						</div>
							
  					</form>
  				</div>
  			</div>
  		</div>
  </main>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>


</body>
<script>
	$('#login-form').submit(function(e){
		e.preventDefault()
		$('#login-form button[type="button"]').attr('disabled',true).html('Logging in...');
		if($(this).find('.alert-danger').length > 0 )
			$(this).find('.alert-danger').remove();
		$.ajax({
			url:'ajax.php?action=login',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
		$('#login-form button[type="button"]').removeAttr('disabled').html('Login');

			},
			success:function(resp){
				if(resp == 1){
					location.href ='index.php?page=home';
				}else if(resp == 2){
					location.href ='voting.php';
				}else{
					$('#login-form').prepend('<div class="alert alert-danger"><h5>Username or password is incorrect.</h5></div>')
					$('#login-form button[type="button"]').removeAttr('disabled').html('Login');
				}
			}
		})
	})
</script>	
</html>