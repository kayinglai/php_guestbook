<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Todo List</title>
    <style>
        /* Reset and base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #f0f4ff 0%, #f5f7ff 100%);
            padding: 2rem 1rem;
        }

        /* Container styles */
        .container {
            max-width: 42rem;
            margin: 0 auto;
        }

        .todo-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            padding: 1.5rem;
        }

        /* Header styles */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .title {
            font-size: 1.875rem;
            font-weight: bold;
            color: #1f2937;
        }

        .progress {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: #6b7280;
        }

        .progress-icon {
            color: #10b981;
            width: 1.25rem;
            height: 1.25rem;
        }

        /* Form styles */
        .todo-form {
            margin-bottom: 1.5rem;
        }

        .input-group {
            display: flex;
            gap: 0.5rem;
        }

        .todo-input {
            flex: 1;
            padding: 0.75rem 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: all 0.2s;
        }

        .todo-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }

        .add-button {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background-color: #3b82f6;
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .add-button:hover {
            background-color: #2563eb;
        }

        /* Todo item styles */
        .todo-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .todo-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            background: white;
            border: 1px solid #f3f4f6;
            border-radius: 0.5rem;
            transition: all 0.2s;
        }

        .todo-item:hover {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .todo-content {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .checkbox {
            width: 1.25rem;
            height: 1.25rem;
            border: 2px solid #d1d5db;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.2s;
        }

        .checkbox.checked {
            background-color: #10b981;
            border-color: #10b981;
            position: relative;
        }

        .checkbox.checked::after {
            content: "✓";
            position: absolute;
            color: white;
            font-size: 0.75rem;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .todo-text {
            color: #374151;
        }

        .todo-text.completed {
            color: #9ca3af;
            text-decoration: line-through;
        }

        .delete-button {
            opacity: 0;
            color: #ef4444;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.25rem;
            transition: all 0.2s;
        }

        .todo-item:hover .delete-button {
            opacity: 1;
        }

        .delete-button:hover {
            color: #dc2626;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="todo-card">
            <div class="header">
                <h1 class="title">My Tasks</h1>
                <div class="progress">
                    <svg class="progress-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>1/2 completed</span>
                </div>
            </div>

            <form class="todo-form">
                <div class="input-group">
                    <input type="text" class="todo-input" placeholder="Add a new task...">
                    <button type="submit" class="add-button">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="16" />
                            <line x1="8" y1="12" x2="16" y2="12" />
                        </svg>
                        Add Task
                    </button>
                </div>
            </form>

            <div class="todo-list">
                <!-- Completed todo item -->
                <div class="todo-item">
                    <div class="todo-content">
                        <div class="checkbox checked"></div>
                        <span class="todo-text completed">Complete project presentation</span>
                    </div>
                    <button class="delete-button">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>

                <!-- Uncompleted todo item -->
                <div class="todo-item">
                    <div class="todo-content">
                        <div class="checkbox"></div>
                        <span class="todo-text">Review team feedback</span>
                    </div>
                    <button class="delete-button">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>