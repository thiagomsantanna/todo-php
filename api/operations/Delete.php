<?php
session_start();
require_once(__DIR__ . "/../objects/Errors.php");
require_once(__DIR__ . '/../utils/goback.php');

$error = &$_SESSION['error'];
$task_id = $_POST['id'];

if (!task_exists($task_id)) {
  $error = ERRORS['not_found'];
  go_back();
}

remove_task($task_id);
go_back();

function task_exists($index)
{
  return isset($_SESSION['tasks'][$index]);
}

function remove_task($index)
{
  unset($_SESSION['tasks'][$index]);
  // $_SESSION['tasks'] = array_values($_SESSION['tasks']); // Reindexar o array
}
