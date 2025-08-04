<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>
    <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}" />
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <!--end::Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
      <script src="{{ asset('assets/js/custom/app.js')  }}"></script>
</head>

<body id="kt_body" class="header-tablet-and-mobile-fixed aside-enabled">
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
              @if(  ) @endif
            @include('template/aside')
            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                @include('template/header')

                <main>
                    {{ $slot }}
                </main>

            </div>
            <!--end::Wrapper-->
        </div>

        @stack('modals')
        @include('sweetalert::alert')
        @stack('scripts')

    </div>
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{  asset('assets/js/scripts.bundle.js') }}"></script>
{{--    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>--}}

    <!--end::Global Javascript Bundle-->
    <!--begin::Vendors Javascript(used for this page only)-->
    <!-- <script src="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>

    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/map.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script> -->
    <!--end::Vendors Javascript-->
    <!--begin::Custom Javascript(used for this page only)-->
    <script src="{{ asset('assets/js/custom/utilities/modals/create-app.js') }}"></script>
    <!--end::Custom Javascript-->
    <!--end::Javascript-->
</body>

</html>
