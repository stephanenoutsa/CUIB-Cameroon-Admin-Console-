<?php
include 'utils/functions.php';
require_once 'utils/server_comm.php';

//Check if user is logged in
$a = is_user_logged();

// If not logged in, redirect to login page
if (!$a) {
    redirect_to('http://localhost/cuib/login.php');
} ?>

<?php
$schools['Business'] = ['Human Resource Management', 'Banking and Finance', 'Accounting', 'Marketing'];
$schools['Engineering'] = ['Electrical & Computer Engineering', 'Chemical Engineering',
    'Mechanical Engineering', 'Civil Engineering'];
$schools['Information Technology'] = ['Cyber & Information Security', 'Computer Networks '
    . '& Telecommunication Systems', 'Software Engineering'];
$schools['Agriculture & Natural Resources'] = ['Agriculture & Natural Resources'];

$levels = ['Freshman', 'Sophomore', 'Junior', 'Senior'];
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
                        <h3 class="page-header"><i class="fa fa-book"></i>All Courses</h3>
                        <ol class="breadcrumb">
                            <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
                            <li><i class="fa fa-book"></i>Courses</li>
                            <li>All Courses</li>						  	
                        </ol>
                    </div>
                </div>
                <!-- overview end -->

                <section class="panel">
                    <?php
                    foreach ($schools as $school => $department) {
                        echo '<div class="panel-body bio-graph-info">';
                        echo '<h1>' . $school . '</h1>';
                        echo '<ul>';
                        foreach ($levels as $level) {
                            echo '<li><b>' . $level . '</b></li>';
                            echo '<ul>';
                            foreach ($department as $dept) {
                                echo '<li style="list-style-type:square">' . $dept . '</li>';
                                echo '<ul>';
                                $courses = get_courses($dept, $level);
                                if (!empty($courses)) {
                                    foreach ($courses as $course) {
                                        echo '<li>';
                                        $id = $course['id'];
                                        $code = $course['code'];
                                        $name = $course['name'];
                                        echo '<a href="single-course.php?c='. $id . '">';
                                        echo '<ol class="breadcrumb">';
                                        echo '<li>' . $code . '</li>';
                                        echo '<li>' . $name . '</li>';
                                        echo '</ol>';
                                        echo '</a>';
                                        echo '</li>';
                                    }
                                } else {
                                    echo '<li>No Courses to display</li>';
                                }
                                echo '</ul>';
                            }
                            echo '</ul><br>';
                        }
                        echo '</ul>';
                        echo '</div>';
                    }
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

