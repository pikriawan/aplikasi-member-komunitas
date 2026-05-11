<script setup>
import { usePage } from "@inertiajs/vue3";
import HomeLayout from "../layouts/HomeLayout.vue";

const page = usePage();
console.log(page.props.posts);
</script>

<template>
    <HomeLayout>
        Blog
    </HomeLayout>
</template>
