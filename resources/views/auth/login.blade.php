@extends('layouts.app')

@section('title', 'Вход')

@section('content')
<div class="card">
    <div class="card-body">
        <h2 class="card-title text-center mb-4">Вход в систему</h2>
        
        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="mb-3">
                <label for="login" class="form-label">Логин</label>
                <input type="text" class="form-control @error('login') is-invalid @enderror" 
                       id="login" name="login" value="{{ old('login') }}" required>
                @error('login')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label">Пароль</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                       id="password" name="password" required>
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <small class="text-muted">Для администратора: Admin / KorokNET</small>
            </div>
            
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Войти</button>
                <a href="{{ route('register') }}" class="btn btn-link">Еще не зарегистрированы? Регистрация</a>
            </div>
        </form>
    </div>
</div>
@endsection