<!--sidebar start-->
<?php
// Get the uri of the current page
$uri = $_SERVER['REQUEST_URI'];
$id = $_GET['c'];

switch ($uri) {
    case '/cuib/':
        $a = true;
        break;
    case '/cuib/index.php':
        $a = true;
        break;
    case '/cuib/students.php':
        $b = true;
        break;
    case '/cuib/new-student.php':
        $b = true;
        break;
    case '/cuib/single-student.php?c=' . $id:
        $b = true;
        break;
    case '/cuib/courses.php':
        $c = true;
        break;
    case '/cuib/new-course.php':
        $c = true;
        break;
    case '/cuib/single-course.php?c=' . $id:
        $c = true;
        break;
    case '/cuib/lecturers.php':
        $d = true;
        break;
    case '/cuib/new-lecturer.php':
        $d = true;
        break;
    case '/cuib/single-lecturer.php?c=' . $id:
        $d = true;
        break;
    case '/cuib/messages.php':
        $e = true;
        break;
    case '/cuib/new-message.php':
        $e = true;
        break;
    case '/cuib/single-message.php?c=' . $id:
        $e = true;
        break;
    case '/cuib/timetable.php':
        $f = true;
        break;
    case '/cuib/users.php':
        $g = true;
        break;
    case '/cuib/new-user.php':
        $g = true;
        break;
    case '/cuib/single-user.php?c=' . $id:
        $g = true;
        break;
    case '/cuib/payments.php':
        $h = true;
        break;
    case 'cuib/single-payment.php?c=' . $id:
        $h = true;
        break;
}
?>

<aside>
    <div id="sidebar"  class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu">                
            <li class="<?php if (isset($a) && $a == true) {echo 'active';} else {echo 'sub-menu';}?>">
                <a class="" href="index.php">
                    <i class="icon_house_alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            
            <li class="<?php if (isset($b) && $b == true) {echo 'active';} else {echo 'sub-menu';}?>">
                <a href="javascript:;" class="">
                    <i class="fa fa-users"></i>
                    <span>Students</span>
                    <span class="menu-arrow arrow_carrot-right"></span>
                </a>
                <ul class="sub">
                    <li><a class="" href="students.php">All Students</a></li>
                    <li><a class="" href="new-student.php">New Student</a></li>
                </ul>
            </li>
            
            <li class="<?php if (isset($c) && $c == true) {echo 'active';} else {echo 'sub-menu';}?>">
                <a href="javascript:;" class="">
                    <i class="fa fa-book"></i>
                    <span>Courses</span>
                    <span class="menu-arrow arrow_carrot-right"></span>
                </a>
                <ul class="sub">
                    <li><a class="" href="courses.php">All Courses</a></li>
                    <li><a class="" href="new-course.php">New Course</a></li>
                </ul>
            </li>
            
            <li class="<?php if (isset($d) && $d == true) {echo 'active';} else {echo 'sub-menu';}?>">
                <a href="javascript:;" class="">
                    <i class="icon_group"></i>
                    <span>Lecturers</span>
                    <span class="menu-arrow arrow_carrot-right"></span>
                </a>
                <ul class="sub">
                    <li><a class="" href="lecturers.php">All Lecturers</a></li>
                    <li><a class="" href="new-lecturer.php">New Lecturer</a></li>
                </ul>
            </li>
            
            <li class="<?php if (isset($e) && $e == true) {echo 'active';} else {echo 'sub-menu';}?>">
                <a href="javascript:;" class="">
                    <i class="fa fa-inbox"></i>
                    <span>Messages</span>
                    <span class="menu-arrow arrow_carrot-right"></span>
                </a>
                <ul class="sub">
                    <li><a class="" href="messages.php">All Messages</a></li>
                    <li><a class="" href="new-message.php">New Message</a></li>
                </ul>
            </li>
            
            <li class="<?php if (isset($f) && $f == true) {echo 'active';} else {echo 'sub-menu';}?>">
                <a class="" href="timetable.php">
                    <i class="icon_document_alt"></i>
                    <span>Timetable</span>
                </a>
            </li>
            
            <li class="<?php if (isset($g) && $g == true) {echo 'active';} else {echo 'sub-menu';}?>">
                <a href="javascript:;" class="">
                    <i class="fa fa-users"></i>
                    <span>Users</span>
                    <span class="menu-arrow arrow_carrot-right"></span>
                </a>
                <ul class="sub">
                    <li><a class="" href="users.php">All Users</a></li>
                    <li><a class="" href="new-user.php">New User</a></li>
                </ul>
            </li>
            
            <li class="<?php if (isset($h) && $h == true) {echo 'active';} else {echo 'sub-menu';}?>">
                <a class="" href="payments.php">
                    <i class="fa fa-credit-card"></i>
                    <span>Payments</span>
                </a>
            </li>

        </ul>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->