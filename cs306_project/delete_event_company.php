<?php
// Process delete operation after confirmation
if (isset($_POST["id"]) && !empty($_POST["id"]) && isset($_POST["starttime"]) && !empty($_POST["starttime"])) {
    // Include config file
    require_once "config.php";

    // Prepare a delete statement
    $sql_books = "DELETE FROM BooksTable WHERE BooksTable.ticket_id IN 
    (SELECT ticket_id from TicketTable T WHERE T.timeinfo_starttime =? AND T.event_id=? AND t.ticket_sold=1)";

    $sql_ticket = "DELETE FROM TicketTable  WHERE timeinfo_starttime = ? AND  event_id=?";

    $sql_detailed = "DELETE FROM DetailedinfoTable  WHERE timeinfo_starttime = ? AND  event_id=?";

    $sql_event_table = "SELECT FROM DetailedinfoTable WHERE event_id=?";


    //Delete From Books Table

    if ($stmt_books = mysqli_prepare($link, $sql_books)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt_books, "si", $param_time, $param_id);

        // Set parameters
        $param_id = trim($_POST["id"]);
        $param_time = trim($_POST["starttime"]);
        echo $param_time;
        echo " ";

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt_books)) {
            // Records deleted successfully. Redirect to landing page

        } else {
            echo "Oops! Something went wrong. Please try again later. (BooksTable)";
        }
        mysqli_stmt_close($stmt_books);
    }

    //Delete From Ticket Table

    if ($stmt_ticket = mysqli_prepare($link, $sql_ticket)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt_ticket, "si", $param_time, $param_id);


        // Set parameters
        $param_id = trim($_POST["id"]);
        $param_time = trim($_POST["starttime"]);

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt_ticket)) {
            // Records deleted successfully. Redirect to landing page
            

        } else {
            echo "Oops! Something went wrong. Please try again later.(DetailedTable)";
        }
        mysqli_stmt_close($stmt_ticket);
    }

    //Delete From DetailedinfoTable 

    if ($sql_detailed = mysqli_prepare($link, $sql_detailed)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($sql_detailed, "si", $param_time, $param_id);


        // Set parameters
        $param_id = trim($_POST["id"]);
        $param_time = trim($_POST["starttime"]);
        echo $param_time;
        
        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($sql_detailed)) {
            // Records deleted successfully. Redirect to landing page
            //header ("location:admin.php");
            

        } else {
            echo "Oops! Something went wrong. Please try again later.(EventTable)";
        }
        mysqli_stmt_close($sql_detailed);
    }

    
    $sql_event_table = "SELECT * FROM DetailedinfoTable WHERE event_id= '$param_id'";

    if ($result = mysqli_query($link, $sql_event_table) ) {

        if (mysqli_num_rows($result) == 0) {

            $sql_event_delete = "DELETE FROM EventTable WHERE event_id=?";

            if ($sql_event_delete= mysqli_prepare($link,$sql_event_delete) ) {
                

                mysqli_stmt_bind_param($sql_event_delete,"i",$param_id);

                $param_id = trim($_POST["id"]);

                if (mysqli_stmt_execute($sql_event_delete)) {
                    // Records deleted successfully. Redirect to landing page
                    
                    header ("location:company_page.php");
        
                } else {
                    echo "Oops! Something went wrong. Please try again later.(EventTable)";
                }
                mysqli_stmt_close($sql_event_delete);

            }

            else {
                echo "Noooooo";
            }

        }

        else {
            header("location:company_page.php");
        }

    }


    // Close connection
    mysqli_close($link);
} else {
    // Check existence of id parameter
    if (empty(trim($_GET["id"])) && empty(trim($_GET["timeinfo_starttime"]))) {
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.html");
        exit();
    }
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

                </h1>

        </section>

        <section class="section mt80">

            <div class="wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12" style="color:white">
                            <div class="page-header">
                                <h1>Delete Record</h1>
                            </div>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <div class="alert alert-danger fade in">
                                    <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>" />
                                    <input type="hidden" name="starttime" value="<?php echo trim($_GET["starttime"]); ?>" />
                                    <p>Are you sure you want to delete this record?</p><br>
                                    <p>
                                        <input type="submit" value="Yes" class="btn btn-danger">
                                        <a href="company_page.php" class="btn btn-default">No</a>
                                    </p>
                                </div>
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