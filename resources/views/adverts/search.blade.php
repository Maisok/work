<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Все товары</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <style>
        /* Добавляем стили для отображения карты на весь экран */
        #map.full-screen {
            position: fixed;
            top: 64px; /* Высота кнопок */
            left: 0;
            width: 100%;
            height: calc(100% - 64px); /* Учитываем высоту кнопок */
            z-index: 1000;
        }

        /* Стили для кнопок */
        .buttons-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            display: flex;
            justify-content: center;
            background-color: white;
            padding: 16px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            z-index: 1001;
        }
    </style>
</head>
<body>
@include('components.header-seller')   

<script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/3.0.1/js.cookie.min.js"></script>
<div id="map" class="w-full h-64 mt-28 md:h-96 hidden sm:block"></div>
<div class="flex justify-center mt-8 hidden sm:block">
    @include('components.search-form') <!-- Подключение формы поиска -->
</div>
<h3 class="text-2xl font-bold mt-8 mb-4 text-center">Результаты поиска:</h3>

<!-- Фильтры по параметру engine -->
<div class="filters bg-white p-4 rounded-lg shadow-md w-80 absolute right-0 mt-4 mr-32 hidden 2xl:block">
    <h4 class="text-xl font-semibold mb-4">Фильтры по двигателю:</h4>
    <form method="GET" action="{{ route('adverts.search') }}"> <!-- Укажите правильный маршрут для обработки формы -->
        @foreach($engines as $engine)
            <div>
                <input type="checkbox" name="engines[]" value="{{ $engine }}" id="engine-{{ $engine }}"
                    {{ in_array($engine, request('engines', [])) || !request()->has('engines') ? 'checked' : '' }}
                    class="mr-2">
                <label for="engine-{{ $engine }}" class="text-lg">{{ !empty($engine) ? ucfirst($engine) : 'Не указан' }}</label>
            </div>
        @endforeach

        <!-- Сохраняем другие параметры запроса -->
        <input type="hidden" name="search_query" value="{{ request('search_query') }}">
        <input type="hidden" name="brand" value="{{ request('brand') }}">
        <input type="hidden" name="model" value="{{ request('model') }}">
        <input type="hidden" name="year" value="{{ request('year') }}">

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg mt-4">Применить фильтры</button>
    </form>
</div>

<div class="flex justify-center items-center space-x-4 mt-4 mb-4 sm:hidden px-4">
    <button id="listButton" class="flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg w-1/2">
        <i class="fas fa-th-large mr-2"></i>
        Списком
    </button>
    <button id="mapButton" class="flex items-center justify-center px-4 py-2 bg-white text-gray-600 border rounded-lg w-1/2">
        <i class="fas fa-map mr-2"></i>
        Показать на карте
    </button>
</div>

<div id="listView" class="container mx-auto mt-8 mb-20">
    @if($adverts->count())
        <!-- Для телефонов -->
        <div id="phoneListView" class="grid grid-cols-2 gap-4 sm:hidden">
            @foreach($adverts as $advert)
            <div class="bg-white rounded-lg shadow p-4 mt-8 cursor-pointer transition-colors duration-300 hover:bg-blue-100" onclick="location.href='{{ route('adverts.show', $advert->id) }}'" tabindex="0" role="button">
                <div class="relative">
                    @if ($advert->main_photo_url)
                        <img src="{{ $advert->main_photo_url }}" alt="{{ $advert->product_name }} - Главное фото" class="w-full h-48 object-cover rounded-lg">
                    @else
                        <img src="{{ asset('images/dontfoto.jpg') }}" alt="Фото отсутствует" class="w-full h-48 object-cover rounded-lg">
                    @endif
                    <span class="absolute top-2 right-2 bg-yellow-200 text-yellow-800 text-xs font-semibold px-2 py-1 rounded">
                        В наличии
                    </span>
                </div>
                <div class="mt-4">
                    <div class="text-lg font-bold">
                        {{ $advert->product_name }}
                    </div>
                    <div class="text-xl text-black font-semibold">
                        {{ $advert->price }} ₽
                    </div>
                    <div class="flex items-center text-gray-500 text-sm mt-2">
                        <i class="fas fa-car mr-2"></i>
                        <span>{{ $advert->brand }}</span>
                        <span class="mx-1">|</span>
                        <span>{{ $advert->model }}</span>
                        <span class="mx-1">|</span>
                        <span>{{ $advert->year }}</span>
                    </div>
                    <div class="text-red-500 font-semibold mt-2">
                        {{ $advert->user->userAddress->city ?? 'Не указан' }}
                    </div>
                    <div class="text-gray-500 text-sm">
                        сегодня в 12:00
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Для больших и средних экранов -->
        <div class="hidden sm:block">
            @foreach($adverts as $advert)
            <div class="bg-white rounded-lg shadow-md flex max-w-5xl p-4 mt-8 cursor-pointer transition-colors duration-300 hover:bg-blue-100" onclick="location.href='{{ route('adverts.show', $advert->id) }}'" tabindex="0" role="button">
                <!-- Вывод главного фото -->
                @if ($advert->main_photo_url)
                    <img src="{{ $advert->main_photo_url }}" alt="{{ $advert->product_name }} - Главное фото" class="rounded-lg w-1/5 object-cover">
                @else
                    <img src="{{ asset('images/dontfoto.jpg') }}" alt="Фото отсутствует" class="rounded-lg w-1/5 object-cover">
                @endif
            
                <div class="flex flex-col justify-between w-full pl-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="text-xl font-semibold">{{ $advert->product_name }}</h2>
                            <p class="beg bg-gray-200 px-3 py-1 w-24 text-sm rounded-lg text-center">{{ $advert->number }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xl font-semibold">{{ $advert->price }} ₽</p>
                            <p class="text-red-500">{{ $advert->user->userAddress->city ?? 'Не указан' }}</p>
                        </div>
                    </div>
                    <div class="flex space-x-2 mt-4 w-full justify-around">
                        <span class="bg-yellow-200 text-yellow-800 text-sm font-semibold px-2.5 py-0.5 rounded">{{ $advert->brand }}</span>
                        <span class="bg-yellow-200 text-yellow-800 text-sm font-semibold px-2.5 py-0.5 rounded">{{ $advert->model }}</span>
                        <span class="bg-yellow-200 text-yellow-800 text-sm font-semibold px-2.5 py-0.5 rounded">{{ $advert->body }}</span>
                        <span class="bg-yellow-200 text-yellow-800 text-sm font-semibold px-2.5 py-0.5 rounded">{{ $advert->engine }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Подключение пагинации -->
        <div id="pagination" class="mt-8">
            @include('components.pagination', ['adverts' => $adverts])
        </div>
    @else
        <p class="text-center text-lg mt-8">Нет результатов для отображения.</p>
    @endif
</div>

<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&amp;apikey=9fbfa4df-7869-44a3-ae8e-0ebc49545ea9" type="text/javascript"></script>
<script>
    let mapInitialized = false;
    let myMap;

    ymaps.ready(function() {
        myMap = new ymaps.Map('map', {
            center: [52.753994, 104.622093],
            zoom: 9, 
            controls: []
        });

        // Отключаем взаимодействие с картой
        myMap.behaviors.disable('drag');
        myMap.behaviors.disable('scrollZoom');

        // Массив адресов для геокодирования
        var addresses = @json($addresses);
        var prod_name = @json($prod_name);
        var image_prod = @json($image_prod);
        var advert_ids = @json($advert_ids);

        // URL изображения по умолчанию
        var defaultImageUrl = "{{ asset('images/dontfoto.jpg') }}";

        // Функция для геокодирования и добавления меток на карту
        function geocodeAndAddToMap(address, prod_name, image_url, advert_id) {
            if (address == "Не указан") {
                return; // Пропускаем добавление метки, если адрес отсутствует
            }

            ymaps.geocode(address, {
                results: 1
            }).then(function (res) {
                var firstGeoObject = res.geoObjects.get(0),
                    coords = firstGeoObject.geometry.getCoordinates(),
                    bounds = firstGeoObject.properties.get('boundedBy');

                // Проверяем, существует ли URL изображения
                var imageUrl = image_url ? image_url : defaultImageUrl;

                // Создаем метку с пользовательским контентом
                var placemark = new ymaps.Placemark(coords, {
                    balloonContent: address + '<br><a href="{{ route('adverts.show', '') }}/' + advert_id + '">' + prod_name + '</a><br><img src="' + imageUrl + '" alt="Фото отсутствует" width="100">', // Пользовательский контент в баллуне с изображением и ссылкой
                    hintContent: prod_name // Пользовательский контент в подсказке
                }, {
                    preset: 'islands#darkBlueDotIconWithCaption'
                });

                myMap.geoObjects.add(placemark);

                // Центрируем карту на последней добавленной метке
                myMap.setCenter(coords, 10, {
                    checkZoomRange: true
                });
            });
        }

        // Выполняем геокодирование и добавление меток для каждого адреса
        addresses.forEach(function (address, index) {
            geocodeAndAddToMap(address, prod_name[index], image_prod[index], advert_ids[index]);
        });

        // Обработчик клика на карту
        document.getElementById('map').addEventListener('click', function() {
            if (!mapInitialized) {
                mapInitialized = true;
                // Включаем взаимодействие с картой
                myMap.behaviors.enable('drag');
                myMap.behaviors.enable('scrollZoom');
            }
        });

        // Обработчик ухода курсора с карты
        document.getElementById('map').addEventListener('mouseleave', function() {
            if (mapInitialized) {
                // Отключаем взаимодействие с картой
                myMap.behaviors.disable('drag');
                myMap.behaviors.disable('scrollZoom');
                mapInitialized = false;
            }
        });
    });

    // JavaScript для переключения отображения
    document.getElementById('listButton').addEventListener('click', function() {
        document.getElementById('phoneListView').classList.remove('hidden');
        document.getElementById('map').classList.remove('full-screen');
        document.getElementById('map').classList.add('hidden');
        document.getElementById('pagination').classList.remove('hidden');
        document.getElementById('listButton').classList.add('bg-blue-600', 'text-white');
        document.getElementById('listButton').classList.remove('bg-white', 'text-gray-600', 'border');
        document.getElementById('mapButton').classList.remove('bg-blue-600', 'text-white');
        document.getElementById('mapButton').classList.add('bg-white', 'text-gray-600', 'border');
    });

    document.getElementById('mapButton').addEventListener('click', function() {
        document.getElementById('phoneListView').classList.add('hidden');
        document.getElementById('map').classList.remove('hidden');
        document.getElementById('map').classList.add('full-screen');
        document.getElementById('pagination').classList.add('hidden');
        document.getElementById('mapButton').classList.add('bg-blue-600', 'text-white');
        document.getElementById('mapButton').classList.remove('bg-white', 'text-gray-600', 'border');
        document.getElementById('listButton').classList.remove('bg-blue-600', 'text-white');
        document.getElementById('listButton').classList.add('bg-white', 'text-gray-600', 'border');
    });
</script>
</body>
</html>