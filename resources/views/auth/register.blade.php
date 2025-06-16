<?php
$isWorkerView = $isWorkerView ?? false;
// dd($isWorkerView);
?>
<x-guest-layout :title="__('Register')">
    <div class="d-flex flex-column flex-lg-row flex-column-fluid">
        <!--begin::Wrapper-->
        <div class="d-flex flex-column flex-column-fluid flex-center w-lg-50 p-10">
            <div class="d-flex justify-content-between flex-column-fluid flex-column w-100 mw-450px">
                <!--begin::Body-->
                <div class="p-10">
                    @if(!$isWorkerView)
                        <x-form> </x-form>
                    @endif
                    @if($isWorkerView)
                        <x-form :typeRegister="'Worker'" :title="'Worker Registration'" :description="'Enter your details to create your account'">
                        </x-form>
                    @endif
                </div>
                <!--end::Body-->
            </div>
        </div>
        <!--begin::Body-->
        <div class="d-none d-lg-flex flex-lg-row-fluid w-50 bgi-size-cover bgi-position-y-center bgi-position-x-start bgi-no-repeat"
            style="background-image: url(assets/media/auth/bg11.png)"></div>
        <!--begin::Body-->
    </div>
</x-guest-layout>