<?php
session_start();
include('db.php');

// Check if user is logged in, else redirect to login page
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $book_id = $_POST['book_id'];
    $sql_delete = "DELETE FROM books WHERE id = '$book_id'";
    if (mysqli_query($conn, $sql_delete)) {
        header('Location: dashboard.php');
        exit;
    } else {
        $error = "Error deleting the book: " . mysqli_error($conn);
    }
}

// Fetch books for display
$sql = "SELECT * FROM books";
$result = mysqli_query($conn, $sql);
$books = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .card {
            margin-bottom: 20px;
        }
        .btn-logout {
            background-color: #dc3545;
            color: white;
            margin-top: 20px;
        }
        .btn-logout:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Admin Dashboard</h2>

    <!-- Logout Button -->
    <form method="POST" action="logout.php">
        <button type="submit" class="btn btn-logout">Logout</button>
    </form>

    <a href="add_book.php" class="btn btn-primary mb-3">Add New Book</a>

    <div class="row">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <?= $error; ?>
            </div>
        <?php endif; ?>

        <?php foreach ($books as $book): ?>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= $book['title'] ?></h5>
                        <p class="card-text"><?= $book['author'] ?></p>
                        <p class="card-text"><?= $book['description'] ?></p>
                        <p class="card-text"><strong>$<?= $book['price'] ?></strong></p>
                        <a href="edit_book.php?id=<?= $book['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="book_id" value="<?= $book['id'] ?>">
                            <button type="submit" name="delete" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Include Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
