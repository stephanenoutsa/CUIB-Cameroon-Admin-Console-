<?php
include 'utils/functions.php';
require_once 'utils/server_comm.php';

//Check if user is logged in
$a = is_user_logged();

// If not logged in, redirect to login page
if (!$a) {
    redirect_to('http://localhost/cuib/login.php');
} ?>
<?php require 'templates/head.php'; ?>
<?php include 'templates/header.php'; ?>
<?php include 'templates/sidebar.php'; ?>
      
        <!--main content start-->
        <section id="main-content">
            <section class="wrapper">            
                <!--overview start-->
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header"><i class="fa fa-inbox"></i>All Messages</h3>
                        <ol class="breadcrumb">
                            <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
                            <li><i class="fa fa-inbox"></i>Messages</li>
                            <li>All Messages</li>
                        </ol>
                    </div>
                </div>
                <!-- overview end -->

                <section class="panel">
                    <?php
                    $messages = get_all_messages();
                    echo '<div id="messages" class="panel-body bio-graph-info">';
                    echo '<ul>';
                    foreach ($messages as $m) {
                        $id = $m['id'];
                        $title = $m['title'];
                        $time = $m['time'];
                        echo '<a href="single-message.php?c=' . $id . '">';
                        echo '<li style="list-style:none">';
                        echo '<ol class="breadcrumb">';
                        echo '<li><b>' . $title . '</b></li>';
                        echo '<li>' . $time . '</li>';
                        echo '</ol>';
                        echo '</li>';
                        echo '</a>';
                    }
                    echo '</ul>';
                    echo '</div>';
                    ?>
                </section>
          </section>
      </section>
      <!--main content end-->
  </section>
  <!-- container section start -->
  
<?php require 'templates/footer.php'; ?>

<!-- javascripts -->
<?php include 'js/pages/scripts.php';
