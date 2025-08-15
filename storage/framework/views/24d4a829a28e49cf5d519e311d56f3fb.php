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
                          <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="nav-item">
                                      <a class="nav-link text-gray-500 text-active-primary px-3 px-lg-6 active" href="#"
                                         data-bs-toggle="tab" data-bs-target="#kt_landing_<?php echo e($product->product_group_code); ?>">
                                           <?php echo e($product->productGroup->value); ?>

                                      </a>
                                </li>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <!--end::Tabs-->
                </div>
                <!--end::Tabs wrapper-->
                <!--begin::Tabs content cards product-->
                <div class="tab-content">
                    <!--begin::Tab pane-->
                      <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="tab-pane fade show active" id="kt_landing_<?php echo e($product->product_group_code); ?>">
                                  <!--begin::Row-->
                                  <div class="row g-10 ">
                                        <div class="col-lg-4">
                                                    <div class="d-flex h-100 align-items-center">
                                                          <!--begin::Option-->
                                                          <div class="w-100 d-flex flex-column flex-center rounded-3 bg-body py-15 px-10">
                                                                <!--begin::Heading-->
                                                                <div class="mb-7 text-center">
                                                                      <!--begin::Title-->
                                                                      <h1 class="text-gray-900 mb-5 fw-boldest"><?php echo e($product->product_name); ?></h1>
                                                                      <!--end::Title-->
                                                                      <!--begin::Description-->
                                                                      <div class="text-gray-500 fw-semibold mb-5">
                                                                            Best Settings for Startups
                                                                      </div>
                                                                      <!--end::Description-->
                                                                      <!--begin::Price-->
                                                                      <div class="text-center">
                                                                            <span class="mb-2 text-primary">Rp</span>
                                                                            <span class="fs-3x fw-bold text-primary" data-kt-plan-price-month="<?php echo e(number_format($product->price, 0, ',', '.')); ?>"
                                                                                  data-kt-plan-price-annual="<?php echo e(number_format($product->price, 0, ',', '.')); ?>"><?php echo e(number_format($product->price, 0, ',', '.')); ?></span>
                                                                            <span class="fs-7 fw-semibold opacity-50"
                                                                                  data-kt-plan-price-month="/ item" data-kt-plan-price-annual="/ Ann">/item</span>
                                                                      </div>
                                                                      <!--end::Price-->
                                                                </div>
                                                                <!--end::Heading-->
                                                                <!--begin::Features-->
                                                                <div class="w-100 mb-5">
                                                                      <!--begin::Item-->
                                                                      <?php $__currentLoopData = preg_split('/\.\s*/', $product->product_description, -1, PREG_SPLIT_NO_EMPTY); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $point): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <div class="d-flex flex-stack mb-5">
                                                                                  <span class="fw-semibold fs-6 text-gray-800 text-start pe-3"><?php echo e($point); ?></span>
                                                                                  <i class="ki-duotone ki-check-circle fs-1 text-success">
                                                                                        <span class="path1"></span>
                                                                                        <span class="path2"></span>
                                                                                  </i>
                                                                            </div>
                                                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                      <!--end::Item-->
                                                                </div>
                                                                <!--end::Features-->
                                                                <!--begin::Select-->
                                                                <a href="#" class="btn btn-primary"
                                                                   data-product-code="<?php echo e($product->product_code); ?>"
                                                                   data-product-name="<?php echo e($product->product_name); ?>"
                                                                   data-product-price="<?php echo e($product->price); ?>"
                                                                   data-product-description="<?php echo e($product->product_description); ?>"
                                                                   data-product-group-name="<?php echo e($product->productGroup->value); ?>"
                                                                   data-product-image="<?php echo e($product->product_image); ?>"
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
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<!--begin::Modal - New Address-->
<div class="modal fade" id="kt_modal_checkout" tabindex="-1" aria-hidden="true">
      <!--begin::Modal dialog-->
      <div class="modal-dialog modal-dialog-centered mw-700px">
            <!--begin::Modal content-->
            <div class="modal-content">
                  <!--begin::Form-->
                  <form class="form" method="POST" action="<?php echo e(route('checkout')); ?>" id="kt_modal_checkout_form">
                        <?php echo csrf_field(); ?>
                        <!--begin::Modal header-->
                        <div class="modal-header" id="kt_modal_checkout_header">
                              <!--begin::Modal title-->
                              <h4  class="fw-bold text-dark">Checkout <span id="kt_modal_checkout_title"></span> </>
                              <!--end::Modal title-->
                              <!--begin::Close-->
                              <div class="btn btn-sm btn-icon btn-active-color-primary" id="kt_modal_checkout_close">
                                    <i class="ki-duotone ki-cross fs-1">
                                          <span class="path1"></span>
                                          <span class="path2"></span>
                                    </i>
                              </div>
                              <!--end::Close-->
                        </div>
                        <!--end::Modal header-->
                        <!--begin::Modal body-->
                        <div class="modal-body py-10 px-lg-17">
                              <!--begin::Scroll-->
                              <div class="scroll-y ps-7  pe-7" id="kt_modal_checkout_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_checkout_header" data-kt-scroll-wrappers="#kt_modal_checkout_scroll" data-kt-scroll-offset="300px">
                                    <!--begin::Input group-->
                                    <div class="row mb-5">
                                          <!--begin::Col-->
                                          <div class="col-md-12 fv-row">
                                                <!--begin::Label-->
                                                <label class="required fs-5 fw-semibold mb-2">Title</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="text" class="form-control form-control-solid" placeholder="" name="title" />
                                                <!--end::Input-->
                                          </div>
                                          <!--end::Col-->
                                          <!--end::Input-->
                                          <!--begin::hidden input-->
                                          <input id="kt_modal_checkout_product_code" type="hidden" name="product_code" data-field="product_code" value="" />
                                          <!--end::hidden input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="row mb-5">
                                          <!--begin::Col-->
                                          <div class="col-md-6 fv-row">
                                                <!--begin::Label-->
                                                <label class="required fs-5 fw-semibold mb-2">Email</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="email" class="form-control form-control-solid" placeholder="" name="email" />
                                                <!--end::Input-->
                                          </div>
                                          <!--end::Col-->
                                          <!--begin::Col-->
                                          <div class="col-md-6 fv-row">
                                                <!--end::Label-->
                                                <label class="required fs-5 fw-semibold mb-2">Due date</label>
                                                <!--end::Label-->
                                                <!--begin::Datepicker-->
                                                <input type="datetime-local" 
                                                       class="form-control form-control-solid ps-12" 
                                                       placeholder="Select a date and time" 
                                                       name="due_date" 
                                                       min="<?php echo e(now()->format('Y-m-d\TH:i')); ?>"
                                                       step="300" 
                                                       required />
                                                <!--end::Datepicker-->
                                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                                <small class="text-muted">Please select a future date and time</small>
                                          </div>
                                          <!--end::Col-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="row mb-5">
                                          <!--begin::Label-->
                                          <!--begin::Label-->
                                          <label class="required fs-5 fw-semibold mb-2">Descriptions</label>
                                          <!--end::Label-->
                                          <textarea class="form-control form-control-solid" rows="3" name="description" placeholder="Tell us more about your plan project"></textarea>
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="row mb-5">
                                          <!--begin::Dropzone-->
                                          <div class="dropzone" id="kt_modal_checkout_files_upload">
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
                                                            <h3 class="dfs-3 fw-bold text-gray-900 mb-1">Drop campaign files here or click to upload.</h3>
                                                            <span class="fw-semibold fs-4 text-muted">Upload up to 10 files</span>
                                                      </div>
                                                      <!--end::Info-->
                                                </div>
                                          </div>
                                          <div class="mb-10">
                                                <!--begin::Label-->
                                                <label class="fs-6 fw-semibold mt-4">Uploaded File</label>
                                                <!--End::Label-->
                                                <!--begin::Files-->
                                                <div class="mh-300px scroll-y me-n7 pe-7" id="kt_modal_uploaded_list">
                                                      <!--begin::File-->
                                                      <div class="d-flex flex-stack py-4 border border-top-0 border-left-0 border-right-0 border-dashed">
                                                      </div>
                                                      <!--end::File-->
                                                </div>
                                                <!--end::Files-->
                                          </div>
                                          <!--end::Dropzone-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <!--begin::Col-->
                                    <div class="row mb-5">
                                          <div class="col-md-12 fv-row">
                                                <!--begin::Label-->
                                                <label class="required fs-5 fw-semibold mb-2">Name in Card</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="text" class="form-control form-control-solid" placeholder="" name="name" />
                                                <!--end::Input-->
                                          </div>
                                    </div>
                                    <!--end::Col-->
                                    <div class="d-flex flex-column mb-5 fv-row">
                                          <!--begin::Label-->
                                          <label class="required fs-6 fw-semibold form-label mb-2">Card Number For Payment Confirmation</label>
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
                                    <div class="fv-row mb-5">
                                          <!--begin::Wrapper-->
                                          <div class="d-flex flex-stack">
                                                <!--begin::Label-->
                                                <div class="me-5">
                                                      <!--begin::Label-->
                                                      <label class="fs-5 fw-semibold">Use as a billing adderess?</label>
                                                      <!--end::Label-->
                                                      <!--begin::Input-->
                                                      <div class="fs-7 fw-semibold text-muted">If you need more info, please check budget planning</div>
                                                      <!--end::Input-->
                                                </div>
                                                <!--end::Label-->
                                                <!--begin::Switch-->
                                                <label class="form-check form-switch form-check-custom form-check-solid">
                                                      <!--begin::Input-->
                                                      <input class="form-check-input" name="isSavedCardNumber" type="checkbox" value="1" checked="checked" />
                                                      <!--end::Input-->
                                                      <!--begin::Label-->
                                                      <span class="form-check-label fw-semibold text-muted">Yes</span>
                                                      <!--end::Label-->
                                                </label>
                                                <!--end::Switch-->
                                          </div>
                                          <!--begin::Wrapper-->
                                    </div>
                                    <!--end::Input group-->
                              </div>
                              <!--end::Scroll-->
                        </div>
                        <!--end::Modal body-->
                        <!--begin::Modal footer-->
                        <div class="modal-footer flex-center">
                              <!--begin::Button-->
                              <button type="reset" id="kt_modal_checkout_cancel" class="btn btn-light me-3">Discard</button>
                              <!--end::Button-->
                              <!--begin::Button-->
                              <button type="submit" id="kt_modal_checkout_submit" class="btn btn-primary">
                                    <span class="indicator-label">Submit</span>
                                    <span class="indicator-progress">Please wait...
								<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                              </button>
                              <!--end::Button-->
                        </div>
                        <!--end::Modal footer-->
                  </form>
                  <!--end::Form-->
            </div>
      </div>
</div>
<!--end::Modal - New Address-->
<?php $__env->startPush('scripts'); ?>
      <script src="<?php echo e(asset('assets/js/custom/utilities/modals/checkout-product.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php /**PATH E:\iseng\AgenToC\resources\views/landing/products.blade.php ENDPATH**/ ?>