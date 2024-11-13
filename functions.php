<?php
// Start the session if it's not already started
// Returns a hardcoded array of 5 users, each with an email and password.
function getUsers() {
    return [
        ['email' => 'user1@example.com', 'password' => 'password123'],
        ['email' => 'user2@example.com', 'password' => 'password456'],
        ['email' => 'user3@example.com', 'password' => 'password789'],
        ['email' => 'user4@example.com', 'password' => 'password101'],
        ['email' => 'user5@example.com', 'password' => 'password202']
    ];
}

// Validates login credentials by checking if the provided email and password are valid.
function validateLoginCredentials($email, $password) {
    $errors = [];

    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    return $errors;
}

// Checks if a given email and password match any user in the provided list of users.
function checkLoginCredentials($email, $password, $users) {
    foreach ($users as $user) {
        if ($user['email'] === $email && $user['password'] === $password) {
            return true; // Login credentials match
        }
    }
    return false; // No match found
}

// Checks if the provided email exists in the users array
function checkUserExists($email, $users) {
    foreach ($users as $user) {
        if ($user['email'] === $email) {
            return true; // User found
        }
    }
    return false; // User not found
}

// Checks if a user's session is active by verifying the existence of an email address in the session.
function checkUserSessionIsActive() {
    return isset($_SESSION['email']) && !empty($_SESSION['email']);
}

// Guard function: Redirects user to login page if not authenticated
function guard() {
    if (!checkUserSessionIsActive()) {
        header("Location: index.php");
        exit;
    }
}

// Error Handling Functions

// Takes an array of error messages and returns a formatted HTML string displaying the errors.
function displayErrors($errors) {
    if (empty($errors)) {
        return ''; // No errors to display
    }

    $errorHTML = "<div class='alert alert-danger'><strong>System Errors</strong><ul>";
    foreach ($errors as $error) {
        $errorHTML .= "<li>" . htmlspecialchars($error) . "</li>";
    }
    $errorHTML .= "</ul></div>";
    return $errorHTML;
}

// Takes a single error message and returns a formatted HTML alert box containing the error.
function renderErrorsToView($error) {
    if (empty($error)) {
        return null; // No error message to display
    }

    return "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>SYSTEM ERROR</strong>
                <p>" . htmlspecialchars($error) . "</p>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
}

function validateStudentData($student_data) {
    $errors = [];

    // Check if 'student_id', 'first_name', and 'last_name' are not empty
    if (empty($student_data['student_id'])) {
        $errors[] = "Student ID is required.";
    }
    if (empty($student_data['first_name'])) {
        $errors[] = "First Name is required.";
    }
    if (empty($student_data['last_name'])) {
        $errors[] = "Last Name is required.";
    }

    return $errors;
}

// Function to check if student data is duplicated
function checkDuplicateStudentData($student_data) {
    $errors = [];
    
    // Iterate over session student data to check for duplicates
    if (isset($_SESSION['students'])) {
        foreach ($_SESSION['students'] as $student) {
            if ($student['student_id'] === $student_data['student_id']) {
                $errors[] = "A student with the same Student ID already exists.";
                break;
            }
        }
    }

    return $errors;
}

// Function to get the index of a selected student
function getSelectedStudentIndex($student_id) {
    if (isset($_SESSION['students'])) {
        foreach ($_SESSION['students'] as $index => $student) {
            if ($student['student_id'] === $student_id) {
                return $index;
            }
        }
    }
    return null; // Return null if no student is found
}

// Function to get student data by index
function getSelectedStudentData($index) {
    if (isset($_SESSION['students'][$index])) {
        return $_SESSION['students'][$index];
    }
    return null; // Return null if no student data is found at that index
}

// Function to validate subject data
function validateSubjectData($subject_data) {
    $errors = [];

    // Check if 'subject_code' and 'subject_name' are not empty
    if (empty($subject_data['subject_code'])) {
        $errors[] = "Subject Code is required.";
    }
    if (empty($subject_data['subject_name'])) {
        $errors[] = "Subject Name is required.";
    }

    return $errors;
}

// Function to check if subject data is duplicated
function checkDuplicateSubjectData($subject_data) {
    $errors = [];
    
    // Iterate over session subject data to check for duplicates
    if (isset($_SESSION['subjects'])) {
        foreach ($_SESSION['subjects'] as $subject) {
            if ($subject['subject_code'] === $subject_data['subject_code'] || $subject['subject_name'] === $subject_data['subject_name']) {
                $errors[] = "A subject with the same Code or Name already exists.";
                break;
            }
        }
    }

    return $errors;
}

// Function to get the index of a selected subject
function getSelectedSubjectIndex($subject_code) {
    if (isset($_SESSION['subjects'])) {
        foreach ($_SESSION['subjects'] as $index => $subject) {
            if ($subject['subject_code'] === $subject_code) {
                return $index;
            }
        }
    }
    return null; // Return null if no subject is found
}

// Function to get subject data by index
function getSelectedSubjectData($index) {
    if (isset($_SESSION['subjects'][$index])) {
        return $_SESSION['subjects'][$index];
    }
    return null; // Return null if no subject data is found at that index
}

// Function to validate if at least one subject is attached to a student
function validateAttachedSubject($subject_data) {
    $errors = [];

    // Check if any subject is selected
    if (empty($subject_data['subjects']) || count($subject_data['subjects']) == 0) {
        $errors[] = "At least one subject must be selected.";
    }

    return $errors;
}
?>
