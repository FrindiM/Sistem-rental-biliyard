<?php
// Connect to the database
$db = mysqli_connect('localhost', 'root', '', 'mydb');

// Check connection
if (!$db) {
  die('Error connecting to database');
}
