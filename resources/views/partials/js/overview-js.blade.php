<script>
    "use strict";

    var KTChartsWidget36 = (function() {
        var e = {
                self: null,
                rendered: !1
            },
            t = function(e) {
                var t = document.getElementById("compaigns_overview_chart");
                if (t) {
                    var a = parseInt(KTUtil.css(t, "height")),
                        l = KTUtil.getCssVariableValue("--bs-gray-500"),
                        r = KTUtil.getCssVariableValue("--bs-border-dashed-color"),
                        o = KTUtil.getCssVariableValue("--bs-primary"),
                        i = KTUtil.getCssVariableValue("--bs-primary"),
                        s = KTUtil.getCssVariableValue("--bs-success"),
                        n = {
                            series: [{
                                    name: "Stripe",
                                    data: @json($formatted_compaigns['stripe_donations']),
                                },
                                {
                                    name: "Paypal",
                                    data: @json($formatted_compaigns['paypal_donations']),
                                },
                            ],
                            chart: {
                                fontFamily: "inherit",
                                type: "area",
                                height: a,
                                toolbar: {
                                    show: !1
                                },
                            },
                            plotOptions: {},
                            legend: {
                                show: !1
                            },
                            dataLabels: {
                                enabled: !1
                            },
                            fill: {
                                type: "gradient",
                                gradient: {
                                    shadeIntensity: 1,
                                    opacityFrom: 0.4,
                                    opacityTo: 0.2,
                                    stops: [15, 120, 100],
                                },
                            },
                            stroke: {
                                curve: "smooth",
                                show: !0,
                                width: 3,
                                colors: [o, s],
                            },
                            xaxis: {
                                categories: @json($formatted_compaigns['categories']),
                                axisBorder: {
                                    show: !1
                                },
                                axisTicks: {
                                    show: !1
                                },
                                tickAmount: 6,
                                labels: {
                                    rotate: 0,
                                    rotateAlways: !0,
                                    style: {
                                        colors: l,
                                        fontSize: "12px"
                                    },
                                },
                                crosshairs: {
                                    position: "front",
                                    stroke: {
                                        color: [o, s],
                                        width: 1,
                                        dashArray: 3,
                                    },
                                },
                                tooltip: {
                                    enabled: !0,
                                    formatter: void 0,
                                    offsetY: 0,
                                    style: {
                                        fontSize: "12px"
                                    },

                                },
                            },
                            yaxis: {
                                tickAmount: 20,
                                labels: {
                                    style: {
                                        colors: l,
                                        fontSize: "12px"
                                    }
                                },
                            },
                            states: {
                                normal: {
                                    filter: {
                                        type: "none",
                                        value: 0
                                    }
                                },
                                hover: {
                                    filter: {
                                        type: "none",
                                        value: 0
                                    }
                                },
                                active: {
                                    allowMultipleDataPointsSelection: !1,
                                    filter: {
                                        type: "none",
                                        value: 0
                                    },
                                },
                            },
                            tooltip: {
                                style: {
                                    fontSize: "12px"
                                }
                            },
                            colors: [i, KTUtil.getCssVariableValue("--bs-success")],
                            grid: {
                                borderColor: r,
                                strokeDashArray: 4,
                                yaxis: {
                                    lines: {
                                        show: !0
                                    }
                                },
                            },
                            markers: {
                                strokeColor: [o, s],
                                strokeWidth: 3
                            },
                        };
                    (e.self = new ApexCharts(t, n)),
                    setTimeout(function() {
                        e.self.render(), (e.rendered = !0);
                    }, 200);
                }
            };
        return {
            init: function() {
                t(e),
                    KTThemeMode.on("kt.thememode.change", function() {
                        e.rendered && e.self.destroy(), t(e);
                    });
            },
        };
    })();
    "undefined" != typeof module && (module.exports = KTChartsWidget36),
        KTUtil.onDOMContentLoaded(function() {
            KTChartsWidget36.init();
        });
</script>
