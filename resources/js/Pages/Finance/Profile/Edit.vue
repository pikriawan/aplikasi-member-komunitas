<script setup>
import { Form, usePage } from "@inertiajs/vue3";
import { computed, useTemplateRef } from "vue";
import DashboardHeader from "../../../Components/DashboardHeader.vue";
import Button from "../../../Components/Ui/Button.vue";
import Popover from "../../../Components/Ui/Popover.vue";
import PopoverContent from "../../../Components/Ui/PopoverContent.vue";
import PopoverTrigger from "../../../Components/Ui/PopoverTrigger.vue";
import TextField from "../../../Components/Ui/TextField.vue";
import FinanceLayout from "../../../Layouts/FinanceLayout.vue";

const page = usePage();

const user = computed(() => page.props.user);
</script>

<template>
    <FinanceLayout>
        <DashboardHeader title="Edit Profil" :back-href="route('finance.profile.index')">
            <Popover class="h-full aspect-square">
                <PopoverTrigger class="w-full h-full flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ellipsis-vertical-icon lucide-ellipsis-vertical"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                </PopoverTrigger>
                <PopoverContent class="top-[calc(100%-1rem)] right-4 flex flex-col gap-px bg-onyx-200">
                    <button form="edit_profile" class="flex items-center gap-4 p-4 bg-white first:rounded-t-[0.4375rem] last:rounded-b-[0.4375rem] whitespace-nowrap">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-icon lucide-file shrink-0"><path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"/><path d="M14 2v5a1 1 0 0 0 1 1h5"/></svg>
                        Simpan perubahan
                    </button>
                </PopoverContent>
            </Popover>
        </DashboardHeader>
        <main class="w-full h-full overflow-auto">
            <Form id="edit_profile" class="flex flex-col gap-8 p-8 lg:min-h-full" :action="route('finance.profile.update')" method="put" v-slot="{ errors }">
                <div class="flex flex-col gap-8">
                    <div class="flex flex-col gap-2 lg:max-w-150">
                        <label for="telephone" class="font-semibold">Nomor telepon</label>
                        <TextField id="telephone" name="telephone" placeholder="Nomor telepon" :value="user.telephone" />
                        <p class="text-danger-500 text-sm" v-if="errors.telephone">{{ errors.telephone }}</p>
                    </div>
                </div>
                <div class="flex flex-col gap-8">
                    <h2 class="text-2xl font-semibold">Ubah Password</h2>
                    <div class="flex flex-col gap-2 lg:max-w-150">
                        <label for="old_password" class="font-semibold">Password lama</label>
                        <TextField id="old_password" name="old_password" placeholder="Password lama" type="password" />
                        <p class="text-danger-500 text-sm" v-if="errors.old_password">{{ errors.old_password }}</p>
                    </div>
                    <div class="flex flex-col gap-2 lg:max-w-150">
                        <label for="password" class="font-semibold">Password baru</label>
                        <TextField id="password" name="password" placeholder="Password baru" type="password" />
                        <p class="text-danger-500 text-sm" v-if="errors.password">{{ errors.password }}</p>
                    </div>
                    <div class="flex flex-col gap-2 lg:max-w-150">
                        <label for="password_confirmation" class="font-semibold">Konfirmasi password baru</label>
                        <TextField id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi password baru" type="password" />
                        <p class="text-danger-500 text-sm" v-if="errors.password_confirmation">{{ errors.password_confirmation }}</p>
                    </div>
                </div>
            </Form>
        </main>
    </FinanceLayout>
</template>
