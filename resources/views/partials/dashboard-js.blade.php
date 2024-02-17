<script>
    "use strict";

    // var KTCardWidgetSellingRequest = {
    //     init: function() {
    //         !(function() {
    //             var e = document.getElementById("kt_card_widget_6_chart");
    //             if (e) {
    //                 var t = parseInt(KTUtil.css(e, "height")),
    //                     a = KTUtil.getCssVariableValue("--bs-gray-500"),
    //                     l = KTUtil.getCssVariableValue("--bs-border-dashed-color"),
    //                     r = KTUtil.getCssVariableValue("--bs-primary"),
    //                     o = KTUtil.getCssVariableValue("--bs-gray-300"),
    //                     i = new ApexCharts(e, {
    //                         series: [{
    //                             name: "Investors",
    //                             data: @json($data['per_day_investors']),
    //                         }, ],
    //                         chart: {
    //                             fontFamily: "inherit",
    //                             type: "bar",
    //                             height: t,
    //                             toolbar: {
    //                                 show: !1
    //                             },
    //                             sparkline: {
    //                                 enabled: !0
    //                             },
    //                         },
    //                         plotOptions: {
    //                             bar: {
    //                                 horizontal: !1,
    //                                 columnWidth: ["55%"],
    //                                 borderRadius: 6,
    //                             },
    //                         },
    //                         legend: {
    //                             show: !1
    //                         },
    //                         dataLabels: {
    //                             enabled: !1
    //                         },
    //                         stroke: {
    //                             show: !0,
    //                             width: 9,
    //                             colors: ["transparent"]
    //                         },
    //                         xaxis: {
    //                             categories: @json($data['formatted_week_dates']),
    //                             axisBorder: {
    //                                 show: !1
    //                             },
    //                             axisTicks: {
    //                                 show: !1,
    //                                 tickPlacement: "between"
    //                             },
    //                             labels: {
    //                                 show: !1,
    //                                 style: {
    //                                     colors: a,
    //                                     fontSize: "12px"
    //                                 },
    //                             },
    //                             crosshairs: {
    //                                 show: !1
    //                             },
    //                         },
    //                         yaxis: {
    //                             labels: {
    //                                 show: !1,
    //                                 style: {
    //                                     colors: a,
    //                                     fontSize: "12px"
    //                                 },
    //                             },
    //                         },
    //                         fill: {
    //                             type: "solid"
    //                         },
    //                         states: {
    //                             normal: {
    //                                 filter: {
    //                                     type: "none",
    //                                     value: 0
    //                                 }
    //                             },
    //                             hover: {
    //                                 filter: {
    //                                     type: "none",
    //                                     value: 0
    //                                 }
    //                             },
    //                             active: {
    //                                 allowMultipleDataPointsSelection: !1,
    //                                 filter: {
    //                                     type: "none",
    //                                     value: 0
    //                                 },
    //                             },
    //                         },
    //                         tooltip: {
    //                             style: {
    //                                 fontSize: "12px"
    //                             },
    //                             // x: {
    //                             //     formatter: function(e) {
    //                             //         return "Feb: " + e;
    //                             //     },
    //                             // },
    //                             y: {
    //                                 formatter: function(e) {
    //                                     return e;
    //                                 },
    //                             },
    //                         },
    //                         colors: [r, o],
    //                         grid: {
    //                             padding: {
    //                                 left: 10,
    //                                 right: 10
    //                             },
    //                             borderColor: l,
    //                             strokeDashArray: 4,
    //                             yaxis: {
    //                                 lines: {
    //                                     show: !0
    //                                 }
    //                             },
    //                         },
    //                     });
    //                 setTimeout(function() {
    //                     i.render();
    //                 }, 300);
    //             }
    //         })();
    //     },
    // };
    // "undefined" != typeof module && (module.exports = KTCardWidgetSellingRequest),
    //     KTUtil.onDOMContentLoaded(function() {
    //         KTCardWidgetSellingRequest.init();
    //     });

    drawBarGrapgh(@json($data['per_day_investors']), "Investors", @json($data['formatted_week_dates']), "kt_card_widget_6_chart");

    drawBarGrapgh(@json($data['per_day_selling_requests']), "Selling Requests", @json($data['formatted_week_dates']),
        "kt_card_widget_selling_requests");


    function drawBarGrapgh(data, title, categories, target) {
        var KTCardBarGrapgh = {
            init: function() {
                !(function() {
                    var e = document.getElementById(target);
                    if (e) {
                        var t = parseInt(KTUtil.css(e, "height")),
                            a = KTUtil.getCssVariableValue("--bs-gray-500"),
                            l = KTUtil.getCssVariableValue("--bs-border-dashed-color"),
                            r = KTUtil.getCssVariableValue("--bs-primary"),
                            o = KTUtil.getCssVariableValue("--bs-gray-300"),
                            i = new ApexCharts(e, {
                                series: [{
                                    name: title,
                                    data: data,
                                }, ],
                                chart: {
                                    fontFamily: "inherit",
                                    type: "bar",
                                    height: t,
                                    toolbar: {
                                        show: !1
                                    },
                                    sparkline: {
                                        enabled: !0
                                    },
                                },
                                plotOptions: {
                                    bar: {
                                        horizontal: !1,
                                        columnWidth: ["55%"],
                                        borderRadius: 6,
                                    },
                                },
                                legend: {
                                    show: !1
                                },
                                dataLabels: {
                                    enabled: !1
                                },
                                stroke: {
                                    show: !0,
                                    width: 9,
                                    colors: ["transparent"]
                                },
                                xaxis: {
                                    categories: categories,
                                    axisBorder: {
                                        show: !1
                                    },
                                    axisTicks: {
                                        show: !1,
                                        tickPlacement: "between"
                                    },
                                    labels: {
                                        show: !1,
                                        style: {
                                            colors: a,
                                            fontSize: "12px"
                                        },
                                    },
                                    crosshairs: {
                                        show: !1
                                    },
                                },
                                yaxis: {
                                    labels: {
                                        show: !1,
                                        style: {
                                            colors: a,
                                            fontSize: "12px"
                                        },
                                    },
                                },
                                fill: {
                                    type: "solid"
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
                                    },
                                    // x: {
                                    //     formatter: function(e) {
                                    //         return "Feb: " + e;
                                    //     },
                                    // },
                                    y: {
                                        formatter: function(e) {
                                            return e;
                                        },
                                    },
                                },
                                colors: [r, o],
                                grid: {
                                    padding: {
                                        left: 10,
                                        right: 10
                                    },
                                    borderColor: l,
                                    strokeDashArray: 4,
                                    yaxis: {
                                        lines: {
                                            show: !0
                                        }
                                    },
                                },
                            });
                        setTimeout(function() {
                            i.render();
                        }, 300);
                    }
                })();
            },
        };
        "undefined" != typeof module && (module.exports = KTCardBarGrapgh),
            KTUtil.onDOMContentLoaded(function() {
                KTCardBarGrapgh.init();
            });

    }

    var KTChartsWidget3 = (function() {
        var e = {
                self: null,
                rendered: !1
            },
            t = function(e) {
                var t = document.getElementById("kt_charts_widget_3");
                if (t) {
                    var a = parseInt(KTUtil.css(t, "height")),
                        l = KTUtil.getCssVariableValue("--bs-gray-500"),
                        r = KTUtil.getCssVariableValue("--bs-border-dashed-color"),
                        o = KTUtil.getCssVariableValue("--bs-success"),
                        i = {
                            series: [{
                                name: "Investment",
                                data: @json($data['per_day_investment']),
                            }, ],
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
                                    opacityTo: 0,
                                    stops: [0, 80, 100],
                                },
                            },
                            stroke: {
                                curve: "smooth",
                                show: !0,
                                width: 3,
                                colors: [o],
                            },
                            xaxis: {
                                categories: @json($data['investment_dates']),
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
                                        color: o,
                                        width: 1,
                                        dashArray: 3
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
                                },
                                y: {
                                    formatter: function(e) {
                                        return "$" + e;
                                    },
                                },
                            },
                            colors: [KTUtil.getCssVariableValue("--bs-success")],
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
                                strokeColor: o,
                                strokeWidth: 3
                            },
                        };
                    (e.self = new ApexCharts(t, i)),
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
    "undefined" != typeof module && (module.exports = KTChartsWidget3),
        KTUtil.onDOMContentLoaded(function() {
            KTChartsWidget3.init();
        });
</script>
