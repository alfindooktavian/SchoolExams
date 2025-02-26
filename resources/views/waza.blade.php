<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="text-center">
        <h1 class="text-4xl font-bold text-gray-800">Selamat Datang di Laravel 10</h1>
        <p class="text-gray-600 mt-2">Framework PHP yang elegan dan simpel</p>
        <a href="{{ url('/dashboard') }}" class="mt-4 inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
            Pergi ke Waza
        </a>
    </div>
</body>
</html>
