<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>

<body>
    <div class="sidebar bg-dark">
        <a class="TITLE" href="{{ route('index') }}">
            <h1 class="text-center fw-bold">MY WORK</h1>
        </a>
        <nav class="nav flex-column">
            <a class="nav-link" href="{{ route('index') }}">Home</a>
            <a class="nav-link" href="{{ route('leave') }}">Leave</a>
            <a class="nav-link" href="{{ route('task') }}">Task</a>
        </nav>
    </div>

    <div class="overlay"></div>

    <button class="sidebar-toggle btn btn-primary">
        <i class="bi bi-list" style="color: #007bff"></i>
    </button>

    <div class="content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.sidebar');
            const sidebarToggle = document.querySelector('.sidebar-toggle');
            const overlay = document.querySelector('.overlay');

            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
            });

            overlay.addEventListener('click', () => {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            });
        });
    </script>
</body>

</html>