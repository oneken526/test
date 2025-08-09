<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Page</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans flex justify-center items-center min-h-screen m-0 bg-gray-100">
    @yield('content')
</body>
</html>
