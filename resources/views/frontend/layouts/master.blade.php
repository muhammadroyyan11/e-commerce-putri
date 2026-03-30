<!DOCTYPE html>
<html lang="en">
<head>
    @include('frontend.layouts.head')
</head>
<body>

@include('frontend.layouts.notification')

@include('frontend.layouts.header')

<main class="main-content">
    @yield('main-content')
</main>

@include('frontend.layouts.footer')

</body>
</html>