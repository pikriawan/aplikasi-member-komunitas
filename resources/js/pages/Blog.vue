<script setup>
import { Form, Link, usePage } from "@inertiajs/vue3";
import HomeLayout from "../layouts/HomeLayout.vue";
import { cn } from "../lib/utils";
import { computed, onMounted, ref } from "vue";

const page = usePage();

const posts = page.props.posts;
const categories = page.props.categories;

const category = ref("");

onMounted(() => {
    category.value = new URLSearchParams(window.location.search).get("category");
});

const links = computed(() => posts.links.map((link) => {
    if (link.label === "&laquo; Previous") {
        link.label = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-left-icon lucide-chevron-left"><path d="m15 18-6-6 6-6"/></svg>';
    } else if (link.label === "Next &raquo;") {
        link.label = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right-icon lucide-chevron-right"><path d="m9 18 6-6-6-6"/></svg>';
    }

    return link;
}));
</script>

<template>
    <HomeLayout>
        <div class="bg-[#007FFF] text-white flex p-8 lg:p-0 lg:px-4 lg:py-8 lg:justify-center">
            <div class="flex flex-col gap-4 lg:w-full lg:max-w-270 lg:flex-row lg:items-center lg:justify-between">
                <h1 class="text-2xl font-medium">Blog</h1>
                <div>
                    <Link href="/">Beranda</Link>
                    &gt;
                    <Link href="/blog">Blog</Link>
                    <template v-if="category">
                        &gt;
                        {{ categories.find((c) => c.slug === category)?.name }}
                    </template>
                </div>
            </div>
        </div>
        <div class="flex p-8 lg:p-0 lg:px-4 lg:py-6 justify-center">
            <div class="w-full lg:max-w-270 flex lg:grid lg:grid-cols-3 lg:gap-6">
                <div class="h-fit hidden lg:flex flex-col gap-6 p-6 shadow-[0_0_0_0.0625rem_#CCCCCC_inset]">
                    <h2 class="font-medium">Kategori</h2>
                    <div class="flex flex-col gap-2">
                        <template v-for="(c, i) in categories">
                            <Link :class="cn('font-medium text-[#999999]', c.active && 'text-[#007FFF]')" :href="`/blog?category=${c.slug}`">
                                {{ c.name }}
                            </Link>
                            <div v-if="i !== categories.length - 1" class="w-full h-px bg-[#CCCCCC]" />
                        </template>
                    </div>
                </div>
                <div class="flex flex-col gap-6 lg:col-span-2">
                    <div class="w-full max-w-150 flex flex-col gap-4">
                        <label class="font-medium" for="search">Cari postingan</label>
                        <Form class="flex items-center gap-4">
                            <input class="w-full px-6 py-2 shadow-[0_0_0_0.0625rem_#999999_inset] placeholder-[#999999] rounded-full" id="search" type="search" placeholder="Cari postingan" />
                            <button class="flex justify-start items-center gap-3 bg-[#007FFF] text-white px-6 py-2 rounded-full">Cari</button>
                        </Form>
                    </div>
                    <div v-if="posts.data.length > 0" class="flex flex-col gap-6">
                        <Link v-for="post of posts.data" :key="post.id" class="flex flex-col items-start gap-6 p-6 shadow-[0_0_0_0.0625rem_#CCCCCC_inset]" href="#">
                            <p class="p-1 text-sm text-white bg-[#007FFF]">{{ post.date }}</p>
                            <h2 class="font-medium">{{ post.title }}</h2>
                            <div class="w-full h-px bg-[#CCCCCC]" />
                            <p class="text-[#999999]">{{ post.description }}</p>
                        </Link>
                    </div>
                    <p v-else>Tidak ada postingan.</p>
                    <div class="flex justify-center items-center gap-4">
                        <template v-for="link in links">
                            <Link v-if="link.url" :class="cn('w-10 h-10 flex justify-center items-center shadow-[0_0_0_0.0625rem_#CCCCCC_inset] font-medium text-[#999999]', link.active && 'text-[#007FFF]')" :href="link.url">
                                <span v-html="link.label" />
                            </Link>
                        </template>
                    </div>
                    <div class="flex flex-col gap-6 p-6 shadow-[0_0_0_0.0625rem_#CCCCCC_inset] lg:hidden">
                        <h2 class="font-medium">Kategori</h2>
                        <div class="flex flex-col gap-2">
                            <template v-for="(c, i) in categories">
                                <Link :class="cn('font-medium text-[#999999]', c.active && 'text-[#007FFF]')" :href="`/blog?category=${c.slug}`">
                                    {{ c.name }}
                                </Link>
                                <div v-if="i !== categories.length - 1" class="w-full h-px bg-[#CCCCCC]" />
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </HomeLayout>
</template>
