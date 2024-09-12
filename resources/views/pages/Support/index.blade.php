@extends('layouts.support.app')

@section('content')
    <div class="container">
        <ul id="messages-list">
            @foreach($data as $item)
            {{$item->messages}}</br>
            @endforeach
        </ul>
    </div>
    <div>
        <form id="message-form">
            @csrf
            <input type="text" name="message" id="message-input" placeholder="Type your message">
            <button type="submit">Send</button>
        </form>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        let form = document.getElementById('message-form');
        form.addEventListener('submit', function (e) {
            e.preventDefault(); // Отменяем стандартное поведение формы

            let messageInput = document.getElementById('message-input');
            let message = messageInput.value;

            // Отправляем запрос с помощью fetch
            fetch('{{ route('support.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message: message })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Message sent:', data);
                messageInput.value = ''; // Очищаем поле ввода
            })
            .catch(error => console.error('Error:', error));
        });

        // Подписываемся на WebSocket
        window.Echo.channel('message')
            .listen('.message', (event) => {
                console.log('Message received:', event.message);
                let messagesList = document.getElementById('messages-list');
                let newMessage = document.createElement('li');
                newMessage.textContent = event.message.messages;
                messagesList.appendChild(newMessage);
            });
    });
</script>

@endsection