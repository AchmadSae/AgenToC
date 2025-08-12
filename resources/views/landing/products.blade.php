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
                                                                <a href="#" class="btn btn-primary"
                                                                   data-product-id="{{ $product->product_code }}"
                                                                   data-product-name="{{ $product->product_name }}"
                                                                   data-product-price="{{ $product->price }}"
                                                                   data-product-description="{{ $product->product_description }}"
                                                                   data-product-group-code="{{ $product->product_group_code }}"
                                                                   data-product-category="{{ $product->productGroup->value }}"
                                                                   data-product-image="{{ $product->product_image }}"
                                                                   data-bs-toggle="modal"
                                                                   data-bs-target="#kt_modal_checkout">Select</a>
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
                                    href="{{ asset('assets/media/stock/600x600/img-11.jpg') }}">
                                    <!--begin::Image-->
                                    <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded h-lg-100 min-h-250px"
                                        style="
                            background-image: url('{{ asset('assets/media/stock/600x600/img-11.jpg') }}');
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
                                    <!--begin::Image-->
                                    <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded h-250px"
                                        style="
                            background-image: url('{{ asset('assets/media/stock/600x600/img-20.jpg') }}');
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
@push('modals')
<!--begin::Modal - Create Checkout-->
      <div class="modal fade" id="kt_modal_checkout" tabindex="-1" aria-hidden="true">
      <!--begin::Modal dialog-->
      <div class="modal-dialog modal-dialog-centered mw-900px">
            <!--begin::Modal content-->
            <div class="modal-content">
                  <!--begin::Modal header-->
                  <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Checkout</h2>
                        <!--end::Modal title-->
                        <!--begin::Close-->
                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-kt-modal-action-type="close">
                              <i class="ki-duotone ki-cross fs-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                              </i>
                        </div>
                        <!--end::Close-->
                  </div>
                  <!--end::Modal header-->
                  <!--begin::Modal body-->
                  <div class="modal-body py-lg-10 px-lg-10">
                        <!--begin::Stepper-->
                        <div class="stepper stepper-pills stepper-column d-flex flex-column flex-xl-row flex-row-fluid" id="kt_modal_checkout_stepper">
                              <!--begin::Aside-->
                              <div class="d-flex justify-content-center justify-content-xl-start flex-row-auto w-100 w-xl-300px">
                                    <!--begin::Nav-->
                                    <div class="stepper-nav ps-lg-10">
                                          <!--begin::Step 1-->
                                          <div class="stepper-item current" data-kt-stepper-element="nav">
                                                <!--begin::Wrapper-->
                                                <div class="stepper-wrapper">
                                                      <!--begin::Icon-->
                                                      <div class="stepper-icon w-40px h-40px">
                                                            <i class="ki-duotone ki-check stepper-check fs-2"></i>
                                                            <span class="stepper-number">1</span>
                                                      </div>
                                                      <!--end::Icon-->
                                                      <!--begin::Label-->
                                                      <div class="stepper-label">
                                                            <h3 class="stepper-title">Details</h3>
                                                            <div class="stepper-desc">Describe your idea</div>
                                                      </div>
                                                      <!--end::Label-->
                                                </div>
                                                <!--end::Wrapper-->
                                                <!--begin::Line-->
                                                <div class="stepper-line h-40px"></div>
                                                <!--end::Line-->
                                          </div>
                                          <!--end::Step 1-->
                                          <!--begin::Step 2-->
                                          <div class="stepper-item" data-kt-stepper-element="nav">
                                                <!--begin::Wrapper-->
                                                <div class="stepper-wrapper">
                                                      <!--begin::Icon-->
                                                      <div class="stepper-icon w-40px h-40px">
                                                            <i class="ki-duotone ki-check stepper-check fs-2"></i>
                                                            <span class="stepper-number">2</span>
                                                      </div>
                                                      <!--begin::Icon-->
                                                      <!--begin::Label-->
                                                      <div class="stepper-label">
                                                            <h3 class="stepper-title">Expectations</h3>
                                                            <div class="stepper-desc">Define your expectations</div>
                                                      </div>
                                                      <!--begin::Label-->
                                                </div>
                                                <!--end::Wrapper-->
                                                <!--begin::Line-->
                                                <div class="stepper-line h-40px"></div>
                                                <!--end::Line-->
                                          </div>
                                          <!--end::Step 2-->
                                          <!--begin::Step 4-->
                                          <div class="stepper-item" data-kt-stepper-element="nav">
                                                <!--begin::Wrapper-->
                                                <div class="stepper-wrapper">
                                                      <!--begin::Icon-->
                                                      <div class="stepper-icon w-40px h-40px">
                                                            <i class="ki-duotone ki-check stepper-check fs-2"></i>
                                                            <span class="stepper-number">4</span>
                                                      </div>
                                                      <!--end::Icon-->
                                                      <!--begin::Label-->
                                                      <div class="stepper-label">
                                                            <h3 class="stepper-title">Billing</h3>
                                                            <div class="stepper-desc">Provide payment details</div>
                                                      </div>
                                                      <!--end::Label-->
                                                </div>
                                                <!--end::Wrapper-->
                                                <!--begin::Line-->
                                                <div class="stepper-line h-40px"></div>
                                                <!--end::Line-->
                                          </div>
                                          <!--end::Step 4-->
                                          <!--begin::Step 5-->
                                          <div class="stepper-item mark-completed" data-kt-stepper-element="nav">
                                                <!--begin::Wrapper-->
                                                <div class="stepper-wrapper">
                                                      <!--begin::Icon-->
                                                      <div class="stepper-icon w-40px h-40px">
                                                            <i class="ki-duotone ki-check stepper-check fs-2"></i>
                                                            <span class="stepper-number">5</span>
                                                      </div>
                                                      <!--end::Icon-->
                                                      <!--begin::Label-->
                                                      <div class="stepper-label">
                                                            <h3 class="stepper-title">Completed</h3>
                                                            <div class="stepper-desc">Review and Submit</div>
                                                      </div>
                                                      <!--end::Label-->
                                                </div>
                                                <!--end::Wrapper-->
                                          </div>
                                          <!--end::Step 5-->
                                    </div>
                                    <!--end::Nav-->
                              </div>
                              <!--begin::Aside-->
                              <!--begin::Content-->
                              <div class="flex-row-fluid py-lg-5 px-lg-15">
                                    <!--begin::Form-->
                                    <form class="form" novalidate="novalidate" id="kt_modal_checkout_form" action="{{ route('checkout') }}">
                                          <!--begin::Step 1-->
                                          <div class="current" data-kt-stepper-element="content">
                                                <div class="w-100">
                                                      <!--begin::Input group-->
                                                      <div class="fv-row mb-10">
                                                            <!--begin::Label-->
                                                            <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                                                  <span class="required">Topic</span>
                                                                  <span class="ms-1" data-bs-toggle="tooltip" title='Specify your topic' >
														<i class="ki-duotone ki-information-5 text-gray-500 fs-6">
															<span class="path1"></span>
															<span class="path2"></span>
															<span class="path3"></span>
														</i>
													</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="text" class="form-control form-control-lg form-control-solid" name="title" placeholder="" value="" />
                                                            <!--begin::Label-->
                                                            <label class="d-flex align-items-center fs-5 fw-semibold mt-4">
                                                                  <span class="required">Description</span>
                                                                  <span class="ms-1" data-bs-toggle="tooltip" title='Tell us more about your topic' >
														<i class="ki-duotone ki-information-5 text-gray-500 fs-6">
															<span class="path1"></span>
															<span class="path2"></span>
															<span class="path3"></span>
														</i>
													</span>
                                                            </label>
                                                            <textarea name="description" class="form-control form-control-solid mt-2" rows="3" placeholder="Type your description"></textarea>
                                                            <!--end::Input-->
                                                      </div>
                                                      <!--end::Input group-->
                                                </div>
                                          </div>
                                          <!--end::Step 1-->
                                          <!--begin::Step 2-->
                                          <div data-kt-stepper-element="content">
                                                <div class="w-100">
                                                      <!--begin::Input group-->
                                                      <div class="fv-row">
                                                            <!--begin::Dropzone-->
                                                            <div class="dropzone" id="kt_modal_create_checkout_file_dropzone">
                                                                  <!--begin::Message-->
                                                                  <div class="dz-message needsclick">
                                                                        <!--begin::Icon-->
                                                                        <i class="ki-duotone ki-file-up fs-3hx text-primary">
                                                                              <span class="path1"></span>
                                                                              <span class="path2"></span>
                                                                        </i>
                                                                        <!--end::Icon-->
                                                                        <!--begin::Info-->
                                                                        <div class="ms-4">
                                                                              <h3 class="dfs-3 fw-bold text-gray-900 mb-1">Drop files here or click to upload.</h3>
                                                                              <span class="fw-semibold fs-4 text-muted">Upload up to 10 files</span>
                                                                        </div>
                                                                        <!--end::Info-->
                                                                  </div>
                                                            </div>
                                                            <!--end::Dropzone-->
                                                      </div>
                                                      <div class="fv-row mb-8">
                                                            <!--begin::Label-->
                                                            <label class="required fs-6 fw-semibold mb-2">Release Date</label>
                                                            <!--end::Label-->
                                                            <!--begin::Wrapper-->
                                                            <div class="position-relative d-flex align-items-center">
                                                                  <!--begin::Icon-->
                                                                  <i class="ki-duotone ki-calendar-8 fs-2 position-absolute mx-4">
                                                                        <span class="path1"></span>
                                                                        <span class="path2"></span>
                                                                        <span class="path3"></span>
                                                                        <span class="path4"></span>
                                                                        <span class="path5"></span>
                                                                        <span class="path6"></span>
                                                                  </i>
                                                                  <!--end::Icon-->
                                                                  <!--begin::Input-->
                                                                  <input class="form-control form-control-solid ps-12" placeholder="Pick date range" name="settings_due_date" />
                                                                  <!--end::Input-->
                                                            </div>
                                                            <!--end::Wrapper-->
                                                      </div>
                                                      <!--end::Input group-->
                                                </div>
                                          </div>
                                          <!--end::Step 2-->
                                          <!--begin::Step 3-->
                                          <div data-kt-stepper-element="content">
                                                <div class="w-100">
                                                      <!--begin::Input group-->
                                                      <div class="d-flex flex-column mb-7 fv-row">
                                                            <!--begin::Label-->
                                                            <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                                                                  <span class="required">Name On Card</span>
                                                                  <span class="ms-1" data-bs-toggle="tooltip" title="Specify a card holder's name">
														<i class="ki-duotone ki-information-5 text-gray-500 fs-6">
															<span class="path1"></span>
															<span class="path2"></span>
															<span class="path3"></span>
														</i>
													</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <input type="text" class="form-control form-control-solid" placeholder="" name="username" value="Max Doe" />
                                                      </div>
                                                      <!--begin::Input group-->
                                                      <div class="d-flex flex-column mb-7 fv-row">
                                                            <!--begin::Label-->
                                                            <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                                                                  <span class="required">Email Address</span>
                                                                  <span class="ms-1" data-bs-toggle="tooltip" title="Fill email for confirmation account and payment">
														<i class="ki-duotone ki-information-5 text-gray-500 fs-6">
															<span class="path1"></span>
															<span class="path2"></span>
															<span class="path3"></span>
														</i>
													</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <input type="email" class="form-control form-control-solid" placeholder="" name="email" />
                                                      </div>
                                                      <!--end::Input group-->
                                                      <!--begin::Input group-->
                                                      <div class="d-flex flex-column mb-7 fv-row">
                                                            <!--begin::Label-->
                                                            <label class="required fs-6 fw-semibold form-label mb-2">Card Number</label>
                                                            <!--end::Label-->
                                                            <!--begin::Input wrapper-->
                                                            <div class="position-relative">
                                                                  <!--begin::Input-->
                                                                  <input type="text" class="form-control form-control-solid" placeholder="Enter card number" name="card_number" value="4111 1111 1111 1111" />
                                                                  <!--end::Input-->
                                                                  <!--begin::Card logos-->
                                                                  <div class="position-absolute translate-middle-y top-50 end-0 me-5">
                                                                        <img src="assets/media/svg/card-logos/visa.svg" alt="" class="h-25px" />
                                                                        <img src="assets/media/svg/card-logos/mastercard.svg" alt="" class="h-25px" />
                                                                        <img src="assets/media/svg/card-logos/american-express.svg" alt="" class="h-25px" />
                                                                  </div>
                                                                  <!--end::Card logos-->
                                                            </div>
                                                            <!--end::Input wrapper-->
                                                      </div>
                                                      <!--end::Input group-->
                                                      <!--begin::Input group-->
                                                      <div class="d-flex flex-stack">
                                                            <!--begin::Label-->
                                                            <div class="me-5">
                                                                  <label class="fs-6 fw-semibold form-label">Save Card for further billing?</label>
                                                                  <div class="fs-7 fw-semibold text-muted">If you need more info, please check budget planning</div>
                                                            </div>
                                                            <!--end::Label-->
                                                            <!--begin::Switch-->
                                                            <label class="form-check form-switch form-check-custom form-check-solid">
                                                                  <input class="form-check-input" type="checkbox" value="1" checked="checked" name="isSaveCard" />
                                                                  <span class="form-check-label fw-semibold text-muted">Save Card</span>
                                                            </label>
                                                            <!--end::Switch-->
                                                      </div>
                                                      <!--end::Input group-->
                                                </div>
                                          </div>
                                          <!--end::Step 4-->
                                          <!--begin::Step 5-->
                                          <div data-kt-stepper-element="content">
                                                <div class="w-100 text-center">
                                                      <!--begin::Heading-->
                                                      <h1 class="fw-bold text-gray-900 mb-3">Release!</h1>
                                                      <!--end::Heading-->
                                                      <!--begin::Description-->
                                                      <div class="text-muted fw-semibold fs-3">Submit your app to kickstart your project.</div>
                                                      <!--end::Description-->
                                                      <!--begin::Illustration-->
                                                      <div class="text-center px-4 py-15">
                                                            <img src="{{ asset('assets/media/illustrations/sigma-1/9.png') }}" alt="" class="mw-100 mh-300px" />
                                                      </div>
                                                      <!--end::Illustration-->
                                                </div>
                                          </div>
                                          <!--end::Step 5-->
                                          <!--begin::Actions-->
                                          <div class="d-flex flex-stack pt-10">
                                                <!--begin::Wrapper-->
                                                <div class="me-2">
                                                      <button type="button" class="btn btn-lg btn-light-primary me-3" data-kt-stepper-action="previous">
                                                            <i class="ki-duotone ki-arrow-left fs-3 me-1">
                                                                  <span class="path1"></span>
                                                                  <span class="path2"></span>
                                                            </i>Back</button>
                                                </div>
                                                <!--end::Wrapper-->
                                                <!--begin::Wrapper-->
                                                <div>
                                                      <button type="button" class="btn btn-lg btn-primary" data-kt-stepper-action="submit">
												<span class="indicator-label">Submit
												<i class="ki-duotone ki-arrow-right fs-3 ms-2 me-0">
													<span class="path1"></span>
													<span class="path2"></span>
												</i></span>
                                                            <span class="indicator-progress">Please wait...
												<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                      </button>
                                                      <button type="button" class="btn btn-lg btn-primary" data-kt-stepper-action="next">Continue
                                                            <i class="ki-duotone ki-arrow-right fs-3 ms-1 me-0">
                                                                  <span class="path1"></span>
                                                                  <span class="path2"></span>
                                                            </i></button>
                                                </div>
                                                <!--end::Wrapper-->
                                          </div>
                                          <!--end::Actions-->
                                    </form>
                                    <!--end::Form-->
                              </div>
                              <!--end::Content-->
                        </div>
                        <!--end::Stepper-->
                  </div>
                  <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
      </div>
      <!--end::Modal dialog-->
</div>
<!--end::Modal - Create App-->
@endpush
