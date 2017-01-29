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
    redirect_to('http://localhost/cuib/payments.php');
}

$date = '';
$amount = '';
$type = '';
$school = '';
$payment = get_payment($id);
if (!empty($payment)) {
    $date = $payment['date'];
    $amount = $payment['amount'];
    $type = $payment['type'];
    $school = $payment['school'];
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
                        <h3 class="page-header"><i class="fa fa-credit-card"></i>Payment</h3>
                        <ol class="breadcrumb">
                            <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
                            <li><i class="fa fa-credit-card"></i>Payments</li>
                            <li>Payment</li>
                        </ol>
                    </div>
                </div>
                <!-- overview end -->
                
                <section class="panel">                                          
                <div class="panel-body bio-graph-info">
                    <h1>Payment Info</h1>
                    <form class="form-horizontal" action="single-payment.php?c=<?= $id; ?>" method="post">                                          
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Date</label>
                            <div class="col-lg-6">
                                <input readonly="true" type="text" name="time" value="<?php echo htmlspecialchars($date)?>" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Amount</label>
                            <div class="col-lg-6">
                                <input readonly="true" type="text" name="title" value="<?php echo htmlspecialchars($amount)?>" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Type</label>
                            <div class="col-lg-6">
                                <input readonly="true" type="text" name="title" value="<?php echo htmlspecialchars($type)?>" class="form-control" placeholder="">
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