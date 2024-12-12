<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="shortcut icon" href="{{asset('images/Group 438.png')}}" type="image/x-icon">
</head>
<body>
    @include('components.header-seller')
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/3.0.1/js.cookie.min.js"></script>
    
    <div class="container mx-auto p-4 mt-20 mb-20">
        <div class="flex flex-col items-center justify-center h-screen">
            <h1 class="text-2xl font-semibold mb-6">Как вы хотите добавить товары?</h1>
            <div class="flex justify-center space-x-4">
                <a href="{{route('adverts.create')}}" class="bg-gray-200 text-gray-800 py-10 px-4 rounded-md">Создать товар с помощью формы</a>
                <a href="#sel" class="bg-gray-200 text-gray-800 py-10 px-4 rounded-md">Загрузить товары из прайс-листа</a>
            </div>
        </div>
    
        <div class="mt-16">
            <h2 id="sel" class="text-xl font-semibold text-center mb-6">Выберите способ загрузки товаров из прайс-листа</h2>
            <div class="space-y-8">
                <div class="border p-4 rounded-md">
                    <div class="flex items-center mb-4">
                        <div class="bg-gray-200 text-gray-800 rounded-full h-8 w-8 flex items-center justify-center mr-4">1</div>
                        <h3 class="text-lg font-semibold">Прямая загрузка товаров из прайс-листа на сайт</h3>
                    </div>
                    <div class="bg-orange-100 p-4 rounded-md mb-4 flex justify-between items-center">
                        <p>Выберите этот способ загрузки товаров, если ваш прайс-лист соответствует <a href="#" class="text-blue-600">принятому формату</a>.</p>
                        <i class="fas fa-times text-gray-500"></i>
                    </div>
                    <div class="flex items-center mb-4">
                        <label class="mr-4">Выберите файл:</label>
                        <input type="file" class="border rounded-md p-2">
                    </div>
                    <div class="flex justify-between items-center mb-4 md:flex-row flex-col">
                        <button class="bg-blue-600 text-white py-2 px-4 rounded-md md:w-auto w-full mb-4 md:mb-0">Добавить товары на сайт</button>
                        <div class="text-right w-full md:w-auto">
                            <p><a href="#" class="text-blue-600">Требования к файлу для прямого импорта</a></p>
                            <p><a href="#" class="text-blue-600">Инструкция по загрузке товаров из файла</a></p>
                            <p><a href="#" class="text-blue-600">Видеоинструкция</a></p>
                        </div>
                    </div>
                </div>
    
                <div class="text-center text-gray-500 text-lg font-semibold">ИЛИ</div>
    
                <div class="border p-4 rounded-md">
                    <div class="flex items-center mb-4">
                        <div class="bg-gray-200 text-gray-800 rounded-full h-8 w-8 flex items-center justify-center mr-4">2</div>
                        <h3 class="text-lg font-semibold">Конвертировать прайс-лист и загрузить товары на сайт</h3>
                    </div>
                    <div class="bg-orange-100 p-4 rounded-md mb-4 flex justify-between items-center">
                        <p>Если Ваш прайс-лист отличается от <a href="#" class="text-blue-600">принятого формата для прямого импорта</a> выберите этот способ. Конвертация позволяет загрузить товары на сайт из прайс-листа любого вида.</p>
                        <i class="fas fa-times text-gray-500"></i>
                    </div>
                    <div class="flex items-center mb-4">
                        <label class="mr-4">Выберите файл:</label>
                        <input type="file" class="border rounded-md p-2">
                    </div>
                    <div class="flex justify-between items-center mb-4 md:flex-row flex-col">
                        <button class="bg-blue-600 text-white py-2 px-4 rounded-md md:w-auto w-full mb-4 md:mb-0">Конвертировать файл и добавить товары на сайт</button>
                        <div class="text-right w-full md:w-auto">
                            <p><a href="#" class="text-blue-600">О конвертере прайс-листов</a></p>
                            <p><a href="#" class="text-blue-600">Первая конвертация файла</a></p>
                            <p><a href="#" class="text-blue-600">Видеоинструкция</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>


