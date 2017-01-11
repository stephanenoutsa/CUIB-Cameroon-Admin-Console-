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
    redirect_to('http://localhost/cuib/lecturers.php');
}

$message = array();
if (isset($_POST['submit'])) {
    // Form was submitted
    $name = ucwords(trim(filter_input(INPUT_POST, 'name')));
    $bio = trim(filter_input(INPUT_POST, 'bio'));
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
        $avatar = 'http://192.168.43.170/cuib/' . $target_file;
        
        $lecturer = create_json_lect($name, $avatar, $bio, $departments, $levels);
        
        if (edit_lecturer($id, $lecturer)) {
            $message = '';
            $success = 'Lecturer edited successfully';
        } else {
            array_push($message, 'There was an error editing the lecturer.');
        }
    }
} else if (isset($_POST['delete'])) {
    if (del_lecturer($id)) {
        $message = '';
        redirect_to('http://localhost/cuib/lecturers.php');
    } else {
        array_push($message, 'Failed to delete lecturer');
    }
} else {
    // Form was not submitted
    $message = '';
    $success = '';
    $name = '';
    $avatar = '';
    $bio = '';
    $ds = array();
    $ls = array();
    $lecturer = get_lecturer($id);
    if (!empty($lecturer)) {
        $name = $lecturer['name'];
        $avatar = $lecturer['avatar'];
        $bio = $lecturer['bio'];
        $ds = $lecturer['departments'];
        $ls = $lecturer['levels'];
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
                        <h3 class="page-header"><i class="fa fa-user"></i><?= $name; ?></h3>
                        <ol class="breadcrumb">
                            <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
                            <li><i class="fa fa-user"></i>Lecturers</li>
                            <li><?= $name; ?></li>
                        </ol>
                    </div>
                </div>
                <!-- overview end -->

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
                        <form class="form-horizontal" action="single-lecturer.php?c=<?= $id; ?>" method="post" enctype="multipart/form-data">                                                  
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
                                    <button type="submit" name="submit" value="Submit" class="btn btn-primary">Edit Lecturer</button>
                                    <button type="submit" name="delete" value="Submit" class="btn btn-danger">Delete Lecturer</button>
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
