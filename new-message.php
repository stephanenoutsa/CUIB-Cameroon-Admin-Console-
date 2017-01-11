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
    $title = trim(filter_input(INPUT_POST, 'title'));
    $body = trim(filter_input(INPUT_POST, 'body'));
    
    if (!isset($title) || $title === '') {
        array_push($message, 'Fill in \'Message Title\' field');
    }
    if (!isset($body) || $body === '') {
        array_push($message, 'Fill in \'Message Body\' field');
    }
    
    if (empty($message)) {
        $tokens = get_tokens();
        $errors = array();
        
        foreach ($tokens as $token) {
            $to = str_replace("\"", "", $token['name']);
            $msg = create_json_message($to, $title, $body);
            if (send_message($msg)) {
                $message = '';
                $success = 'Message sent successfully';
            } else {
                array_push($errors, 'There was an error sending the message.');
            }
        }
        
        if (!empty($errors)) {
            array_push($message, 'There was an error sending the message.');
        } else {
            // Save message in remote server
            $time = date('d-m-y h:i A');
            $m = create_json_msg($title, $body, $time);
            save_message($m);
            
            $title = '';
            $body = '';
        }
    }
} else {
    // Form was not submitted
    $message = '';
    $success = '';
    $title = '';
    $body = '';
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
                        <h3 class="page-header"><i class="fa fa-inbox"></i>Send Message</h3>
                        <ol class="breadcrumb">
                            <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
                            <li><i class="fa fa-inbox"></i>Messages</li>
                            <li>Send Message</li>
                        </ol>
                    </div>
                </div>
                <!-- overview end -->
                
                <section class="panel">                                          
                <div class="panel-body bio-graph-info">
                    <h1>Message Info</h1>
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
                    <form class="form-horizontal" action="new-message.php" method="post">                                                  
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Message Title</label>
                            <div class="col-lg-6">
                                <input type="text" name="title" value="<?php echo htmlspecialchars($title)?>" class="form-control" placeholder="" autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Message Body</label>
                            <div class="col-lg-6">
                                <textarea name="body" class="form-control" cols="30" rows="5"><?php echo htmlspecialchars($body); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button type="submit" name="submit" value="Submit" class="btn btn-primary">Send Message</button>
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
