<script setup>
import { cn } from "../lib/utils";
import { computed, ref } from "vue";

const props = defineProps({
    variant: String
});

const show = ref(true);

const variantClasses = computed(() => {
    switch (props.variant) {
        case "success":
            return "bg-[#E6FFED] text-[#03C93E] shadow-[0_0_0_0.0625rem_#CDFEDC_inset]";
        case "warning":
            return "bg-[#FFEEE5] text-[#FF5100] shadow-[0_0_0_0.0625rem_#FFDCCC_inset]";
        case "danger":
            return "bg-[#FFE6E5] text-[#FF0900] shadow-[0_0_0_0.0625rem_#FFCECC_inset]";
        default:
            return "bg-[#E5F2FF] text-[#007FFF] shadow-[0_0_0_0.0625rem_#CCE5FF_inset]";
    }
});
</script>

<template>
    <div :class="cn('w-full flex items-center gap-6 p-6 rounded-lg', variantClasses)" v-if="show" v-bind="props">
        <div class="w-full">
            <slot />
        </div>
        <button class="flex items-center justify-center" @click="show = false">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-icon lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
        </button>
    </div>
</template>
