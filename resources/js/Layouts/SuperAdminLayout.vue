<script setup>
import { Form, Link, usePage } from "@inertiajs/vue3";
import { computed, provide, ref } from "vue";
import Badge from "../Components/Ui/Badge.vue";
import Button from "../Components/Ui/Button.vue";
import Popover from "../Components/Ui/Popover.vue";
import PopoverContent from "../Components/Ui/PopoverContent.vue";
import PopoverTrigger from "../Components/Ui/PopoverTrigger.vue";
import UserRole from "../Enums/UserRole.js";
import { cn } from "../lib/utils";

const page = usePage();

const appUrl = computed(() => page.props.appUrl);
const storageUrl = computed(() => page.props.storageUrl);
const setting = computed(() => page.props.setting);
const user = computed(() => page.props.user);

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
                <img :src="setting.community_logo ? `${storageUrl}/${setting.community_logo}` : `${appUrl}/images/community-logo.svg`" width="48" alt="Brand">
                <button class="lg:hidden" @click="setSidebarVisible(false)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-icon lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                </button>
            </header>
            <div class="w-full h-full flex flex-col justify-between p-8">
                <nav class="w-full flex flex-col">
                    <Link :class="cn('w-full flex items-center gap-4 p-4 rounded-lg font-medium', route().current() === 'super_admin.accounts.index' && 'bg-surface text-primary')" :href="route('super_admin.accounts.index')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-round-icon lucide-users-round shrink-0"><path d="M18 21a8 8 0 0 0-16 0"/><circle cx="10" cy="8" r="5"/><path d="M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3"/></svg>
                        Kelola Akun
                    </Link>
                    <Link :class="cn('w-full flex items-center gap-4 p-4 rounded-lg font-medium', route().current() === 'super_admin.settings.index' && 'bg-surface text-primary')" :href="route('super_admin.settings.index')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-settings-icon lucide-settings shrink-0"><path d="M9.671 4.136a2.34 2.34 0 0 1 4.659 0 2.34 2.34 0 0 0 3.319 1.915 2.34 2.34 0 0 1 2.33 4.033 2.34 2.34 0 0 0 0 3.831 2.34 2.34 0 0 1-2.33 4.033 2.34 2.34 0 0 0-3.319 1.915 2.34 2.34 0 0 1-4.659 0 2.34 2.34 0 0 0-3.32-1.915 2.34 2.34 0 0 1-2.33-4.033 2.34 2.34 0 0 0 0-3.831A2.34 2.34 0 0 1 6.35 6.051a2.34 2.34 0 0 0 3.319-1.915"/><circle cx="12" cy="12" r="3"/></svg>
                        Pengaturan Sistem
                    </Link>
                    <Link class="w-full flex items-center gap-4 p-4 rounded-lg font-medium" :href="route('home')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-house-icon lucide-house shrink-0"><path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"/><path d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                        Beranda
                    </Link>
                </nav>
                <div class="w-full flex flex-col gap-4">
                    <Popover>
                        <PopoverTrigger as="div" class="w-full flex items-center gap-4">
                            <div class="w-full flex flex-col gap-4">
                                <span>{{ user.name }}</span>
                                <div>
                                    <Badge>{{ UserRole.from(user.role).label }}</Badge>
                                </div>
                            </div>
                        </PopoverTrigger>
                        <PopoverContent class="bottom-full left-0 flex flex-col gap-px bg-onyx-200">
                            <Link class="flex items-center gap-4 p-4 bg-white first:rounded-t-[0.4375rem] last:rounded-b-[0.4375rem] whitespace-nowrap" :href="route('super_admin.profile.index')">
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
