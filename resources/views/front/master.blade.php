<!DOCTYPE html>
<html lang="en">

    @include('front.partials.head')

<body>
    <div class="container-xxl bg-white p-0">
        @include('front.partials.spinner')


    @include('front.partials.navbar')

    
    @yield('hero')

      @yield('content')

    @include('front.partials.footer')


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    @include('front.partials.scripts')
</body>

</html>