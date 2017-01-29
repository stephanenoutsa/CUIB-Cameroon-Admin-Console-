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
                        <h3 class="page-header"><i class="fa fa-credit-card"></i>All Payments</h3>
                        <ol class="breadcrumb">
                            <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
                            <li><i class="fa fa-credit-card"></i>Payments</li>
                            <li>All Payments</li>						  	
                        </ol>
                    </div>
                </div>
                <!-- overview end -->

                <section class="panel">
                    <?php
                    $payments = get_all_payments();
                    $pays = array_reverse($payments);
                    echo '<div id="payments" class="panel-body bio-graph-info">';
                    echo 'Count: <b>' . sizeof($payments) . '</b><br>';
                    echo 'Expected revenue: <b>' . expected_revenue(sizeof($payments)) . ' FCFA</b>';
                    if (empty($payments)) {
                        echo '<ul>';
                        echo '<ol class="breadcrumb">';
                        echo '<li>No payments to display!</li>';
                        echo '</ol>';
                    } else {
                        echo '<ul>';
                        foreach ($pays as $p) {
                            $id = $p['id'];
                            $date = $p['date'];
                            $amount = $p['amount'];
                            $type = $p['type'];
                            $school = $p['school'];
                            echo '<a href="single-payment.php?c=' . $id . '">';
                            echo '<li style="list-style:none">';
                            echo '<ol class="breadcrumb">';
                            echo '<li>' . $type . ' (' . $date . ')</li>';
                            echo '</ol>';
                            echo '</li>';
                            echo '</a>';
                        }
                        echo '</ul>';
                    }
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
