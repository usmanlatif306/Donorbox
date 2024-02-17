<div class="col-md-6 col-xxl-12">
    <!--begin::List widget 3-->
    <div class="card card-flush h-xl-100">
        <!--begin::Header-->
        <div class="card-header pt-5">
            <!--begin::Title-->
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold text-dark fs-3">Compaigns</span>
                <span class="text-gray-400 mt-1 fw-semibold fs-6">Percentage of all compaigns</span>
            </h3>
            <!--end::Title-->
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body">

            @foreach ($compaigns as $item)
                <!--begin::Item-->
                <div class="d-flex flex-stack">
                    <!--begin::Wrapper-->
                    <div class="d-flex align-items-center me-3">
                        <!--begin::Section-->
                        <div class="flex-grow-1">
                            <a href="#"
                                class="text-gray-800 text-hover-primary fs-5 fw-bold lh-0">{{ $item['compaign']->name }}</a>
                        </div>
                        <!--end::Section-->
                    </div>
                    <!--end::Wrapper-->
                    <!--begin::Statistics-->
                    @php
                        $goal_amt = (float) $item['compaign']->goal_amt;
                        if ($item['compaign']->goal_amt > 0.1) {
                            $percentage = ceil(($item['compaign']->total_raised / $goal_amt) * 100);
                        } else {
                            $percentage = 0;
                        }

                    @endphp
                    <div class="d-flex align-items-center w-100 mw-125px">
                        <!--begin::Progress-->
                        <div class="progress h-8px w-100 me-2 bg-light-{{ $item['colour'] }}">
                            <div class="progress-bar bg-{{ $item['colour'] }}" role="progressbar"
                                style="width: {{ $percentage }}%" aria-valuenow="{{ $percentage }}"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <!--end::Progress-->
                        <!--begin::Value-->
                        <span class="text-gray-400 fw-semibold">{{ $percentage }}%</span>
                        <!--end::Value-->
                    </div>
                    <!--end::Statistics-->
                </div>
                <!--end::Item-->
                <!--begin::Separator-->
                @if (!$loop->last)
                    <div class="separator separator-dashed my-4"></div>
                @endif
                <!--end::Separator-->
            @endforeach
            <!--end::Item-->
        </div>
        <!--end::Body-->
    </div>
    <!--end::List widget 3-->
</div>
