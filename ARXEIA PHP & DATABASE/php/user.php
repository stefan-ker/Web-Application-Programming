<?php
session_start();
require 'db_connect.php'; // Σύνδεση με τη βάση δεδομένων

if (!isset($_SESSION['username'])) {
    header("Location: login.php?msg=Πρέπει να συνδεθείτε πρώτα!");
    exit();
}

$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];

// Επιλέγουμε τις συνταγές από τη βάση δεδομένων
$stmt = $conn->prepare("SELECT * FROM recipes ORDER BY id DESC");
$stmt->execute();
$recipes = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Προσωπική Σελίδα Χρήστη</title>
    <link rel="stylesheet" type="text/css" href="mycss.css"/>
    <script>
        function toggleContent(id) {
            const content = document.getElementById(id);
            const button = document.getElementById('btn_' + id);
            if (content.style.display === "none") {
                content.style.display = "block";
                button.innerText = "Δείτε λιγότερα";
            } else {
                content.style.display = "none";
                button.innerText = "Δείτε περισσότερα";
            }
        }
    </script>
</head>
<body>

<div id="container">
    <?php require('header.php'); ?>
    <?php require('leftsidebar.php'); ?>

    <div id="main">
        <?php if (isset($_SESSION['flash_message'])): ?>
            <div class="flash-message" style="background-color: #f0f0f0; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; color: #333;">
                <?php 
                    echo $_SESSION['flash_message']; 
                    unset($_SESSION['flash_message']); 
                ?>
            </div>
        <?php endif; ?>
        
        <h2>Καλωσορίσατε, <?php echo $_SESSION['username']; ?>!</h2>
        <p>Αυτή είναι η προσωπική σας σελίδα.</p>

        <form action="add_recipe.php" method="get">
            <input type="submit" value="Εισαγωγή Συνταγής" class="button" />
        </form>

        <?php while ($recipe = $recipes->fetch_assoc()): ?>
            <div class="recipe">
                <h3><?php echo $recipe['title']; ?></h3>
                <img src="images/recipes/<?php echo $recipe['image']; ?>" alt="<?php echo $recipe['title']; ?>" style="width: 300px; height: auto;">
                <p><strong>Υλικά:</strong> <?php echo $recipe['ingredients']; ?></p>
                
                <div id="instructions_<?php echo $recipe['id']; ?>" style="display: none;">
                    <p><strong>Οδηγίες:</strong> <?php echo $recipe['instructions']; ?></p>
                </div>
                <button id="btn_instructions_<?php echo $recipe['id']; ?>" class="button" onclick="toggleContent('instructions_<?php echo $recipe['id']; ?>')">Δείτε περισσότερα</button>
                
                <p><strong>Χρόνος προετοιμασίας:</strong> <?php echo $recipe['preparation_time']; ?></p>

                <?php if (isset($_SESSION['username'])): ?>
                    <form action="like_recipe.php" method="post">
                        <input type="hidden" name="recipe_id" value="<?php echo $recipe['id']; ?>">
                        <input type="submit" value="Like" class="button" />
                    </form>

                    <form action="comment_recipe.php" method="post">
                        <textarea name="comment" placeholder="Πρόσθεσε το σχόλιο σου" required></textarea><br>
                        <input type="hidden" name="recipe_id" value="<?php echo $recipe['id']; ?>">
                        <input type="submit" value="Σχολίασε" class="button" />
                    </form>
                <?php endif; ?>

                <?php if ($recipe['user_id'] == $user_id): ?>
                    <form action="delete_recipe.php" method="post">
                        <input type="hidden" name="recipe_id" value="<?php echo $recipe['id']; ?>">
                        <input type="submit" value="Διαγραφή" class="button" />
                    </form>
                <?php endif; ?>

                <div class="likes">
                    <?php
                    // Επιλέγουμε όλα τα Likes για τη συγκεκριμένη συνταγή
                    $like_stmt = $conn->prepare("SELECT users.username FROM likes JOIN users ON likes.user_id = users.id WHERE likes.recipe_id = ?");
                    $like_stmt->bind_param("i", $recipe['id']);
                    $like_stmt->execute();
                    $like_result = $like_stmt->get_result();

                    if ($like_result->num_rows > 0) {
                        echo "<strong>Likes:</strong><br>";
                        while ($like = $like_result->fetch_assoc()) {
                            echo $like['username'] . "<br>";
                        }
                    } else {
                        echo "Δεν υπάρχουν Likes για αυτή τη συνταγή.";
                    }
                    $like_stmt->close();
                    ?>
                </div>

                <div class="comments">
                    <?php
                    // Επιλέγουμε όλα τα σχόλια για τη συγκεκριμένη συνταγή
                    $comment_stmt = $conn->prepare("SELECT users.username, comments.comment FROM comments JOIN users ON comments.user_id = users.id WHERE comments.recipe_id = ?");
                    $comment_stmt->bind_param("i", $recipe['id']);
                    $comment_stmt->execute();
                    $comment_result = $comment_stmt->get_result();

                    if ($comment_result->num_rows > 0) {
                        echo "<strong>Σχόλια:</strong><br>";
                        while ($comment = $comment_result->fetch_assoc()) {
                            echo $comment['username'] . ": " . $comment['comment'] . "<br>";
                        }
                    } else {
                        echo "Δεν υπάρχουν σχόλια για αυτή τη συνταγή.";
                    }
                    $comment_stmt->close();
                    ?>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <?php require('footer.php'); ?>
</div>

</body>
</html>
