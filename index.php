<?php
session_start();

$todoList = array();

if (isset($_SESSION["todoList"])) {
    $todoList = $_SESSION["todoList"];
}

function appendData($data, &$todoList) {
    $todoList[] = $data;
}

function deleteData($toDelete, &$todoList) {
    foreach ($todoList as $index => $taskName) {
        if ($taskName === $toDelete) {
            unset( $todoList[$index] );
            break;
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (empty( $_POST["task"] )) {
        echo '<script>alert("Error: there is no data to add in array")</script>';
        exit;
    }

    appendData($_POST["task"], $todoList);
    $_SESSION["todoList"] = $todoList;
}

if (isset($_GET['delete']) && isset($_GET['task'])) {
    deleteData($_GET['task'], $todoList);
    $_SESSION["todoList"] = $todoList;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple To-Do List</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 800px;
            margin-top: 50px;
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .card {
            border: none;
            box-shadow: none;
        }

        .card-header {
            background-color: #fff;
            border-bottom: none;
            padding: 10px;
            font-weight: bold;
            font-size: 18px;
        }

        .form-control {
            border-radius: 5px;
            height: 40px;
            padding: 10px;
            font-size: 16px;
        }

        .btn {
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 16px;
        }

        .list-group-item {
            padding: 10px;
            border-radius: 5px;
            border: none;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .delete-btn {
            background-color: transparent;
            border: none;
            color: #dc3545;
            font-size: 16px;
            cursor: pointer;
        }

        .delete-btn:hover {
            text-decoration: underline;
        }

        .task-list {
            margin-top: 20px;
        }

        .custom-control {
            margin-right: 10px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">To-Do List</h1>
    <div class="card">
        <div class="card-header">Add a new task</div>
        <div class="card-body">
            <form method="post" action="">
                <div class="form-group">
                    <input type="text" class="form-control" name="task" placeholder="Enter your task here"></div>
                <button type="submit" class="btn btn-primary">Add Task</button>
            </form>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">Tasks</div>
        <div class="task-list">
            <?php
            if (!empty($todoList)) {
                foreach ($todoList as $task) {
                    echo '<label class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="task-' . htmlspecialchars($task) . '">
                                <label class="custom-control-label" for="task-' . htmlspecialchars($task) . '">' . htmlspecialchars($task) . '</label>
                            </div>
                            <span class="delete-btn" data-task="' . htmlspecialchars($task) . '">Delete</span>
                          </label>';
                }
            } else {
                echo '<li class="list-group-item">No tasks yet.</li>';
            }
            ?>
        </div>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    document.querySelectorAll('.delete-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const task = this.getAttribute('data-task');
            if (confirm('Are you sure you want to delete the task: ' + task + '?')) {
                window.location.href = 'index.php?delete=true&task=' + encodeURIComponent(task);
            }
        });
    });
</script>
</body>
</html>