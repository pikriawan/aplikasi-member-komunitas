<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import DashboardHeader from "../../../Components/DashboardHeader.vue";
import Badge from "../../../Components/Ui/Badge.vue";
import Popover from "../../../Components/Ui/Popover.vue";
import PopoverContent from "../../../Components/Ui/PopoverContent.vue";
import PopoverTrigger from "../../../Components/Ui/PopoverTrigger.vue";
import UserRole from "../../../Enums/UserRole.js";
import SuperAdminLayout from "../../../Layouts/SuperAdminLayout.vue";

const page = usePage();

const user = computed(() => page.props.user);
</script>

<template>
    <SuperAdminLayout>
        <DashboardHeader title="Profil">
            <Popover class="h-full aspect-square">
                <PopoverTrigger class="w-full h-full flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ellipsis-vertical-icon lucide-ellipsis-vertical"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                </PopoverTrigger>
                <PopoverContent class="top-[calc(100%-1rem)] right-4 flex flex-col gap-px bg-onyx-200">
                    <Link class="flex items-center gap-4 p-4 bg-white first:rounded-t-[0.4375rem] last:rounded-b-[0.4375rem] whitespace-nowrap" :href="route('super_admin.profile.edit')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen-icon lucide-square-pen shrink-0"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/></svg>
                        Edit profil
                    </Link>
                </PopoverContent>
            </Popover>
        </DashboardHeader>
        <main class="w-full h-full overflow-auto">
            <div class="flex flex-col gap-8 p-8 lg:min-h-full">
                <div class="flex flex-col gap-8 lg:flex-row lg:max-w-270 lg:items-center">
                    <div class="flex flex-col gap-4 w-full">
                        <div class="flex items-center gap-2">
                            <h2 class="font-semibold text-[1.25rem]">{{ user.name }}</h2>
                        </div>
                        <div class="flex flex-col gap-4 lg:flex-row lg:flex-wrap">
                            <div class="flex items-center gap-2.5 text-onyx-400 font-semibold">
                                <span class="p-1 rounded-full bg-onyx-50 text-onyx-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail-icon lucide-mail"><path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"/><rect x="2" y="4" width="20" height="16" rx="2"/></svg>
                                </span>
                                {{ user.email }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col gap-8">
                    <h2 class="font-semibold text-2xl">Informasi Pribadi</h2>
                    <div class="w-full lg:max-w-150 flex flex-col gap-6 lg:gap-4">
                        <div class="flex flex-col gap-2 lg:grid grid-cols-2">
                            <p>Nama lengkap</p>
                            <p class="font-semibold">{{ user.name }}</p>
                        </div>
                        <div class="flex flex-col gap-2 lg:grid grid-cols-2">
                            <p>Email</p>
                            <p class="font-semibold">{{ user.email }}</p>
                        </div>
                        <div class="flex flex-col gap-2 lg:grid grid-cols-2">
                            <p>Nomor telepon</p>
                            <p class="font-semibold">{{ user.telephone || "-" }}</p>
                        </div>
                        <div class="flex flex-col gap-2 lg:grid grid-cols-2">
                            <p>Role</p>
                            <p class="font-semibold">{{ UserRole.from(user.role).label }}</p>
                        </div>
                        <div class="flex flex-col gap-2 lg:grid grid-cols-2">
                            <p>Status</p>
                            <div>
                                <Badge :variant="user.is_active ? 'success' : 'danger'">{{ user.is_active ? "Aktif" : "Nonaktif" }}</Badge>
                            </div>
                        </div>
                        <div class="flex flex-col gap-2 lg:grid grid-cols-2">
                            <p>Bergabung sejak</p>
                            <p class="font-semibold">{{ user.join_date }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </SuperAdminLayout>
</template>
