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
                                                                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app">Select</a>
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
                </div>
                <!--end::Tabs content-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Container-->
</div>
<!--begin::Modal - Create App-->
<div class="modal fade" id="kt_modal_create_app" tabindex="-1" aria-hidden="true">
      <!--begin::Modal dialog-->
      <div class="modal-dialog modal-dialog-centered mw-900px">
            <!--begin::Modal content-->
            <div class="modal-content">
                  <!--begin::Modal header-->
                  <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Create App</h2>
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
                        <div class="stepper stepper-pills stepper-column d-flex flex-column flex-xl-row flex-row-fluid" id="kt_modal_create_app_stepper">
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
                                                            <div class="stepper-desc">Name your App</div>
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
                                                            <h3 class="stepper-title">Frameworks</h3>
                                                            <div class="stepper-desc">Define your app framework</div>
                                                      </div>
                                                      <!--begin::Label-->
                                                </div>
                                                <!--end::Wrapper-->
                                                <!--begin::Line-->
                                                <div class="stepper-line h-40px"></div>
                                                <!--end::Line-->
                                          </div>
                                          <!--end::Step 2-->
                                          <!--begin::Step 3-->
                                          <div class="stepper-item" data-kt-stepper-element="nav">
                                                <!--begin::Wrapper-->
                                                <div class="stepper-wrapper">
                                                      <!--begin::Icon-->
                                                      <div class="stepper-icon w-40px h-40px">
                                                            <i class="ki-duotone ki-check stepper-check fs-2"></i>
                                                            <span class="stepper-number">3</span>
                                                      </div>
                                                      <!--end::Icon-->
                                                      <!--begin::Label-->
                                                      <div class="stepper-label">
                                                            <h3 class="stepper-title">Database</h3>
                                                            <div class="stepper-desc">Select the app database type</div>
                                                      </div>
                                                      <!--end::Label-->
                                                </div>
                                                <!--end::Wrapper-->
                                                <!--begin::Line-->
                                                <div class="stepper-line h-40px"></div>
                                                <!--end::Line-->
                                          </div>
                                          <!--end::Step 3-->
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
                                    <form class="form" novalidate="novalidate" id="kt_modal_create_app_form">
                                          <!--begin::Step 1-->
                                          <div class="current" data-kt-stepper-element="content">
                                                <div class="w-100">
                                                      <!--begin::Input group-->
                                                      <div class="fv-row mb-10">
                                                            <!--begin::Label-->
                                                            <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                                                  <span class="required">App Name</span>
                                                                  <span class="ms-1" data-bs-toggle="tooltip" title="Specify your unique app name">
														<i class="ki-duotone ki-information-5 text-gray-500 fs-6">
															<span class="path1"></span>
															<span class="path2"></span>
															<span class="path3"></span>
														</i>
													</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="text" class="form-control form-control-lg form-control-solid" name="name" placeholder="" value="" />
                                                            <!--end::Input-->
                                                      </div>
                                                      <!--end::Input group-->
                                                      <!--begin::Input group-->
                                                      <div class="fv-row">
                                                            <!--begin::Label-->
                                                            <label class="d-flex align-items-center fs-5 fw-semibold mb-4">
                                                                  <span class="required">Category</span>
                                                                  <span class="ms-1" data-bs-toggle="tooltip" title="Select your app category">
														<i class="ki-duotone ki-information-5 text-gray-500 fs-6">
															<span class="path1"></span>
															<span class="path2"></span>
															<span class="path3"></span>
														</i>
													</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin:Options-->
                                                            <div class="fv-row">
                                                                  <!--begin:Option-->
                                                                  <label class="d-flex flex-stack mb-5 cursor-pointer">
                                                                        <!--begin:Label-->
                                                                        <span class="d-flex align-items-center me-2">
															<!--begin:Icon-->
															<span class="symbol symbol-50px me-6">
																<span class="symbol-label bg-light-primary">
																	<i class="ki-duotone ki-compass fs-1 text-primary">
																		<span class="path1"></span>
																		<span class="path2"></span>
																	</i>
																</span>
															</span>
                                                                              <!--end:Icon-->
                                                                              <!--begin:Info-->
															<span class="d-flex flex-column">
																<span class="fw-bold fs-6">Quick Online Courses</span>
																<span class="fs-7 text-muted">Creating a clear text structure is just one SEO</span>
															</span>
                                                                              <!--end:Info-->
														</span>
                                                                        <!--end:Label-->
                                                                        <!--begin:Input-->
                                                                        <span class="form-check form-check-custom form-check-solid">
															<input class="form-check-input" type="radio" name="category" value="1" />
														</span>
                                                                        <!--end:Input-->
                                                                  </label>
                                                                  <!--end::Option-->
                                                                  <!--begin:Option-->
                                                                  <label class="d-flex flex-stack mb-5 cursor-pointer">
                                                                        <!--begin:Label-->
                                                                        <span class="d-flex align-items-center me-2">
															<!--begin:Icon-->
															<span class="symbol symbol-50px me-6">
																<span class="symbol-label bg-light-danger">
																	<i class="ki-duotone ki-element-11 fs-1 text-danger">
																		<span class="path1"></span>
																		<span class="path2"></span>
																		<span class="path3"></span>
																		<span class="path4"></span>
																	</i>
																</span>
															</span>
                                                                              <!--end:Icon-->
                                                                              <!--begin:Info-->
															<span class="d-flex flex-column">
																<span class="fw-bold fs-6">Face to Face Discussions</span>
																<span class="fs-7 text-muted">Creating a clear text structure is just one aspect</span>
															</span>
                                                                              <!--end:Info-->
														</span>
                                                                        <!--end:Label-->
                                                                        <!--begin:Input-->
                                                                        <span class="form-check form-check-custom form-check-solid">
															<input class="form-check-input" type="radio" name="category" value="2" />
														</span>
                                                                        <!--end:Input-->
                                                                  </label>
                                                                  <!--end::Option-->
                                                                  <!--begin:Option-->
                                                                  <label class="d-flex flex-stack cursor-pointer">
                                                                        <!--begin:Label-->
                                                                        <span class="d-flex align-items-center me-2">
															<!--begin:Icon-->
															<span class="symbol symbol-50px me-6">
																<span class="symbol-label bg-light-success">
																	<i class="ki-duotone ki-timer fs-1 text-success">
																		<span class="path1"></span>
																		<span class="path2"></span>
																		<span class="path3"></span>
																	</i>
																</span>
															</span>
                                                                              <!--end:Icon-->
                                                                              <!--begin:Info-->
															<span class="d-flex flex-column">
																<span class="fw-bold fs-6">Full Intro Training</span>
																<span class="fs-7 text-muted">Creating a clear text structure copywriting</span>
															</span>
                                                                              <!--end:Info-->
														</span>
                                                                        <!--end:Label-->
                                                                        <!--begin:Input-->
                                                                        <span class="form-check form-check-custom form-check-solid">
															<input class="form-check-input" type="radio" name="category" value="3" />
														</span>
                                                                        <!--end:Input-->
                                                                  </label>
                                                                  <!--end::Option-->
                                                            </div>
                                                            <!--end:Options-->
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
                                                            <!--begin::Label-->
                                                            <label class="d-flex align-items-center fs-5 fw-semibold mb-4">
                                                                  <span class="required">Select Framework</span>
                                                                  <span class="ms-1" data-bs-toggle="tooltip" title="Specify your apps framework">
														<i class="ki-duotone ki-information-5 text-gray-500 fs-6">
															<span class="path1"></span>
															<span class="path2"></span>
															<span class="path3"></span>
														</i>
													</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin:Option-->
                                                            <label class="d-flex flex-stack cursor-pointer mb-5">
                                                                  <!--begin:Label-->
                                                                  <span class="d-flex align-items-center me-2">
														<!--begin:Icon-->
														<span class="symbol symbol-50px me-6">
															<span class="symbol-label bg-light-warning">
																<i class="ki-duotone ki-html fs-2x text-warning">
																	<span class="path1"></span>
																	<span class="path2"></span>
																</i>
															</span>
														</span>
                                                                        <!--end:Icon-->
                                                                        <!--begin:Info-->
														<span class="d-flex flex-column">
															<span class="fw-bold fs-6">HTML5</span>
															<span class="fs-7 text-muted">Base Web Projec</span>
														</span>
                                                                        <!--end:Info-->
													</span>
                                                                  <!--end:Label-->
                                                                  <!--begin:Input-->
                                                                  <span class="form-check form-check-custom form-check-solid">
														<input class="form-check-input" type="radio" checked="checked" name="framework" value="1" />
													</span>
                                                                  <!--end:Input-->
                                                            </label>
                                                            <!--end::Option-->
                                                            <!--begin:Option-->
                                                            <label class="d-flex flex-stack cursor-pointer mb-5">
                                                                  <!--begin:Label-->
                                                                  <span class="d-flex align-items-center me-2">
														<!--begin:Icon-->
														<span class="symbol symbol-50px me-6">
															<span class="symbol-label bg-light-success">
																<i class="ki-duotone ki-react fs-2x text-success">
																	<span class="path1"></span>
																	<span class="path2"></span>
																</i>
															</span>
														</span>
                                                                        <!--end:Icon-->
                                                                        <!--begin:Info-->
														<span class="d-flex flex-column">
															<span class="fw-bold fs-6">ReactJS</span>
															<span class="fs-7 text-muted">Robust and flexible app framework</span>
														</span>
                                                                        <!--end:Info-->
													</span>
                                                                  <!--end:Label-->
                                                                  <!--begin:Input-->
                                                                  <span class="form-check form-check-custom form-check-solid">
														<input class="form-check-input" type="radio" name="framework" value="2" />
													</span>
                                                                  <!--end:Input-->
                                                            </label>
                                                            <!--end::Option-->
                                                            <!--begin:Option-->
                                                            <label class="d-flex flex-stack cursor-pointer mb-5">
                                                                  <!--begin:Label-->
                                                                  <span class="d-flex align-items-center me-2">
														<!--begin:Icon-->
														<span class="symbol symbol-50px me-6">
															<span class="symbol-label bg-light-danger">
																<i class="ki-duotone ki-angular fs-2x text-danger">
																	<span class="path1"></span>
																	<span class="path2"></span>
																	<span class="path3"></span>
																</i>
															</span>
														</span>
                                                                        <!--end:Icon-->
                                                                        <!--begin:Info-->
														<span class="d-flex flex-column">
															<span class="fw-bold fs-6">Angular</span>
															<span class="fs-7 text-muted">Powerful data mangement</span>
														</span>
                                                                        <!--end:Info-->
													</span>
                                                                  <!--end:Label-->
                                                                  <!--begin:Input-->
                                                                  <span class="form-check form-check-custom form-check-solid">
														<input class="form-check-input" type="radio" name="framework" value="3" />
													</span>
                                                                  <!--end:Input-->
                                                            </label>
                                                            <!--end::Option-->
                                                            <!--begin:Option-->
                                                            <label class="d-flex flex-stack cursor-pointer">
                                                                  <!--begin:Label-->
                                                                  <span class="d-flex align-items-center me-2">
														<!--begin:Icon-->
														<span class="symbol symbol-50px me-6">
															<span class="symbol-label bg-light-primary">
																<i class="ki-duotone ki-vue fs-2x text-primary">
																	<span class="path1"></span>
																	<span class="path2"></span>
																</i>
															</span>
														</span>
                                                                        <!--end:Icon-->
                                                                        <!--begin:Info-->
														<span class="d-flex flex-column">
															<span class="fw-bold fs-6">Vue</span>
															<span class="fs-7 text-muted">Lightweight and responsive framework</span>
														</span>
                                                                        <!--end:Info-->
													</span>
                                                                  <!--end:Label-->
                                                                  <!--begin:Input-->
                                                                  <span class="form-check form-check-custom form-check-solid">
														<input class="form-check-input" type="radio" name="framework" value="4" />
													</span>
                                                                  <!--end:Input-->
                                                            </label>
                                                            <!--end::Option-->
                                                      </div>
                                                      <!--end::Input group-->
                                                </div>
                                          </div>
                                          <!--end::Step 2-->
                                          <!--begin::Step 3-->
                                          <div data-kt-stepper-element="content">
                                                <div class="w-100">
                                                      <!--begin::Input group-->
                                                      <div class="fv-row mb-10">
                                                            <!--begin::Label-->
                                                            <label class="required fs-5 fw-semibold mb-2">Database Name</label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="text" class="form-control form-control-lg form-control-solid" name="dbname" placeholder="" value="master_db" />
                                                            <!--end::Input-->
                                                      </div>
                                                      <!--end::Input group-->
                                                      <!--begin::Input group-->
                                                      <div class="fv-row">
                                                            <!--begin::Label-->
                                                            <label class="d-flex align-items-center fs-5 fw-semibold mb-4">
                                                                  <span class="required">Select Database Engine</span>
                                                                  <span class="ms-1" data-bs-toggle="tooltip" title="Select your app database engine">
														<i class="ki-duotone ki-information-5 text-gray-500 fs-6">
															<span class="path1"></span>
															<span class="path2"></span>
															<span class="path3"></span>
														</i>
													</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin:Option-->
                                                            <label class="d-flex flex-stack cursor-pointer mb-5">
                                                                  <!--begin::Label-->
                                                                  <span class="d-flex align-items-center me-2">
														<!--begin::Icon-->
														<span class="symbol symbol-50px me-6">
															<span class="symbol-label bg-light-success">
																<i class="ki-duotone ki-note text-success fs-2x">
																	<span class="path1"></span>
																	<span class="path2"></span>
																</i>
															</span>
														</span>
                                                                        <!--end::Icon-->
                                                                        <!--begin::Info-->
														<span class="d-flex flex-column">
															<span class="fw-bold fs-6">MySQL</span>
															<span class="fs-7 text-muted">Basic MySQL database</span>
														</span>
                                                                        <!--end::Info-->
													</span>
                                                                  <!--end::Label-->
                                                                  <!--begin::Input-->
                                                                  <span class="form-check form-check-custom form-check-solid">
														<input class="form-check-input" type="radio" name="dbengine" checked="checked" value="1" />
													</span>
                                                                  <!--end::Input-->
                                                            </label>
                                                            <!--end::Option-->
                                                            <!--begin:Option-->
                                                            <label class="d-flex flex-stack cursor-pointer mb-5">
                                                                  <!--begin::Label-->
                                                                  <span class="d-flex align-items-center me-2">
														<!--begin::Icon-->
														<span class="symbol symbol-50px me-6">
															<span class="symbol-label bg-light-danger">
																<i class="ki-duotone ki-google text-danger fs-2x">
																	<span class="path1"></span>
																	<span class="path2"></span>
																</i>
															</span>
														</span>
                                                                        <!--end::Icon-->
                                                                        <!--begin::Info-->
														<span class="d-flex flex-column">
															<span class="fw-bold fs-6">Firebase</span>
															<span class="fs-7 text-muted">Google based app data management</span>
														</span>
                                                                        <!--end::Info-->
													</span>
                                                                  <!--end::Label-->
                                                                  <!--begin::Input-->
                                                                  <span class="form-check form-check-custom form-check-solid">
														<input class="form-check-input" type="radio" name="dbengine" value="2" />
													</span>
                                                                  <!--end::Input-->
                                                            </label>
                                                            <!--end::Option-->
                                                            <!--begin:Option-->
                                                            <label class="d-flex flex-stack cursor-pointer">
                                                                  <!--begin::Label-->
                                                                  <span class="d-flex align-items-center me-2">
														<!--begin::Icon-->
														<span class="symbol symbol-50px me-6">
															<span class="symbol-label bg-light-warning">
																<i class="ki-duotone ki-microsoft text-warning fs-2x">
																	<span class="path1"></span>
																	<span class="path2"></span>
																	<span class="path3"></span>
																	<span class="path4"></span>
																</i>
															</span>
														</span>
                                                                        <!--end::Icon-->
                                                                        <!--begin::Info-->
														<span class="d-flex flex-column">
															<span class="fw-bold fs-6">DynamoDB</span>
															<span class="fs-7 text-muted">Microsoft Fast NoSQL Database</span>
														</span>
                                                                        <!--end::Info-->
													</span>
                                                                  <!--end::Label-->
                                                                  <!--begin::Input-->
                                                                  <span class="form-check form-check-custom form-check-solid">
														<input class="form-check-input" type="radio" name="dbengine" value="3" />
													</span>
                                                                  <!--end::Input-->
                                                            </label>
                                                            <!--end::Option-->
                                                      </div>
                                                      <!--end::Input group-->
                                                </div>
                                          </div>
                                          <!--end::Step 3-->
                                          <!--begin::Step 4-->
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
                                                            <input type="text" class="form-control form-control-solid" placeholder="" name="card_name" value="Max Doe" />
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
                                                      <div class="row mb-10">
                                                            <!--begin::Col-->
                                                            <div class="col-md-8 fv-row">
                                                                  <!--begin::Label-->
                                                                  <label class="required fs-6 fw-semibold form-label mb-2">Expiration Date</label>
                                                                  <!--end::Label-->
                                                                  <!--begin::Row-->
                                                                  <div class="row fv-row">
                                                                        <!--begin::Col-->
                                                                        <div class="col-6">
                                                                              <select name="card_expiry_month" class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Month">
                                                                                    <option></option>
                                                                                    <option value="1">1</option>
                                                                                    <option value="2">2</option>
                                                                                    <option value="3">3</option>
                                                                                    <option value="4">4</option>
                                                                                    <option value="5">5</option>
                                                                                    <option value="6">6</option>
                                                                                    <option value="7">7</option>
                                                                                    <option value="8">8</option>
                                                                                    <option value="9">9</option>
                                                                                    <option value="10">10</option>
                                                                                    <option value="11">11</option>
                                                                                    <option value="12">12</option>
                                                                              </select>
                                                                        </div>
                                                                        <!--end::Col-->
                                                                        <!--begin::Col-->
                                                                        <div class="col-6">
                                                                              <select name="card_expiry_year" class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Year">
                                                                                    <option></option>
                                                                                    <option value="2024">2024</option>
                                                                                    <option value="2025">2025</option>
                                                                                    <option value="2026">2026</option>
                                                                                    <option value="2027">2027</option>
                                                                                    <option value="2028">2028</option>
                                                                                    <option value="2029">2029</option>
                                                                                    <option value="2030">2030</option>
                                                                                    <option value="2031">2031</option>
                                                                                    <option value="2032">2032</option>
                                                                                    <option value="2033">2033</option>
                                                                                    <option value="2034">2034</option>
                                                                              </select>
                                                                        </div>
                                                                        <!--end::Col-->
                                                                  </div>
                                                                  <!--end::Row-->
                                                            </div>
                                                            <!--end::Col-->
                                                            <!--begin::Col-->
                                                            <div class="col-md-4 fv-row">
                                                                  <!--begin::Label-->
                                                                  <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                                                                        <span class="required">CVV</span>
                                                                        <span class="ms-1" data-bs-toggle="tooltip" title="Enter a card CVV code">
															<i class="ki-duotone ki-information-5 text-gray-500 fs-6">
																<span class="path1"></span>
																<span class="path2"></span>
																<span class="path3"></span>
															</i>
														</span>
                                                                  </label>
                                                                  <!--end::Label-->
                                                                  <!--begin::Input wrapper-->
                                                                  <div class="position-relative">
                                                                        <!--begin::Input-->
                                                                        <input type="text" class="form-control form-control-solid" minlength="3" maxlength="4" placeholder="CVV" name="card_cvv" />
                                                                        <!--end::Input-->
                                                                        <!--begin::CVV icon-->
                                                                        <div class="position-absolute translate-middle-y top-50 end-0 me-3">
                                                                              <i class="ki-duotone ki-credit-cart fs-2hx">
                                                                                    <span class="path1"></span>
                                                                                    <span class="path2"></span>
                                                                              </i>
                                                                        </div>
                                                                        <!--end::CVV icon-->
                                                                  </div>
                                                                  <!--end::Input wrapper-->
                                                            </div>
                                                            <!--end::Col-->
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
                                                                  <input class="form-check-input" type="checkbox" value="1" checked="checked" />
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
                                                            <img src="assets/media/illustrations/sigma-1/9.png" alt="" class="mw-100 mh-300px" />
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
