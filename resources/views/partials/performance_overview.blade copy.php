<div class="col-xxl-6 mb-5 mb-xl-10">
    <div class="card card-flush overflow-hidden h-md-100">
        <!--begin::Header-->
        <div class="card-header py-5">
            <!--begin::Title-->
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold text-dark">Performance Overview</span>
                {{-- <span class="text-gray-400 mt-1 fw-semibold fs-6">Users from all channels</span> --}}
            </h3>
            <!--end::Title-->
        </div>
        <!--end::Header-->
        <!--begin::Card body-->
        <div class="card-body d-flex justify-content-between flex-column pb-1 px-0">
            <!--begin::Info-->
            <div class="px-9 mb-5">
                <!--begin::Statistics-->
                <div class="d-flex align-items-center mb-2">
                    <!--begin::Currency-->
                    <span class="fs-4 fw-semibold text-gray-400 align-self-start me-1">$</span>
                    <!--end::Currency-->
                    <!--begin::Value-->
                    <span
                        class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">{{ formatted_number($total_raised, 2) }}</span>
                    <!--end::Value-->
                    {{-- <span class="badge badge-light-success fs-base">
                        <i class="ki-duotone ki-arrow-down fs-5 text-success ms-n1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>4.5%</span> --}}
                </div>
                <!--end::Statistics-->
                <!--begin::Description-->
                <span class="fs-6 fw-semibold text-gray-400">Total Donations</span>
                <!--end::Description-->
            </div>
            <!--end::Info-->
            <!--begin::Chart-->
            <div id="performance_overview_chart" class="min-h-auto ps-4 pe-6" style="height: 600px"></div>
            <!--end::Chart-->
        </div>
        <!--end::Card body-->
    </div>
</div>
