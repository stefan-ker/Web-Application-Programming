<?php
// Τυπώνει πιθανό μήνυμα που υπάρχει στην παράμετρο 'msg' του $_GET
function echo_msg() {
    if (isset($_GET['msg'])) {   // Ελέγχουμε αν η παράμετρος 'msg' υπάρχει στη διεύθυνση URL
        echo '<p style="color:red;">' . $_GET['msg'] . '</p>';  // Εμφανίζουμε το μήνυμα με κόκκινο χρώμα
    }
}
?>
