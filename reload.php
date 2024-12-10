<?php 
if (isset($_GET['ajax']) && $_GET['ajax'] == '1') {
    // I-return lang ang table content
    include 'profile.php';
    exit;
}

?>