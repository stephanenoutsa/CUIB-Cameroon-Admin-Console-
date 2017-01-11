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
                        <h3 class="page-header"><i class="fa fa-users"></i>All Users</h3>
                        <ol class="breadcrumb">
                            <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
                            <li><i class="fa fa-users"></i>Users</li>
                            <li>All Users</li>						  	
                        </ol>
                    </div>
                </div>
                <!-- overview end -->

                <section class="panel">
                    <?php
                    $user = get_all_users();
                    echo '<div id="users" class="panel-body bio-graph-info">';
                    echo '<ul>';
                    foreach ($user as $u) {
                        $id = $u['id'];
                        $email = $u['email'];
                        $phone = $u['phone'];
                        $role = $u['role'];
                        echo '<a href="single-user.php?c=' . $id . '">';
                        echo '<li style="list-style:none">';
                        echo '<ol class="breadcrumb">';
                        echo '<li>' . $role . '</li>';
                        echo '<li>' . $email . ' (' . $phone . ')</li>';
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
