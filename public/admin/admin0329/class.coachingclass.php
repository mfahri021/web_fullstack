<?php
/**
 *
 */
class CoachingClass extends DBobject{
  protected static $_table = "coaching_classes";
  protected $_attributes = array(
    "id" => 0,
    "class_code" => "NCC",
    "class_genre" => "Math",
    "class_type" => "online_class",
    "class_name" => "NCN",
    "class_detail" => "NCD",
    "list_of_topics_covered" => "NLT",
    "level_required" => "Below_9",
    "level_required_note" => "NLN",
    "class_start_date" => "NSD",
    "number_of_lectures" => "NLN",
    "note_about_lectures" => "NLN",
    "class_time" => "NCT",
    "class_duration" => "NCD",
    "fee_to_attend" => 0,
    "fee_to_audit" => 0,
    "note_about_fee" => "NFN",
    "registration_status" => "open",
    "class_instructor" => "NCI",
    "class_instructor_email" => "NIE",
    "class_TA" => "No TA Assigned Yet",
    "class_TA_email" => "ntae@ntaemail.com",
    "photo_name" => "NPN",
    "photo_caption" => "NPC",
    "photo_file_name" => "NFL", //filename + a unique extension
    "photo_file_type" => "NFT",
    "student_capacity" => 0,
    "student_enrollment" => 0,
    "student_audience" => 0,
    "book_details" => "NBD",
    "order_in_class_list"=> 10,
    "overall_comment" => "NC"
  );

   public static $upload_error = array(
     UPLOAD_ERR_OK => "No Errors.",
     UPLOAD_ERR_INI_SIZE => "Larger than the Max File Size.",
     UPLOAD_ERR_FORM_SIZE => "Larger than the Max of Form File Size.",
     UPLOAD_ERR_PARTIAL => "Partial upload.",
     UPLOAD_ERR_NO_FILE => "No FILE.",
     UPLOAD_ERR_NO_TMP_DIR => "No Temporary directory.",
     UPLOAD_ERR_CANT_WRITE => "Cannot write to the disk.",
     UPLOAD_ERR_EXTENSION => "File upload stopped by extension."
   );


  function __construct($attributes){
    try {
      parent::__construct($attributes);
    } catch (Exception $e) {
      throw $e;
    }
  }

  public  function save_photo($tmp_value){
       $target_path = IMG_PATH .DS. $this->_attributes["photo_file_name"];
       try {
         move_uploaded_file($tmp_value, $target_path);
         return 'Photo saved.';
       } catch (Exception $e) {
         throw $e;
       }
   }

   public  function save_mobile_photo($tmp_value){
        $target_path = MOBILE_IMG_PATH .DS. $this->_attributes["photo_file_name"];
        try {
          move_uploaded_file($tmp_value, $target_path);
          return 'Photo saved.';
        } catch (Exception $e) {
          throw $e;
        }
    }



   public function delete_photo(){
     try {
       unlink(IMG_PATH.DS.$this->_attributes["photo_file_name"]);
       return 'Photo deleted from DB';
     } catch (Exception $e) {
       throw $e;
     }
   }

   public static function instanciate_array_from_db($key_value_pairs){
     try {
       return parent::instanciate_array_from_db($key_value_pairs);
     } catch (Exception $e) {
       throw $e;
     }
   }

   public static function instanciate_array_from_db_detailed($key_value_pairs, $order_columns){
     try {
       return parent::instanciate_array_from_db_detailed($key_value_pairs, $order_columns);
     } catch (Exception $e) {
       throw $e;
     }
   }

  /////////////////////////setters of the $_attributes array under this line ////////////////////

  protected function _set_id($id){
    if($id == 0 || filter_var($id, FILTER_VALIDATE_INT)){
      $this->_attributes["id"] = $id;
    }else{
      throw new Exception("Not a valid id.");
    }
  }


  protected function _set_class_code($class_code){
    if(is_string($class_code)){
      $this->_attributes["class_code"] = filter_var($class_code, FILTER_SANITIZE_STRING);
    }else{
      throw new Exception("Not a valid class code.");
    }
  }

  protected function _set_class_genre($class_genre){
    global $class_genres;
    if(in_array($class_genre, $class_genres, false)){//in_array($class_genre, $class_genres, false)
      $this->_attributes["class_genre"] = $class_genre;
    }else{
      throw new Exception("Not a valid class genre. ");
    }
  }

  protected function _set_class_type($class_type){
    global $class_types;
    if(in_array($class_type, $class_types, false)){
      $this->_attributes["class_type"] = $class_type;
    }else{
      throw new Exception("Not a valid class type.");
    }
  }

  protected function _set_class_name($class_name){
    if(is_string($class_name)){//ctype_alpha($class_name)
      $this->_attributes["class_name"] = filter_var($class_name, FILTER_SANITIZE_STRING);
    }else{
      throw new Exception("Not a valid class name" . $class_name);
    }
  }

  protected function _set_class_detail($class_detail){
    if(is_string($class_detail)){//ctype_alpha($class_detail)
      $this->_attributes["class_detail"] = filter_var($class_detail, FILTER_SANITIZE_STRING);
    }else{
      throw new Exception("Not a valid class detail");
    }
  }

  protected function _set_list_of_topics_covered($list_of_topics_covered){
    if(is_string($list_of_topics_covered)){//ctype_alpha($list_of_topics_covered)
      $this->_attributes["list_of_topics_covered"] = $list_of_topics_covered; //filter_var($list_of_topics_covered, FILTER_SANITIZE_STRING);
    }else{
      throw new Exception("Not a valid list of topics covered");
    }
  }

  protected function _set_level_required($level_required){
    global $_current_edu_level;
    if(in_array($level_required, $_current_edu_level, $strict = true)){
      $this->_attributes["level_required"] = $level_required;
    }else{
      throw new Exception("Not a valid educational level required");
    }
  }

  protected function _set_level_required_note($level_required_note){
    if(is_string($level_required_note)){//ctype_alpha($level_required_note)
      $this->_attributes["level_required_note"] = filter_var($level_required_note, FILTER_SANITIZE_STRING);
    }else{
      throw new Exception("Not a valid level required note");
    }
  }

  protected function _set_class_start_date($class_start_date){
    if(strtotime($class_start_date)){
      $this->_attributes["class_start_date"] = filter_var($class_start_date, FILTER_SANITIZE_STRING);
    }else{
      throw new Exception("Not a valid class start date");
    }
  }

  protected function _set_number_of_lectures($number_of_lectures){
    if($number_of_lectures == 0 || filter_var($number_of_lectures, FILTER_VALIDATE_INT)){
      $this->_attributes["number_of_lectures"] = $number_of_lectures;
    }else{
      throw new Exception("Not a valid number of lectures.");
    }
  }

  protected function _set_note_about_lectures($note_about_lectures){
    if(is_string($note_about_lectures)){//need to change it//ctype_alpha($note_about_lectures)
      $this->_attributes["note_about_lectures"] = filter_var($note_about_lectures, FILTER_SANITIZE_STRING);
    }else{
      throw new Exception("Not a valid note about lectures");
    }
  }

  protected function _set_class_time($class_time){
    if(strtotime($class_time)){//need to change it
      $this->_attributes["class_time"] = filter_var($class_time, FILTER_SANITIZE_STRING);
    }else{
      throw new Exception("Not a valid class time");
    }
  }

  protected function _set_class_duration($class_duration){//duration is in number of minutes
    if($class_duration == 0 || filter_var($class_duration, FILTER_VALIDATE_INT)){
      $this->_attributes["class_duration"] = $class_duration;
    }else{
      throw new Exception("Not a valid class duration.");
    }
  }

  protected function _set_fee_to_attend($fee_to_attend){//fee in cents
    if($fee_to_attend == 0 || filter_var($fee_to_attend, FILTER_VALIDATE_INT)){
      $this->_attributes["fee_to_attend"] = $fee_to_attend;
    }else{
      throw new Exception("Not a valid fee to attend.");
    }
  }

  protected function _set_fee_to_audit($fee_to_audit){//fee in cents
    if($fee_to_audit == 0 || filter_var($fee_to_audit, FILTER_VALIDATE_INT)){
      $this->_attributes["fee_to_audit"] = $fee_to_audit;
    }else{
      throw new Exception("Not a valid fee to audit.");
    }
  }

  protected function _set_note_about_fee($note_about_fee){
    if(is_string($note_about_fee)){//need to change it
      $this->_attributes["note_about_fee"] = filter_var($note_about_fee, FILTER_SANITIZE_STRING);
    }else{
      throw new Exception("Not a valid note about fee");
    }
  }

  protected function _set_registration_status($registration_status){
    global $class_registration_status;
    if(in_array($registration_status, $class_registration_status, false)){
      $this->_attributes["registration_status"] = $registration_status;
    }else{
      throw new Exception("Not a valid registration status.");
    }
  }

  protected function _set_class_instructor($class_instructor){
    if(is_string($class_instructor)){
      $this->_attributes["class_instructor"] = filter_var($class_instructor, FILTER_SANITIZE_STRING);
    }else{
      throw new Exception("Not a valid class instructor");
    }
  }

  protected function _set_class_instructor_email($class_instructor_email){
    if(filter_var($class_instructor_email, FILTER_VALIDATE_EMAIL)){
      $this->_attributes["class_instructor_email"] = filter_var($class_instructor_email, FILTER_SANITIZE_EMAIL);
    }else{
      throw new Exception("Not a valid Class Instructor email");
    }
  }

  protected function _set_class_TA($class_TA){
    if(is_string($class_TA)){
      $this->_attributes["class_TA"] = filter_var($class_TA, FILTER_SANITIZE_STRING);
    }else{
      throw new Exception("Not a valid class TA");
    }
  }

  protected function _set_class_TA_email($class_TA_email){
    if(filter_var($class_TA_email, FILTER_VALIDATE_EMAIL)){
      $this->_attributes["class_TA_email"] = filter_var($class_TA_email, FILTER_SANITIZE_EMAIL);
    }else{
      throw new Exception("Not a valid TA email");
    }
  }

  protected function _set_photo_name($photo_name){
    if(is_string($photo_name)){
      $this->_attributes["photo_name"] = filter_var($photo_name, FILTER_SANITIZE_STRING);
    }else{
      throw new Exception("Not a valid photo name");
    }
  }

  protected function _set_photo_caption($photo_caption){
    if(is_string($photo_caption)){
      $this->_attributes["photo_caption"] = filter_var($photo_caption, FILTER_SANITIZE_STRING);
    }else{
      throw new Exception("Not a valid photo caption");
    }
  }

  protected function _set_photo_file_name($photo_file_name){
     if(is_string($photo_file_name)){
       $this->_attributes["photo_file_name"] = filter_var($photo_file_name, FILTER_SANITIZE_STRING);
     }else{
       throw new Exception("Not a valid photo file name");
     }
   }

   protected function _set_photo_file_type($photo_file_type){
     if(is_string($photo_file_type)){
       $this->_attributes["photo_file_type"] = filter_var($photo_file_type, FILTER_SANITIZE_STRING);
     }else{
       throw new Exception("Not a valid photo file type");
     }
   }

   protected function _set_student_capacity($student_capacity){
     if($student_capacity == 0 || filter_var($student_capacity, FILTER_VALIDATE_INT)){
       $this->_attributes["student_capacity"] = $student_capacity;
     }else{
       throw new Exception("Not a valid student capacity.");
     }
   }

   protected function _set_student_enrollment($student_enrollment){
     if($student_enrollment == 0 || filter_var($student_enrollment, FILTER_VALIDATE_INT)){
       $this->_attributes["student_enrollment"] = $student_enrollment;
     }else{
       throw new Exception("Not a valid student enrollment.");
     }
   }

   protected function _set_student_audience($student_audience){
     if($student_audience == 0 || filter_var($student_audience, FILTER_VALIDATE_INT)){
       $this->_attributes["student_audience"] = $student_audience;
     }else{
       throw new Exception("Not a valid student audience.");
     }
   }

   protected function _set_book_details($book_details){
     if(is_string($book_details)){
       $this->_attributes["book_details"] = filter_var($book_details, FILTER_SANITIZE_STRING);
     }else{
       throw new Exception("Not a valid book details");
     }
   }

   protected function _set_order_in_class_list($order_in_class_list){
     if($order_in_class_list == 0 || filter_var($order_in_class_list, FILTER_VALIDATE_INT)){
       $this->_attributes["order_in_class_list"] = $order_in_class_list;
     }else{
       throw new Exception("Not a valid order_in_class_list.");
     }
   }

   protected function _set_overall_comment($overall_comment){
     if(is_string($overall_comment)){
       $this->_attributes["overall_comment"] = filter_var($overall_comment, FILTER_SANITIZE_STRING);
     }else{
       throw new Exception("Not a valid overall comment");
     }
   }
///////////////////End of all the setters

}




?>
