<script setup>
import { computed, ref } from "vue";
import { cn } from "../../lib/utils";

const props = defineProps({
    class: {
        type: String,
        default: ""
    },
    variant: {
        type: String,
        default: "info",
        validator(value) {
            return ["info", "success", "warning", "danger"].includes(value);
        }
    },
});

const variantClasses = {
    info: "bg-info-50 text-info-500 ring-info-100",
    success: "bg-success-50 text-success-600 ring-success-100",
    warning: "bg-warning-50 text-warning-500 ring-warning-100",
    danger: "bg-danger-50 text-danger-500 ring-danger-100"
};

const mergedClasses = computed(() => {
    return cn("flex items-center gap-4 p-6 ring ring-inset rounded-lg", variantClasses[props.variant], props.class);
});

const visible = ref(true);
</script>

<template>
    <div v-if="visible" :class="mergedClasses">
        <p class="w-full">
            <slot />
        </p>
        <button class="shrink-0" @click="visible = false">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-icon lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
        </button>
    </div>
</template>
