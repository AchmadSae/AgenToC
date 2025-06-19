<x-guest-layout :title="__('Register')">
    <div class="d-flex flex-column flex-lg-row flex-column-fluid">
        <!--begin::Wrapper-->
        <div class="d-flex flex-column flex-column-fluid flex-center w-lg-50 p-10">
            <div class="d-flex justify-content-between flex-column-fluid flex-column w-100 mw-450px">
                <!--begin::Body-->
                <div class="p-10">
                    <!--begin::Form-->
                    @if($flag == 'user')
                        <x-form :form="'sign_up'" :directUrl="'home'" :title="'Join our partnership'" :description="'Be our partners for your freelance business'" :id="'kt_sign_up_form'" :action="'register'">
                        </x-form>
                    @endif
                    @if($flag == 'worker')
                        <x-form :form="'sign_up'" :directUrl="'home'" :title="'Join our partnership'" :description="'Be our partners for your freelance business'" :id="'kt_sign_up_form'" :action="'register'"
                            :typeRegister="'worker'">
                        </x-form>
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
</x-guest-layout>