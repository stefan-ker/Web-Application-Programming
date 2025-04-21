<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php?msg=Πρέπει να συνδεθείτε πρώτα!");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['title'], $_POST['ingredients'], $_POST['instructions'], $_POST['preparation_time'], $_FILES['image'])) {
        $title = htmlspecialchars($_POST['title']);
        $ingredients = htmlspecialchars($_POST['ingredients']);
        $instructions = htmlspecialchars($_POST['instructions']);
        $preparation_time = htmlspecialchars($_POST['preparation_time']);

        // Διαχείριση εικόνας
        $image = $_FILES['image'];
        $image_name = $image['name'];
        $image_tmp_name = $image['tmp_name'];
        $image_size = $image['size'];
        $image_error = $image['error'];

        if ($image_error === 0 && $image_size <= 5000000) {
            $image_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

            if (in_array($image_extension, $allowed_extensions)) {
                $image_new_name = uniqid('', true) . "." . $image_extension;
                $image_upload_path = 'images/recipes/' . $image_new_name;
                move_uploaded_file($image_tmp_name, $image_upload_path);

                // Αποθήκευση στη βάση δεδομένων με το user_id
                $stmt = $conn->prepare("INSERT INTO recipes (title, ingredients, instructions, preparation_time, image, user_id) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssssi", $title, $ingredients, $instructions, $preparation_time, $image_new_name, $_SESSION['user_id']);
                $stmt->execute();
                $stmt->close();

                header("Location: user.php?msg=Η συνταγή προστέθηκε επιτυχώς!");
                exit();
            } else {
                $error_message = "Μόνο εικόνες JPG, JPEG, PNG, GIF επιτρέπονται!";
            }
        } else {
            $error_message = "Η εικόνα είναι πολύ μεγάλη ή υπήρξε σφάλμα!";
        }
    } else {
        $error_message = "Παρακαλώ συμπληρώστε όλα τα πεδία!";
    }
}
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Προσθήκη Συνταγής</title>
    <link rel="stylesheet" href="mycss.css"/>
</head>
<body>

<div id="container">
    <?php require('header.php'); ?>
    <?php require('leftsidebar.php'); ?>

    <div id="main">
        <h2>Προσθήκη Συνταγής</h2>

        <?php if (isset($error_message)) { echo '<p style="color: red;">' . $error_message . '</p>'; } ?>

        <form action="add_recipe.php" method="POST" enctype="multipart/form-data">
            <label for="title">Τίτλος Συνταγής:</label>
            <input type="text" id="title" name="title" required><br><br>

            <label for="ingredients">Υλικά:</label>
            <textarea id="ingredients" name="ingredients" required></textarea><br><br>

            <label for="instructions">Οδηγίες:</label>
            <textarea id="instructions" name="instructions" required></textarea><br><br>

            <label for="preparation_time">Χρόνος Προετοιμασίας:</label>
            <input type="text" id="preparation_time" name="preparation_time" required><br><br>

            <label for="image">Εικόνα Συνταγής:</label>
            <input type="file" id="image" name="image" required><br><br>

            <input type="submit" value="Προσθήκη Συνταγής">
        </form>
    </div>

    <?php require('footer.php'); ?>
</div>

</body>
</html>
