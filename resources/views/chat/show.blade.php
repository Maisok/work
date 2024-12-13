<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Чат</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link rel="shortcut icon" href="{{asset('images/Group 438.png')}}" type="image/x-icon">
</head>
<body class="h-screen overflow-hidden">
    @include('components.header-seller')

    <div class="mt-20 w-full h-full">
        <div class="flex w-full h-full flex-col md:flex-row pb-24">
            <!-- Боковая панель для списка чатов на больших экранах -->
            <div class="chat-list-container w-1/3 p-4 md:block hidden">
                @include('components.chat-list', ['userChats' => $userChats])
            </div>

            <div class="flex-1 flex flex-col w-full h-full border-l border-gray-300">
                @if($chat && $advert)
                    <!-- Ссылка на страницу с чатами (только для мобильных устройств) -->
                    <a href="{{ route('chats.index') }}" class="md:hidden flex items-center justify-start w-full p-4 bg-white text-blue-500 hover:underline text-sm">
                        <i class="fas fa-arrow-left mr-2"></i> Назад к чатам
                    </a>

                    <!-- Шапка с информацией о товаре -->
                    <div class="flex items-center justify-between w-full p-4 bg-white">
                        <div class="flex items-center space-x-4">
                            <img alt="Product image" class="w-12 h-12 rounded-full" src="{{ $advert->image_url ?: asset('images/no-image.jpg') }}" width="50" height="50"/>
                            <div>
                                <h2 class="text-xl font-bold">
                                    <a href="{{ route('advert.show', ['advert' => $advert->id]) }}" class="text-blue-500 hover:underline">
                                        {{ $advert->product_name }}
                                    </a>
                                </h2>
                                <p class="text-lg text-gray-500">
                                    {{ $advert->price }}₽
                                </p>
                            </div>
                        </div>
                        <span class="text-lg text-gray-500">
                            {{ $messages->last()->created_at->format('d.m.Y') }}
                        </span>
                    </div>

                    <!-- Список сообщений -->
                    <div id="chat-messages" class="flex-1 p-4 w-full space-y-4 overflow-y-auto">
                        @foreach($messages as $message)
                            <div class="flex items-start space-x-4 @if($message->user_id === auth()->id()) justify-end @endif">
                                <img alt="User avatar" class="w-10 h-10 rounded-full" src="{{ $message->user->avatar_url ?: asset('images/noava.jpg') }}" width="50" height="50"/>
                                <div class="bg-gray-100 p-3 rounded-lg @if($message->user_id === auth()->id()) bg-green-100 @endif">
                                    <p>{{ $message->message }}</p>
                                </div>
                                <span class="text-sm text-gray-500">
                                    {{ $message->created_at->format('H:i') }}
                                </span>
                            </div>
                        @endforeach
                    </div>

                    <!-- Форма для отправки сообщения -->
                    <div class="p-4 border-t flex items-center space-x-4 pb-10 sm:pb-0">
                        <form action="{{ route('chat.send', ['chat' => $chat]) }}" method="POST" class="flex w-full">
                            @csrf
                            <input type="text" name="message" class="flex-1 p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Сообщение" required>
                            <button class="bg-blue-500 text-white px-4 py-2 rounded-lg" type="submit">
                                Отправить
                            </button>
                        </form>
                    </div>
                @else
                    <p class="text-gray-600 p-4">Выберите чат из списка.</p>
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
                    $('#chat-messages').append('<div class="flex items-start space-x-4 justify-end">' +
                        '<span class="text-sm text-gray-500">' + moment().format('H:i') + '</span>' +
                        '<div class="bg-green-100 p-3 rounded-lg">' +
                            '<p>' + response.message + '</p>' +
                        '</div>' +
                        '<img alt="User avatar" class="w-10 h-10 rounded-full" src="{{ auth()->user()->avatar_url ?: asset('images/noava.jpg') }}" width="50" height="50"/>' +
                    '</div>');
                    messageInput.val(''); // Очищаем поле ввода
                    $('#chat-messages').scrollTop($('#chat-messages')[0].scrollHeight); // Прокручиваем вниз
                },
                error: function(xhr) {
                    console.log(xhr.responseText); // Обработка ошибок
                }
            });
        });

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
                        var formattedTime = moment(message.created_at).format('H:i');
                        var messageDate = moment(message.created_at).format('YYYY-MM-DD');

                        // Добавляем дату, если это первое сообщение за день
                        if (lastDate !== messageDate) {
                            $('#chat-messages').append('<div class="message-date text-center text-gray-500 text-sm my-2">' + moment(message.created_at).format('DD.MM.YYYY') + '</div>');
                            lastDate = messageDate;
                        }

                        // Добавляем сообщение с аватаром и временем
                        $('#chat-messages').append('<div class="flex items-start space-x-4 ' + (message.user_id === {{ auth()->id() }} ? 'justify-end' : '') + '">' +
                            '<img alt="User avatar" class="w-10 h-10 rounded-full" src="' + message.user.avatar_url + '" width="50" height="50"/>' +
                            '<div class="bg-gray-100 p-3 rounded-lg ' + (message.user_id === {{ auth()->id() }} ? 'bg-green-100' : '') + '">' +
                                '<p>' + message.message + '</p>' +
                            '</div>' +
                            '<span class="text-sm text-gray-500">' + formattedTime + '</span>' +
                        '</div>');
                    });
                    $('#chat-messages').scrollTop($('#chat-messages')[0].scrollHeight); // Прокручиваем вниз
                },
                error: function(xhr) {
                    console.log(xhr.responseText); // Обработка ошибок
                }
            });
        }

        // Запускаем функцию каждые 5 секунд (опционально)
        setInterval(fetchMessages, 5000);
    });
    </script>
</body>
</html>