<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My To-Do List</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 40px 16px;
            font-family: Arial, sans-serif;
            background: #f4f6fb;
            color: #252a34;
        }

        .container {
            max-width: 650px;
            margin: 0 auto;
            padding: 30px;
            background: white;
            border-radius: 14px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.08);
        }

        h1 {
            margin-top: 0;
            text-align: center;
            color: #4f46e5;
        }

        .subtitle {
            text-align: center;
            color: #777;
            margin-bottom: 28px;
        }

        input[type="text"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #d5d8e0;
            border-radius: 7px;
            font-size: 15px;
        }

        button {
            padding: 10px 14px;
            border: none;
            border-radius: 7px;
            cursor: pointer;
            font-size: 14px;
        }

        .add-button {
            width: 100%;
            margin-top: 10px;
            background: #4f46e5;
            color: white;
        }

        .add-button:hover {
            background: #3730a3;
        }

        .task {
            margin-top: 16px;
            padding: 16px;
            border: 1px solid #e5e7eb;
            border-radius: 9px;
        }

        .task form {
            margin-top: 10px;
        }

        .task-title {
            margin-bottom: 8px;
            font-weight: bold;
        }

        .completed {
            color: #16803d;
            text-decoration: line-through;
        }

        .checkbox-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 12px 0;
            font-size: 14px;
        }

        .save-button {
            background: #16a34a;
            color: white;
        }

        .delete-button {
            background: #dc2626;
            color: white;
        }

        .success {
            padding: 12px;
            margin-bottom: 18px;
            background: #dcfce7;
            color: #166534;
            border-radius: 7px;
        }

        .error {
            margin-top: 6px;
            color: #dc2626;
            font-size: 13px;
        }

        .empty {
            text-align: center;
            padding: 25px 0;
            color: #777;
        }

        @media (max-width: 480px) {
            .container {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
<div class="container">
    <h1>My To-Do List</h1>
    <p class="subtitle">Organize your day, one task at a time.</p>

    @if (session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('todos.store') }}" method="POST">
        @csrf

        <input
            type="text"
            name="title"
            placeholder="Enter a new task..."
            value="{{ old('title') }}"
            required
            maxlength="255"
        >

        @error('title')
            <div class="error">{{ $message }}</div>
        @enderror

        <button type="submit" class="add-button">+ Add Task</button>
    </form>

    <h2>Your Tasks</h2>

    @forelse ($todos as $todo)
        <div class="task">
            <div class="task-title {{ $todo->is_completed ? 'completed' : '' }}">
                {{ $todo->title }}
            </div>

            <form action="{{ route('todos.update', $todo) }}" method="POST">
                @csrf
                @method('PATCH')

                <input
                    type="text"
                    name="title"
                    value="{{ $todo->title }}"
                    required
                    maxlength="255"
                    aria-label="Edit task title"
                >

                <label class="checkbox-row">
                    <input
                        type="checkbox"
                        name="is_completed"
                        value="1"
                        {{ $todo->is_completed ? 'checked' : '' }}
                    >
                    Mark as completed
                </label>

                <button type="submit" class="save-button">
                    Save Changes
                </button>
            </form>

            <form
                action="{{ route('todos.destroy', $todo) }}"
                method="POST"
                onsubmit="return confirm('Are you sure you want to delete this task?')"
            >
                @csrf
                @method('DELETE')

                <button type="submit" class="delete-button">
                    Delete
                </button>
            </form>
        </div>
    @empty
        <div class="empty">
            No tasks yet. Add your first task above!
        </div>
    @endforelse
</div>
</body>
</html>