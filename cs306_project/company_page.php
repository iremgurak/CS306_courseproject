<?php

session_start();

if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["type"] === "company")) {

  header("location: main.php");
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
            <?php
            if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
              echo '<a href="logout.php" class="link mobile-button">Sign Out</a>';
            }
            ?>

          </div>

        </header>

        <h1 class="headline__title">
          <strong> COMPANY PANEL </strong>
        </h1>

    </section>

    <section class="section mt80">


      <div class="wrapper">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="page-header clearfix">
                <h2 class="pull-left" style="color: white;">Event Details</h2>

                <a href="add_event_company.php" class="btn btn-primary pull-right">Add New Event</a>
              </div>

              <div>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                  <input type="text" name="search_bar" style=" margin-bottom: 10px; height: 29px; width: 504px; margin-left: 70px; margin-right: 70px;" placeholder=" Search by name">
                  <br>
                </form>
              </div>
              <?php
              // Include config file
              require_once "config.php";

              // Attempt select query execution
              $compid = $_SESSION["id"];
              //$sql_compay= "SELECT A.event_id FROM AdjustTable A WHERE A.company_id = $compid";
            
              // Attempt select query execution
              $sql = "SELECT E.event_name, E.event_id, D.timeinfo_date, D.timeinfo_starttime 
              FROM EventTable E, DetailedinfoTable D WHERE E.event_id = D.event_id AND E.event_id IN (
                                      SELECT A.event_id FROM AdjustTable A WHERE A.company_id = $compid)";


              if (isset($_POST['search_bar'])) {

                $param_search = $_POST['search_bar'];

                $sql_search = "SELECT E.event_name, E.event_id, D.timeinfo_date, D.timeinfo_starttime 
                  FROM EventTable E, DetailedinfoTable D,AdjustTable A WHERE E.event_name LIKE '%$param_search%' AND D.event_id=E.event_id AND A.event_id = E.event_id AND A.company_id = $compid ";

                $result2 = mysqli_query($link, $sql_search);
                if (mysqli_num_rows($result2) > 0) {
                  echo "<table class='table table-bordered  table-hover'>";
                  echo "<thead>";
                  echo "<tr class='p-3 mb-2 bg-warning text-dark'>";
                  echo "<th>Event ID</th>";
                  echo "<th>Event Name</th>";
                  echo "<th>Event Date</th>";
                  echo "<th>Event Start Time</th>";
                  echo "<th>Operations</th>";
                  echo "</tr>";
                  echo "</thead>";
                  echo "<tbody>";
                  while ($row2 = mysqli_fetch_array($result2)) {
                    echo "<tr class='p-3 mb-2 bg-warning text-dark'>";
                    echo "<td>" . $row2['event_id'] . "</td>";
                    echo "<td>" . $row2['event_name'] . "</td>";
                    echo "<td>" . $row2['timeinfo_date'] . "</td>";
                    echo "<td>" . $row2['timeinfo_starttime'] . "</td>";
                    echo "<td>";
                    echo "<a href='read_event_company.php?id="   . $row2['event_id'] . "&starttime=" . $row2['timeinfo_starttime'] . "' title='View Detailed Info' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                    echo "<a href='update_event.php?id=" . $row2['event_id'] . "&starttime=" . $row2['timeinfo_starttime'] . "' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                    echo "<a href='delete_event_company.php?id=" . $row2['event_id'] . "&starttime=" . $row2['timeinfo_starttime'] . "' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                    echo "</td>";
                    echo "</tr>";
                  }
                  echo "</tbody>";
                  echo "</table>";
                  // Free result set
                  mysqli_free_result($result2);
                } else {
                  echo "<p class='lead'><em>No records were found.</em></p>";
                }
              } 
              
              else {




                if ($result = mysqli_query($link, $sql)) {
                  if (mysqli_num_rows($result) > 0) {
                    echo "<table class='table table-bordered  table-hover'>";
                    echo "<thead>";
                    echo "<tr class='p-3 mb-2 bg-warning text-dark'>";
                    echo "<th>Event ID</th>";
                    echo "<th>Event Name</th>";
                    echo "<th>Event Date</th>";
                    echo "<th>Event Start Time</th>";
                    echo "<th>Operations</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    while ($row = mysqli_fetch_array($result)) {
                      echo "<tr class='p-3 mb-2 bg-warning text-dark'>";
                      echo "<td>" . $row['event_id'] . "</td>";
                      echo "<td>" . $row['event_name'] . "</td>";
                      echo "<td>" . $row['timeinfo_date'] . "</td>";
                      echo "<td>" . $row['timeinfo_starttime'] . "</td>";
                      echo "<td>";
                      echo "<a href='read_event_company.php?id="   . $row['event_id'] . "&starttime=" . $row['timeinfo_starttime'] . "' title='View Detailed Info' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                      echo "<a href='update_event_company.php?id=" . $row['event_id'] . "&starttime=" . $row['timeinfo_starttime'] . "' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                      echo "<a href='delete_event_company.php?id=" . $row['event_id'] . "&starttime=" . $row['timeinfo_starttime'] . "' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                      echo "</td>";
                      echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                    // Free result set
                    mysqli_free_result($result);
                  } else {
                    echo "<p class='lead'><em>No records were found.</em></p>";
                  }
                } else {
                  echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                }
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