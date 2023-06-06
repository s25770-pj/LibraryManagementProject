<?php
require_once 'database.php';
require_once 'tasks.php';

$db = new Database('localhost', 'root', '', 'team_management');
$taskRepository = new TaskRepository($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_task'])) {
    $title = $_POST['title'];
    $completed = isset($_POST['completed']) ? 1 : 0;

    $taskRepository->createTask($title, $completed);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_task'])) {
    $taskId = $_POST['task_id'];

    $taskRepository->deleteTask($taskId);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_task'])) {
    $title = $_POST['title'];
    $taskId = $_POST['task_id'];
    $completed = isset($_POST['completed']) ? 1 : 0;

    $taskRepository->updateTask($taskId, $title, $completed);
}

$tasks = $taskRepository->getAllTasks();
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>List of tasks</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>List of tasks</h1>

    <h2>Add new task</h2>
    <form action="" method="POST">
        <input type="text" name="title" placeholder="Task title" required>
        <label><input type="checkbox" name="completed"> Completed</label>
        <button type="submit" name="add_task">Add task</button>
    </form>

    <h2>List of tasks</h2>
    <ul>
        <?php foreach ($tasks as $task): ?>
            <li>
                <span class="task-title"><?php echo $task['title']; ?></span>
                <?php if ($task['completed']): ?>
                    <span class="task-status">(Completed)</span>
                <?php else: ?>
                    <span class="task-status">(Not completed)</span>
                <?php endif; ?>
                <form action="" method="POST" class="task-form">
                    <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                    <input type="text" name="title" value="<?php echo $task['title']; ?>">
                    <label><input type="checkbox" name="completed" <?php if ($task['completed']) echo 'checked'; ?>> Completed</label>
                    <button type="submit" name="update_task">Update</button>
                    <button type="submit" name="delete_task">Delete</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
    <script src="script.js"></script>
</body>
</html>