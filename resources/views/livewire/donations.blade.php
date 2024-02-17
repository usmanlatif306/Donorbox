<div class="card card-flush">
    <div class="card-header pt-7">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold text-gray-800">All Donations</span>
        </h3>
        <div class="card-toolbar">
            <button wire:click="changeDonationType('all')"
                class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light fw-bold px-4 me-1 {{ $donation_type === 'all' ? 'active' : '' }}">All</button>
            <button wire:click="changeDonationType('stripe')"
                class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light fw-bold px-4 me-1 {{ $donation_type === 'stripe' ? 'active' : '' }}">Stripe</button>
            <button wire:click="changeDonationType('paypal')"
                class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light fw-bold px-4 me-1 {{ $donation_type === 'paypal' ? 'active' : '' }}">Paypal</button>
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
                placeholder="{{ __('Search doantion') }}" />
        </div>
        <!--end::Search-->

        <div class="table-responsive pt-10">
            <table class="table table-row-dashed align-middle gs-0 gy-3 my-0">
                <thead>
                    <tr class="fs-7 fw-bold text-gray-400 border-bottom-0">
                        <th class="pb-3 min-w-50px text-start">No</th>
                        <th class="pb-3 min-w-150px">Compaign</th>
                        <th class="pb-3 min-w-150px">Donor</th>
                        <th class="pb-3 min-w-100px text-center">Amount</th>
                        <th class="pb-3 min-w-100px text-center">Type</th>
                        <th class="pb-3 min-w-100px text-center">Fee</th>
                        <th class="pb-3 min-w-100px text-center">Status</th>
                        <th class="pb-3 min-w-100px text-center">Time</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($donations as $donation)
                        <tr>
                            <th>{{ ($donations->currentpage() - 1) * $donations->perpage() + $loop->index + 1 }}</th>
                            <td>{{ $donation->compaign?->name }}</td>
                            <td class="d-flex align-items-center">
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    @php
                                        $colour = random_colour();
                                    @endphp
                                    <div
                                        class="symbol-label fs-3 bg-light-{{ $colour }} text-{{ $colour }}">
                                        {{ name_alphabetic($donation->donor?->name) }}</div>
                                </div>
                                <div class="d-flex flex-column">
                                    <span
                                        class="text-gray-800 text-hover-primary mb-1">{{ $donation->donor?->name }}</span>
                                    <span>{{ $donation->donor?->email }}</span>
                                </div>
                            </td>
                            <td class="text-center">{{ $donation->formatted_amount }}</td>
                            <td class="text-capitalize text-center">{{ $donation->type }}</td>
                            <td class="text-center">{{ $donation->formatted_processing_fee }}</td>
                            <td class="text-capitalize text-center">{{ $donation->status }}</td>
                            <td class="text-center">{{ $donation->created_at->format('d M y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">No donation</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-10">
                {{ $donations->links() }}
            </div>
        </div>
    </div>
</div>
