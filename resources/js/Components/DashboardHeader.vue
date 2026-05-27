<script setup>
import { Link } from "@inertiajs/vue3";
import { inject } from "vue";

defineProps({
    title: {
        type: [String, null]
    },
    backHref: {
        type: [String, null]
    }
});

const sidebar = inject("sidebar");
</script>

<template>
    <header class="sticky top-0 z-1 h-20 flex items-center justify-between lg:px-8 bg-white shadow-[0_-0.0625rem_0_var(--color-onyx-200)_inset]">
        <div class="h-full flex items-center">
            <button v-if="!backHref" class="lg:hidden h-full aspect-square flex justify-center items-center" @click="sidebar.setSidebarVisible(true)">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-menu-icon lucide-menu"><path d="M4 5h16"/><path d="M4 12h16"/><path d="M4 19h16"/></svg>
            </button>
            <Link v-if="backHref" :href="backHref" class="h-full aspect-square flex justify-center items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-left-icon lucide-chevron-left"><path d="m15 18-6-6 6-6"/></svg>
            </Link>
            <h1 v-if="title" class="font-semibold lg:text-2xl">{{ title }}</h1>
        </div>
        <slot />
    </header>
</template>
