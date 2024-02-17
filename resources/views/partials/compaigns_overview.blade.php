<div class="col-12 mb-5 mb-xl-10">
    <!--begin::Chart widget 36-->
    <div class="card card-flush overflow-hidden h-xl-100">
        <!--begin::Header-->
        <div class="card-header pt-5">
            <!--begin::Title-->
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold text-dark">Campaigns Overview</span>
            </h3>
            <!--end::Title-->
            <div class="d-flex flex-wrap px-9 mb-5">
                <!--begin::Stat-->
                <div class="rounded min-w-125px py-3 px-4 my-1 me-6" style="border: 1px dashed rgba(202, 57, 57, 0.15)">
                    <!--begin::Number-->
                    <div class="text-center">
                        <div class="text-black fs-2 fw-bold" data-kt-countup="true"
                            data-kt-countup-value="{{ $stripe_donations }}" data-kt-countup-prefix="$">
                            {{ $stripe_donations }}
                        </div>
                    </div>
                    <!--end::Number-->
                    <!--begin::Label-->
                    <div class="fw-semibold fs-6 text-black opacity-50">Stripe Donations</div>
                    <!--end::Label-->
                </div>
                <!--end::Stat-->
                <!--begin::Stat-->
                <div class="rounded min-w-125px py-3 px-4 my-1" style="border: 1px dashed rgba(202, 57, 57, 0.15)">
                    <!--begin::Number-->
                    <div class="d-flex align-items-center">
                        <div class="text-black fs-2 fw-bold" data-kt-countup="true"
                            data-kt-countup-value="{{ $paypal_donations }}" data-kt-countup-prefix="$">
                            {{ $paypal_donations }}
                        </div>
                    </div>
                    <!--end::Number-->
                    <!--begin::Label-->
                    <div class="fw-semibold fs-6 text-black opacity-50">Paypal Donations</div>
                    <!--end::Label-->
                </div>
                <!--end::Stat-->
            </div>
        </div>
        <!--end::Header-->
        <!--begin::Card body-->
        <div class="card-body d-flex align-items-end p-0">

            <!--begin::Chart-->
            <div id="compaigns_overview_chart" class="min-h-auto w-100 ps-4 pe-6" style="height: 500px"></div>
            <!--end::Chart-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Chart widget 36-->
</div>
