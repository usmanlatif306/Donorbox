<div class="col-md-6 col-xxl-12 mb-5 mb-xl-10">
    <!--begin::Table widget 14-->
    <div class="card card-flush h-md-100">
        <!--begin::Header-->
        <div class="card-header pt-7">
            <!--begin::Title-->
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold text-gray-800">Compaigns Stats</span>
                {{-- <span class="text-gray-400 mt-1 fw-semibold fs-6">Updated 37 minutes ago</span> --}}
            </h3>
            <!--end::Title-->
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body pt-6">
            <!--begin::Table container-->
            <div class="table-responsive">
                <!--begin::Table-->
                <table class="table table-row-dashed align-middle gs-0 gy-9 my-0">
                    <!--begin::Table head-->
                    <thead>
                        <tr class="fs-7 fw-bold text-gray-400 border-bottom-0">
                            <th class="p-0 pb-3 min-w-200px text-start">NAME</th>
                            <th class="p-0 pb-3 min-w-100px text-center">GOAL</th>
                            <th class="p-0 pb-3 min-w-100px text-center">RAISED</th>
                            <th class="p-0 pb-3 min-w-100px text-center">DONORS</th>
                            <th class="p-0 pb-3 min-w-150px text-center pe-12">STATUS</th>
                            {{-- <th class="p-0 pb-3 w-150px text-center pe-7">CHART</th> --}}
                        </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody>
                        @foreach ($compaigns as $item)
                            @php
                                $completed = $item['compaign']->total_raised >= $item['compaign']->goal_amt;
                            @endphp
                            <tr>
                                <td>
                                    <span class="text-gray-600 fw-semibold fs-6">{{ $item['compaign']->name }}</span>
                                </td>
                                <td class="text-center pe-0">
                                    <span
                                        class="text-gray-600 fw-semibold fs-6">{{ $item['compaign']->formatted_goal_amount }}</span>
                                </td>
                                <td class="text-center pe-0">
                                    <span
                                        class="text-gray-600 fw-semibold fs-6">{{ $item['compaign']->formatted_total_raised }}</span>
                                </td>
                                <td class="text-center pe-0">
                                    <span
                                        class="text-gray-600 fw-semibold fs-6">{{ $item['compaign']->donations_count }}</span>
                                </td>
                                <td class="text-center pe-12">
                                    <span
                                        class="badge py-3 px-4 fs-7 badge-light-{{ $completed ? 'success' : 'primary' }}">
                                        @if ($completed)
                                            Completed
                                        @else
                                            In Process
                                        @endif

                                    </span>
                                </td>
                                <td class="text-center pe-0">
                                    {{-- <div id="kt_table_widget_14_chart_{{ $loop->iteration }}" class="h-50px mt-n8 pe-7"
                                        data-kt-chart-color="{{ $item['colour'] }}"></div> --}}
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                    <!--end::Table body-->
                </table>
            </div>
            <!--end::Table-->
        </div>
        <!--end: Card Body-->
    </div>
    <!--end::Table widget 14-->
</div>
