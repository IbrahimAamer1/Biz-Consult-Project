  @php
  use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

 $locale = LaravelLocalization::getCurrentLocale() == 'ar' ? 'en' : 'ar';
 @endphp
       <a class="nav-link text-muted my-2" href="{{ LaravelLocalization::getLocalizedURL($locale) }}" id="localeSwitcher">
      {{ strtoupper($locale) }}
     </a>