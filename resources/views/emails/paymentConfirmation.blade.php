<x-guest-lay>
      <x-slot:title>
            Payment Email
      </x-slot:title>
      @php
        $logo = $ordersData['status'] != 0
            ? asset('assets/media/email/icon-positive-vote-4.svg')
            : asset('assets/media/stock/unpaid.png');
      @endphp
      <div style="text-align:center; margin:0 60px 34px 60px">
            <!--begin:Logo-->
            <div style="margin-bottom: 10px">
                  <a href="https://keenthemes.com" rel="noopener" target="_blank">
                        <img alt="Logo" src="assets/media/email/logo-1.svg" style="height: 35px">
                  </a>
            </div>
            <!--end:Logo-->
            <!--begin:Media-->
            <div style="margin-bottom: 15px">
                  <img alt="Logo" src="{{ asset($logo) }} ">
            </div>
            <!--end:Media-->
            <!--begin:Text-->
            <div style="font-size: 14px; font-weight: 500; margin-bottom: 42px; font-family:Arial,Helvetica,sans-serif">
                  <p style="margin-bottom:9px; color:#181C32; font-size: 22px; font-weight:700">Premium account is set!</p>
                  <p style="margin-bottom:2px; color:#7E8299">Lots of people make mistakes while creating</p>
                  <p style="margin-bottom:2px; color:#7E8299">paragraphs. Some writers just put whitespace in</p>
                  <p style="margin-bottom:2px; color:#7E8299">their text in random places</p>
            </div>
            <!--end:Text-->
            <!--begin:Order-->
            <div style="margin-bottom: 15px">
                  <!--begin:Title-->
                  <h3 style="text-align:left; color:#181C32; font-size: 18px; font-weight:600; margin-bottom: 22px">Order summary</h3>
                  <!--end:Title-->
                  <!--begin:Items-->
                  <div style="padding-bottom:9px">
                        <!--begin:Item-->
                        <div style="display:flex; justify-content: space-between; color:#7E8299; font-size: 14px; font-weight:500; margin-bottom:8px">
                              <!--begin:Description-->
                              <div style="font-family:Arial,Helvetica,sans-serif">Business - Monthly invoice</div>
                              <!--end:Description-->
                              <!--begin:Total-->
                              <div style="font-family:Arial,Helvetica,sans-serif">$120,00</div>
                              <!--end:Total-->
                        </div>
                        <!--end:Item-->
                        <!--begin:Item-->
                        <div style="display:flex; justify-content: space-between; color:#7E8299; font-size: 14px; font-weight:500;">
                              <!--begin:Description-->
                              <div style="font-family:Arial,Helvetica,sans-serif">VAT (25%)</div>
                              <!--end:Description-->
                              <!--begin:Total-->
                              <div style="font-family:Arial,Helvetica,sans-serif">$30,00</div>
                              <!--end:Total-->
                        </div>
                        <!--end:Item-->
                        <!--begin::Separator-->
                        <div class="separator separator-dashed" style="margin:15px 0"></div>
                        <!--end::Separator-->
                        <!--begin:Item-->
                        <div style="display:flex; justify-content: space-between; color:#7E8299; font-size: 14px; font-weight:500">
                              <!--begin:Description-->
                              <div style="font-family:Arial,Helvetica,sans-serif">Total paid</div>
                              <!--end:Description-->
                              <!--begin:Total-->
                              <div style="color:#50cd89; font-weight:700; font-family:Arial,Helvetica,sans-serif">$150,00</div>
                              <!--end:Total-->
                        </div>
                        <!--end:Item-->
                  </div>
                  <!--end:Items-->
            </div>
            <!--end:Order-->
            <!--begin:Action-->
            <a href="apps/invoices/view/invoice-1.html" target="_blank" style="background-color:#50cd89; border-radius:6px;display:inline-block; padding:11px 19px; color: #FFFFFF; font-size: 14px; font-weight:500;">Download Invoice</a>
            <!--begin:Action-->
      </div>


</x-guest-lay>
