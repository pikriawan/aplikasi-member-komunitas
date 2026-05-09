<script setup>
import { Form, usePage } from "@inertiajs/vue3";
import HomeLayout from "../layouts/HomeLayout.vue";

const page = usePage();
</script>

<template>
    <HomeLayout>
        <p>Periksa email</p>
        <p class="text-green-600" v-if="page.flash.message">
            {{ page.flash.message }}
        </p>
        <p class="text-red-600" v-if="page.flash.error">
            {{ page.flash.error }}
        </p>
        <Form action="/email/verification-notification" method="post" v-slot="{ processing }">
            <button :disabled="processing" class="bg-blue-700 text-white px-4 py-2 disabled:opacity-60">Kirim ulang email verifikasi</button>
        </Form>
        <Form action="/logout" method="post">
            <button class="bg-red-600 text-white px-4 py-2">Logout</button>
        </Form>
    </HomeLayout>
</template>
