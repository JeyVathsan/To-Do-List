<?php
// File to store tasks
$filename = 'tasks.json';

// Read tasks from the file
$tasks = file_exists($filename) ? json_decode(file_get_contents($filename), true) : [];

// Add a new task
if (isset($_POST['add'])) {
    $task = trim($_POST['task']);
    if ($task) {
        $tasks[] = ['id' => time(), 'task' => $task];
        file_put_contents($filename, json_encode($tasks));
    }
}

// Update an existing task
if (isset($_POST['update'])) {
    $task_id = $_POST['id'];
    $new_task = trim($_POST['task']);
    foreach ($tasks as &$task) {
        if ($task['id'] == $task_id) {
            $task['task'] = $new_task;
            break;
        }
    }
    file_put_contents($filename, json_encode($tasks));
}

// Delete a task
if (isset($_GET['delete'])) {
    $task_id = $_GET['delete'];
    $tasks = array_filter($tasks, function($task) use ($task_id) {
        return $task['id'] != $task_id;
    });
    file_put_contents($filename, json_encode($tasks));
}

// Get the current list of tasks
$tasks = json_decode(file_get_contents($filename), true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="Assets/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto+Serif:ital,opsz,wght@0,8..144,100..900;1,8..144,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
  
    <script src="Assets/script.js"></script>
</head>
<body>
    <h1>To-Do List</h1>


    <form method="POST">
        <input type="text" name="task" placeholder="Enter new task" required>
        <button type="submit" name="add">Add Task</button>
    </form>

    <ul>
        <?php foreach ($tasks as $task): ?>
            <li>
                <span><?php echo htmlspecialchars($task['task']); ?></span>
                <div class="task-actions">
                    <button onclick="openModal('<?php echo $task['id']; ?>', '<?php echo htmlspecialchars($task['task']); ?>')">Update</button>
                    <a href="?delete=<?php echo $task['id']; ?>"><button class="red">Delete</button></a>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>


    <div id="updateModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Update Task</h2>
            <form method="POST" action="">
                <input type="hidden" name="id" id="taskId">
                <input type="text" name="task" id="taskValue" required>
                <button type="submit" name="update">Update</button>
            </form>
        </div>
    </div>
</body>
</html>
