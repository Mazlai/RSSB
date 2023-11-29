<?php
  $host_name = '';
  $database = '';
  $user_name = '';
  $password = '';
  $bdd = null;

  try {
    $bdd = new PDO("mysql:host=$host_name; dbname=$database;", $user_name, $password);
  } catch (PDOException $e) {
    echo "Erreur!:" . $e->getMessage() . "<br/>";
    die();
  }
?>
