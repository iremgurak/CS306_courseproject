<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$username = $password = $mobile = $email = $gender = $age = $address = $member = $point ="";
$username_err = $password_err = $mobile_err = $email_err = $gender_err = $age_err = $address_err ="";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a full-name.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM UserTable WHERE user_fullname = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } 
            else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate moblie
    if(empty(trim($_POST["mobile"]))){
        $mobile_err = "Please enter mobile.";     
    }  else{
        $mobile = trim($_POST["mobile"]);
    }

    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter an e-mail.";     
    }  else{
        $email = trim($_POST["email"]);
    }

    // Validate gender
    if(empty(trim($_POST["gender"]))){
        $gender_err = "Please enter your gender.";     
    }  else{
        $gender = trim($_POST["gender"]);

        if ($gender == "Male") {
            $gender = 0;
        } 

        else if ($gender == "Female") {
                $gender = 1;
        }

        else {
            $gender = 2;
        }
    }

     // Validate age
     if(empty(trim($_POST["age"]))){
        $age_err = "Please enter your age.";     
    }  else{
        $age = trim($_POST["age"]);
    }

    // Validate address
    if(empty(trim($_POST["address"]))){
        $address_err = "Please enter your address.";     
    }  else{
        $address = trim($_POST["address"]);
    }

    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter your fullname.";     
    }  else{
        $username = trim($_POST["username"]);
    }
    
    // Check input errors before inserting in database
        
    if(empty($username_err) && empty($password_err) && empty($gender_err) && empty($address_err) && empty($age_err) && empty($email_err) && empty($gender_err)) {

    
        // Prepare an insert statement
        $sql = "INSERT INTO UserTable (user_fullname, user_mobile, user_address, is_member ,user_mail, user_password, user_gender, member_point, user_age) VALUES (?,?,?,?,?,?,?,?,?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssssss", $param_username, $param_mobile, $param_address, $param_member,$param_email, $param_password, $param_gender, $param_point, $param_age);
            
            // Set parameters
            $param_username = $username;
            $param_mobile = $mobile;
            $param_email = $email;
            $param_gender = $gender;
            $param_age= $age;
            $param_address = $address;
            $param_password = $password; 
            $param_point =0;
            $param_member = 1;

            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page 
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}

?>
 
<!DOCTYPE html>
<html lang="tr">
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
<body class="page-ltr">


<div class="">
  <section class="section">
    <div class="headline">
      <header class="header">
        <div class="logo">
          <img src="https://www.sabanciuniv.edu/sites/default/files/logo_sabancicmyk.jpg" alt="Logo" class="logo" />
      </header>

      <h1 class="headline__title">
        <strong> SING UP </strong> 
      </h1>

  </section>

  <section class="section mt80">
  </section>

  <section class="section">

    <div class="wrapper" style= "width:200px; margin: 0 auto;">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Fullname</label>
                <input type="text" style = "width:236px" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" style = "width:236px" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($mobile_err)) ? 'has-error' : ''; ?>">
                <label>Mobile</label>
                <input type="tel" style = "width:236px" name="mobile" class="form-control" value="<?php echo $mobile; ?>">
                <span class="help-block"><?php echo $mobile_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>E-Mail</label>
                <input type="mail" style = "width:236px" name="email" class="form-control" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div> 
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Gender</label>
                <br>
                <input type="radio" name="gender" value="Male"> Male<br>
                <input type="radio" name="gender" value="Female"> Female<br>
                <input type="radio" name="gender" value="Other"> Other
                <span class="help-block"><?php echo $gender_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($age_err)) ? 'has-error' : ''; ?>">
                <label>Age</label>
                <input type="number" style = "width:236px" name="age" class="form-control" value="<?php echo $age; ?>">
                <span class="help-block"><?php echo $age_err; ?></span>
            </div> 

            <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                <label>Address</label>
                <input type="text" style = "width:236px" name="address" class="form-control" value="<?php echo $address; ?>">
                <span class="help-block"><?php echo $address_err; ?></span>
            </div> 

            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p >Already have an account? <a href="./login.php">Login here</a>.</p>
        </form>
    </div>    
      
   
  </section>
</div>


  <script src="/Scripts/lib/bootstrap.js"></script>
<script src="/Scripts/lib/respond.js"></script>
<script src="/Scripts/lib/dedectClient.js"></script>
<script src="/Scripts/ApiProvider/ErcmsApiProvider-1.0.js"></script>
<script src="/Scripts/ApiProvider/LocalrProvider.js"></script>
<script src="/Scripts/Page/GlobalData-1.3.js"></script>
<script src="/Scripts/ApiProvider/UesProvider-1.0.js"></script>
<script src="/Scripts/Page/cookiePopup.js"></script>
<script src="/Scripts/Page/Search-1.1.js"></script>
<script src="/Scripts/Page/ResponsiveSettings.js"></script>
<script src="/Scripts/PageCustomJs/layout.js"></script>
<script src="/Scripts/Helper/InputValidation.js"></script>

  


  
  
<script src="/scripts/lib/jquery.form.min.js"></script>
<script src="/scripts/lib/vue.min.js"></script>
<script src="/scripts/Helper/InputValidation.js"></script>
<script src="/Scripts/ViewScripts/Landing/Landing.js"></script>



</body>
</html>