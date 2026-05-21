<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import PillButton from "../Components/Ui/PillButton.vue";
import HomeLayout from "../Layouts/HomeLayout.vue";

const page = usePage();

const appUrl = computed(() => page.props.appUrl);
const storageUrl = computed(() => page.props.storageUrl);
const setting = computed(() => page.props.setting);
</script>

<template>
    <HomeLayout>
        <main class="relative p-8 lg:h-136 lg:p-0 lg:px-4 lg:flex lg:justify-center lg:items-center">
            <img class="absolute top-0 left-0 w-full h-full object-cover saturate-0 -z-2" :src="setting.background_image ? `${storageUrl}/${setting.background_image}` : `${appUrl}/images/background.jpg`" alt="Background">
            <div class="absolute top-0 left-0 w-full h-full -z-1 bg-primary opacity-80" />
            <div class="lg:w-full lg:max-w-270">
                <div class="flex flex-col gap-8 items-start lg:max-w-150">
                    <h1 class="font-medium text-3xl text-white">{{ setting.hero_title || "Bangun Koneksi dan Tumbuh Bersama" }}</h1>
                    <p class="text-white">{{ setting.hero_description || "Terhubung dengan individu dari berbagai latar belakang, berbagi ide, dan membangun kolaborasi dalam komunitas inklusif untuk berkembang bersama serta menciptakan dampak nyata." }}</p>
                    <PillButton :as="Link" :href="route('register')" class="bg-black">
                        Gabung Membership
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-move-right-icon lucide-move-right"><path d="M18 8L22 12L18 16"/><path d="M2 12H22"/></svg>
                    </PillButton>
                </div>
            </div>
        </main>
    </HomeLayout>
</template>
