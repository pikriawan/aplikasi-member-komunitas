<script setup>
import { cn } from "../lib/utils";
import { Form, Link, usePage } from "@inertiajs/vue3";
import { computed, provide, ref } from "vue";

const page = usePage();

const appUrl = computed(() => page.props.appUrl);
const storageUrl = computed(() => page.props.storageUrl);
const settings = computed(() => page.props.settings);
const user = computed(() => page.props.auth?.user);
const memberProfile = computed(() => page.props.memberProfile);

const pathname = computed(() => page.url);

const sidebarShow = ref(false);

function setSidebarShow(value) {
    sidebarShow.value = value;
}

const mobileProfileMenuShow = ref(false);
const desktopProfileMenuShow = ref(false);
</script>

<template>
    <div
        class="w-full h-full fixed top-0 left-0 bg-black opacity-40 z-1 lg:hidden"
        v-if="sidebarShow"
        @click="() => {
            sidebarShow = false;
            mobileProfileMenuShow = false;
        }"
    />
    <aside class="w-3/4 max-w-90 h-full fixed top-0 left-0 bg-white z-2 flex flex-col font-geist text-[#333333] lg:hidden" v-if="sidebarShow">
        <header class="shrink-0 h-14 flex items-center px-8 shadow-[0_-0.0625rem_0_#CCCCCC_inset]">
            <img :src="settings?.community_logo ? `${storageUrl}/${settings.community_logo}` : `${appUrl}/images/community-logo.svg`" alt="Logo" width="46" />
        </header>
        <div class="h-full flex flex-col justify-between p-8">
            <nav class="flex flex-col">
                <Link :class="cn('flex items-center gap-4 p-4 rounded-lg font-medium', pathname === '/member/contents' && 'text-primary bg-surface')" href="/member/contents">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-play-icon lucide-circle-play"><path d="M9 9.003a1 1 0 0 1 1.517-.859l4.997 2.997a1 1 0 0 1 0 1.718l-4.997 2.997A1 1 0 0 1 9 14.996z"/><circle cx="12" cy="12" r="10"/></svg>
                    Konten
                </Link>
                <Link :class="cn('flex items-center gap-4 p-4 rounded-lg font-medium', pathname === '/member/questions' && 'text-primary bg-surface')" href="/member/questions">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-circle-more-icon lucide-message-circle-more"><path d="M2.992 16.342a2 2 0 0 1 .094 1.167l-1.065 3.29a1 1 0 0 0 1.236 1.168l3.413-.998a2 2 0 0 1 1.099.092 10 10 0 1 0-4.777-4.719"/><path d="M8 12h.01"/><path d="M12 12h.01"/><path d="M16 12h.01"/></svg>
                    Pertanyaan
                </Link>
                <Link :class="cn('flex items-center gap-4 p-4 rounded-lg font-medium', pathname === '/member/payments' && 'text-primary bg-surface')" href="/member/payments">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-credit-card-icon lucide-credit-card"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>
                    Pembayaran
                </Link>
            </nav>
            <div class="flex flex-col gap-4">
                <Link class="flex items-center gap-4 p-4 text-white bg-primary rounded-lg font-medium" v-if="!memberProfile?.is_active" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap-icon lucide-zap"><path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"/></svg>
                    Premium
                </Link>
                <div class="relative select-none">
                    <div class="absolute top-0 left-0 -translate-y-full w-50 flex flex-col gap-px p-px bg-[#CCCCCC] rounded-lg shadow-[0_0.25rem_4rem_rgba(0,0,0,0.1)] lg:hidden" v-if="mobileProfileMenuShow">
                        <Link class="flex items-center gap-4 p-4 font-medium bg-white rounded-t-[0.4375rem]" href="/member/profile">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-icon lucide-user"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            Profil
                        </Link>
                        <Form class="font-medium bg-white rounded-b-[0.4375rem] text-[#FF0800]" action="/logout" method="post">
                            <button class="flex items-center gap-4 p-4 w-full h-full cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-out-icon lucide-log-out"><path d="m16 17 5-5-5-5"/><path d="M21 12H9"/><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/></svg>
                                Logout
                            </button>
                        </Form>
                    </div>
                    <div class="flex items-center gap-4 cursor-pointer" @click="mobileProfileMenuShow = !mobileProfileMenuShow">
                        <img class="rounded-full object-cover" :src="memberProfile?.image_url ? `${storageUrl}/${memberProfile.image_url}` : `${appUrl}/images/member-profile-image-placeholder.svg`" alt="" width="48" height="48" />
                        <div class="w-full flex flex-col items-start gap-4">
                            <span class="w-full">{{ user?.name }}</span>
                            <span class="px-2 py-1 font-medium text-[0.75rem] text-primary bg-surface rounded">{{ memberProfile?.is_active ? "Member Premium" : "Member" }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </aside>
    <div class="font-geist text-[#333333] lg:fixed lg:top-0 lg:left-0 lg:w-full lg:h-full lg:grid lg:grid-cols-[22.5rem_1fr] lg:grid-rows-1">
        <aside class="bg-white flex-col font-geist text-[#333333] shadow-[-0.0625rem_0_0_#CCCCCC_inset] hidden lg:flex">
            <header class="shrink-0 h-20 flex items-center px-8 shadow-[0_-0.0625rem_0_#CCCCCC_inset]">
                <img :src="settings?.community_logo ? `${storageUrl}/${settings.community_logo}` : `${appUrl}/images/community-logo.svg`" alt="Logo" width="46" />
            </header>
            <div class="h-full flex flex-col justify-between p-8">
                <nav class="flex flex-col">
                    <Link :class="cn('flex items-center gap-4 p-4 rounded-lg font-medium', pathname === '/member/contents' && 'text-primary bg-surface')" href="/member/contents">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-play-icon lucide-circle-play"><path d="M9 9.003a1 1 0 0 1 1.517-.859l4.997 2.997a1 1 0 0 1 0 1.718l-4.997 2.997A1 1 0 0 1 9 14.996z"/><circle cx="12" cy="12" r="10"/></svg>
                        Konten
                    </Link>
                    <Link :class="cn('flex items-center gap-4 p-4 rounded-lg font-medium', pathname === '/member/questions' && 'text-primary bg-surface')" href="/member/questions">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-circle-more-icon lucide-message-circle-more"><path d="M2.992 16.342a2 2 0 0 1 .094 1.167l-1.065 3.29a1 1 0 0 0 1.236 1.168l3.413-.998a2 2 0 0 1 1.099.092 10 10 0 1 0-4.777-4.719"/><path d="M8 12h.01"/><path d="M12 12h.01"/><path d="M16 12h.01"/></svg>
                        Pertanyaan
                    </Link>
                    <Link :class="cn('flex items-center gap-4 p-4 rounded-lg font-medium', pathname === '/member/payments' && 'text-primary bg-surface')" href="/member/payments">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-credit-card-icon lucide-credit-card"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>
                        Pembayaran
                    </Link>
                </nav>
                <div class="flex flex-col gap-4">
                    <Link class="flex items-center gap-4 p-4 text-white bg-primary rounded-lg font-medium" v-if="!memberProfile?.is_active" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap-icon lucide-zap"><path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"/></svg>
                        Premium
                    </Link>
                    <div class="relative select-none">
                        <div class="absolute top-0 left-0 -translate-y-full w-50 flex-col gap-px p-px bg-[#CCCCCC] rounded-lg shadow-[0_0.25rem_4rem_rgba(0,0,0,0.1)] hidden lg:flex" v-if="desktopProfileMenuShow">
                            <Link class="flex items-center gap-4 p-4 font-medium bg-white rounded-t-[0.4375rem]" href="/member/profile">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-icon lucide-user"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                Profil
                            </Link>
                            <Form class="font-medium bg-white rounded-b-[0.4375rem] text-[#FF0800]" action="/logout" method="post">
                                <button class="flex items-center gap-4 p-4 w-full h-full cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-out-icon lucide-log-out"><path d="m16 17 5-5-5-5"/><path d="M21 12H9"/><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/></svg>
                                    Logout
                                </button>
                            </Form>
                        </div>
                        <div class="flex items-center gap-4 cursor-pointer" @click="desktopProfileMenuShow = !desktopProfileMenuShow">
                            <img class="rounded-full object-cover" :src="memberProfile?.image_url ? `${storageUrl}/${memberProfile.image_url}` : `${appUrl}/images/member-profile-image-placeholder.svg`" alt="" width="48" height="48" />
                            <div class="w-full flex flex-col items-start gap-4">
                                <span class="w-full">{{ user?.name }}</span>
                                <span class="px-2 py-1 font-medium text-[0.75rem] text-primary bg-surface rounded">{{ memberProfile?.is_active ? "Member Premium" : "Member" }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
        <div class="lg:w-full lg:h-full lg:grid lg:grid-cols-1 lg:grid-rows-[5rem_1fr]">
            <slot :sidebarShow="sidebarShow" :setSidebarShow="setSidebarShow" />
        </div>
    </div>
</template>
