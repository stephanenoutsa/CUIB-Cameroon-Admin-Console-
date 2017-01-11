<?php
// Start session
session_start();

// Clear session
$_SESSION = array();

require_once 'utils/functions.php';
require_once 'utils/server_comm.php';


$message = array();
if (isset($_POST['submit'])) {
    // Form was submitted
    $email = trim(filter_input(INPUT_POST, 'email'));
    $password = trim(filter_input(INPUT_POST, 'password'));

    if (!isset($email) || $email === '') {
        array_push($message, 'Fill in email field');
    }
    else if (!email_valid($email)){
        array_push($message, 'Invalid email address');
    }
    
    if (!isset($password) || $password === '') {
        array_push($message, 'Fill in password field');
    } else {
        // Hash password
        $pw = hash("sha256", $password);
        
        // Check if user exists
        $user = create_json_user($email, 'null', 'null', 'null', $pw, 'null');
        
        $result = login_user($user);
        if (empty($result)) {
            // Set session email
            $_SESSION['email'] = $email;
            
            // Redirect user to dashboard
            redirect_to('http://localhost/cuib/');
        } else {
            foreach ($result as $r) {
                array_push($message, $r);
            }
        }
    }
} else {
    // Form was not submitted
    $id = '';
    $message = '';
    $email = '';
}
?>
<?php require 'templates/head.php'; ?>

<body class="login-img3-body">

    <div class="container">
        
        <form class="login-form" action="login.php" method="post">        
            <div class="login-wrap">
                <p class="login-img"><i class="icon_lock_alt"></i></p>
                <div class="<?php if($message != ''){echo 'alert alert-block alert-danger';}?>">
                    <ul>
                        <?php
                        foreach($message as $msg) {
                            echo '<li style="list-style-type:square">' . $msg . '</li>';
                        }
                        ?>
                    </ul>
                </div>
                <div class="input-group">
                  <span class="input-group-addon"><i class="icon_profile"></i></span>
                  <input type="text" name="email" value="<?php echo htmlspecialchars($email); ?>" class="form-control" placeholder="Email" autofocus>
                </div>
                <div class="input-group">
                    <span class="input-group-addon"><i class="icon_key_alt"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="Password">
                </div>
                <label class="checkbox">
                    <span class="pull-right"> <a href="#"> Forgot Password?</a></span>
                </label>
                <button class="btn btn-primary btn-lg btn-block" type="submit" name="submit" value="Submit">Login</button>
            </div>
        </form>

    </div>

</body>
  
</html>