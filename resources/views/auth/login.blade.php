<x-guest-layout :title="__('Login')">
    <div class="d-flex flex-column flex-lg-row flex-column-fluid">
        <!--begin::Wrapper-->
        <div class="d-flex flex-column flex-column-fluid flex-center w-lg-50 p-10">
            <div class="d-flex justify-content-between flex-column-fluid flex-column w-100 mw-450px">
                <div class="d-flex flex-stack py-2">
                    <!--begin::Back link-->
                    <div class="me-2"></div>
                    @if($flag == 'user')
                        <div class="m-0">
                            <span class="text-gray-500 fw-bold fs-5 me-2" data-kt-translate="sign-in-head-desc">Not a Member
                                yet?</span>
                            <a href="{{ route('sign-up', ['flag' => 'user']) }}" class="link-primary fw-bold fs-5"
                                data-kt-translate="sign-in-head-link">Sign Up</a>
                        </div>
                    @endif
                    @if($flag == 'worker')
                        <div class="m-0">
                            <span class="text-gray-500 fw-bold fs-5 me-2" data-kt-translate="sign-in-head-desc">Not a Member
                                yet?</span>
                            <a href="{{ route('sign-up', ['flag' => 'worker']) }}" class="link-primary fw-bold fs-5"
                                data-kt-translate="sign-in-head-link">Sign Up</a>
                        </div>
                    @endif
                    <!--end::Sign Up link=-->
                </div>
                <!--begin::Body-->
                <div class="p-20">
                    <!--begin::Form-->
                    @if($flag == 'user')
                        <x-form :form="'sign-in'" :directUrl="'home'" :title="'Sign In'" :description="'Get our flexibility and easy management business'" :id="'kt_sign_in_form'" :action="'login'">
                        </x-form>
                    @endif
                    @if($flag == 'worker')
                        <x-form :form="'sign-in'" :directUrl="'home'" :title="'Sign In'" :description="'Get our flexibility and easy management business'" :id="'kt_sign_in_form'" :action="'login'"
                            :typeRegister="'worker'">
                        </x-form>
                    @endif
                    <!--end::Form-->
                </div>
                <!--end::Body-->
                <!--begin::Footer-->
                <div class="m-0">
                    <!--begin::Toggle-->
                    <button class="btn btn-flex btn-link rotate" data-kt-menu-trigger="click"
                        data-kt-menu-placement="bottom-start" data-kt-menu-offset="0px, 0px">
                        <img data-kt-element="current-lang-flag" class="w-25px h-25px rounded-circle me-3"
                            src="{{ asset('assets/media/flags/united-states.svg')}}" alt="" />
                        <span data-kt-element="current-lang-name" class="me-2">English</span>
                        <i class="ki-duotone ki-down fs-2 text-muted rotate-180 m-0"></i>
                    </button>
                    <!--end::Toggle-->
                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-4"
                        data-kt-menu="true" id="kt_auth_lang_menu">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link d-flex px-5" data-kt-lang="English">
                                <span class="symbol symbol-20px me-4">
                                    <img data-kt-element="lang-flag" class="rounded-1"
                                        src="{{ asset('assets/media/flags/united-states.svg') }}" alt="" />
                                </span>
                                <span data-kt-element=" lang-name">English</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link d-flex px-5" data-kt-lang="Spanish">
                                <span class="symbol symbol-20px me-4">
                                    <img data-kt-element="lang-flag" class="rounded-1"
                                        src="{{ asset('assets/media/flags/spain.svg') }}" alt="" />
                                </span>
                                <span data-kt-element="lang-name">Spanish</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link d-flex px-5" data-kt-lang="German">
                                <span class="symbol symbol-20px me-4">
                                    <img data-kt-element="lang-flag" class="rounded-1"
                                        src="{{ asset('assets/media/flags/germany.svg') }}" alt="" />
                                </span>
                                <span data-kt-element="lang-name">German</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link d-flex px-5" data-kt-lang="Japanese">
                                <span class="symbol symbol-20px me-4">
                                    <img data-kt-element="lang-flag" class="rounded-1"
                                        src="{{ asset('assets/media/flags/japan.svg') }}" alt="" />
                                </span>
                                <span data-kt-element="lang-name">Japanese</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link d-flex px-5" data-kt-lang="French">
                                <span class="symbol symbol-20px me-4">
                                    <img data-kt-element="lang-flag" class="rounded-1"
                                        src="{{ asset('assets/media/flags/france.svg') }}" alt="" />
                                </span>
                                <span data-kt-element="lang-name">French</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::Menu-->
                </div>
                <!--end::Footer-->
            </div>
        </div>
        <!--begin::Body-->
        <div class="d-none d-lg-flex flex-lg-row-fluid w-50 bgi-size-cover bgi-position-y-center bgi-position-x-start bgi-no-repeat"
            style="background-image: url({{ asset('assets/media/auth/bg11.png') }})"></div>
        <!--begin::Body-->
    </div>
</x-guest-layout>