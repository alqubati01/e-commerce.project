<?php

try {
  $pdo = new PDO('mysql:host=localhost;dbname=ecommerce;charset=utf8;connect_timeout=15', 'root', '',
    [
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES => false,
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]
  );
  $pdo->query('SET SQL_MODE="NO_BACKSLASH_ESCAPES"');
} catch(PDOException $e) {
  die($e->getMessage());
}
