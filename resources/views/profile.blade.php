<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль пользователя</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .icon-text-hover:hover i,
        .icon-text-hover:hover p {
            color: #0077FF;
        }
    </style>
</head>
<body class="bg-white">
    @include('components.header-seller')
    <div class="container mx-auto p-4 mt-20 mb-20">
        <div class="flex flex-col md:flex-row justify-between items-center mb-4">
            <div class="flex items-center w-full md:w-auto">
                <div class="w-32 h-32 bg-gray-100 rounded-full flex items-center justify-center">
                    @if($user->avatar_url)
                        <img src="{{ $user->avatar_url }}" alt="Аватар пользователя" class="ava w-24 h-24 rounded-full mx-auto mb-4">
                    @else
                        <i class="fas fa-user text-8xl text-gray-400"></i>
                    @endif
                </div>
                <div class="ml-6 w-full md:w-auto">
                    <h1 class="text-3xl font-bold mb-4">AutoTut</h1>
                    <p class="text-gray-600 mb-2">Имя пользователя: <span class="text-black">{{ $user->username }}</span></p>
                    <p class="text-gray-600 mb-2">Email: <span class="text-black">{{ $user->email }}</span></p>
                    @if($user->UserAddress)
                        <p class="text-gray-600 mb-2">Город: <span class="text-black">{{ $user->UserAddress->city }}</span></p>
                        <p class="text-gray-600 mb-2">Адрес: <span class="text-black">{{ $user->UserAddress->address_line }}</span></p>
                    @else
                        <p class="text-gray-600 mb-2">Адрес не указан.</p>
                    @endif
                    @if($user->UserPhoneNumber)
                        <p class="text-gray-600 mb-2">Номер: <span class="text-black">{{ $user->UserPhoneNumber->number_1 }}</span></p>
                    @else
                        <p class="text-gray-600 mb-2">Номер не указан.</p>
                    @endif
                    <p class="text-gray-600 mb-2">Ваш баланс: <span class="text-black">{{ $balance }}р</span></p>
                </div>
            </div>
            <div class="bg-yellow-100 p-4 rounded-lg text-right flex items-center mt-4 md:mt-0">
                <div>
                    <p class="text-blue-600 text-xl font-bold flex items-center">
                        <i class="fas fa-wallet text-2xl text-gray-600 mr-2"></i> 1,000 ₽
                    </p>
                    <p class="text-gray-600 flex items-center">
                        <i class="fas fa-plus text-gray-600 mr-1"></i> Пополнить кошелек
                    </p>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 mt-4">
            @if($user->user_status == 1)
                <a href="{{ route('market.analysis') }}" class="bg-gray-100 p-8 rounded-lg flex items-center icon-text-hover">
                    <i class="fas fa-chart-bar text-2xl text-gray-600 mr-4"></i>
                    <p class="text-gray-600">Анализ рынка</p>
                </a>
            @endif
            <a href="{{ route('profile.edit', $user->id) }}" class="bg-gray-100 p-8 rounded-lg flex items-center icon-text-hover">
                <i class="fas fa-cog text-2xl text-gray-600 mr-4"></i>
                <p class="text-gray-600">Редактировать Профиль</p>
            </a>
            @if($user->user_status == 1)
                <a href="{{ route('tariff.settings') }}" class="bg-gray-100 p-8 rounded-lg flex items-center icon-text-hover">
                    <i class="fas fa-sliders-h text-2xl text-gray-600 mr-4"></i>
                    <p class="text-gray-600">Настроить тариф</p>
                </a>
                <a href="{{ route('adverts.create') }}" class="bg-gray-100 p-8 rounded-lg flex items-center icon-text-hover">
                    <i class="fas fa-plus text-2xl text-gray-600 mr-4"></i>
                    <p class="text-gray-600">Разместить товары</p>
                </a>
                <a href="{{ route('adverts.my_adverts') }}" class="bg-gray-100 p-8 rounded-lg flex items-center icon-text-hover">
                    <i class="fas fa-list text-2xl text-gray-600 mr-4"></i>
                    <p class="text-gray-600">Мои товары</p>
                </a>
                <a href="{{ route('pay.form') }}" class="bg-gray-100 p-8 rounded-lg flex items-center icon-text-hover">
                    <i class="fas fa-wallet text-2xl text-gray-600 mr-4"></i>
                    <p class="text-gray-600">Пополнить баланс</p>
                </a>
            @endif
            <div class="bg-gray-100 p-8 rounded-lg flex items-center">
                <i class="fas fa-book text-2xl text-gray-600 mr-4"></i>
                <p class="text-gray-600">Справка</p>
            </div>
            <div class="bg-gray-100 p-8 rounded-lg flex items-center">
                <i class="fas fa-headset text-2xl text-gray-600 mr-4"></i>
                <p class="text-gray-600">Служба поддержки</p>
            </div>
        </div>
    </div>
</body>
</html>