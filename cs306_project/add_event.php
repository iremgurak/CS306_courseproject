<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$event_name = $event_id = $event_info = $event_price = $event_genre
    = $event_type = $event_img = $event_info = $event_rating = $event_location =
    $event_capacity = $event_date = $event_starttime = $event_endtime = $company_id = "";

$event_name_err = $event_id_err = $event_info_err =
    $event_price_err = $event_genre_err = $event_type_err
    = $event_img_err = $event_info_err = $event_location_err = $event_date_err = $event_starttime_err = $event_endtime_err = $event_capacity_err = $company_id_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    $input_event_name = trim($_POST["event_name"]);
    if (empty($input_event_name)) {
        $event_name_err = "Please enter a name.";
    } else {
        $event_name = trim($_POST["event_name"]);
    }

    // Validate id
    $event_id_input = trim($_POST["event_id"]);
    if (empty($event_id_input)) {
        $event_id_err = "Please enter an id.";
    } else {
        $event_id = trim($_POST["event_id"]);
    }

    // Validate info
    $event_info_input = trim($_POST["event_info"]);
    if (empty($event_info_input)) {
        $event_info_err = "Please enter the event info.";
    } else {
        $event_info = trim($_POST["event_info"]);
    }

    // Validate price
    $event_price_input = trim($_POST["event_price"]);
    if (empty($event_price_input)) {
        $event_price_err = "Please enter the event price.";
    } elseif (!ctype_digit($event_price_input)) {
        $event_price_err = "Please enter a positive integer value.";
    } else {
        $event_price = trim($_POST["event_price"]);
    }

    // Validate genre
    $event_genre_input = trim($_POST["event_genre"]);
    if (empty($event_genre_input)) {
        $event_genre_err = "Please enter the event genre.";
    } else {
        $event_genre = trim($_POST["event_genre"]);
    }

    // Validate type
    $event_type_input = trim($_POST["event_type"]);
    if (empty($event_type_input)) {
        $event_type_err = "Please enter the event type.";
    } else {
        $event_type = trim($_POST["event_type"]);
    }

    // Validate image
    $event_img_input = trim($_POST["event_img"]);
    if (empty($event_img_input)) {
        $event_img_err = "Please enter the event image.";
    } else {
        $event_img = trim($_POST["event_img"]);
    }

    // Validate info
    $event_info_input = trim($_POST["event_info"]);
    if (empty($event_info_input)) {
        $event_info_err = "Please enter the event info.";
    } else {
        $event_info = trim($_POST["event_info"]);
    }

    // Validate rating
    $event_rating_input = trim($_POST["event_rating"]);
    if (empty($event_rating_input)) {
        $event_rating = null;
    } else {
        $event_rating = trim($_POST["event_rating"]);
    }


    // Validate location
    $event_location_input = trim($_POST["event_location"]);
    if (empty($event_location_input)) {
        $event_location_err = "Please enter the event location.";
    } else {
        $event_location = trim($_POST["event_location"]);
    }

    // Validate capacity
    $event_capacity_input = trim($_POST["event_capacity"]);
    if (empty($event_capacity_input)) {
        $event_capacity_err = "Please enter the event capacity.";
    } else {
        $event_capacity = trim($_POST["event_capacity"]);
    }

    // Validate date
    $event_date_input = trim($_POST["event_date"]);
    if (empty($event_date_input)) {
        $event_date_err = "Please enter the event date.";
    } else {
        $event_date = trim($_POST["event_date"]);
    }

    // Validate starttime
    $event_starttime_input = trim($_POST["event_starttime"]);
    if (empty($event_starttime_input)) {
        $event_starttime_err = "Please enter the event start-time.";
    } else {
        $event_starttime = trim($_POST["event_starttime"]);
    }

    // Validate endtime
    $event_endtime_input = trim($_POST["event_endtime"]);
    if (empty($event_endtime_input)) {
        $event_endtime_err = "Please enter the event end-time.";
    } else {
        $event_endtime = trim($_POST["event_endtime"]);
    }

    // Validate endtime
    $company_id_input = trim($_POST["company_id"]);
    if (empty($company_id_input)) {
        $company_id_err = "Please enter the company ID";
    } else {
        $company_id = trim($_POST["company_id"]);
    }


    // Check input errors before inserting in database
    if (
        empty($event_name_err) && empty($event_id_err) && empty($event_info_err)
        && empty($event_price_err) && empty($event_genre_err) && empty($event_type_err) && empty($event_img_err)
        && empty($event_location_err) && empty($event_capacity_err) && empty($event_date_err) && empty($event_starttime_err) && empty($event_endtime_err) && empty($company_id_err)
    ) {

        // Prepare an insert statement
        echo "check 1";

        $sql_event_check = "SELECT event_id FROM EventTable WHERE event_id = '$event_id'";

        $sql_event = "INSERT INTO EventTable (event_id, event_name, event_genre, event_type, event_info, movie_rating, event_img_url) 
        VALUES (?, ?, ?, ?, ? , ? ,? )";

        $sql_detailed = "INSERT INTO DetailedinfoTable (timeinfo_date, timeinfo_starttime, timeinfo_endtime, event_id, event_sold, event_capacity, event_location) 
        VALUES (?, ?, ?, ?, ? , ? ,? )";

        $sql_company = "INSERT INTO CompanyTable (company_id, event_id) VALUES ($company_id,$event_id) ";

        $sql_adjust = "INSERT INTO AdjustTable (company_id, event_id) VALUES ($company_id,$event_id)";


        if ($result = mysqli_query($link, $sql_event_check)) {
            

            if (mysqli_num_rows($result) == 0) {
               

                if ($stmt_event = mysqli_prepare($link, $sql_event)) {
                    
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt_event, "sssssss", $param_event_id, $param_event_name, $param_event_genre, $param_event_type, $param_event_info, $param_event_rating, $param_event_img);


                    // Set parameters for EventTable
                    $param_event_id     = $event_id;
                    $param_event_name   = $event_name;
                    $param_event_genre  = $event_genre;
                    $param_event_type   = $event_type;
                    $param_event_info   = $event_info;
                    $param_event_rating = $event_rating;
                    $param_event_img    = $event_img;

                    // Attempt to execute the prepared statement
                    if (!mysqli_stmt_execute($stmt_event)) {
                        // Records created successfully. Redirect to landing page
                        echo "Something went wrong (EventTable). Please try again later.";
                    }
                }

                // Close statement
                mysqli_stmt_close($stmt_event);

                if ($stmt_detailed = mysqli_prepare($link, $sql_detailed)) {
                   
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt_detailed, "sssssss", $param_date, $param_start, $param_end, $param_event_id, $param_sold, $param_capacity, $param_location);

                    // Set parameters for DetailedTable
                    $param_date = $event_date;
                    $param_start = $event_starttime;
                    $param_end = $event_endtime;
                    $param_sold = 0;
                    $param_capacity = $event_capacity;
                    $param_location = $event_location;

                    if (!mysqli_stmt_execute($stmt_detailed)) {
                        // Records created successfully. Redirect to landing page
                        echo "Something went wrong (EventTable). Please try again later.";
                    }
                


                    // Attempt to execute the prepared statement

                    for ($i = 1; $i <= $event_capacity; $i++) {
                        $seat = $i . 'A';
                        $sql_statement_ticket_insert = "INSERT INTO TicketTable (ticket_seat,ticket_sold,ticket_price,event_id,timeinfo_starttime)
                                                            VALUES ('$seat',0,$event_price,$event_id,'$param_start')";
                        mysqli_query($link, $sql_statement_ticket_insert);
                    }

                    mysqli_query($link, $sql_company);
                    mysqli_query($link,$sql_adjust);
                    // Records created successfully. Redirect to landing page
                    header("location: admin.php");


                    mysqli_stmt_close($stmt_detailed);
                }

                // Close connection
                mysqli_close($link);
            } 
            
            else {
               

                if ($stmt_detailed = mysqli_prepare($link, $sql_detailed)) {
                   
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt_detailed,"sssssss", $param_date, $param_start, $param_end, $param_event_id, $param_sold, $param_capacity, $param_location);

                    // Set parameters for DetailedTable
                    $param_event_id = $event_id;
                    $param_date = $event_date;
                    $param_start = $event_starttime;
                    $param_end = $event_endtime;
                    $param_sold = 0;
                    $param_capacity = $event_capacity;
                    $param_location = $event_location;
                
                    if (!mysqli_stmt_execute($stmt_detailed)) {
                        // Records created successfully. Redirect to landing page
                        echo "Something went wrong (EventTable9). Please try again later.";
                    }

                    

                
                    // Attempt to execute the prepared statement

                    for ($i = 1; $i <= $event_capacity; $i++) {
                        $seat = $i . 'A';
                        $sql_statement_ticket_insert = "INSERT INTO TicketTable (ticket_seat,ticket_sold,ticket_price,event_id,timeinfo_starttime)
                                                            VALUES ('$seat',0,$event_price,$event_id,'$param_start')";
                        mysqli_query($link, $sql_statement_ticket_insert);
                    }
                    // Records created successfully. Redirect to landing page
                    header("location: admin.php");


                    mysqli_stmt_close($stmt_detailed);
                }

                // Close connection
                mysqli_close($link);
            }
        }
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
                    <strong> Create Record </strong>
                </h1>

        </section>

        <section class="section mt80" style="margin-top: 0; margin-bottom:50px; color:white">

            <div class="wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="page-header">

                            </div>
                            <p>Please fill this form and submit to add new event record to the database.</p>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <div class="form-group <?php echo (!empty($event_id_err)) ? 'has-error' : ''; ?>">
                                    <label>Event ID</label>
                                    <input type="number" name="event_id" class="form-control" value="<?php echo $event_id; ?>">
                                    <span class="help-block"><?php echo $event_id_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($event_name_err)) ? 'has-error' : ''; ?>">
                                    <label>Event Name</label>
                                    <input type="text" name="event_name" class="form-control" value="<?php echo $event_name; ?>">
                                    <span class="help-block"><?php echo $event_name_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($event_info_err)) ? 'has-error' : ''; ?>">
                                    <label>Event Info</label>
                                    <textarea name="event_info" class="form-control"><?php echo $event_info; ?></textarea>
                                    <span class="help-block"><?php echo $event_info_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($event_price_err)) ? 'has-error' : ''; ?>">
                                    <label>Price</label>
                                    <input type="number" name="event_price" class="form-control" value="<?php echo $event_price; ?>">
                                    <span class="help-block"><?php echo $event_price_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($event_genre_err)) ? 'has-error' : ''; ?>">
                                    <label>Genre</label>
                                    <input type="text" name="event_genre" class="form-control" value="<?php echo $event_genre; ?>">
                                    <span class="help-block"><?php echo $event_genre_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($event_type_err)) ? 'has-error' : ''; ?>">
                                    <label>Event Type</label>
                                    <input type="text" name="event_type" class="form-control" value="<?php echo $event_type; ?>">
                                    <span class="help-block"><?php echo $event_type_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($event_img_err)) ? 'has-error' : ''; ?>">
                                    <label>Event Image URL</label>
                                    <input type="text" name="event_img" class="form-control" value="<?php echo $event_img; ?>">
                                    <span class="help-block"><?php echo $event_img_err; ?></span>
                                </div>

                                <div class="form-group <?php echo (!empty($event_location_err)) ? 'has-error' : ''; ?>">
                                    <label>Event Location</label>
                                    <input type="text" name="event_location" class="form-control" value="<?php echo $event_location; ?>">
                                    <span class="help-block"><?php echo $event_location_err; ?></span>
                                </div>
                                <div class="form-group">
                                    <label>Movie Rating</label>
                                    <input type="number" placeholder="Only for movies!" name="event_rating" class="form-control" value="<?php echo $event_rating; ?>">
                                </div>
                                <div class="form-group <?php echo (!empty($event_capacity_err)) ? 'has-error' : ''; ?>">
                                    <label>Event Capacity</label>
                                    <input type="number" name="event_capacity" class="form-control" value="<?php echo $event_capacity; ?>">
                                    <span class="help-block"><?php echo $event_capacity_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($event_date_err)) ? 'has-error' : ''; ?>">
                                    <label>Event Date</label>
                                    <input type="date" name="event_date" class="form-control" value="<?php echo $event_date; ?>">
                                    <span class="help-block"><?php echo $event_date_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($event_starttime_err)) ? 'has-error' : ''; ?>">
                                    <label>Event Start Time</label>
                                    <input type="datetime-local" name="event_starttime" class="form-control" value="<?php echo $event_starttime; ?>">
                                    <span class="help-block"><?php echo $event_starttime_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($event_endtime_err)) ? 'has-error' : ''; ?>">
                                    <label>Event End Time</label>
                                    <input type="datetime-local" name="event_endtime" class="form-control" value="<?php echo $event_endtime; ?>">
                                    <span class="help-block"><?php echo $event_endtime_err; ?></span>
                                </div>
                                <?php
                                require_once "config.php";

                                $sql = "SELECT DISTINCT company_id FROM AdjustTable ORDER BY company_id ASC";

                                if ($stmt = mysqli_prepare($link, $sql)) {

                                    if (mysqli_stmt_execute($stmt)) {
                                        /* store result */
                                        $result_comp = mysqli_stmt_get_result($stmt);
                                    } else {
                                        echo "Oops! Something went wrong. Please try again later.";
                                    }
                                    // Close statement
                                    mysqli_stmt_close($stmt);
                                }

                                ?>
                                <div class="form-group <?php echo (!empty($company_id_err)) ? 'has-error' : ''; ?>" style=" margin-bottom: 20px;">
                                    <label>Company ID</label>
                                    <br>
                                    <select id="company" name="company_id">
                                        <option value="0" selected="selected">Select Company ID</option>
                                        <?php
                                        if (!empty($result_comp)) {
                                            while ($row = mysqli_fetch_array($result_comp)) {
                                                echo '<option value=" ' . $row['company_id'] . ' "> ' . $row['company_id'] . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                    <span class="help-block"><?php echo $company_id_err; ?></span>
                                </div>
                                <input type="submit" class="btn btn-primary" value="Submit">
                                <a href="admin.php" class="btn btn-default">Cancel</a>
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