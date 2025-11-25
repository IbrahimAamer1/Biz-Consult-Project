  @php
    use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
    
  @endphp

<!doctype html>
<html lang="en">
    @include('admin.partials.head')
  <body class="vertical  light  @if(LaravelLocalization::getCurrentLocale() == 'ar') rtl @endif ">
    <div class="wrapper">
    @include('admin.partials.navbar')


    @include('admin.partials.sidebar')
      <main role="main" class="main-content">
        @yield('content')
      </main> <!-- main -->
    </div> <!-- .wrapper -->
  @include('admin.partials.scripts')

  <script>
            function confirmdelete(id) {
                if (confirm('Are you sure you want to delete this service?')) {
                    $('#delete-form-'+id).submit();
                }
            }
        </script>
  </body>
</html> 
