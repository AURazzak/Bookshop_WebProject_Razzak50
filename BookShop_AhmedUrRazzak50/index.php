<?php
session_start();
include('db.php'); // Include database connection file

// Handle login form submission
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to check if the email and password match
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // User found, start session and redirect to dashboard
        $_SESSION['user'] = $email;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid login credentials!";
    }
}

// Handle registration form submission
if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if email already exists
    $sql_check = "SELECT * FROM users WHERE email = '$email'";
    $result_check = mysqli_query($conn, $sql_check);

    if (mysqli_num_rows($result_check) > 0) {
        $error = "Email already exists!";
    } else {
        // Insert new user into the database
        $sql_insert = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
        if (mysqli_query($conn, $sql_insert)) {
            $success = "Registration successful! Please log in.";
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Shop - Login/Register</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f4;
            padding-top: 50px;
        }
        .container {
            max-width: 500px;
            margin-top: 50px;
        }
        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .form-container h3 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-container .form-group {
            margin-bottom: 20px;
        }
        .form-container .alert {
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Login/Register Form -->
    <div class="form-container">
        <h3>Login or Register</h3>

        <!-- Display success or error messages -->
        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <?= $error; ?>
            </div>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <div class="alert alert-success">
                <?= $success; ?>
            </div>
        <?php endif; ?>

        <!-- Tabs for login and registration -->
        <ul class="nav nav-tabs" id="loginRegisterTabs">
            <li class="nav-item">
                <a class="nav-link active" id="login-tab" data-toggle="tab" href="#login">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="register-tab" data-toggle="tab" href="#register">Register</a>
            </li>
        </ul>

        <div class="tab-content">
            <!-- Login Form -->
            <div class="tab-pane fade show active" id="login">
                <form method="POST">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" name="login" class="btn btn-primary btn-block">Login</button>
                </form>
            </div>

            <!-- Register Form -->
            <div class="tab-pane fade" id="register">
                <form method="POST">
                    <div class="form-group">
                        <label for="name">Full Name:</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" name="register" class="btn btn-success btn-block">Register</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Include Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
