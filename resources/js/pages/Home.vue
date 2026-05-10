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
            <section class="flex lg:justify-center lg:items-center p-8 lg:p-0 lg:px-4 lg:py-16">
                <div class="lg:w-full lg:max-w-270 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">
                    <img class="w-full lg:w-80 aspect-square object-cover" :src="`${appUrl}/images/earth.jpg`" />
                    <div class="lg:w-full lg:max-w-150 flex flex-col gap-6">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 flex items-center justify-center">
                                <span class="w-6 h-0.5 bg-[#007FFF]" />
                            </div>
                            <h2 class="font-medium text-2xl w-full">Tentang</h2>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8" />
                            <p class="text-[#999999] w-full">
                                Komunitas ini adalah ruang terbuka bagi siapa saja yang ingin belajar, berkembang, dan saling terhubung dalam lingkungan yang positif dan kolaboratif. Kami menghadirkan berbagai kesempatan untuk bertukar wawasan, membangun relasi, serta berpartisipasi dalam kegiatan yang mendorong pertumbuhan pribadi maupun profesional.
                                <br />
                                Dengan semangat kebersamaan, kami percaya bahwa setiap individu memiliki potensi untuk memberikan kontribusi dan menciptakan dampak yang berarti. Di sini, kamu tidak hanya menjadi bagian dari komunitas, tetapi juga bagian dari perjalanan untuk tumbuh dan berkembang bersama.
                            </p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </HomeLayout>
</template>
