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
    redirect_to('http://localhost/cuib/users.php');
}

$message = array();
if (isset($_POST['submit'])) {
    // Form was submitted
    $email = trim(filter_input(INPUT_POST, 'email'));
    $phone = trim(filter_input(INPUT_POST, 'phone'));
    $dob = trim(filter_input(INPUT_POST, 'dob'));
    $gdr = trim(filter_input(INPUT_POST, 'gender'));
    $gender = '';
    $g1 = '';
    $g2 = '';
    $g3 = '';
    switch ($gdr) {
        case "1":
            $gender = "Male";
            $g1 = "Male";
            break;
        case "2":
            $gender = "Female";
            $g2 = "Female";
            break;
        case "3":
            $gender = "Other";
            $g3 = "Other";
            break;
    }
    $rl = trim(filter_input(INPUT_POST, 'role'));
    $role = '';
    $r1 = '';
    $r2 = '';
    switch ($rl) {
        case "1":
            $role = 'Subscriber';
            $r1 = "Subscriber";
            break;
        case "2":
            $role = 'Admin';
            $r2 = "Admin";
            break;
    }
    
    if (!isset($email) || $email === '') {
        array_push($message, 'Fill in \'Email\' field');
    }
    if (!isset($phone) || $phone === '') {
        array_push($message, 'Fill in \'Phone Number\' field');
    }
    if (!isset($dob) || $dob === '') {
        array_push($message, 'Fill in \'Date of Birth\' field');
    }
    if (!isset($gender) || $gender === '') {
        array_push($message, 'Fill in \'Gender\' field');
    }
    if (!isset($role) || $role === '') {
        array_push($message, 'Select a role');
    }
    
    if (empty($message)) {
        $user = create_json_user($email, $phone, $dob, $gender, $_SESSION['user-password'], $role);
        
        if (edit_user($id, $user)) {
            $message = '';
            $success = 'User edit successfully';            
        } else {
            array_push($message, 'There was an error editing the user.');
        }
    }
} else if (isset($_POST['delete'])) {
    if (del_user($id)) {
        $message = '';
        redirect_to('http://localhost/cuib/users.php');
    } else {
        array_push($message, 'Failed to delete user');
    }
} else {
    // Form was not submitted
    $message = '';
    $success = '';
    $email = '';
    $phone = '';
    $dob = '';
    $gender = '';
    $g1 = '';
    $g2 = '';
    $g3 = '';
    $role = '';
    $r1 = '';
    $r2 = '';
    $user = get_user($id);
    if (!empty($user)) {
        $email = $user['email'];
        $phone = $user['phone'];
        $dob = $user['dob'];
        $gender = $user['gender'];
        switch ($gender) {
            case "Male":
                $g1 = "Male";
                break;
            case "Female":
                $g2 = "Female";
                break;
            case "Other":
                $g3 = "Other";
                break;
        }
        $role = $user['role'];
        switch ($role) {
            case "Subscriber":
                $r1 = "Subscriber";
                break;
            case "Admin":
                $r2 = "Admin";
                break;
        }
        $_SESSION['user-password'] = $user['password'];
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
                        <h3 class="page-header"><i class="fa fa-user"></i>User</h3>
                        <ol class="breadcrumb">
                            <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
                            <li><i class="fa fa-users"></i>Users</li>
                            <li>User</li>						  	
                        </ol>
                    </div>
                </div>
                <!-- overview end -->
                
                <section class="panel">                                          
                    <div class="panel-body bio-graph-info">
                        <h1>User Info</h1>
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
                        <form class="form-horizontal" action="single-user.php?c=<?= $id; ?>" method="post">                                                  
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Email</label>
                                <div class="col-lg-6">
                                    <input type="text" name="email" value="<?php echo htmlspecialchars($email)?>" class="form-control" placeholder="" autofocus>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Phone Number</label>
                                <div class="col-lg-6">
                                    <input type="text" name="phone" value="<?php echo htmlspecialchars($phone)?>" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Date of Birth</label>
                                <div class="col-lg-6">
                                    <input type="text" name="dob" value="<?php echo htmlspecialchars($dob)?>" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Gender</label>
                                <div class="col-lg-6">
                                    <select name="gender" class="form-control input-m m-bot15">
                                        <option value="1" <?php if(isset($g1) && $g1 !== ''){echo 'selected="true"';}?>>Male</option>
                                        <option value="2" <?php if(isset($g2) && $g2 !== ''){echo 'selected="true"';}?>>Female</option>
                                        <option value="3" <?php if(isset($g3) && $g3 !== ''){echo 'selected="true"';}?>>Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Role</label>
                                <div class="col-lg-6">
                                    <select name="role" class="form-control input-m m-bot15">
                                        <option value="1" <?php if(isset($r1) && $r1 !== ''){echo 'selected="true"';}?>>Subscriber</option>
                                        <option value="2" <?php if(isset($r2) && $r2 !== ''){echo 'selected="true"';}?>>Administrator</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <button type="submit" name="submit" value="Submit" class="btn btn-primary">Edit User</button>
                                    <button type="submit" name="delete" value="Submit" class="btn btn-danger">Delete User</button>
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
