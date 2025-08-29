<x-guest-lay>
      @php
            $img = $order->status != 0
                ? asset('assets/media/stock/paid.png')
                : asset('assets/media/stock/unpaid.png');
      @endphp
      <x-slot:title>
            Invoice
            </x-slot>
      <div class="container">
            <!--begin::Heading-->
            <div class="text-center mt-10">
                  <!--begin::Description-->
                  <div class="fs-5 text-muted fw-bold">
                        Please check your receipt and payment <br /> Transaction will be invalid after 24 hours
                  </div>
                  <!--end::Description-->
            </div>
            <!--end::Heading-->
            <div class="row p-10">
            <div class="col-lg-12" id="kt_wrapper">
                        <!--begin::Post-->
                        <div class="post d-flex flex-column-fluid" id="kt_receipt">
                              <!--begin::Container-->
                              <div id="kt_content_container" class="container-xxl">
                                    <!-- begin::Invoice 3-->
                                    <div class="card">
                                          <!-- begin::Body-->
                                          <div class="card-body py-20">
                                                <!-- begin::Wrapper-->
                                                <div class="mw-lg-950px mx-auto w-100">
                                                      <!-- begin::Header-->
                                                      <div class="d-flex justify-content-between flex-column flex-sm-row mb-19">
                                                            <h4 class="fw-bolder text-gray-800 fs-2qx pe-5 pb-7">RECEIPT</h4>

                                                            <div class="text-sm-end">
                                                                  <a href="#" class="d-block mw-150px ms-sm-auto">
                                                                        <img alt="Logo" src="{{ asset($img) }} " style="opacity: 50%"
                                                                             class="w-100" />
                                                                  </a>
                                                            </div>
                                                            <!--end::Logo-->
                                                            <div class="text-sm-end">
                                                                  <!--begin::Logo-->
                                                                  <a href="#" class="d-block mw-150px ms-sm-auto">
                                                                        <img alt="Logo" src="{{ asset('assets/media/svg/brand-logos/lloyds-of-london-logo.svg') }} "
                                                                             class="w-100" />
                                                                  </a>

                                                                  <!--end::Logo-->
                                                                  <!--begin::Text-->
                                                                  <div class="text-sm-end fw-semibold fs-4 text-muted mt-7">
                                                                        <div>{{ $user->address ?? 'address not defined'}}</div>
                                                                  </div>
                                                                  <!--end::Text-->
                                                            </div>
                                                      </div>
                                                      <!--end::Header-->
                                                      <!--begin::Body-->
                                                      <div class="pb-12">
                                                            <!--begin::Wrapper-->
                                                            <div class="d-flex flex-column gap-7 gap-md-10">
                                                                  <!--begin::Message-->
                                                                  <div class="fw-bold fs-2"> {{ $user->full_name }}
                                                                        <span class="fs-6">(
                                                                               {{ $user->email }} )</span>,
                                                                        <br />
                                                                        <span class="text-muted fs-5">Here are your order details. Completed your payment and check your email for confirmation payment.</span>
                                                                  </div>
                                                                  <!--begin::Message-->
                                                                  <!--begin::Separator-->
                                                                  <div class="separator"></div>
                                                                  <!--begin::Separator-->
                                                                  <!--begin::Order details-->
                                                                  <div class="d-flex flex-column flex-sm-row gap-7 gap-md-10 fw-bold">
                                                                        <div class="flex-root d-flex flex-column">
                                                                              <span class="text-muted">Order ID</span>
                                                                              <span class="fs-5">{{ $order->order_id }}</span>
                                                                        </div>
                                                                        <div class="flex-root d-flex flex-column">
                                                                              <span class="text-muted">Date</span>
                                                                              <span class="fs-5">{{ $order->created_at->format('d F Y') }}</span>
                                                                        </div>
                                                                        <div class="flex-root d-flex flex-column">
                                                                              <span class="text-muted">Invoice ID</span>
                                                                              <span class="fs-5">{{ $order->invoice_id }}</span>
                                                                        </div>
                                                                  </div>
                                                                  <!--end::Order details-->
                                                                  <!--begin::Billing & shipping-->
                                                                  <div class="d-flex flex-column flex-sm-row gap-7 gap-md-10 fw-bold">
                                                                        <div class="flex-root d-flex flex-column">
                                                                              <span class="text-muted">User Address</span>
                                                                              <span class="fs-6">{{ $user->address ?? 'address not defined' }},
                                                                                  <br />{{ $user->postal_code ?? 'postal code not defined' }},
                                                                                  <br />Indonesia</span>
                                                                        </div>
                                                                  </div>
                                                                  <!--end::Billing & shipping-->
                                                                  <!--begin:Order summary-->
                                                                  <div class="d-flex justify-content-between flex-column">
                                                                        <!--begin::Table-->
                                                                        <div class="table-responsive border-bottom mb-9">
                                                                              <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                                                                                    <thead>
                                                                                    <tr class="border-bottom fs-6 fw-bold text-muted">
                                                                                          <th class="min-w-175px pb-2">Products</th>
                                                                                          <th class="min-w-70px text-end pb-2">Group</th>
                                                                                          <th class="min-w-80px text-end pb-2">Contract</th>
                                                                                          <th class="min-w-100px text-end pb-2">Total</th>
                                                                                    </tr>
                                                                                    </thead>
                                                                                    <tbody class="fw-semibold text-gray-600">
                                                                                    <tr>
                                                                                          <td>
                                                                                                <div class="d-flex align-items-center">
                                                                                                      <!--begin::Thumbnail-->
                                                                                                      <a href="#"
                                                                                                         class="symbol symbol-50px">
                                                                                                <span class="symbol-label"
                                                                                                      style="background-image:url({{ $product->product_image ?? asset('assets/media/icons/duotune/ecommerce/ecm002.svg') }});"></span>
                                                                                                      </a>
                                                                                                      <!--end::Thumbnail-->
                                                                                                      <!--begin::Title-->
                                                                                                      <div class="ms-5">
                                                                                                            <div class="fw-bold">
                                                                                                                  {{ $product->product_name }}</div>
                                                                                                            <div class="fs-7 text-muted">Checkout Date:
                                                                                                                  {{ $order->created_at->format('d/m/Y') }}
                                                                                                            </div>
                                                                                                      </div>
                                                                                                      <!--end::Title-->
                                                                                                </div>
                                                                                          </td>
                                                                                          <td class="text-end">{{ $product->value }}</td>
                                                                                          <td class="text-end">{{ $task->task_contract }} | deadline: {{ $task->deadline }}</td>
                                                                                          <td class="text-end">Rp. {{number_format($product->price, 0, ',', '.') }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                          <td colspan="3" class="text-end">Transaction Fee</td>
                                                                                          <td class="text-end">Rp. 0.00</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                          <td colspan="3" class="text-end">Discount (0%)</td>
                                                                                          <td class="text-end">-</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                          <td colspan="3" class="fs-3 text-gray-900 fw-bold text-end">
                                                                                                Grand
                                                                                                Total</td>
                                                                                          <td class="text-gray-900 fs-3 fw-bolder text-end">Rp. {{number_format($product->price, 0, ',', '.') }}
                                                                                          </td>
                                                                                    </tr>
                                                                                    </tbody>
                                                                              </table>
                                                                        </div>
                                                                        <!--end::Table-->
                                                                  </div>
                                                                  <!--end:Order summary-->
                                                            </div>
                                                            <!--end::Wrapper-->
                                                      </div>
                                                      <!--end::Body-->
                                                      <!-- begin::Footer-->
                                                      <div class="d-flex flex-stack flex-wrap mt-lg-20 pt-13">
                                                            <!-- begin::Actions-->
                                                            <div class="my-1 me-5">
                                                                  <!-- begin::Pint-->
                                                                  <button type="button" class="btn btn-success my-1 me-12"
                                                                          onclick="window.print();">Print
                                                                        Receipt</button>
                                                                  <!-- end::Pint-->
                                                                  <!-- begin::Download-->
{{--                                                                  <a href="{{ route('download.receipt', ['id' => $order->order_id]) }}"--}}
{{--                                                                     class="btn btn-light-success my-1"--}}
{{--                                                                     id="kt_receipt_download">--}}
{{--                                                                        Download Receipt--}}
{{--                                                                  </a>--}}

                                                                  <!-- end::Download-->
                                                            </div>
                                                            <!-- end::Actions-->
                                                            <!-- begin::Action-->
                                                            <a  class="btn btn-primary my-1" id="receipt-confirm">Confirm</a>
                                                            <!-- end::Action-->
                                                      </div>
                                                      <!-- end::Footer-->
                                                </div>
                                                <!-- end::Wrapper-->
                                          </div>
                                          <!-- end::Body-->
                                    </div>
                                    <!-- end::Invoice 1-->
                              </div>
                              <!--end::Container-->
                        </div>
                        <!--end::Post-->
            </div>
            </div>
      </div>

      @include('template/footer')
      @push('scripts')
            <script src="{{ asset('assets/js/custom/receipt.js') }}"></script>
            <script>
                  document.addEventListener('DOMContentLoaded', function() {
                        const receipt = new KTReceipt({
                              landingRoute: "{{ route('landing') }}"
                        });
                        receipt.init();
                  });
            </script
                  @endpush

                  <!--end::Container-->
</x-guest-lay>
