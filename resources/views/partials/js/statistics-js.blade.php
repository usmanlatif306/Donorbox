<script>
    "use strict";

    const compaigns = @json($compaigns);
    compaigns.forEach(item => {
        drawChart(`kt_card_compaign_${item.id}_chart`, item.formatted_data, item.formatted_days, item.id, item
            .colour)
    });


    function drawChart(target, data, categories, id, color) {
        var KTCardCompaign = (function() {
            var e = {
                    self: null,
                    rendered: !1
                },
                t = function(e) {
                    var t = document.getElementById(target);
                    if (t) {
                        var a = parseInt(KTUtil.css(t, "height")),
                            l = KTUtil.getCssVariableValue("--bs-border-dashed-color"),
                            r = KTUtil.getCssVariableValue("--bs-gray-800"),
                            o = {
                                series: [{
                                    name: "Donations",
                                    data: data,
                                }, ],
                                chart: {
                                    fontFamily: "inherit",
                                    type: "area",
                                    height: a,
                                    toolbar: {
                                        show: !1
                                    },
                                },
                                legend: {
                                    show: !1
                                },
                                dataLabels: {
                                    enabled: !1
                                },
                                fill: {
                                    type: "solid",
                                    opacity: 0
                                },
                                stroke: {
                                    curve: "smooth",
                                    show: !0,
                                    width: 2,
                                    colors: [r],
                                },
                                xaxis: {
                                    categories: categories,
                                    axisBorder: {
                                        show: !1
                                    },
                                    axisTicks: {
                                        show: !1
                                    },
                                    labels: {
                                        show: !1
                                    },
                                    crosshairs: {
                                        position: "front",
                                        stroke: {
                                            color: r,
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
                                yaxis: {
                                    labels: {
                                        show: !1
                                    }
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
                                    //         return "March " + e;
                                    //     },
                                    // },
                                    y: {
                                        formatter: function(e) {
                                            return "$" + e;
                                        },
                                    },
                                },
                                colors: [KTUtil.getCssVariableValue(`--bs-${color}`)],
                                grid: {
                                    borderColor: l,
                                    strokeDashArray: 4,
                                    padding: {
                                        top: 0,
                                        right: -20,
                                        bottom: -20,
                                        left: -20,
                                    },
                                    yaxis: {
                                        lines: {
                                            show: !0
                                        }
                                    },
                                },
                                markers: {
                                    strokeColor: r,
                                    strokeWidth: 2
                                },
                            };
                        (e.self = new ApexCharts(t, o)),
                        // e.self.render(), (e.rendered = !0);
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
        "undefined" != typeof module && (module.exports = KTCardCompaign),
            KTUtil.onDOMContentLoaded(function() {
                KTCardCompaign.init();
            });
    }
</script>
