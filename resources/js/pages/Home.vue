<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import HomeLayout from "../layouts/HomeLayout.vue";

const page = usePage();

const appUrl = page.props.appUrl;
</script>

<template>
    <HomeLayout>
        <div class="flex flex-col">
            <section class="relative flex lg:justify-center lg:items-center p-8 lg:p-0 lg:px-4 lg:h-136">
                <div class="absolute top-0 left-0 w-full h-full bg-[rgba(0,127,255,0.8)] -z-1" />
                <div class="absolute top-0 left-0 w-full h-full grayscale -z-2 bg-cover" :style="{ backgroundImage: `url('${appUrl}/images/background.jpg')` }" />
                <div class="lg:w-full lg:max-w-270">
                    <div class="flex flex-col items-start gap-8 lg:max-w-150">
                        <h1 class="font-medium text-3xl text-white">Bangun Koneksi dan Tumbuh Bersama</h1>
                        <p class="text-white">Terhubung dengan individu dari berbagai latar belakang, berbagi ide, dan membangun kolaborasi dalam komunitas inklusif untuk berkembang bersama serta menciptakan dampak nyata.</p>
                        <Link class="flex justify-start items-center gap-3 bg-black text-white px-6 py-2 rounded-full" href="/register">
                            Gabung membership
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-move-right-icon lucide-move-right"><path d="M18 8L22 12L18 16"/><path d="M2 12H22"/></svg>
                        </Link>
                    </div>
                </div>
            </section>
        </div>
    </HomeLayout>
</template>
