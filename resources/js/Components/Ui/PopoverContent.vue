<script setup>
import { computed, inject } from "vue";
import { cn } from "../../lib/utils";

defineOptions({
    inheritAttrs: false
});

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
    return cn("absolute z-2 min-w-50 p-px rounded-lg bg-white shadow-[0_0_0_0.0625rem_var(--color-onyx-200)_inset,0_0.25rem_4rem_rgba(0,0,0,0.1)]", props.class);
});

const popover = inject("popover");
</script>

<template>
    <template v-if="popover.visible.value">
        <div class="fixed top-0 left-0 w-full h-full z-1" @click="popover.setVisible(false)" />
        <component :is="as" :class="mergedClasses" v-bind="$attrs">
            <slot />
        </component>
    </template>
</template>
