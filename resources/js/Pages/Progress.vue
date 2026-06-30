<script setup>
import { progress } from "@inertiajs/vue3";

function load() {
    progress.start();

    for (let i = 0; i < 100; i++) {
        setTimeout(() => {
            progress.set(i * 0.01);
        }, i * 100);
    }
}
</script>

<template>
    <button @click="load">Load</button>
</template>
