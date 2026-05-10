<script setup>
import { Link } from '@inertiajs/vue3';
import Header from '../components/Header.vue';
</script>

<template>
    <Header />
    <main>
        <slot />
    </main>
</template>
