<div class="card card-flush">
    <div class="card-header pt-7">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold text-gray-800">Payouts</span>
        </h3>
        <div class="card-toolbar">
            {{-- <button wire:click="changePayoutType('all')"
                class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light fw-bold px-4 me-1 {{ $payout_type === 'all' ? 'active' : '' }}">All</button> --}}
            <button wire:click="changePayoutType('stripe')"
                class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light fw-bold px-4 me-1 {{ $payout_type === 'stripe' ? 'active' : '' }}">Stripe</button>
            <button wire:click="changePayoutType('paypal')"
                class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light fw-bold px-4 me-1 {{ $payout_type === 'paypal' ? 'active' : '' }}">Paypal</button>
        </div>

        <div class="card-toolbar">
            <button wire:click="changeType('all')"
                class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light fw-bold px-4 me-1 {{ $type === 'all' ? 'active' : '' }}">All</button>
            <button wire:click="changeType('week')"
                class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light fw-bold px-4 me-1 {{ $type === 'week' ? 'active' : '' }}">Week</button>
            <button wire:click="changeType('month')"
                class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light fw-bold px-4 me-1 {{ $type === 'month' ? 'active' : '' }}">Month</button>
        </div>

    </div>
    <div class="card-body">
        <!--begin::Search-->
        <div class="d-flex align-items-center position-relative my-1">
            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
            <input type="search" wire:model.live="search" class="form-control form-control-solid w-250px ps-13"
                placeholder="{{ __('Search payout') }}" />
        </div>
        <!--end::Search-->

        <div class="table-responsive pt-10">
            <table class="table table-row-dashed align-middle gs-0 gy-3 my-0">
                <thead>
                    <tr class="fs-7 fw-bold text-gray-400 border-bottom-0">
                        <th class="pb-3 min-w-50px text-start">No</th>
                        <th class="pb-3 min-w-150px">Compaign</th>
                        <th class="pb-3 min-w-100px text-center">Amount</th>
                        <th class="pb-3 min-w-100px text-center">Payout ID</th>
                        <th class="pb-3 min-w-100px text-center">Status</th>
                        @if ($payout_type === 'stripe')
                            <th class="pb-3 min-w-100px text-center">Type</th>
                            <th class="pb-3 min-w-100px text-center">Arrival Date</th>
                        @endif

                        <th class="pb-3 min-w-100px text-center">Created</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($payouts as $payout)
                        <tr>
                            <th>{{ ($payouts->currentpage() - 1) * $payouts->perpage() + $loop->index + 1 }}</th>
                            <td>{{ $payout->compaign?->name }}</td>
                            <td class="text-center">
                                {{ currency_sign($payout->currency) }}{{ formatted_number($payout->amount) }}</td>
                            <td class="text-center">{{ $payout->payout_id }}</td>
                            <td class="text-capitalize text-center">{{ $payout->status }}</td>
                            @if ($payout_type === 'stripe')
                                <td class="text-capitalize text-center">{{ str_replace('_', ' ', $payout->type) }}</td>
                                <td class="text-capitalize text-center">{{ $payout->arrival_date->format('d M y') }}
                                </td>
                            @endif
                            <td class="text-center">{{ $payout->created_at->format('d M y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $payout_type === 'stripe' ? '8' : '6' }}">No payout</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-10">
                {{ $payouts->links() }}
            </div>
        </div>
    </div>
</div>
