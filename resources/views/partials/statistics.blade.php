<div class="col-12 mb-5 mb-xl-10">
    <!--begin::Row-->
    <div class="row g-lg-5 g-xl-10">
        @foreach ($compaigns as $item)
            <!--begin::Col-->
            {{-- <div class="{{ !$loop->last ? 'col-md-6 col-xl-6' : 'col-12' }}"> --}}
            <div class="col-md-6 col-xl-4">
                <div class="card">
                    <div class="card-body d-flex justify-content-between flex-column px-0 pb-0">
                        <div class="mb-4 px-9">
                            <div class="d-flex align-items-center mb-2">
                                <span
                                    class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">{{ formatted_number($item['total_raised']) }}</span>
                                <span class="d-flex align-items-end text-gray-400 fs-6 fw-semibold">$</span>
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
</div>
