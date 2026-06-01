<script setup>
import { inject } from "vue";

defineProps({
    as: {
        type: [String, Object],
        default: "button"
    }
});

const modal = inject("modal");
</script>

<template>
    <component :is="as" @click="modal.setVisible(false)">
        <slot />
    </component>
</template>
