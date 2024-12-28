<?php

$task = '';
$readyToStore = false;


function connectToDB() {

    $conn = new mysqli("localhost", "root", "", "guestbook_todo");


    if($conn->connect_error) {
        return false;
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

$conn = connectToDB();

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['submit']) && isset($_POST['task'])) {
    $task = htmlspecialchars($_POST['task']);
    $readyToStore = true;
}


if ($readyToStore && $conn) {
    $sql = "INSERT INTO todo (task) VALUES ('$task')";
    if ($conn->query($sql) === TRUE) {
        echo "Task added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']);
    $sql = "DELETE FROM todo WHERE id = $delete_id";
    if ($conn->query($sql) === TRUE) {
        echo "Task deleted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


if ($conn) {
    $sql = "SELECT * FROM todo ORDER BY created_at DESC";
    $result = $conn->query($sql);
    $tasks = "";

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tasks .= '<div class="task">
                <span class="task-name">'.$row['task'].'</span>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="delete_id" value="'.$row['id'].'">
                    <button type="submit" class="delete-btn">Delete</button>
                </form>
            </div>';
        }
    } else {
        $tasks = "<p>No tasks found. Add a new task!</p>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Todo List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #007bff;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .form-container {
            margin-bottom: 20px;
        }

        input[type="text"] {
            width: calc(100% - 90px);
            padding: 10px;
            margin-right: 10px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }

        .submit-btn {
            padding: 10px 15px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .task {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f9f9f9;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 3px;
            margin-bottom: 10px;
        }

        .delete-btn {
            padding: 5px 10px;
            background-color: #dc3545;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Todo List</h1>

        <div class="form-container">
            <form method="post">
                <input type="text" name="task" placeholder="Add a new task" required>
                <button name="submit" type="submit" class="submit-btn">Add Task</button>
            </form>
        </div>

        <div class="tasks-container">
            <?= $tasks ?>
        </div>
    </div>
</body>
</html>
