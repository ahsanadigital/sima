<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />

  <!-- Main Title Here -->
  <title>{{ !empty($title) ? $title : config('app.name') }}</title>

  <!-- Main Styling -->
  <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
  <link rel="stylesheet" href="{{ asset('vendor/toastr/snackbar.css') }}" />

  <!-- Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />

  @yield('header')
</head>
<body class="bg-gradient-primary">

  @yield('container')

  <!-- Main Script -->
  <script src="{{ asset('js/app.js') }}"></script>
  <script src="{{ asset('vendor/toastr/snackbar.js') }}"></script>

  @yield('footer')
  @stack('script')

  @if(session('error'))
  <script>
    "use strict";

    Snackbar.show({
      pos: 'top-right',
      actionText: 'Close',
      width: '25%',
      text: '{{ session("error") }}',
      textColor: '#FFFFFF',
      backgroundColor: '#e74a3b',
      actionTextColor: '#FFFFFF',
    });
  </script>
  @elseif(session('success'))
  <script>
    "use strict";

    Snackbar.show({
      pos: 'top-right',
      actionText: 'Close',
      width: '25%',
      text: '{{ session("success") }}',
      textColor: '#FFFFFF',
      backgroundColor: '#1cc88a',
      actionTextColor: '#FFFFFF',
    });
  </script>
  @elseif(session('warning'))
  <script>
    "use strict";

    Snackbar.show({
      pos: 'top-right',
      actionText: 'Close',
      width: '25%',
      text: '{{ session("warning") }}',
      textColor: '#FFFFFF',
      backgroundColor: '#f6c23e',
      actionTextColor: '#FFFFFF',
    });
  </script>
  @elseif(session('info'))
  <script>
    "use strict";

    Snackbar.show({
      pos: 'top-right',
      actionText: 'Close',
      width: '25%',
      text: '{{ session("warning") }}',
      textColor: '#FFFFFF',
      backgroundColor: '#36b9cc',
      actionTextColor: '#FFFFFF',
    });
  </script>
  @endif
</body>
</html>
