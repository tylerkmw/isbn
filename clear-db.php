<?php

include 'db.php';
include 'header.php';

$query = mysqli_query($connect, "DELETE FROM books");
echo "Database has been cleared.";