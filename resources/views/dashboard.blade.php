@extends('layouts.app')

@section('content')
    @include('partials.dashboard_header', ['title' => 'Dashboard'])

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            {{-- Alert Messages --}}
            @include('partials.alert')
            @php
                $currency_sign = currency_sign();
            @endphp

            <!--begin::Row-->
            <div class="row gx-5 gx-xl-10">
                @include('partials.performance_overview', [
                    'compaigns' => $compaigns,
                    'total_raised' => $total_raised,
                    'total_withdraw' => $total_withdraw,
                    'stripe_withdraw' => $stripe_withdraw,
                    'paypal_withdraw' => $paypal_withdraw,
                    'stripe_donations' => $stripe_donations,
                    'paypal_donations' => $paypal_donations,
                    'stripe' => $stripe,
                ])

                @include('partials.statistics', [
                    'compaigns' => $compaigns,
                    'currency_sign' => $currency_sign,
                ])
            </div>
            <!--end::Row-->

            <!--begin::Row-->
            <div class="row gy-5 g-xl-10">
                {{-- @include('partials.compaigns_overview', [
                    'stripe_donations' => $stripe_donations,
                    'paypal_donations' => $paypal_donations,
                ]) --}}

                @include('partials.compains_percentage', ['compaigns' => $compaigns])

                @include('partials.compaigns', [
                    'compaigns' => $compaigns,
                    'currency_sign' => $currency_sign,
                ])

            </div>
            <!--end::Row-->

            <!--Withdraw model-->
            <div class="modal fade" tabindex="-1" id="withdrawl_modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 id="modal_title" class="modal-title">Modal title</h3>

                            <!--begin::Close-->
                            <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                                aria-label="Close">
                                <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span
                                        class="path2"></span></i>
                            </div>
                            <!--end::Close-->
                        </div>

                        <form id="withdraw_form" action="{{ route('withdraw') }}" method="post">
                            @csrf
                            <div class="modal-body">
                                <!--begin::Tabs-->
                                <div class="card-title mb-5 gap-4 gap-lg-10 gap-xl-15 nav nav-tabs border-bottom-0"
                                    data-kt-withdraw-type="tabs_nav">
                                    <div id="stripe_tab"
                                        class="fs-4 fw-bold pb-3 cursor-pointer border-bottom border-3 border-primary"
                                        data-kt-withdraw-type="tab" data-kt-withdraw-type-value="stripe">Stripe Withdraw
                                    </div>

                                    <div id="paypal_tab" class="fs-4 fw-bold pb-3 cursor-pointer text-muted"
                                        data-kt-withdraw-type="tab" data-kt-withdraw-type-value="paypal">Paypal Withdraw
                                    </div>
                                </div>
                                <!--end::Tabs-->

                                <input type="hidden" name="type" value="stripe">
                                <input type="hidden" id="compaign_id" name="compaign_id">
                                <input type="hidden" id="stripe_withdraw_limit" name="stripe_withdraw_limit">
                                <input type="hidden" id="paypal_withdraw_limit" name="paypal_withdraw_limit">

                                <div id="payout_id" class="d-none mb-4">
                                    <input type="text" name="payout_id" class="form-control"
                                        placeholder="Enter Paypal Payout Id" />
                                    <span class="text-primary d-block pt-1">Paypal transaction id of withdrawal amount for
                                        reference</span>
                                </div>

                                <div class="">
                                    <input type="text" id="withdraw_amount" name="withdraw_amount" class="form-control"
                                        placeholder="Enter withdraw amount" min="1" required />
                                    <span id="stripe_remaining_amount_notice" class="text-primary d-block pt-1"></span>
                                    <span id="paypal_remaining_amount_notice"
                                        class="text-primary d-block pt-1 d-none"></span>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Withdraw</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    @include('partials.js.performance-js', ['performance' => $performance])
    @include('partials.js.statistics-js', ['compaigns' => $compaigns])
    @include('partials.js.overview-js', [
        'compaigns' => $compaigns,
        'formatted_compaigns' => $formatted_compaigns,
    ])

    <script>
        let stripe_withdraw_limit = 0;
        let paypal_withdraw_limit = 0;
        const e = document.querySelector('[data-kt-withdraw-type="tabs_nav"]')
            .querySelectorAll('[data-kt-withdraw-type="tab"]');
        const a = ["border-bottom", "border-3", "border-primary"];

        e.forEach((l => {
            l.addEventListener("click", (r => {
                e.forEach((e => {
                    e.classList.remove(...a), e
                        .classList.add("text-muted")
                })), l.classList.remove("text-muted"), l.classList.add(...a);
                const tabValue = l.getAttribute("data-kt-withdraw-type-value");
                if (tabValue == "stripe") {
                    $('#withdraw_amount').attr('max', stripe_withdraw_limit);
                    $('#payout_id').addClass('d-none');
                    $("[name='payout_id']").attr('required', false);
                    $(`#stripe_remaining_amount_notice`).removeClass('d-none');
                    $(`#paypal_remaining_amount_notice`).addClass('d-none');
                } else {
                    $('#withdraw_amount').attr('max', paypal_withdraw_limit);
                    $('#payout_id').removeClass('d-none');
                    $("[name='payout_id']").attr('required', true);
                    $(`#stripe_remaining_amount_notice`).addClass('d-none');
                    $(`#paypal_remaining_amount_notice`).removeClass('d-none');
                }
                $("[name='type']").val(tabValue);
            }))
        }));

        function withdraw(compaign_id, compaign_name, stripe_limit, stripe_remaining_amount, paypal_limit,
            paypal_remaining_amount) {
            // reset withdraw type tabs
            $("[name='type']").val('stripe');
            $('#stripe_tab').removeClass().addClass(
                'fs-4 fw-bold pb-3 cursor-pointer border-bottom border-3 border-primary');
            $('#paypal_tab').removeClass().addClass('fs-4 fw-bold pb-3 cursor-pointer text-muted');
            $(`#stripe_remaining_amount_notice`).removeClass('d-none');
            $(`#paypal_remaining_amount_notice`).addClass('d-none');
            $('#payout_id').addClass('d-none');
            $("[name='payout_id']").attr('required', false);

            // setting values for withdraw modal
            $('#compaign_id').val(compaign_id);
            $("#stripe_withdraw_limit").val(stripe_limit);
            $("#paypal_withdraw_limit").val(paypal_limit);
            $('#modal_title').text(compaign_name);
            $('#stripe_remaining_amount_notice').text(`Remaining stripe balance to withdraw: ${stripe_remaining_amount}`);
            $('#paypal_remaining_amount_notice').text(`Remaining paypal balance to withdraw: ${paypal_remaining_amount}`);
            $('#withdraw_amount').attr('max', stripe_limit);
            stripe_withdraw_limit = stripe_limit;
            paypal_withdraw_limit = paypal_limit;
            $('#withdrawl_modal').modal('show');
        }

        function resetCompaign(compaign_id) {
            $('#reset_compaign_id').val(compaign_id);
            $('#reset_compaign_form').submit();
        }

        $('#withdraw_form').on('submit', function(event) {
            $('#withdrawl_modal').modal('hide');
            $(':button').prop('disabled', true);
        })
    </script>
@endpush
