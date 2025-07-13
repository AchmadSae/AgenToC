<x-app-layout>
    <x-slot:title>
        Client Dashboard
        </x-slot>

        <!--begin::Content-->
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            <!--begin::Post-->
            <div class="post d-flex flex-column-fluid" id="kt_post">
                <!--begin::Container-->
                <div id="kt_content_container" class="container-xxl">
                    @include('client/sections/overview')
                    @include('client/sections/task')

                </div>
                <!--end::Post-->
            </div>
            @include('template/footer')
            <!-- end::wrapper -->
        </div>


</x-app-layout>