<div class="card card-flush">
    <div class="card-header pt-7">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold text-gray-800">All Compaigns</span>
        </h3>
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
                placeholder="{{ __('Search compaign') }}" />
        </div>
        <!--end::Search-->

        <div class="table-responsive pt-10">
            <table class="table table-row-dashed align-middle gs-0 gy-3 my-0">
                <thead>
                    <tr class="fs-7 fw-bold text-gray-400 border-bottom-0">
                        <th class="p-0 pb-3 min-w-50px text-start">No</th>
                        <th class="p-0 pb-3 min-w-150px">Name</th>
                        <th class="p-0 pb-3 min-w-100px">Goal Amount</th>
                        <th class="p-0 pb-3 min-w-100px">Raised Amount</th>
                        <th class="p-0 pb-3 min-w-100px">Withdraw</th>
                        <th class="p-0 pb-3 min-w-100px">Donors</th>
                        <th class="p-0 pb-3 min-w-100px">Show on Dashboard</th>
                        <th class="p-0 pb-3 min-w-100px">Creaded On</th>
                        <th class="p-0 pb-3 min-w-100px">Creaded On</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($compaigns as $compaign)
                        <tr>
                            <th>{{ ($compaigns->currentpage() - 1) * $compaigns->perpage() + $loop->index + 1 }}</th>
                            <td>{{ $compaign->name }}</td>
                            <td>{{ $compaign->formatted_goal_amount }}</td>
                            <td>{{ $compaign->formatted_total_raised }}</td>
                            <td>{{ $compaign->stripe_payouts_sum_amount ? formatted_number($compaign->stripe_payouts_sum_amount) : 0 }}
                                {{ currency_sign() }}
                            </td>
                            <td>{{ $compaign->donations_count }}</td>
                            <td class="">
                                <input class="form-check-input" type="checkbox"
                                    wire:click="toggleShow({{ $compaign->id }})" @checked($compaign->show) />
                            </td>
                            <td>{{ $compaign->created_at->format('d M y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">No compaign</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-10">
                {{ $compaigns->links() }}
            </div>
        </div>
    </div>
</div>
