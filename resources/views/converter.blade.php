<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversor de Números Romanos e Reais</title>
</head>
<body>
    <h1>Conversor de Números Romanos e Reais</h1>

    @if(session('result'))
        <p>Resultado: {{ session('result') }}</p>
    @endif

    @if ($errors->any())
        <div>
            <strong>{{ $errors->first() }}</strong>
        </div>
    @endif

    <form action="/convert" method="POST">
        @csrf
        <label for="number">Número:</label>
        <input type="text" id="number" name="number" required>

        <label for="conversion_type">Converter para:</label>
        <select name="conversion_type" id="conversion_type">
            <option value="to_roman">Reais para Romanos</option>
            <option value="to_reais">Romanos para Reais</option>
        </select>

        <button type="submit">Converter</button>
    </form>
</body>
</html>
