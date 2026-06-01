<script setup>
import { provide, ref } from "vue";

const visible = ref(false);

function setVisible(value) {
    visible.value = value;
}

provide("modal", { visible, setVisible });
</script>

<template>
    <slot />
</template>
