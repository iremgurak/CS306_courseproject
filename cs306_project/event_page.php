<?php

session_start();

if (isset($_GET['ID'])) {
    require_once "config.php";
    $ID = mysqli_real_escape_string($link, $_GET['ID']);
    $sql = "SELECT * FROM eventtable E WHERE E.event_id='$ID' ";
    $result = mysqli_query($link, $sql) or die("Bad query: $sql");
    $row = mysqli_fetch_array($result);


    $sql2 = "SELECT DISTINCT C.company_name FROM adjusttable A, companytable C WHERE A.event_id='$ID' AND C.company_id = A.company_id ";
    $result2 = mysqli_query($link, $sql2) or die("Bad query: $sql2");


    $sql3 = "SELECT * FROM detailedinfotable D WHERE D.event_id='$ID' ";
    $result3 = mysqli_query($link, $sql3) or die("Bad query: $sql3");


    $sql4 = "SELECT * FROM tickettable T WHERE T.event_id='$ID' ";
    $result4 = mysqli_query($link, $sql4) or die("Bad query: $sql4");

    //$sql6 = "SELECT * FROM detailedinfotable D WHERE D.event_id='$ID' ";
    //$result6 = mysqli_query($link, $sql6) or die("Bad query: $sql6");

}


?>


<!DOCTYPE html>
<html lang="tr">

<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="icon" type="image/png" href="https://www.sabanciuniv.edu/sites/default/files/logo_sabancicmyk.jpg" sizes="32x32" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <meta name="theme-color" content="#111111" />

    <link rel="manifest" href="/manifest.json">
    <link href="https://wasset.exxen.com/content/css/critic2.min.css?v=15" rel="stylesheet" />
    <title> TicketSU </title>

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
        var UserMobile = null;
        var ln = "tr";
    </script>


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
                    <div class="actions">
                        <?php
                        
                        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
                            echo '<a href="profile.php" class="link mobile-button">My Profile </a>';
                            echo '<br>';
                            echo '<a href="logout.php" class="link mobile-button">Sign Out</a>';
                        } else {
                            $sql_statement = "SELECT MAX(U.user_id) AS user_id FROM UserTable U";
                            $result6 = mysqli_query($link, $sql_statement) or die("Bad query: $sql_statement");
                            $row_id = mysqli_fetch_array($result6);
                            $my_session_id = $row_id['user_id'] + 1;
                            $_SESSION['id'] = $my_session_id;
                        }

                        ?>
                    </div>
                </header>

                <h1 class="headline__title">
                    <strong> DETAILS </strong>
                </h1>

        </section>

        <section id="event" class="py-3">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <img src=<?php echo $row['event_img_url'] ?> alt="Picture" style="width: 350px;height: 500px;" class="img-fluid" />
                    </div>
                    <div class="col-sm-6">
                        <h3 class="font-baloo"> <?php echo $row['event_name'] ?></h3>
                        <?php
                        require_once "config.php";
                        while ($row2 = mysqli_fetch_array($result2)) {
                            echo ' <small> ' . $row2['company_name'] . ' </small>';
                        }
                        ?>
                        <?php
                        require_once "config.php";
                        while ($row3 = mysqli_fetch_array($result3)) {
                            echo '
                  <div id="datetime">
                    <div class="d-flex">
                          <h5 class="font-baloo">TIME: &nbsp;  ' . $row3['timeinfo_starttime'] . ' </h5> 
                          <h5 class="font-baloo">DATE: &nbsp;  ' . $row3['timeinfo_date'] . ' </h5>
                          <h5 class="font-baloo">PLACE: &nbsp;  ' . $row3['event_location'] . ' </h5>
                          
                          
                    </div>
                  </div> ';
                            if ($row3['event_sold'] == $row3['event_capacity']) {
                                echo '
                                <h5 class="font-baloo" style= "color:red;" >SOLD OUT!!!</h5> ';
                            } else if (abs($row3['event_capacity'] - $row3['event_sold']) <= 3) {
                                echo '
                                <h5 class="font-baloo" style= "color:red;" >HOT TICKET!!!</h5> ';
                            }
                            echo '<br><br>';
                        }
                        ?>
                        <div id="info">
                            <div class="d-flex">
                                <h6 class="font-baloo"> <?php echo  $row['event_info'] ?> </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="container" style="margin-bottom: 19px;">
            <div class="row">
                <div class="col">
                    <h5>AVAILABLE TICKETS</h5>
                    <form action="./payment_info.php" method="post">
                        <label for="tickets">Choose a ticket:</label>
                        <select id="tickets" name="tickets">
                            <?php
                            $isSold = TRUE;
                            require_once "config.php";
                            while ($row4 = mysqli_fetch_array($result4)) {
                                if ($row4['ticket_sold'] == 0) {
                                    $isSold = FALSE;
                                    $sql5 = "SELECT D.event_location FROM detailedinfotable D, tickettable T WHERE $row4[ticket_id] = T.ticket_id AND T.event_id = D.event_id AND T.timeinfo_starttime = D.timeinfo_starttime ";
                                    $result5 = mysqli_query($link, $sql5) or die("Bad query: $sql5");
                                    $row5 = mysqli_fetch_array($result5);
                                    echo ' <option value=" ' . $row4['ticket_id'] . ' " > ' . $row4['timeinfo_starttime'] . ' &nbsp; ' . $row4['ticket_seat'] . ' &nbsp; ' . $row4['ticket_price'] . ' TL' . ' &nbsp; ' . $row5['event_location'] . ' </option>';
                                    // $sql5 = "SELECT D.event_location FROM detailedinfotable D, tickettable T WHERE $row4[ticket_id] = T.ticket_id AND T.event_id = D.event_id AND T.timeinfo_starttime = D.timeinfo_starttime ";
                                    // $result5 = mysqli_query($link, $sql5) or die("Bad query: $sql5");
                                    // $row5 =mysqli_fetch_array($result5);
                                    // echo ' <option value=" ' . $row4['ticket_id']. ' " > '.$row4['timeinfo_starttime'] . ' &nbsp; ' . $row4['ticket_seat'] . ' &nbsp; ' . $row4['ticket_price'] .' TL'. ' &nbsp; ' . $row5['event_location'] . ' </option>';
                                }
                            }
                            ?>
                        </select>
                        <?php
                        require_once "config.php";
                        if ($isSold == TRUE) {
                            echo '
                                <h5 class="font-baloo" style= "color:red;" >NO TICKETS AVAILABLE!</h5> ';
                        } else {
                            echo '
                                <button type="submit" class="btn btn-danger form-control" formmethod="post">Proceed to buy</button> ';
                        }

                        ?>


                    </form>
                </div>
            </div>
        </div>

        <section>

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