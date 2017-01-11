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
    $code = strtoupper(trim(filter_input(INPUT_POST, 'code')));
    $name = ucwords(trim(filter_input(INPUT_POST, 'name')));
    $description = trim(filter_input(INPUT_POST, 'description'));
    $schls = $_POST['schools'];
    $schools = array();
    foreach ($schls as $s) {
        switch ($s) {
            case "1":
                array_push($schools, "Business");
                break;
            case "2":
                array_push($schools, "Engineering");
                break;
            case "3":
                array_push($schools, "Information Technology");
                break;
            case "4":
                array_push($schools, "Agriculture & Natural Resources");
                break;
        }
    }
    $depts = $_POST['departments'];
    $departments = array();
    foreach ($depts as $d) {
        switch ($d) {
            case "1":
                array_push($departments, "Human Resource Management");
                break;
            case "2":
                array_push($departments, "Banking and Finance");
                break;
            case "3":
                array_push($departments, "Accounting");
                break;
            case "4":
                array_push($departments, "Marketing");
                break;
            case "5":
                array_push($departments, "Electrical & Computer Engineering");
                break;
            case "6":
                array_push($departments, "Chemical Engineering");
                break;
            case "7":
                array_push($departments, "Mechanical Engineering");
                break;
            case "8":
                array_push($departments, "Civil Engineering");
                break;
            case "9":
                array_push($departments, "Cyber & Information Security");
                break;
            case "10":
                array_push($departments, "Computer Networks & Telecommunication Systems");
                break;
            case "11":
                array_push($departments, "Software Engineering");
                break;
            case "12":
                array_push($departments, "Agriculture & Natural Resources");
                break;
        }
    }
    $lvls = $_POST['levels'];
    $levels = array();
    foreach ($lvls as $l) {
        switch ($l) {
            case "1":
                array_push($levels, "Freshman");
                break;
            case "2":
                array_push($levels, "Sophomore");
                break;
            case "3":
                array_push($levels, "Junior");
                break;
            case "4":
                array_push($levels, "Senior");
                break;
        }
    }
    
    if (!isset($code) || $code === '') {
        array_push($message, 'Fill in \'Course Code\' field');
    }
    if (!isset($name) || $name === '') {
        array_push($message, 'Fill in \'Course Name\' field');
    }
    if (!isset($description) || $description === '') {
        array_push($message, 'Fill in \'Course Description\' field');
    }
    if (!isset($schls) || $schls === '') {
        array_push($message, 'Fill in \'Schools\' field');
    }
    if (!isset($depts) || $depts === '') {
        array_push($message, 'Fill in \'Departments\' field');
    }
    if (!isset($lvls) || $lvls === '') {
        array_push($message, 'Fill in \'Levels\' field');
    }
    
    if (empty($message)) {
        $course = create_json_course($code, $name, $description, $schools, $departments, $levels);
        
        if (add_course($course)) {
            $message = '';
            $success = 'Course added successfully';
            $code = '';
            $name = '';
            $description = '';
            $schools = '';
            $departments = '';
            $levels = '';
        } else {
            array_push($message, 'There was an error saving the course. Ensure that it was not previously saved!');
        }
    }
} else {
    // Form was not submitted
    $message = '';
    $success = '';
    $code = '';
    $name = '';
    $description = '';
    $schools = '';
    $departments = '';
    $levels = '';
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
                        <h3 class="page-header"><i class="fa fa-book"></i>Add Course</h3>
                        <ol class="breadcrumb">
                            <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
                            <li><i class="fa fa-book"></i>Courses</li>
                            <li>Add Course</li>
                        </ol>
                    </div>
                </div>
                <!-- overview end -->
            </section>
            
            <section class="panel">                                          
                <div class="panel-body bio-graph-info">
                    <h1>Course Info</h1>
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
                    <form class="form-horizontal" action="new-course.php" method="post">                                                  
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Course Code</label>
                            <div class="col-lg-6">
                                <input type="text" name="code" value="<?php echo htmlspecialchars($code)?>" class="form-control" placeholder="" autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Course Name</label>
                            <div class="col-lg-6">
                                <input type="text" name="name" value="<?php echo htmlspecialchars($name)?>" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Course Description</label>
                            <div class="col-lg-6">
                                <textarea name="description" class="form-control" cols="30" rows="5"><?php echo htmlspecialchars($description);?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Schools</label>
                            <div class="col-lg-6">
                                <select name="schools[]" multiple="yes" class="form-control input-m m-bot15">
                                    <option value="1" selected="true">Business</option>
                                    <option value="2">Engineering</option>
                                    <option value="3">Information Technology</option>
                                    <option value="4">Agriculture & Natural Resources</option>
                                </select>
                                <span class="help-block">*Press and hold 'Ctrl' then select the corresponding schools</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Departments</label>
                            <div class="col-lg-6">
                                <select name="departments[]" multiple="yes" class="form-control input-m m-bot15">
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
                                <span class="help-block">*Press and hold 'Ctrl' then select the corresponding departments</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Levels</label>
                            <div class="col-lg-6">
                                <select name="levels[]" multiple="yes" class="form-control input-m m-bot15">
                                    <option value="1" selected="true">Freshman</option>
                                    <option value="2">Sophomore</option>
                                    <option value="3">Junior</option>
                                    <option value="4">Senior</option>
                                </select>
                                <span class="help-block">*Press and hold 'Ctrl' then select the corresponding levels</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button type="submit" name="submit" value="Submit" class="btn btn-primary">Save Course</button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </section>
        <!--main content end-->
</section>
<!-- container section start -->
  
<?php require 'templates/footer.php'; ?>

<!-- load scripts -->
<?php include 'js/pages/scripts.php';
