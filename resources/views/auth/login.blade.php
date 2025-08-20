<x-guest-lay>
    <x-slot:title>
        Login
    </x-slot>
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
                    <x-form-auth :form="'sign-in'" :directUrl="'test'" :title="'Sign In'"
                        :description="'Get our flexibility and easy management business'" :id="'kt_sign_in_form'"
                        :action="'login'">
                    </x-form-auth>
                    @endif
                    @if($flag == 'worker')
                    <x-form-auth :form="'sign-in'" :directUrl="'home'" :title="'Sign In'"
                        :description="'Get our flexibility and easy management business'" :id="'kt_sign_in_form'"
                        :action="'login'" :typeRegister="'worker'">
                    </x-form-auth>
                    @endif
                    <!--end::Form-->
                </div>
                <!--end::Body-->
            </div>
        </div>
        <!--begin::Body-->
        <div class="d-none d-lg-flex flex-lg-row-fluid w-50 bgi-size-cover bgi-position-y-center bgi-position-x-start bgi-no-repeat"
            style="background-image: url({{ asset('assets/media/auth/bg11.png') }})"></div>
        <!--begin::Body-->
    </div>
</x-guest-lay>
