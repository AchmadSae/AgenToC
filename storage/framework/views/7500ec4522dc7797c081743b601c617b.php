<?php if (isset($component)) { $__componentOriginal6ee4dac3943a34f4bd44f2de5be3a7d4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6ee4dac3943a34f4bd44f2de5be3a7d4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.guest-lay','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('guest-lay'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
       <?php $__env->slot('title', null, []); ?> 
            Reset Password
       <?php $__env->endSlot(); ?>

      <!--begin::Page bg image-->
      <style>body { background-image: url(<?php echo e(asset('assets/media/auth/bg10.jpeg')); ?>); } [data-bs-theme="dark"] body { background-image: url(<?php echo e(asset('assets/media/auth/bg10-dark.jpeg')); ?>); }</style>
      <!--end::Page bg image-->
      <!--begin::Authentication - New password -->
      <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <!--begin::Aside-->
            <div class="d-flex flex-lg-row-fluid">
                  <!--begin::Content-->
                  <div class="d-flex flex-column flex-center pb-0 pb-lg-10 p-10 w-100">
                        <!--begin::Image-->
                        <img class="theme-light-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20" src="assets/media/auth/agency.png" alt="" />
                        <img class="theme-dark-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20" src="assets/media/auth/agency-dark.png" alt="" />
                        <!--end::Image-->
                        <!--begin::Title-->
                        <h1 class="text-gray-800 fs-2qx fw-bold text-center mb-7">Fast, Efficient and Productive</h1>
                        <!--end::Title-->
                        <!--begin::Text-->
                        <div class="text-gray-600 fs-base text-center fw-semibold">In this kind of post,
                              <a href="#" class="opacity-75-hover text-primary me-1">the blogger</a>introduces a person they’ve interviewed
                              <br />and provides some background information about
                              <a href="#" class="opacity-75-hover text-primary me-1">the interviewee</a>and their
                              <br />work following this is a transcript of the interview.</div>
                        <!--end::Text-->
                  </div>
                  <!--end::Content-->
            </div>
            <!--begin::Aside-->
            <!--begin::Body-->
            <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
                  <!--begin::Wrapper-->
                  <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
                        <!--begin::Content-->
                        <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
                              <!--begin::Wrapper-->
                              <div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">
                                    <!--begin::Form-->
                                    <form class="form w-100" novalidate="novalidate" id="kt_new_password_form" data-kt-redirect-url="<?php echo e(route('sign-in')); ?>" action="<?php echo e(route('password-update', ['token', $token])); ?>">
                                          <!--begin::Heading-->
                                          <div class="text-center mb-10">
                                                <!--begin::Title-->
                                                <h1 class="text-gray-900 fw-bolder mb-3">Setup New Password</h1>
                                                <!--end::Title-->
                                                <!--begin::Link-->
                                                <div class="text-gray-500 fw-semibold fs-6">Have you already reset the password ?
                                                      <a href="<?php echo e(route('sign-in')); ?>" class="link-primary fw-bold">Sign in</a></div>
                                                <!--end::Link-->
                                          </div>
                                          <!--begin::Heading-->
                                          <!--begin::Input group-->
                                          <div class="fv-row mb-8" data-kt-password-meter="true">
                                                <!--begin::Wrapper-->
                                                <input name="token" type="text" class="hidden" value="<?php echo e($token); ?>">
                                                <div class="mb-1">
                                                      <!--begin::Input wrapper-->
                                                      <div class="position-relative mb-3">
                                                            <input class="form-control bg-transparent" type="password" placeholder="Password" name="password" autocomplete="off" />
                                                            <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
													<i class="ki-duotone ki-eye-slash fs-2"></i>
													<i class="ki-duotone ki-eye fs-2 d-none"></i>
												</span>
                                                      </div>
                                                      <!--end::Input wrapper-->
                                                      <!--begin::Meter-->
                                                      <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                                                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                                                      </div>
                                                      <!--end::Meter-->
                                                </div>
                                                <!--end::Wrapper-->
                                                <!--begin::Hint-->
                                                <div class="text-muted">Use 8 or more characters with a mix of letters, numbers & symbols.</div>
                                                <!--end::Hint-->
                                          </div>
                                          <!--end::Input group=-->
                                          <!--end::Input group=-->
                                          <div class="fv-row mb-8">
                                                <!--begin::Repeat Password-->
                                                <input type="password" placeholder="Repeat Password" name="confirm-password" autocomplete="off" class="form-control bg-transparent" />
                                                <!--end::Repeat Password-->
                                          </div>
                                          <!--end::Input group=-->
                                          <!--begin::Input group=-->
                                          <div class="fv-row mb-8">
                                                <label class="form-check form-check-inline">
                                                      <input class="form-check-input" type="checkbox" name="toc" value="1" />
                                                      <span class="form-check-label fw-semibold text-gray-700 fs-6 ms-1">I Agree &
											<a href="#" class="ms-1 link-primary">Terms and conditions</a>.</span>
                                                </label>
                                          </div>
                                          <!--end::Input group=-->
                                          <!--begin::Action-->
                                          <div class="d-grid mb-10">
                                                <button type="button" id="kt_new_password_submit" class="btn btn-primary">
                                                      <!--begin::Indicator label-->
                                                      <span class="indicator-label">Submit</span>
                                                      <!--end::Indicator label-->
                                                      <!--begin::Indicator progress-->
                                                      <span class="indicator-progress">Please wait...
											<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                      <!--end::Indicator progress-->
                                                </button>
                                          </div>
                                          <!--end::Action-->
                                    </form>
                                    <!--end::Form-->
                              </div>
                              <!--end::Wrapper-->
                              <!--begin::Footer-->
                              <div class="w-lg-500px d-flex flex-stack">
                                    <!--begin::Languages-->
                                    <div class="me-10">
                                          <!--begin::Toggle-->
                                          <button class="btn btn-flex btn-link btn-color-gray-700 btn-active-color-primary rotate fs-base" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-offset="0px, 0px">
                                                <img data-kt-element="current-lang-flag" class="w-20px h-20px rounded me-3" src="assets/media/flags/united-states.svg" alt="" />
                                                <span data-kt-element="current-lang-name" class="me-1">English</span>
                                                <i class="ki-duotone ki-down fs-5 text-muted rotate-180 m-0"></i>
                                          </button>
                                          <!--end::Toggle-->
                                          <!--begin::Menu-->
                                          <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-4 fs-7" data-kt-menu="true" id="kt_auth_lang_menu">
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                      <a href="#" class="menu-link d-flex px-5" data-kt-lang="English">
												<span class="symbol symbol-20px me-4">
													<img data-kt-element="lang-flag" class="rounded-1" src="assets/media/flags/united-states.svg" alt="" />
												</span>
                                                            <span data-kt-element="lang-name">English</span>
                                                      </a>
                                                </div>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                      <a href="#" class="menu-link d-flex px-5" data-kt-lang="Spanish">
												<span class="symbol symbol-20px me-4">
													<img data-kt-element="lang-flag" class="rounded-1" src="assets/media/flags/spain.svg" alt="" />
												</span>
                                                            <span data-kt-element="lang-name">Spanish</span>
                                                      </a>
                                                </div>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                      <a href="#" class="menu-link d-flex px-5" data-kt-lang="German">
												<span class="symbol symbol-20px me-4">
													<img data-kt-element="lang-flag" class="rounded-1" src="assets/media/flags/germany.svg" alt="" />
												</span>
                                                            <span data-kt-element="lang-name">German</span>
                                                      </a>
                                                </div>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                      <a href="#" class="menu-link d-flex px-5" data-kt-lang="Japanese">
												<span class="symbol symbol-20px me-4">
													<img data-kt-element="lang-flag" class="rounded-1" src="assets/media/flags/japan.svg" alt="" />
												</span>
                                                            <span data-kt-element="lang-name">Japanese</span>
                                                      </a>
                                                </div>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                      <a href="#" class="menu-link d-flex px-5" data-kt-lang="French">
												<span class="symbol symbol-20px me-4">
													<img data-kt-element="lang-flag" class="rounded-1" src="assets/media/flags/france.svg" alt="" />
												</span>
                                                            <span data-kt-element="lang-name">French</span>
                                                      </a>
                                                </div>
                                                <!--end::Menu item-->
                                          </div>
                                          <!--end::Menu-->
                                    </div>
                                    <!--end::Languages-->
                                    <!--begin::Links-->
                                    <div class="d-flex fw-semibold text-primary fs-base gap-5">
                                          <a href="pages/team.html" target="_blank">Terms</a>
                                          <a href="pages/pricing/column.html" target="_blank">Plans</a>
                                          <a href="pages/contact.html" target="_blank">Contact Us</a>
                                    </div>
                                    <!--end::Links-->
                              </div>
                              <!--end::Footer-->
                        </div>
                        <!--end::Content-->
                  </div>
                  <!--end::Wrapper-->
            </div>
            <!--end::Body-->
      </div>
      <!--end::Authentication - New password-->
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6ee4dac3943a34f4bd44f2de5be3a7d4)): ?>
<?php $attributes = $__attributesOriginal6ee4dac3943a34f4bd44f2de5be3a7d4; ?>
<?php unset($__attributesOriginal6ee4dac3943a34f4bd44f2de5be3a7d4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6ee4dac3943a34f4bd44f2de5be3a7d4)): ?>
<?php $component = $__componentOriginal6ee4dac3943a34f4bd44f2de5be3a7d4; ?>
<?php unset($__componentOriginal6ee4dac3943a34f4bd44f2de5be3a7d4); ?>
<?php endif; ?>
<?php /**PATH D:\development\CollaborateAgenToC\AgentC\resources\views/auth/password/form_reset_password_email.blade.php ENDPATH**/ ?>