<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Кошелёк</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="shortcut icon" href="{{asset('images/Group 438.png')}}" type="image/x-icon">
    <style>
        .hidden {
            display: none;
        }
    </style>
</head>
<body class="bg-white text-gray-800">
    @include('components.header-seller')
    <div class="container mx-auto p-4 mt-20">
        <div class="flex justify-between items-center mb-6">
            <div class="text-gray-600">
                <a href="#" class="hover:underline">Профиль</a> / <span>Кошелёк</span>
            </div>
            <div class="space-y-2 text-right text-sm text-gray-600">
                <a href="#" class="block hover:underline">Как пополнить кошелёк</a>
                <a href="#" class="block hover:underline">Как происходят списания</a>
                <a href="#" class="block hover:underline">Возврат средств</a>
                <a href="#" class="block hover:underline">Часто задаваемые вопросы</a>
            </div>
        </div>
        <div class="text-center">
            <h1 class="text-2xl font-bold mb-2">Кошелёк</h1>
            <p class="text-lg mb-4">Баланс <span class="font-bold">1,000 ₽</span></p>
            <div class="flex justify-center space-x-4 mb-6">
                <a href="#" id="top-up-link" class="text-black font-bold border-b-2 border-black">Пополнение кошелка</a>
                <a href="#" id="history-link" class="text-gray-600">История операций</a>
            </div>
            <div id="content-section">
                <form action="{{ route('pay') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="amount" class="block text-gray-600 mb-2">Введите сумму</label>
                        <div class="inline-flex items-center border border-gray-300 rounded-md px-3 py-2">
                            <input type="number" name="amount" id="amount" required value="1500" class="w-20 text-center outline-none">
                            <span class="ml-2">₽</span>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-4">Выберите способ пополнения</p>
                    <div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-3">
                        <button class="flex items-center justify-center p-4 bg-gray-100 rounded-md shadow-sm hover:bg-gray-200">
                            <i class="fas fa-credit-card text-2xl mr-2"></i>
                            <span>Банковская карта</span>
                        </button>
                        <button class="flex items-center justify-center p-4 bg-gray-100 rounded-md shadow-sm hover:bg-gray-200">
                            <i class="fas fa-file-invoice text-2xl mr-2"></i>
                            <span>Сформировать счёт</span>
                        </button>
                        <button class="flex items-center justify-center p-4 bg-gray-100 rounded-md shadow-sm hover:bg-gray-200">
                            <i class="fas fa-university text-2xl mr-2"></i>
                            <span>СБП</span>
                        </button>
                        <button class="flex items-center justify-center p-4 bg-gray-100 rounded-md shadow-sm hover:bg-gray-200">
                            <i class="fas fa-credit-card text-2xl mr-2"></i>
                            <span>T-Pay</span>
                        </button>
                        <button class="flex items-center justify-center p-4 bg-gray-100 rounded-md shadow-sm hover:bg-gray-200">
                            <i class="fas fa-credit-card text-2xl mr-2"></i>
                            <span>Мир-Pay</span>
                        </button>
                        <button class="flex items-center justify-center p-4 bg-gray-100 rounded-md shadow-sm hover:bg-gray-200">
                            <i class="fas fa-credit-card text-2xl mr-2"></i>
                            <span>Sber-Pay</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Секция с историей операций -->
            <div id="history-section" class="hidden mt-8">
                <div class="container mx-auto p-4">
                    <div class="flex justify-center">
                        <div>
                            <div class="mt-4 flex space-x-4">
                                <button class="text-blue-500 font-semibold">Все операции</button>
                                <button class="text-gray-500">Пополнение</button>
                                <button class="text-gray-500">Списание</button>
                            </div>
                            <div class="mt-4 space-y-4">
                                <div class="bg-gray-100 p-4 rounded-lg">
                                    <p class="font-semibold">Пополнение кошелька</p>
                                    <p class="text-gray-500 text-sm">02.12.2024</p>
                                    <p class="text-right font-semibold text-lg text-green-500">+ 1,500 ₽</p>
                                </div>
                                <div class="bg-gray-100 p-4 rounded-lg">
                                    <p class="font-semibold">Оплата тарифа</p>
                                    <p class="text-gray-500 text-sm">1000 товаров × 0,75₽</p>
                                    <p class="text-gray-500 text-sm">02.12.2024</p>
                                    <p class="text-right font-semibold text-lg text-red-500">- 750 ₽</p>
                                </div>
                                <div class="bg-gray-100 p-4 rounded-lg">
                                    <p class="font-semibold">Оплата тарифа</p>
                                    <p class="text-gray-500 text-sm">1000 товаров × 0,75₽</p>
                                    <p class="text-gray-500 text-sm">01.12.2024</p>
                                    <p class="text-right font-semibold text-lg text-red-500">- 750 ₽</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('history-link').addEventListener('click', function(event) {
            event.preventDefault();
            var contentSection = document.getElementById('content-section');
            var historySection = document.getElementById('history-section');
            var topUpLink = document.getElementById('top-up-link');
            var historyLink = document.getElementById('history-link');

            if (historySection.classList.contains('hidden')) {
                contentSection.classList.add('hidden');
                historySection.classList.remove('hidden');
                topUpLink.classList.remove('text-black', 'font-bold', 'border-b-2', 'border-black');
                topUpLink.classList.add('text-gray-600');
                historyLink.classList.remove('text-gray-600');
                historyLink.classList.add('text-black', 'font-bold', 'border-b-2', 'border-black');
            } else {
                contentSection.classList.remove('hidden');
                historySection.classList.add('hidden');
                topUpLink.classList.add('text-black', 'font-bold', 'border-b-2', 'border-black');
                topUpLink.classList.remove('text-gray-600');
                historyLink.classList.add('text-gray-600');
                historyLink.classList.remove('text-black', 'font-bold', 'border-b-2', 'border-black');
            }
        });

        document.getElementById('top-up-link').addEventListener('click', function(event) {
            event.preventDefault();
            var contentSection = document.getElementById('content-section');
            var historySection = document.getElementById('history-section');
            var topUpLink = document.getElementById('top-up-link');
            var historyLink = document.getElementById('history-link');

            if (contentSection.classList.contains('hidden')) {
                contentSection.classList.remove('hidden');
                historySection.classList.add('hidden');
                topUpLink.classList.add('text-black', 'font-bold', 'border-b-2', 'border-black');
                topUpLink.classList.remove('text-gray-600');
                historyLink.classList.add('text-gray-600');
                historyLink.classList.remove('text-black', 'font-bold', 'border-b-2', 'border-black');
            } else {
                contentSection.classList.add('hidden');
                historySection.classList.remove('hidden');
                topUpLink.classList.remove('text-black', 'font-bold', 'border-b-2', 'border-black');
                topUpLink.classList.add('text-gray-600');
                historyLink.classList.remove('text-gray-600');
                historyLink.classList.add('text-black', 'font-bold', 'border-b-2', 'border-black');
            }
        });
    </script>
</body>
</html>