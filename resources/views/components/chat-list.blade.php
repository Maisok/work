<div class="w-full md:w-1/4 p-4 chat-list h-screen">
    <!-- Список чатов занимает всю ширину на маленьких экранах и 1/4 на больших -->
    <h2 class="text-xl font-bold mb-4">
        Чаты
    </h2>
    <div class="space-y-4">
        <!-- Chat Item -->
        @foreach($userChats as $userChat)
            <div class="flex items-center space-x-4">
                <img src="{{ ($userChat->user1_id == auth()->id() ? $userChat->user2->avatar_url : $userChat->user1->avatar_url) ?: asset('images/noava.jpg') }}" alt="Аватар" class="w-12 h-12 rounded-full">
                <div class="flex-1">
                    <div class="flex justify-between items-center">
                        <h3 class="font-bold">
                            {{ $userChat->user1_id == auth()->id() ? $userChat->user2->username : $userChat->user1->username }}
                        </h3>
                        <span class="text-sm text-gray-500">
                            {{ $userChat->last_message ? $userChat->last_message->created_at->format('H:i') : '10:15' }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-500">
                        Название товара по которому диалог
                    </p>
                    <p class="text-sm text-gray-400">
                        {{ $userChat->last_message ? Str::limit($userChat->last_message->message, 20, '...') : 'текст последнего сообщения' }}
                    </p>
                </div>
            </div>
            <hr class="border-gray-300"/>
        @endforeach
    </div>
</div>