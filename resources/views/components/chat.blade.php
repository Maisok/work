<html lang="ru">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>
   Chat Interface
  </title>
  <script src="https://cdn.tailwindcss.com">
  </script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
 </head>
 <body class="bg-white h-screen flex">
  <!-- Sidebar -->
  <div class="w-1/3 bg-gray-100 p-4">
   <h2 class="text-2xl font-bold mb-4">
    Чаты
   </h2>
   <div class="space-y-4">
    <div class="flex items-center space-x-4 p-2 bg-white rounded-lg shadow">
     <img alt="User avatar" class="w-12 h-12 rounded-full" height="50" src="" width="50"/>
     <div class="flex-1">
      <div class="flex justify-between items-center">
       <h3 class="font-semibold">
        Алексей
       </h3>
       <span class="text-sm text-gray-500">
        10:15
       </span>
      </div>
      <p class="text-sm text-gray-500">
       Название товара по которому диалог
      </p>
      <p class="text-sm text-gray-400">
       текст последнего сообщения
      </p>
     </div>
    </div>
    <div class="flex items-center space-x-4 p-2 bg-white rounded-lg shadow">
     <img alt="User avatar" class="w-12 h-12 rounded-full" height="50" src="" width="50"/>
     <div class="flex-1">
      <div class="flex justify-between items-center">
       <h3 class="font-semibold">
        Ирина
       </h3>
       <span class="text-sm text-gray-500">
        10:15
       </span>
      </div>
      <p class="text-sm text-gray-500">
       Название товара по которому диалог
      </p>
      <p class="text-sm text-gray-400">
       текст последнего сообщения
      </p>
     </div>
    </div>
   </div>
  </div>
  <!-- Main Chat Area -->
  <div class="flex-1 flex flex-col">
   <div class="flex items-center justify-between p-4 border-b">
    <div class="flex items-center space-x-4">
     <img alt="Product image" class="w-12 h-12 rounded-full" height="50" src="https://storage.googleapis.com/a1aa/image/83rQ3Up93TqXDp838jy4AazKYKdRksHBbBypc4P7l4jqWXeJA.jpg" width="50"/>
     <div>
      <h2 class="text-xl font-bold">
       Двигатель [название объявления по которому диалог]
      </h2>
      <p class="text-lg text-gray-500">
       100 000₽
      </p>
     </div>
    </div>
    <span class="text-lg text-gray-500">
     02.12.2024
    </span>
   </div>
   <div class="flex-1 p-4 space-y-4 overflow-y-auto">
    <div class="flex items-start space-x-4">
     <img alt="User avatar" class="w-10 h-10 rounded-full" height="50" src="https://storage.googleapis.com/a1aa/image/vfmMQKmwMyVqJaV4APLBn1gnTa3f38tEcnOM5bl4dtSoad5TA.jpg" width="50"/>
     <div class="bg-gray-100 p-3 rounded-lg">
      <p>
       Входящее сообщение
      </p>
     </div>
     <span class="text-sm text-gray-500">
      10:10
     </span>
    </div>
    <div class="flex items-start space-x-4 justify-end">
     <span class="text-sm text-gray-500">
      10:15
     </span>
     <div class="bg-green-100 p-3 rounded-lg">
      <p>
       Исходящее сообщение
      </p>
     </div>
     <img alt="User avatar" class="w-10 h-10 rounded-full" height="50" src="https://storage.googleapis.com/a1aa/image/vfmMQKmwMyVqJaV4APLBn1gnTa3f38tEcnOM5bl4dtSoad5TA.jpg" width="50"/>
    </div>
   </div>
   <div class="p-4 border-t flex items-center space-x-4">
    <input class="flex-1 p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Сообщение" type="text"/>
    <button class="bg-blue-500 text-white px-4 py-2 rounded-lg">
     Отправить
    </button>
   </div>
  </div>
 </body>
</html>
