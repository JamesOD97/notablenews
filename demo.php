<?php

$secure = parse_ini_file('/home/notablenews/.secure/secure.ini');

require('article.php');                 // Includes the holder class 'Article'
require('difference.php');				// Includes the difference calculator function

$conn = new mysqli($secure['hostname'], $secure['username'], $secure['password'], $secure['db']);

if (!$conn->connect_error) {			// If connection successful

}

?>