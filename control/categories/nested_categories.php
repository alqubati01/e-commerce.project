<?php

session_start();
require_once '../../inc/Database.php';

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) {
  global $pdo;
  $stmt = $pdo->prepare('SELECT * FROM categories');
  $stmt->execute();

  if ($stmt->rowCount()) {
    $categories = array();

    while ($row = $stmt->fetch()) {
      $categories[$row['parent_id']][] = $row;
    }

    function add_children($categories, $parent)
    {
      $nested_array = array();
      foreach($categories[$parent] as $category) {
        $obj = new stdClass();
        $obj->id = $category['id'];
  //        $obj->parent_id = $category['parent_id'];
        $obj->title = $category['name'];
  //        $obj->is_active = $category['is_active'];
  //        $obj->created_at = $category['created_at'];
  //        $obj->updated_at = $category['updated_at'];
        if(isset($categories[$category['id']])) {
          $obj->subs = add_children($categories, $category['id']);
        }
        $nested_array[] = $obj;
      }
      return $nested_array;
    }

    $nestedCategories = add_children($categories, NULL);
    echo json_encode($nestedCategories);
  } else {
    echo json_encode(['status'=> 303, 'message'=> 'No categories founded']);
  }
} else {
  echo json_encode(['status'=> 303, 'message'=> 'Please login']);
}