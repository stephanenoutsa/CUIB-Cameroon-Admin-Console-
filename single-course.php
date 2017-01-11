<?php
include 'utils/functions.php';
require_once 'utils/server_comm.php';

//Check if user is logged in
$a = is_user_logged();

// If not logged in, redirect to login page
if (!$a) {
    redirect_to('http://localhost/cuib/login.php');
} ?>

<?php
$id = $_GET['c'];

if (!isset($id) || $id === '') {
    redirect_to('http://localhost/cuib/courses.php');
}

$message = array();
if (isset($_POST['submit'])) {
    // Form was submitted
    $code = strtoupper(trim(filter_input(INPUT_POST, 'code')));
    $name = trim(filter_input(INPUT_POST, 'name'));
    $description = trim(filter_input(INPUT_POST, 'description'));
    $schls = $_POST['schools'];
    $schools = array();
    $s1 = '';
    $s2 = '';
    $s3 = '';
    $s4 = '';
    foreach ($schls as $s) {
        switch ($s) {
            case "1":
                array_push($schools, "Business");
                $s1 = "Business";
                break;
            case "2":
                array_push($schools, "Engineering");
                $s2 = "Engineering";
                break;
            case "3":
                array_push($schools, "Information Technology");
                $s3 = "Information Technology";
                break;
            case "4":
                array_push($schools, "Agriculture & Natural Resources");
                $s4 = "Agriculture & Natural Resources";
                break;
        }
    }
    $depts = $_POST['departments'];
    $departments = array();
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
    foreach ($depts as $d) {
        switch ($d) {
            case "1":
                array_push($departments, "Human Resource Management");
                $d1 = "Human Resource Management";
                break;
            case "2":
                array_push($departments, "Banking and Finance");
                $d2 = "Banking and Finance";
                break;
            case "3":
                array_push($departments, "Accounting");
                $d3 = "Accounting";
                break;
            case "4":
                array_push($departments, "Marketing");
                $d4 = "Marketing";
                break;
            case "5":
                array_push($departments, "Electrical & Computer Engineering");
                $d5 = "Electrical & Computer Engineering";
                break;
            case "6":
                array_push($departments, "Chemical Engineering");
                $d6 = "Chemical Engineering";
                break;
            case "7":
                array_push($departments, "Mechanical Engineering");
                $d7 = "Mechanical Engineering";
                break;
            case "8":
                array_push($departments, "Civil Engineering");
                $d8 = "Civil Engineering";
                break;
            case "9":
                array_push($departments, "Cyber & Information Security");
                $d9 = "Cyber & Information Security";
                break;
            case "10":
                array_push($departments, "Computer Networks & Telecommunication Systems");
                $d10 = "Computer Networks & Telecommunication Systems";
                break;
            case "11":
                array_push($departments, "Software Engineering");
                $d11 = "Software Engineering";
                break;
            case "12":
                array_push($departments, "Agriculture & Natural Resources");
                $d12 = "Agriculture & Natural Resources";
                break;
        }
    }
    $lvls = $_POST['levels'];
    $levels = array();
    $l1 = '';
    $l2 = '';
    $l3 = '';
    $l4 = '';
    foreach ($lvls as $l) {
        switch ($l) {
            case "1":
                array_push($levels, "Freshman");
                $l1 = "Freshman";
                break;
            case "2":
                array_push($levels, "Sophomore");
                $l2 = "Sophomore";
                break;
            case "3":
                array_push($levels, "Junior");
                $l3 = "Junior";
                break;
            case "4":
                array_push($levels, "Senior");
                $l4 = "Senior";
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
        
        if (edit_course($id, $course)) {
            $message = '';
            $success = 'Course edited successfully';
        } else {
            array_push($message, 'There was an error editing the course.');
        }
    }
} else if (isset($_POST['delete'])) {
    if (del_course($id)) {
        $message = '';
        redirect_to('http://localhost/cuib/courses.php');
    } else {
        array_push($message, 'Failed to delete course');
    }
} else {
    // Form was not submitted
    $message = '';
    $success = '';
    $code = '';
    $name = '';
    $description = '';
    $ss = array();
    $ds = array();
    $ls = array();
    $course = get_course($id);
    if (!empty($course)) {
        $code = $course['code'];
        $name = $course['name'];
        $description = $course['description'];
        $ss = $course['schools'];
        $ds = $course['departments'];
        $ls = $course['levels'];
    }
    $s1 = '';
    $s2 = '';
    $s3 = '';
    $s4 = '';
    foreach ($ss as $s) {
        switch ($s) {
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
    }
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
    foreach ($ds as $d) {
        switch ($d) {
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
    }
    $l1 = '';
    $l2 = '';
    $l3 = '';
    $l4 = '';
    foreach ($ls as $l) {
        switch ($l) {
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
    }
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
                        <h3 class="page-header"><i class="fa fa-book"></i><?php echo $name; ?></h3>
                        <ol class="breadcrumb">
                            <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
                            <li><i class="fa fa-book"></i>Courses</li>
                            <li><?php echo $name; ?></li>						  	
                        </ol>
                    </div>
                </div>
                <!-- overview end -->

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
                    <form class="form-horizontal" action="single-course.php?c=<?= $id; ?>" method="post">                                                  
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
                                    <option value="1" <?php if(isset($s1) && $s1 !== ''){echo 'selected="true"';}?>>Business</option>
                                    <option value="2" <?php if(isset($s2) && $s2 !== ''){echo 'selected="true"';}?>>Engineering</option>
                                    <option value="3" <?php if(isset($s3) && $s3 !== ''){echo 'selected="true"';}?>>Information Technology</option>
                                    <option value="4" <?php if(isset($s4) && $s4 !== ''){echo 'selected="true"';}?>>Agriculture & Natural Resources</option>
                                </select>
                                <span class="help-block">*Press and hold 'Ctrl' then select the corresponding schools</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Departments</label>
                            <div class="col-lg-6">
                                <select name="departments[]" multiple="yes" class="form-control input-m m-bot15">
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
                                <span class="help-block">*Press and hold 'Ctrl' then select the corresponding departments</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Levels</label>
                            <div class="col-lg-6">
                                <select name="levels[]" multiple="yes" class="form-control input-m m-bot15">
                                    <option value="1" <?php if(isset($l1) && $l1 !== ''){echo 'selected="true"';}?>>Freshman</option>
                                    <option value="2" <?php if(isset($l2) && $l2 !== ''){echo 'selected="true"';}?>>Sophomore</option>
                                    <option value="3" <?php if(isset($l3) && $l3 !== ''){echo 'selected="true"';}?>>Junior</option>
                                    <option value="4" <?php if(isset($l4) && $l4 !== ''){echo 'selected="true"';}?>>Senior</option>
                                </select>
                                <span class="help-block">*Press and hold 'Ctrl' then select the corresponding levels</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button type="submit" name="submit" value="Submit" class="btn btn-primary">Edit Course</button>
                                <button type="submit" name="delete" value="Delete" class="btn btn-danger">Delete Course</button>
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