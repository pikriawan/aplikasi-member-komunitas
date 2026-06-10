<script setup>
import { Form, Link, usePage } from "@inertiajs/vue3";
import { computed, provide, ref } from "vue";
import Badge from "../Components/Ui/Badge.vue";
import Button from "../Components/Ui/Button.vue";
import Popover from "../Components/Ui/Popover.vue";
import PopoverContent from "../Components/Ui/PopoverContent.vue";
import PopoverTrigger from "../Components/Ui/PopoverTrigger.vue";
import { cn } from "../lib/utils";

const page = usePage();

const appUrl = computed(() => page.props.appUrl);
const storageUrl = computed(() => page.props.storageUrl);
const setting = computed(() => page.props.setting);
const user = computed(() => page.props.user);
const memberProfile = computed(() => page.props.memberProfile);

const sidebarVisible = ref(false);

function setSidebarVisible(value) {
    sidebarVisible.value = value;
}

provide("sidebar", { setSidebarVisible });
</script>

<template>
    <div class="font-geist lg:w-full lg:h-screen lg:grid lg:grid-cols-[22.5rem_1fr] lg:grid-rows-[5rem_1fr]">
        <aside :class="cn('fixed top-0 -left-full lg:static lg:top-auto lg:left-auto lg:row-span-2 z-2 w-full lg:w-auto h-full lg:h-auto flex flex-col bg-white shadow-[-0.0625rem_0_0_var(--color-onyx-200)_inset] transition-[left_var(--default-transition-timing-function)_var(--default-transition-duration)]', sidebarVisible && 'left-0')">
            <header class="w-full h-20 shrink-0 flex items-center justify-between px-8 shadow-[0_-0.0625rem_0_var(--color-onyx-200)_inset]">
                <img :src="setting.community_logo ? `${storageUrl}/${setting.community_logo}` : `${appUrl}/images/community-logo.svg`" alt="Brand">
                <button class="lg:hidden" @click="setSidebarVisible(false)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-icon lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                </button>
            </header>
            <div class="w-full h-full flex flex-col justify-between p-8">
                <nav class="w-full flex flex-col">
                    <Link :class="cn('w-full flex items-center gap-4 p-4 rounded-lg font-medium', route().current() === 'member.contents.index' && 'bg-surface text-primary')" :href="route('member.contents.index')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-play-icon lucide-circle-play shrink-0"><path d="M9 9.003a1 1 0 0 1 1.517-.859l4.997 2.997a1 1 0 0 1 0 1.718l-4.997 2.997A1 1 0 0 1 9 14.996z"/><circle cx="12" cy="12" r="10"/></svg>
                        Konten
                    </Link>
                    <Link :class="cn('w-full flex items-center gap-4 p-4 rounded-lg font-medium', route().current() === 'member.conversation.index' && 'bg-surface text-primary')" :href="route('member.conversation.index')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-circle-more-icon lucide-message-circle-more shrink-0"><path d="M2.992 16.342a2 2 0 0 1 .094 1.167l-1.065 3.29a1 1 0 0 0 1.236 1.168l3.413-.998a2 2 0 0 1 1.099.092 10 10 0 1 0-4.777-4.719"/><path d="M8 12h.01"/><path d="M12 12h.01"/><path d="M16 12h.01"/></svg>
                        Pertanyaan
                    </Link>
                    <Link :class="cn('w-full flex items-center gap-4 p-4 rounded-lg font-medium', route().current() === 'member.invoices.index' && 'bg-surface text-primary')" :href="route('member.invoices.index')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-credit-card-icon lucide-credit-card shrink-0"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>
                        Tagihan
                    </Link>
                </nav>
                <div class="w-full flex flex-col gap-4">
                    <Button :as="Link" v-if="!memberProfile.is_active" class="flex items-center justify-center gap-4 p-4 rounded-lg text-white font-medium bg-primary" :href="route('member.premium.index')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap-icon lucide-zap shrink-0"><path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"/></svg>
                        Gabung member premium
                    </Button>
                    <Popover>
                        <PopoverTrigger as="div" class="w-full flex items-center gap-4">
                            <img :src="memberProfile.image_url ? `${storageUrl}/${memberProfile.image_url}` : `${appUrl}/images/profile-placeholder.svg`" alt="Profile" class="w-12 aspect-square object-cover rounded-full">
                            <div class="w-full flex flex-col gap-4">
                                <span>{{ user.name }}</span>
                                <div>
                                    <Badge>{{ memberProfile.is_active ? "Member Premium" : "Member" }}</Badge>
                                </div>
                            </div>
                        </PopoverTrigger>
                        <PopoverContent class="bottom-full left-0 flex flex-col gap-px bg-onyx-200">
                            <Link class="flex items-center gap-4 p-4 bg-white first:rounded-t-[0.4375rem] last:rounded-b-[0.4375rem] whitespace-nowrap" :href="route('member.profile.index')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-icon lucide-user shrink-0"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                Profil
                            </Link>
                            <Form class="bg-white first:rounded-t-[0.4375rem] last:rounded-b-[0.4375rem]" :action="route('logout')" method="post">
                                <button class="w-full flex items-center gap-4 p-4 rounded-[0.4375rem] text-danger-500 whitespace-nowrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-out-icon lucide-log-out shrink-0"><path d="m16 17 5-5-5-5"/><path d="M21 12H9"/><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/></svg>
                                    Log out
                                </button>
                            </Form>
                        </PopoverContent>
                    </Popover>
                </div>
            </div>
        </aside>
        <slot />
    </div>
</template>
