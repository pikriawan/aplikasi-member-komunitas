<script setup>
import { Form, usePage } from "@inertiajs/vue3";
import HomeLayout from "../layouts/HomeLayout.vue";

const page = usePage();
</script>

<template>
    <HomeLayout>
        <div class="bg-primary text-white flex p-8 lg:p-0 lg:px-4 lg:py-8 lg:justify-center">
            <div class="flex flex-col gap-4 lg:w-full lg:max-w-270 lg:flex-row lg:items-center lg:justify-between">
                <h1 class="text-2xl font-medium">Daftar Membership</h1>
            </div>
        </div>
        <div class="flex p-8 lg:p-0 lg:px-4 lg:py-16 justify-center">
            <div class="w-full lg:max-w-lg flex flex-col gap-8">
                <p>Terima kasih sudah mendaftar! Sebelum memulai, dapatkah Anda melakukan verifikasi email dengan klik tautan yang baru saja kami kirim ke email Anda? Jika Anda tidak menerima email, kami akan mengirimnya lagi.</p>
                <p class="text-[#03C03C]" v-if="page.flash.message">
                    {{ page.flash.message }}
                </p>
                <p class="text-[#FF0800]" v-if="page.flash.error">
                    {{ page.flash.error }}
                </p>
                <div class="flex flex-col lg:flex-row lg:justify-between items-start lg:items-center gap-8">
                    <Form action="/email/verification-notification" method="post" v-slot="{ processing }">
                        <button class="flex justify-center items-center bg-primary text-white font-geist font-medium px-4 py-3 rounded-lg disabled:opacity-60">Kirim kembali email verifikasi</button>
                    </Form>
                    <Form action="/logout" method="post">
                        <button class="text-[#FF0800]">Logout</button>
                    </Form> 
                </div>
            </div>
        </div>
    </HomeLayout>
</template>
