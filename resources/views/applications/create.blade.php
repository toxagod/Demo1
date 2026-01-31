@extends('layouts.app')

@section('title', 'Новая заявка')

@section('content')
<div class="card">
    <div class="card-body">
        <h2 class="card-title text-center mb-4">Новая заявка на обучение</h2>
        
        <form method="POST" action="{{ route('applications.store') }}">
            @csrf
            
            <div class="mb-3">
                <label for="course_id" class="form-label">Наименование курса *</label>
                <select class="form-select @error('course_id') is-invalid @enderror" 
                        id="course_id" name="course_id" required>
                    <option value="">Выберите курс</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" 
                                {{ old('course_id') == $course->id ? 'selected' : '' }}>
                            {{ $course->name }}
                        </option>
                    @endforeach
                </select>
                @error('course_id')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="start_date" class="form-label">Желаемая дата начала обучения *</label>
                <input type="text" class="form-control @error('start_date') is-invalid @enderror" 
                       id="start_date" name="start_date" value="{{ old('start_date') }}" 
                       placeholder="ДД.ММ.ГГГГ" required>
                @error('start_date')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-4">
                <label class="form-label">Способ оплаты *</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="payment_method" 
                           id="cash" value="cash" 
                           {{ old('payment_method') == 'cash' ? 'checked' : '' }} required>
                    <label class="form-check-label" for="cash">
                        Наличными
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="payment_method" 
                           id="phone_transfer" value="phone_transfer" 
                           {{ old('payment_method') == 'phone_transfer' ? 'checked' : '' }}>
                    <label class="form-check-label" for="phone_transfer">
                        Переводом по номеру телефона
                    </label>
                </div>
                @error('payment_method')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Отправить заявку</button>
                <a href="{{ route('applications.index') }}" class="btn btn-outline-secondary">Назад к списку заявок</a>
            </div>
        </form>
    </div>
</div>

@section('scripts')
<script>
    $(document).ready(function() {
        $('#start_date').on('input', function() {
            let x = $(this).val().replace(/\D/g, '').match(/(\d{0,2})(\d{0,2})(\d{0,4})/);
            if (!x) return '';
            $(this).val(x[1] + (x[2] ? '.' + x[2] : '') + (x[3] ? '.' + x[3] : ''));
        });
    });
</script>
@endsection
@endsection