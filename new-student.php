<?php
require_once 'utils/functions.php';
require_once 'utils/server_comm.php';

//Check if user is logged in
$a = is_user_logged();

// If not logged in, redirect to login page
if (!$a) {
    redirect_to('http://localhost/cuib/login.php');
}

$message = array();
if (isset($_POST['submit'])) {
    // Form was submitted
    $name = ucwords(trim(filter_input(INPUT_POST, 'name')));
    $matricule = trim(filter_input(INPUT_POST, 'matricule'));
    $enrolled = trim(filter_input(INPUT_POST, 'enrolled'));
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
    $email = trim(filter_input(INPUT_POST, 'email'));
    $phone = trim(filter_input(INPUT_POST, 'phone'));
    $password = trim(filter_input(INPUT_POST, 'password'));
    $repassword = trim(filter_input(INPUT_POST, 'repassword'));
    
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
    if (!isset($password) || $password === '') {
        array_push($message, 'Fill in \'Password\' field');
    }
    if (!isset($repassword) || $repassword === '') {
        array_push($message, 'Fill in \'Confirm Password\' field');
    } else if ($repassword != $password) {
        array_push($message, 'Passwords don\'t match');
    }
    
    if (empty($message)) {
        // Hash password
        $pw = hash("sha256", $password);
        
        $student = create_json_student($name, $matricule, $enrolled, $level, $school, $department, $email, $phone, $pw);
        
        $result = add_student($student);
        
        if (empty($result)) {
            $message = '';
            $success = 'Student added successfully';
            $name = '';
            $matricule = '';
            $enrolled = '';
            $level = '';
            $school = '';
            $deparmtent = '';
            $email = '';
            $phone = '';
            $password = '';
            $repassword = '';
        } else {
            foreach ($result as $r) {
                array_push($message, $r);
            }
        }
    }
} else {
    // Form was not submitted
    $message = '';
    $success = '';
    $name = '';
    $matricule = '';
    $enrolled = '';
    $level = '';
    $school = '';
    $deparmtent = '';
    $email = '';
    $phone = '';
    $password = '';
    $repassword = '';
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
                        <h3 class="page-header"><i class="fa fa-user"></i>Add Student</h3>
                        <ol class="breadcrumb">
                            <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
                            <li><i class="fa fa-user"></i>Students</li>
                            <li>Add Student</li>
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
                        <form class="form-horizontal" action="new-student.php" method="post">                                                  
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Student Name</label>
                                <div class="col-lg-6">
                                    <input type="text" name="name" value="<?php echo htmlspecialchars($name);?>" class="form-control" placeholder="" autofocus>
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
                                        <option value="1" selected="true">Freshman</option>
                                        <option value="2">Sophomore</option>
                                        <option value="3">Junior</option>
                                        <option value="4">Senior</option>
                                    </select>
                                </div>
                            </div>
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
                                <label class="col-lg-2 control-label">Password</label>
                                <div class="col-lg-6">
                                    <input type="password" name="password" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Confirm Password</label>
                                <div class="col-lg-6">
                                    <input type="password" name="repassword" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <button type="submit" name="submit" value="Submit" class="btn btn-primary">Save Student</button>
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
