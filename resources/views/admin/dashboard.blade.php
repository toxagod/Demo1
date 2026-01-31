@extends('layouts.app')

@section('title', 'Панель администратора')

@section('styles')
<style>
    .table-responsive {
        overflow-x: auto;
    }
    .table th {
        white-space: nowrap;
    }
    .status-badge {
        padding: 0.25em 0.6em;
        border-radius: 0.25rem;
        font-size: 0.875em;
    }
    .badge-new { background-color: #ffc107; color: #000; }
    .badge-in_progress { background-color: #0dcaf0; color: #000; }
    .badge-completed { background-color: #198754; color: #fff; }
</style>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Панель администратора</h2>
    <div class="text-muted">
        Всего заявок: {{ $applications->total() }}
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.dashboard') }}" class="row g-2">
            <div class="col-md-4">
                <select class="form-select" name="status">
                    <option value="">Все статусы</option>
                    <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>Новые</option>
                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>В процессе</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Завершённые</option>
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100">Фильтровать</button>
            </div>
            <div class="col-md-4">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary w-100">Сбросить</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($applications->isEmpty())
            <div class="alert alert-info">Заявок пока нет</div>
        @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Пользователь</th>
                            <th>Курс</th>
                            <th>Дата начала</th>
                            <th>Способ оплаты</th>
                            <th>Статус</th>
                            <th>Дата подачи</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($applications as $application)
                        <tr>
                            <td>#{{ $application->id }}</td>
                            <td>{{ $application->user->full_name }}<br>
                                <small class="text-muted">{{ $application->user->email }}</small>
                            </td>
                            <td>{{ $application->course->name }}</td>
                            <td>{{ date('d.m.Y', strtotime($application->start_date)) }}</td>
                            <td>{{ $application->payment_method == 'cash' ? 'Наличные' : 'Перевод' }}</td>
                            <td>
                                <span class="status-badge badge-{{ $application->status }}">
                                    @if($application->status == 'new')
                                        Новая
                                    @elseif($application->status == 'in_progress')
                                        Идет обучение
                                    @else
                                        Обучение завершено
                                    @endif
                                </span>
                            </td>
                            <td>{{ $application->created_at->format('d.m.Y H:i') }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-primary dropdown-toggle" 
                                            type="button" data-bs-toggle="dropdown">
                                        Изменить статус
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <form method="POST" action="{{ route('admin.applications.update', $application) }}">
                                                @csrf
                                                <button type="submit" name="status" value="new" 
                                                        class="dropdown-item" 
                                                        onclick="return confirm('Изменить статус на "Новая"?')">
                                                    Новая
                                                </button>
                                            </form>
                                        </li>
                                        <li>
                                            <form method="POST" action="{{ route('admin.applications.update', $application) }}">
                                                @csrf
                                                <button type="submit" name="status" value="in_progress" 
                                                        class="dropdown-item" 
                                                        onclick="return confirm('Изменить статус на "Идет обучение"?')">
                                                    Идет обучение
                                                </button>
                                            </form>
                                        </li>
                                        <li>
                                            <form method="POST" action="{{ route('admin.applications.update', $application) }}">
                                                @csrf
                                                <button type="submit" name="status" value="completed" 
                                                        class="dropdown-item" 
                                                        onclick="return confirm('Изменить статус на "Обучение завершено"?')">
                                                    Обучение завершено
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <nav aria-label="Навигация по страницам" class="mt-4">
                <ul class="pagination justify-content-center">
                    {{ $applications->links() }}
                </ul>
            </nav>
        @endif
    </div>
</div>

<div class="mt-4 text-center">
    <a href="{{ route('home') }}" class="btn btn-outline-secondary">На главную</a>
</div>
@endsection