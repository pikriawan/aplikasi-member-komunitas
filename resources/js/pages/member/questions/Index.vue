<script setup>
import { computed, onMounted, ref } from "vue";
import Button from "../../../components/Button.vue";
import MemberLayout from "../../../layouts/MemberLayout.vue";
import { cn } from "../../../lib/utils";
import { Form, Link, usePage } from "@inertiajs/vue3";
import Alert from "../../../components/Alert.vue";

const page = usePage();

const appUrl = computed(() => page.props.appUrl);
const storageUrl = computed(() => page.props.storageUrl);
const error = computed(() => page.props.error);
const conversations = computed(() => page.props.conversations);

const links = computed(() => conversations.value?.links?.map((link) => {
    if (link.label === "&laquo; Previous") {
        link.label = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-left-icon lucide-chevron-left"><path d="m15 18-6-6 6-6"/></svg>';
    } else if (link.label === "Next &raquo;") {
        link.label = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right-icon lucide-chevron-right"><path d="m9 18 6-6-6-6"/></svg>';
    }

    return link;
}) || []);

const optionsShow = ref(false);
</script>

<template>
    <MemberLayout v-slot="{ setSidebarShow }">
        <header class="sticky top-0 h-14 flex items-center lg:gap-4 shadow-[0_-0.0625rem_0_#CCCCCC_inset] lg:h-20 lg:px-8 bg-white">
            <button class="h-full aspect-square flex items-center justify-center lg:hidden" @click="setSidebarShow(true)">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-menu-icon lucide-menu"><path d="M4 5h16"/><path d="M4 12h16"/><path d="M4 19h16"/></svg>
            </button>
            <h1 class="w-full font-semibold lg:text-2xl">Pertanyaan</h1>
            <div class="h-full aspect-square relative">
                <div class="fixed top-0 left-0 w-full h-full" v-if="optionsShow" @click="optionsShow = false" />
                <div class="absolute w-50 top-[calc(100%+0.5rem)] right-2 flex flex-col gap-px p-px bg-[#CCCCCC] rounded-lg font-medium shadow-[0_0.25rem_4rem_rgba(0,0,0,0.1)] lg:hidden" v-if="optionsShow">
                    <Link class="flex bg-white rounded-[0.4375rem] items-center gap-4 p-4" href="/member/questions/create">
                        Buat pertanyaan baru
                    </Link>
                </div>
                <button class="w-full h-full flex items-center justify-center lg:hidden" @click="optionsShow = true">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ellipsis-vertical-icon lucide-ellipsis-vertical"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                </button>
            </div>
            <div class="shrink-0 gap-4 hidden lg:flex">
                <Button :tag="Link" href="/member/questions/create">
                    Buat pertanyaan baru
                </Button>
            </div>
        </header>
        <div class="overflow-x-auto lg:w-full lg:h-full lg:overflow-auto">
            <div class="lg:min-h-full flex flex-col justify-between gap-8 p-5 lg:p-8">
                <div class="flex flex-col gap-8" v-if="error">
                    <Alert variant="danger">{{ error }}</Alert>
                </div>
                <template v-else>
                    <div class="flex flex-col items-center gap-8" v-if="conversations.data.length > 0">
                        <div class="w-full lg:max-w-150 flex flex-col gap-8">
                            <Link class="flex flex-col gap-4 p-6 items-start rounded-2xl shadow-[0_0_0_0.0625rem_#CCCCCC_inset]" v-for="conversation in conversations.data" :key="conversation.id" :href="`/member/questions/${conversation.ticket_number}`">
                                <span class="w-full">#{{ conversation.ticket_number }}</span>
                                <h2 class="w-full font-semibold text-2xl">{{ conversation.title }}</h2>
                                <span class="w-full text-[#999999]">{{ conversation.date }}</span>
                                <span class="px-2 py-1 rounded font-medium text-[0.75rem] text-[#03C93E] bg-[#E6FFED]" v-if="conversation.is_closed">Selesai</span>
                                <span class="px-2 py-1 rounded font-medium text-[0.75rem] text-[#FF5100] bg-[#FFEEE5]" v-else>Belum selesai</span>
                            </Link>
                        </div>
                    </div>
                    <div class="flex flex-col gap-8" v-else>
                        <Alert>Tidak ada pertanyaan.</Alert>
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
