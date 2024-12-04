<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tariff;
use Carbon\Carbon;

class TariffController extends Controller
{
    public function save(Request $request)
    {
        // Валидация данных
        $request->validate([
            'ad-count' => 'required|integer|min:100|max:100000',
        ]);

        // Расчет цен
        $adCount = $request->input('ad-count');
        $basePricePerDay = 0.75;
        $discountFactor = 1 - min(0.5, ($adCount - 100) / 100000);
        $dailyCost = $adCount * $basePricePerDay * $discountFactor;
        $dailyCostPerItem = $basePricePerDay * $discountFactor;
        $monthlyCost = $dailyCost * 30;

        // Получение даты регистрации пользователя
        $user = auth()->user();
        $dateJoined = $user->date_joined;

        // Определение статуса
        $status = Carbon::parse($dateJoined)->diffInDays(Carbon::now()) >= 14 ? 'old' : 'new';

        // Поиск тарифа для пользователя
        $tariff = Tariff::where('id_user', $user->id)->first();

        if ($tariff) {
            // Если тариф уже существует, получаем id_tariff
            $idTariff = $tariff->id_tariff;

            // Обновляем данные по id_tariff
            Tariff::where('id_tariff', $idTariff)->update([
                'price_day' => $dailyCost,
                'price_day_one_advert' => $dailyCostPerItem,
                'price_month' => $monthlyCost,
                'adverts' => $adCount,
                'status' => $status,
                'updated_at' => Carbon::now(), // Убедитесь, что updated_at обновляется
            ]);
        } else {
            // Если тарифа нет, создаем новый
            $tariff = Tariff::create([
                'id_user' => $user->id,
                'price_day' => $dailyCost,
                'price_day_one_advert' => $dailyCostPerItem,
                'price_month' => $monthlyCost,
                'adverts' => $adCount,
                'status' => $status,
            ]);
        }

        return redirect()->back()->with('success', 'Тариф успешно сохранен!');
    }
}