<div class="col-12 mb-5 mb-xl-10">
    <div class="card card-flush h-xl-100">
        <!--begin::Heading-->
        <div class="card-header rounded bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start h-250px top-grean-bg"
            data-bs-theme="light">
            <!--begin::Title-->
            <h3 class="card-title align-items-start flex-column text-white pt-15">
                <span class="fw-bold fs-2x mb-3">Performance Overview</span>
            </h3>
            <!--end::Title-->
        </div>
        <!--end::Heading-->
        <!--begin::Body-->
        <div class="card-body mt-n20">
            <!--begin::Stats-->
            <div class="mt-n20 position-relative">
                <!--begin::Row-->
                <div class="row g-3 g-lg-6">
                    <!--begin::Col-->
                    <div class="col-6">
                        <!--begin::Items-->
                        <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-30px me-5 mb-8">
                                <span class="symbol-label">
                                    <i class="fas fa-map-marked fs-1 text-primary">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                            </div>
                            <!--end::Symbol-->
                            <!--begin::Stats-->
                            <div class="m-0 d-flex align-items-center justify-content-between">
                                <div class="">
                                    <span
                                        class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{ count($compaigns) }}</span>
                                    <span class="text-gray-500 fw-semibold fs-6">Campaigns</span>
                                </div>

                                <div class="">
                                    <span
                                        class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{ currency_sign() }}{{ formatted_number($total_raised) }}</span>
                                    <span class="text-gray-500 fw-semibold fs-6">Total Donations</span>
                                </div>
                            </div>
                            <!--end::Stats-->
                        </div>
                        <!--end::Items-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-6">
                        <!--begin::Items-->
                        <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-30px me-5 mb-8">
                                <span class="symbol-label">
                                    <i class="fas fa-hand-holding-usd fs-1 text-primary">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                            </div>
                            <!--end::Symbol-->
                            <!--begin::Stats-->
                            <div class="m-0 d-flex align-items-center justify-content-between">
                                <div class="text-center">
                                    <span
                                        class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{ currency_sign() }}{{ formatted_number($total_withdraw) }}</span>
                                    <span class="text-gray-500 fw-semibold fs-6">Total Withdraw</span>
                                </div>
                                <div class="text-center">
                                    <span
                                        class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{ currency_sign() }}{{ formatted_number($stripe_withdraw) }}</span>
                                    <span class="text-gray-500 fw-semibold fs-6">Stripe Withdraw</span>
                                </div>

                            </div>
                            <!--end::Stats-->
                        </div>
                        <!--end::Items-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-6">
                        <!--begin::Items-->
                        <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-30px me-5 mb-8">
                                <span class="symbol-label">
                                    <i class="fab fa-stripe-s fs-1 text-primary">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                </span>
                            </div>
                            <!--end::Symbol-->
                            <!--begin::Stats-->
                            <div class="m-0 d-flex align-items-center justify-content-between">
                                <div class="">
                                    <span
                                        class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{ currency_sign() }}{{ formatted_number($stripe_donations) }}</span>
                                    <span class="text-gray-500 fw-semibold fs-6">Stripe Donations</span>
                                </div>
                                <div class="text-center">
                                    <span
                                        class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{ currency_sign($stripe['currency']) }}{{ formatted_number($stripe['amount']) }}</span>
                                    <span class="text-gray-500 fw-semibold fs-6">Stripe Available Balance</span>
                                </div>
                            </div>
                            <!--end::Stats-->
                        </div>
                        <!--end::Items-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-6">
                        <!--begin::Items-->
                        <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-30px me-5 mb-8">
                                <span class="symbol-label">
                                    <i class="fab fa-paypal fs-1 text-primary">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                </span>
                            </div>
                            <!--end::Symbol-->
                            <!--begin::Stats-->
                            <div class="m-0 d-flex align-items-center justify-content-between">
                                <div class="">
                                    <span
                                        class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{ currency_sign() }}{{ formatted_number($paypal_donations) }}</span>
                                    <span class="text-gray-500 fw-semibold fs-6">Paypal Donations</span>
                                </div>

                                <div class="text-center">
                                    <span
                                        class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{ currency_sign() }}{{ formatted_number($paypal_withdraw) }}</span>
                                    <span class="text-gray-500 fw-semibold fs-6">Paypal Withdraw</span>
                                </div>
                            </div>
                            <!--end::Stats-->
                        </div>
                        <!--end::Items-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->
            </div>
            <!--end::Stats-->
        </div>
        <!--end::Body-->
    </div>
</div>
