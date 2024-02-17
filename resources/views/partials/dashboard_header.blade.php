<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <!--begin::Toolbar container-->
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <!--begin::Title-->
            <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                Dashboard
            </h1>
            <!--end::Title-->
        </div>
        <!--end::Page title-->

        <div class="card-toolbar">
            <ul class="nav" id="kt_chart_widget_8_tabs">
                <li class="nav-item type-link" data-type="all">
                    <a
                        class="btn btn-sm btn-light-primary fw-bold px-4 me-1 {{ !request()->type || request()->type === 'all' ? 'active' : '' }}">All
                        Time</a>
                </li>
                <li class="nav-item type-link" data-type="week">
                    <a
                        class="btn btn-sm btn-light-primary fw-bold px-4 me-1 {{ request()->type === 'week' ? 'active' : '' }}">Week</a>
                </li>
                <li class="nav-item type-link" data-type="month">
                    <a
                        class="btn btn-sm btn-light-primary fw-bold px-4 me-1 {{ request()->type === 'month' ? 'active' : '' }}">Month</a>
                </li>
                <li class="nav-item type-link" data-type="quarter">
                    <a
                        class="btn btn-sm btn-light-primary fw-bold px-4 me-1 {{ request()->type === 'quarter' ? 'active' : '' }}">Quarter</a>
                </li>
                <li class="nav-item type-link" data-type="6_months">
                    <a
                        class="btn btn-sm btn-light-primary fw-bold px-4 me-1 {{ request()->type === '6_months' ? 'active' : '' }}">6
                        Months
                    </a>
                </li>
                <li class="nav-item type-link" data-type="year">
                    <a
                        class="btn btn-sm btn-light-primary fw-bold px-4 me-1 {{ request()->type === 'year' ? 'active' : '' }}">Year</a>
                </li>
            </ul>
        </div>
    </div>
    <!--end::Toolbar container-->
</div>
@push('scripts')
    <script>
        $(function() {
            $('.type-link').on('click', function() {
                const type = $(this).data('type');
                const base_url = document.location.origin;
                const url = type !== "all" ? `{{ route('dashboard') }}?type=${type}` :
                    "{{ route('dashboard') }}";
                window.location.href = url;
            })
        });
    </script>
@endpush
