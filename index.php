<?php
// Start the session if it's not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include functions.php file (only once)
require_once('functions.php');
// Ensure guard() function is called after the session is started and functions are included


// If the user is logged in, redirect to the dashboard page
if (checkUserSessionIsActive()) {
    header("Location: dashboard.php");
    exit;
}

// Error message variable
$error = [];

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate email and password
    $error = validateLoginCredentials($email, $password);

    // If there are no validation errors, check login credentials
    if (empty($error)) {
        // Get the hardcoded users
        $users = getUsers();

        // Check if the login credentials are correct
        $emailExists = checkUserExists($email, $users);
        $loginSuccessful = checkLoginCredentials($email, $password, $users);

        // Check if the email exists
        if (!$emailExists) {
            $error[] = "Invalid Email or Password.";
        }

        // Check if the password is incorrect
        if ($emailExists && !$loginSuccessful) {
            $error[] = "Incorrect password.";
        }

        // If login is successful, store the email in session
        if ($emailExists && $loginSuccessful) {
            $_SESSION['email'] = $email;
            $_SESSION['current_page'] = 'dashboard.php'; // Store the current page (dashboard) in the session
            header("Location: dashboard.php"); // Redirect to dashboard
            exit; // Ensure no further code is executed
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body style="background-color: #ffffff;"> <!-- White background for the entire page -->

    <!-- Fullscreen Container for login -->
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="card shadow-sm" style="width: 100%; max-width: 400px; background-color: #ffffff;"> <!-- White background for the card -->
            <div class="card-body">
                <!-- Login Title with White Background -->
                <h3 class="card-title text-center bg-light text-dark py-3 mb-4">Login</h3> <!-- Light background for title -->

                <!-- Display error message if login fails -->
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>SYSTEM ERROR</strong>
                        <ul>
                            <?php foreach ($error as $err): ?>
                                <li><?php echo $err; ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- Login Form -->
                <form action="index.php" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="text" class="form-control" id="email" name="email" value="<?php echo isset($email) ? $email : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>
