<template>
    <div id="kt_header" style="" class="header  align-items-stretch">
        <!--begin::Container-->
        <div class=" container-fluid  d-flex align-items-stretch justify-content-between">
            <!--begin::Aside mobile toggle-->
            <div class="d-flex align-items-center d-lg-none ms-n1 me-2" title="Show aside menu">
                <div
                    >
                    <button @click="toggleSidebar" class="btn btn-icon btn-active-color-primary d-lg-none">
                        <i class="bi bi-list fs-2"></i>
                    </button>
                </div>
            </div>
            <!--end::Aside mobile toggle-->

            <!--begin::Mobile logo-->
            <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
                <a :href="route('dashboard')" class="d-lg-none">
                    <img alt="Logo" src="../../../src/logo/logo_b.png" class="h-55px" />
                </a>
            </div>
            <!--end::Mobile logo-->

            <!--begin::Wrapper-->
            <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
                <!--begin::Navbar-->
                <div class="d-flex align-items-stretch" id="kt_header_nav">

                    <!--begin::Menu wrapper-->
                    <div class="header-menu align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="header-menu"
                        data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
                        data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="end"
                        data-kt-drawer-toggle="#kt_header_menu_mobile_toggle" data-kt-swapper="true"
                        data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav'}">
                        <!--begin::Menu-->
                        <div class="menu menu-rounded menu-column menu-lg-row menu-active-bg menu-state-primary menu-title-gray-700 menu-arrow-gray-400 fw-semibold my-5 my-lg-0 px-2 px-lg-0 align-items-stretch"
                            id="#kt_header_menu" data-kt-menu="true">
                            <!--begin:Menu item-->
                            <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                                data-kt-menu-placement="bottom-start"
                                class="menu-item menu-here-bg menu-lg-down-accordion me-0 me-lg-2 show menu-dropdown">

                                <span v-if="bandwidth == 0" style="padding-right: 10px;"><img
                                        src="../../../src/connectivity/disconnected.png" height="20" width="20" /></span>
                                <span v-else-if="bandwidth > 0 && bandwidth <= 0.25" style="padding-right: 10px;"><img
                                        src="../../../src/connectivity/connectivity_none.png" height="20"
                                        width="20" /></span>
                                <span v-else-if="bandwidth > 0.25 && bandwidth <= 2" style="padding-right: 10px;"><img
                                        src="../../../src/connectivity/connectivity_slow.png" height="20"
                                        width="20" /></span>
                                <span v-else style="padding-right: 10px;"><img
                                        src="../../../src/connectivity/connectivity_connected.png" height="20"
                                        width="20" /></span>

                                <span class="menu-title text-gray-600 w-200px">{{ currentDate }} &nbsp; {{ currentTime
                                }}</span>

                                <!-- <span class="menu-title">
                                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#calculatorModal">
                                        <img src="../../../src/icon/calculator.png" />
                                    </a>
                                </span> -->

                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <div class="d-flex align-items-stretch flex-shrink-0">

                <div class="d-flex align-items-center ms-1 ms-lg-3">
                    <div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px"
                        data-bs-toggle="modal" data-bs-target="#calculatorModal" id="kt_activities_toggle">
                        <i class="bi bi-calculator fs-2"></i>
                    </div>
                </div>
                <div v-if="props.auth.user.user_role_id == 1" class="d-flex align-items-center ms-1 ms-lg-3">
                    <Link :href="route('configuration.index')">
                    <div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px"
                        id="kt_activities_toggle">
                        <i class="bi bi-gear-wide-connected fs-2"></i>
                    </div>
                    </Link>
                </div>
                <!-- <div class="d-flex align-items-center ms-1 ms-lg-3">
                    <div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px"
                        data-bs-toggle="modal" data-bs-target="#contactModal" id="kt_activities_toggle">
                        <i class="bi bi-headset fs-2"></i>
                    </div>
                </div> -->

            </div>

            <div class="d-flex align-items-stretch flex-shrink-0">

                <div class="d-flex align-items-center ms-1 ms-lg-3" id="kt_header_user_menu_toggle">

                    <div class="btn btn-icon btn-active-light-primary w-30px w-md-40px h-30px h-md-40px px-2"
                        data-bs-toggle="dropdown" data-kt-menu-placement="bottom-end">
                        <i class="bi bi-person-circle fs-2"></i>

                    </div>
                    <span class="ms-1 text-gray-700">{{ props.auth.user.name }}</span>

                    <div class="dropdown-menu menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-2 fs-6 w-200px"
                        data-kt-menu="true">

                        <div class="menu-item px-6 text-end">
                            <!-- {{ props.auth.user.name }}<br /> -->
                            {{ props.auth.user.email }}
                        </div>

                        <div class="menu-item px-5 text-end border-top">
                            <Link :href="route('logout')" method="post" as="button" class="dropdown-item mt-2"
                                style="background-color: rgb(239, 239, 239); border-radius: 5px;">
                            Log Out
                            </Link>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Calculator Modal -->
    <div class="modal fade" id="calculatorModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="col-12 mb-8 text-end">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="row px-4 pt-1 pb-2">
                        <div class="col-12">
                            <div class="row">
                                <div class="cal_input" id="cal_input">{{ cal_input }}</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row operators">
                                <div class="col-3 g-1 py-3" @click="handleOperatorClick('+')">+</div>
                                <div class="col-3 g-1 py-3" @click="handleOperatorClick('-')">-</div>
                                <div class="col-3 g-1 py-3" @click="handleOperatorClick('×')">×</div>
                                <div class="col-3 g-1 py-3" @click="handleOperatorClick('÷')">÷</div>
                            </div>
                            <div class="row">
                                <div class="col-9">
                                    <div class="row numbers">
                                        <div class="col-4 g-1 py-3" @click="handleNumberClick('7')">7</div>
                                        <div class="col-4 g-1 py-3" @click="handleNumberClick('8')">8</div>
                                        <div class="col-4 g-1 py-3" @click="handleNumberClick('9')">9</div>
                                    </div>
                                    <div class="row numbers">
                                        <div class="col-4 g-1 py-3" @click="handleNumberClick('4')">4</div>
                                        <div class="col-4 g-1 py-3" @click="handleNumberClick('5')">5</div>
                                        <div class="col-4 g-1 py-3" @click="handleNumberClick('6')">6</div>
                                    </div>
                                    <div class="row numbers">
                                        <div class="col-4 g-1 py-3" @click="handleNumberClick('1')">1</div>
                                        <div class="col-4 g-1 py-3" @click="handleNumberClick('2')">2</div>
                                        <div class="col-4 g-1 py-3" @click="handleNumberClick('3')">3</div>
                                    </div>
                                    <div class="row numbers">
                                        <div class="col-4 g-1 py-3" @click="handleNumberClick('0')">0</div>
                                        <div class="col-4 g-1 py-3" @click="handleNumberClick('.')">.</div>
                                        <div class="col-4 g-1 py-3" id="clear" @click="handleClearClick">C</div>
                                    </div>
                                </div>
                                <div class="col-3 equal " @click="handleResultClick" style="background-color:#4b49b7 ;">
                                    <div class="row h-100 d-flex align-items-center justify-content-center">
                                        <div class="col-12 " id="result">=</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Contact Modal -->
    <div class="modal fade" id="contactModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="col-12 mb-8 text-end">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="col-12 text-center">
                        <img alt="Logo" src="../../../src/logo/logo_b.png" class="h-50px logo" />
                    </div>
                    <div class="col-12 mt-4 text-center">
                        <span class="fs-1 text-gray-700">Contact Us</span>
                    </div>
                    <div class="col-12 mt-4 text-center">
                        <span class="fs-4 text-gray-700">If you need any help, please contact us</span>
                    </div>
                    <div class="col-12 mt-7 text-center">
                        <i class="bi bi-telephone-fill fs-2hx"></i>
                    </div>
                    <div class="col-12 mt-4 text-center">
                        <span class="fs-2 text-gray-700">Lakshan : <a href="#">077 273 38668 </a></span>
                    </div>
                    <div class="col-12 mt-5 text-center">
                        <i class="bi bi-envelope-at-fill fs-2hx"></i>
                    </div>
                    <div class="col-12 mt-4 mb-8 text-center">
                        <span class="fs-3 text-gray-700"><a href="mailto:serendib.itcontact@gmail.com" type="email"
                                target="_blank">serendib.itcontact@gmail.com</a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { ref, computed, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { toggleSidebar } from '@/eventBus.js';



const { props } = usePage();

const userHasRole = computed(() => (roleName) => {
    return props.auth.user.role_name === roleName;
});

const currentDate = ref(formatDate(new Date()));
const currentTime = ref(formatTime(new Date()));

const bandwidth = ref(0);
const isLoading = ref(true);

const cal_input = ref("");
const resultDisplayed = ref(false);

setInterval(() => {
    currentDate.value = formatDate(new Date());
    currentTime.value = formatTime(new Date());
}, 1000);

function formatDate(date) {
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year = date.getFullYear();

    return `${day}/${month}/${year}`;
}

function formatTime(date) {
    let hours = date.getHours();
    const ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12 || 12; // Convert to 12-hour format
    hours = String(hours).padStart(2, '0'); // Ensure two digits
    const minutes = String(date.getMinutes()).padStart(2, '0');
    const seconds = String(date.getSeconds()).padStart(2, '0');

    return `${hours}:${minutes}:${seconds} ${ampm}`;
}

const handleNumberClick = async (val) => {
    console.log('Number clicked:', val);
    if (resultDisplayed.value === false) {
        cal_input.value += val;
    } else {
        resultDisplayed.value = false;
        cal_input.value = val;
    }
};

const handleOperatorClick = (val) => {
    const lastChar = cal_input.value[cal_input.value.length - 1];
    if (lastChar === "+" || lastChar === "-" || lastChar === "×" || lastChar === "÷") {
        cal_input.value = cal_input.value.slice(0, -1) + val;
    } else if (cal_input.value.length === 0) {
        console.log("Enter a number first");
    } else {
        cal_input.value += val;
    }
};

const handleResultClick = () => {
    const numbers = cal_input.value.split(/\+|\-|\×|\÷/g);
    const operators = cal_input.value.replace(/[0-9]|\./g, "").split("");

    let divide = operators.indexOf("÷");
    while (divide !== -1) {
        numbers.splice(divide, 2, numbers[divide] / numbers[divide + 1]);
        operators.splice(divide, 1);
        divide = operators.indexOf("÷");
    }

    let multiply = operators.indexOf("×");
    while (multiply !== -1) {
        numbers.splice(multiply, 2, numbers[multiply] * numbers[multiply + 1]);
        operators.splice(multiply, 1);
        multiply = operators.indexOf("×");
    }

    let subtract = operators.indexOf("-");
    while (subtract !== -1) {
        numbers.splice(subtract, 2, numbers[subtract] - numbers[subtract + 1]);
        operators.splice(subtract, 1);
        subtract = operators.indexOf("-");
    }

    let add = operators.indexOf("+");
    while (add !== -1) {
        numbers.splice(add, 2, parseFloat(numbers[add]) + parseFloat(numbers[add + 1]));
        operators.splice(add, 1);
        add = operators.indexOf("+");
    }

    cal_input.value = numbers[0].toString();
    resultDisplayed.value = true;
};

const handleClearClick = () => {
    cal_input.value = "";
};

onMounted(() => {

    if (navigator.connection) {

        bandwidth.value = navigator.connection.downlink.toFixed(2);
        isLoading.value = false;

        navigator.connection.addEventListener('change', () => {
            bandwidth.value = navigator.connection.downlink.toFixed(2);
        });
    } else {
        props.connectionType = 'Unknown';
        bandwidth.value = 0;
        isLoading.value = false;
    }

    document.addEventListener("keydown", function (event) {
        const key = event.key;

        if (/\d/.test(key)) {
            handleNumberClick(key);
        } else if (key === "+") {
            handleOperatorClick("+");
        } else if (key === "-") {
            handleOperatorClick("-");
        } else if (key === "*") {
            handleOperatorClick("×");
        } else if (key === "/") {
            handleOperatorClick("÷");
        } else if (key === "Enter") {
            handleResultClick();
        } else if (key === "c") {
            handleClearClick();
        }
    });

});


</script>

<style lang="scss" scoped>
.calculator {
    background-color: #f0f0f0;
    padding: 20px;
    border-radius: 10px;
}

.cal_input {
    border: 2px solid #009ef7;
    border-radius: 5px;
    height: 60px;
    text-align: right;
    font-size: 2.5rem;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: border .2s ease-in-out, box-shadow .2s ease-in-out;
}

.cal_input:hover {
    border: 2px solid #015b9b;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.numbers div {
    background-color: #fff;
    border: 1px solid #bbb;
    border-radius: 5px;
    text-align: center;
    cursor: pointer;
    font-size: 1.5rem;
    transition: background-color .2s, border-color .2s, box-shadow .2s;
}

.numbers div:hover {
    background-color: #f1f1f1;
    border-color: #999;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.operators div {
    background-color: #f9f9f9;
    border: 1px solid #bbb;
    border-radius: 5px;
    text-align: center;
    cursor: pointer;
    font-size: 1.5rem;
    transition: background-color .2s, border-color .2s, box-shadow .2s;
}

.operators div:hover {
    background-color: #ddd;
    border-color: #aaa;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

div.equal {
    background-color: #009ef7;
    border: 2px solid #009ef7;
    border-radius: 5px;
    text-align: center;
    cursor: pointer;
    color: #FFF;
    font-size: 2rem;
    transition: all .2s ease-in-out;
}

div.equal:hover {
    background-color: #015b9b;
    border-color: #015b9b;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.border-top {
    border-top: 1px solid #373636;
}
</style>
