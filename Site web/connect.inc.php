<?php
  $host_name = 'db5013078784.hosting-data.io';
  $database = 'dbs10979999';
  $user_name = 'dbu4795446';
  $password = '/catamimosud!';
  $bdd = null;

  try {
    $bdd = new PDO("mysql:host=$host_name; dbname=$database;", $user_name, $password);
  } catch (PDOException $e) {
    echo "Erreur!:" . $e->getMessage() . "<br/>";
    die();
  }
?>