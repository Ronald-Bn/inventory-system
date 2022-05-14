<!DOCTYPE html>
<html lang="en">

<head>
<?php include('./db_connect.php'); ?>
<?php 
session_start();
if(isset($_SESSION['login_id']))
header("location:index.php?page=home");

if($_SERVER["REQUEST_METHOD"] == "POST"){
	$username = $_POST["username"];
	$password = $_POST["password"];
	$qry = $conn->query("SELECT * FROM users where username = '".$username."' and password = '".$password."' ");
		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'passwors' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
			header("location:index.php?page=home");
		}else{
			 $_SESSION["error"] = "Username or password is incorrect.";
			 $save = $conn->query("UPDATE tblattempts set attempts = attempts + 1 where id = '1'");
		}
}
$query = $conn->query("SELECT * FROM system_settings limit 1")->fetch_array();
		foreach ($query as $key => $value) {
			if(!is_numeric($key))
				$_SESSION['setting_'.$key] = $value;
		}
?>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Red Camia Inventory System</title>
 	

<?php include('./header.php'); ?>

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
					  <?php if(isset($_SESSION["error"])) {?>	
						 <div class="alert alert-danger"><h5><?= $_SESSION["error"];?></h5></div>
					  <?php unset($_SESSION["error"]); } ?>	  
					  <form action="" method="POST" >
						  <div class="form-group">
  							<input type="text" id="username" name="username" class="form-control" placeholder="USERNAME" >
  						</div>
  						<div class="form-group">
  							<input type="password" id="password" name="password" class="form-control" placeholder="PASSWORD" >
  						</div>
						<div class="form-group">
						  <?php
						  	$qry = $conn->query("SELECT attempts FROM tblattempts where id = '1'");
							while($row=$qry->fetch_assoc()):
								if($row['attempts'] > 3){
									$_SESSION["locked"] = time(); 
									print 'Please wait for <div id="some_div">
									</div>';
									unset($_SESSION["error"]);
								}
								 else {
								  ?>
							<button class="form-control btn">SIGN IN</button>
							<?php }
							endwhile; ?>
  						</div>	
  					</form>
  				</div>
  			</div>
  		</div>
  </main>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

<script>
	var timeLeft = 30;
    var elem = document.getElementById('some_div');
    
    var timerId = setInterval(countdown, 1000);
	
    
    function countdown() {
      if (timeLeft == -1) {
        clearTimeout(timerId);
		var id = 1;
		$.ajax({
			url:'ajax.php?action=restart_attempts',
		    method	: 'POST',
		    data: { id: 1},
			success:function(resp){
				if(resp==1){
					setTimeout(function(){
						location.href = "login.php"
					},0)
				}
			}
		})	

      } else {
        elem.innerHTML = timeLeft + ' seconds remaining';
        timeLeft--;
      }
    }
</script>
</body>
</html>