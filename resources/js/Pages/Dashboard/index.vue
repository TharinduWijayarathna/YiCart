<template>
    <AppLayout title=" Horizon POS Dashboard">
        <template #content>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="mb-4 card">
                        <div class="p-3 card-body">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="mb-0 text-sm text-uppercase font-weight-bold">Sales
                                        </p>
                                        <h5 class="font-weight-bolder">
                                            {{ formattedNumber(parseFloat(this.total_system_sales)) }}
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="mb-4 card">
                        <div class="p-3 card-body">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="mb-0 text-sm text-uppercase font-weight-bold">No. of Invoices
                                        </p>
                                        <h5 class="font-weight-bolder">
                                            {{ this.total_system_invoices }}
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="mb-4 card">
                        <div class="p-3 card-body">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="mb-0 text-sm text-uppercase font-weight-bold">Credit Value
                                        </p>
                                        <h5 class="font-weight-bolder">
                                            {{ formattedNumber(parseFloat(this.total_system_non_paid)) }}
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mt-1">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="h3 mt-5">Today Sales</h5>
                        </div>
                        <div class="card-body">
                            <apexchart type="area" height="175" :options="chartOptionsInvoice" :series="total_sales">
                            </apexchart>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mt-1">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="h3 mt-5">Today Invoices</h5>
                        </div>
                        <div class="card-body">
                            <apexchart type="area" height="175" :options="chartOptionsInvoice" :series="seriesInvoice">
                            </apexchart>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" v-if="$page.props.auth.user.user_role_id == 1">
                <div class="col-md-6 mt-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="h3 mt-5">Monthly Sales</h5>
                        </div>
                        <div class="card-body">
                            <apexchart type="area" height="175" :options="chartOptionMonthlySales"
                                :series="seriesMonthlySales">
                            </apexchart>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mt-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="h3 mt-5">Monthly Invoices</h5>
                        </div>
                        <div class="card-body">
                            <apexchart type="area" height="175" :options="chartOptionMonthlyInvoices"
                                :series="seriesMonthlyInvoices">
                            </apexchart>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3'

import { library } from '@fortawesome/fontawesome-svg-core'
import { faHouse, faAngleRight } from '@fortawesome/free-solid-svg-icons'
import VueApexCharts from 'vue3-apexcharts'
export default {
    components: {
        AppLayout,
        Link,
        library,
        VueApexCharts,
    },

    props: {
        monthly_sales: Array,
        monthly_invoices: Array,

        total_sales: Array,
        total_invoices: Array,
        hours: Array,

        total_system_sales: Number,
        total_system_non_paid: Number,
        total_system_invoices: Number,

        distinct_month_names: Array,
        distinct_month_names_invoices: Array,

        today_total_sales: Number,
        today_total_invoices: Number,
    },
    beforeMount() {
        library.add(faHouse)
        library.add(faAngleRight)
    },
    data() {
        return {
            textClassHead: "text-start text-uppercase",
            textClassBody: "text-start",
            iconClassHead: "text-center",
            iconClassBody: "text-center",
            valueClassHead: "text-right",
            valueClassBody: "text-right",
            // materialTypesName:[],
            materialTypes: [],
            count: {},

            //For Today Sales chart
            seriesSale: [{
                data: this.total_sales
            }],
            chartOptionsSale: {
                chart: {
                    height: 350,
                    type: 'area',
                    zoom: {
                        enabled: false // Disable zooming
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth'
                },
                xaxis: {
                    type: 'time',
                    labels: {
                        format: 'HH:mm'
                    },
                    categories: this.hours,
                },
                tooltip: {
                    x: {
                        format: 'dd-MM-yy HH:mm'
                    },
                },
                yaxis: {
                    labels: {
                        formatter: function (val) {
                            return (val / 1).toFixed(2).replace(",", ".").toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        }
                    }
                }
            },

            //For Today Invoices chart
            seriesInvoice: [{
                data: this.monthly_invoices
            }],
            chartOptionsInvoice: {
                chart: {
                    height: 350,
                    type: 'area',
                    zoom: {
                        enabled: false // Disable zooming
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth'
                },
                xaxis: {
                    type: 'time',
                    labels: {
                        format: 'HH:mm'
                    },
                    categories: this.hours,
                },
                tooltip: {
                    x: {
                        format: 'dd-MM-yy HH:mm'
                    },
                },
                yaxis: {
                    labels: {
                        formatter: function (val) {
                            return (val / 1).toFixed(2).replace(",", ".").toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        }
                    }
                }
            },


            // For Monthly Sales chart
            chartOptionMonthlySales: {
                chart: {
                    height: 350,
                    type: 'area',
                    zoom: {
                        enabled: false // Disable zooming
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth'
                },
                xaxis: {
                    categories: this.distinct_month_names,
                },
                yaxis: {
                    labels: {
                        formatter: function (val) {
                            return (val / 1).toFixed(2).replace(",", ".").toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        }
                    }
                }
            },
            seriesMonthlySales: [
                {
                    data: this.monthly_sales
                }
            ],

            //For Monthly Invoices chart
            chartOptionMonthlyInvoices: {
                chart: {
                    height: 350,
                    type: 'area',
                    zoom: {
                        enabled: false // Disable zooming
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth'
                },
                xaxis: {
                    categories: this.distinct_month_names_invoices,
                },
                yaxis: {
                    labels: {
                        formatter: function (val) {
                            return (val / 1).toFixed(2).replace(",", ".").toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        }
                    }
                }
            },
            seriesMonthlyInvoices: [
                {
                    data: this.monthly_invoices
                }
            ],


        }
    },
    methods: {
        formattedNumber(number) {
            console.log(number);
            if (number == undefined || number == null) {
                return ""; // or some default value
            }
            return number.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
                useGrouping: true
            });
        },
    }
}
</script>
