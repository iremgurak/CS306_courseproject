<?php
// Include config file
require_once "config.php";

session_start();
$ticket_id = $_POST["tickets"];
// Define variables and initialize with empty values
$user_mail = $creditcard_type = $creditcard_fullname = $creditcard_num = $creditcard_enddate = $creditcard_cvv =  "";
$email_err = $type_err = $cname_err = $ccnum_err = $expdate_err = $cvv_err =  "";
$muthis_user="";
if(!(isset($_SESSION["loggedin"]))||((isset($_SESSION["loggedin"])&&($_SESSION["loggedin"] == false)))){
    $_SESSION["ismember"]=false;
}
else{
    $_SESSION["ismember"]=true;
}
// Processing form data when form is submitted
if (isset($_POST["sub"])) {
    // Get hidden input value
    if($_SESSION["ismember"]==true) { $old_member_point = $_POST["old_member_point"]; }

    $event_name = $_POST["event_name"];
    $timeinfo_date = $_POST["timeinfo_date"];
    $event_location = $_POST["event_location"];
    $ticket_price = $_POST["ticket_price"];
    $ticket_seat = $_POST["ticket_seat"];

    // Validate email
    $email_address = trim($_POST["user_mail"]);
    if (empty($email_address)) {
        $email_err = "Please enter e mail address.";
    } else {
        $user_mail = $email_address;
    }

    // Validate cc type
    $cc_type = trim($_POST["creditcard_type"]);
    if (empty($cc_type)) {
        $type_err = "Please enter a credit card type.";
    } else {
        $creditcard_type = $cc_type;
    }

    // Validate cname
    $cc_name = trim($_POST["creditcard_fullname"]);
    if (empty($cc_name)) {
        $cname_err = "Please enter the name on the credit card.";
    } else {
        $creditcard_fullname = $cc_name;
    }
    //validate ccnum
    $cc_num = trim($_POST["creditcard_num"]);
    if (empty($cc_num)) {
        $ccnum_err = "Please enter the credit card number.";
    } else {
        $creditcard_num = $cc_num;
    }

    //validate expiration date
    $expdate = trim($_POST["creditcard_enddate"]);
    if (empty($expdate)) {
        $expdate_err = "Please enter the expiration date.";
    } else {
        $creditcard_enddate = $expdate;
    }
    //validate cvv
    $cvv = trim($_POST["creditcard_cvv"]);
    if (empty($cvv)) {
        $cvv_err = "Please enter the cvv.";
    } else {
        $creditcard_cvv = $cvv;
    }
    // Check input errors before inserting in database
    if (empty($email_err) && empty($type_err) && empty($cname_err) && empty($ccnum_err) && empty($expdate_err) && empty($cvv_err)) {
        // Prepare an insert statement
        $sql2 = "UPDATE TicketTable SET ticket_sold=1 WHERE ticket_id=$ticket_id";
        $result_ticket=mysqli_query($link, $sql2);
        
        $current_time=gmdate("Y-m-d H:i:sa");
    
        $userid = $_SESSION['id'];
        if($_SESSION["ismember"]==false) {
            $sql_adding_user = "INSERT INTO UserTable (user_id, user_mail) VALUES (?, ?)";
            $stmt = mysqli_prepare($link,$sql_adding_user);
            $stmt->bind_param("ss", $userid, $user_mail);
            $stmt->execute();
            //mysqli_query($link, $sql_adding_user);
            //echo $userid;
        }

        $sql = "INSERT INTO BooksTable (books_date, user_id , ticket_id) VALUES (?, ?, ?)";
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_time, $param_user_id, $param_ticketid);

            // Set parameters
            
            $userid = $_SESSION['id'];
            $param_user_id = $userid;
            //echo $param_user_id ;
            $param_time = $current_time;
            $param_ticketid = $ticket_id;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                $sql_get_info ="SELECT D.timeinfo_starttime,D.event_id FROM DetailedinfoTable D, TicketTable T WHERE T.ticket_id=$ticket_id AND D.event_id=T.event_id AND D.timeinfo_starttime= T.timeinfo_starttime";
                $result_to_inc_info = mysqli_query($link,$sql_get_info);
                $row_info_inc = mysqli_fetch_assoc($result_to_inc_info);
                $time_start_to_inc= $row_info_inc["timeinfo_starttime"];
                $eventid_to_inc= $row_info_inc["event_id"];
                
                $sql_inc_artik="UPDATE DetailedinfoTable SET event_sold= event_sold+1 WHERE timeinfo_starttime= '$time_start_to_inc' AND event_id=$eventid_to_inc";
                mysqli_query($link, $sql_inc_artik);
                
                if($_SESSION["ismember"]==true) {
                    if(isset($_SESSION["want_to_use"])){
                            unset($_SESSION['want_to_use']);
                            $sql_shopping_change="SELECT U.member_point FROM UserTable U WHERE U.user_id=$userid";
                            $result_detail_pt_change = mysqli_query($link, $sql_shopping_change);
                            $row_detail_pt_change =mysqli_fetch_assoc($result_detail_pt_change);
                            $your_point_change = $row_detail_pt_change["member_point"];
                            $old = $your_point_change;

                            $sql_ticket_price_change = "SELECT T.ticket_price FROM TicketTable T WHERE T.ticket_id= $ticket_id";
                            $result_ticket_price_change = mysqli_query($link, $sql_ticket_price_change);
                            $row_ticket_price_change =mysqli_fetch_assoc($result_ticket_price_change);
                            $ticket_price_change = $row_ticket_price_change["ticket_price"];


                            if($your_point_change<=$ticket_price_change){
                                $ticket_price_change=$ticket_price_change-$your_point_change;
                                $your_point_change-=$old_member_point;
                            }
                            else{
                            $your_point_change= $your_point_change - $ticket_price_change;
                            }
                                
                            $sql_member_point_change = "UPDATE UserTable SET member_point=$your_point_change WHERE user_id=$userid";
                            mysqli_query($link, $sql_member_point_change); 
                        }
                }
                //increase by 20 percent
                $sql_son= "SELECT T.event_id,T.timeinfo_starttime FROM TicketTable T WHERE T.ticket_id=$ticket_id";
                $result_son= mysqli_query($link,$sql_son);
                $row_son= mysqli_fetch_assoc($result_son);
                $event_id_son = $row_son["event_id"];
                $timeinfo_son = $row_son["timeinfo_starttime"];

                $sql_son2 = "UPDATE TicketTable SET ticket_price=ticket_price*1.20 WHERE event_id=$event_id_son AND ticket_sold=0 AND timeinfo_starttime = '$timeinfo_son'";
                mysqli_query($link,$sql_son2);
                    
                // Records created successfully. Redirect to landing page
                header("location: continue.html");
                //exit();
            }
            else {
                echo "Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}
// Check existence of id parameter before processing further

else {
    if((isset($_SESSION["loggedin"]))&&($_SESSION["loggedin"] == true)){
        $userid = $_SESSION['id'];
        $sql_get_user = "SELECT * FROM UserTable U WHERE U.user_id = $userid";
        $result_user = mysqli_query($link,$sql_get_user);
        $row_user = mysqli_fetch_assoc($result_user);
        $user_mail = $row_user["user_mail"];
    
        $sql_user_card = "SELECT * FROM CreditCardTable WHERE user_id = $userid ";
        $result_user_card = mysqli_query($link, $sql_user_card);
        // Bind variables to the prepared statement as parameters
    
        /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
        $row_user_card = mysqli_fetch_assoc($result_user_card);
    
        // Retrieve individual field value
        $user_id = $row_user_card["user_id"];
        $creditcard_num = $row_user_card["creditcard_num"];
        $creditcard_cvv = $row_user_card["creditcard_cvv"];
        $creditcard_fullname = $row_user_card["creditcard_fullname"];
        $creditcard_type = $row_user_card["creditcard_type"];
        $creditcard_enddate = $row_user_card["creditcard_enddate"];

        $sql_detail = "SELECT E.event_name, D.timeinfo_date ,D.event_location,T.ticket_price,T.ticket_seat
                FROM DetailedinfoTable D, TicketTable T, EventTable E
                WHERE E.event_id = T.event_id AND D.event_id=T.event_id AND T.ticket_id = $ticket_id AND D.timeinfo_starttime = T.timeinfo_starttime ";
        $result_detail = mysqli_query($link, $sql_detail);
        $row_detail =mysqli_fetch_assoc($result_detail);
        // Retrieve individual field value
        $event_name = $row_detail["event_name"];
        $timeinfo_date = $row_detail["timeinfo_date"];
        $event_location = $row_detail["event_location"];
        $ticket_price = $row_detail["ticket_price"];
        $ticket_seat = $row_detail["ticket_seat"];

        $sql_shopping="SELECT U.member_point FROM UserTable U WHERE U.user_id=$user_id";
        $result_detail_pt = mysqli_query($link, $sql_shopping);
        $row_detail_pt =mysqli_fetch_assoc($result_detail_pt);
        $your_point = $row_detail_pt["member_point"];
        $old_member_point=$member_point= $your_point;
    
        if(isset($_POST["use"])){

            if($member_point<=$ticket_price){
            $ticket_price=$ticket_price-$member_point;
            $member_point=0;
            }
            else{
            $member_point= $member_point - $ticket_price;
            $ticket_price=0;
            }
            $_SESSION["want_to_use"]=true;

        }
        else {
            if(isset($_SESSION["plus"])){
                $muthis_user="Your additional 5 points are in your account now!!";;
            }

            else{
                $sqldiscount="SELECT M.ID FROM (SELECT COUNT(B1.ticket_id) AS NUM,B1.user_id AS ID FROM bookstable B1 GROUP by B1.user_id)AS M ORDER BY M.NUM DESC LIMIT 3";
                $result_discount= mysqli_query($link,$sqldiscount);
                $getdiscount=false;
                
                while($row_disc=mysqli_fetch_assoc($result_discount)){
                    if($userid==$row_disc['ID']){
                        $getdiscount=true;
                    }
                }
                if($getdiscount==true){
                    $member_point=$row_detail_pt["member_point"]+5;
                    $muthis_user="You are a gold member,we give you 5 additional points!!";
                    $sql_member_point_change = "UPDATE UserTable SET member_point=$member_point WHERE user_id=$userid";
                    mysqli_query($link, $sql_member_point_change);
                    $_SESSION["plus"]=true;
                }
                else{
                    $member_point=$row_detail_pt["member_point"];
                }
            }

        }
            
        
            
    } else {
        if(isset($_SESSION['id'])) {
            $userid = $_SESSION['id'];
            $sql_detail = "SELECT E.event_name, D.timeinfo_date ,D.event_location,T.ticket_price,T.ticket_seat
                    FROM DetailedinfoTable D, TicketTable T, EventTable E
                    WHERE E.event_id = T.event_id AND D.event_id=T.event_id AND T.ticket_id = $ticket_id AND D.timeinfo_starttime = T.timeinfo_starttime ";
            $result_detail = mysqli_query($link, $sql_detail);
            $row_detail =mysqli_fetch_assoc($result_detail);
            // Retrieve individual field value
            $event_name = $row_detail["event_name"];
            $timeinfo_date = $row_detail["timeinfo_date"];
            $event_location = $row_detail["event_location"];
            $ticket_price = $row_detail["ticket_price"];
            $ticket_seat = $row_detail["ticket_seat"];
    } }
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
                    <strong> BOOK SEATS </strong>
                </h1>

        </section>


        <div class="wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12" style="color:white; margin-top:0px ; margin-bottom:50px;">
                        <h1>Summary</h1>
                        <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                            <p style="color:white;">Event name: <span><?php echo $event_name; ?></span></p>
                            <p style="color:white;">Event location:<span> <?php echo $event_location; ?> </span></p>
                            <p style="color:white;">Event price:<span><?php echo $ticket_price; ?></span></p>
                            <p style="color:white;">Seat number:<span> <?php echo $ticket_seat; ?> </span></p>
                            <p style="color:white;">Event time:<span><?php echo $timeinfo_date; ?> </span></p>
                            <?php
                            if($_SESSION["ismember"]==true) {
                                echo '<p style="color:white;">Your member point:<span> '. $member_point .' </span></p>'; }
                            ?>
                            <p style="color:red;"><?php echo $muthis_user; ?></p>
                            <input type="hidden" name="tickets" value="<?= $ticket_id ?>"/>
                            <input type="hidden" name="event_name" value="<?= $event_name ?>"/>
                            <input type="hidden" name="timeinfo_date" value="<?= $timeinfo_date ?>"/>
                            <input type="hidden" name="event_location" value="<?= $event_location ?>"/>
                            <input type="hidden" name="ticket_price" value="<?= $ticket_price ?>"/>
                            <input type="hidden" name="ticket_seat" value="<?= $ticket_seat ?>"/>
                            <input type="hidden" name="member_point" value="<?= $member_point ?>"/>
                            <input type="hidden" name="old_member_point" value="<?= $old_member_point ?>"/>
                            <?php
                            if($_SESSION["ismember"]==true) {
                                echo '<input type="Submit" name="use" class="btn btn-primary" value="use the points!">'; }
                            ?>
                        </form>
                            <br>
                            <br>
                            <p>Please fill in this form to finialize shopping.</p>
                            <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                                <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                                    <label>E-mail</label>
                                    <input type="text" name="user_mail" class="form-control" value="<?php echo $user_mail; ?>">
                                    <span class="help-block"><?php echo $email_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($cname_err)) ? 'has-error' : ''; ?>">
                                    <label>Full Name on the credit card</label>
                                    <input type="text" name="creditcard_fullname" class="form-control"value="<?php echo $creditcard_fullname; ?>">
                                        <span class="help-block"><?php echo $cname_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($ccnum_err)) ? 'has-error' : ''; ?>">
                                    <label>Credit Card number</label>
                                    <input type="text" name="creditcard_num" class="form-control" value="<?php echo $creditcard_num; ?>">
                                    <span class="help-block"><?php echo $ccnum_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($type_err)) ? 'has-error' : ''; ?>">
                                    <label>Credit Card type</label>
                                    <input type="text" name="creditcard_type" class="form-control" value="<?php echo $creditcard_type; ?>">
                                    <span class="help-block"><?php echo $type_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($expdate_err)) ? 'has-error' : ''; ?>">
                                    <label>Expiration date of the card</label>
                                    <input type="text" name="creditcard_enddate" class="form-control" value="<?php echo $creditcard_enddate; ?>">
                                    <span class="help-block"><?php echo $expdate_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($cvv_err)) ? 'has-error' : ''; ?>">
                                    <label>Cvv</label>
                                    <input type="number" name="creditcard_cvv" class="form-control" value="<?php echo $creditcard_cvv; ?>">
                                    <span class="help-block"><?php echo $cvv_err; ?></span>
                                </div>
                                <input type="hidden" name="tickets" value="<?= $ticket_id ?>"/>
                                <input type="hidden" name="event_name" value="<?= $event_name ?>"/>
                                <input type="hidden" name="timeinfo_date" value="<?= $timeinfo_date ?>"/>
                                <input type="hidden" name="event_location" value="<?= $event_location ?>"/>
                                <input type="hidden" name="ticket_price" value="<?= $ticket_price ?>"/>
                                <input type="hidden" name="ticket_seat" value="<?= $ticket_seat ?>"/>
                                <input type="hidden" name="member_point" value="<?= $member_point ?>"/>
                                <input type="hidden" name="old_member_point" value="<?= $old_member_point ?>"/>
                                <input type="submit" name="sub" class="btn btn-primary" value="Submit">
                                <a href="./main.php" class="btn btn-default">Cancel</a>
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