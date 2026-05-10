<script setup>
import { Link } from '@inertiajs/vue3';
import Header from '../components/Header.vue';
</script>

<template>
    <div class="text-[#333333]">
        <Header />
        <main class="mt-14 flex flex-col gap-4">
            <slot />
        </main>
    </div>
</template>
