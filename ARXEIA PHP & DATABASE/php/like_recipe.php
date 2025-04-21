<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    $_SESSION['flash_message'] = "Πρέπει να συνδεθείτε πρώτα!";
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$recipe_id = $_POST['recipe_id'];

// Έλεγχος για διπλό like
$stmt = $conn->prepare("SELECT id FROM likes WHERE user_id = ? AND recipe_id = ?");
$stmt->bind_param("ii", $user_id, $recipe_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $_SESSION['flash_message'] = "⚠️ Έχετε ήδη κάνει Like σε αυτή τη συνταγή.";
    header("Location: user.php");
    exit();
}
$stmt->close();

$stmt = $conn->prepare("INSERT INTO likes (user_id, recipe_id) VALUES (?, ?)");
$stmt->bind_param("ii", $user_id, $recipe_id);

if ($stmt->execute()) {
    $_SESSION['flash_message'] = "👍 Επιτυχές Like!";
} else {
    $_SESSION['flash_message'] = "❌ Σφάλμα κατά την καταχώρηση του Like.";
}

$stmt->close();
header("Location: user.php");
exit();
