<script setup>
import { Form, Link, usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import DashboardHeader from "../../../Components/DashboardHeader.vue";
import Alert from "../../../Components/Ui/Alert.vue";
import Badge from "../../../Components/Ui/Badge.vue";
import Button from "../../../Components/Ui/Button.vue";
import Modal from "../../../Components/Ui/Modal.vue";
import ModalClose from "../../../Components/Ui/ModalClose.vue";
import ModalContent from "../../../Components/Ui/ModalContent.vue";
import ModalTrigger from "../../../Components/Ui/ModalTrigger.vue";
import Popover from "../../../Components/Ui/Popover.vue";
import PopoverContent from "../../../Components/Ui/PopoverContent.vue";
import PopoverTrigger from "../../../Components/Ui/PopoverTrigger.vue";
import UserRole from "../../../Enums/UserRole.js";
import SuperAdminLayout from "../../../Layouts/SuperAdminLayout.vue";

const page = usePage();

const appUrl = computed(() => page.props.appUrl);
const storageUrl = computed(() => page.props.storageUrl);
const account = computed(() => page.props.account);
const messages = computed(() => page.flash.messages);
</script>

<template>
    <SuperAdminLayout>
        <DashboardHeader title="Detail Akun" :back-href="route('super_admin.accounts.index')" />
        <main class="w-full h-full overflow-auto">
            <main class="w-full h-full overflow-auto">
            <div class="flex flex-col gap-8 p-8 lg:min-h-full">
                <Alert v-for="message in messages" :variant="message.variant" :key="message.text">
                    {{ message.text }}
                </Alert>
                <template v-if="account">
                    <div v-if="account.role === UserRole.Member.value" class="flex flex-col gap-8 lg:flex-row lg:max-w-270 lg:items-center">
                        <img :src="account.member_profile.image_url ? `${storageUrl}/${account.member_profile.image_url}` : `${appUrl}/images/profile-placeholder.svg`" alt="Profile" class="w-32 aspect-square object-cover rounded-full">
                        <div class="flex flex-col gap-4 w-full">
                            <h2 class="font-semibold text-[1.25rem]">{{ account.name }}</h2>
                            <div class="flex flex-col gap-4 lg:flex-row lg:flex-wrap">
                                <div class="flex items-center gap-2.5 text-onyx-400 font-semibold">
                                    <span class="p-1 rounded-full bg-onyx-50 text-onyx-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-building-icon lucide-building"><path d="M12 10h.01"/><path d="M12 14h.01"/><path d="M12 6h.01"/><path d="M16 10h.01"/><path d="M16 14h.01"/><path d="M16 6h.01"/><path d="M8 10h.01"/><path d="M8 14h.01"/><path d="M8 6h.01"/><path d="M9 22v-3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3"/><rect x="4" y="2" width="16" height="20" rx="2"/></svg>
                                    </span>
                                    {{ account.member_profile.institution || "-" }}
                                </div>
                                <div class="flex items-center gap-2.5 text-onyx-400 font-semibold">
                                    <span class="p-1 rounded-full bg-onyx-50 text-onyx-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-icon lucide-users"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><path d="M16 3.128a4 4 0 0 1 0 7.744"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><circle cx="9" cy="7" r="4"/></svg>
                                    </span>
                                    {{ account.member_profile.department || "-" }}
                                </div>
                                <div class="flex items-center gap-2.5 text-onyx-400 font-semibold">
                                    <span class="p-1 rounded-full bg-onyx-50 text-onyx-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail-icon lucide-mail"><path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"/><rect x="2" y="4" width="20" height="16" rx="2"/></svg>
                                    </span>
                                    {{ account.email }}
                                </div>
                            </div>
                            <div class="flex flex-col gap-4 lg:grid grid-cols-[repeat(auto-fit,minmax(12.5rem,1fr))]">
                                <div class="flex flex-col gap-4 p-4 rounded-lg border border-dashed border-onyx-200">
                                    <div class="flex items-center gap-2.5 font-semibold">
                                        <span class="p-1 rounded-full bg-success-50 text-success-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-id-card-icon lucide-id-card"><path d="M16 10h2"/><path d="M16 14h2"/><path d="M6.17 15a3 3 0 0 1 5.66 0"/><circle cx="9" cy="11" r="2"/><rect x="2" y="5" width="20" height="14" rx="2"/></svg>
                                        </span>
                                        {{ account.member_profile.number }}
                                    </div>
                                    <p class="text-onyx-400">Nomor Anggota</p>
                                </div>
                                <div class="flex flex-col gap-4 p-4 rounded-lg border border-dashed border-onyx-200">
                                    <div class="flex items-center gap-2.5 font-semibold">
                                        <span class="p-1 rounded-full bg-blue-50 text-blue-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-icon lucide-user"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                        </span>
                                        {{ account.member_profile.is_active ? "Aktif" : "Nonaktif" }}
                                    </div>
                                    <p class="text-onyx-400">Status</p>
                                </div>
                                <div class="flex flex-col gap-4 p-4 rounded-lg border border-dashed border-onyx-200">
                                    <div class="flex items-center gap-2.5 font-semibold">
                                        <span class="p-1 rounded-full bg-violet-50 text-violet-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-days-icon lucide-calendar-days"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/><path d="M8 18h.01"/><path d="M12 18h.01"/><path d="M16 18h.01"/></svg>
                                        </span>
                                        {{ account.member_profile.join_date }}
                                    </div>
                                    <p class="text-onyx-400">Bergabung Sejak</p>
                                </div>
                                <div class="flex flex-col gap-4 p-4 rounded-lg border border-dashed border-onyx-200">
                                    <div class="flex items-center gap-2.5 font-semibold">
                                        <span class="p-1 rounded-full bg-danger-50 text-danger-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-timer-icon lucide-timer"><line x1="10" x2="14" y1="2" y2="2"/><line x1="12" x2="15" y1="14" y2="11"/><circle cx="12" cy="14" r="8"/></svg>
                                        </span>
                                        {{ account.member_profile.membership_until }}
                                    </div>
                                    <p class="text-onyx-400">Membership Hingga</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col gap-8">
                        <h2 class="font-semibold text-2xl">Informasi Pribadi</h2>
                        <div class="w-full lg:max-w-150 flex flex-col gap-6 lg:gap-4">
                            <div class="flex flex-col gap-2 lg:grid grid-cols-2">
                                <p>Nama lengkap</p>
                                <p class="font-semibold">{{ account.name }}</p>
                            </div>
                            <div class="flex flex-col gap-2 lg:grid grid-cols-2">
                                <p>Email</p>
                                <p class="font-semibold">{{ account.email }}</p>
                            </div>
                            <div v-if="account.role === UserRole.Member.value" class="flex flex-col gap-2 lg:grid grid-cols-2">
                                <p>Nomor anggota</p>
                                <p class="font-semibold">{{ account.member_profile.number }}</p>
                            </div>
                            <div v-if="account.role === UserRole.Member.value" class="flex flex-col gap-2 lg:grid grid-cols-2">
                                <p>Status membership</p>
                                <div>
                                    <Badge v-if="account.member_profile.is_active" variant="success">Aktif</Badge>
                                    <Badge v-else variant="danger">Nonaktif</Badge>
                                </div>
                            </div>
                            <div class="flex flex-col gap-2 lg:grid grid-cols-2">
                                <p>Status akun</p>
                                <div>
                                    <Badge v-if="account.is_active" variant="success">Aktif</Badge>
                                    <Badge v-else variant="danger">Nonaktif</Badge>
                                </div>
                            </div>
                            <div v-if="account.role === UserRole.Member.value" class="flex flex-col gap-2 lg:grid grid-cols-2">
                                <p>Bergabung sejak</p>
                                <p class="font-semibold">{{ account.member_profile.join_date }}</p>
                            </div>
                            <div v-if="account.role === UserRole.Member.value" class="flex flex-col gap-2 lg:grid grid-cols-2">
                                <p>Membership hingga</p>
                                <p class="font-semibold">{{ account.member_profile.membership_until }}</p>
                            </div>
                            <div v-if="account.role === UserRole.Member.value" class="flex flex-col gap-2 lg:grid grid-cols-2">
                                <p>Jenis kelamin</p>
                                <p class="font-semibold">{{ account.member_profile.gender || "-" }}</p>
                            </div>
                            <div v-if="account.role === UserRole.Member.value" class="flex flex-col gap-2 lg:grid grid-cols-2">
                                <p>Golongan darah</p>
                                <p class="font-semibold">{{ account.member_profile.blood_type || "-" }}</p>
                            </div>
                            <div v-if="account.role === UserRole.Member.value" class="flex flex-col gap-2 lg:grid grid-cols-2">
                                <p>Pendidikan terakhir</p>
                                <p class="font-semibold">{{ account.member_profile.last_education || "-" }}</p>
                            </div>
                            <div v-if="account.role === UserRole.Member.value" class="flex flex-col gap-2 lg:grid grid-cols-2">
                                <p>Institusi</p>
                                <p class="font-semibold">{{ account.member_profile.institution || "-" }}</p>
                            </div>
                            <div v-if="account.role === UserRole.Member.value" class="flex flex-col gap-2 lg:grid grid-cols-2">
                                <p>Departemen</p>
                                <p class="font-semibold">{{ account.member_profile.department || "-" }}</p>
                            </div>
                            <div class="flex flex-col gap-2 lg:grid grid-cols-2">
                                <p>Nomor telepon</p>
                                <p class="font-semibold">{{ account.telephone || "-" }}</p>
                            </div>
                            <div v-if="account.role === UserRole.Member.value" class="flex flex-col gap-2 lg:grid grid-cols-2">
                                <p>Alamat rumah</p>
                                <p class="font-semibold">{{ account.member_profile.address || "-" }}</p>
                            </div>
                        </div>
                        <div class="flex flex-col lg:flex-row items-start lg:items-center gap-4">
                            <Modal v-if="account.is_active">
                                <ModalTrigger :as="Button" variant="danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ban-icon lucide-ban shrink-0"><circle cx="12" cy="12" r="10"/><path d="M4.929 4.929 19.07 19.071"/></svg>
                                    Nonaktifkan akun
                                </ModalTrigger>
                                <ModalContent class="lg:min-w-150 font-geist">
                                    <div class="flex flex-col gap-5">
                                        <header class="flex justify-between items-center gap-4">
                                            <h3 class="font-semibold">Nonaktifkan akun?</h3>
                                            <ModalClose class="shrink-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-icon lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                                            </ModalClose>
                                        </header>
                                        <p>Apakah Anda yakin ingin menonaktifkan akun ini?</p>
                                        <Form class="flex gap-4" :action="route('super_admin.accounts.status.update', account.id)" method="put">
                                            <input type="hidden" name="status" value="false">
                                            <ModalClose type="button" class="w-full justify-center" :as="Button" variant="outlined">Batal</ModalClose>
                                            <Button class="w-full justify-center">Ya</Button>
                                        </Form>
                                    </div>
                                </ModalContent>
                            </Modal>
                            <Modal v-else>
                                <ModalTrigger :as="Button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-icon lucide-check shrink-0"><path d="M20 6 9 17l-5-5"/></svg>
                                    Aktifkan akun
                                </ModalTrigger>
                                <ModalContent class="lg:min-w-150 font-geist">
                                    <div class="flex flex-col gap-5">
                                        <header class="flex justify-between items-center gap-4">
                                            <h3 class="font-semibold">Aktifkan akun?</h3>
                                            <ModalClose class="shrink-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-icon lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                                            </ModalClose>
                                        </header>
                                        <p>Apakah Anda yakin ingin mengaktifkan akun ini?</p>
                                        <Form class="flex gap-4" :action="route('super_admin.accounts.status.update', account.id)" method="put">
                                            <input type="hidden" name="status" value="true">
                                            <ModalClose type="button" class="w-full justify-center" :as="Button" variant="outlined">Batal</ModalClose>
                                            <Button class="w-full justify-center">Ya</Button>
                                        </Form>
                                    </div>
                                </ModalContent>
                            </Modal>
                        </div>
                    </div>
                </template>
            </div>
        </main>
        </main>
    </SuperAdminLayout>
</template>
