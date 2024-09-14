@extends('layouts.support.app')

@section('content')
    <div class="container mt-4">
        <!-- Фильтрация чатов -->
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <h2>Чаты поддержки</h2>

            <!-- Кнопки для фильтрации -->
            <div class="btn-group" role="group" aria-label="Фильтр чатов">
                <button id="all_but" class="btn btn-secondary">Все</button>
                <button id="read_but" class="btn btn-success">Прочитанные</button>
                <button id="unread_but" class="btn btn-warning">Непрочитанные</button>
            </div>
        </div>

        <!-- Список чатов -->
        <div id="chatList">
            @if(!$data->isEmpty())
                <div class="list-group">
                    @foreach($data as $item)
                        @php
                            $statusClass = (int) $item->status === 0 ? 'read' : 'unread';
                        @endphp

                        <div class="list-group-item justify-content-between align-items-center chat-item {{ $statusClass }}" style="background-color: #27293d; border: #27293d; display:flex">
                            <div class="d-flex align-items-center">
                                <!-- Кружок статуса -->
                                <span class="status-circle {{ $statusClass === 'read' ? 'bg-success' : 'bg-warning' }}"></span>
                                <div class="ml-2">
                                    <h5 class="mb-1">ID: {{$item->chat_id}}</h5>
                                    <p class="mb-1">{{$item->name}}</p>
                                </div>
                            </div>
                            <a href="{{ route('support.show', $item->chat_id) }}" class="btn btn-primary" style="color: white;">Перейти</a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info mt-3" role="alert">
                    Сообщений пока нет.
                </div>
            @endif
        </div>
    </div>
@endsection

<style>
    .bg-success {
        background-color: #28a745 !important;
    }
    .bg-warning {
        background-color: #ffc107 !important;
    }
    .status-circle {
        display: inline-block;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        margin-right: 10px;
    }
    .chat-item {
        display: table; /* Это гарантирует, что элементы будут отображаться */
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const allBut = document.getElementById('all_but');
    const readBut = document.getElementById('read_but');
    const unreadBut = document.getElementById('unread_but');
    const chatItems = document.querySelectorAll('.chat-item');

    // Функция показа всех чатов
    allBut.addEventListener('click', function() {
        chatItems.forEach(item => {
            item.style.display = 'flex';
        });
    });

    // Функция показа только прочитанных чатов
    readBut.addEventListener('click', function() {
        chatItems.forEach(item => {
            if (item.classList.contains('read')) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    });

    // Функция показа только непрочитанных чатов
    unreadBut.addEventListener('click', function() {
        chatItems.forEach(item => {
            if (item.classList.contains('unread')) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    });
});
</script>
