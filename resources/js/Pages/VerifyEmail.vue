<script setup>
import { Form, usePage } from "@inertiajs/vue3";

const page = usePage();
</script>

<template>
    <div class="flex flex-col gap-4 p-4">
        <h1 class="font-semibold text-2xl">Periksa Email Anda</h1>
        <Form class="flex flex-col items-start gap-2" :action="route('verification.send')" method="post">
            <div class="flex flex-col gap-1">
                <button class="bg-violet-600 text-white px-2 py-1 rounded-lg">Kirim kembali tautan verifikasi</button>
                <p class="text-lime-500 text-sm" v-if="page.flash.message">{{ page.flash.message }}</p>
            </div>
        </Form>
        <Form class="flex flex-col items-start gap-2" :action="route('logout')" method="post">
            <button class="bg-red-600 text-white px-2 py-1 rounded-lg">Logout</button>
        </Form>
    </div>
</template>
