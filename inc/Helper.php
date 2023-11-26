<?php

require_once 'Database.php';
function totalTeamMembers() {
  global $pdo;
  $stmt = $pdo->prepare('SELECT COUNT(*) AS total FROM users');
  $stmt->execute();
  $result = $stmt->fetch();

  return $result['total'];
}

function totalBrands() {
  global $pdo;
  $stmt = $pdo->prepare('SELECT COUNT(*) AS total FROM brands');
  $stmt->execute();
  $result = $stmt->fetch();

  return $result['total'];
}

//function categories() {
//  global $pdo;
//  $stmt = $pdo->prepare('SELECT * FROM categories');
//  $stmt->execute();
//  echo json_encode($stmt->fetchAll());
//}

function totalProductItems() {
  global $pdo;
  $stmt = $pdo->prepare('SELECT COUNT(*) AS total FROM products');
  $stmt->execute();
  $result = $stmt->fetch();

  return $result['total'];
}

function totalCustomers() {
  global $pdo;
  $stmt = $pdo->prepare('SELECT COUNT(*) AS total FROM customers');
  $stmt->execute();
  $result = $stmt->fetch();

  return $result['total'];
}

function totalPayments() {
  global $pdo;
  $stmt = $pdo->prepare('SELECT COUNT(*) AS total FROM payment_methods');
  $stmt->execute();
  $result = $stmt->fetch();

  return $result['total'];
}

function totalShippers() {
  global $pdo;
  $stmt = $pdo->prepare('SELECT COUNT(*) AS total FROM shippers');
  $stmt->execute();
  $result = $stmt->fetch();

  return $result['total'];
}