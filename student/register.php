<?php
// Start the session if it's not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include necessary files
require_once('../functions.php');
require_once('../auth_check.php'); // Ensures the user is logged in

// Error message variable
$error = [];

// Handle Register Student
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];

    // Validate the form data (Make fields optional but still validate)
    if (empty($student_id)) {
        $error[] = "Student ID is required.";
    }

    if (empty($first_name)) {
        $error[] = "First Name is required.";
    }

    if (empty($last_name)) {
        $error[] = "Last Name is required.";
    }

    // If no errors, save the student data
    if (empty($error)) {
        // Save student data (for example, in session or a database)
        $_SESSION['students'][] = [
            'student_id' => $student_id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'subjects' => [] // No subjects attached
        ];
        
        // Show success message
        echo "<p class='text-success'>Student registered successfully!</p>";
    }
}

// Handle Delete Student (Triggered via button)
if (isset($_GET['delete'])) {
    $student_id_to_delete = $_GET['delete'];
    // Find and delete the student
    foreach ($_SESSION['students'] as $key => $student) {
        if ($student['student_id'] == $student_id_to_delete) {
            unset($_SESSION['students'][$key]);
            break;
        }
    }
    header("Location: register.php"); // Refresh the page after deletion
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Student</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        /* Custom Styling for Form */
        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            font-weight: bold;
            display: block;
        }

        /* Table styling for registered students */
        table {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <!-- Include the header -->
    <?php require_once('../header.php'); ?>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Register a New Student</h2>

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

        <!-- Student Registration Form -->
        <form method="POST" action="register.php">
            <div class="mb-3">
                <label for="student_id" class="form-label">Student ID</label>
                <input type="text" name="student_id" id="student_id" class="form-control" value="<?php echo isset($student_id) ? $student_id : ''; ?>">
            </div>
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo isset($first_name) ? $first_name : ''; ?>">
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" name="last_name" id="last_name" class="form-control" value="<?php echo isset($last_name) ? $last_name : ''; ?>">
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary w-100">Register Student</button>
            </div>
        </form>

        <!-- Display Registered Students -->
        <h3 class="mt-4">Registered Students</h3>
        <?php if (isset($_SESSION['students']) && count($_SESSION['students']) > 0): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Subjects</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['students'] as $student): ?>
                        <tr>
                            <td><?= htmlspecialchars($student['student_id']) ?></td>
                            <td><?= htmlspecialchars($student['first_name']) ?></td>
                            <td><?= htmlspecialchars($student['last_name']) ?></td>
                            <td>No subjects attached</td> <!-- No subjects column -->
                            <td>
                                <!-- Edit Button -->
                                <a href="edit.php?student_id=<?= $student['student_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                
                                <!-- Delete Button -->
                                <a href="register.php?delete=<?= $student['student_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
                                
                                <!-- Attach Subject Button -->
                                <a href="attach_subject.php?student_id=<?= $student['student_id'] ?>" class="btn btn-info btn-sm">Attach Subject</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No students have been registered yet.</p>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS (Optional for Modal and Button functionality) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
