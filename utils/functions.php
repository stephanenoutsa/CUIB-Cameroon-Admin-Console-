<?php
// Start session
session_start();

// Check if email address is valid
function email_valid($email) {
    $ok = true;
    
    // Check if email is well formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $ok = false;
    }
    
    return $ok;
}

// Check if user is logged in
function is_user_logged() {
    if (isset($_SESSION['email'])) {
        return true;
    } else {
        return false;
    }
}

// Redirect to new web page
function redirect_to($new_location) {
    header('Location: ' . $new_location);
    exit;
}

// Check if name is valid
function name_valid($name) {
    $ok = true;
    
    $array = explode(' ', $name);    
    if (sizeof($array) < 2) {
        $ok = false;
    }
    
    return $ok;
}

// Create User model JSON object
function create_json_user($email, $phone, $dob, $gender, $password, $role) {
    $user = array(
        'email' => $email,
        'phone' => $phone,
        'dob' => $dob,
        'gender' => $gender,
        'password' => $password,
        'role' => $role
    );
    
    return json_encode($user);
}

// Create Course model JSON object
function create_json_course($code, $name, $description, $schools, $departments, $levels) {
    $course = array(
        'code' => $code,
        'name' => $name,
        'description' => $description,
        'schools' => $schools,
        'departments' => $departments,
        'levels' => $levels
    );
    
    return json_encode($course);
}

// Create Timetable model JSON object
function create_json_timetable($school, $dept, $level, $url) {
    $timetable = array(
        'school' => $school,
        'department' => $dept,
        'level' => $level,
        'url' => $url
    );
    
    return json_encode($timetable);
}

// Create Lecturer model JSON object
function create_json_lect($name, $avatar, $bio, $departments, $levels) {
    $lect = array(
        'name' => $name,
        'avatar' => $avatar,
        'bio' => $bio,
        'departments' => $departments,
        'levels' => $levels
    );
    
    return json_encode($lect);
}

// Create Student model JSON object
function create_json_student($name, $matricule, $enrolled, $level, $school, $department, $email,
        $phone, $password) {
    $student = array(
        'name' => $name,
        'matricule' => $matricule,
        'enrolled' => $enrolled,
        'level' => $level,
        'school' => $school,
        'department' => $department,
        'email' => $email,
        'phone' => $phone,
        'password' => $password
    );
    
    return json_encode($student);
}

// Create Message model JSON object (for sending)
function create_json_message($to, $title, $body) {
    $message = array(
        'to' => $to,
        'data' => array(
            'title' => $title,
            'body' => $body
        )
    );
    
    return json_encode($message);
}

// Create Message model JSON object (for saving)
function create_json_msg($title, $body, $time) {
    $message = array(
        'title' => $title,
        'body' => $body,
        'time' => $time
    );
    
    return json_encode($message);
}

// Create Results model JSON object
function create_json_results($year, $semester, $matricule, $url) {
    $results = array(
        'year' => $year,
        'semester' => $semester,
        'matricule' => $matricule,
        'url' => $url
    );
    
    return json_encode($results);
}

// Convert string to array neatly
function string_to_array($string) {
    $uc_string = ucwords($string);
    $array = explode(',', $uc_string);
    $new_array = array();
    
    foreach($array as $a) {
        array_push($new_array, trim($a));
    }
    
    return $new_array;
}

// Calculate expected revenue for schools from payments
function expected_revenue($count) {
    $revenue = $count * 600 * 0.3;
    
    return $revenue;
}