@php
    use Illuminate\Support\Facades\Cache;
    $site_name = Cache::remember('site-title', 60 * 60 * 60, function () {
        return getGeneralSetting('system_name') != null ? getGeneralSetting('system_name') : getGeneralSetting('site_title');
    });
    $site_moto = Cache::remember('site-moto', 60 * 60 * 60, function () {
        return getGeneralSetting('site_moto') != null ? ' | ' . getGeneralSetting('site_moto') : '';
    });
    $site_title = $site_name . '' . $site_moto;
    $meta_title = getGeneralSetting('site_meta_title') ? getGeneralSetting('site_meta_title') : getGeneralSetting('system_name');
@endphp
@extends('theme/tlcommerce::frontend.layouts.master')
@section('seo')
    <title>{{ $site_title }}</title>
    <meta name="title" content="{{ $meta_title }}" />
    <meta name="description" content="{{ getGeneralSetting('site_meta_description') }}" />
    <meta name="keywords" content="{{ getGeneralSetting('site_meta_keywords') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{ getGeneralSetting('site_meta_title') }}" />
    <meta property="og:description" content="{{ getGeneralSetting('site_meta_description') }}" />
    <meta name="twitter:card" content="{{ getGeneralSetting('site_meta_description') }}" />
    <meta name="twitter:title" content="{{ getGeneralSetting('site_meta_title') }}" />
    <meta name="twitter:description" content="{{ getGeneralSetting('site_meta_description') }}" />
    <meta name="twitter:image" content="{{ getFilePath(getGeneralSetting('site_meta_image')) }}" />
    <meta property="og:image" content="{{ getFilePath(getGeneralSetting('site_meta_image')) }}" />
@endsection
