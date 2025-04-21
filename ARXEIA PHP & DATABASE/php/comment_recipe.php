<?php
session_start();
require 'db_connect.php';

// Έλεγχος αν ο χρήστης είναι συνδεδεμένος
if (!isset($_SESSION['user_id'])) {
    $_SESSION['flash_message'] = "Πρέπει να συνδεθείτε πρώτα!";
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$recipe_id = $_POST['recipe_id'];
$comment = trim($_POST['comment']);

// Έλεγχος για κενό σχόλιο
if (empty($comment)) {
    $_SESSION['flash_message'] = "❌ Το σχόλιο δεν μπορεί να είναι κενό.";
    header("Location: user.php");
    exit();
}

// Εισαγωγή σχολίου
$stmt = $conn->prepare("INSERT INTO comments (user_id, recipe_id, comment) VALUES (?, ?, ?)");
$stmt->bind_param("iis", $user_id, $recipe_id, $comment);

if ($stmt->execute()) {
    $_SESSION['flash_message'] = "✅ Το σχόλιό σας προστέθηκε με επιτυχία!";
} else {
    $_SESSION['flash_message'] = "❌ Παρουσιάστηκε σφάλμα κατά την αποθήκευση του σχολίου.";
}

$stmt->close();
header("Location: user.php");
exit();
