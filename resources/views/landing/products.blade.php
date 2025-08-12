<div class="mb-lg-n15 position-relative z-index-2">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Card-->
        <div class="card"
            style="filter: drop-shadow(0px 0px 40px rgba(68, 81, 96, 0.08)); background-color: rgba(211, 216, 221, 0.9);">
            <!--begin::Card body-->
            <div class="card-body p-lg-20">
                <!--begin::Heading-->
                <div class="text-center mb-5 mb-lg-10">
                    <!--begin::Title-->
                    <h3 class="fs-2hx text-gray-900 mb-5" id="portfolio"
                        data-kt-scroll-offset="{default: 100, lg: 250}">
                        Our Products
                    </h3>
                    <!--end::Title-->
                </div>
                <!--end::Heading-->
                <!--begin::Tabs wrapper-->
                <div class="d-flex flex-center mb-5 mb-lg-15">
                    <!--begin::Tabs-->
                    <ul class="nav border-transparent flex-center fs-5 fw-bold">
                          @foreach($products as $product)
                                <li class="nav-item">
                                      <a class="nav-link text-gray-500 text-active-primary px-3 px-lg-6 active" href="#"
                                         data-bs-toggle="tab" data-bs-target="#kt_landing_{{ $product->product_group_code }}">
                                           {{ $product->productGroup->value }}
                                      </a>
                                </li>
                          @endforeach
                    </ul>
                    <!--end::Tabs-->
                </div>
                <!--end::Tabs wrapper-->
                <!--begin::Tabs content cards product-->
                <div class="tab-content">
                    <!--begin::Tab pane-->
                      @foreach($products as $product)
                            <div class="tab-pane fade show active" id="kt_landing_{{ $product->product_group_code }}">
                                  <!--begin::Row-->
                                  <div class="row g-10 ">
                                        <div class="col-lg-4">
                                                    <div class="d-flex h-100 align-items-center">
                                                          <!--begin::Option-->
                                                          <div class="w-100 d-flex flex-column flex-center rounded-3 bg-body py-15 px-10">
                                                                <!--begin::Heading-->
                                                                <div class="mb-7 text-center">
                                                                      <!--begin::Title-->
                                                                      <h1 class="text-gray-900 mb-5 fw-boldest">{{ $product->product_name }}</h1>
                                                                      <!--end::Title-->
                                                                      <!--begin::Description-->
                                                                      <div class="text-gray-500 fw-semibold mb-5">
                                                                            Best Settings for Startups
                                                                      </div>
                                                                      <!--end::Description-->
                                                                      <!--begin::Price-->
                                                                      <div class="text-center">
                                                                            <span class="mb-2 text-primary">Rp</span>
                                                                            <span class="fs-3x fw-bold text-primary" data-kt-plan-price-month="{{number_format($product->price, 0, ',', '.') }}"
                                                                                  data-kt-plan-price-annual="{{number_format($product->price, 0, ',', '.') }}">{{number_format($product->price, 0, ',', '.') }}</span>
                                                                            <span class="fs-7 fw-semibold opacity-50"
                                                                                  data-kt-plan-price-month="/ item" data-kt-plan-price-annual="/ Ann">/item</span>
                                                                      </div>
                                                                      <!--end::Price-->
                                                                </div>
                                                                <!--end::Heading-->
                                                                <!--begin::Features-->
                                                                <div class="w-100 mb-10">
                                                                      <!--begin::Item-->
                                                                      @foreach(preg_split('/\.\s*/', $product->product_description, -1, PREG_SPLIT_NO_EMPTY) as $point)
                                                                            <div class="d-flex flex-stack mb-5">
                                                                                  <span class="fw-semibold fs-6 text-gray-800 text-start pe-3">{{ $point }}</span>
                                                                                  <i class="ki-duotone ki-check-circle fs-1 text-success">
                                                                                        <span class="path1"></span>
                                                                                        <span class="path2"></span>
                                                                                  </i>
                                                                            </div>
                                                                      @endforeach
                                                                      <!--end::Item-->
                                                                </div>
                                                                <!--end::Features-->
                                                                <!--begin::Select-->
                                                                <a href="#" class="btn btn-primary">Select</a>
                                                                <!--end::Select-->
                                                          </div>
                                                          <!--end::Option-->
                                                    </div>
                                              </div>
                                  </div>
                                  <!--end::Row-->
                            </div>
                      @endforeach

                    <!--end::Tab pane-->
                    <!--begin::Tab pane-->
                    <div class="tab-pane fade" id="kt_landing_projects_web_design">
                        <!--begin::Row-->
                        <div class="row g-10">
                            <!--begin::Col-->
                            <div class="col-lg-6">
                                <!--begin::Item-->
                                <a class="d-block card-rounded overlay h-lg-100" data-fslightbox="lightbox-projects"
                                    href="assets/media/stock/600x600/img-11.jpg">
                                    <!--begin::Image-->
                                    <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded h-lg-100 min-h-250px"
                                        style="
                            background-image: url('assets/media/stock/600x600/img-11.jpg');
                          "></div>
                                    <!--end::Image-->
                                    <!--begin::Action-->
                                    <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                                        <i class="ki-duotone ki-eye fs-3x text-white">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    </div>
                                    <!--end::Action-->
                                </a>
                                <!--end::Item-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-lg-6">
                                <!--begin::Row-->
                                <div class="row g-10 mb-10">
                                    <!--begin::Col-->
                                    <div class="col-lg-6">
                                        <!--begin::Item-->
                                        <a class="d-block card-rounded overlay" data-fslightbox="lightbox-projects"
                                            href="assets/media/stock/600x600/img-12.jpg">
                                            <!--begin::Image-->
                                            <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded h-250px"
                                                style="
                                background-image: url('assets/media/stock/600x600/img-12.jpg');
                              "></div>
                                            <!--end::Image-->
                                            <!--begin::Action-->
                                            <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                                                <i class="ki-duotone ki-eye fs-3x text-white">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>
                                            </div>
                                            <!--end::Action-->
                                        </a>
                                        <!--end::Item-->
                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col-lg-6">
                                        <!--begin::Item-->
                                        <a class="d-block card-rounded overlay" data-fslightbox="lightbox-projects"
                                            href="assets/media/stock/600x600/img-21.jpg">
                                            <!--begin::Image-->
                                            <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded h-250px"
                                                style="
                                background-image: url('assets/media/stock/600x600/img-21.jpg');
                              "></div>
                                            <!--end::Image-->
                                            <!--begin::Action-->
                                            <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                                                <i class="ki-duotone ki-eye fs-3x text-white">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>
                                            </div>
                                            <!--end::Action-->
                                        </a>
                                        <!--end::Item-->
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Row-->
                                <!--begin::Item-->
                                <a class="d-block card-rounded overlay" data-fslightbox="lightbox-projects"
                                    href="assets/media/stock/600x400/img-20.jpg">
        WW                            <!--begin::Image-->
                                    <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded h-250px"
                                        style="
                            background-image: url('assets/media/stock/600x600/img-20.jpg');
                          "></div>
                                    <!--end::Image-->
                                    <!--begin::Action-->
                                    <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                                        <i class="ki-duotone ki-eye fs-3x text-white">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    </div>
                                    <!--end::Action-->
                                </a>
                                <!--end::Item-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Tab pane-->
                    <!--end::Tab pane-->
                </div>
                <!--end::Tabs content-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Container-->
</div>
