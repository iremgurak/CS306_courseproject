<?php
// Include config file
require_once "config.php";
session_start();
$userid = $_SESSION["id"];
// Define variables and initialize with empty values
$user_name = $user_mobile = $user_address =$user_password= $user_mail = $user_age = "";
$user_name_err = $user_mobile_err = $user_address_err = $user_password_err =$user_mail_err = $user_age_err = "";

// Processing form data when form is submitted
if (isset($_POST["sub"])) {
    
    // Validate name
    $input_user_name = trim($_POST["user_name"]);
    if (empty($input_user_name)) {
        $user_name_err = "Please enter a name.";
    } else {
        $user_name = trim($_POST["user_name"]);
    }

   
    // Validate mobile
    $user_mobile_input = trim($_POST["user_mobile"]);
    if (empty($user_mobile_input)) {
        $user_mobile_err = "Please enter the your mobile.";
    } else {
        $user_mobile = trim($_POST["user_mobile"]);
    }

    // Validate age
    $user_age_input = trim($_POST["user_age"]); 
    if (empty($user_age_input)) {
        $user_age_err = "Please enter a positive integer.";
    } else {
        $user_age = trim($_POST["user_age"]);
    }
    
    // Validate mail
    $user_mail_input = trim($_POST["user_mail"]);
    if (empty($user_mail_input)) {
        $user_mail_err = "Please enter your mail.";
    } else {
        $user_mail = trim($_POST["user_mail"]);
    }

    // Validate type
    $user_address_input = trim($_POST["user_address"]);
    if (empty($user_address_input)) {
        $user_address_err = "Please enter your address.";
    } else {
        $user_address = trim($_POST["user_address"]);
    }

    // Validate image
    $user_pass_input = trim($_POST["user_password"]);
    if (empty($user_pass_input)) {
        $user_password_err = "Please enter new password";
    } else {
        $user_password = trim($_POST["user_password"]);
    }

    
    // Check input errors before inserting in database
    if (
        empty($user_name_err) && empty($user_mobile_err) && empty($user_address_err)
        && empty($user_mail_err) && empty($user_age_err) && empty($user_password_err)
    ) {
        // Prepare an update statement
        $sql_update_user = "UPDATE UserTable SET  user_fullname='$user_name', user_mobile='$user_mobile', user_address='$user_address', user_password='$user_password', user_age=$user_age,user_mail='$user_mail' WHERE user_id=$userid";
        mysqli_query($link, $sql_update_user);
        header("Location:profile.php");
    }
} else {
    // Check existence of id parameter before processing further
        // Get URL paramete

        // Prepare a select statement
        $sql_select = "SELECT user_fullname,user_mobile,user_address,user_mail,user_password,user_age,member_point FROM UserTable WHERE user_id = $userid";
        $result2 = mysqli_query($link, $sql_select);
        // Bind variables to the prepared statement as parameters
            
        /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
        $row = mysqli_fetch_assoc($result2);

        // Retrieve individual field value
        $user_name = $row["user_fullname"];
        $user_mobile = $row["user_mobile"];
        $user_address = $row["user_address"];
        $user_password = $row["user_password"];
        $user_age = $row["user_age"];
        $user_mail = $row["user_mail"];
        $member_point= $row["member_point"];
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
    <title> TicketSU </title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper {
            width: 500px;
            margin: 0 auto;
        }
    </style>




    <link href="/Content/css/reset.css" rel="stylesheet" />
    <link href="/Content/lib/jquery-ui.css" rel="stylesheet" />
    <link href="/Content/lib/bootstrap.min.css" rel="stylesheet" />
    <link href="/Content/lib/pure-release-1.0.0/pure-min.css" rel="stylesheet" />
    <link href="/Content/lib/pure-release-1.0.0/grids-responsive-min.css" rel="stylesheet" />
    <link href="/Content/lib/pure-release-1.0.0/menus-min.css" rel="stylesheet" />
    <link href="/Content/lib/swiper/swiper.min.css" rel="stylesheet" />
    <link href="/Content/css/cookies.css" rel="stylesheet" />
    <link href="/Content/css/dropdownMenu.css" rel="stylesheet" />
    <link href="/Content/css/landing-1.css" rel="stylesheet" />
    <link href="/Content/css/Site-1.5.css" rel="stylesheet" />
    <link href="/Content/css/rtl-fix.css" rel="stylesheet" />
    <link href="/Content/css/Modals.css" rel="stylesheet" />




    <link href="https://wasset.exxen.com/content/lib/swiper/swiper-bundle.min.css" rel="stylesheet" />
    <link href="https://wasset.exxen.com/content/css/Landing.css" rel="stylesheet" />
    <script src="https://wasset.exxen.com/content/lib/swiper/swiper-bundle.min.js"></script>

</head>

<body class="page-ltr">
    <!-- Google Tag Manager (noscript) -->

    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TCXGM82" height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>

    <div class="">
        <section class="section">
            <div class="headline">
                <header class="header">
                    <div class="logo">
                        <img src="https://www.sabanciuniv.edu/sites/default/files/logo_sabancicmyk.jpg" alt="Logo" class="logo" />
                </header>

                <h1 class="headline__title">
                    <strong> UPDATE RECORD </strong>
                </h1>

        </section>

        <section class="section mt80">

            <div class="wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12" style="color:white; margin-top:0px ; margin-bottom:50px;">
                            
                            <p>Please edit the input values and submit to update the record.</p>
                            <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                                <div class="form-group <?php echo (!empty($user_name_err)) ? 'has-error' : ''; ?>">
                                    <label>Fullname</label>
                                    <input type="text" name="user_name" class="form-control" value="<?php echo $user_name; ?>">
                                    <span class="help-block"><?php echo $user_name_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($user_mobile_err)) ? 'has-error' : ''; ?>">
                                    <label>Mobile</label>
                                    <input type="text" name="user_mobile" class="form-control" value="<?php echo $user_mobile; ?>">
                                    <span class="help-block"><?php echo $user_mobile_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($user_address_err)) ? 'has-error' : ''; ?>">
                                    <label>Address</label>
                                    <textarea name="user_address" class="form-control"><?php echo $user_address; ?></textarea>
                                    <span class="help-block"><?php echo $user_address_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($user_mail_err)) ? 'has-error' : ''; ?>">
                                    <label>E-mail</label>
                                    <input type="text" name="user_mail" class="form-control" value="<?php echo $user_mail; ?>">
                                    <span class="help-block"><?php echo $user_mail_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($user_password_err)) ? 'has-error' : ''; ?>">
                                    <label>Password</label>
                                    <input type="text" name="user_password" class="form-control" value="<?php echo $user_password; ?>">
                                    <span class="help-block"><?php echo $user_password_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($user_age_err)) ? 'has-error' : ''; ?>">
                                    <label>Age</label>
                                    <input type="number" name="user_age" class="form-control" value="<?php echo $user_age; ?>">
                                    <span class="help-block"><?php echo $user_age_err; ?></span>
                                </div>

                                <input type="submit" name ="sub" class="btn btn-primary" value="Submit">
                                <a href="profile.php" class="btn btn-default">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section">


        </section>
    </div>



    <script src="/Scripts/lib/jquery-3.4.1.min.js"></script>
    <script src="/Scripts/lib/jquery-ui.min.js"></script>
    <script src="/Content/lib/swiper/swiper.min.js"></script>
    <script src="/Scripts/Page/RequestPool.js"></script>
    <script src="/Scripts/Page/req.js"></script>

    <script type="text/javascript">
        function imgError(image) {
            image.onerror = "";
            image.src = "https://wimage.exxen.com/content/img/null-image.jpg";
            return true;
        }
    </script>
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