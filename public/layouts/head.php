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
?>
<?php
require_once 'navbar.php';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>pick-a-face-and-nick</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="shortcut icon" href=<?php echo "..".DS."assets".DS."vitalimages".DS."fcon.png";?> type="image/x-icon">
    <link rel="stylesheet" href=<?php echo "..".DS."stylesheets".DS."mediaflex.css";?>>
    <link rel="stylesheet" href=<?php echo "..".DS."stylesheets".DS."masterstyle.css";?>>
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
    <div id="overlay"></div>
    <div id="popup"></div>
    <!-- The above two divs get activated by js -->
    <div class="visible-contents">
      <header>
        <div class="top-grid">
          <?php if (isMobileDevice()){ ?>
            <div class="navbar-img-1-div">
              <img id="navbar-img-1" src=<?php echo ".." . DS . "assets" . DS . "vitalimages" . DS . "fcon.png"; ?>  alt="MachoMath"
              ><h2><?php $toshow = substr(basename($_SERVER["PHP_SELF"]), 0, -4); if($toshow == "home"){echo "MachoMath";}else{echo $toshow;}?></h2>
            </div>
          <?php }else{ ?>
            <div class="navbar-img-1-div">
              <nav>
                <img id="navbar-img" src=<?php echo ".." . DS . "assets" . DS . "vitalimages" . DS . "logo.png"; ?>  alt="MachoMath">
                <?php echo $html;?>
              </nav>
            </div>
          <?php } ?>



    <!-- </header> -->
    <!-- </div> -->
