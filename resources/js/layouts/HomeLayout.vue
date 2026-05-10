<script setup>
import { Link } from "@inertiajs/vue3";
import Header from "../components/Header.vue";
import Footer from "../components/Footer.vue";
</script>

<template>
    <Header />
    <main>
        <slot />
    </main>
    <Footer />
</template>
