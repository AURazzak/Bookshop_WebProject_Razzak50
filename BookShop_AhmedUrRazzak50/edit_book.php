<?php
session_start();
include('db.php');

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}

// Fetch the book data if an ID is provided
if (isset($_GET['id'])) {
    $book_id = $_GET['id'];
    $sql_fetch = "SELECT * FROM books WHERE id = '$book_id'";
    $result = mysqli_query($conn, $sql_fetch);

    if (mysqli_num_rows($result) > 0) {
        $book = mysqli_fetch_assoc($result);
    } else {
        header('Location: dashboard.php');
        exit;
    }
} else {
    header('Location: dashboard.php');
    exit;
}

// Handle the form submission to update the book
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_book'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $sql_update = "UPDATE books SET title = '$title', author = '$author', description = '$description', price = '$price' WHERE id = '$book_id'";
    if (mysqli_query($conn, $sql_update)) {
        header('Location: dashboard.php');
        exit;
    } else {
        $error = "Error updating the book: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Book</h2>

    <!-- Error message -->
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label for="title">Book Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?= $book['title'] ?>" required>
        </div>
        <div class="form-group">
            <label for="author">Author</label>
            <input type="text" class="form-control" id="author" name="author" value="<?= $book['author'] ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" required><?= $book['description'] ?></textarea>
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <input type="text" class="form-control" id="price" name="price" value="<?= $book['price'] ?>" required>
        </div>
        <button type="submit" name="edit_book" class="btn btn-primary">Update Book</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
