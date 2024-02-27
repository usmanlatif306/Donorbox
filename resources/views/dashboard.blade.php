@extends('layouts.app')

@section('content')
    @include('partials.dashboard_header', ['title' => 'Dashboard'])

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            {{-- Alert Messages --}}
            @include('partials.alert')

            <!--begin::Row-->
            <div class="row gx-5 gx-xl-10">
                @include('partials.performance_overview', [
                    'compaigns' => $compaigns,
                    'total_raised' => $total_raised,
                    'total_withdraw' => $total_withdraw,
                    'stripe_donations' => $stripe_donations,
                    'paypal_donations' => $paypal_donations,
                    'stripe' => $stripe,
                ])

                @include('partials.statistics', [
                    'compaigns' => $compaigns,
                    'currency_sign' => currency_sign(),
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
                    'currency_sign' => currency_sign(),
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

                        <form action="{{ route('withdraw') }}" method="post">
                            @csrf
                            <div class="modal-body">
                                <input type="hidden" id="compaign_id" name="compaign_id">
                                <input type="number" id="withdraw_amount" name="withdraw_amount" class="form-control"
                                    placeholder="Enter withdraw amount" required />
                                <span id="remaining_amount_notice" class="text-primary d-block pt-1"></span>

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
        function withdraw(compaign_id, compaign_name, limit, remaining_amount) {
            $('#compaign_id').val(compaign_id);
            $('#modal_title').text(compaign_name);
            $('#remaining_amount_notice').text(`Remaining balance to withdraw: ${remaining_amount}`);
            $('#withdraw_amount').attr('max', limit);
            $('#withdrawl_modal').modal('show');
        }
    </script>
@endpush
