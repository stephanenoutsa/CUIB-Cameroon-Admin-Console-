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
    $email = trim(filter_input(INPUT_POST, 'email'));
    $phone = trim(filter_input(INPUT_POST, 'phone'));
    $dob = trim(filter_input(INPUT_POST, 'dob'));
    $gdr = trim(filter_input(INPUT_POST, 'gender'));
    $gender = '';
    switch ($gdr) {
        case "1":
            $gender = "Male";
            break;
        case "2":
            $gender = "Female";
            break;
        case "3":
            $gender = "Other";
            break;
    }
    $password = trim(filter_input(INPUT_POST, 'password'));
    $repassword = trim(filter_input(INPUT_POST, 'repassword'));
    $rl = trim(filter_input(INPUT_POST, 'role'));
    $role = '';
    switch ($rl) {
        case "1":
            $role .= 'Subscriber';
            break;
        case "2":
            $role .= 'Admin';
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
    if (!isset($password) || $password === '') {
        array_push($message, 'Fill in \'Password\' field');
    }
    if (!isset($repassword) || $repassword === '') {
        array_push($message, 'Fill in \'Confirm Password\' field');
    } else if ($repassword != $password) {
        array_push($message, 'Passwords don\'t match');
    }
    if (!isset($role) || $role === '') {
        array_push($message, 'Select a role');
    }
    
    if (empty($message)) {
        // Hash password
        $pw = hash("sha256", $password);
        
        $user = create_json_user($email, $phone, $dob, $gender, $pw, $role);
        
        $result = add_user($user);
        
        if (empty($result)) {
            $message = '';
            $success = 'User added successfully';
            $email = '';
            $phone = '';
            $dob = '';
            $gender = '';
            $password = '';
            $repassword = '';
            $role = '';
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
    $email = '';
    $phone = '';
    $dob = '';
    $gender = '';
    $password = '';
    $repassword = '';
    $role = '';
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
                        <h3 class="page-header"><i class="fa fa-user"></i>Add User</h3>
                        <ol class="breadcrumb">
                            <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
                            <li><i class="fa fa-users"></i>Users</li>
                            <li>Add User</li>						  	
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
                        <form class="form-horizontal" action="new-user.php" method="post">                                                  
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
                                        <option value="1" selected="true">Male</option>
                                        <option value="2">Female</option>
                                        <option value="3">Other</option>
                                    </select>
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
                                <label class="col-lg-2 control-label">Role</label>
                                <div class="col-lg-6">
                                    <select name="role" class="form-control input-m m-bot15">
                                        <option value="1" selected="true">Subscriber</option>
                                        <option value="2">Administrator</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <button type="submit" name="submit" value="Submit" class="btn btn-primary">Save User</button>
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
