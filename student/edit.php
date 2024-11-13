<?php
// Start the session if it's not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include necessary files
require_once('../functions.php');
require_once('../auth_check.php'); // Ensure the user is logged in

// Error message variable
$error = [];

// Retrieve the student ID from the query parameter (passed via URL)
if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];

    // Get the index of the student from the session
    $student_index = getSelectedStudentIndex($student_id);

    // If the student is found, pre-populate the form
    if ($student_index !== null) {
        $student = getSelectedStudentData($student_index);

        // Process the form submission
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $student_id = $_POST['student_id'];
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];

            // Validate the form data
            $error = validateStudentData($_POST);

            // If no errors, update the student data in the session
            if (empty($error)) {
                $_SESSION['students'][$student_index] = [
                    'student_id' => $student_id,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'subjects' => $student['subjects'] // Keep existing subjects
                ];

                // Redirect back to the dashboard or wherever appropriate
                header("Location: dashboard.php");
                exit;
            }
        }
    } else {
        // If no student is found, redirect to dashboard
        header("Location: dashboard.php");
        exit;
    }
} else {
    // If student_id is not provided, redirect to dashboard
    header("Location: dashboard.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

    <!-- Include the header -->
    <?php include('../header.php'); ?>

    <!-- Dashboard content -->
    <div class="container mt-5">
        <h2 class="text-center mb-4">Edit Student Details</h2>

        <!-- Display error messages -->
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong>
                <ul>
                    <?php foreach ($error as $err): ?>
                        <li><?php echo $err; ?></li>
                    <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Student Edit Form -->
        <form method="POST" action="edit.php?student_id=<?php echo $student['student_id']; ?>">
            <div class="mb-3">
                <label for="student_id" class="form-label">Student ID</label>
                <input type="text" name="student_id" id="student_id" class="form-control" value="<?php echo htmlspecialchars($student['student_id']); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo htmlspecialchars($student['first_name']); ?>">
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" name="last_name" id="last_name" class="form-control" value="<?php echo htmlspecialchars($student['last_name']); ?>">
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary w-100">Update Student</button>
            </div>
        </form>

    </div>

    <!-- Bootstrap JS (Optional for Modal and Button functionality) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
