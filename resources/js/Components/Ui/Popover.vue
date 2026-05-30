<script setup>
import { computed, provide, ref } from "vue";
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
    return cn("relative", props.class);
});

const visible = ref(false);

function setVisible(value) {
    visible.value = value;
}

provide("popover", { visible, setVisible });
</script>

<template>
    <component :is="as" :class="mergedClasses">
        <slot />
    </component>
</template>
