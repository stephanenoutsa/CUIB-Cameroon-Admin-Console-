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
    $bio = trim(filter_input(INPUT_POST, 'bio'));
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
    
    $dir_name = explode(' ', strtolower($name));
    $path = "uploads/lecturers/" . implode('_', $dir_name);
    $target_dir = $path . "/";
    $target_file = $target_dir . basename($_FILES['avatar']['name']);
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
    
    if (!is_dir($path)) {
        if (!mkdir($path, 0777, true)) {
            array_push($message, 'Failed to create directory for image. Please try again.');
        }
    } else {
        unlink($target_file);
    }    
    if (!isset($name) || $name === '') {
        array_push($message, 'Fill in \'Lecturer Name\' field');
    } else if (!name_valid($name)) {
        array_push($message, 'Provide at least two names');
    }
    if (getimagesize($_FILES['avatar']['tmp_name']) === false) {
        array_push($message, 'File is not an image or is too large');
    } else if ($_FILES['avatar']['size'] > 500000) {
        array_push($message, 'File is too large');
    } else if (!move_uploaded_file($_FILES['avatar']['tmp_name'], $target_file)) {
        array_push($message, 'Failed to upload image');
    }
    if (!isset($bio) || $bio === '') {
        array_push($message, 'Fill in \'Lecturer Biography\' field');
    }
    if (!isset($depts) || $depts === '') {
        array_push($message, 'Fill in \'Departments\' field');
    }
    if (!isset($lvls) || $lvls === '') {
        array_push($message, 'Fill in \'Levels\' field');
    }
    
    if (empty($message)) {        
        // Delete image if it already exists then replace it
//        if (file_exists($target_file)) {
//            unlink($target_file);
//            move_uploaded_file($_FILES['avatar']['tmp_name'], $target_file);
//        }
        
        //$avatar = 'http://' . $_SERVER['SERVER_ADDR'] . '/cuib/' . $target_file;
        $avatar = 'http://10.0.2.2/cuib/' . $target_file;
        
        $lecturer = create_json_lect($name, $avatar, $bio, $departments, $levels);
        
        if (add_lecturer($lecturer)) {
            $message = '';
            $success = 'Lecturer added successfully';
            $name = '';
            $bio = '';
            $depts = '';
            $lvls = '';
        } else {
            array_push($message, 'There was an error saving the lecturer.');
        }
    }
} else {
    // Form was not submitted
    $message = '';
    $success = '';
    $name = '';
    $avatar = '';
    $bio = '';
    $depts = '';
    $lvls = '';
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
                        <h3 class="page-header"><i class="fa fa-user"></i>Add Lecturer</h3>
                        <ol class="breadcrumb">
                            <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
                            <li><i class="fa fa-user"></i>Lecturers</li>						  	
                            <li>Add Lecturer</li>						  	
                        </ol>
                    </div>
                </div>
                <!-- overview end -->
            </section>
            
            <section class="panel">                                          
                <div class="panel-body bio-graph-info">
                    <h1>Lecturer Info</h1>
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
                    <form class="form-horizontal" action="new-lecturer.php" method="post" enctype="multipart/form-data">                                                  
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Lecturer Name</label>
                            <div class="col-lg-6">
                                <input type="text" name="name" value="<?php echo htmlspecialchars($name)?>" class="form-control" placeholder="" autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Lecturer Avatar</label>
                            <div class="col-lg-6">
                                <!-- MAX_FILE_SIZE must precede the file input field -->
                                <input type="hidden" name="MAX_FILE_SIZE" value="500000" />
                                <input type="file" name="avatar" id="avatar" class="" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Lecturer Biography</label>
                            <div class="col-lg-6">
                                <textarea name="bio" class="form-control" cols="30" rows="5"><?php echo htmlspecialchars($bio);?></textarea>
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
                                <button type="submit" name="submit" value="Submit" class="btn btn-primary">Save Lecturer</button>
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

<!-- javascripts -->
<?php include 'js/pages/scripts.php';
