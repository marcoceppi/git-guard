<?php

session_destroy();
session_start();
session_store("html", array('success' => "You have been successfully logged out"));
header("Location: index.php");
?>
