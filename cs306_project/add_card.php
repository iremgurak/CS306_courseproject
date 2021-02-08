<?php
// Include config file
require_once "config.php";
session_start();
$userid = $_SESSION["id"];
// Define variables and initialize with empty values
$card_num = $card_owner = $card_type = $card_end_date = $card_cvv = "";
$card_num_err = $card_owner_err = $card_type_err = $card_end_date_err = $card_cvv_err = "";

// Processing form data when form is submitted
if (isset($_POST["sub"])) {
    // Validate name
    $input_card_num = trim($_POST["card_num"]);
    if (empty($input_card_num)) {
        $card_num_err = "Please enter a card number.";
    } else {
        $card_num = trim($_POST["card_num"]);
    }


    // Validate mobile
    $card_owner_input = trim($_POST["card_owner"]);
    if (empty($card_owner_input)) {
        $card_owner_err = "Please enter a card owner.";
    } else {
        $card_owner = trim($_POST["card_owner"]);
    }

    // Validate age
    $card_type_input = trim($_POST["card_type"]);
    if (empty($card_type_input)) {
        $card_type_err = "Please enter a card type.";
    } else {
        $card_type = trim($_POST["card_type"]);
    }

    // Validate mail
    $card_end_date_input = trim($_POST["card_end_date"]);
    if (empty($card_end_date_input)) {
        $card_end_date_err = "Please enter end date.";
    } else {
        $card_end_date = trim($_POST["card_end_date"]);
    }

    // Validate type
    $card_cvv_input = trim($_POST["card_cvv"]);
    if (empty($card_cvv_input)) {
        $card_cvv_err = "Please enter cvv.";
    } else {
        $card_cvv = trim($_POST["card_cvv"]);
    }


    // Check input errors before inserting in database
    if (
        empty($card_num_err) && empty($card_owner_err) && empty($card_type_err)
        && empty($card_end_date_err) && empty($card_cvv_err)
    ) {
        session_start();
        $userid = $_SESSION["id"];
        // Prepare an update statement
        $sql_update_user = "INSERT INTO CreditCardTable(user_id,creditcard_num, creditcard_fullname,creditcard_type, creditcard_enddate,creditcard_cvv) VALUES($userid,'$card_num','$card_owner','$card_type','$card_end_date',$card_cvv)";

        mysqli_query($link, $sql_update_user);
        header("Location:profile.php");
    }
} else {
    // Check existence of id parameter before processing further
    // Get URL paramete

    // Prepare a select statement

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

                    </div>
                </header>

                <h1 class="headline__title">
                    <strong> ADD CARD </strong>
                </h1>

        </section>

        <section class="section mt80">

            <div class="wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12" style="color:white; margin-top:0px ; margin-bottom:50px;">


                            <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                                <div class="form-group <?php echo (!empty($card_num_err)) ? 'has-error' : ''; ?>">
                                    <label>Card Number</label>
                                    <input type="text" name="card_num" class="form-control" value="<?php echo $card_num; ?>">
                                    <span class="help-block"><?php echo $card_num_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($card_owner_err)) ? 'has-error' : ''; ?>">
                                    <label>Card Owner</label>
                                    <textarea name="card_owner" class="form-control"><?php echo $card_owner; ?></textarea>
                                    <span class="help-block"><?php echo $card_owner_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($card_type_err)) ? 'has-error' : ''; ?>">
                                    <label>Card Type</label>
                                    <input type="text" name="card_type" class="form-control" value="<?php echo $card_type; ?>">
                                    <span class="help-block"><?php echo $card_type_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($card_end_date_err)) ? 'has-error' : ''; ?>">
                                    <label>Card Enddate</label>
                                    <input type="text" name="card_end_date" class="form-control" value="<?php echo $card_end_date; ?>">
                                    <span class="help-block"><?php echo $card_end_date_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($card_cvv_err)) ? 'has-error' : ''; ?>">
                                    <label>Cvv</label>
                                    <input type="number" name="card_cvv" class="form-control" value="<?php echo $card_cvv; ?>">
                                    <span class="help-block"><?php echo $card_cvv_err; ?></span>
                                </div>
                                <input type="hidden" name="oldcardnum" class="btn btn-primary" value="<?= $oldnum ?>">
                                <input type="submit" name="sub" class="btn btn-primary" value="Submit">
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