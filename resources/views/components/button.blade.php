<!-- <button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button> -->

@props(['id' => null, 'type', 'class', 'translate', 'text' => 'Submit'])

<button {{ $attributes->merge([
    'id' => $id,
    'class' => 'btn btn-' . $type . ' ' . $class,
])
    }}>
    <!--begin::Indicator label-->
    <span class="indicator-label" data-kt-translate="{{ $translate }}">{{ $text}}</span>
    <!--end::Indicator label-->
    <!--begin::Indicator progress-->
    <span class="indicator-progress">
        <span data-kt-translate="general-progress">Please wait...</span>
        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
    </span>
    <!--end::Indicator progress-->
</button>