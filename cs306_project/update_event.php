<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$event_name = $event_id = $event_info = $event_price = $event_genre
    = $event_type = $event_img = $event_info = $event_rating = $event_location =
    $event_capacity = $event_date = $event_starttime = $event_endtime = "";

$event_name_err = $event_id_err = $event_info_err =
    $event_price_err = $event_genre_err = $event_type_err
    = $event_img_err = $event_info_err = $event_location_err = $event_date_err = $event_starttime_err = $event_endtime_err = $event_capacity_err = "";

// Processing form data when form is submitted
if (isset($_POST["id"]) && !empty($_POST["id"]) && isset($_POST["starttime"]) && !empty($_POST["starttime"])) {
    // Get hidden input value
    $id = $_POST["id"];
    $starttime = $_POST["starttime"];

    //mertgokcen: ihtiyac var tutmaya
    $old_start_time=trim($_POST["old_start_time"]);
    
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
        $event_price = $event_price_input;
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

    

    // Check input errors before inserting in database
    if (
        empty($event_name_err) && empty($event_id_err) && empty($event_info_err)
        && empty($event_price_err) && empty($event_genre_err) && empty($event_type_err) && empty($event_img_err)
        && empty($event_location_err) && empty($event_capacity_err) && empty($event_date_err) && empty($event_starttime_err) && empty($event_endtime_err)
    ) {
        // Prepare an update statement
        $sql = "UPDATE EventTable, DetailedinfoTable SET  EventTable.event_name=?, EventTable.event_genre=?, EventTable.event_type=?, EventTable.event_info=?, EventTable.movie_rating=?, EventTable.event_img_url=? WHERE 
        DetailedinfoTable.timeinfo_starttime =? AND  DetailedinfoTable.event_id = EventTable.event_id AND DetailedinfoTable.event_id = ?";

        $sql_detailed = "UPDATE DetailedinfoTable SET  timeinfo_date=?, timeinfo_starttime=?, timeinfo_endtime=?, event_capacity=?, event_location=? WHERE timeinfo_starttime = '$starttime' AND  event_id='$event_id'";

        $sql_adjust = "UPDATE AdjustTable SET company_id =$, event_id = $event_id ";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssssi", $param_event_name, $param_event_genre, $param_event_type, $param_event_info, $param_event_rating, $param_event_img, $param_start, $param_event_id);

            // Set parameters for EventTable
            $param_event_id     = $event_id;
            $param_event_name   = $event_name;
            $param_event_genre  = $event_genre;
            $param_event_type   = $event_type;
            $param_event_info   = $event_info;
            $param_event_rating = $event_rating;
            $param_event_img    = $event_img;
            $param_start        = $starttime;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                //mertgokcen burada artik sadece satilmayan ve o saatteki ticket price degisiyor
                $sql_ticket_update = "UPDATE TicketTable T SET T.ticket_price = $event_price WHERE T.event_id = $param_event_id AND T.ticket_sold=0 AND T.timeinfo_starttime = '$param_start'";
                mysqli_query($link,$sql_ticket_update);
                // Records updated successfully. Redirect to landing page
            } 
            else {
                echo "Something went wrong. Please try again later.";
            }
        
            mysqli_stmt_close($stmt);
        }



        $stmt_detailed = mysqli_prepare($link, $sql_detailed);
        if ($stmt_detailed) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt_detailed, "sssss", $param_date, $param_start, $param_end, $param_capacity, $param_location);

            // Set parameters for DetailedTable
            $param_date = $event_date;
            $param_start = $event_starttime;
            $param_end = $event_endtime;
            $param_capacity = $event_capacity;
            $param_location = $event_location;
            $param_event_id = $event_id;
            
        }
       

       
        

            //mertgokcen burada capacity degisince ticket sayisi degisiyor
            $sql_total_ticket ="SELECT COUNT(*) as count FROM TicketTable T Where T.event_id=$event_id AND T.timeinfo_starttime='$old_start_time'" ;
            $sql_empty_ticket_num = "SELECT COUNT(*) as count FROM TicketTable T Where T.event_id=$event_id AND T.ticket_sold=0 AND T.timeinfo_starttime='$old_start_time'";
            $sql_old_capacity=  "SELECT D.event_capacity FROM DetailedinfoTable D WHERE D.event_id=$event_id AND D.timeinfo_starttime='$old_start_time'";

            $result_total_ticket_num = mysqli_query($link,$sql_total_ticket);
            $result_empty_ticket_num = mysqli_query($link,$sql_empty_ticket_num);
            $result_capacity_old = mysqli_query($link,$sql_old_capacity);

            $row_total_ticket = mysqli_fetch_assoc($result_total_ticket_num);
            $row_empty_ticket = mysqli_fetch_assoc($result_empty_ticket_num);
            $row_old_capacity = mysqli_fetch_assoc($result_capacity_old);

            $count_total_ticket= $row_total_ticket['count'];
            $count_empty_ticket= $row_empty_ticket['count'];
            $old_capacity= $row_old_capacity['event_capacity'];
            /*
            session_start();
            $_SESSION['old']=$old_capacity;
            $_SESSION['new']=$param_capacity;
            header("Location:mert.php");
            */

            $param_capacity = $event_capacity;

            if($old_capacity==$param_capacity){
                //Do nothing
            }
            else if($old_capacity<$param_capacity){
                //add n new tickets $n= $param_capacity-$old_capacity;
                for ($ticketstoadd= $param_capacity-$old_capacity; $ticketstoadd >0; $ticketstoadd--) {
                    $seat = $ticketstoadd . 'B';
                    $sql_statement_ticket_insert = "INSERT INTO TicketTable (ticket_seat,ticket_sold,ticket_price,event_id,timeinfo_starttime)
                                                        VALUES ('$seat',0,$event_price,$event_id,'$param_start')";
                    mysqli_query($link, $sql_statement_ticket_insert);
                }
            }
            else if($old_capacity>$param_capacity){
                //delete n tickets $n=$old_capacity-$param_capacity;
                $n=$old_capacity-$param_capacity;
                /*
                session_start();
                $_SESSION["todelete"]=$n;
                $_SESSION["count_empty_ticket"]=$count_empty_ticket;
                header("Location:mert.php");
                */
                if($n==$count_empty_ticket){
                    //delete all unsold tickets
                    $sql_empty_ticket_delete = "DELETE FROM TicketTable Where event_id=$event_id AND ticket_sold=0 AND timeinfo_starttime='$old_start_time'";
                    mysqli_query($link,$sql_empty_ticket_delete);
                }
                if($n<$count_empty_ticket){
                    //delete n unsold tickets
                    $sql_empty_ticket_delete = "DELETE FROM TicketTable  Where event_id=$event_id AND ticket_sold=0 AND timeinfo_starttime='$old_start_time' LIMIT $n";
                    mysqli_query($link,$sql_empty_ticket_delete);
                }
                /*
                session_start();
                $_SESSION["n"]=$n;
                $_SESSION["count_empty_ticket"]=$sql_empty_ticket_num;
                header("Location:mert.php");
                */
                if($n>$count_empty_ticket){
                    //delete all unsold tickets
                    $sql_empty_ticket_delete = "DELETE FROM TicketTable Where event_id=$event_id AND ticket_sold=0 AND timeinfo_starttime='$old_start_time'";
                    mysqli_query($link,$sql_empty_ticket_delete);
                    // delete m sold tickets $m= $n-$count_empty_ticket;
                    $m= $n-$count_empty_ticket;
                    
                    $sql_first_m_id = "SELECT T.ticket_id FROM TicketTable T WHERE T.event_id=$event_id AND T.ticket_sold=1 LIMIT $m";
                    
                    $result_id_sold_ticket= mysqli_query($link,$sql_first_m_id);
                    $query_ticket_ids = "(";
                    $i=0;
                    while($row_for_query=mysqli_fetch_assoc($result_id_sold_ticket)){
                        if($i!=0){
                            $query_ticket_ids = $query_ticket_ids.",";
                        }
                        $i++;
                        $query_ticket_ids = $query_ticket_ids. $row_for_query['ticket_id'];
                    }
        
                    $query_ticket_ids = $query_ticket_ids.")";
                    $delete_books_sql= "DELETE FROM BooksTable WHERE ticket_id IN $query_ticket_ids";
                    mysqli_query($link,$delete_books_sql);
                    $sql_delete_first_m_id = "DELETE FROM TicketTable  WHERE event_id=$event_id AND ticket_sold=1 LIMIT $m";
                    mysqli_query($link,$sql_delete_first_m_id);

                    //decrease detailedinfo event_sold by $m;
                }
            }
            //mertgokcen end

           
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt_detailed)) {
                // Records created successfully. Redirect to landing page
                
                header("location: admin.php");
            } else {
                echo "Something went wrong (DetailedEventTable). Please try again later.";
            }

            mysqli_stmt_close($stmt_detailed);


        // Close connection
        mysqli_close($link);
    }
} else {
    // Check existence of id parameter before processing further
    if (isset($_GET["id"]) && !empty(trim($_GET["id"])) && isset($_GET["starttime"]) && !empty(trim($_GET["starttime"]))) {
        // Get URL parameter
        $id =  trim($_GET["id"]);
        $starttime =  trim($_GET["starttime"]);

        //mertgokcen: ihtiyac var tutmaya
        $old_start_time=trim($_GET["starttime"]);

        // Prepare a select statement
        $sql_select = "SELECT EventTable.event_id,event_name,event_genre,event_type,event_info,movie_rating,event_img_url FROM EventTable, DetailedinfoTable  
        WHERE  timeinfo_starttime = ?  AND DetailedinfoTable.event_id = EventTable.event_id AND DetailedinfoTable.event_id=?";
        $sql_detailed_select = "SELECT timeinfo_date,timeinfo_starttime,timeinfo_endtime,event_sold,event_capacity,event_location FROM DetailedinfoTable WHERE timeinfo_starttime=? AND event_id = ?";

        if ($stmt = mysqli_prepare($link, $sql_select)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_start, $param_id);

            // Set parameters
            $param_id = $id;
            $param_start = $starttime;
            

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) == 1) {
                    /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    // Retrieve individual field value
                    $event_id = $row["event_id"];
                    $event_name = $row["event_name"];
                    $event_info = $row["event_info"];
                    $event_genre = $row["event_genre"];
                    $event_type = $row["event_type"];
                    $event_img = $row["event_img_url"];
                    //mertgokcen En pahali ticket price gosteriliyor
                    $sql_get_price = "SELECT T.ticket_price FROM TicketTable T WHERE T.event_id = $event_id ORDER BY T.ticket_price DESC";
                    $result = mysqli_query($link,$sql_get_price);
                    $row_price = mysqli_fetch_assoc($result);
                    $event_price = $row_price["ticket_price"];
                    
                } else {
                    // URL doesn't contain valid id. Redirect to error page
                    ("location: error.php");
                    exit();
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            // Close statement
            mysqli_stmt_close($stmt);
        }



        if ($sql_detailed_select = mysqli_prepare($link, $sql_detailed_select)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($sql_detailed_select, "si", $param_start, $param_id);

            // Set parameters
            $param_id = $id;
            $param_start = $starttime;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($sql_detailed_select)) {
                $result = mysqli_stmt_get_result($sql_detailed_select);

                if (mysqli_num_rows($result) == 1) {
                    /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    // Retrieve individual field value
                    $event_location = $row["event_location"];
                    $event_capacity = $row["event_capacity"];
                    $event_date = $row["timeinfo_date"];
                    $event_starttime = $row["timeinfo_starttime"];
                    $event_endtime = $row["timeinfo_endtime"];

                } else {
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            // Close statement
            mysqli_stmt_close($sql_detailed_select);
        }

        // Close connection
        mysqli_close($link);
    } else {
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
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
                    <strong> UPDATE RECORD </strong>
                </h1>

        </section>

        <section class="section mt80">

            <div class="wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12" style="color:white; margin-top:0px ; margin-bottom:50px;">
                            <div class="page-header">

                            </div>
                            <p>Please edit the input values and submit to update the record.</p>
                            <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
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
                                    <label>Event Price</label>
                                    <input type="number" name="event_price" class="form-control" value="<?php echo $event_price; ?>">
                                    <span class="help-block"><?php echo $event_price_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($event_genre_err)) ? 'has-error' : ''; ?>">
                                    <label>Event Genre</label>
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
                                    <input type="text" name="event_starttime" class="form-control" value="<?php echo $event_starttime; ?>">
                                    <span class="help-block"><?php echo $event_starttime_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($event_endtime_err)) ? 'has-error' : ''; ?>">
                                    <label>Event End Time</label>
                                    <input type="text" name="event_endtime" class="form-control" value="<?php echo $event_endtime; ?>">
                                    <span class="help-block"><?php echo $event_endtime_err; ?></span>
                                </div>
                                <input type="hidden" name="id" value="<?php echo $id; ?>" />
                                <input type="hidden" name="starttime" value="<?php echo $starttime; ?>" />
                                <input type="hidden" name="old_start_time" value="<?php echo $old_start_time; ?>" />
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