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
                        <h3 class="page-header"><i class="icon_group"></i>All Lecturers</h3>
                        <ol class="breadcrumb">
                            <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
                            <li><i class="icon_group"></i>Lecturers</li>						  	
                            <li>All Lecturers</li>						  	
                        </ol>
                    </div>
                </div>
                <!-- overview end -->

                <section class="panel">
                    <?php
                    $lecturers = get_all_lecturers();
                    echo '<div id="lecturers" class="panel-body bio-graph-info">';
                    echo '<ul>';
                    foreach ($lecturers as $l) {
                        $id = $l['id'];
                        $name = $l['name'];
                        $avatar = $l['avatar'];
                        echo '<a href="single-lecturer.php?c=' . $id . '">';
                        echo '<li style="list-style:none">';
                        echo '<span class="lecturer-avatar">';
                        echo '<img alt="" src="'. $avatar . '">';
                        echo '</span>';
                        echo '<span class="lecturer-name">';
                        echo $name;
                        echo '</span>';
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

