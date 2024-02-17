<div class="card card-flush">
    <div class="card-header pt-7">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold text-gray-800">All Donors</span>
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
                placeholder="{{ __('Search donor') }}" />
        </div>
        <!--end::Search-->

        <div class="table-responsive pt-10">
            <table class="table table-row-dashed align-middle gs-0 gy-3 my-0">
                <thead>
                    <tr class="fs-7 fw-bold text-gray-400 border-bottom-0">
                        <th class="pb-3 min-w-50px text-start">No</th>
                        <th class="pb-3 min-w-150px">Donor</th>
                        <th class="pb-3 min-w-100px">Phone</th>
                        <th class="pb-3 min-w-150px">Address</th>
                        <th class="pb-3 min-w-150px text-center">Donation Count</th>
                        <th class="pb-3 min-w-150px text-center">Total Donations</th>
                        <th class="pb-3 min-w-150px text-center">Last Donation At</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($donors as $donor)
                        <tr>
                            <th>{{ ($donors->currentpage() - 1) * $donors->perpage() + $loop->index + 1 }}</th>
                            <td class="d-flex align-items-center">
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    @php
                                        $colour = random_colour();
                                    @endphp
                                    <div
                                        class="symbol-label fs-3 bg-light-{{ $colour }} text-{{ $colour }}">
                                        {{ name_alphabetic($donor->name) }}</div>
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="text-gray-800 text-hover-primary mb-1">{{ $donor->name }}</span>
                                    <span>{{ $donor->email }}</span>
                                </div>
                            </td>
                            <td>{{ $donor->phone }}</td>
                            <td>{{ $donor->address . ', ' . $donor->city . ', ' . $donor->country }}</td>
                            <td class="text-center">{{ $donor->donations_count }}</td>
                            <td class="text-center">${{ $donor->total_donation }}</td>
                            <td class="text-center">{{ $donor->last_donation_at->format('d M y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No donor</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-10">
                {{ $donors->links() }}
            </div>
        </div>
    </div>
</div>
