<?php

// Initialize the session


// Check if the user is already logged in, if yes then redirect him to welcome page



?>


<!DOCTYPE html>
<html lang="tr">

<head>

  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link rel="icon" type="image/png" href="https://www.sabanciuniv.edu/sites/default/files/logo_sabancicmyk.jpg" sizes="32x32" />


  <meta name="theme-color" content="#111111" />

  <link rel="manifest" href="/manifest.json">
  <link href="https://wasset.exxen.com/content/css/critic2.min.css?v=15" rel="stylesheet" />
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
  <title> TicketSU </title>




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
            session_start();
            if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
              echo '<a href="profile.php" class="link mobile-button">My Profile </a><i class="material-icons" style="color:black">person</i>';
              echo '<br>';
              echo '<a href="logout.php" class="link mobile-button">Sign Out</a>';
            } else {
              echo '<a href="./login.php" class="link mobile-button" style="padding-right: 10px;"> Login |</a>';
              echo '<a href="./signup.php" class="link mobile-button">Sign Up</a>';
            }

            ?>

          </div>
        </header>
        <h1 class="headline__title">
          <strong> HOT-TICKETS</strong>
        </h1>
        <div class="headline__slider">
          <!-- Slider main container -->
          <div class="swiper-container" style="height:450px">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
              <!-- Slides -->
              <?php
              require_once "config.php";
              $sql = "SELECT event_img_url,event_id FROM EventTable";

              if ($stmt = mysqli_prepare($link, $sql)) {
                // Bind variables to the prepared statement as parameters
                //mysqli_stmt_bind_param($stmt, "s", $param_search);

                // Set parameters
                //$param_search = trim($_POST["search_bar"]);

                // Attempt to execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                  /* store result */
                  $result = mysqli_stmt_get_result($stmt);
                  while ($row = mysqli_fetch_array($result)) {
                    $event_id = $row['event_id'];
                    echo '
                        <div class="swiper-slide"> 
                        <a href="./event_page.php?ID=' . $event_id . '"> 
                            <img src=' . $row['event_img_url'] . ' / style="height:400px; width:270px">      
                        </a>
                      </div>';
                  }
                } else {
                  echo "Oops! Something went wrong. Please try again later.";
                }

                // Close statement
                mysqli_stmt_close($stmt);
              }
              ?>
            </div>
          </div>
        </div>
        <!-- If we need navigation buttons -->
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
        <script>
          var mySwiper = new Swiper(".swiper-container", {
            // Optional parameters

            loop: true,
            autoplay: {
              delay: 3000,
            },
            spaceBetween: 30,

            // Navigation arrows
            navigation: {
              nextEl: ".swiper-button-next",
              prevEl: ".swiper-button-prev",
            },
            slidesPerView: 1,
            breakpoints: {
              320: {
                slidesPerView: 2.5,
                spaceBetween: 20,
              },
              480: {
                slidesPerView: 2.5,
                spaceBetween: 30
              },
              1024: {
                slidesPerView: 5,
              },
            },
          });
        </script>
      </div>
  </div>
  </section>

  <section class="section mt80"  style="margin-bottom:100px">
    <div class="content-section content-section--big-padding" >
      <h2 class="content-section__title">
        THE BEST EVENTS IN THE TICKET-SU
      </h2>
      <p class="content-section__desc">
        Discover the best events in the world!
      </p>
      <section class="section">
        <div class="video-section">

          <div class="video-section__player">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
              <h2 class="content-section__title">SEARCH</h2>
              <input type="text" name="search_bar" style="width:504px" placeholder="Search an event by type">
              <button type="submit"><i class="fa fa-search"></i></button>
            </form>
            <?php
            require_once "config.php";

            $sql = "SELECT DISTINCT event_location FROM DetailedinfoTable ORDER BY event_location ASC";

            if ($stmt = mysqli_prepare($link, $sql)) {

              if (mysqli_stmt_execute($stmt)) {
                /* store result */
                $result_loc = mysqli_stmt_get_result($stmt);
              } else {
                echo "Oops! Something went wrong. Please try again later.";
              }
              // Close statement
              mysqli_stmt_close($stmt);
            }
            $sql2 = "SELECT DISTINCT ticket_price FROM TicketTable ORDER BY ticket_price ASC";

            if ($stmt2 = mysqli_prepare($link, $sql2)) {

              if (mysqli_stmt_execute($stmt2)) {
                /* store result */
                $result_loc2 = mysqli_stmt_get_result($stmt2);
              } else {
                echo "Oops! Something went wrong. Please try again later.";
              }
              // Close statement
              mysqli_stmt_close($stmt2);
            }

            ?>
            <div class="search-box" style="margin-right: auto; margin-left: auto;width:504px">
              <form id="loc1" name="loc_form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                <select id="Place" name="location" style="width: max-auto; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                  <option value="0" selected="selected">Select Location</option>
                  <?php
                  if (!empty($result_loc)) {
                    while ($row = mysqli_fetch_array($result_loc)) {
                      echo '<option value=" ' . $row['event_location'] . ' "> ' . $row['event_location'] . '</option>';
                    }
                  }
                  ?>
                </select>
                <input type="submit" name="Submit" value="Select" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;"/>
            </div>
            </form>

            <form id="loc1" name="loc_form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
              <div class="search-box" style="margin-right: auto; margin-left: auto; width:auto;">
                <select id="Price" name="price" style="width:208px; height:22px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                  <option value="0" selected="selected">Select Price</option>
                  <?php
                  if (!empty($result_loc2)) {
                    while ($row = mysqli_fetch_array($result_loc2)) {
                      echo '<option value=" ' . $row['ticket_price'] . ' "> ' . $row['ticket_price'] . '</option>';
                    }
                  }
                  ?>
                </select>
                <input type="submit" name="Submit" value="Select" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;"/>
            </form>
            <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
              <input type="submit" name="desc" class="btn btn-primary" value="Price descending order" style="width:504px; margin-left: auto; margin-right: auto;font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
              <input type="submit" name="asc" class="btn btn-primary" value="Price ascending order" style="width:504px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
            </form>
          </div>
        </div>
      </section>


      <div class="content-section__images">

        <?php

        require_once "config.php";

        $search_query = "";
        $search_query_err = "";
        $img = "";
        $event_id = "";


        if ($_SERVER["REQUEST_METHOD"] == "POST") {

          if (!empty($_POST["location"]) & empty($_POST["search_bar"]) && empty($_POST["price"]) && !isset($_POST["asc"]) && !isset($_POST["desc"])) {

            $sql = "SELECT DISTINCT E.event_img_url,E.event_id From EventTable E, DetailedinfoTable D Where E.event_id = D.event_id and D.event_location=?";

            if ($stmt = mysqli_prepare($link, $sql)) {
              // Bind variables to the prepared statement as parameters
              mysqli_stmt_bind_param($stmt, "s", $param_loc);

              // Set parameters
              $param_loc = trim($_POST["location"]);

              // Attempt to execute the prepared statement
              if (mysqli_stmt_execute($stmt)) {
                /* store result */

                $result = mysqli_stmt_get_result($stmt);
                $count = mysqli_num_rows($result);

                if ($count == 0) {
                  echo '<p class="content-section__desc">
                No results!
                  </p>';
                } else {

                  while ($row = mysqli_fetch_array($result)) {
                    //echo $count;
                    $event_id = $row['event_id'];
                    echo '
                      <a href="./event_page.php?ID=' . $event_id . '"> 
                          <img src=' . $row['event_img_url'] . ' / style="height:400px;width:270px;margin-right:10px;margin-left:10px;margin-bottom: 20px;"">      
                      </a>';
                  }
                }
              } else {
                echo "Oops! Something went wrong. Please try again later.";
              }

              // Close statement
              mysqli_stmt_close($stmt);
            }
          }
          if (empty($_POST["location"]) & empty($_POST["search_bar"]) & !empty($_POST["price"]) && !isset($_POST["asc"]) && !isset($_POST["desc"])) {

            $sql_price = "SELECT DISTINCT E.event_img_url,T.event_id From EventTable E, DetailedinfoTable D, TicketTable T Where E.event_id = D.event_id and T.event_id=D.event_id and T.ticket_price=?";

            if ($stmt_price = mysqli_prepare($link, $sql_price)) {
              // Bind variables to the prepared statement as parameters
              mysqli_stmt_bind_param($stmt_price, "s", $param_price);

              // Set parameters
              $param_price = trim($_POST["price"]);

              // Attempt to execute the prepared statement
              if (mysqli_stmt_execute($stmt_price)) {
                /* store result */

                $result_price = mysqli_stmt_get_result($stmt_price);
                $count_price = mysqli_num_rows($result_price);

                if ($count_price == 0) {
                  echo '<p class="content-section__desc">
                No results!
                  </p>';
                } else {
                  while ($row_price = mysqli_fetch_array($result_price)) {
                    //echo $count_price ;
                    $event_id = $row_price['event_id'];
                    //echo $event_id;
                    echo '
                      <a href="./event_page.php?ID=' . $event_id . '"> 
                          <img src=' . $row_price['event_img_url'] . ' / style="height:400px; width:270px; margin-right:10px; margin-left:10px">      
                      </a>';
                  }
                }
              } else {
                echo "Oops! Something went wrong. Please try again later.";
              }

              // Close statement
              mysqli_stmt_close($stmt_price);
            }
          }
          if (!isset($_POST['search_bar']) && !isset($_POST['location']) && !isset($_POST['price']) && !isset($_POST["asc"]) && !isset($_POST["desc"])) {
            echo '<p class="content-section__desc">
           Please enter a search-word!
         </p>';
          } else if (!isset($_POST["asc"]) && isset($_POST["desc"])) {
            $sql_descending = "SELECT DISTINCT E.event_id, T.ticket_price,E.event_name,D.event_location,D.timeinfo_starttime FROM EventTable E, tickettable T, detailedinfotable D 
            WHERE T.event_id= E.event_id and D.event_id=T.event_id AND D.timeinfo_starttime=T.timeinfo_starttime ORDER BY T.ticket_price DESC";
            if ($result_desc = mysqli_query($link, $sql_descending)) {
              if (mysqli_num_rows($result_desc) > 0) {
                echo "<table class='table table-bordered  table-hover'>";
                echo "<thead>";
                echo "<tr class='p-3 mb-2 bg-warning text-dark'>";

                echo "<th>Event Name</th>";
                echo "<th>Ticket Price</th>";
                echo "<th>Event Start Time</th>";
                echo "<th>Location</th>";
                //echo "<th>Go to page!</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                while ($row_Desc = mysqli_fetch_array($result_desc)) {
                  $event_id=$row_Desc['event_id'] ;
                  echo "<tr class='p-3 mb-2 bg-warning text-dark'>";
                  echo '<td> <a href="./event_page.php?ID=' .$event_id.' ">  '. $row_Desc['event_name'] . ' </a> </td>';
                  echo "<td>" . $row_Desc['ticket_price'] . "</td>";
                  echo "<td>" . $row_Desc['timeinfo_starttime'] . "</td>";
                  echo "<td>" . $row_Desc['event_location'] . "</td>";

                  echo "<td>";
                  echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
                // Free result set
                mysqli_free_result($result_desc);
              } else {
                echo "<p class='lead'><em>No records were found.</em></p>";
              }
            }
          } else if (isset($_POST["asc"]) && !isset($_POST["desc"])) {
            $sql_ascending = "SELECT DISTINCT E.event_id, T.ticket_price,E.event_name,D.event_location,D.timeinfo_starttime FROM EventTable E, tickettable T, detailedinfotable D 
            WHERE T.event_id= E.event_id and D.event_id=T.event_id AND D.timeinfo_starttime=T.timeinfo_starttime ORDER BY T.ticket_price ASC";
            if ($result_asc = mysqli_query($link, $sql_ascending)) {
              if (mysqli_num_rows($result_asc) > 0) {
                echo "<table class='table table-bordered  table-hover'>";
                echo "<thead>";
                echo "<tr class='p-3 mb-2 bg-warning text-dark'>";

                echo "<th>Event Name</th>";
                echo "<th>Ticket Price</th>";
                echo "<th>Event Start Time</th>";
                echo "<th>Location</th>";

                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                while ($row_asc = mysqli_fetch_array($result_asc)) {
                  echo "<tr class='p-3 mb-2 bg-warning text-dark'>";

                  $event_id = $row_asc['event_id'];

                  echo '<td> <a href="./event_page.php?ID=' . $event_id . ' ">  ' . $row_asc['event_name'] . ' </a> </td>';
                  echo "<td>" . $row_asc['ticket_price'] . "</td>";
                  echo "<td>" . $row_asc['timeinfo_starttime'] . "</td>";
                  echo "<td>" . $row_asc['event_location'] . "</td>";
                  echo "<td>";
                  echo "<td>";
                  echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
                // Free result set
                mysqli_free_result($result_asc);
              } else {
                echo "<p class='lead'><em>No records were found.</em></p>";
              }
            }
          } else if (isset($_POST['search_bar'])) {
            $sql = "SELECT event_img_url,event_id FROM EventTable WHERE event_type = ?";

            if ($stmt = mysqli_prepare($link, $sql)) {
              // Bind variables to the prepared statement as parameters
              mysqli_stmt_bind_param($stmt, "s", $param_search);

              // Set parameters
              $param_search = trim($_POST["search_bar"]);

              // Attempt to execute the prepared statement
              if (mysqli_stmt_execute($stmt)) {
                /* store result */

                $result = mysqli_stmt_get_result($stmt);
                $count = mysqli_num_rows($result);

                if ($count == 0) {
                  echo '<p class="content-section__desc">
            No results!
         </p>';
                } else {

                  while ($row = mysqli_fetch_array($result)) {


                    $event_id = $row['event_id'];
                    echo '
              
              <a href="./event_page.php?ID=' . $event_id . '"> 
                  <img src=' . $row['event_img_url'] . ' / style="height:400px; width:270px; margin-right:10px; margin-left:10px">      
              </a>';
                  }
                }
              } else {
                echo "Oops! Something went wrong. Please try again later.";
              }

              // Close statement
              mysqli_stmt_close($stmt);
            }
          }
        }

        ?>
      </div>
    </div>

  </section>
  
  <section class="section" >
    <div class="content-section content-section--big-padding" style="padding-bottom:100px">
      <div class="content-section__title">Cheapest and the Best Tickets!</div>

      <a href="./about.html">
        <h2 class="content-section__title">
          About Project

        </h2>
      </a>

    </div>
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