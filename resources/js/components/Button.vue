<script setup>
import { cn } from "../lib/utils";
import { computed } from "vue";

const props = defineProps({
    variant: String,
    justify: String
});

const variantClasses = computed(() => {
    switch (props.variant) {
        case "outlined":
            return "text-primary shadow-[0_0_0_0.0625rem_var(--color-primary)_inset]";
        case "danger":
            return "bg-[#FF0800] text-white";
        case "danger-outlined":
            return "text-[#FF0800] shadow-[0_0_0_0.0625rem_#FF0800_inset]";
        default:
            return "bg-primary text-white";
    }
});

const justifyClass = computed(() => {
    switch (props.justify) {
        case "center":
            return "justify-center";
        case "end":
            return "justify-end";
    }
});
</script>

<template>
    <button :class="cn('flex items-center gap-3 px-4 py-3 rounded-lg font-medium', variantClasses, justifyClass)" v-bind="props">
        <slot />
    </button>
</template>
