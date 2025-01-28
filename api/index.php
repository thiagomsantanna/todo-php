<?php
session_start();
require_once(__DIR__ . '/utils/helpers.php');

if (isset($_GET['fill'])) fill();
if (isset($_GET['flush'])) erase();
if (isset($_GET['error'])) error();

if (!isset($_SESSION['tasks'])) {
  $_SESSION['tasks'] = [];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>To-Do List</title>
  <link rel="stylesheet" type="text/css" href="./assets/style.css">
  <link rel="icon" type="image/png" sizes="32x32" href="./assets/imgs/icon.png">
  <script>
    function check(event) {
      const img = event.target;
      const li = img.parentElement.parentElement; // button -> li

      for (const element of [img, li]) {
        element.classList.toggle("checked");
      }
    }

    function edit(taskId, task) {
      const [input, inputId] = [
        document.getElementById("input-box"),
        document.querySelector(`input[name="id"]`)
      ];
      const addButton = document.getElementById("add");

      inputId.value = taskId;
      input.attributes.placeholder.value = `Editing: ${task}`;
      input.focus();

      addButton.innerText = "Edit";
      addButton.attributes.formaction.value = "./server/operations/Edit.php";
    }
  </script>
</head>

<body>
  <div class="container">
    <div class="todo-app">
      <!-- Error-->
      <?php if (isset($_SESSION['error'])): ?>
        <div class="error-card">
          <div class="error-icon">!</div>
          <div class="error-message">
            <strong>Error:</strong> <?= htmlspecialchars($_SESSION['error']); ?>
          </div>
        </div>
        <?php unset($_SESSION['error']); ?>
      <?php endif; ?>

      <!-- App -->
      <h2>ToDo List <img src="./assets/imgs/icon.png"></h2>
      <form method="post" class="row">
        <input type="hidden" name="id" value="">
        <input type="text" name="task" id="input-box" placeholder="Add your text">

        <button id="add" type="submit" formaction="./server/operations/Add.php">Add</button>
      </form>

      <!-- Tasks -->
      <ul id="list-container">
        <?php foreach ($_SESSION['tasks'] as $index => $task): ?>
          <?php $check = $task['done'] ? 'checked' : '' ?>

          <form method="post">
            <li class=<?= $check ?>>
              <button type="submit" formaction="./server/operations/Check.php">
                <img onclick="check(event)" class=<?= $check ?> />
              </button>

              <p><?= $task['description']; ?></p><input type="hidden" name="id" value="<?= $index ?>">

              <button type="button" onclick="edit('<?= $index ?>', '<?= $task['description'] ?>')">
                <span class="edit">&#x270E</span>
              </button>
              <button type="submit" formaction="./server/operations/Delete.php">
                <span>&#x00D7</span>
              </button>
            </li>
          </form>

        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</body>

</html>