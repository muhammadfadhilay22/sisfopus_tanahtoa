<!-- Author Name: Nikhil Bhalerao +919423979339. 
PHP, Laravel and Codeignitor Developer
-->
<?php include('connect.php'); ?>

<body>
  <?php
  $que = "select * from manage_website";
  $query = $conn->query($que);
  while ($row = mysqli_fetch_array($query)) {
    //print_r($row);
    extract($row);
    $business_name = $row['business_name'];
    $business_email = $row['business_email'];
    $business_web = $row['business_web'];
    $portal_addr = $row['portal_addr'];
    $addr = $row['addr'];
    $curr_sym = $row['curr_sym'];
    $curr_position = $row['curr_position'];
    $front_end_en = $row['front_end_en'];
    $date_format = $row['date_format'];
    $def_tax = $row['def_tax'];
    $logo = $row['logo'];
  }
  ?>

  <div class="theme-loader">
    <div class="ball-scale">
      <div class='contain'>
        <div class="ring">
          <div class="frame"></div>
        </div>
        <div class="ring">
          <div class="frame"></div>
        </div>
        <div class="ring">
          <div class="frame"></div>
        </div>
        <div class="ring">
          <div class="frame"></div>
        </div>
        <div class="ring">
          <div class="frame"></div>
        </div>
        <div class="ring">
          <div class="frame"></div>
        </div>
        <div class="ring">
          <div class="frame"></div>
        </div>
        <div class="ring">
          <div class="frame"></div>
        </div>
        <div class="ring">
          <div class="frame"></div>
        </div>
        <div class="ring">
          <div class="frame"></div>
        </div>
      </div>
    </div>
  </div>

  <div id="pcoded" class="pcoded">
    <div class="pcoded-overlay-box"></div>
    <div class="pcoded-container navbar-wrapper">
      <nav class="navbar header-navbar pcoded-header">
        <div class="navbar-wrapper">
          <div class="navbar-logo">

            <a href="index.php">

              <div class="logo-line">Puskesmas</div>
              <div class="logo-line highlight">Tanah Toa</div>
            </a>
            <a class="mobile-options">
              <i class="feather icon-more-horizontal"></i>
            </a>
          </div>


          <div class="navbar-container container-fluid">
            <ul class="nav-left">
              <li class="header-search">
                <div class="main-search morphsearch-search">
                  <div class="input-group">
                    <span class="input-group-addon search-close"><i class="feather icon-x"></i></span>
                    <input type="text" class="form-control">
                    <span class="input-group-addon search-btn"><i class="feather icon-search"></i></span>
                  </div>
                </div>
              </li>
              <li>
                <a href="#!" onclick="javascript:toggleFullScreen()">
                  <i class="feather icon-maximize full-screen"></i>
                </a>
              </li>
            </ul>
            <ul class="nav-right">
              <li class="header-notification">
                <div class="dropdown-primary dropdown">
                  <div class="dropdown-toggle" data-toggle="dropdown">

              <li class="user-profile header-notification">
                <div class="dropdown-primary dropdown">
                  <div class="dropdown-toggle" data-toggle="dropdown">

                    <?php

                    /*$sql = "select * from admin where id = '".$_SESSION["id"]."'";
        $query=$conn->query($sql);
        while($row=mysqli_fetch_array($query))
        {
            //print_r($row);
            extract($row);
            $fname = $row['fname'];
            $lname = $row['lname'];
            $email = $row['loginid'];
            $contact = $row['mobileno'];
            //$dob1 = $row['dob'];
            $gender = $row['gender'];
            $image = $row['image'];
        }*/
                    if ($_SESSION['user'] == 'admin') {
                    ?>

                      <img src="uploadImage/Profile/<?php echo $_SESSION['image']; ?>" class="img-radius" alt="User-Profile-Image" /><?php } ?>
                    <span><?php echo $_SESSION['fname']; ?></span>
                    <i class="feather icon-chevron-down"></i>
                  </div>
                  <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">

                    <li>
                      <a href="profile.php">
                        <i class="feather icon-user"></i> Profil
                      </a>
                    </li>
                    <li>
                      <a href="changepassword.php">
                        <i class="feather icon-edit"></i> Ganti Password
                      </a>
                    </li>

                    <li>
                      <a href="logout.php">
                        <i class="feather icon-log-out"></i> Keluar
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>