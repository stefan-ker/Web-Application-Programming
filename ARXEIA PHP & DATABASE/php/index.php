<?php session_start(); ?>

<!DOCTYPE html>
<html lang="el">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Συνταγές</title>
  <link rel="stylesheet" href="mycss.css"/>

  <script>
    // JavaScript για εμφάνιση/απόκρυψη των οδηγιών
    function toggleInstructions(recipeId) {
      var instructions = document.getElementById('instructions-' + recipeId);
      var button = document.getElementById('toggle-button-' + recipeId);

      // Ελέγχουμε αν οι οδηγίες είναι κρυμμένες ή εμφανισμένες
      if (instructions.style.display === 'none') {
        instructions.style.display = 'block';
        button.innerHTML = 'Δείτε λιγότερα'; // Αλλάζουμε το κείμενο του κουμπιού
      } else {
        instructions.style.display = 'none';
        button.innerHTML = 'Δείτε περισσότερα'; // Επαναφέρουμε το κείμενο του κουμπιού
      }
    }
  </script>

</head>
<body>

<div id="container">
  <?php require('header.php'); ?>
  <?php require('leftsidebar.php'); ?>

  <div id="main">
    <h2>Συνταγές για σήμερα</h2>
    
    <?php 
      if (isset($_GET['msg'])) {
        echo '<p style="color:red;">' . $_GET['msg'] . '</p>';
      }
    ?>


    <div class="recipe">
      <h3>Μουσακάς</h3>
      <img src="images/moussaka.jpg" alt="Μουσακάς" style="width: 300px; height: auto;"/>
      <p>Μια παραδοσιακή ελληνική συνταγή με μελιτζάνες, κιμά και μπεσαμέλ.</p>
      <p><strong>Χρόνος προετοιμασίας:</strong> 1 ώρα</p>
      <p><strong>Μερίδες:</strong> 4</p>
      <p><strong>Υλικά:</strong> Μελιτζάνες, Κιμάς, Μπεσαμέλ, Παρμεζάνα</p>


      <div id="instructions-1" style="display: none;">
        <p><strong>Οδηγίες:</strong> Τηγανίζουμε τις μελιτζάνες, μαγειρεύουμε τον κιμά και ετοιμάζουμε την μπεσαμέλ. Ενώνουμε τα υλικά σε στρώσεις και ψήνουμε για 45 λεπτά.</p>
      </div>
      

      <button id="toggle-button-1" onclick="toggleInstructions(1)">Δείτε περισσότερα</button>
    </div>


    <div class="recipe">
      <h3>Γιουβέτσι</h3>
      <img src="images/giouvetsi.jpg" alt="Γιουβέτσι" style="width: 300px; height: auto;"/>
      <p>Μια συνταγή με κρέας και ζυμαρικά στον φούρνο, πολύ αγαπητό στην ελληνική κουζίνα.</p>
      <p><strong>Χρόνος προετοιμασίας:</strong> 45 λεπτά</p>
      <p><strong>Μερίδες:</strong> 4-6</p>
      <p><strong>Υλικά:</strong> Κρέας (αρνί ή μοσχάρι), Ζυμαρικά, Ντομάτα, Μπαχαρικά</p>

     
      <div id="instructions-2" style="display: none;">
        <p><strong>Οδηγίες:</strong> Σοτάρουμε το κρέας, προσθέτουμε τη σάλτσα ντομάτας και τα ζυμαρικά. Ψήνουμε για 1 ώρα στο φούρνο.</p>
      </div>
      

      <button id="toggle-button-2" onclick="toggleInstructions(2)">Δείτε περισσότερα</button>
    </div>


    <div class="recipe">
      <h3>Μακαρόνια με κιμά</h3>
      <img src="images/makaronia.jpg" alt="Μακαρόνια" style="width: 300px; height: auto;"/>
      <p>Μακαρόνια με κιμά.</p>
      <p><strong>Χρόνος προετοιμασίας:</strong> 20 λεπτά</p>
      <p><strong>Μερίδες:</strong> 6</p>
      <p><strong>Υλικά:</strong> Μακαρόνια, κιμάς, Φύλλο</p>


      <div id="instructions-3" style="display: none;">
        <p><strong>Οδηγίες:</strong> Τοποθετούμε μια κατσαρόλα με νερό σε δυνατή φωτιά και αφήνουμε να βράσει. Ρίχνουμε αλάτι και τα ζυμαρικά, και βράζουμε σύμφωνα με τις οδηγίες της συσκευασίας.</p>
      </div>
      
   
      <button id="toggle-button-3" onclick="toggleInstructions(3)">Δείτε περισσότερα</button>
    </div>


    <div class="recipe">
      <h3>Γαλακτομπούρεκο</h3>
      <img src="images/galaktoboureko.jpg" alt="Γαλακτομπούρεκο" style="width: 300px; height: auto;"/>
      <p>Λαχταριστό γλυκό με κρέμα και φύλλο, σιροπιασμένο για επιπλέον γεύση.</p>
      <p><strong>Χρόνος προετοιμασίας:</strong> 1 ώρα</p>
      <p><strong>Μερίδες:</strong> 8</p>
      <p><strong>Υλικά:</strong> Φύλλο κρούστας, Κρέμα, Ζάχαρη, Βανίλια</p>

 
      <div id="instructions-4" style="display: none;">
        <p><strong>Οδηγίες:</strong> Ετοιμάζουμε την κρέμα και την τοποθετούμε ανάμεσα στα φύλλα. Ψήνουμε και σιροπιάζουμε το γλυκό όταν κρυώσει.</p>
      </div>
      

      <button id="toggle-button-4" onclick="toggleInstructions(4)">Δείτε περισσότερα</button>
    </div>


    <div class="recipe">
      <h3>Χταπόδι με μακαρόνια</h3>
      <img src="images/xtapodi.jpg" alt="Χταπόδι με μακαρόνια" style="width: 300px; height: auto;"/>
      <p>Αυτή η συνταγή συνδυάζει το χταπόδι με ζυμαρικά σε μια υπέροχη σάλτσα.</p>
      <p><strong>Χρόνος προετοιμασίας:</strong> 50 λεπτά</p>
      <p><strong>Μερίδες:</strong> 4</p>
      <p><strong>Υλικά:</strong> Χταπόδι, Μακαρόνια, Ντομάτα, Μπαχαρικά</p>

      <div id="instructions-5" style="display: none;">
        <p><strong>Οδηγίες:</strong> Βράζουμε το χταπόδι και το αναμειγνύουμε με τα ζυμαρικά και τη σάλτσα ντομάτας. Σερβίρουμε ζεστό.</p>
      </div>
      
      <button id="toggle-button-5" onclick="toggleInstructions(5)">Δείτε περισσότερα</button>
    </div>

  </div>

  <?php require('footer.php'); ?>

</div>

</body>
</html>
