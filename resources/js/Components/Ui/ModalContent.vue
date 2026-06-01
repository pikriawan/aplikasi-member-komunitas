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
    return cn("fixed top-4 left-4 w-[calc(100%-2rem)] lg:w-auto lg:top-1/2 lg:left-1/2 lg:-translate-1/2 z-3 bg-white p-5 rounded-2xl", props.class);
});

const modal = inject("modal");
</script>

<template>
    <template v-if="modal.visible.value">
        <Teleport to="body">
            <div class="fixed top-0 left-0 w-full h-full z-2 bg-[rgba(0,0,0,0.2)]" @click="modal.setVisible(false)" />
            <component :is="as" :class="mergedClasses" v-bind="$attrs">
                <slot />
            </component>
        </Teleport>
    </template>
</template>
