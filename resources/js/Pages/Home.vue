<script setup>
import { usePage } from "@inertiajs/vue3";
import { computed, watchEffect } from "vue";

const page = usePage();

const setting = computed(() => page.props.setting);

watchEffect(() => {
    console.log(setting.value);
});
</script>

<template>
    <div class="flex flex-col gap-4 p-4">
        <h1 class="font-semibold text-2xl">{{ setting.community_logo || "Logo" }}</h1>
    </div>
</template>
