@php
$config = [
'appName' => config('app.name'),
'locale' => $locale = app()->getLocale(),
'locales' => config('app.locales'),
'googleAuth' => config('services.google.client_id'),
'facebookAuth' => config('services.facebook.client_id'),
];
@endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>{{ config('app.name') }}</title>

  <link rel="manifest" href="/manifest.json">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />

  <link rel="stylesheet" href="{{ mix('dist/css/app.css') }}" />
</head>

<body>
  <div id="app"></div>

  <script>
    window.config = @json($config);
  </script>

  <script src="{{ mix('dist/js/app.js') }}"></script>
</body>

</html>