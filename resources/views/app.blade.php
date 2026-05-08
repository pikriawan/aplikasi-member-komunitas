<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <x-inertia::head />
    </head>
    <body>
        <x-inertia::app />
    </body>
</html>
