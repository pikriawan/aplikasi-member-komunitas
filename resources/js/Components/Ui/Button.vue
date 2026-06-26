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
            return ["primary", "outlined", "danger", "danger-outlined"].includes(value);
        }
    },
    as: {
        type: [String, Object],
        default: "button"
    }
});

const variantClasses = {
    primary: "bg-primary text-white",
    outlined: "ring ring-inset ring-primary text-primary",
    danger: "bg-danger-500 text-white",
    "danger-outlined": "ring ring-inset ring-danger-500 text-danger-500"
};

const mergedClasses = computed(() => {
    return cn("flex items-center gap-3 px-4 py-3 rounded-lg font-medium disabled:bg-onyx-50 disabled:text-onyx-800 disabled:ring-onyx-200 disabled:opacity-60", variantClasses[props.variant], props.class);
});
</script>

<template>
    <component :is="as" :class="mergedClasses">
        <slot />
    </component>
</template>
