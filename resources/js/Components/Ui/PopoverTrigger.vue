<script setup>
import { inject } from "vue";

defineProps({
    as: {
        type: [String, Object],
        default: "button"
    }
});

const popover = inject("popover");
</script>

<template>
    <component :is="as" @click="popover.setVisible(!popover.visible.value)">
        <slot />
    </component>
</template>
