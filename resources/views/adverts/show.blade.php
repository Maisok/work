<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $advert->product_name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&amp;apikey=9fbfa4df-7869-44a3-ae8e-0ebc49545ea9" type="text/javascript"></script>
</head>
<body class="text-gray-800">
    @include('components.header-seller')

    <!-- Горизонтальная линия под хэдером -->
    <div class="border-b border-gray-300 my-4 mt-20"></div>

    <!-- путь -->
    <div class="container_path px-4 py-2">
        <a href="{{ route('adverts.index') }}" class="text-blue-500 hover:underline">Главная</a> /
        <a href="javascript:history.back()" class="text-blue-500 hover:underline">Поиск</a> /
        <a href="{{ route('adverts.show', $advert->id) }}" class="text-blue-500 hover:underline">{{ $advert->product_name }}</a>
    </div>

    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-semibold mb-4">{{ $advert->product_name }}</h1>
        <div class="flex flex-col lg:flex-row">
            <div class="lg:w-2/3">
                <div class="bg-gray-100 p-4 rounded-lg mb-4" style="width: 800px; height: 600px;">
                    <img id="main-photo" alt="Изображение товара" class="w-full h-full object-cover" src="{{ $advert->main_photo_url }}"/>
                </div>
                <div class="flex space-x-2">
                    @if ($advert->additional_photo_url_1)
                        <img alt="Миниатюра 1" class="w-32 h-32 bg-gray-100 p-2 rounded-lg object-cover cursor-pointer" src="{{ $advert->additional_photo_url_1 }}" onclick="swapImage(this)"/>
                    @endif
                    @if ($advert->additional_photo_url_2)
                        <img alt="Миниатюра 2" class="w-32 h-32 bg-gray-100 p-2 rounded-lg object-cover cursor-pointer" src="{{ $advert->additional_photo_url_2 }}" onclick="swapImage(this)"/>
                    @endif
                    @if ($advert->additional_photo_url_3)
                        <img alt="Миниатюра 3" class="w-32 h-32 bg-gray-100 p-2 rounded-lg object-cover cursor-pointer" src="{{ $advert->additional_photo_url_3 }}" onclick="swapImage(this)"/>
                    @endif
                </div>
            </div>
            <div class="lg:w-1/3 lg:pl-8">
                <div class="bg-white p-6 rounded-lg shadow-lg w-80">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-3xl font-bold">{{ $advert->price }} ₽</p>
                            <p class="text-gray-500 text-base">сегодня в 12:00</p>
                        </div>
                        <button class="text-gray-500 hover:text-gray-700">
                            <i class="far fa-heart text-2xl"></i>
                        </button>
                    </div>
                    <div class="mt-2">
                        <p class="text-red-500 font-semibold text-lg">{{ $advert->user->userAddress->city ?? 'Не указан' }}</p>
                        <div class="flex items-center mt-1">
                            <i class="fas fa-truck text-yellow-500 text-lg"></i>
                            <p class="text-yellow-500 text-base ml-1">Есть доставка</p>
                        </div>
                        <a class="text-blue-500 text-base mt-1 block" href="#">Показать условия доставки</a>
                    </div>
                    <div class="mt-4 flex justify-between items-start">
                        <div>
                            <p class="font-semibold text-lg">{{ $advert->user->username }}</p>
                            <p class="text-gray-500 text-base">{{ $advert->user->userAddress->address_line ?? 'Не указан' }}</p>
                            <a class="text-blue-500 text-base mt-1 block" href="#">показать на карте</a>
                        </div>
                        <div class="flex justify-center">
                            <img alt="Логотип {{ $advert->user->username }}" class="rounded-full w-24 h-24 object-cover" src=""/>
                        </div>
                    </div>
                    <div class="mt-6">
                        <button class="w-full bg-blue-500 text-white py-2 rounded-lg text-lg">Показать телефон</button>
                        <button class="w-full bg-green-500 text-white py-2 rounded-lg text-lg mt-2">Написать продавцу</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="max-w-md mt-8">
            <h1 class="text-xl font-semibold mb-4">
                Продавец
            </h1>
            <div class="flex items-center">
                <img alt="Логотип {{ $advert->user->username }}" class="w-24 h-24 rounded-full mr-4 object-cover" src=""/>
                <div>
                    <h2 class="text-lg font-semibold">
                        {{ $advert->user->username }}
                    </h2>
                    <p class="text-base text-gray-600">
                        {{ $advert->user->userAddress->address_line ?? 'Не указан' }}
                    </p>
                    <div class="flex items-center mt-1">
                        <span class="text-base font-semibold text-yellow-600 bg-yellow-100 px-2 py-1 rounded">
                            +7(999)649-22-12
                        </span>
                        <a class="text-base text-blue-500 ml-4" href="#">
                            показать на карте
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-8">
            <h2 class="text-2xl font-semibold mb-4">Характеристики</h2>
            <div class="grid grid-cols-2 gap-4 text-base">
                <div>Артикул</div>
                <div>{{ $advert->article_number ?? 'Не указан' }}</div>
                <div>Номер запчасти</div>
                <div>{{ $advert->part_number ?? 'Не указан' }}</div>
                <div>Марка</div>
                <div>{{ $advert->brand }}</div>
                <div>Модель</div>
                <div>{{ $advert->model }}</div>
                <div>Кузов</div>
                <div>{{ $advert->body ?? 'Не указан' }}</div>
                <div>Двигатель</div>
                <div>{{ $advert->engine ?? 'Не указан' }}</div>
                <div>Год выпуска</div>
                <div>{{ $advert->year }}</div>
                <div>Состояние</div>
                <div>{{ $advert->condition ?? 'Не указан' }}</div>
            </div>
        </div>
        <div class="mt-8">
            <h2 class="text-2xl font-semibold mb-4">Описание</h2>
            <p class="text-base">{{ $advert->body }}</p>
        </div>
        <div class="mt-8">
            <h2 class="text-2xl font-semibold mb-4">Может подойти</h2>
            <div class="bg-yellow-100 p-4 rounded-lg mb-4 text-base">
                Совместимость не гарантирована. Данные сформированы автоматически и могут содержать ошибки. Уточните применимость к вашему авто у продавца.
            </div>
            <div class="mb-4">
                <div class="flex items-center space-x-2">
                    <span class="font-bold text-lg">Марка</span>
                    <a href="#" class="text-blue-600 text-lg">Показать все</a>
                    <a href="#" class="text-blue-600 text-lg">Honda</a>
                </div>
                <div class="flex items-center space-x-2 mt-2">
                    <span class="font-bold text-lg">Модель</span>
                    <a href="#" class="text-blue-600 text-lg">Показать все</a>
                    <a href="#" class="text-blue-600 text-lg">Fit</a>
                    <a href="#" class="text-blue-600 text-lg">Fit Aria</a>
                </div>
            </div>
            <table class="w-full text-base text-left">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-2">Марка</th>
                        <th class="p-2">Модель</th>
                        <th class="p-2">Поколение</th>
                        <th class="p-2">Период выпуска</th>
                        <th class="p-2">Модификация</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($relatedCars as $car)
                        <tr class="border-b">
                            <td class="p-2">{{ $car['brand'] }}</td>
                            <td class="p-2">{{ $car['model'] }}</td>
                            <td class="p-2">{{ $car['generation'] }}</td>
                            <td class="p-2">{{ $car['year_from'] }} - {{ $car['year_before'] }}</td>
                            <td class="p-2">{{ $car['modification'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-8">
            <h2 class="text-2xl font-semibold mb-4">Доставка и оплата</h2>
            <p class="text-base mb-4">Гарантия и условия возврата</p>
            <p class="text-base mb-4">Гарантия есть!</p>
            <p class="text-base mb-4">**** ВНИМАНИЕ! ****</p>
            <p class="text-base mb-4">Цена указана за наличный расчет или переводом на карту!</p>
            <p class="text-base mb-4">Возможна оплата по терминалу и по счету. (+10% к стоимости).</p>
            <p class="text-base mb-4">Цена и наличие может быть неактуальными!</p>
            <p class="text-base mb-4">Перед тем как ехать, всю информацию уточняйте пожалуйста в переписке или по телефону!</p>
            <p class="text-base mb-4">ПРОСЬБА !!! до приезда в магазин !!! оповестить нас по телефону о Вашем намерении забрать в магазине товар!</p>
            <p class="text-base mb-4">Звоните нам или пишите на WhatsApp, подберем запчасти под Ваш бюджет!</p>
            <div class="text-base mb-4">
                <p class="font-semibold">Доставка и оплата</p>
                <p>Самовывоз — <a class="text-blue-500 hover:underline" href="#">Иркутск, ул.Лермонтова 321\2</a></p>
                <p>Доставка по городу Иркутск — 300 р.</p>
                <p>До транспортной компании в Иркутске — 300 р.</p>
                <p>При заказе от 50 000 р. доставка курьером в Иркутске и до транспортной компании бесплатна</p>
                <p>Самовывоз ул. Баррикад 82 ТЦ "Gold Car", пав. 5</p>
            </div>
            <div class="flex items-center p-4">
                <img alt="Логотип {{ $advert->user->username }}" class="w-24 h-24 rounded-full object-cover" src=""/>
                <div class="ml-4">
                    <div class="text-lg font-semibold">
                        {{ $advert->user->username }}
                    </div>
                    <div class="text-gray-500 text-base">
                        {{ $advert->user->userAddress->address_line ?? 'Не указан' }}
                    </div>
                </div>
                <div class="ml-auto flex space-x-4">
                    <button class="bg-blue-500 text-white px-4 py-2 rounded text-lg">
                        Показать телефон
                    </button>
                    <button class="bg-green-500 text-white px-4 py-2 rounded text-lg">
                        Написать продавцу
                    </button>
                </div>
            </div>
        </div>
        <div class="mt-8">
            <div id="map" class="w-full h-96 mt-4 mb-12"></div>
        </div>
    </div>

    <script>
        ymaps.ready(init);

        function init() {
            var myMap = new ymaps.Map('map', {
                center: [52.753994, 104.622093],
                zoom: 9, 
                controls: []
            });

            // Данные для геокодирования
            var address = "{{ $advert->user->userAddress->address_line ?? 'Не указан' }}";
            var prod_name = "{{ $advert->product_name }}";
            var image_url = "{{ $advert->main_photo_url }}";
            var advert_id = "{{ $advert->id }}";

            // URL изображения по умолчанию
            var defaultImageUrl = "{{ asset('images/dontfoto.jpg') }}";

            // Функция для геокодирования и добавления метки на карту
            function geocodeAndAddToMap(address, prod_name, image_url, advert_id) {
                if (!address || address === "Не указан") {
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
                    myMap.setCenter(coords, 15, {
                        checkZoomRange: true
                    });
                });
            }

            // Выполняем геокодирование и добавление метки для адреса
            geocodeAndAddToMap(address, prod_name, image_url, advert_id);
        }

        function swapImage(thumbnail) {
            const mainPhoto = document.getElementById('main-photo');
            const mainPhotoSrc = mainPhoto.src;
            const thumbnailSrc = thumbnail.src;

            mainPhoto.src = thumbnailSrc;
            thumbnail.src = mainPhotoSrc;
        }
    </script>
</body>
</html>