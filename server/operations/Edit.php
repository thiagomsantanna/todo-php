<?php
session_start();
require("../utils/task_validation.php");

$error = &$_SESSION['error'];
$tasks = &$_SESSION['tasks'];

$task_id = $_POST['id'];
$task = $_POST['task'];

$old_task = $tasks[$task_id];

if (empty($task)) empty_task($error);

$tasks[$task_id] = [
  'description' => $task,
  'done' => $old_task['done'],
];

if (has_dupes($tasks)) {
  $tasks[$task_id] = $old_task;
  duplicated_task($tasks, $error);
}

go_back();
