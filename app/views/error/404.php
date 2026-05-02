<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>404 Not Found</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="h-screen flex flex-col items-center justify-center bg-gray-100">
        <h1 class="text-6xl font-bold text-gray-800">404</h1>
        <p class="text-xl text-gray-600 text-center mt-4">Sorry, the page you are looking for cannot be found.</p>
        <a href="<?= url('/') ?>" class="mt-6 inline-block bg-green-700 text-white px-6 py-3 rounded-md hover:bg-green-800 transition">Back to Home</a>
        <a href="<?= url('/support') ?>" class="mt-4 inline-block text-base underline">Support</a>
    </div>
</body>

</html>