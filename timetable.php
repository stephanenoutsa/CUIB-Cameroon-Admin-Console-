<?php
include 'utils/functions.php';
require_once 'utils/server_comm.php';

//Check if user is logged in
$a = is_user_logged();

// If not logged in, redirect to login page
if (!$a) {
    redirect_to('http://localhost/cuib/login.php');
}

$message = array();
if (isset($_POST['submit'])) {
//    echo '<pre>';
//    print_r($_FILES);
//    echo '</pre>';exit;
    // Form was submitted    
    $schl = trim(filter_input(INPUT_POST, 'school'));
    $school = '';
    switch ($schl) {
        case "1":
            $school = "Business";
            break;
        case "2":
            $school = "Engineering";
            break;
        case "3":
            $school = "Information Technology";
            break;
        case "4":
            $school = "Agriculture & Natural Resources";
            break;
    }
    $dept = trim(filter_input(INPUT_POST, 'department'));
    $department = '';
    switch ($dept) {
        case "1":
            $department = "Human Resource Management";
            break;
        case "2":
            $department = "Banking and Finance";
            break;
        case "3":
            $department = "Accounting";
            break;
        case "4":
            $department = "Marketing";
            break;
        case "5":
            $department = "Electrical & Computer Engineering";
            break;
        case "6":
            $department = "Chemical Engineering";
            break;
        case "7":
            $department = "Mechanical Engineering";
            break;
        case "8":
            $department = "Civil Engineering";
            break;
        case "9":
            $department = "Cyber & Information Security";
            break;
        case "10":
            $department = "Computer Networks & Telecommunication Systems";
            break;
        case "11":
            $department = "Software Engineering";
            break;
        case "12":
            $department = "Agriculture & Natural Resources";
            break;
    }
    $lvl = trim(filter_input(INPUT_POST, 'level'));
    $level = '';
    switch ($lvl) {
        case "1":
            $level = "Freshman";
            break;
        case "2":
            $level = "Sophomore";
            break;
        case "3":
            $level = "Junior";
            break;
        case "4":
            $level = "Senior";
            break;
    }
    
    $path = "uploads/timetables/" . $school . "/" . $department . "/" . $level;
    $target_dir = $path . "/";
    $target_file = $target_dir . basename($_FILES['timetable']['name']);
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
    
    $encoded_path = "uploads/timetables/" . rawurlencode($school) . "/" . rawurlencode($department) . "/" . $level;
    $encoded_path .= "/" . basename($_FILES['timetable']['name']);
    
    if (!is_dir($path)) {
        array_push($message, 'Ensure you selected corresponding \'School\' and \'Department\'.');
    } else {
        unlink($target_file);
    }
    
    if (!isset($school) || $school === '') {
        array_push($message, 'Please select a school');
    }
    if (!isset($department) || $department === '') {
        array_push($message, 'Please select a department');
    }
    if (!isset($level) || $level === '') {
        array_push($message, 'Please select a level');
    }
    if (getimagesize($_FILES['timetable']['tmp_name']) === false) {
        array_push($message, 'File is not an image or is too large');
    } else if ($_FILES['timetable']['size'] > 500000) {
        array_push($message, 'File is too large');
    } else if (!move_uploaded_file($_FILES['timetable']['tmp_name'], $target_file)) {
        array_push($message, 'Failed to upload image');
    }
    
    if (empty($message)) {
        $url = 'http://192.168.43.170/cuib/' . $encoded_path;
        $timetable = create_json_timetable($school, $department, $level, $url);
        
        if (add_timetable($timetable)) {
            $message = '';
            $success = 'Timetable uploaded successfully';
            $school = '';
            $deparmtent = '';
            $level = '';
        } else {
            array_push($messages, 'There was an error uploading the timetable');
        }
    }
} else {
    // Form was not submitted
    $message = '';
    $success = '';
    $school = '';
    $deparmtent = '';
    $level = '';
}

?>
<?php require 'templates/head.php'; ?>
<?php include 'templates/header.php'; ?>
<?php include 'templates/sidebar.php'; ?>
      
        <!--main content start-->
        <section id="main-content">
            <section class="wrapper">            
                <!--overview start-->
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header"><i class="icon_document_alt"></i>Upload Timetable</h3>
                        <ol class="breadcrumb">
                            <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
                            <li><i class="icon_document_alt"></i>Upload Timetable</li>						  	
                        </ol>
                    </div>
                </div>
                <!-- overview end -->

                <section class="panel">                                          
                <div class="panel-body bio-graph-info">
                    <h1>Timetable Info</h1>
                    <div class="<?php if($message != ''){echo 'alert alert-block alert-danger';}?>">
                        <ul>
                            <?php
                            foreach($message as $msg) {
                                echo '<li style="list-style-type:square">' . $msg . '</li>';
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="<?php if ($success != '') {echo 'alert alert-block alert-success';}?>">
                        <?php echo $success; ?>
                    </div>
                    <form class="form-horizontal" action="timetable.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="col-lg-2 control-label">School</label>
                            <div class="col-lg-6">
                                <select name="school" class="form-control input-m m-bot15">
                                    <option value="1" selected="true">Business</option>
                                    <option value="2">Engineering</option>
                                    <option value="3">Information Technology</option>
                                    <option value="4">Agriculture & Natural Resources</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Department</label>
                            <div class="col-lg-6">
                                <select name="department" class="form-control input-m m-bot15">
                                    <option value="1" selected="true">Human Resource Management</option>
                                    <option value="2">Banking and Finance</option>
                                    <option value="3">Accounting</option>
                                    <option value="4">Marketing</option>
                                    <option value="5">Electrical & Computer Engineering</option>
                                    <option value="6">Chemical Engineering</option>
                                    <option value="7">Mechanical Engineering</option>
                                    <option value="8">Civil Engineering</option>
                                    <option value="9">Cyber & Information Security</option>
                                    <option value="10">Computer Networks & Telecommunication Systems</option>
                                    <option value="11">Software Engineering</option>
                                    <option value="12">Agriculture & Natural Resources</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Level</label>
                            <div class="col-lg-6">
                                <select name="level" class="form-control input-m m-bot15">
                                    <option value="1" selected="true">Freshman</option>
                                    <option value="2">Sophomore</option>
                                    <option value="3">Junior</option>
                                    <option value="4">Senior</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Timetable</label>
                            <div class="col-lg-6">
                                <!-- MAX_FILE_SIZE must precede the file input field -->
<!--                                <input type="hidden" name="MAX_FILE_SIZE" value="500000" />-->
                                <input type="file" name="timetable" id="timetable" class="" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button type="submit" name="submit" value="Submit" class="btn btn-primary">Upload Timetable</button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
          </section>
      </section>
      <!--main content end-->
  </section>
  <!-- container section start -->
  
<?php require 'templates/footer.php'; ?>

<!-- load scripts -->
<?php include 'js/pages/scripts.php';
