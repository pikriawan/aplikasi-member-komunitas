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

const optionsShow = ref(false);
</script>

<template>
    <MemberLayout v-slot="{ setSidebarShow }">
        <header class="sticky top-0 h-14 flex items-center lg:gap-4 shadow-[0_-0.0625rem_0_#CCCCCC_inset] lg:h-20 lg:px-8 bg-white">
            <Link class="h-full lg:h-8 aspect-square flex items-center justify-center" href="/member/questions">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-left-icon lucide-chevron-left"><path d="m15 18-6-6 6-6"/></svg>
            </Link>
            <h1 class="w-full font-semibold lg:text-2xl">Buat Pertanyaan Baru</h1>
        </header>
        <div class="overflow-x-auto lg:w-full lg:h-full">
            <div class="lg:h-full lg:relative flex">
                <div class="flex flex-col" v-if="error">
                    <Alert variant="danger">{{ error }}</Alert>
                </div>
                <div class="flex flex-col gap-8 w-full" v-else>
                    <div class="flex flex-col gap-8 lg:overflow-y-auto p-5 lg:p-8">
                        <!-- <Alert>Halo</Alert>
                        <p class="text-center">8 April 2026</p>
                        <div class="flex justify-end">
                            <div class="w-full max-w-100 flex flex-col gap-3 p-5 bg-[#F2F2F2] rounded-xl rounded-tr">
                                <p class="font-medium">Saya • 12:43</p>
                                <p>Bagaimana cara memperbarui data profil saya?</p>
                            </div>
                        </div>
                        <div class="flex">
                            <div class="w-full max-w-100 flex flex-col gap-3 p-5 bg-[#F2F2F2] rounded-xl rounded-tl">
                                <p class="font-medium">Nem Painem • 12:45</p>
                                <p>Masuk ke akun Anda, lalu buka menu Profil. Pilih Edit Profil, kemudian ubah data yang diinginkan seperti foto, alamat, atau nomor kontak. Setelah selesai klik Simpan.</p>
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <div class="w-full max-w-100 flex flex-col gap-3 p-5 bg-[#F2F2F2] rounded-xl rounded-tr">
                                <p class="font-medium">Saya • 12:43</p>
                                <p>Bagaimana cara memperbarui data profil saya?</p>
                            </div>
                        </div>
                        <div class="flex">
                            <div class="w-full max-w-100 flex flex-col gap-3 p-5 bg-[#F2F2F2] rounded-xl rounded-tl">
                                <p class="font-medium">Nem Painem • 12:45</p>
                                <p>Masuk ke akun Anda, lalu buka menu Profil. Pilih Edit Profil, kemudian ubah data yang diinginkan seperti foto, alamat, atau nomor kontak. Setelah selesai klik Simpan.</p>
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <div class="w-full max-w-100 flex flex-col gap-3 p-5 bg-[#F2F2F2] rounded-xl rounded-tr">
                                <p class="font-medium">Saya • 12:43</p>
                                <p>Bagaimana cara memperbarui data profil saya?</p>
                            </div>
                        </div>
                        <div class="flex">
                            <div class="w-full max-w-100 flex flex-col gap-3 p-5 bg-[#F2F2F2] rounded-xl rounded-tl">
                                <p class="font-medium">Nem Painem • 12:45</p>
                                <p>Masuk ke akun Anda, lalu buka menu Profil. Pilih Edit Profil, kemudian ubah data yang diinginkan seperti foto, alamat, atau nomor kontak. Setelah selesai klik Simpan.</p>
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <div class="w-full max-w-100 flex flex-col gap-3 p-5 bg-[#F2F2F2] rounded-xl rounded-tr">
                                <p class="font-medium">Saya • 12:43</p>
                                <p>Bagaimana cara memperbarui data profil saya?</p>
                            </div>
                        </div>
                        <div class="flex">
                            <div class="w-full max-w-100 flex flex-col gap-3 p-5 bg-[#F2F2F2] rounded-xl rounded-tl">
                                <p class="font-medium">Nem Painem • 12:45</p>
                                <p>Masuk ke akun Anda, lalu buka menu Profil. Pilih Edit Profil, kemudian ubah data yang diinginkan seperti foto, alamat, atau nomor kontak. Setelah selesai klik Simpan.</p>
                            </div>
                        </div> -->
                    </div>
                    <div class="fixed lg:absolute bottom-0 left-0 w-full flex flex-col px-5 pb-5 bg-white">
                        <Form class="flex gap-4 p-3 rounded-xl shadow-[0_0_0_0.0625rem_#CCCCCC_inset]" @submit.prevent>
                            <input class="w-full focus:outline-0" placeholder="Tulis pertanyaan" />
                            <Button>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-send-horizontal-icon lucide-send-horizontal"><path d="M3.714 3.048a.498.498 0 0 0-.683.627l2.843 7.627a2 2 0 0 1 0 1.396l-2.842 7.627a.498.498 0 0 0 .682.627l18-8.5a.5.5 0 0 0 0-.904z"/><path d="M6 12h16"/></svg>
                                Kirim
                            </Button>
                        </Form>
                    </div>
                </div>
            </div>
        </div>
    </MemberLayout>
</template>
