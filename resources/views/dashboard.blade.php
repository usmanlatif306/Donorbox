@extends('layouts.app')

@section('content')
    @include('partials.dashboard_header', ['title' => 'Dashboard'])

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            {{-- Alert Messages --}}
            @include('partials.alert')

            <!--begin::Row-->
            <div class="row gx-5 gx-xl-10">
                @include('partials.performance_overview', [
                    'compaigns' => $compaigns,
                    'total_raised' => $total_raised,
                    'stripe_donations' => $stripe_donations,
                    'paypal_donations' => $paypal_donations,
                ])

                @include('partials.statistics', ['compaigns' => $compaigns])
            </div>
            <!--end::Row-->

            <!--begin::Row-->
            <div class="row gy-5 g-xl-10">
                {{-- @include('partials.compaigns_overview', [
                    'stripe_donations' => $stripe_donations,
                    'paypal_donations' => $paypal_donations,
                ]) --}}

                @include('partials.compains_percentage', ['compaigns' => $compaigns])

                @include('partials.compaigns', ['compaigns' => $compaigns])

            </div>
            <!--end::Row-->
        </div>
    </div>
@endsection
@push('scripts')
    @include('partials.js.performance-js', ['performance' => $performance])
    @include('partials.js.statistics-js', ['compaigns' => $compaigns])
    @include('partials.js.overview-js', [
        'compaigns' => $compaigns,
        'formatted_compaigns' => $formatted_compaigns,
    ])
@endpush
