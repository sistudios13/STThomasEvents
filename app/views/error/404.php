<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>404 Not Found</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="<?= url('/assets/favicon-96x96.png') ?>" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="<?= url('/assets/favicon.svg') ?>" />
    <link rel="shortcut icon" href="<?= url('/assets/favicon.ico') ?>" />
    <link rel="apple-touch-icon" sizes="180x180" href="<?= url('/assets/apple-touch-icon.png') ?>" />
    <meta name="apple-mobile-web-app-title" content="St. Thomas Events" />
    <link rel="manifest" href="<?= url('/assets/site.webmanifest') ?>" />
</head>

<body>
    <div class="h-screen flex flex-col items-center justify-center p-4 bg-gray-100">
        <h1 class="text-6xl font-bold text-gray-800">404</h1>
        <p class="text-xl text-gray-600 text-center mt-4">Sorry, the page you are looking for cannot be found.</p>
        <a href="<?= url('/') ?>" class="mt-6 inline-block bg-green-600 text-white font-semibold px-6 py-3 rounded-md hover:bg-green-700 transition">Back to Home</a>
        <a href="<?= url('/support') ?>" class="mt-4 inline-block text-base underline">Support</a>
    </div>
</body>

</html>