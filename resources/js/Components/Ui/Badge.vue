<script setup>
import { computed } from "vue";
import { cn } from "../../lib/utils";

const props = defineProps({
    class: {
        type: String,
        default: ""
    },
    variant: {
        type: String,
        default: "primary",
        validator(value) {
            return ["primary", "info", "success", "warning", "danger"].includes(value);
        }
    },
    as: {
        type: [String, Object],
        default: "span"
    }
});

const variantClasses = {
    primary: "bg-surface text-primary",
    info: "bg-info-50 text-info-500",
    success: "bg-success-50 text-success-600",
    warning: "bg-warning-50 text-warning-500",
    danger: "bg-danger-50 text-danger-500"
};

const mergedClasses = computed(() => {
    return cn("px-2 py-1 rounded font-medium text-[0.75rem]", variantClasses[props.variant], props.class);
});
</script>

<template>
    <component :is="as" :class="mergedClasses">
        <slot />
    </component>
</template>
