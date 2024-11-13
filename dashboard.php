<?php
// Start the session if it's not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include necessary files
require_once('functions.php');
require_once('auth_check.php'); // Ensure the user is logged in

// Check if the user is logged in by checking session for the email
if (!isset($_SESSION['email'])) {
    header("Location: index.php"); // Redirect to login page if not logged in
    exit();
}

$email = $_SESSION['email']; // Get the email of the logged-in user
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

    <!-- Include the header -->
    <?php include('header.php'); ?>

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </nav>

    <!-- Dashboard content -->
    <div class="container mt-5">
        <div class="row align-items-center">
            <div class="col">
                <h2>Welcome, <strong><?php echo htmlspecialchars($email); ?></strong>!</h2>
            </div>
            <div class="col text-end">
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>

        <!-- Add a Subject and Register a Student Section -->
        <div class="row mt-5">
            <!-- Add a Subject Section -->
            <div class="col-md-6">
                <h3>Add a Subject</h3>
                <p class="lead">Here you can add a new subject. Please provide the subject details and click on the "Add Subject" button to proceed.</p>
                <a href="subject/add.php" class="btn btn-primary">Add Subject</a>
            </div>

            <!-- Register a Student Section -->
            <div class="col-md-6">
                <h3>Register a Student</h3>
                <p class="lead">Here you can register a new student. Click on the "Register" button to proceed.</p>
                <a href="student/register.php" class="btn btn-primary">Register</a>
            </div>
        </div>

        <div class="mt-4">
            <!-- Add other dashboard content or features here -->
        </div>
    </div>

    <!-- Bootstrap JS (Optional for Modal and Button functionality) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
