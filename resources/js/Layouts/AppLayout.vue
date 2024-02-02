<template>
    <Head :title="title ? title : 'M Mobile'">
        <link rel="icon" type="image/jpg" href="/logo/logo_favicon.jpg">
        <slot name="meta_head" />
    </Head>

    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <SideBar />
            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <NavBar />
                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::Post-->
                    <div class="post d-flex flex-column-fluid" id="kt_post">
                        <!--begin::Container-->
                        <div id="kt_content_container" class="container-fluid">
                            <slot name="header" />
                            <slot name="content" />
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Post-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Wrapper-->
            <slot name="modal" />
            <slot name="loader" />
        </div>
        <!--end::Page-->
    </div>
</template>

<script setup>
import { onMounted, ref, defineProps  } from 'vue';
import { Head } from '@inertiajs/vue3';
import NavBar from '@/Components/Main/NavBar.vue';
import SideBar from '@/Components/Main/SideBar.vue';
import { usePage } from '@inertiajs/vue3';
import Loader from '@/Components/Basic/LoadingBar.vue';

const isSidebarExpanded = ref(false);

const props = defineProps({
  title: String,
});

const toggleSidebar = () => {
    isSidebarExpanded.value = true;
};

const closeSidebar = () => {
    isSidebarExpanded.value = false;
};
</script>

<style lang="scss">
body {
    background-image: url("/img/banner/bg.png");
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    height: 100vh;
}

.table-responsive {
    overflow: auto;
}

.page-top{
    margin-top: 53px;
}
</style>
