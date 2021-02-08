<?php

	$membererror = $companyerror = $adminerror = '';
	$memberpasswordhint = $companypasswordhint =$adminpasswordhint ='';
	function checkCorrect(&$membererror,&$companyerror,&$adminerror, &$memberpasswordhint, &$companypasswordhint,&$adminpasswordhint){
		require_once "config.php";

		if($_SERVER["REQUEST_METHOD"] == "POST"){
		if(isset($_POST['usermail'])){
			if($_POST['userpassword']!=''){
				$usermail = $_POST['usermail'];
				$userpassword = $_POST['userpassword'];
				$sql_statement = "SELECT * FROM UserTable U WHERE U.user_mail = '$usermail' 
				AND U.user_password = '$userpassword'";
				$result= mysqli_query($link,$sql_statement);
				$numrow = mysqli_num_rows($result);
				if($numrow>0){
					$row = mysqli_fetch_assoc($result);
					session_start();
									
					//Store data in session variables
					$_SESSION["loggedin"] = true;
					$_SESSION["id"] = $row['user_id'];
					$_SESSION["username"] = $row['user_fullname'];
					$_SESSION["type"] = "member";
					header("Location:main.php");
				}
				else{
					$membererror = "Please enter a valid user mail password combination.";
				}
			}
			else{
				$usermail = $_POST['usermail'];
				$sql_statement = "SELECT U.user_password,U.is_member FROM UserTable U WHERE U.user_mail = '$usermail'";
				$result= mysqli_query($link,$sql_statement);
				$numrow = mysqli_num_rows($result);
				if($numrow>0){
					$row = mysqli_fetch_assoc($result);
					if($row['is_member']==1){
						$firstthree = $row['user_password'];
						$memberpasswordhint = "First three characters of your password is: ".substr($firstthree, 0, 3);
					}
					else{
						$memberpasswordhint='No user found with this email.';
					}
				}
				else{
					$memberpasswordhint='No user found with this email.';
				}
			}
			
		}
		else if(isset($_POST['companymail'])){
			if($_POST['companypassword']!=''){
				$companymail = $_POST['companymail'];
				$companypassword = $_POST['companypassword'];
				$sql_statement = "SELECT * FROM CompanyTable C WHERE C.company_mail = '$companymail' 
				AND C.company_password = '$companypassword'";
				$result= mysqli_query($link,$sql_statement);
				$numrow = mysqli_num_rows($result);
				if($numrow>0){
					$row = mysqli_fetch_assoc($result);
					session_start();
									
					//Store data in session variables
					$_SESSION["loggedin"] = true;
					$_SESSION["id"] = $row['company_id'];
					$_SESSION["type"] = "company";
					header("Location:company_page.php");
				}
				else{
					$companyerror = "Please enter a valid company mail password combination.";
				}
			}
			else{
				$companymail = $_POST['companymail'];
				$sql_statement = "SELECT C.company_password FROM CompanyTable C WHERE C.company_mail= '$companymail'";
				$result= mysqli_query($link,$sql_statement);
				$numrow = mysqli_num_rows($result);
				if($numrow>0){
					$row = mysqli_fetch_assoc($result);
					$firstthree = $row['company_password'];
					$companypasswordhint = "First three characters of your password is: ".substr($firstthree, 0, 3);
				}
				else{
					$companypasswordhint='No company found with this email.';
				}
			}
			
		}
		else if(isset($_POST['adminmail'])){

			if($_POST['adminpassword']!=''){
				$adminmail = $_POST['adminmail'];
				$adminpassword = $_POST['adminpassword'];
				$sql_statement = "SELECT * FROM AdminTable A WHERE A.admin_email = '$adminmail' 
				AND A.admin_password = '$adminpassword'";
				$result= mysqli_query($link,$sql_statement);
				$numrow = mysqli_num_rows($result);
				if($numrow>0){
					$row = mysqli_fetch_assoc($result);
					session_start();
									
					//Store data in session variables
					$_SESSION["loggedin"] = true;
					$_SESSION["id"] = $row['admin_id'];
					$_SESSION["type"] = "admin";
					header("location:admin.php");
				}
				else{
					$adminerror = "Please enter a valid admin mail password combination.";
				}
			}
			else{
				$adminmail = $_POST['adminmail'];
				$sql_statement = "SELECT A.admin_password FROM AdminTable A WHERE A.admin_email = '$adminmail'";
				$result= mysqli_query($link,$sql_statement);
				$numrow = mysqli_num_rows($result);
				if($numrow>0){
					$row = mysqli_fetch_assoc($result);
					$firstthree = $row['admin_password'];
					$adminpasswordhint = "First three characters of your password is: ".substr($firstthree, 0, 3);
				}
				else{
					$adminpasswordhint='No admin found with this email.';
				}
			}
			
		}
	}
}
	checkCorrect($membererror,$companyerror,$adminerror,$memberpasswordhint,$companypasswordhint,$adminpasswordhint);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link rel="icon" type="image/png" href="https://www.sabanciuniv.edu/sites/default/files/logo_sabancicmyk.jpg" sizes="32x32" />
  <link rel="icon" type="image/png" href="https://www.sabanciuniv.edu/sites/default/files/logo_sabancicmyk.jpg" sizes="16x16" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
  <meta name="theme-color" content="#111111" />

  <link rel="manifest" href="/manifest.json">
  <link href="https://wasset.exxen.com/content/css/critic2.min.css?v=15" rel="stylesheet" />
  <title> TicketSU  </title>



  

  <meta name="title" content="Exxen">
  <meta name="description" content="Exxen">
  <meta name="keywords" content="Exxen, login, üye ol, giriş yap, kampanya">
  <meta name="robots" content="index, follow">
  <meta name="revisit-after" content="1 days">


  <meta property="og:url" content="http://www.exxen.com/tr" />
  <meta property="og:title" content="Giriş Yap" />
  <meta property="og:description" content="login, üye ol, giriş yap, kampanya">
  <meta property="og:type" content="website" />
  <meta property="og:image" content="https://wimage.exxen.com/content/img/exxen-logo.png" />
  <meta name="twitter:url" content="http://www.exxen.com/tr">
  <meta name="twitter:title" content="Giriş Yap">
  <meta name="twitter:description" content="login, üye ol, giriş yap, kampanya">
  <meta name="twitter:image" content="https://wimage.exxen.com/content/img/exxen-logo.png">
  <meta name="thumbnail" content="https://wimage.exxen.com/content/img/exxen-logo.png" />
  <meta name="fragment" content="!">



  <script type="text/javascript">
    var UserMobile = null;    var ln = "tr";
  </script>


<link href="/Content/css/reset.css" rel="stylesheet"/>
<link href="/Content/lib/jquery-ui.css" rel="stylesheet"/>
<link href="/Content/lib/bootstrap.min.css" rel="stylesheet"/>
<link href="/Content/lib/pure-release-1.0.0/pure-min.css" rel="stylesheet"/>
<link href="/Content/lib/pure-release-1.0.0/grids-responsive-min.css" rel="stylesheet"/>
<link href="/Content/lib/pure-release-1.0.0/menus-min.css" rel="stylesheet"/>
<link href="/Content/lib/swiper/swiper.min.css" rel="stylesheet"/>
<link href="/Content/css/cookies.css" rel="stylesheet"/>
<link href="/Content/css/dropdownMenu.css" rel="stylesheet"/>
<link href="/Content/css/landing-1.css" rel="stylesheet"/>
<link href="/Content/css/Site-1.5.css" rel="stylesheet"/>
<link href="/Content/css/rtl-fix.css" rel="stylesheet"/>
<link href="/Content/css/Modals.css" rel="stylesheet"/>


  

  <link href="https://wasset.exxen.com/content/lib/swiper/swiper-bundle.min.css" rel="stylesheet" />
  <link href="https://wasset.exxen.com/content/css/Landing.css" rel="stylesheet" />
  <script src="https://wasset.exxen.com/content/lib/swiper/swiper-bundle.min.js"></script>

</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col">&nbsp;</div>
		</div>
		<div class="row justify-content-md-center">
			<div class="col"></div>
			<div class="col-md-auto">
				<h2>Login
					<small class="text-muted">Member Panel</small>
				</h2>
			</div>
			<div class="col"></div>
		</div>
		<div class="text-center">
			<img src="https://upload.wikimedia.org/wikipedia/commons/c/cb/Classical_spectacular10.jpg" class="rounded" alt="Concert" width="160"> 
		</div>
		<div class="row">
			<div class="col">&nbsp;</div>
		</div>

		<div class="row justify-content-md-center">
			<div class="col-3"></div>
			<div class="col-6">
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
					<div class="form-group row"> 
						<label for="E-mail" class="col-sm-2 col-form-label">E-mail</label>
						<div class="col-sm-10">
							<input type="text" id="usermail" name="usermail" class="form-control" placeholder="E-mail">
						</div>
					</div>

					<div class="form-group row"> 
						<label for="Password" class="col-sm-2 col-form-label">Password</label>
						<div class="col-sm-10">
							<input type="Password" id="userpassword" name="userpassword" class="form-control" placeholder="Password">
						</div>
					</div>
					<span class="help-block" ><?php echo "<p style='color:red'>".$membererror."</p>"; ?></span>
					<span class="help-block" ><?php echo "<p style='color:red'>".$memberpasswordhint."</p>"; ?></span>
					<button type="submit" class="btn btn-primary btn-block btn-lg">Log in</button>
					<button type="submit" class="btn btn-primary btn-block btn-lg">Forget Password</button>
				</form>
			</div>
			<div class="col-3"></div>
		</div>
	</div>
		<div class="container">
		<div class="row">
			<div class="col">&nbsp;</div>
		</div>
		<div class="row justify-content-md-center">
			<div class="col"></div>
			<div class="col-md-auto">
				<h2>Login
					<small class="text-muted">Company Panel</small>
				</h2>
			</div>
			<div class="col"></div>
		</div>
		<div class="text-center">
			<img src="https://media.istockphoto.com/vectors/gold-comedy-and-tragedy-theater-masks-vector-id1127806019?b=1&k=6&m=1127806019&s=612x612&w=0&h=Ak6JCn3IzvU9sIjStWSjcG6IESJnRgCJhaZTZOatjJQ=" class="rounded" alt="Theatre masks" width="160"> 
		</div>
		<div class="row">
			<div class="col">&nbsp;</div>
		</div>

		<div class="row justify-content-md-center">
			<div class="col-3"></div>
			<div class="col-6">
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
					<div class="form-group row"> 
						<label for="E-mail" class="col-sm-2 col-form-label">E-mail</label>
						<div class="col-sm-10">
							<input type="text" id="companymail" name="companymail" class="form-control" placeholder="E-mail">
						</div>
					</div>

					<div class="form-group row"> 
						<label for="Password" class="col-sm-2 col-form-label">Password</label>
						<div class="col-sm-10">
							<input type="Password" id="companypassword" name="companypassword" class="form-control" placeholder="Password">
						</div>
					</div>
					<span class="help-block" ><?php echo "<p style='color:red'>".$companyerror."</p>"; ?></span>
					<span class="help-block" ><?php echo "<p style='color:red'>".$companypasswordhint."</p>"; ?></span>
					<button type="submit" class="btn btn-primary btn-block btn-lg">Log in</button>
					<button type="submit" class="btn btn-primary btn-block btn-lg">Forget Password</button>
				</form>
			</div>
			<div class="col-3"></div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col">&nbsp;</div>
		</div>
		<div class="row justify-content-md-center">
			<div class="col"></div>
			<div class="col-md-auto">
				<h2>Login
					<small class="text-muted">Admin Panel</small>
				</h2>
			</div>
			<div class="col"></div>
		</div>
		<div class="text-center">
			<img src="https://www.deccanherald.com/sites/dh/files/articleimages/2020/09/13/cinema-hall-886778-1599978918.jpg" class="rounded" alt="Cinema Hall" width="160"> 
		</div>
		<div class="row">
			<div class="col">&nbsp;</div>
		</div>

		<div class="row justify-content-md-center">
			<div class="col-3"></div>
			<div class="col-6">
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
					<div class="form-group row"> 
						<label for="E-mail" class="col-sm-2 col-form-label">E-mail</label>
						<div class="col-sm-10">
							<input type="text" id="adminmail" name="adminmail" class="form-control" placeholder="E-mail">
						</div>
					</div>

					<div class="form-group row"> 
						<label for="Password" class="col-sm-2 col-form-label">Password</label>
						<div class="col-sm-10">
							<input type="Password" id="adminpassword" name="adminpassword" class="form-control" placeholder="Password">
						</div>
					</div>
					<span class="help-block" ><?php echo "<p style='color:red'>".$adminerror."</p>"; ?></span>
					<span class="help-block" ><?php echo "<p style='color:red'>".$adminpasswordhint."</p>"; ?></span>
					<button type="submit" class="btn btn-primary btn-block btn-lg">Log in</button>
					<button type="submit" class="btn btn-primary btn-block btn-lg">Forget Password</button>
				</form>
			</div>
			<div class="col-3"></div>
		</div>
	</div>
</body>
</html>