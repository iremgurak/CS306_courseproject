<?php
/*
// Initialize the session
require_once "config.php";
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
$userid = $_SESSION["id"];
$sql_statement = "SELECT * FROM UserTable U WHERE U.user_id = '$userid'" ;
$result= mysqli_query($link,$sql_statement);
$row = mysqli_fetch_assoc($result);
echo"<table>
  <tr>
    <th>Value</th>
    <th>Your Info</th>
  </tr>";
  echo "<tr><td><p style='color:black'>FullName</p></td>";
  echo "<td><p style='color:black'>".$row['user_fullname']."</p></td></tr>";
  echo "<tr><td>Mobile</td>";
  echo "<td>".$row['user_mobile']."</td></tr>";
  echo "<tr><td><p style='color:black'>Address</p></td>";
  echo "<td><p style='color:black'>".$row['user_address']."</p></td></tr>";
  echo "<tr><td>E-Mail</td>";
  echo "<td>".$row['user_mail']."</td></tr>";
  echo "<tr><td><p style='color:black'>Member Point</p></td>";
  echo "<td><p style='color:black'>".$row['member_point']."</p></td></tr>";
  
  echo "<tr><td>Age</td>";
  echo "<td>".$row['user_age']."</td></tr>";
  $sql_statement2 = "SELECT E.event_genre as genre, COUNT(E.event_genre)as times
  FROM BooksTable B, TicketTable T,EventTable E
  WHERE B.user_id= $userid AND T.ticket_id = B.ticket_id AND T.event_id = E.event_id
  ORDER BY times DESC
  LIMIT 1;";
  $result2 = mysqli_query($link,$sql_statement2);
  $rowMost = mysqli_fetch_assoc($result2);
  if($rowMost['times']==0){
    $sql_statement4= "SELECT E.event_genre, COUNT(*)as soldcount
    FROM EventTable E, TicketTable T
    WHERE E.event_id= T.event_id AND T.ticket_sold=1
    GROUP BY E.event_genre
    ORDER BY soldcount DESC 
    LIMIT 1;";
    $result4= mysqli_query($link,$sql_statement4);
    $row4= mysqli_fetch_assoc($result4);
    $genre2 = $row4['event_genre'];
    echo "<tr><td><p style='color:black'>It seems like you haven't been to any events, our mostpopular event genre is <b>".$genre2."</b>.<br>Do you want to see these events with the same genre?</p></td>";
    echo "<td>";
    $sql_statement5 = "SELECT E.event_id, E.event_name
    FROM EventTable E WHERE E.event_genre= '$genre2';";
    $result5= mysqli_query($link,$sql_statement5);
    while($row5= mysqli_fetch_assoc($result5)){
        echo "<p style='color:black'>".$row5['event_name']."<br></p>";
    }
    echo "</td></tr>";
  }
  else{
    $genre = $rowMost['genre'];
    echo "<tr><td><p style='color:black'>It seems like you went mostly to events with genre <b>".$genre."</b>.<br>Have you seen these events with the same genre?</p></td>";
    echo "<td>";
    $sql_statement3 = "SELECT E.event_id, E.event_name
    FROM EventTable E WHERE E.event_genre= '$genre';";
    $result3= mysqli_query($link,$sql_statement3);
    while($row3= mysqli_fetch_assoc($result3)){
        echo "<p style='color:black'>".$row3['event_name']."<br></p>";
    }
    echo "</td></tr>";
  }
  echo "</table>";
  */
?>
<?php
/*
<!DOCTYPE html>
<html lang="en">
<head>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}
td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}
tr:nth-child(odd) { 
  background-color: #051ced;
}
tr:nth-child(even) { 
  background-color: #fca2a2;
}
</style>
  
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link rel="icon" type="image/png" href="https://wimage.exxen.com/content/favicon/favicon-32x32.png" sizes="32x32" />
  <link rel="icon" type="image/png" href="https://wimage.exxen.com/content/favicon/favicon-16x16.png" sizes="16x16" />
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
</body>
</html>
*/
?>
<?php

session_start();

if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)) {

  header("location: main.php");
  exit;
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
  <style type="text/css">
    .wrapper {
      width: 650px;
      margin: 0 auto;
    }

    .page-header h2 {
      margin-top: 0;
    }

    table tr td:last-child a {
      margin-right: 15px;
    }
  </style>
  <script type="text/javascript">
    $(document).ready(function() {
      $('[data-toggle="tooltip"]').tooltip();
    });
  </script>





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

            <a href="main.php" class="link mobile-button">Main Page</a>

          </div>
        </header>

        <h1 class="headline__title">
          <strong> User Profile </strong>
        </h1>

    </section>

    <section class="section mt80">


      <div class="wrapper">

        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <?php /*
                    <div class="page-header clearfix">
                        <h2 class="pull-left" style="color: white;">Event Details</h2>
                        
                        <a href="add_event.php" class="btn btn-primary pull-right">Add New Event</a>
                    </div>
                    */ ?>
              <?php
              // Include config file
              require_once "config.php";
              
              // Attempt select query execution
              $userid = $_SESSION["id"];
              $sql_statement = "SELECT * FROM UserTable U WHERE U.user_id = $userid";
              if ($result = mysqli_query($link, $sql_statement)) {
                echo "<p style='text-align:right'><a href='update_profile.php' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                echo "<a href='delete_user.php?' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a></p>";
                echo "<table class='table table-bordered  '>";
                echo "<thead>";
                echo "<tr class='p-3 mb-2 bg-warning text-dark'>";
                echo "<th>Info</th>";
                echo "<th>Your Value</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                $row = mysqli_fetch_array($result);

                echo "<tr><td><p style='color:white'>FullName</p></td>";
                echo "<td><p style='color:white'>" . $row['user_fullname'] . "</p></td></tr>";

                echo "<tr><td><p style='color:white'>Mobile</p></td>";
                echo "<td><p style='color:white'>" . $row['user_mobile'] . "</p></td></tr>";

                echo "<tr><td><p style='color:white'>Address</p></td>";
                echo "<td><p style='color:white'>" . $row['user_address'] . "</p></td></tr>";

                echo "<tr><td><p style='color:white'>E-Mail</td>";
                echo "<td><p style='color:white'>" . $row['user_mail'] . "</p></td></tr>";

                echo "<tr><td><p style='color:white'>Password</td>";
                echo "<td><p style='color:white'>" . $row['user_password'] . "</p></td></tr>";

                echo "<tr><td><p style='color:white'>Member Point</p></td>";
                echo "<td><p style='color:white'>" . $row['member_point'] . "</p></td></tr>";

                echo "<tr><td><p style='color:white'>Age</p></td>";
                echo "<td><p style='color:white'>" . $row['user_age'] . "</p></td></tr>";

                $sql_statement2 = "SELECT E.event_genre as genre, COUNT(E.event_genre)as times
                      FROM BooksTable B, TicketTable T,EventTable E
                      WHERE B.user_id= $userid AND T.ticket_id = B.ticket_id AND T.event_id = E.event_id
                      ORDER BY times DESC
                      LIMIT 1;";
                $result2 = mysqli_query($link, $sql_statement2);
                $rowMost = mysqli_fetch_assoc($result2);
                if ($rowMost['times'] == 0) {
                  $sql_statement4 = "SELECT E.event_genre, COUNT(*)as soldcount
                        FROM EventTable E, TicketTable T
                        WHERE E.event_id= T.event_id AND T.ticket_sold=1
                        GROUP BY E.event_genre
                        ORDER BY soldcount DESC 
                        LIMIT 1;";
                  $result4 = mysqli_query($link, $sql_statement4);
                  $row4 = mysqli_fetch_assoc($result4);
                  $genre2 = $row4['event_genre'];
                  echo "<tr><td><p style='color:white'>It seems like you haven't been to any events, our mostpopular event genre is <b>" . $genre2 . "</b>.<br>Do you want to see these events with the same genre?</p></td>";
                  echo "<td>";
                  $sql_statement5 = "SELECT E.event_id, E.event_name
                        FROM EventTable E WHERE E.event_genre= '$genre2';";
                  $result5 = mysqli_query($link, $sql_statement5);
                  while ($row5 = mysqli_fetch_assoc($result5)) {
                    echo "<p style='color:white'>" . $row5['event_name'] . "<br></p>";
                  }
                  echo "</td></tr>";
                } else {
                  $genre = $rowMost['genre'];
                  echo "<tr><td><p style='color:white'>It seems like you went mostly to events with genre <b>" . $genre . "</b>.<br>Have you seen these events with the same genre?</p></td>";
                  echo "<td>";
                  $sql_statement3 = "SELECT E.event_id, E.event_name
                        FROM EventTable E WHERE E.event_genre= '$genre';";
                  $result3 = mysqli_query($link, $sql_statement3);
                  while ($row3 = mysqli_fetch_assoc($result3)) {
                    echo "<p style='color:white'>" . $row3['event_name'] . "<br></p>";
                  }
                  echo "</td></tr>";
                }

                echo "</tbody>";
                echo "</table>";
                // Free result set
                mysqli_free_result($result);
                echo "<br><br>";

                $sql_get_cards = "SELECT * FROM CreditCardTable C WHERE C.user_id = $userid";
                $result_get_cards = mysqli_query($link, $sql_get_cards);
                $numrow_card = mysqli_num_rows($result_get_cards);
                if ($numrow_card == 0) {
                  echo "<p style='color:white'>You don't have any registered cards.</p>";
                }
                echo '<a href="add_card.php" class="btn btn-primary pull-right" style="text-align:right">Add New Card</a>';
                if ($numrow_card != 0) {
                  echo "<table class='table table-bordered  '>";
                  echo "<caption style='text-align:center;color:white'><font size='5'>Credit Cards</font></caption>";
                  echo "<thead>";
                  echo "<tr class='p-3 mb-2 bg-warning text-dark'>";
                  echo "<th>Card Number</th>";
                  echo "<th>Card Owner</th>";
                  echo "<th>Card Type</th>";
                  echo "<th>Card Enddate</th>";
                  echo "<th>Card Cvv</th>";
                  echo "<th>Operations</th>";
                  echo "</tr>";
                  echo "</thead>";
                  echo "<tbody>";

                  while ($row_get_cards = mysqli_fetch_assoc($result_get_cards)) {
                    echo "<tr>";
                    echo "<td><p style='color:white'>" . $row_get_cards['creditcard_num'] . "</p></td>";

                    echo "<td><p style='color:white'>" . $row_get_cards['creditcard_fullname'] . "</p></td>";

                    echo "<td><p style='color:white'>" . $row_get_cards['creditcard_type'] . "</p></td>";

                    echo "<td><p style='color:white'>" . $row_get_cards['creditcard_enddate'] . "</p></td>";

                    echo "<td><p style='color:white'>" . $row_get_cards['creditcard_cvv'] . "</p></td>";

                    echo "<td>";
                    echo "<a href='update_card.php?cardnum=" . $row_get_cards['creditcard_num'] . "' title='Update Card' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                    echo "<a href='delete_card.php?cardnum=" . $row_get_cards['creditcard_num'] . "' title='Delete Card' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                    echo "</td>";


                    echo "</tr>";
                  }
                  echo "</tbody>";
                  echo "</table>";
                }
                echo "<br><br>";

                $sql_get_hist = "SELECT E.event_name,D.timeinfo_starttime,D.event_location,T.ticket_seat,T.ticket_price,T.ticket_id FROM BooksTable B,EventTable E, TicketTable T,DetailedinfoTable D
                      WHERE B.user_id=$userid AND T.ticket_id=B.ticket_id AND T.event_id=E.event_id AND D.event_id = T.event_id AND D.timeinfo_starttime =T.timeinfo_starttime;";
                $result_get_hist = mysqli_query($link, $sql_get_hist);
                $numrow_hist = mysqli_num_rows($result_get_hist);
                if ($numrow_hist == 0) {
                  echo "<p style='color:white'>You don't have any purchase.</p>";
                } else {
                  echo "<table class='table table-bordered  '>";
                  echo "<caption style='text-align:center;color:white'><font size='5'>Purchase History</font></caption>";
                  echo "<thead>";
                  echo "<tr class='p-3 mb-2 bg-warning text-dark'>";
                  echo "<th>Event Name</th>";
                  echo "<th>Event Time</th>";
                  echo "<th>Event Place</th>";
                  echo "<th>Ticket Seat</th>";
                  echo "<th>Ticket Price</th>";
                  echo "<th>Ticket ID</th>";
                  echo "</tr>";
                  echo "</thead>";
                  echo "<tbody>";

                  while ($row_get_hist = mysqli_fetch_assoc($result_get_hist)) {
                    echo "<tr>";
                    echo "<td><p style='color:white'>" . $row_get_hist['event_name'] . "</p></td>";

                    echo "<td><p style='color:white'>" . $row_get_hist['timeinfo_starttime'] . "</p></td>";

                    echo "<td><p style='color:white'>" . $row_get_hist['event_location'] . "</p></td>";

                    echo "<td><p style='color:white'>" . $row_get_hist['ticket_seat'] . "</p></td>";

                    echo "<td><p style='color:white'>" . $row_get_hist['ticket_price'] . "</p></td>";

                    echo "<td><p style='color:white'>" . $row_get_hist['ticket_id'] . "</p></td>";
                    echo "</tr>";
                  }
                  echo "</tbody>";
                  echo "</table>";
                }
              } else {
                echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
              }

              // Close connection
              mysqli_close($link);
              ?>
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