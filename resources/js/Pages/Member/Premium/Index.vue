<script setup>
import { Form, Link, usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import DashboardHeader from "../../../Components/DashboardHeader.vue";
import Button from "../../../Components/Ui/Button.vue";
import Modal from "../../../Components/Ui/Modal.vue";
import ModalClose from "../../../Components/Ui/ModalClose.vue";
import ModalContent from "../../../Components/Ui/ModalContent.vue";
import ModalTrigger from "../../../Components/Ui/ModalTrigger.vue";
import MemberLayout from "../../../Layouts/MemberLayout.vue";

const page = usePage();

const setting = computed(() => page.props.setting);
</script>

<template>
    <MemberLayout>
        <DashboardHeader title="Premium" />
        <main class="flex-1 overflow-auto">
            <div class="p-8 lg:min-h-full">
                <div class="flex flex-col gap-8 lg:w-full lg:flex-row lg:max-w-270">
                    <div class="w-full flex flex-col gap-5 p-5 rounded-2xl ring ring-inset ring-onyx-200">
                        <h2 class="font-semibold text-[1.25rem]">Member Biasa</h2>
                        <p>
                            <span class="font-semibold text-3xl">{{ new Intl.NumberFormat("id-ID", { style: "currency", currency: "IDR" }).format(0) }}</span>
                            <span>/tahun</span>
                        </p>
                        <div class="flex flex-col gap-4">
                            <div class="flex items-center gap-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check-icon lucide-circle-check text-success-600 shrink-0"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
                                Akses blog
                            </div>
                            <div class="flex items-center gap-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-icon lucide-x text-danger-500 shrink-0"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                                Akses konten premium
                            </div>
                            <div class="flex items-center gap-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-icon lucide-x text-danger-500 shrink-0"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                                Ajukan pertanyaan
                            </div>
                        </div>
                        <Button class="justify-center text-center" disabled>Saat ini</Button>
                    </div>
                    <div class="w-full flex flex-col gap-5 p-5 rounded-2xl bg-primary text-white">
                        <h2 class="font-semibold text-[1.25rem]">Member Premium</h2>
                        <p>
                            <span class="font-semibold text-3xl">{{ new Intl.NumberFormat("id-ID", { style: "currency", currency: "IDR" }).format(Number(setting.membership_fee || "0")) }}</span>
                            <span>/tahun</span>
                        </p>
                        <div class="flex flex-col gap-4">
                            <div class="flex items-center gap-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check-icon lucide-circle-check shrink-0"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
                                Akses blog
                            </div>
                            <div class="flex items-center gap-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check-icon lucide-circle-check shrink-0"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
                                Akses konten premium
                            </div>
                            <div class="flex items-center gap-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check-icon lucide-circle-check shrink-0"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
                                Ajukan pertanyaan
                            </div>
                        </div>
                        <Modal>
                            <ModalTrigger :as="Button" class="justify-center text-center bg-white text-primary">Langganan sekarang</ModalTrigger>
                            <ModalContent class="lg:min-w-150 font-geist">
                                <div class="flex flex-col gap-5">
                                    <header class="flex justify-between items-center gap-4">
                                        <h3 class="font-semibold">Lanjut ke Pembayaran?</h3>
                                        <ModalClose class="shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-icon lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                                        </ModalClose>
                                    </header>
                                    <p>Apakah Anda yakin ingin lanjut ke pembayaran?</p>
                                    <Form class="flex gap-4" :action="route('member.invoices.store')" method="post">
                                        <ModalClose type="button" class="w-full justify-center" :as="Button" variant="outlined">Batal</ModalClose>
                                        <Button class="w-full justify-center">Ya</Button>
                                    </Form>
                                </div>
                            </ModalContent>
                        </Modal>
                    </div>
                </div>
            </div>
        </main>
    </MemberLayout>
</template>
