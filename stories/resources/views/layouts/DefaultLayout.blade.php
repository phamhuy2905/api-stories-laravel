<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="{{ asset('css/toastr.css') }}"  rel="stylesheet" >
    <link href="{{ asset('css/toastr1.css') }}"  rel="stylesheet" >
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/toastify.min.css') }}">
    @vite('resources/css/app.css')
</head>
<body>
   
    @include('layouts.Sidebar')
  <div class="p-4 sm:ml-64 ">
     <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
        @yield('content')
     </div>
  </div>
  
</body>
   <script src="{{ asset('js/vendors.min.js') }}"></script>
    {{-- toast   --}}
    <script src="{{ asset('js/toastify-js.js') }}"></script>
    <script src="{{ asset('js/validate.js') }}"></script>   
    <script src="{{ asset('js/toastr.js') }}"></script>
    <script src="{{ asset('js/toastr.min.js') }}"> </script>

@stack('js')
</html>