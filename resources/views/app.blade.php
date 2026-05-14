<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @fonts

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <x-inertia::head />

        @php
            $primaryColor = \App\Models\Setting::get('primary_color', '#007FFF');
            $surfaceColor = \App\Models\Setting::get('surface_color', '#E5F2FF');
        @endphp

        <style>
            :root {
                --color-primary: {{ $primaryColor }};
                --color-surface: {{ $surfaceColor }};
            }
        </style>
    </head>
    <body>
        <x-inertia::app />
    </body>
</html>
