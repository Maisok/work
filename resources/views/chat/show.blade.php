
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Чат</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
</head>
<body class="">
@extends('layouts.app')
@include('components.header-seller')

<div class=" mt-20 mb-24">
    <div class="flex flex-col md:flex-row">
        @include('components.chat-list', ['userChats' => $userChats]) <!-- Подключаем компонент список чатов -->

        <div class="w-full p-4"> <!-- Чат занимает всю ширину на всех экранах -->
            @if($chat && $advert) 
                <!-- Chat Header -->
                <div class="flex items-center justify-between p-4 border-b border-gray-300 w-full">
                    <div class="flex items-center space-x-4">
                        <img alt="Product image" class="w-12 h-12 rounded-full" src="{{ $advert->image_url ?: asset('images/noimage.jpg') }}" width="50" height="50">
                        <div>
                            <h2 class="text-xl font-bold">
                                <a href="{{ route('advert.show', ['advert' => $advert->id]) }}" class="text-blue-500 hover:underline">
                                    {{ $advert->product_name }} <!-- Здесь отображается название объявления -->
                                </a>
                            </h2>
                            <p class="text-lg text-gray-500">
                                {{ $advert->price }}₽
                            </p>
                        </div>
                    </div>
                    <span class="text-lg text-gray-500">
                        {{ $chat->created_at->format('d.m.Y') }}
                    </span>
                </div>
        
                <!-- Chat Messages -->
                <div id="chat-messages" class="flex-1 p-4 space-y-4 overflow-y-auto h-96 w-full">
                    @foreach($messages as $message)
                        @if(!isset($lastDate) || $lastDate != $message->created_at->toDateString())
                            <div class="message-date text-center text-gray-500 text-sm my-2">{{ $message->created_at->format('d.m.Y') }}</div>
                            @php
                                $lastDate = $message->created_at->toDateString();
                            @endphp
                        @endif
                        <div class="message @if($message->user_id === auth()->id()) justify-end @else justify-start @endif">
                            <div class="flex items-start space-x-4">
                                <img alt="User avatar" class="w-12 h-12 rounded-full" src="{{ $message->user->avatar_url ?: asset('images/noava.jpg') }}" width="50" height="50">
                                <div class="bg-gray-100 p-4 rounded-lg @if($message->user_id === auth()->id()) bg-green-100 @endif">
                                    <p>
                                        <strong>{{ $message->user->username }}</strong> {{ $message->message }}
                                    </p>
                                    <span class="text-sm text-gray-500">
                                        {{ $message->created_at->format('H:i') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
        
                <!-- Chat Input -->
                <form action="{{ route('chat.send', ['chat' => $chat]) }}" method="POST" class="p-4 border-t border-gray-300 flex items-center space-x-4">
                    @csrf
                    <input type="text" name="message" class="flex-1 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Введите сообщение" required>
                    <button class="bg-blue-500 text-white px-4 py-2 rounded-lg" type="submit">Отправить</button>
                </form>
            @else
                <p class="text-gray-600">Выберите чат из списка.</p>
            @endif
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Обработчик отправки формы
    $('form').on('submit', function(e) {
        e.preventDefault(); // Предотвращаем стандартное поведение формы

        var messageInput = $(this).find('input[name="message"]');
        var message = messageInput.val();
        var chatId = '{{ $chat->id }}'; // Получаем ID чата

        $.ajax({
            url: '/chat/' + chatId + '/send',
            type: 'POST',
            data: {
                message: message,
                _token: '{{ csrf_token() }}' // Добавляем CSRF-токен
            },
            success: function(response) {
                // Добавляем новое сообщение в интерфейс
                $('#chat-messages').append('<div class="message sent">' + response.message + ' <span class="text-muted text-xs text-gray-500">just now</span></div>');
                messageInput.val(''); // Очищаем поле ввода
                $('#chat-messages').scrollTop($('#chat-messages')[0].scrollHeight); // Прокручиваем вниз

                // Отмечаем сообщения как прочитанные
                markMessagesAsRead(chatId);
            },
            error: function(xhr) {
                console.log(xhr.responseText); // Обработка ошибок
            }
        });
    });

    // Функция для отметки сообщений как прочитанных
    function markMessagesAsRead(chatId) {
        $.ajax({
            url: '/chat/' + chatId + '/mark-as-read',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                // Обновляем статус сообщений в интерфейсе
                $('.message.received').each(function() {
                    var isRead = $(this).find('img.status-icon').attr('src').includes('messageyes.png');
                    if (isRead) {
                        $(this).find('img.status-icon').attr('src', '{{ asset('images/messageyes.png') }}');
                    } else {
                        $(this).find('img.status-icon').attr('src', '{{ asset('images/messageno.png') }}');
                    }
                });
            },
            error: function(xhr) {
                console.log(xhr.responseText); // Обработка ошибок
            }
        });
    }

    // Отмечаем сообщения как прочитанные при загрузке страницы
    markMessagesAsRead('{{ $chat->id }}');

    // Функция для периодической проверки новых сообщений
    function fetchMessages() {
        var chatId = '{{ $chat->id }}'; // Получаем ID чата

        $.ajax({
            url: '/chat/' + chatId + '/messages', // Создайте этот маршрут и метод в контроллере
            type: 'GET',
            success: function(response) {
                $('#chat-messages').empty(); // Очищаем старые сообщения
                var lastDate = null;
                response.messages.forEach(function(message) {
                    // Форматируем время с помощью moment.js
                    var formattedTime = moment(message.created_at).fromNow();
                    var messageDate = moment(message.created_at).format('YYYY-MM-DD');

                    // Добавляем дату, если это первое сообщение за день
                    if (lastDate !== messageDate) {
                        $('#chat-messages').append('<div class="message-date text-center text-gray-500 text-sm my-2">' + moment(message.created_at).format('DD.MM.YYYY') + '</div>');
                        lastDate = messageDate;
                    }

                    // Определяем статус сообщения
                    var readStatus = message.is_read ? '<img src="{{ asset('images/messageyes.png') }}" alt="Прочитано" class="status-icon w-4">' : '<img src="{{ asset('images/messageno.png') }}" alt="Не прочитано" class="status-icon w-4">';

                    // Добавляем сообщение с аватаром и статусом
                    $('#chat-messages').append('<div class="message ' + (message.user_id === {{ auth()->id() }} ? 'sent' : 'received') + '">' +
                        '<img src="' + message.user.avatar_url + '" alt="Аватар" class="w-10 h-10 rounded-full avatar">' +
                        '<div class="message-content">' +
                            '<strong>' + message.user.username + '</strong> ' + message.message +
                            '<span class="text-muted text-xs text-gray-500">' + formattedTime + '</span>' +
                            (message.user_id !== {{ auth()->id() }} ? readStatus : '') +
                        '</div>' +
                    '</div>');
                });
                $('#chat-messages').scrollTop($('#chat-messages')[0].scrollHeight); // Прокручиваем вниз

                // Отмечаем сообщения как прочитанные
                markMessagesAsRead(chatId);
            },
            error: function(xhr) {
                console.log(xhr.responseText); // Обработка ошибок
            }
        });
    }

    // Запускаем функцию каждые 5 секунд (опционально)
    // setInterval(fetchMessages, 5000);

    // Отмечаем сообщения как прочитанные при загрузке страницы
    markMessagesAsRead('{{ $chat->id }}');
});
</script>

</body>
</html>