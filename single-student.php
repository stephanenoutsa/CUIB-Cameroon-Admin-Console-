<?php
require_once 'utils/functions.php';
require_once 'utils/server_comm.php';

//Check if user is logged in
$a = is_user_logged();

// If not logged in, redirect to login page
if (!$a) {
    redirect_to('http://localhost/cuib/login.php');
}

$id = $_GET['c'];

if (!isset($id) || $id === '') {
    redirect_to('http://localhost/cuib/students.php');
}

$message = array();
if (isset($_POST['submit'])) {
    // Form was submitted
    $name = ucwords(trim(filter_input(INPUT_POST, 'name')));
    $matricule = trim(filter_input(INPUT_POST, 'matricule'));
    $enrolled = trim(filter_input(INPUT_POST, 'enrolled'));
    $lvl = trim(filter_input(INPUT_POST, 'level'));
    $level = '';
    $l1 = '';
    $l2 = '';
    $l3 = '';
    $l4 = '';
    switch ($lvl) {
        case "1":
            $level = "Freshman";
            $l1 = "Freshman";
            break;
        case "2":
            $level = "Sophomore";
            $l2 = "Sophomore";
            break;
        case "3":
            $level = "Junior";
            $l3 = "Junior";
            break;
        case "4":
            $level = "Senior";
            $l4 = "Senior";
            break;
    }
    $schl = trim(filter_input(INPUT_POST, 'school'));
    $school = '';
    $s1 = '';
    $s2 = '';
    $s3 = '';
    $s4 = '';
    switch ($schl) {
        case "1":
            $school = "Business";
            $s1 = "Business";
            break;
        case "2":
            $school = "Engineering";
            $s2 = "Engineering";
            break;
        case "3":
            $school = "Information Technology";
            $s3 = "Information Technology";
            break;
        case "4":
            $school = "Agriculture & Natural Resources";
            $s4 = "Agriculture & Natural Resources";
            break;
    }
    $dept = trim(filter_input(INPUT_POST, 'department'));
    $department = '';
    $d1 = '';
    $d2 = '';
    $d3 = '';
    $d4 = '';
    $d5 = '';
    $d6 = '';
    $d7 = '';
    $d8 = '';
    $d9 = '';
    $d10 = '';
    $d11 = '';
    $d12 = '';
    switch ($dept) {
        case "1":
            $department = "Human Resource Management";
            $d1 = "Human Resource Management";
            break;
        case "2":
            $department = "Banking and Finance";
            $d2 = "Banking and Finance";
            break;
        case "3":
            $department = "Accounting";
            $d3 = "Accounting";
            break;
        case "4":
            $department = "Marketing";
            $d4 = "Marketing";
            break;
        case "5":
            $department = "Electrical & Computer Engineering";
            $d5 = "Electrical & Computer Engineering";
            break;
        case "6":
            $department = "Chemical Engineering";
            $d6 = "Chemical Engineering";
            break;
        case "7":
            $department = "Mechanical Engineering";
            $d7 = "Mechanical Engineering";
            break;
        case "8":
            $department = "Civil Engineering";
            $d8 = "Civil Engineering";
            break;
        case "9":
            $department = "Cyber & Information Security";
            $d9 = "Cyber & Information Security";
            break;
        case "10":
            $department = "Computer Networks & Telecommunication Systems";
            $d10 = "Computer Networks & Telecommunication Systems";
            break;
        case "11":
            $department = "Software Engineering";
            $d11 = "Software Engineering";
            break;
        case "12":
            $department = "Agriculture & Natural Resources";
            $d12 = "Agriculture & Natural Resources";
            break;
    }
    $email = trim(filter_input(INPUT_POST, 'email'));
    $phone = trim(filter_input(INPUT_POST, 'phone'));
    
    if (!isset($name) || $name === '') {
        array_push($message, 'Fill in \'Student Name\' field');
    } else if (!name_valid($name)) {
        array_push($message, 'Provide at least two names');
    }
    if (!isset($matricule) || $matricule === '') {
        array_push($message, 'Fill in \'Student Matricule\' field');
    }
    if (!isset($enrolled) || $enrolled === '') {
        array_push($message, 'Fill in \'Enrollment Year\' field');
    }
    if (!isset($level) || $level === '') {
        array_push($message, 'Fill in \'Level\' field');
    }
    if (!isset($school) || $school === '') {
        array_push($message, 'Fill in \'School\' field');
    }
    if (!isset($department) || $department === '') {
        array_push($message, 'Fill in \'Department\' field');
    }
    if (!isset($email) || $email === '') {
        array_push($message, 'Fill in \'Student Email\' field');
    } else if (! email_valid($email)) {
        array_push($message, 'Invalid email address');
    }
    if (!isset($phone) || $phone === '') {
        array_push($message, 'Fill in \'Phone Number\' field');
    }
    
    if (empty($message)) {
        $student = create_json_student($name, $matricule, $enrolled, $level, $school, $department, $email, $phone, $_SESSION['student-password']);
        
        if (edit_student($id, $student)) {
            $message = '';
            $success = 'Student edited successfully';
        } else {
            array_push($message, 'There was an error editing the student.');
        }
    }
} else if (isset($_POST['delete'])) {
    if (del_student($id)) {
        $message = '';
        redirect_to('http://localhost/cuib/students.php');
    } else {
        array_push($message, 'Failed to delete student');
    }
} else {
    // Form was not submitted
    $message = '';
    $success = '';
    $name = '';
    $matricule = '';
    $enrolled = '';
    $level = '';
    $l1 = '';
    $l2 = '';
    $l3 = '';
    $l4 = '';
    $school = '';
    $s1 = '';
    $s2 = '';
    $s3 = '';
    $s4 = '';
    $department = '';
    $d1 = '';
    $d2 = '';
    $d3 = '';
    $d4 = '';
    $d5 = '';
    $d6 = '';
    $d7 = '';
    $d8 = '';
    $d9 = '';
    $d10 = '';
    $d11 = '';
    $d12 = '';
    $email = '';
    $phone = '';
    $student = get_student($id);
    if (!empty($student)) {
        $name = $student['name'];
        $matricule = $student['matricule'];
        $_SESSION['student-matricule'] = $matricule;
        $enrolled = $student['enrolled'];
        $level = $student['level'];
        switch ($level) {
            case "Freshman":
                $l1 = "Freshman";
                break;
            case "Sophomore":
                $l2 = "Sophomore";
                break;
            case "Junior":
                $l3 = "Junior";
                break;
            case "Senior":
                $l4 = "Senior";
                break;
        }
        $school = $student['school'];
        switch ($school) {
            case "Business":
                $s1 = "Business";
                break;
            case "Engineering":
                $s2 = "Engineering";
                break;
            case "Information Technology":
                $s3 = "Information Technology";
                break;
            case "Agriculture & Natural Resources":
                $s4 = "Agriculture & Natural Resources";
                break;
        }
        $department = $student['department'];
        switch ($department) {
            case "Human Resource Management":
                $d1 = "Human Resource Management";
                break;
            case "Banking and Finance":
                $d2 = "Banking and Finance";
                break;
            case "Accounting":
                $d3 = "Accounting";
                break;
            case "Marketing":
                $d4 = "Marketing";
                break;
            case "Electrical & Computer Engineering":
                $d5 = "Electrical & Computer Engineering";
                break;
            case "Chemical Engineering":
                $d6 = "Chemical Engineering";
                break;
            case "Mechanical Engineering":
                $d7 = "Mechanical Engineering";
                break;
            case "Civil Engineering":
                $d8 = "Civil Engineering";
                break;
            case "Cyber & Information Security":
                $d9 = "Cyber & Information Security";
                break;
            case "Computer Networks & Telecommunication Systems":
                $d10 = "Computer Networks & Telecommunication Systems";
                break;
            case "Software Engineering":
                $d11 = "Software Engineering";
                break;
            case "Agriculture & Natural Resources":
                $d12 = "Agriculture & Natural Resources";
                break;
        }
        $email = $student['email'];
        $phone = $student['phone'];
        $_SESSION['student-password'] = $student['password'];
//        $password = $student['password'];
//        $repassword = $password;
    }
}

$failed = array();
if (isset($_POST['upload'])) {
    $year = trim(filter_input(INPUT_POST, 'year'));
    $sem = trim(filter_input(INPUT_POST, 'semester'));
    $semester = '';
    switch ($sem) {
        case "1":
            $semester = "1";
            break;
        case "2":
            $semester = "2";
            break;
        case "3":
            $semester = "Resit";
    }
    if (!isset($year) || $year === '') {
        array_push($failed, 'Fill in the \'Academic Year\' field');
    }
    if (!isset($semester) || $semester === '') {
        array_push($failed, 'Select a semester');
    }
    
    $year_array = explode("/", $year);
    $a_year = implode("-", $year_array);
    $path = "uploads/results/" . $a_year . "/" . $semester . "/" . $_SESSION['student-matricule'];
    $target_dir = $path . "/";
    $target_file = $target_dir . basename($_FILES['results']['name']);
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
    
    $encoded_path = "uploads/results/" . rawurlencode($a_year) . "/" . rawurlencode($semester) . "/" . rawurlencode($_SESSION['student-matricule']);
    $encoded_path .= "/" . basename($_FILES['results']['name']);
    
    if (!is_dir($path)) {
        if (!mkdir($path, 0777, true)) {
            array_push($failed, 'Failed to create directory for results. Please try again.');
        }
    } else {
        unlink($target_file);
    }
    if (getimagesize($_FILES['results']['tmp_name']) === false) {
        array_push($failed, 'File is not an image or is too large');
    } else if ($_FILES['results']['size'] > 500000) {
        array_push($failed, 'File is too large');
    } else if (!move_uploaded_file($_FILES['results']['tmp_name'], $target_file)) {
        array_push($failed, 'Failed to upload results');
    }
    
    if (empty($failed)) {
        $url = 'http://192.168.43.210/cuib/' . $encoded_path;
        $results = create_json_results($year, $semester, $_SESSION['student-matricule'], $url);
        
        if (add_results($results)) {
            $failed = '';
            $uploaded = 'Results uploaded successfully';
            $year = '';
            $semester = '';
            $url = '';
        } else {
            array_push($failed, 'There was an error uploading the results');
        }
    }
} else {
    $failed = '';
    $uploaded = '';
    $year = '';
    $semester = '';
    $url = '';
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
                        <h3 class="page-header"><i class="fa fa-user"></i><?= $name; ?></h3>
                        <ol class="breadcrumb">
                            <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
                            <li><i class="fa fa-user"></i>Students</li>
                            <li><?= $name; ?></li>
                        </ol>
                    </div>
                </div>
                <!-- overview end -->

                <section class="panel">                                          
                    <div class="panel-body bio-graph-info">
                        <h1>Student Info</h1>
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
                        <form class="form-horizontal" action="single-student.php?c=<?= $id; ?>" method="post">                                                  
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Student Name</label>
                                <div class="col-lg-6">
                                    <input type="text" name="name" value="<?php echo htmlspecialchars($name);?>" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Student Matricule</label>
                                <div class="col-lg-6">
                                    <input type="text" name="matricule" value="<?php echo htmlspecialchars($matricule);?>" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Enrollment Year</label>
                                <div class="col-lg-6">
                                    <input type="text" name="enrolled" value="<?php echo htmlspecialchars($enrolled);?>" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Level</label>
                                <div class="col-lg-6">
                                    <select name="level" class="form-control input-m m-bot15">
                                        <option value="1" <?php if(isset($l1) && $l1 !== ''){echo 'selected="true"';}?>>Freshman</option>
                                        <option value="2" <?php if(isset($l2) && $l2 !== ''){echo 'selected="true"';}?>>Sophomore</option>
                                        <option value="3" <?php if(isset($l3) && $l3 !== ''){echo 'selected="true"';}?>>Junior</option>
                                        <option value="4" <?php if(isset($l4) && $l4 !== ''){echo 'selected="true"';}?>>Senior</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">School</label>
                                <div class="col-lg-6">
                                    <select name="school" class="form-control input-m m-bot15">
                                        <option value="1" <?php if(isset($s1) && $s1 !== ''){echo 'selected="true"';}?>>Business</option>
                                        <option value="2" <?php if(isset($s2) && $s2 !== ''){echo 'selected="true"';}?>>Engineering</option>
                                        <option value="3" <?php if(isset($s3) && $s3 !== ''){echo 'selected="true"';}?>>Information Technology</option>
                                        <option value="4" <?php if(isset($s4) && $s4 !== ''){echo 'selected="true"';}?>>Agriculture & Natural Resources</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Department</label>
                                <div class="col-lg-6">
                                    <select name="department" class="form-control input-m m-bot15">
                                        <option value="1" <?php if(isset($d1) && $d1 !== ''){echo 'selected="true"';}?>>Human Resource Management</option>
                                        <option value="2" <?php if(isset($d2) && $d2 !== ''){echo 'selected="true"';}?>>Banking and Finance</option>
                                        <option value="3" <?php if(isset($d3) && $d3 !== ''){echo 'selected="true"';}?>>Accounting</option>
                                        <option value="4" <?php if(isset($d4) && $d4 !== ''){echo 'selected="true"';}?>>Marketing</option>
                                        <option value="5" <?php if(isset($d5) && $d5 !== ''){echo 'selected="true"';}?>>Electrical & Computer Engineering</option>
                                        <option value="6" <?php if(isset($d6) && $d6 !== ''){echo 'selected="true"';}?>>Chemical Engineering</option>
                                        <option value="7" <?php if(isset($d7) && $d7 !== ''){echo 'selected="true"';}?>>Mechanical Engineering</option>
                                        <option value="8" <?php if(isset($d8) && $d8 !== ''){echo 'selected="true"';}?>>Civil Engineering</option>
                                        <option value="9" <?php if(isset($d9) && $d9 !== ''){echo 'selected="true"';}?>>Cyber & Information Security</option>
                                        <option value="10" <?php if(isset($d10) && $d10 !== ''){echo 'selected="true"';}?>>Computer Networks & Telecommunication Systems</option>
                                        <option value="11" <?php if(isset($d11) && $d11 !== ''){echo 'selected="true"';}?>>Software Engineering</option>
                                        <option value="12" <?php if(isset($d12) && $d12 !== ''){echo 'selected="true"';}?>>Agriculture & Natural Resources</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Email</label>
                                <div class="col-lg-6">
                                    <input type="text" name="email" value="<?php echo htmlspecialchars($email);?>" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Phone Number</label>
                                <div class="col-lg-6">
                                    <input type="text" name="phone" value="<?php echo htmlspecialchars($phone);?>" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <button type="submit" name="submit" value="Submit" class="btn btn-primary">Edit Student</button>
                                    <button type="submit" name="delete" value="Submit" class="btn btn-danger">Delete Student</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <div class="panel-body bio-graph-info">
                        <h1>Upload Results</h1>
                        <div class="<?php if($failed != ''){echo 'alert alert-block alert-danger';}?>">
                            <ul>
                                <?php
                                foreach($failed as $f) {
                                    echo '<li style="list-style-type:square">' . $f . '</li>';
                                }
                                ?>
                            </ul>
                        </div>
                        <div class="<?php if ($uploaded != '') {echo 'alert alert-block alert-success';}?>">
                            <?php echo $uploaded; ?>
                        </div>
                        <form class="form-horizontal" action="single-student.php?c=<?= $id; ?>" method="post" enctype="multipart/form-data">                                                  
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Academic Year</label>
                                <div class="col-lg-6">
                                    <input type="text" name="year" value="<?php echo htmlspecialchars($year);?>" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Semester</label>
                                <div class="col-lg-6">
                                    <select name="semester" class="form-control input-m m-bot15">
                                        <option value="1" selected="true">1</option>
                                        <option value="2">2</option>
                                        <option value="3">Resit</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Results</label>
                                <div class="col-lg-6">
                                    <input type="file" name="results" id="results" class="" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <button type="submit" name="upload" value="Submit" class="btn btn-primary">Upload Results</button>
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

<!-- javascripts -->
<?php include 'js/pages/scripts.php';
