<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>Корочки.есть - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
        }
        .navbar-brand {
            font-weight: bold;
            color: #0d6efd !important;
        }
        .container {
            max-width: 390px;
            padding: 15px;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }
        .error {
            color: #dc3545;
            font-size: 0.875em;
        }
        .status-new { color: #ffc107; font-weight: bold; }
        .status-in_progress { color: #0dcaf0; font-weight: bold; }
        .status-completed { color: #198754; font-weight: bold; }
    </style>
    @yield('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">Корочки.есть</a>
        <div class="navbar-nav ms-auto">
            @if(session('user_id'))
                <span class="nav-item me-3 text-muted">
                    {{ session('user_name') }}
                    @if(session('is_admin'))
                        <span class="badge bg-danger ms-1">Админ</span>
                    @endif
                </span>
                @if(session('is_admin'))
                    <a class="nav-link" href="{{ route('admin.dashboard') }}">Панель администратора</a>
                @else
                    <a class="nav-link" href="{{ route('applications.index') }}">Мои заявки</a>
                    <a class="nav-link" href="{{ route('applications.create') }}">Новая заявка</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="nav-link btn btn-link" style="border: none; background: none;">
                        Выйти
                    </button>
                </form>
            @else
                <a class="nav-link" href="{{ route('login') }}">Войти</a>
                <a class="nav-link" href="{{ route('register') }}">Регистрация</a>
            @endif
        </div>
    </div>
</nav>

    <main class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    @yield('scripts')
</body>
</html>