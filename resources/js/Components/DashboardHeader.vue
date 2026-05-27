<script setup>
import { inject } from "vue";

const sidebar = inject("sidebar");
</script>

<template>
    <button @click="sidebar.setSidebarVisible(true)">Open sidebar</button>
</template>
