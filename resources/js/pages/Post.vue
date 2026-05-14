<script setup>
import { Link } from "@inertiajs/vue3";
import HomeLayout from "../layouts/HomeLayout.vue";

const props = defineProps({
    post: Object,
    categories: Array
});
</script>

<template>
    <HomeLayout>
        <div class="bg-primary text-white flex p-8 lg:p-0 lg:px-4 lg:py-8 lg:justify-center">
            <div class="flex flex-col gap-4 lg:w-full lg:max-w-270 lg:flex-row lg:items-center lg:justify-between">
                <h1 class="text-2xl font-medium">Blog</h1>
                <div>
                    <Link href="/">Beranda</Link>
                    &gt;
                    <Link href="/blog">Blog</Link>
                    &gt;
                    <Link :href="`/blog?category${post.category.slug}`">{{ post.category.name }}</Link>
                    &gt;
                    <span>{{ post.title }}</span>
                </div>
            </div>
        </div>
        <div class="flex p-8 lg:p-0 lg:px-4 lg:py-6 justify-center">
            <div class="w-full lg:max-w-270 flex lg:grid lg:grid-cols-3 lg:gap-6">
                <div class="flex flex-col gap-6 lg:col-span-2">
                    <div class="flex flex-col items-start gap-6 p-6 shadow-[0_0_0_0.0625rem_#CCCCCC_inset]">
                        <p class="p-1 text-sm text-white bg-primary">{{ post.date }}</p>
                        <h2 class="font-medium text-2xl w-full">{{ post.title }}</h2>
                        <div class="w-full h-px bg-[#CCCCCC]" />
                        <div class="w-full flex flex-col gap-6 text-[#999999]" v-html="post.content" />
                        <div class="w-full flex items-center gap-2.5">
                            <div class="w-8 h-8 flex justify-center items-center">
                                <span class="w-6 h-0.5 bg-primary" />
                            </div>
                            <p class="text-[#999999]">
                                oleh
                                <strong class="font-medium">{{ post.author.name }}</strong>
                                <template v-if="post.category">
                                    dalam
                                    <strong class="font-medium">{{ post.category.name }}</strong>
                                </template>
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-col gap-6 p-6 shadow-[0_0_0_0.0625rem_#CCCCCC_inset] lg:hidden">
                        <h2 class="font-medium">Kategori</h2>
                        <div class="flex flex-col gap-2">
                            <template v-for="(c, i) in categories">
                                <Link class="font-medium text-[#999999]" :href="`/blog?category=${c.slug}`">
                                    {{ c.name }}
                                </Link>
                                <div v-if="i !== categories.length - 1" class="w-full h-px bg-[#CCCCCC]" />
                            </template>
                        </div>
                    </div>
                </div>
                <div class="h-fit hidden lg:flex flex-col gap-6 p-6 shadow-[0_0_0_0.0625rem_#CCCCCC_inset]">
                    <h2 class="font-medium">Kategori</h2>
                    <div class="flex flex-col gap-2">
                        <template v-for="(c, i) in categories">
                            <Link class="font-medium text-[#999999]" :href="`/blog?category=${c.slug}`">
                                {{ c.name }}
                            </Link>
                            <div v-if="i !== categories.length - 1" class="w-full h-px bg-[#CCCCCC]" />
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </HomeLayout>
</template>
