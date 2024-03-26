<div class="col-12 mb-5 mb-xl-10">
    <!--begin::Row-->
    <div class="row g-lg-5 g-xl-10">
        @foreach ($compaigns as $item)
            <!--begin::Col-->
            {{-- <div class="{{ !$loop->last ? 'col-md-6 col-xl-6' : 'col-12' }}"> --}}
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-body d-flex justify-content-between flex-column px-0 pb-0">
                        <div class="mb-4 px-9">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="d-flex align-items-center justify-content-between gap-5 flex-1 w-100 pe-4">
                                    <div class="d-flex align-items-center" title="Raised Donations Without Tax">
                                        <span
                                            class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">{{ formatted_number($item['total_raised']) }}</span>
                                        <span
                                            class="d-flex align-items-end text-gray-400 fs-6 fw-semibold">{{ $currency_sign }}</span>
                                    </div>
                                    <div class="d-flex align-items-center" title="Raised Donations With Tax">
                                        <span
                                            class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">{{ formatted_number($item['total_raised_with_tax']) }}</span>
                                        <span
                                            class="d-flex align-items-end text-gray-400 fs-6 fw-semibold">{{ $currency_sign }}</span>
                                    </div>
                                    <div class="d-flex flex-column gap-3">
                                        <div class="d-flex align-items-center" title="Stripe Withdraw">
                                            <span
                                                class="fs-2 fw-bold text-gray-800 me-2 lh-1 ls-n2">{{ formatted_number($item['stripe_withdraw']) }}</span>
                                            <span
                                                class="d-flex align-items-end text-gray-400 fs-6 fw-semibold">{{ $currency_sign }}</span>
                                        </div>
                                        <div class="d-flex align-items-center" title="Paypal Withdraw">
                                            <span
                                                class="fs-2 fw-bold text-gray-800 me-2 lh-1 ls-n2">{{ formatted_number($item['paypal_withdraw']) }}</span>
                                            <span
                                                class="d-flex align-items-end text-gray-400 fs-6 fw-semibold">{{ $currency_sign }}</span>
                                        </div>

                                    </div>
                                </div>
                                <div class="d-flex flex-column gap-3">
                                    <button class="btn btn-sm btn-light-primary"
                                        onclick="resetCompaign('{{ $item['compaign']->id }}')" title="Reset Campaign"
                                        {{ $item['total_raised'] == 0 ? 'disabled' : '' }}>Reset</button>
                                    <button class="btn btn-sm btn-light-primary"
                                        onclick="withdraw('{{ $item['compaign']->id }}','{{ $item['compaign']->name }}',{{ $item['stripe_withdraw_limit'] }},'{{ $currency_sign . $item['stripe_withdraw_limit'] }}',{{ $item['paypal_withdraw_limit'] }},'{{ $currency_sign . $item['paypal_withdraw_limit'] }}')"
                                        {{ !$item['can_withdraw'] ? 'disabled' : '' }}
                                        title="{{ $item['can_withdraw'] ? 'Withdraw to bank account using stripe' : 'You cannot withdraw because your remaining withdraw limit is either 0 or you donation is raised using paypal. Withdraw only support through stripe.' }}">Withdraw</button>
                                </div>
                            </div>
                            <span class="fs-6 fw-semibold text-gray-400">{{ $item['compaign']->name }}</span>
                        </div>
                        <div id="kt_card_compaign_{{ $item['compaign']->id }}_chart" class="min-h-auto"
                            style="height: 125px"></div>
                    </div>
                </div>
            </div>
            <!--end::Col-->
        @endforeach
    </div>
    <!--end::Row-->

    <form id="reset_compaign_form" action="{{ route('compaigns.reset') }}" method="post">
        @csrf
        <input type="hidden" id="reset_compaign_id" name="compaign_id">
    </form>
</div>
