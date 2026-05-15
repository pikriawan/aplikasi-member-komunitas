<script setup>
import { computed, onMounted, ref } from "vue";
import Button from "../../components/Button.vue";
import MemberLayout from "../../layouts/MemberLayout.vue";
import { cn } from "../../lib/utils";
import { Form, Link, usePage } from "@inertiajs/vue3";
import Alert from "../../components/Alert.vue";

const page = usePage();

const appUrl = computed(() => page.props.appUrl);
const storageUrl = computed(() => page.props.storageUrl);
const error = computed(() => page.props.error);
const contents = computed(() => page.props.contents);

const links = computed(() => contents.value?.links?.map((link) => {
    if (link.label === "&laquo; Previous") {
        link.label = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-left-icon lucide-chevron-left"><path d="m15 18-6-6 6-6"/></svg>';
    } else if (link.label === "Next &raquo;") {
        link.label = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right-icon lucide-chevron-right"><path d="m9 18 6-6-6-6"/></svg>';
    }

    return link;
}) || []);

const type = ref("video");

onMounted(() => {
    type.value = new URLSearchParams(window.location.search).get("type") || "video";
});

const optionsShow = ref(false);
</script>

<template>
    <MemberLayout v-slot="{ setSidebarShow }">
        <header class="sticky top-0 h-14 flex items-center lg:gap-4 shadow-[0_-0.0625rem_0_#CCCCCC_inset] lg:h-20 lg:px-8 bg-white">
            <button class="h-full aspect-square flex items-center justify-center lg:hidden" @click="setSidebarShow(true)">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-menu-icon lucide-menu"><path d="M4 5h16"/><path d="M4 12h16"/><path d="M4 19h16"/></svg>
            </button>
            <h1 class="w-full font-semibold lg:text-2xl">Konten</h1>
            <!-- <div class="h-full aspect-square relative">
                <div class="fixed top-0 left-0 w-full h-full" v-if="optionsShow" @click="optionsShow = false" />
                <div class="absolute w-50 top-[calc(100%+0.5rem)] right-2 flex flex-col gap-px p-px bg-[#CCCCCC] rounded-lg font-medium shadow-[0_0.25rem_4rem_rgba(0,0,0,0.1)] lg:hidden" v-if="optionsShow">
                    <Form class="flex bg-white rounded-t-[0.4375rem]">
                        <button class="w-full h-full flex items-center gap-4 p-4">Aksi 1</button>
                    </Form>
                    <Form class="flex bg-white">
                        <button class="w-full h-full flex items-center gap-4 p-4">Aksi 2</button>
                    </Form>
                    <Form class="flex bg-white rounded-b-[0.4375rem]">
                        <button class="w-full h-full flex items-center gap-4 p-4">Aksi 3</button>
                    </Form>
                </div>
                <button class="w-full h-full flex items-center justify-center lg:hidden" @click="optionsShow = true">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ellipsis-vertical-icon lucide-ellipsis-vertical"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                </button>
            </div> -->
            <!-- <div class="shrink-0 gap-4 hidden lg:flex">
                <Button variant="outlined">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil-icon lucide-pencil"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/><path d="m15 5 4 4"/></svg>
                    Aksi 1
                </Button>
                <Button variant="danger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil-icon lucide-pencil"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/><path d="m15 5 4 4"/></svg>
                    Aksi 2
                </Button>
                <Button>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil-icon lucide-pencil"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/><path d="m15 5 4 4"/></svg>
                    Aksi 3
                </Button>
            </div> -->
        </header>
        <div class="overflow-x-auto lg:w-full lg:h-full lg:overflow-auto">
            <div class="lg:min-h-full flex flex-col justify-between gap-8 p-5 lg:p-8">
                <div class="flex flex-col gap-8" v-if="error">
                    <Alert variant="danger">{{ error }}</Alert>
                </div>
                <template v-else>
                    <div class="flex flex-col gap-8" v-if="contents.data.length > 0">
                        <div class="w-full flex gap-4">
                            <Link :class="cn('px-4 py-3 rounded-full font-medium bg-surface text-primary', type === 'video' && 'bg-primary text-white')" href="/member/contents?type=video">
                                Video
                            </Link>
                            <Link :class="cn('px-4 py-3 rounded-full font-medium bg-surface text-primary', type === 'ebook' && 'bg-primary text-white')" href="/member/contents?type=ebook">
                                Ebook
                            </Link>
                        </div>
                        <div :class="cn('flex flex-col gap-8 lg:grid', type === 'video' ? 'lg:grid-cols-3' : 'lg:grid-cols-5')">
                            <Link class="flex flex-col gap-4 justify-between" v-for="content in contents.data" :key="content.id" :href="content.file_url">
                                <div class="flex flex-col gap-4">
                                    <img :class="cn('w-full object-cover rounded-2xl', content.type === 'video' ? 'aspect-video' : 'aspect-2/3')" :src="content.thumbnail_url ? `${storageUrl}/${content.thumbnail_url}` : `${appUrl}/images/content-thumbnail-placeholder.svg`" alt="Thumbnail" />
                                    <h2 class="font-semibold text-2xl">{{ content.title }}</h2>
                                </div>
                                <span class="text-[#999999]">{{ content.date }}</span>
                            </Link>
                        </div>
                    </div>
                    <div class="flex flex-col gap-8" v-else>
                        <Alert>Tidak ada konten.</Alert>
                    </div>
                    <div class="flex flex-wrap justify-center items-center gap-4">
                        <template v-for="link in links">
                            <Link v-if="link.url" :class="cn('w-9 h-9 flex justify-center items-center text-sm rounded-lg', link.active && 'text-white bg-primary')" :href="link.url">
                                <span v-html="link.label" />
                            </Link>
                        </template>
                    </div>
                </template>
            </div>
        </div>
    </MemberLayout>
</template>
