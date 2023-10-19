<?php
// get_index.php

if (isset($_POST['index'])) {
    // Retrieve the index value from the POST data
    $index1 = $_POST['index'];   
    echo $index1;
} else {
    // Handle the case where the index is not provided
    echo "Index not provided";
}
?>
