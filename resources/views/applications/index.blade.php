@extends('layouts.app')

@section('title', 'Мои заявки')

@section('content')
<h2 class="mb-4">Мои заявки</h2>

@if($applications->isEmpty())
<div class="alert alert-info">
    У вас пока нет заявок. <a href="{{ route('applications.create') }}">Создать первую заявку</a>
</div>
@else
    @foreach($applications as $application)
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">{{ $application->course->name }}</h5>
            
            <div class="mb-2">
                <strong>Дата начала:</strong> {{ date('d.m.Y', strtotime($application->start_date)) }}
            </div>
            
            <div class="mb-2">
                <strong>Способ оплаты:</strong> 
                {{ $application->payment_method == 'cash' ? 'Наличными' : 'Перевод по телефону' }}
            </div>
            
            <div class="mb-3">
                <strong>Статус:</strong>
                <span class="status-{{ $application->status }}">
                    @if($application->status == 'new')
                        Новая
                    @elseif($application->status == 'in_progress')
                        Идет обучение
                    @else
                        Обучение завершено
                    @endif
                </span>
            </div>
            
            <div class="mb-2">
                <strong>Дата подачи:</strong> {{ $application->created_at->format('d.m.Y H:i') }}
            </div>
            
            @if($application->status == 'completed')
                @if($application->review)
                <div class="alert alert-success mt-3">
                    <strong>Ваш отзыв:</strong> {{ $application->review->rating }}/5
                    <p class="mb-0 mt-2">{{ $application->review->comment }}</p>
                </div>
                @else
                <button class="btn btn-sm btn-outline-primary mt-2" 
                        data-bs-toggle="modal" 
                        data-bs-target="#reviewModal{{ $application->id }}">
                    Оставить отзыв
                </button>
                
                <div class="modal fade" id="reviewModal{{ $application->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Отзыв о курсе "{{ $application->course->name }}"</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form method="POST" action="{{ route('applications.review.store', $application) }}">
                                @csrf
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Оценка (1-5)</label>
                                        <select class="form-select" name="rating" required>
                                            <option value="5">5 - Отлично</option>
                                            <option value="4">4 - Хорошо</option>
                                            <option value="3">3 - Удовлетворительно</option>
                                            <option value="2">2 - Плохо</option>
                                            <option value="1">1 - Очень плохо</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Комментарий</label>
                                        <textarea class="form-control" name="comment" rows="3" 
                                                  placeholder="Расскажите о своем опыте обучения..." 
                                                  required minlength="10"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                                    <button type="submit" class="btn btn-primary">Отправить отзыв</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
            @endif
        </div>
    </div>
    @endforeach
@endif

<div class="d-grid">
    <a href="{{ route('applications.create') }}" class="btn btn-primary">Подать новую заявку</a>
</div>
@endsection