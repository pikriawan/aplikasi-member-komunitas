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

const statisticsMenuExpanded = ref(route().current().startsWith("leader.statistics"));
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
                    <div class="w-full flex flex-col">
                        <div class="relative">
                            <Link :class="cn('w-full flex items-center gap-4 p-4 rounded-lg font-medium', route().current() === 'leader.statistics.index' && 'bg-surface text-primary')" :href="route('leader.statistics.index')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chart-column-icon lucide-chart-column shrink-0"><path d="M3 3v16a2 2 0 0 0 2 2h16"/><path d="M18 17V9"/><path d="M13 17V5"/><path d="M8 17v-3"/></svg>
                                Statistik
                            </Link>
                            <button @click="statisticsMenuExpanded = !statisticsMenuExpanded" class="absolute top-1/2 -translate-y-1/2 right-4 p-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" :class="cn('lucide lucide-chevron-right-icon lucide-chevron-right transition-transform', statisticsMenuExpanded && 'rotate-90', route().current() === 'leader.statistics.index' && 'bg-surface text-primary' && 'text-primary')"><path d="m9 18 6-6-6-6"/></svg>
                            </button>
                        </div>
                        <div v-if="statisticsMenuExpanded" class="flex">
                            <div class="flex justify-center items-center p-2">
                                <span class="w-px h-full bg-onyx-200" />
                            </div>
                            <div class="w-full flex flex-col">
                                <Link :class="cn('w-full flex items-center gap-4 p-4 rounded-lg font-medium', route().current() === 'leader.statistics.members.index' && 'bg-surface text-primary')" :href="route('leader.statistics.members.index')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-icon lucide-user shrink-0"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                    Member
                                </Link>
                                <Link :class="cn('w-full flex items-center gap-4 p-4 rounded-lg font-medium', route().current() === 'leader.statistics.contents.index' && 'bg-surface text-primary')" :href="route('leader.statistics.contents.index')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-play-icon lucide-circle-play shrink-0"><path d="M9 9.003a1 1 0 0 1 1.517-.859l4.997 2.997a1 1 0 0 1 0 1.718l-4.997 2.997A1 1 0 0 1 9 14.996z"/><circle cx="12" cy="12" r="10"/></svg>
                                    Konten
                                </Link>
                                <Link :class="cn('w-full flex items-center gap-4 p-4 rounded-lg font-medium', route().current() === 'leader.statistics.posts.index' && 'bg-surface text-primary')" :href="route('leader.statistics.posts.index')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-notebook-icon lucide-notebook shrink-0"><path d="M2 6h4"/><path d="M2 10h4"/><path d="M2 14h4"/><path d="M2 18h4"/><rect width="16" height="20" x="4" y="2" rx="2"/><path d="M16 2v20"/></svg>
                                    Postingan
                                </Link>
                                <Link :class="cn('w-full flex items-center gap-4 p-4 rounded-lg font-medium', route().current() === 'leader.statistics.revenues.index' && 'bg-surface text-primary')" :href="route('leader.statistics.revenues.index')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-banknote-arrow-up-icon lucide-banknote-arrow-up shrink-0"><path d="M12 18H4a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5"/><path d="M18 12h.01"/><path d="M19 22v-6"/><path d="m22 19-3-3-3 3"/><path d="M6 12h.01"/><circle cx="12" cy="12" r="2"/></svg>
                                    Pendapatan
                                </Link>
                            </div>
                        </div>
                    </div>
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
                            <Link class="flex items-center gap-4 p-4 bg-white first:rounded-t-[0.4375rem] last:rounded-b-[0.4375rem] whitespace-nowrap" :href="route('leader.profile.index')">
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
