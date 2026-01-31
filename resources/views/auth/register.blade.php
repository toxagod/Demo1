@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')
<div class="card">
    <div class="card-body">
        <h2 class="card-title text-center mb-4">Регистрация</h2>
        
        <form method="POST" action="{{ route('register') }}">
            @csrf
            
            <div class="mb-3">
                <label for="login" class="form-label">Логин *</label>
                <input type="text" class="form-control @error('login') is-invalid @enderror" 
                       id="login" name="login" value="{{ old('login') }}" required>
                @error('login')
                    <div class="error">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">Латиница и цифры, не менее 6 символов</small>
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label">Пароль *</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                       id="password" name="password" required>
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">Минимум 8 символов</small>
            </div>
            
            <div class="mb-3">
                <label for="full_name" class="form-label">ФИО *</label>
                <input type="text" class="form-control @error('full_name') is-invalid @enderror" 
                       id="full_name" name="full_name" value="{{ old('full_name') }}" required>
                @error('full_name')
                    <div class="error">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">Кириллица и пробелы</small>
            </div>
            
            <div class="mb-3">
                <label for="phone" class="form-label">Телефон *</label>
                <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                       id="phone" name="phone" value="{{ old('phone') }}" 
                       placeholder="8(XXX)XXX-XX-XX" required>
                @error('phone')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label">Email *</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                       id="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Создать пользователя</button>
                <a href="{{ route('login') }}" class="btn btn-link">Уже зарегистрированы? Войти</a>
            </div>
        </form>
    </div>
</div>

@section('scripts')
<script>
    $(document).ready(function() {
        $('#phone').on('input', function() {
            let x = $(this).val().replace(/\D/g, '').match(/(\d{0,1})(\d{0,3})(\d{0,3})(\d{0,2})(\d{0,2})/);
            if (!x) return '';
            $(this).val(!x[2] ? x[1] : x[1] + '(' + x[2] + ')' + x[3] + (x[4] ? '-' + x[4] : '') + (x[5] ? '-' + x[5] : ''));
        });
    });
</script>
@endsection
@endsection