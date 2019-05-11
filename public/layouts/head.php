<?php
  defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
  defined('P_ROOT') ? null : define('P_ROOT', dirname(dirname(dirname(__FILE__))));
  //dirname(dirname(dirname(__FILE__))) = /media/sf_zebbox/agora which is requied for the
  //following line of code
  //dirname($_SERVER['PHP_SELF'], 3) = /agora which is needed for URI used in redirection
  require_once P_ROOT.DS.'includes'.DS.'init.php';
  // if($_SERVER["HTTPS"] != "on"){//code to switch to https
  //     header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
  //     exit();
  // }

  if(isset($_SESSION["message"])){
    $session_message = $_SESSION["message"];
    echo "<script>function sessionAlert(){alert('" . $session_message . "');}</script>";
  }

 require_once 'navbar.php';
?>

<?php      //for sign in
  if(isset($_POST['signin'])){
    global $db;
    $email=$_POST['email'];
    $username=$_POST['username'];
    $password=$_POST['password'];
    $type=$_POST['type'];
    $query = "SELECT * FROM login WHERE username='$username' AND password='$password' AND type='$type'";
    $result = $db->my_query($query);
    $row = $result->fetch(PDO::FETCH_ASSOC);
    $count = 0;

    while($row){
      $count++;
      if($row['username']==$username && $row['password']==$password && $row['type']=='Admin'){
        header("Location: ../admin/admin.php");
        echo $count;
      } 
      elseif($row['username']==$username && $row['password']==$password && $row['type']=='User'){
        header("Location: ../frontend/home.php");
      }
    }
  }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>pick-a-face-and-nick</title>
    <script defer src="https://use.fontawesome.com/releases/v5.5.0/js/all.js"></script>
    <link rel="shortcut icon" href=<?php echo "..".DS."assets".DS."vitalimages".DS."user.png";?> type="image/x-icon">
    <link rel="stylesheet" href=<?php echo "..".DS."styles".DS."mediaflex.css";?>>
    <link rel="stylesheet" href=<?php echo "..".DS."styles".DS."master.css";?>>
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src=<?php echo "..".DS."javascript".DS."pickalert.js";?>></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-131410677-1"></script>
    <script>
      // window.dataLayer = window.dataLayer || [];
      // function gtag(){dataLayer.push(arguments);}
      // gtag('js', new Date());
      // gtag('config', 'UA-131410677-1');
    </script>
    <!-- End Global site tag (gtag.js) - Google Analytics -->
  </head>

  <body <?php echo (isset($session_message) ? 'onload="sessionAlert()"' : null );?> >
    <div class="container">
      <!-- navigation -->
      <div class="wrapper">
        <div id="overlay"></div>
        <div id="popup-content"></div>

          <header class="navbar">
              <nav>
                  <div class="toggle"><i class="fas fa-bars"></i></div>
                  <div class="logo"><a href="../frontend/overlay.php"><img src="../assets/vitalimages/logo.gif" alt="logo..." width="30" height="40"></a></div>
                  <div class="menu"><?php echo $html;?></div>
                  <div class="user">
                      <ul>
                        <input id="filterInput" type="text" placeholder="Search">
                        <a href="#portfolio"><i class="fas fa-search"></i></a>
                        <li><a id="signinModalBtn" href="#">SignIn</a></li>

                          <div id="signinModal" class="signinmodal">
                            <div class="signinmodal-content">
                                <div class="signinmodal-header">
                                    <h4>Please SignIn or SignUp</h4>
                                </div>
                                <div class="signinmodal-body">
                                    <form method="POST" >
                                      <input type="email" name="email" id="email" placeholder="Email" required><br><br>
                                      <input type="username" name="username" id="username" placeholder="Nickname" required><br><br>
                                      <input type="password" name="password" id="password" placeholder="Password" required><br><br>
                                      <p>
                                        <select id = "mytype" name="type">
                                          <option value = "User">User</option>
                                          <option value = "Admin">Admin</option>
                                        </select>
                                       </p>
                                      <!-- <input type="number" name="admin_signin_pin" placeholder="PIN" required><br><br> -->
                                      <button type="submit" name="signin" class="signup-button">Sign In</button>
                                      <button type="submit" name="signup" class="signup-button">Sign Up</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <li><a href="home.php">SignOut</a></li>
                      </ul>
                  </div>
              </nav>
          </header>
      </div>

      <!-- <div class="visible-contents">
        <header>
          <div class="top-grid">
            <?php if (isMobileDevice()){ ?>
              <div class="navbar-img-1-div">
                <img id="navbar-img-1" src=<?php echo ".." . DS . "assets" . DS . "vitalimages" . DS . "fcon.png"; ?>  alt="Pick a Face and Nick"
                ><h2><?php $toshow = substr(basename($_SERVER["PHP_SELF"]), 0, -4); if($toshow == "home"){echo "PickAFaceAndNick";}else{echo $toshow;}?></h2>
              </div>
            <?php }else{ ?>
              <div class="navbar-img-1-div">
                <nav>
                  <img id="navbar-img" src=<?php echo ".." . DS . "assets" . DS . "vitalimages" . DS . "logo.png"; ?>  alt="Pick a Face and Nick">
                  <?php echo $html;?>
                </nav>
              </div>
            <?php } ?>
        </header>
      </div> -->
