<?php
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
defined('P_ROOT') ? null : define('P_ROOT', dirname(dirname(dirname(__FILE__))));
//dirname(dirname(dirname(__FILE__))) = /media/sf_zebbox/agora which is requied for the
//following line of code
//dirname($_SERVER['PHP_SELF'], 3) = /agora which is needed for URI used in redirection
require_once P_ROOT.DS.'includes'.DS.'init.php';
//require_once P_ROOT.DS.'includes'.DS.'metapasswordhash.php';
?>
<?php


  try {
    if(!$my_session->is_signed_in() ){
      header("Location: adminsignin.php");
    }else{
      $current_user = unserialize($_SESSION["current_user"]);
      Admin::is_admin($current_user->email);
    }
  } catch (Exception $e) {
    header("Location: index.php");
  }


  try {
    $faculty_members = Admin::instanciate_array_from_db(["type"=>"faculty", "comment"=>"NC"]);
    $ta = Admin::instanciate_array_from_db(["type"=>"ta", "comment"=>"NC"]);
  } catch (Exception $e) {
    $alert_message = $e->getmessage();
  }
//////////////////////////////////////Creating a new coaching class/////////////////////////
///////////////////////////////////Copying and existing class into a new class/////////////////////
  if(isset($_POST["copy_coaching_class"], $_POST["rand"]) &&  $_POST["rand"] == $_SESSION["rand"]
              && $_FILES['uploaded_file0']['name'] == $_FILES['uploaded_file1']['name']){
    try {
      $parameters = $_POST;
      unset($parameters["copy_coaching_class"]);
      unset($parameters["id"]);
      unset($parameters["rand"]);
      unset($parameters["order_in_class_list"]);
      $parameters += ["id"=>0,
                      "photo_file_name"=>"loaded_at_" . time() . "_" . $_FILES['uploaded_file0']['name'],
                      "photo_file_type"=>$_FILES['uploaded_file0']['type'],
                      "order_in_class_list"=> time()
                      ];

      $coaching_class = new CoachingClass($parameters);

        if(!$_FILES['uploaded_file0']['error'] && !$_FILES['uploaded_file1']['error']){
          $coaching_class->insert_into_table();

          $file_message1 = $coaching_class->save_photo($_FILES['uploaded_file0']['tmp_name']);
          $file_message2 = $coaching_class->save_mobile_photo($_FILES['uploaded_file1']['tmp_name']);
          $alert_message = "Coaching Class Successfully Added: " . $file_message1 . " " . $file_message2;
        }else{
          $file_message = $coaching_class->upload_error[$_FILES['uploaded_file']['error']];
          throw new Exception($file_message);
        }

    } catch (Exception $e) {
      $alert_message = $e->getMessage();
    }

  }
//////////////////////////////Editing the contents of an existing class/////////////////////

if(isset($_POST["edit_coaching_class"], $_POST["rand"]) &&  $_POST["rand"] == $_SESSION["rand"]){

  try {
    $parameters = $_POST;
    unset($parameters["edit_coaching_class"]);
    unset($parameters["rand"]);
    //unset($parameters["order_in_class_list"]);
    $coaching_class = new CoachingClass($parameters);
    $coaching_class->modify_all_attributes($parameters);
      // if(!$_FILES['uploaded_file']['error']){
      //   $coaching_class->insert_into_table();
      //   $file_message = $coaching_class->save_photo($_FILES['uploaded_file']['tmp_name']);
      //   $alert_message = "Coaching Class Successfully Added: " . $file_message;
      // }else{
      //   $file_message = $coaching_class->upload_error[$_FILES['uploaded_file']['error']];
      //   throw new Exception($file_message);
      // }


  } catch (Exception $e) {
    $alert_message = $e->getMessage();
  }

}
  $rand = rand();
  $_SESSION["rand"] = $rand;
?>

<div class="meta-head">
  <?php require_once LAYOUT_PATH.DS.'adminhead.php'; ?>
      <h2 id="signinup-h2">MachoMath Admins are Welcome; hackers/Intruders will be prosecuted</h2>
    </header>
</div>
<hr>

<?php
try {
  $classes = CoachingClass::instanciate_array_from_db([]);
} catch (Exception $e) {
  $alert_message = $e->getMessage();
}


?>
<div class="formdiv">
  <form method="post">
    <select class="all-classes" name="all_classes">
      <option name="all_classes" value="" disabled selected>Select a class</option>
      <?php foreach ($classes as $value): ?>
        <option name="all_classes" value=<?php echo $value->id; ?>><?php echo $value->class_name; ?></option>
      <?php endforeach; ?>
    </select>
  </form>
</div>
<div id="temp"></div>
<?php
  //testing
  echo "<pre>";
    //var_dump($classes);
  echo "</pre>";
  //exit;

 ?>
<hr>

<div class="formdiv" id="edit-or-clone">
  <form method="post" enctype="multipart/form-data">
    <input type="number" name="id"  placeholder="Class id" readonly>
    <input type="text" name="rand" value=<?php echo $rand?> style="display: none;">
    <input type="text" name="class_code" placeholder="Class Code (Don't start with a number, use _ as separator)" required>
    <select class="" name="class_genre">
      <option name="class_genre" value="" disabled selected>Select class genre</option>
      <?php foreach ($class_genres as $value): ?>
        <option name="class_genre" value=<?php echo $value; ?> ><?php echo str_replace("_", " ", $value); ?></option>
      <?php endforeach; ?>
    </select>

    <select class="" name="class_type" required>
      <option name="class_type" value="" disabled selected>Select class type</option>
      <?php foreach ($class_types as $value): ?>
        <option name="class_type" value=<?php echo $value; ?> ><?php echo str_replace("_", " ", $value); ?></option>
      <?php endforeach; ?>
    </select>

    <input type="text" name="class_name" placeholder="Class Name (Include words like SAT AMC NOV 2018 etc)" required>
    <input type="text" name="class_detail" placeholder="Class Detail" required>
    <textarea name="list_of_topics_covered" rows="8" required><ul><li></li></ul></textarea>

    <select class="" name="level_required">
      <option name="level_required" value="" disabled selected>Select class level required</option>
      <?php foreach ($_current_edu_level as $value): ?>
        <option name="level_required" value=<?php echo $value; ?> ><?php echo str_replace("_", " ", $value); ?></option>
      <?php endforeach; ?>
    </select>

    <input type="text" name="level_required_note" placeholder="Enter Note like the Student must have done Algebra I" required>
    <input type="text" name="class_start_date" placeholder="Class Start Date" onfocus="(this.type='date')" onblur="(this.type='text')" required>
    <input type="number" name="number_of_lectures" placeholder="Number of Lectures" required>
    <input type="text" name="note_about_lectures" placeholder="Note About Lectures (Like each lecture will be 40 to 50 of duration, M-F, etc)" required>
    <input type="text" name="class_time" placeholder="Class Time" onfocus="(this.type='time')" onblur="(this.type='text')" required>
    <input type="number" name="class_duration" placeholder="Class Duration in minutes" required>
    <input type="number" name="fee_to_attend" placeholder="Fee to attend the class in cents" required>
    <input type="number" name="fee_to_audit" placeholder="Fee to audit the class in cents" required>
    <input type="text" name="note_about_fee" placeholder="Note About Fee (Like the mentioned price is for each lecture but the payment will be made for entire class)" required>

    <select class="" name="registration_status">
      <option name="registration_status" value="" disabled selected>Registration Status</option>
      <?php foreach ($class_registration_status as $value): ?>
        <option name="registration_status" value=<?php echo $value;?>><?php echo str_replace("_", " ", $value); ?></option>
      <?php endforeach; ?>
    </select>

    <select class="" name="class_instructor">
      <option name="class_instructor" value="" disabled selected>Class Instructor</option>
      <?php foreach ($faculty_members as $value): ?>
        <option name="class_instructor" value=<?php echo '"' . $value->username . '"' ;?> ><?php echo $value->username; ?></option>
      <?php endforeach; ?>
    </select>

    <select class="" name="class_instructor_email">
      <option name="class_instructor_email" value="" disabled selected>Class Instructor Email</option>
      <?php foreach ($faculty_members as $value): ?>
        <option name="class_instructor_email" value=<?php echo $value->email; ?> ><?php echo $value->username . "'s Email " . $value->email; ?></option>
      <?php endforeach; ?>
    </select>

    <select class="" name="class_TA">
      <option name="class_TA" value="" disabled selected>Class TA</option>
      <?php foreach ($ta as $value): ?>
        <option name="class_TA" value=<?php echo $value->username; ?> ><?php echo str_replace("_", " ", $value->username); ?></option>
      <?php endforeach; ?>
    </select>

    <select class="" name="class_TA_email">
      <option name="class_TA_email" value="" disabled selected>Class TA Email</option>
      <?php foreach ($ta as $value): ?>
        <option name="class_TA_email" value=<?php echo $value->email; ?> ><?php echo $value->username . "'s Email " . $value->email; ?></option>
      <?php endforeach; ?>
    </select>

    <input type="file" name="uploaded_file0" title="Photo for big view">
    <input type="file" name="uploaded_file1" title="Photo for mobile view, must be of the same name and type as above.">
    <input type="text" name="photo_name" required placeholder="Enter Photo Name (Use Class Name etc)">
    <input type="text" name="photo_caption" required placeholder="Photo Caption (Try Using SEO)">
    <input type="number" name="student_capacity" placeholder="Enter a suitable number for Students Capacity" required>
    <input type="number" name="student_enrollment" placeholder="Enter 0 for Student Enrollment, it will come from DB" required>
    <input type="number" name="student_audience" placeholder="Enter 0 for Student Audience, it will come from DB" required>
    <input type="text" name="book_details" placeholder="Book Details" required>
    <input type="number" name="order_in_class_list" value="" placeholder="Order in the list of classes">
    <input type="text" name="overall_comment" required placeholder="Paste Zoom link for Attendees (Create a Zoom Webinar First...)">
    <div class="password-div">
      <button type="submit" name="edit_coaching_class" id="signin-button">Edit Coaching Class</button>
      <button type="submit" name="copy_coaching_class" id="change-button">Create a new Coaching Class</button>
    </div>
  </form>
</div>

<hr>
<div class="formdiv">
  <h2>Students Registered in this Class</h2>
  <p id="students-attend-names"></p>
  <hr>
  <p id="students-attend-email-addresses"></p>
  <hr>
  <p id="students-audit-email-addresses"></p>
</div>


<script type="text/javascript" src=<?php echo "..".DS."javascript".DS."admintasks.js"?> ></script>
<script type="text/javascript" src=<?php echo "..".DS."javascript".DS."admintasks2.js"?> ></script>
<?php require_once LAYOUT_PATH.DS.'metafoot.php'; ?>
