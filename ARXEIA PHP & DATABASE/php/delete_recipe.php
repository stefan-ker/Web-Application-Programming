<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php?msg=Πρέπει να συνδεθείτε πρώτα!");
    exit();
}

$user_id = $_SESSION['user_id'];
$recipe_id = $_POST['recipe_id'];

// Έλεγχος αν ο χρήστης είναι ο ιδιοκτήτης της συνταγής
$stmt = $conn->prepare("SELECT user_id FROM recipes WHERE id = ?");
$stmt->bind_param("i", $recipe_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($recipe_owner_id);
$stmt->fetch();
$stmt->close();

if ($recipe_owner_id == $user_id) {
    // Πρώτα διαγράφουμε τα σχόλια για τη συνταγή
    $stmt = $conn->prepare("DELETE FROM comments WHERE recipe_id = ?");
    $stmt->bind_param("i", $recipe_id);
    $stmt->execute();
    $stmt->close();

    // Στη συνέχεια διαγράφουμε τα likes για τη συνταγή
    $stmt = $conn->prepare("DELETE FROM likes WHERE recipe_id = ?");
    $stmt->bind_param("i", $recipe_id);
    $stmt->execute();
    $stmt->close();

    // Τέλος, διαγράφουμε τη συνταγή
    $stmt = $conn->prepare("DELETE FROM recipes WHERE id = ?");
    $stmt->bind_param("i", $recipe_id);
    $stmt->execute();
    $stmt->close();

    header("Location: user.php?msg=Η συνταγή διαγράφηκε επιτυχώς!");
} else {
    header("Location: user.php?msg=Δεν έχετε άδεια να διαγράψετε αυτή τη συνταγή.");
}
exit();
?>
