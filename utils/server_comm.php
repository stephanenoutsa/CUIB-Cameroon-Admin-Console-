<?php
//$_SESSION['url'] = 'http://192.168.43.210:8080/cuib/webapi/';
$_SESSION['url'] = 'http://127.0.0.1:8080/cuib/webapi/';

/**
 * Start of functions for User model
 * 
 * @param type $user
 * @return boolean
 */
// Check if user exists in remote server
function login_user($user) {
    $message = array();
    
    $url = $_SESSION['url'];
    $curl = curl_init($url . 'users/check/login');
    //curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $user);
    //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //curl error SSL certificate problem, verify that the CA cert is OK

    $result = curl_exec($curl);
    $u = json_decode($result, true);
    $eml = $u['email'];
    $phn = $u['phone'];
    $dob = $u['dob'];
    $gdr = $u['gender'];
    $pw = $u['password'];
    $rl = $u['role'];
    
    if (curl_errno($curl)) {
        array_push($message, "Host unreachable. Check your network and try again.");
    } else if ($eml === "null" && $phn === "null" && $dob === "null" && $gdr === "null"
            && $pw === "null" && $rl === "null") {
        array_push($message, "Email or password incorrect.");
    } else if (trim($rl) == "Subscriber") {
        array_push($message, 'Sorry, you do not have the required privileges!');
    }
    
    return $message;
}

// Add user to remote server
function add_user($user) {
    $message = array();
    
    $url = $_SESSION['url'];
    $curl = curl_init($url . 'users');
    //curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $user);
    //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //curl error SSL certificate problem, verify that the CA cert is OK

    $result = curl_exec($curl);
    $u = json_decode($result, true);
    $eml = $u['email'];
    $phn = $u['phone'];
    $dob = $u['dob'];
    $gdr = $u['gender'];
    $pw = $u['password'];
    $rl = $u['role'];
    
    if (curl_errno($curl)) {
        array_push($message, "Host unreachable. Check your network and try again.");
    } else if ($eml === "null" && $phn === "null" && $dob === "null" && $gdr === "null"
            && $pw === "null" && $rl === "null") {
        array_push($message, "User already exists!");
    }
    
    return $message;
}

// Get all users from remote server
function get_all_users() {
    $url = $_SESSION['url'];
    $curl = curl_init($url . 'users');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));

    $result = curl_exec($curl);
    
    if (curl_errno($curl)) {
        $users = array();
        return $users;
    }
    
    $users = json_decode($result, true);
    
    return $users;
}

// Get single user from remote server
function get_user($id) {
    $url = $_SESSION['url'];
    $curl = curl_init($url . 'users/' . $id);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt( $curl, CURLOPT_CUSTOMREQUEST, 'GET' );

    $result = curl_exec($curl);
    
    if (curl_errno($curl)) {
        $user = array();
        return $user;
    }
    
    $user = json_decode($result, true);
    
    return $user;
}

// Update user in remote server
function edit_user($id, $user) {
    $ok = true;
    
    $url = $_SESSION['url'];
    $curl = curl_init($url . 'users/' . $id);
    //curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($curl, CURLOPT_POSTFIELDS, $user);
    //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //curl error SSL certificate problem, verify that the CA cert is OK

    curl_exec($curl);
    
    if (curl_errno($curl)) {
        $ok = false;
    }
    
    return $ok;
}

// Delete user in remote server
function del_user($id) {
    $ok = true;
    
    $url = $_SESSION['url'];
    $curl = curl_init($url . 'users/' . $id);
    //curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
    //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //curl error SSL certificate problem, verify that the CA cert is OK

    curl_exec($curl);
    
    if (curl_errno($curl)) {
        $ok = false;
    }
    
    return $ok;
}
/**
 * End of functions for User model
 */



/**
 * Start of functions for Student model
 */
// Add student to remote server
function add_student($student) {
    $message = array();
    
    $url = $_SESSION['url'];
    $curl = curl_init($url . 'students');
    //curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $student);
    //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //curl error SSL certificate problem, verify that the CA cert is OK

    $result = curl_exec($curl);
    $s = json_decode($result, true);
    $nm = $s['name'];
    $mtr = $s['matricule'];
    $enr = $s['enrolled'];
    $lvl = $s['level'];
    $sch = $s['school'];
    $dpt = $s['department'];
    $eml = $s['email'];
    $phn = $s['phone'];
    $pw = $s['password'];
    
    if (curl_errno($curl)) {
        array_push($message, "Host unreachable. Check your network and try again.");
    } else if ($nm !== "null" && $mtr !== "null" && $enr !== "null" && $lvl !== "null"
            && $sch !== "null" && $dpt !== "null" && $eml !== "null" && $phn !== "null"
            && $pw !== "null") {
        array_push($message, "Student already exists!");
    }
    
    return $message;
}

// Get students from remote server
function get_students($dept, $level) {
    $url = $_SESSION['url'];
    $curl = curl_init($url . 'students/' . urlencode($dept) . '/' . $level);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt( $curl, CURLOPT_CUSTOMREQUEST, 'GET' );

    $result = curl_exec($curl);
    
    if (curl_errno($curl)) {
        $students = array();
        return $students;
    }
    
    $students = json_decode($result, true);
    
    return $students;
}

// Get single student from remote server
function get_student($id) {
    $url = $_SESSION['url'];
    $curl = curl_init($url . 'students/' . $id);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt( $curl, CURLOPT_CUSTOMREQUEST, 'GET' );

    $result = curl_exec($curl);
    
    if (curl_errno($curl)) {
        $student = array();
        return $student;
    }
    
    $student = json_decode($result, true);
    
    return $student;
}

// Update student in remote server
function edit_student($id, $student) {
    $ok = true;
    
    $url = $_SESSION['url'];
    $curl = curl_init($url . 'students/' . $id);
    //curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($curl, CURLOPT_POSTFIELDS, $student);
    //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //curl error SSL certificate problem, verify that the CA cert is OK

    curl_exec($curl);
    
    if (curl_errno($curl)) {
        $ok = false;
    }
    
    return $ok;
}

// Delete student in remote server
function del_student($id) {
    $ok = true;
    
    $url = $_SESSION['url'];
    $curl = curl_init($url . 'students/' . $id);
    //curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
    //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //curl error SSL certificate problem, verify that the CA cert is OK

    curl_exec($curl);
    
    if (curl_errno($curl)) {
        $ok = false;
    }
    
    return $ok;
}
/**
 * End of functions for Student model
 */



/**
 * Start of functions for Course model
 */
// Add course to remote server
function add_course($course) {
    $ok = true;
    
    $url = $_SESSION['url'];
    $curl = curl_init($url . 'courses');
    //curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $course);
    //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //curl error SSL certificate problem, verify that the CA cert is OK

    $result = curl_exec($curl);
    $c = json_decode($result, true);
    $cd = $c['code'];
    $nm = $c['name'];
    $ds = $c['description'];
    
    if (curl_errno($curl)) {
        $ok = false;
    } else if ($cd !== "null" && $nm !== "null" && $ds !== "null") {
        $ok = false;
    }
    
    return $ok;
}

// Get courses from remote server
function get_courses($dept, $level) {
    $url = $_SESSION['url'];
    $curl = curl_init($url . 'courses/' . urlencode($dept) . '/' . $level);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt( $curl, CURLOPT_CUSTOMREQUEST, 'GET' );

    $result = curl_exec($curl);
    
    if (curl_errno($curl)) {
        $courses = array();
        return $courses;
    }
    
    $courses = json_decode($result, true);
    
    return $courses;
}

// Get single course from remote server
function get_course($id) {
    $url = $_SESSION['url'];
    $curl = curl_init($url . 'courses/' . $id);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt( $curl, CURLOPT_CUSTOMREQUEST, 'GET' );

    $result = curl_exec($curl);
    
    if (curl_errno($curl)) {
        $course = array();
        return $course;
    }
    
    $course = json_decode($result, true);
    
    return $course;
}

// Update course in remote server
function edit_course($id, $course) {
    $ok = true;
    
    $url = $_SESSION['url'];
    $curl = curl_init($url . 'courses/' . $id);
    //curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($curl, CURLOPT_POSTFIELDS, $course);
    //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //curl error SSL certificate problem, verify that the CA cert is OK

    curl_exec($curl);
    
    if (curl_errno($curl)) {
        $ok = false;
    }
    
    return $ok;
}

// Delete course in remote server
function del_course($id) {
    $ok = true;
    
    $url = $_SESSION['url'];
    $curl = curl_init($url . 'courses/' . $id);
    //curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
    //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //curl error SSL certificate problem, verify that the CA cert is OK

    curl_exec($curl);
    
    if (curl_errno($curl)) {
        $ok = false;
    }
    
    return $ok;
}
/**
 * End of functions for Course model
 */



/**
 * Start of functions for Lecturer model
 */
// Add lecturer to remoter server
function add_lecturer($lecturer) {
    $ok = true;
    
    $url = $_SESSION['url'];
    $curl = curl_init($url . 'lecturers');
    //curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $lecturer);
    //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //curl error SSL certificate problem, verify that the CA cert is OK

    curl_exec($curl);
    
    if (curl_errno($curl)) {
        $ok = false;
    }
    
    return $ok;
}

// Get lecturers from remote server
function get_all_lecturers() {
    $url = $_SESSION['url'];
    $curl = curl_init($url . 'lecturers');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt( $curl, CURLOPT_CUSTOMREQUEST, 'GET' );

    $result = curl_exec($curl);
    
    if (curl_errno($curl)) {
        $lecturers = array();
        return $lecturers;
    }
    
    $lecturers = json_decode($result, true);
    
    return $lecturers;
}

// Get single lecturer from remote server
function get_lecturer($id) {
    $url = $_SESSION['url'];
    $curl = curl_init($url . 'lecturers/' . $id);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt( $curl, CURLOPT_CUSTOMREQUEST, 'GET' );

    $result = curl_exec($curl);
    
    if (curl_errno($curl)) {
        $lecturer = array();
        return $lecturer;
    }
    
    $lecturer = json_decode($result, true);
    
    return $lecturer;
}

// Update lecturer in remote server
function edit_lecturer($id, $lecturer) {
    $ok = true;
    
    $url = $_SESSION['url'];
    $curl = curl_init($url . 'lecturers/' . $id);
    //curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($curl, CURLOPT_POSTFIELDS, $lecturer);
    //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //curl error SSL certificate problem, verify that the CA cert is OK

    curl_exec($curl);
    
    if (curl_errno($curl)) {
        $ok = false;
    }
    
    return $ok;
}

// Delete lecturer in remote server
function del_lecturer($id) {
    $ok = true;
    
    $url = $_SESSION['url'];
    $curl = curl_init($url . 'lecturers/' . $id);
    //curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
    //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //curl error SSL certificate problem, verify that the CA cert is OK

    curl_exec($curl);
    
    if (curl_errno($curl)) {
        $ok = false;
    }
    
    return $ok;
}
/**
 * End of functions for Lecturer model
 */

/**
 * Start of functions for Timetable model
 */
// Add timetable to remoter server
function add_timetable($timetable) {
    $ok = true;
    
    $url = $_SESSION['url'];
    $curl = curl_init($url . 'timetables');
    //curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $timetable);
    //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //curl error SSL certificate problem, verify that the CA cert is OK

    curl_exec($curl);
    
    if (curl_errno($curl)) {
        $ok = false;
    }
    
    return $ok;
}

// Get timetables from remote server
function get_all_timetables() {
    $url = $_SESSION['url'];
    $curl = curl_init($url . 'timetables');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt( $curl, CURLOPT_CUSTOMREQUEST, 'GET' );

    $result = curl_exec($curl);
    
    if (curl_errno($curl)) {
        $timetables = array();
        return $timetables;
    }
    
    $timetables = json_decode($result, true);
    
    return $timetables;
}

// Get single timetable from remote server
function get_timetable($dept, $level) {
    $url = $_SESSION['url'];
    $curl = curl_init($url . 'timetables/' . urlencode($dept) . '/' . $level);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt( $curl, CURLOPT_CUSTOMREQUEST, 'GET' );

    $result = curl_exec($curl);
    
    if (curl_errno($curl)) {
        $timetable = array();
        return $timetable;
    }
    
    $timetable = json_decode($result, true);
    
    return $timetable;
}

// Update timetable in remote server
function edit_timetable($id, $timetable) {
    $ok = true;
    
    $url = $_SESSION['url'];
    $curl = curl_init($url . 'timetables/' . $id);
    //curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($curl, CURLOPT_POSTFIELDS, $timetable);
    //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //curl error SSL certificate problem, verify that the CA cert is OK

    curl_exec($curl);
    
    if (curl_errno($curl)) {
        $ok = false;
    }
    
    return $ok;
}

// Delete timetable in remote server
function del_timetable($id) {
    $ok = true;
    
    $url = $_SESSION['url'];
    $curl = curl_init($url . 'timetables/' . $id);
    //curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
    //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //curl error SSL certificate problem, verify that the CA cert is OK

    curl_exec($curl);
    
    if (curl_errno($curl)) {
        $ok = false;
    }
    
    return $ok;
}
/**
 * End of functions for Timetable model
 */



/**
 * Start of functions for Messages
 */
// Send message to users
function send_message($message) {
    $ok = true;
    
    $url = "https://fcm.googleapis.com/fcm/send";
    $curl = curl_init($url);
    //curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array(
                "Content-type: application/json",
                "Authorization: key= AIzaSyAveKYjIqLxYVTMf9F_0sJ01Ci9aLrWF3c"
                ));
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $message);
    //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //curl error SSL certificate problem, verify that the CA cert is OK

    $returned = curl_exec($curl);
    $result = json_decode($returned, true);
    $success = $result['success'];
    $failure = $result['failure'];
    
    if (curl_errno($curl)) {
        $ok = false;
    } else if ($success == 0 || $failure == 1) {
        $ok = false;
    }
    
    return $ok;
}

// Save message in remote server
function save_message($message) {
    $ok = true;
    
    $url = $_SESSION['url'];
    $curl = curl_init($url . 'messages');
    //curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $message);
    //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //curl error SSL certificate problem, verify that the CA cert is OK

    curl_exec($curl);
    
    if (curl_errno($curl)) {
        $ok = false;
    }
    
    return $ok;
}

// Get all messages from remote server
function get_all_messages() {
    $url = $_SESSION['url'];
    $curl = curl_init($url . 'messages');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt( $curl, CURLOPT_CUSTOMREQUEST, 'GET' );

    $result = curl_exec($curl);
    
    if (curl_errno($curl)) {
        $messages = array();
        return $messages;
    }
    
    $messages = json_decode($result, true);
    
    return $messages;
}

// Get single message from remote server
function get_message($id) {
    $url = $_SESSION['url'];
    $curl = curl_init($url . 'messages/' . $id);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt( $curl, CURLOPT_CUSTOMREQUEST, 'GET' );

    $result = curl_exec($curl);
    
    if (curl_errno($curl)) {
        $message = array();
        return $message;
    }
    
    $message = json_decode($result, true);
    
    return $message;
}

// Delete message from remote server
function del_message($id) {
    $ok = true;
    
    $url = $_SESSION['url'];
    $curl = curl_init($url . 'messages/' . $id);
    //curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
    //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //curl error SSL certificate problem, verify that the CA cert is OK

    curl_exec($curl);
    
    if (curl_errno($curl)) {
        $ok = false;
    }
    
    return $ok;
}
/**
 * End of functions for Messages
 */



/**
 * Start of functions for tokens
 */
// Get tokens from remote server
function get_tokens() {
    $url = $_SESSION['url'];
    $curl = curl_init($url . 'tokens');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));

    $result = curl_exec($curl);
    $tokens = json_decode($result, true);
    
    return $tokens;
}
/**
 * End of functions for tokens
 */

/**
 * Start of functions for Results model
 */
// Add results to remoter server
function add_results($results) {
    $ok = true;
    
    $url = $_SESSION['url'];
    $curl = curl_init($url . 'results');
    //curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $results);
    //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //curl error SSL certificate problem, verify that the CA cert is OK

    curl_exec($curl);
    
    if (curl_errno($curl)) {
        $ok = false;
    }
    
    return $ok;
}
/**
 * End of functions for Results model
 */

/**
 * Start of functions for Payment model
 */
// Get all payments from remote server
function get_all_payments() {
    $url = $_SESSION['url'];
    $curl = curl_init($url . 'payments');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));

    $result = curl_exec($curl);
    $payments = json_decode($result, true);
    
    return $payments;
}

// Get single payment from remote server
function get_payment($id) {
    $url = $_SESSION['url'];
    $curl = curl_init($url . 'payments/' . $id);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt( $curl, CURLOPT_CUSTOMREQUEST, 'GET' );

    $result = curl_exec($curl);
    
    if (curl_errno($curl)) {
        $payment = array();
        return $payment;
    }
    
    $payment = json_decode($result, true);
    
    return $payment;
}
/**
 * End of functions for Payment model
 */