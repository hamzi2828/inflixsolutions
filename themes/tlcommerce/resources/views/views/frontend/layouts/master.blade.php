@php
    use Plugin\TlcommerceCore\Repositories\SettingsRepository;
    use Illuminate\Support\Facades\Cache;
    $site_name = Cache::remember('site-title', 60 * 60 * 60, function () {
        return getGeneralSetting('system_name') != null ? getGeneralSetting('system_name') : getGeneralSetting('site_title');
    });
    $site_moto = Cache::remember('site-moto', 60 * 60 * 60, function () {
        return getGeneralSetting('site_moto') != null ? ' | ' . getGeneralSetting('site_moto') : '';
    });
    $site_title = $site_name . '' . $site_moto;
    $default_language = defaultLanguage();
    $default_country = defaultCountry();
    $default_curency = SettingsRepository::defaultCurrency();
    
    $active_theme = getActiveTheme();
    
    $body_typography = themeOptionToCss('body_typography', $active_theme->id);
    $paragraph_typography = themeOptionToCss('paragraph_typography', $active_theme->id);
    $heading_typography = themeOptionToCss('heading_typography', $active_theme->id);
    $menu_typography = themeOptionToCss('menu_typography', $active_theme->id);
    $button_typography = themeOptionToCss('button_typography', $active_theme->id);
    
    $logo_details = getGeneralSettingsDetails();
    
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    @if (isset($logo_details['favicon']))
        <link rel="shortcut icon" href="{{ project_asset($logo_details['favicon']) }}">
    @else
        <link rel="shortcut icon" href="{{ asset('/public/backend/assets/img/favicon.png') }}">
    @endif
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @yield('seo')
    <meta property="og:image:width" content="1200" />
    <meta name="brand_name" content="{{ $site_name }}" />
    <link rel="canonical" href="{{ env('APP_URL') }}" />
    <meta property="og:url" content="{{ env('APP_URL') }}" />
    <meta name="twitter:domain" content="{{ env('APP_URL') }}" />
    <meta property="og:site_name" content="{{ $site_name }}" />
    <meta name="twitter:site" content="{{ $site_name }}" />
    <meta name="apple-mobile-web-app-title" content="{{ $site_title }}" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/public/backend/assets/plugins/fontawsome/css/all.min.css') }}">
    <link rel="stylesheet" href="/themes/tlcommerce/public/blog/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('/themes/tlcommerce/public/css/custom_app.css') }}">


    <link rel="stylesheet" type="text/css" href="{{ asset('/themes/tlcommerce/public/css/back_to_top.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/themes/tlcommerce/public/css/header.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/themes/tlcommerce/public/css/header_logo.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/themes/tlcommerce/public/css/menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/themes/tlcommerce/public/css/blog.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/themes/tlcommerce/public/css/sidebar_options.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/themes/tlcommerce/public/css/page_404.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/themes/tlcommerce/public/css/subscribe.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/themes/tlcommerce/public/css/footer.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/themes/tlcommerce/public/css/social_icon.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/themes/tlcommerce/public/css/custom_css.css') }}">
    <!-- Including all google fonts link -->
    @includeIf('theme/tlcommerce::frontend.blog.includes.custom.google-font-link', [
        'body_typography' => $body_typography,
        'paragraph_typography' => $paragraph_typography,
        'heading_typography' => $heading_typography,
        'menu_typography' => $menu_typography,
        'button_typography' => $button_typography,
    ])
    <!-- Including all dynamic css -->
    @includeIf('theme/tlcommerce::frontend.blog.includes.custom.tl-dynamic-css', [
        'body_typography' => $body_typography,
        'paragraph_typography' => $paragraph_typography,
        'heading_typography' => $heading_typography,
        'menu_typography' => $menu_typography,
        'button_typography' => $button_typography,
    ])
    <!-- Theme Option Css -->
</head>

<body class="antialiased">
    <div id="app">
    </div>
    <script>
        //set site title
        let site_title = localStorage.getItem('site_title');
        localStorage.setItem('site_title', '<?php echo $site_title; ?>');

        //set default language
        let locale = localStorage.getItem('locale');
        if (locale == null) {
            localStorage.setItem('locale', '<?php echo $default_language; ?>');
        }
        //set default country
        let country = localStorage.getItem('country');
        if (country == null) {
            localStorage.setItem('country', '<?php echo $default_country; ?>');
        }
        //set selected currency
        let currency = localStorage.getItem('currency');

        if (currency == null) {
            localStorage.setItem('currency', '<?php echo $default_curency; ?>');
        }
        //set default currency
        localStorage.setItem('default_currency', '<?php echo $default_curency; ?>');
    </script>
    @if (isActivePluging('tlecommercecore'))
        <script src="{{ asset('/themes/tlcommerce/public/js/main.js?v=1040') }}"></script>
    @endif
</body>

</html>
