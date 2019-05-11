<?php
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
defined('P_ROOT') ? null : define('P_ROOT', dirname(dirname(dirname(__FILE__))));
//dirname(dirname(dirname(__FILE__))) = /media/sf_zebbox/agora which is requied for the
//following line of code
//dirname($_SERVER['PHP_SELF'], 3) = /agora which is needed for URI used in redirection
require_once P_ROOT.DS.'includes'.DS.'init.php';
require_once P_ROOT.DS.'includes'.DS.'stripeintegration'.DS.'config.php';
?>

<!-- ///////////request a class block//////////// -->
<?php
if($my_session->is_signed_in()){
  $current_user = unserialize($_SESSION["current_user"]);
  $name_prefix = $current_user->name_prefix;
  $first_name = $current_user->first_name;
  $last_name = $current_user->last_name;
}
$rand = rand();
if($my_session->is_signed_in() &&
  isset($_SESSION["rand"], $_POST["rand"], $_POST["subject"], $_POST["class_name"], $_POST["level_required"], $_POST["book"], $_POST["body"], $_POST["send"]) &&
  $_SESSION["rand"] == $_POST["rand"]){

  $full_name = $name_prefix . " " . $first_name . " " . $last_name;
  $from = $current_user->email;

  $subject = filter_var($_POST["subject"], FILTER_SANITIZE_STRING);
  $body = "Class Name: " . filter_var($_POST["class_name"], FILTER_SANITIZE_STRING) . "<br>";
  $body .= "Edu Level: " . str_replace("_", " ", filter_var($_POST["level_required"], FILTER_SANITIZE_STRING)) . "<br>";
  $body .= "Book: " . filter_var($_POST["book"], FILTER_SANITIZE_STRING) . "<br><br>";

  $body .= filter_var($_POST["body"], FILTER_SANITIZE_STRING);

  /////////////
  $mail_params["to"]["address"] = "info@machomath.com";
  $mail_params["to"]["name"] = "MachoMath";//"Customer";

  $mail_params["from"]["address"] = "info@machomath.com";
  $mail_params["from"]["name"] = "MachoMath";

  $mail_params["cc"]["name"] = "Customer" . $full_name .' Via MachoMath Request a Class';
  $mail_params["cc"]["address"] = $from;//This mail is from a customer via contact form

  $mail_params["subject"] = $subject;
  $mail_params["body"] = $body;

  send_my_email($mail_params);
  ////////////////////
  $alert_message = "Got it, we will reply ASAP.";
}
///// To AVOID RESUBMISSION OF THE FORM 2nd part/////////
$_SESSION["rand"] = $rand;

////////////////////END SEND MESSAGE/////////////////

?>

<!-- //////////request a class block ends ///////// -->
<?php require_once LAYOUT_PATH.DS.'head.php'; ?>
<?php
//Search process//
  try {
    if(isset($_POST["search_button"])){
      $search_by = filter_var($_POST["search_by"], FILTER_SANITIZE_STRING);
      $search_parameters = filter_var($_POST["search_parameters"], FILTER_SANITIZE_STRING);

      switch ($search_by) {
        case 'class_genre':

        case 'class_type':

        case 'class_instructor':

        case 'level_required':
          $classes = CoachingClass::instanciate_array_from_db_detailed([$search_by=>$search_parameters], [["order_in_class_list", "DESC"]]);
          break;

        case 'class_name':
          $classes = CoachingClass::instanciate_array_from_db_detailed([], [["order_in_class_list", "DESC"]]);
          foreach ($classes as $key => $class) {
            if(!preg_match( "/" . $search_parameters . "/i" , $class->$search_by)){
              unset($classes[$key]);
            }
          }
          break;

        case 'fee_to_audit':

        case 'fee_to_attend':
          if($search_parameters == "free"){
            $classes = CoachingClass::instanciate_array_from_db_detailed([$search_by=>0], [["order_in_class_list", "DESC"]]);
          }else{
            $classes = CoachingClass::instanciate_array_from_db_detailed([], [["order_in_class_list", "DESC"]]);
            $free_classes = CoachingClass::instanciate_array_from_db_detailed([$search_by=>0], [["order_in_class_list", "DESC"]]);
            foreach ($free_classes as $free_class) {
              foreach ($classes as $key=>$class) {
                if($class->id == $free_class->id){
                  unset($classes[$key]);
                }
              }
            }
          }
          break;

        case 'registration_status':
          if($search_parameters == "open"){
            $classes = CoachingClass::instanciate_array_from_db_detailed([], [["order_in_class_list", "DESC"]]);
            foreach ($classes as $key => $class) {
              if(!($class->$search_by == "open" || $class->$search_by == "only_audit_open")){
                unset($classes[$key]);
              }
            }
          }else{
            $classes = CoachingClass::instanciate_array_from_db_detailed([$search_by=>$search_parameters], [["order_in_class_list", "DESC"]]);
          }
          break;

        case 'student_id':
        //need to do further
          if(isset($current_user)){
            $registrations = Registration::instanciate_array_from_db([$search_by =>$current_user->id]);
            $classes = CoachingClass::instanciate_array_from_db_detailed([], [["order_in_class_list", "DESC"]]);

            switch ($search_parameters) {
              case "Not Registered At All":
                foreach ($registrations as $key => $registration) {
                  foreach ($classes as $key => $class) {
                    if($class->id == $registration->coaching_class_id){
                      unset($classes[$key]);
                    }
                  }
                }
                break;

              case "Already Registered to Attend":
                foreach ($registrations as $key => $registration) {
                  foreach ($classes as $key => $class) {
                    if($class->id == $registration->coaching_class_id){
                      if($registration->attend_status != "attend"){
                        unset($classes[$key]);
                      }
                    }
                  }
                }
                break;

              case "Already Registered to Audit":
                foreach ($registrations as $key => $registration) {
                  foreach ($classes as $key => $class) {
                    if($class->id == $registration->coaching_class_id){
                      if($registration->attend_status != "audit"){
                        unset($classes[$key]);
                      }
                    }
                  }
                }
                break;
            }
          }

          break;

        case 'all_classes':
          $classes = CoachingClass::instanciate_array_from_db_detailed([], [["order_in_class_list", "DESC"]]);
          break;
      }

    }else{
      $classes = CoachingClass::instanciate_array_from_db_detailed([], [["order_in_class_list", "DESC"]]);
      foreach ($classes as $key => $class) {
        if(!($class->registration_status == "open" || $class->registration_status == "only_audit_open")){
          unset($classes[$key]);
        }
      }
    }
  } catch (Exception $e) {
    $alert_message = $e->getMessage();
    if($alert_message == "No such DB Entry"){
      $alert_message = "No Such Classes for Now.";
      $classes = CoachingClass::instanciate_array_from_db_detailed([], [["order_in_class_list", "DESC"]]);
      foreach ($classes as $key => $class) {
        if(!($class->$search_by == "open" || $class->$search_by == "only_audit_open")){
          unset($classes[$key]);
        }
      }
    }
  }

  if(empty($classes)){
    $alert_message = "No Such Classes for Now.";
    $classes = CoachingClass::instanciate_array_from_db_detailed([], [["order_in_class_list", "DESC"]]);
    foreach ($classes as $key => $class) {
      if(!($class->registration_status == "open" || $class->registration_status == "only_audit_open")){
        unset($classes[$key]);
      }
    }
  }

?>
      <div class="img-div">
        <button type="button" name="button" class="button-class  left-arrow">&lsaquo;</button>
        <img id="carousal" src=<?php echo "..".DS."assets".DS."carousal".DS."4.jpg";?> alt="<?php echo $seo; ?>">
        <button type="button" name="button" class="button-class  right-arrow">&rsaquo;</button>
      </div>
      <a href="#demand-a-class-div">
        <div id="demand-a-class-h2">
          <h2><?php if($my_session->is_signed_in()){echo $name_prefix . " " . $last_name . ", c";}else{echo "C";} ?>hoose your class</h2>
          <p>
            We offer a variety of classes<br>
            <?php if(!$my_session->is_signed_in()){echo "Please signin and c";}else{echo "C";} ?>lick here to request for a class if not listed below
          </p>
        </div>
      </a>
    </div>
  </header>
  <!-- Demand a Class Starts -->
  <?php if ($my_session->is_signed_in()): ?>
  <div class="formdiv" id="demand-a-class-div" style="display: none;">
    <form method="post">
      <input type="number" name="rand" value=<?php echo $rand;?> style="display: none;">
      <input type="text" name="subject" value="Request for a Class via MachoMath Classes" required readonly>
      <input type="text" name="class_name" placeholder="Class name, as it is normally offered" required>
      <input type="text" name="book" placeholder="Book Name and Details like Chapters etc." required>

      <select class="" name="level_required">
        <option name="level_required" value="" disabled selected>Select class level required</option>
        <?php foreach ($_current_edu_level as $value): ?>
          <option name="level_required" value=<?php echo $value; ?> ><?php echo str_replace("_", " ", $value); ?></option>
        <?php endforeach; ?>
      </select>
      <textarea name="body" rows="8" placeholder="Some more details about the class, tell us if someone else is also interested, mention names and email addresses..."></textarea>

      <div class="password-div">
        <button type="submit" name="send" id="signin-button">Send Request</button>
        <button type="button" name="get_pin" id="change-button">Cancel</button>
      </div>
    </form>
  </div>
  <?php endif; ?>
  <!-- Demand a class Ends -->

  <!-- Serchbar starts -->
  <div class="">
    <?php
    $search_criteria = array(
      ["class_genre", "Search by Class Genre"],
      ["class_type", "Search by Class Type"],
      ["class_name", "Search by Class Name Keywords"],
      ["level_required", "Seach by Educational Level"],
      ["fee_to_attend", "Search Free to Attend Classes"],
      ["fee_to_audit", "Search Free to Audit Classes"],
      ["registration_status", "Seach only Open Classes"],
      ["class_instructor", "Search by Instructor Name"],
      ["all_classes", "Show All Classes"]
    );

    if($my_session->is_signed_in()){
      $search_criteria[] = ["student_id", "Search classes I am already registered in"];
    }
    ?>

    <form class="classes-container" method="post" id="search-form">
      <select name="search_by" class="" id="search-select">
        <option name="search_by" value="" selected disabled>Search by ...</option>
        <?php foreach ($search_criteria as $serch_option): ?>
          <option name="search_by" value="<?php echo $serch_option[0]; ?>"><?php echo  $serch_option[1]; ?></option>
        <?php endforeach; ?>
      </select>

      <select class="" name="search_parameters" id="search-parameters">
        <option value="">Search Parameters</option>
      </select>
      <button name="search_button" type="submit"><i class="fa fa-search"></i></button>
    </form>
  </div>
  <!-- Searchbar ends -->
  <div class="colored-body">
    <?php $grid_container_classes_number = 0 ?>
    <?php foreach ($classes as $value): ?>
      <div class="classes-container">
        <div class="grid-container-classes-<?php echo $grid_container_classes_number;?>">
          <div class="grid-item item1-classes">
            <?php if (isMobileDevice()){ ?>
              <img src=<?php echo "..".DS."assets".DS."mobilecoachingclassimages".DS.$value->photo_file_name;?> alt=<?php echo "'". $value->photo_caption . "'"?>>
            <?php }else{ ?>
              <img src=<?php echo "..".DS."assets".DS."coachingclassimages".DS.$value->photo_file_name;?> alt=<?php echo "'". $value->photo_caption . "'"?>>
            <?php } ?>
            <p><?php echo $value->class_detail;?></p>
          </div>
          <div class="grid-item item2-classes">
            <h2 id="class-name-<?php echo $value->id;?>"><?php echo $value->class_name;?></h2>
            <p>Grade Level: <span id="prerequisite-<?php echo $value->id;?>"><?php echo str_replace("_", " ", $value->level_required) . '</span><br><span class="small-font">('. $value->level_required_note .")</span>";?></p>
          </div>
          <div class="grid-item item3-classes">
            <h2>Outline Details</h2>
            <div class="">
              <?php echo $value->list_of_topics_covered;?>
            </div>
          </div>
          <div class="grid-item item4-classes">
            <h2>Instructor:</h2>
            <p><a href="faculty.php"><?php echo $value->class_instructor ?></a></p><br>
            <?php if ($value->class_TA != "NTA" && $value->class_TA != "No TA Assigned Yet" ): ?>
              <h2>Teaching Assistant:</h2>
              <p><?php echo $value->class_TA . "(". $value->class_TA_email .")"; ?></p><br>
            <?php endif; ?>
            <h2>Book Details:</h2>
            <p id="book-<?php echo $value->id;?>"><?php echo $value->book_details;?></p><br>
            <h2>Start Date: </h2>
            <p>
              <?php echo date("M-d-Y", strtotime($value->class_start_date));?>;
              <?php echo $value->number_of_lectures;?> lectures
              (<?php echo $value->note_about_lectures; ?>)</p><br>
            <h2>Class Time: </h2>
            <p>
              <span id="timing-<?php echo $value->id;?>"><?php echo $value->class_time;?>(CT)</span>
            </p><br>
            <h2>Class Duration: </h2>
            <p>
              <?php echo $value->class_duration ?> to <?php echo $value->class_duration +10 ?> mins.
            </p>
          </div>

          <div class="grid-item item5-classes">
            <form class="promocode-form">
              <input type="text" name="promo_code" placeholder="Enter Promo Code and Press &rsaquo;" id="promo-code-<?php echo $value->id;?>">
              <button type="button" name="promo_code" id="promo-code-button-<?php echo $value->id;?>" value="<?php echo $value->id;?>">&rsaquo;</button>
            </form>
            <h2>Fee to Attend: </h2>
            <p>
              $<span id="attend-fee-per-lecture-<?php echo $value->id;?>"><?php echo $value->fee_to_attend/100/$value->number_of_lectures;?></span> per lecture
            </p>

            <p>
              (with a total fee of $<span id="attend-fee-<?php echo $value->id;?>"><?php echo $value->fee_to_attend/100;?></span>)
            </p><br>
            <h2>Fee to Audit: </h2>
            <p>
              $<span id="audit-fee-per-lecture-<?php echo $value->id;?>"><?php echo $value->fee_to_audit/100/$value->number_of_lectures;?></span> per lecture
              (with a total fee of $<span id="audit-fee-<?php echo $value->id;?>"><?php echo $value->fee_to_audit/100;?></span>)
            </p>
            <p style="text-align: justify;">
              <span><?php echo $value->note_about_fee;?><span>. 'Attending' students should actively interact with the instructor, while 'auditing' students should
              actively attend/watch the live lectures.
            </p>
            <h2>Registration Status: </h2>
            <p id="registration-status-<?php echo $value->id;?>">
              <?php echo ucfirst(str_replace( "_", " ", $value->registration_status));?>
            </p><br>
            <h2>Total Seats: </h2>
            <p><?php echo $value->student_capacity;?> (Max. Students 'Attending')</p><br>
            <h2>Current Enrollment: </h2>
            <p><span id="student-enrollment-<?php echo $value->id;?>"><?php echo $value->student_enrollment;?></span></p>
          </div>

          <div class="grid-item item6-classes attendStatus-<?php echo $value->id;?>">
            <form>
              <?php if ($value->student_enrollment < $value->student_capacity){ ?>
                <input type="radio" name="attendStatus" value="attend" checked> Attend
                <input type="radio" name="attendStatus" value="audit"> Audit
              <?php }else{ ?>
                <input type="radio" name="attendStatus" value="audit" checked> Audit
              <?php } ?>
            </form>
          </div>

          <div class="grid-item item7-classes">
            <form method="post">
              <button type="button" name="goahead_with_registration" class="signup-button" value=<?php echo $value->id ?>><?php if(!$my_session->is_signed_in()){echo "Signin for Registration";}else{echo "Registration";} ?></button>
            </form>
          </div>
        </div>
        <div class="contract" id="<?php echo 'contract-'. $value->id;?>">

        </div>
        <?php if ($value->fee_to_attend != 0 || $value->fee_to_audit != 0): ?>
          <div class="submit-button" id="<?php echo 'stripe-attend-button-'. $value->id;?>" style="display: none;">
            <script src="https://checkout.stripe.com/checkout.js"></script>
          </div>
        <?php endif; ?>
      </div>
      <?php $grid_container_classes_number = ($grid_container_classes_number + 1)%2; ?>
    <?php endforeach; ?>
  </div>

  <script type="text/javascript" src=<?php echo "..".DS."javascript".DS."carousalclasses.js"?>></script>
  <script type="text/javascript" src=<?php echo "..".DS."javascript".DS."search.js"?> ></script>
  <?php if (!$my_session->is_signed_in()): ?>
    <script type="text/javascript" src=<?php echo "..".DS."javascript".DS."classes1.js"?>></script>
  <?php endif; ?>
  <?php
    if ($my_session->is_signed_in()){
      $current_user = unserialize($_SESSION["current_user"]);
      if($current_user->type === "stu"){
  ?>
    <script type="text/javascript">
      var studentTermsInitial = <?php echo '"' . give_me_dependent_student_terms(
                                              $current_user->first_name . " " . $current_user->last_name,
                                              $current_user->parent_first_name . " " . $current_user->parent_last_name,
                                              $current_user->email,
                                              $current_user->parent_email,
                                              $current_user->phone_number,
                                              $current_user->street_address . ", " .  $current_user->address_city . ", " . $current_user->address_state . ", " . $current_user->address_country . ", " . $current_user->address_zip,
                                              str_replace("_", " ", $current_user->current_edu_level),
                                              $current_user->latest_edu_institution) . '"';?>;
    </script>
  <?php }elseif($current_user->type === "independent_stu"){ ?>
    <script type="text/javascript">
      var studentTermsInitial = <?php echo '"' . give_me_independent_student_terms(
                                              $current_user->first_name . " " . $current_user->last_name,
                                              $current_user->email,
                                              $current_user->phone_number,
                                              $current_user->street_address . ", " .  $current_user->address_city . ", " . $current_user->address_state . ", " . $current_user->address_country . ", " . $current_user->address_zip,
                                              str_replace("_", " ", $current_user->current_edu_level),
                                              $current_user->latest_edu_institution) . '"';?>;
    </script>
  <?php } ?>
  <script type="text/javascript">
    var publishableKey = <?php echo '"' . $stripe["publishable_key"] . '"'; ?>
  </script>
  <script type="text/javascript" src=<?php echo "..".DS."javascript".DS."classes2.js"?> ></script>
  <script type="text/javascript" src=<?php echo "..".DS."javascript".DS."classes3.js"?> ></script>
  <script type="text/javascript" src=<?php echo "..".DS."javascript".DS."promocode.js"?> ></script>
<?php } ?>

  <?php require_once LAYOUT_PATH.DS.'foot.php'; ?>
  <?php unset($_SESSION["message"]); ?>
