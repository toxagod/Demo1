@extends('layouts.app')

@section('title', 'Главная')

@section('styles')
<style>
    .slider-image {
        width: 100%;
        height: 250px;
        object-fit: cover;
        border-radius: 10px;
    }
    .carousel-indicators {
        bottom: -30px;
    }
    .carousel-caption {
        background: rgba(0, 0, 0, 0.5);
        border-radius: 5px;
        padding: 5px 10px;
        bottom: 10px;
        left: 10px;
        right: 10px;
        width: auto;
    }

</style>
@endsection

@section('content')
<div class="text-center mb-4">
    <h2 class="mb-3">Добро пожаловать на портал "Корочки.есть"</h2>
    <p class="lead">Онлайн курсы дополнительного профессионального образования</p>
</div>

<div id="classroomSlider" class="carousel slide mb-5" data-bs-ride="carousel">

    <div class="carousel-inner rounded shadow" style="border: 1px solid #dee2e6;">
        <div class="carousel-item active">
            <img src="{{ asset('media/image06.jpg') }}" class="d-block w-100 slider-image" alt="Компьютерный класс 1">
        </div>
        <div class="carousel-item">
            <img src="{{ asset('media/image07.jpg') }}" class="d-block w-100 slider-image" alt="Компьютерный класс 2">
        </div>
        <div class="carousel-item">
            <img src="{{ asset('media/image08.webp') }}" class="d-block w-100 slider-image" alt="Компьютерный класс 3">
        </div>
        <div class="carousel-item">
            <img src="{{ asset('media/image09.webp') }}" class="d-block w-100 slider-image" alt="Компьютерный класс 4">
        </div>
        <div class="carousel-item">
            <img src="{{ asset('media/image10.webp') }}" class="d-block w-100 slider-image" alt="Компьютерный класс 5">
        </div>
        <div class="carousel-item">
            <img src="{{ asset('media/image11.jpg') }}" class="d-block w-100 slider-image" alt="Компьютерный класс 6">
        </div>
        <div class="carousel-item">
            <img src="{{ asset('media/image12.webp') }}" class="d-block w-100 slider-image" alt="Компьютерный класс 7">
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title">О нашей платформе</h5>
        <p class="card-text">Портал "Корочки.есть" предоставляет доступ к качественным онлайн курсам 
        дополнительного профессионального образования. У нас вы найдете:</p>
        <ul>
            <li>Современные компьютерные классы</li>
            <li>Опытных преподавателей</li>
            <li>Актуальные программы обучения</li>
            <li>Гибкий график занятий</li>
            <li>Сертификаты об окончании</li>
        </ul>
        
        @if(!session('user_id'))
            <div class="d-grid gap-2">
                <a href="{{ route('register') }}" class="btn btn-primary">Начать обучение</a>
                <a href="{{ route('login') }}" class="btn btn-outline-primary">Войти в систему</a>
            </div>
        @elseif(!session('is_admin'))
            <div class="d-grid gap-2">
                <a href="{{ route('applications.create') }}" class="btn btn-primary">Подать новую заявку</a>
                <a href="{{ route('applications.index') }}" class="btn btn-outline-primary">Мои заявки</a>
            </div>
        @else
            <div class="d-grid gap-2">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Панель администратора</a>
            </div>
        @endif
    </div>
</div>

<div class="card mt-4">
    <div class="card-body">
        <h5 class="card-title">Наши преимущества</h5>
        <div class="row text-center">
            <div class="col-4">
                <div class="mb-2">
                    <i class="bi bi-laptop fs-3 text-primary"></i>
                </div>
                <h6>Онлайн-формат</h6>
                <small class="text-muted">Учитесь из любой точки мира</small>
            </div>
            <div class="col-4">
                <div class="mb-2">
                    <i class="bi bi-award fs-3 text-primary"></i>
                </div>
                <h6>Сертификаты</h6>
                <small class="text-muted">Документы об окончании</small>
            </div>
            <div class="col-4">
                <div class="mb-2">
                    <i class="bi bi-people fs-3 text-primary"></i>
                </div>
                <h6>Поддержка</h6>
                <small class="text-muted">Помощь преподавателей</small>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    $(document).ready(function() {
        const slider = new bootstrap.Carousel(document.getElementById('classroomSlider'), {
            interval: 1000,
            wrap: true,
            cycle: true
        });

    });
</script>
@endsection
@endsection