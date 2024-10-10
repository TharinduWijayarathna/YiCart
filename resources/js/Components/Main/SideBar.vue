<template>
    <div id="kt_aside"  class="aside overflow-visible pb-2 pt-5 pt-lg-0" :class="{ 'sidebar-open': isSidebarOpen, 'd-lg-block': isSidebarOpen }">



        <div class="aside-logo flex-column-auto mt-2 mb-2" id="kt_aside_logo">
            <a :href="route('dashboard')">
                <img alt="Logo" src="../../../src/logo/logo_sidebar.png" class="h-60px logo" />
            </a>
        </div>

        <div class="flex-column-fluid" id="kt_aside_menu">
            <!--begin::Aside Menu-->
            <div class="my-lg-5 scroll-ms" id="kt_aside_menu_wrapper" data-kt-scroll="true"
                data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer"
                data-kt-scroll-wrappers="#kt_aside, #kt_aside_menu" data-kt-scroll-offset="5px">

                <div class="menu menu-column menu-title-gray-700 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-semibold"
                    data-kt-menu="true">

                    <Link v-if="props.auth.user.user_role_id == 1 || props.auth.user.user_role_id == 0"
                        :href="route('cart')" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                        data-kt-menu-placement="right-start" class="menu-item here show py-1"
                        :class="{ 'active': $page.url.startsWith('/order') }">
                    <span class="menu-link menu-center">
                        <span class="menu-icon-copy me-2">
                            <i class="bi bi-cart"></i>
                        </span>
                        <span class="menu-title-copy">Cart</span>
                    </span>
                    </Link>

                    <Link v-if="props.auth.user.user_role_id == 1 || props.auth.user.user_role_id == 0"
                        :href="route('receipt.index')" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                        data-kt-menu-placement="right-start" class="menu-item here show py-1"
                        @click="setActiveRoute('receipt.index')"
                        :class="{ 'active': $page.url.startsWith('/receipt/view') }">
                    <span class="menu-link menu-center">
                        <span class="menu-icon-copy me-2">
                            <i class="bi bi-receipt"></i>
                        </span>
                        <span class="menu-title-copy">Bills</span>
                    </span>
                    </Link>

                    <Link v-if="props.auth.user.user_role_id == 1 || props.auth.user.user_role_id == 0"
                        :href="route('products.index')" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                        data-kt-menu-placement="right-start" class="menu-item here show py-1"
                        :class="{ 'active': $page.url.startsWith('/products') }">
                    <span class="menu-link menu-center">
                        <span class="menu-icon-copy me-2">
                            <i class="bi bi-box2"></i>
                        </span>
                        <span class="menu-title-copy">Product</span>
                    </span>
                    </Link>



                    <Link v-if="props.auth.user.user_role_id == 1 || props.auth.user.user_role_id == 0"
                        :href="route('cart.hold.index')" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                        data-kt-menu-placement="right-start" class="menu-item here show py-1"
                        @click="setActiveRoute('cart.hold.index')"
                        :class="{ 'active': $page.url.startsWith('/saved-order') }">
                    <span class="menu-link menu-center">
                        <span class="menu-icon-copy me-2">
                            <i class="bi bi-cart-plus"></i>
                        </span>
                        <span class="menu-title-copy">Hold</span>
                    </span>
                    </Link>

                    <Link v-if="props.auth.user.user_role_id == 1 || props.auth.user.user_role_id == 0"
                        :href="route('return.index')" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                        data-kt-menu-placement="right-start" class="menu-item here show py-1"
                        @click="setActiveRoute('return.index')" :class="{ 'active': $page.url.startsWith('/returns') }">
                    <span class="menu-link menu-center">
                        <span class="menu-icon-copy me-2">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </span>
                        <span class="menu-title-copy">Return</span>
                    </span>
                    </Link>

                    <Link v-if="props.auth.user.user_role_id == 1 || props.auth.user.user_role_id == 0"
                        :href="route('receipt.credit')" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                        data-kt-menu-placement="right-start" class="menu-item here show py-1"
                        @click="setActiveRoute('receipt.credit')"
                        :class="{ 'active': $page.url.startsWith('/receipt/credit') }">
                    <span class="menu-link menu-center">
                        <span class="menu-icon-copy me-2">
                            <i class="bi bi-receipt"></i>
                        </span>
                        <span class="menu-title-copy text-center">Credit </span>
                    </span>
                    </Link>

                    <Link :href="route('stock.index')" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                        data-kt-menu-placement="right-start" class="menu-item here show py-1"
                        @click="setActiveRoute('stock.index')" :class="{ 'active': $page.url.startsWith('/stock') }">
                    <span class="menu-link menu-center">
                        <span class="menu-icon-copy me-2">
                            <i class="bi bi-boxes"></i>
                        </span>
                        <span class="menu-title-copy">Stock</span>
                    </span>
                    </Link>

                    <Link v-if="props.auth.user.user_role_id == 1 || props.auth.user.user_role_id == 0"
                        :href="route('customer.index')" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                        data-kt-menu-placement="right-start" class="menu-item here show py-1"
                        @click="setActiveRoute('customer.index')" :class="{ 'active': $page.url.startsWith('/customer') }">
                    <span class="menu-link menu-center">
                        <span class="menu-icon-copy me-2">
                            <i class="bi bi-people"></i>
                        </span>
                        <span class="menu-title-copy">Customers</span>
                    </span>
                    </Link>

                    <Link v-if="props.auth.user.user_role_id == 1" :href="route('user.index')"
                        data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start"
                        class="menu-item here show py-1" @click="setActiveRoute('user.index')"
                        :class="{ 'active': $page.url.startsWith('/user') }">
                    <span class="menu-link menu-center">
                        <span class="menu-icon-copy me-2">
                            <i class="bi bi-person"></i>
                        </span>
                        <span class="menu-title-copy">Users</span>
                    </span>
                    </Link>

                    <!-- <Link v-if="props.auth.user.user_role_id == 1" :href="route('configuration.index')"
                        data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start"
                        class="menu-item here show py-1" @click="setActiveRoute('configuration.index')"
                        :class="{ 'active': $page.url.startsWith('/configuration') }">
                    <span class="menu-link menu-center">
                        <span class="menu-icon-copy me-2">
                            <i class="bi bi-gear"></i>
                        </span>
                        <span class="menu-title-copy text-center">Settings</span>
                    </span>
                    </Link> -->



                </div>
                <!--end::Menu-->
            </div>
            <!--end::Aside Menu-->
        </div>
        <!--end::Aside menu-->

        <!-- <div class="aside-footer flex-column-auto" id="kt_aside_footer">
            <div class="d-flex justify-content-center mb-8">
                <a href="javascript:void(0)" class="btn btm-sm btn-icon btn-icon-primary" data-kt-menu-trigger="click"
                    data-kt-menu-overflow="true" data-kt-menu-placement="top-start" data-bs-placement="right"
                    data-bs-dismiss="click" aria-label="Quick actions" data-bs-original-title="Quick actions"
                    data-kt-initialized="1" data-bs-toggle="modal" data-bs-target="#contactModal">
                    <span class="menu-title-copy">Support</span>
                </a>
            </div>
        </div> -->
    </div>
</template>


<script setup>
import { Link } from '@inertiajs/vue3';
import { computed } from "vue";
import { usePage } from '@inertiajs/vue3';
import { isSidebarOpen} from '@/eventBus.js';

const { props } = usePage();

const userHasRole = computed(() => (roleName) => {
    return props.auth.user.role_name === roleName;
});


</script>

<style lang="css" scoped>

.sidebar-open {
    display: block;
}

</style>
