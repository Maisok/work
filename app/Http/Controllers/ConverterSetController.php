<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use App\Models\ConverterSet;
use Illuminate\Support\Facades\Auth;

class ConverterSetController extends Controller
{
 // Метод для получения настроек
 public function getSettings(Request $request)
 {
     // Получаем ID текущего пользователя
     $userId = auth()->id();
 
     // Ищем настройки пользователя в базе данных
     $settings = ConverterSet::where('user_id', $userId)->first();
 
     if ($settings) {
         // Список всех возможных брендов
         $brands = [
             'acura', 'alfa_romeo', 'asia', 'aston_martin', 'audi', 'bentley', 'bmw', 'byd',
             'cadillac', 'changan', 'chevrolet', 'citroen', 'daewoo', 'daihatsu', 'datsun',
             'fiat', 'ford', 'gaz', 'geely', 'haval', 'honda', 'hyundai', 'infiniti', 'isuzu',
             'jaguar', 'jeep', 'kia', 'lada', 'land_rover', 'mazda', 'mercedes_benz', 'mitsubishi',
             'nissan', 'opel', 'peugeot', 'peugeot_lnonum', 'porsche', 'renault', 'skoda',
             'ssangyong', 'subaru', 'suzuki', 'toyota', 'uaz', 'volkswagen', 'volvo', 'zaz',
         ];
 
         // Массив для преобразования имен брендов
         $brandTranslations = [
             'alfa_romeo' => 'alfa romeo',
             'aston_martin' => 'aston martin',
             'gaz' => 'газ',
             'land_rover' => 'land rover',
             'uaz' => 'уаз',
             'zaz' => 'заз',
             'vaz' => 'ваз',
             'mercedes_benz' => 'mercedes',
         ];
 
         // Извлекаем выбранные бренды
         $selectedBrands = [];
         foreach ($brands as $brand) {
             if ($settings->$brand == 1) { // Если значение равно 1, бренд выбран
                 // Преобразуем имя бренда, если оно есть в массиве $brandTranslations
                 $selectedBrands[] = $brandTranslations[$brand] ?? $brand;
             }
         }
 
         // Возвращаем выбранные бренды в формате JSON
         return response()->json(['settings' => $selectedBrands]);
     }
 
     // Если настройки не найдены
     return response()->json(['error' => 'Настройки не найдены'], 404);
 }

    public function edit()
    {
        // Получаем настройки текущего пользователя
        $converterSet = ConverterSet::where('user_id', Auth::id())->first();

        return view('converter_set.edit', compact('converterSet'));
    }

    public function update(Request $request)
    {
        // Валидация входящих данных
        $request->validate([
            'acura' => 'boolean',
            'alfa_romeo' => 'boolean',
            'asia' => 'boolean',
            'aston_martin' => 'boolean',
            'audi' => 'boolean',
            'bentley' => 'boolean',
            'bmw' => 'boolean',
            'byd' => 'boolean',
            'cadillac' => 'boolean',
            'changan' => 'boolean',
            'chevrolet' => 'boolean',
            'citroen' => 'boolean',
            'daewoo' => 'boolean',
            'daihatsu' => 'boolean',
            'datsun' => 'boolean',
            'fiat' => 'boolean',
            'ford' => 'boolean',
            'gaz' => 'boolean',
            'geely' => 'boolean',
            'haval' => 'boolean',
            'honda' => 'boolean',
            'hyundai' => 'boolean',
            'infiniti' => 'boolean',
            'isuzu' => 'boolean',
            'jaguar' => 'boolean',
            'jeep' => 'boolean',
            'kia' => 'boolean',
            'lada' => 'boolean',
            'land_rover' => 'boolean',
            'mazda' => 'boolean',
            'mercedes_benz' => 'boolean',
            'mitsubishi' => 'boolean',
            'nissan' => 'boolean',
            'opel' => 'boolean',
            'peugeot' => 'boolean',
            'peugeot_lnonum' => 'boolean',
            'porsche' => 'boolean',
            'renault' => 'boolean',
            'skoda' => 'boolean',
            'ssangyong' => 'boolean',
            'subaru' => 'boolean',
            'suzuki' => 'boolean',
            'toyota' => 'boolean',
            'uaz' => 'boolean',
            'volkswagen' => 'boolean',
            'volvo' => 'boolean',
            'zaz' => 'boolean',
    
             // Поля с текстовыми значениями
        'product_name' => 'nullable|string|max:255',
        'price' => 'nullable|string|max:255',
        'car_brand' => 'nullable|string|max:255', 
        'car_model' => 'nullable|string|max:255', 
        'year' => 'nullable|string|max:255', 
        'oem_number' => 'nullable|string|max:255', 
        'picture' => 'nullable|string|max:255', 
        'body' => 'nullable|string|max:255', 
        'engine' => 'nullable|string|max:255', 
        'quantity' => 'nullable|string|max:255', 
        'text_declaration' => 'nullable|string|max:255', 
        'left_right' => 'nullable|string|max:255', 
        'up_down' => 'nullable|string|max:255', 
        'front_back' => 'nullable|string|max:255', 
        'fileformat_col' => 'nullable|string|max:255', 
        'encoding' => 'nullable|string|max:255', 
        'file_price' => 'nullable|string|max:255', 
        'my_file' => 'nullable|string|max:255', 
        'header_str_col' => 'nullable|string|max:255', 
        'separator_col' => 'nullable|string|max:255', 
        'del_duplicate' => 'nullable|string|max:255', 
        'art_number' => 'nullable|string|max:255', 
        'availability' => 'nullable|string|max:255', 
        'color' => 'nullable|string|max:255', 
        'delivery_time' => 'nullable|string|max:255', 
        'new_used' => 'nullable|string|max:255', 
        'many_pages_col' => 'nullable|string|max:255',

        ]);

        // Обновляем или создаем настройки
        ConverterSet::updateOrCreate(
            ['user_id' => Auth::id()],
            $request->only([
                'acura',
                'alfa_romeo',
                'asia',
                'aston_martin',
                'audi',
                'bentley',
                'bmw',
                'byd',
                'cadillac',
                'changan',
                'chevrolet',
                'citroen',
                'daewoo',
                'daihatsu',
                'datsun',
                'fiat',
                'ford',
                'gaz',
                'geely',
                'haval',
                'honda',
                'hyundai',
                'infiniti',
                'isuzu',
                'jaguar',
                'jeep',
                'kia',
                'lada',
                'land_rover',
                'mazda',
                'mercedes_benz',
                'mitsubishi',
                'nissan',
                'opel',
                'peugeot',
                'peugeot_lnonum',
                'porsche',
                'renault',
                'skoda',
                'ssangyong',
                'subaru', 
                'suzuki', 
                'toyota', 
                'uaz', 
                'volkswagen', 
                'volvo', 
                'zaz', 
                'product_name', 
                'price', 
                'car_brand', 
                'car_model', 
                'year', 
                'oem_number', 
                'picture', 
                'body', 
                'engine', 
                'quantity', 
                'text_declaration', 
                'left_right', 
                'up_down', 
                'front_back', 
                'fileformat_col', 
                'encoding', 
                'file_price', 
                'my_file', 
                'header_str_col', 
                'separator_col', 
                'del_duplicate', 
                'art_number', 
                'availability', 
                'color', 
                'delivery_time', 
                'new_used', 
                'many_pages_col'
        
            ])
        );

        return redirect()->back()->with('success', 'Настройки обновлены успешно!');
    }
    
    public function convertPriceList(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|mimes:csv,xlsx',
            ]);

            $file = $request->file('file');
            $filePath = $file->getPathname();

            $spreadsheet = IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();
            $columns = $worksheet->getRowIterator(1, 1)->current()->getCellIterator();

            $columnNames = [];
            foreach ($columns as $column) {
                $columnNames[] = $column->getValue();
            }

            return response()->json($columnNames);
        } catch (\Exception $e) {
            Log::error('Error in convertPriceList: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while processing the file.'], 500);
        }
    }
}