<script setup>
import { computed, onMounted, ref } from "vue";
import HomeLayout from "../layouts/HomeLayout.vue";
import { cn } from "../lib/utils";
import { Form, Link } from "@inertiajs/vue3";

const props = defineProps({
    posts: Object
});

const posts = props.posts;

const search = ref("");

onMounted(() => {
    search.value = new URLSearchParams(window.location.search).get("q");
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
        <div class="bg-primary text-white flex p-8 lg:p-0 lg:px-4 lg:py-8 lg:justify-center">
            <div class="flex flex-col gap-4 lg:w-full lg:max-w-270 lg:flex-row lg:items-center lg:justify-between">
                <h1 class="text-2xl font-medium">Hasil pencarian untuk: {{ search }}</h1>
                <div>
                    <Link href="/">Beranda</Link>
                    &gt;
                    <Link href="/blog">Blog</Link>
                    &gt;
                    Hasil pencarian untuk: {{ search }}
                </div>
            </div>
        </div>
        <div class="flex p-8 lg:p-0 lg:px-4 lg:py-6 justify-center">
            <div class="w-full lg:max-w-270 flex flex-col gap-6">
                <Form class="w-full max-w-150 flex flex-col gap-4" action="/blog/search" method="get">
                    <label class="font-medium" for="search">Cari postingan</label>
                    <div class="flex items-center gap-4">
                        <input class="w-full px-6 py-2 shadow-[0_0_0_0.0625rem_#999999_inset] placeholder-[#999999] rounded-full" id="search" name="q" type="search" placeholder="Cari postingan" :value="search" />
                        <button class="flex justify-start items-center gap-3 bg-primary text-white px-6 py-2 rounded-full">Cari</button>
                    </div>
                </Form>
                <div v-if="posts.data.length > 0" class="w-full flex flex-col gap-6">
                    <template v-for="(post, i) in posts.data" :key="post.id">
                        <Link class="flex flex-col gap-6" :href="`/blog/posts/${post.slug}`">
                            <h2 class="font-medium">{{ post.title }}</h2>
                            <p class="text-[#999999]">{{ post.description }}</p>
                        </Link>
                        <div v-if="i !== posts.data.length - 1" class="w-full h-px bg-[#CCCCCC]" />
                    </template>
                </div>
                <p v-else>Postingan tidak ditemukan.</p>
                <div class="flex justify-center items-center gap-4">
                    <template v-for="link in links">
                        <Link v-if="link.url" :class="cn('w-10 h-10 flex justify-center items-center shadow-[0_0_0_0.0625rem_#CCCCCC_inset] font-medium text-[#999999]', link.active && 'text-primary')" :href="link.url">
                            <span v-html="link.label" />
                        </Link>
                    </template>
                </div>
            </div>
        </div>
    </HomeLayout>
</template>
