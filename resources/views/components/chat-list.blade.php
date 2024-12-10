<div class="w-1/3 p-4 ">
    <h2 class="text-2xl font-bold mb-4">Чаты</h2>
    <div class="space-y-4">
        @foreach($userChats as $userChat)
            <div class="flex items-center space-x-4 p-2 rounded-lg chat-item" data-chat-id="{{ $userChat->id }}">
                <a href="{{ route('chat.show', ['chat' => $userChat]) }}" class="flex items-center space-x-4 w-full">
                    <!-- Отображаем аватар пользователя -->
                    <img src="{{ ($userChat->user1_id == auth()->id() ? $userChat->user2->avatar_url : $userChat->user1->avatar_url) ?: asset('images/noava.jpg') }}" alt="Аватар" class="w-12 h-12 rounded-full avatar">
                    <div class="flex-1">
                        <!-- Отображаем имя пользователя и время последнего сообщения -->
                        <div class="flex justify-between items-center">
                            <h3 class="font-semibold text-black">
                                {{ $userChat->user1_id == auth()->id() ? $userChat->user2->username : $userChat->user1->username }}
                            </h3>
                            @if($userChat->last_message)
                                <span class="text-sm text-gray-500">
                                    {{ $userChat->last_message->created_at->format('H:i') }}
                                </span>
                            @endif
                        </div>
                        <!-- Отображаем название товара по которому диалог -->
                        <p class="text-sm text-black">
                            Название товара по которому диалог
                        </p>
                        <!-- Отображаем текст последнего сообщения -->
                        <p class="text-sm text-gray-400">
                            @if($userChat->last_message)
                                {{ Str::limit($userChat->last_message->message, 20, '...') }}
                            @else
                                Нет сообщений
                            @endif
                        </p>
                    </div>
                    <!-- Отображаем счетчик непрочитанных сообщений -->
                    @if($userChat->unread_count > 0)
                        <span class="bg-blue-500 text-white rounded-full px-2 py-1 text-xs unread-count">{{ $userChat->unread_count }}</span>
                    @else
                        <span class="bg-blue-500 text-white rounded-full px-2 py-1 text-xs unread-count" style="display: none;"></span>
                    @endif
                </a>
            </div>
        @endforeach
    </div>
</div>