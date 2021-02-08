<?php
// Check existence of id parameter before processing further
if (isset($_GET["id"]) && !empty(trim($_GET["id"])) && isset($_GET["starttime"]) && !empty(trim($_GET["starttime"]))) {
    // Include config file
    require_once "config.php";

    // Prepare a select statement
    $sql = "SELECT * FROM EventTable E, DetailedinfoTable D WHERE E.event_id = D.event_id AND D.timeinfo_starttime =? AND D.event_id =?";

    if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "si", $param_start, $param_id);

        // Set parameters
        $param_id = trim($_GET["id"]);
        $param_start = trim($_GET["starttime"]);

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) == 1) {
                /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);


                // Retrieve individual field value
                $name = $row["event_name"];
                $genre = $row["event_genre"];
                $type = $row["event_type"];
                $info = $row["event_info"];
                $location = $row["event_location"];
                $starttime = $param_start;
                $endtime = $row["timeinfo_endtime"];
                $capacity = $row["event_capacity"];
                $sold = $row["event_sold"];
            } else {
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    $sql_price = "SELECT SUM(T.ticket_price) AS ticket_price From TicketTable T WHERE T.event_id=$param_id AND T.timeinfo_starttime= $param_start AND T.ticket_sold=1";

    $sql_statement = "SELECT SUM(T.ticket_price) AS revenue From TicketTable T WHERE T.event_id=$param_id AND T.timeinfo_starttime= '$param_start' AND T.ticket_sold=1";
    $result6 = mysqli_query($link, $sql_statement) or die("Bad query: $sql_statement");
    $revenue = mysqli_fetch_array($result6);
    $revenue_real = $revenue['revenue'];

    // Close statement
    mysqli_stmt_close($stmt);

    // Close connection
    mysqli_close($link);
} else {
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
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
                    <strong> EVENT DETAILS </strong>
                </h1>

        </section>

        <section class="section mt80" style="margin-top: 0; margin-bottom:50px; color:white">

            <div class="wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="page-header">
                                
                            </div>
                            <div class="form-group">
                                <label>Name</label>
                                <p class="form-control-static"><?php echo $name ?></p>
                            </div>
                            <div class="page-header"> </div>
                            <div class="form-group">
                                <label>Genre</label>
                                <p class="form-control-static"><?php echo $genre ?></p>
                            </div>
                            <div class="page-header"> </div>
                            <div class="form-group">
                                <label>Type</label>
                                <p class="form-control-static"><?php echo $type ?></p>
                            </div>
                            <div class="page-header"> </div>
                            <div class="form-group">
                                <label>Info</label>
                                <p class="form-control-static"><?php echo $info ?></p>
                            </div>
                            <div class="page-header"> </div>
                            <div class="form-group">
                                <label>Location</label>
                                <p class="form-control-static"><?php echo $location ?></p>
                            </div>
                            <div class="page-header"> </div>
                            <div class="form-group">
                                <label>Start Time</label>
                                <p class="form-control-static"><?php echo $starttime ?></p>
                            </div>
                            <div class="page-header"> </div>
                            <div class="form-group">
                                <label>End Time</label>
                                <p class="form-control-static"><?php echo $endtime ?></p>
                            </div>
                            <div class="page-header"> </div>
                            <div class="form-group">
                                <label>Sold</label>
                                <p class="form-control-static"><?php echo $sold ?></p>
                            </div>
                            <div class="page-header"> </div>
                            <div class="form-group">
                                <label>Capacity</label>
                                <p class="form-control-static"><?php echo $capacity ?></p>
                            </div>
                            <div class="page-header"> </div>
                            <div class="form-group">
                                <label>Total Revenue</label>
                                <p class="form-control-static"><?php echo $revenue_real ?></p>
                            </div>
                            <p><a href="company_page.php" class="btn btn-primary">Back</a></p>
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