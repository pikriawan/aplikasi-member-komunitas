<script setup>
import { computed, inject } from "vue";
import { cn } from "../../lib/utils";

const props = defineProps({
    class: {
        type: String,
        default: ""
    },
    as: {
        type: [String, Object],
        default: "div"
    }
});

const mergedClasses = computed(() => {
    return cn("absolute", props.class);
});

const popover = inject("popover");
</script>

<template>
    <component :is="as" :class="mergedClasses" v-if="popover.visible.value">
        <slot />
    </component>
</template>
