<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>пополнения</title>
</head>
<body>
    

<form action="{{ route('pay') }}" method="POST">
    @csrf
    <label for="amount">Сумма пополнения (в рублях):</label>
    <input type="number" name="amount" id="amount" required>
    <button type="submit">Пополнить</button>
</form>

</body>
</html>