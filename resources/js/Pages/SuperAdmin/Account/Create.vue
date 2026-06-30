<script setup>
import { Form, Link } from "@inertiajs/vue3";
import { computed } from "vue";
import DashboardHeader from "../../../Components/DashboardHeader.vue";
import Button from "../../../Components/Ui/Button.vue";
import Popover from "../../../Components/Ui/Popover.vue";
import PopoverContent from "../../../Components/Ui/PopoverContent.vue";
import PopoverTrigger from "../../../Components/Ui/PopoverTrigger.vue";
import TextField from "../../../Components/Ui/TextField.vue";
import UserRole from "../../../Enums/UserRole.js";
import SuperAdminLayout from "../../../Layouts/SuperAdminLayout.vue";
import { cn } from "../../../lib/utils.js";
</script>

<template>
    <SuperAdminLayout>
        <DashboardHeader title="Buat Akun Baru" :back-href="route('super_admin.accounts.index')">
            <Popover class="h-full aspect-square">
                <PopoverTrigger class="w-full h-full flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ellipsis-vertical-icon lucide-ellipsis-vertical"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                </PopoverTrigger>
                <PopoverContent class="top-[calc(100%-1rem)] right-4 flex flex-col gap-px bg-onyx-200">
                    <button form="create_account" class="flex items-center gap-4 p-4 bg-white first:rounded-t-[0.4375rem] last:rounded-b-[0.4375rem] whitespace-nowrap">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus shrink-0"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                        Buat akun
                    </button>
                </PopoverContent>
            </Popover>
        </DashboardHeader>
        <main class="flex-1 overflow-auto">
            <Form id="create_account" class="flex flex-col gap-8 p-8 lg:min-h-full" :action="route('super_admin.accounts.store')" method="post" v-slot="{ errors }">
                <div class="flex flex-col gap-2 lg:max-w-150">
                    <label for="name" class="font-semibold">Nama lengkap *</label>
                    <TextField id="name" name="name" placeholder="Nama lengkap" />
                    <p class="text-danger-500 text-sm" v-if="errors.name">{{ errors.name }}</p>
                </div>
                <div class="flex flex-col gap-2 lg:max-w-150">
                    <label for="email" class="font-semibold">Email *</label>
                    <TextField id="email" name="email" type="email" placeholder="Email" />
                    <p class="text-danger-500 text-sm" v-if="errors.email">{{ errors.email }}</p>
                </div>
                <div class="flex flex-col gap-2 lg:max-w-150">
                    <label for="telephone" class="font-semibold">Nomor telepon</label>
                    <TextField id="telephone" name="telephone" placeholder="Nomor telepon" />
                    <p class="text-danger-500 text-sm" v-if="errors.telephone">{{ errors.telephone }}</p>
                </div>
                <div class="flex flex-col gap-2">
                    <span class="font-semibold">Role *</span>
                    <div class="flex flex-col gap-2">
                        <label class="flex items-center gap-2" for="role_staff">
                            <input type="radio" name="role" id="role_staff" :value="UserRole.Staff.value" checked>
                            <span>{{ UserRole.Staff.label }}</span>
                        </label>
                        <label class="flex items-center gap-2" for="role_finance">
                            <input type="radio" name="role" id="role_finance" :value="UserRole.Finance.value">
                            <span>{{ UserRole.Finance.label }}</span>
                        </label>
                        <label class="flex items-center gap-2" for="role_leader">
                            <input type="radio" name="role" id="role_leader" :value="UserRole.Leader.value">
                            <span>{{ UserRole.Leader.label }}</span>
                        </label>
                    </div>
                    <p class="text-danger-500 text-sm" v-if="errors.role">{{ errors.role }}</p>
                </div>
                <div class="flex flex-col gap-2 lg:max-w-150">
                    <label for="password" class="font-semibold">Password *</label>
                    <TextField id="password" name="password" type="password" placeholder="Password" />
                    <p class="text-danger-500 text-sm" v-if="errors.password">{{ errors.password }}</p>
                </div>
                <div class="flex flex-col gap-2 lg:max-w-150">
                    <label for="password_confirmation" class="font-semibold">Konfirmasi password *</label>
                    <TextField id="password_confirmation" name="password_confirmation" type="password" placeholder="Konfirmasi password" />
                    <p class="text-danger-500 text-sm" v-if="errors.password_confirmation">{{ errors.password_confirmation }}</p>
                </div>
                <div class="flex gap-2 text-onyx-400">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-alert-icon lucide-circle-alert shrink-0"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                    Password minimal 8 karakter dengan kombinasi huruf dan angka
                </div>
                <div class="flex gap-2 text-onyx-400">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-alert-icon lucide-circle-alert shrink-0"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                    * wajib diisi
                </div>
            </Form>
        </main>
    </SuperAdminLayout>
</template>
