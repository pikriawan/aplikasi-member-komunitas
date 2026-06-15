<script setup>
import { computed, ref } from "vue";
import { cn } from "../../lib/utils";

defineOptions({
    inheritAttrs: false
});

defineEmits(["update:modelValue"]);

const props = defineProps({
    class: {
        type: String,
        default: ""
    },
    type: {
        type: String,
        default: "text"
    },
    as: {
        type: String,
        default: "input",
        validator(value) {
            return ["input", "textarea"].includes(value);
        }
    },
    modelValue: {
        type: String,
        default: ""
    }
});

const mergedClasses = computed(() => {
    return cn(
        "px-4 py-3 rounded-lg ring ring-inset ring-onyx-200 disabled:bg-onyx-50 disabled:text-onyx-800 disabled:ring-onyx-200 disabled:opacity-60",
        props.type === "password" && "w-full",
        props.as === "textarea" && "min-h-32",
        props.class
    );
});

const passwordVisible = ref(false);
</script>

<template>
    <div v-if="type === 'password'" class="relative">
        <input
            :type="passwordVisible ? 'text' : 'password'"
            :class="mergedClasses"
            v-model="model"
            v-bind="$attrs"
        >
        <button type="button" class="absolute top-0 right-0 h-full aspect-square flex justify-center items-center" @click="passwordVisible = !passwordVisible">
            <svg v-if="passwordVisible" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-off-icon lucide-eye-off"><path d="M10.733 5.076a10.744 10.744 0 0 1 11.205 6.575 1 1 0 0 1 0 .696 10.747 10.747 0 0 1-1.444 2.49"/><path d="M14.084 14.158a3 3 0 0 1-4.242-4.242"/><path d="M17.479 17.499a10.75 10.75 0 0 1-15.417-5.151 1 1 0 0 1 0-.696 10.75 10.75 0 0 1 4.446-5.143"/><path d="m2 2 20 20"/></svg>
            <svg v-else xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-icon lucide-eye"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>
        </button>
    </div>
    <template v-else>
        <input v-if="as === 'input'" :type="type" :class="mergedClasses" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" v-bind="$attrs">
        <textarea v-else :class="mergedClasses" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" v-bind="$attrs" />
    </template>
</template>
