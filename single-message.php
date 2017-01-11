<?php
include 'utils/functions.php';
require_once 'utils/server_comm.php';

//Check if user is logged in
$a = is_user_logged();

// If not logged in, redirect to login page
if (!$a) {
    redirect_to('http://localhost/cuib/login.php');
}

$id = $_GET['c'];

if (!isset($id) || $id === '') {
    redirect_to('http://localhost/cuib/messages.php');
}

$message = array();
if (isset($_POST['delete'])) {
    if (del_message($id)) {
        $message = '';
        redirect_to('http://localhost/cuib/messages.php');
    } else {
        array_push($message, 'Failed to delete message');
    }
} else {
    $message = '';
    $time = '';
    $title = '';
    $body = '';
    $m = get_message($id);
    if (!empty($m)) {
        $time = $m['time'];
        $title = $m['title'];
        $body = $m['body'];
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
                        <h3 class="page-header"><i class="fa fa-inbox"></i>Message</h3>
                        <ol class="breadcrumb">
                            <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
                            <li><i class="fa fa-inbox"></i>Messages</li>
                            <li>Message</li>
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
                    <form class="form-horizontal" action="single-message.php?c=<?= $id; ?>" method="post">                                          
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Sent</label>
                            <div class="col-lg-6">
                                <input readonly="true" type="text" name="time" value="<?php echo htmlspecialchars($time)?>" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Message Title</label>
                            <div class="col-lg-6">
                                <input readonly="true" type="text" name="title" value="<?php echo htmlspecialchars($title)?>" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Message Body</label>
                            <div class="col-lg-6">
                                <textarea readonly="true" name="body" class="form-control" cols="30" rows="5"><?php echo htmlspecialchars($body); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button type="submit" name="delete" value="Submit" class="btn btn-danger">Delete Message</button>
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