<script setup>
import { Form, usePage } from "@inertiajs/vue3";
import PillButton from "../Components/Ui/PillButton.vue";
import HomeLayout from "../Layouts/HomeLayout.vue";

const page = usePage();
</script>

<template>
    <HomeLayout>
        <section class="p-8 lg:p-0 lg:px-4 lg:py-8 lg:flex lg:justify-center bg-primary">
            <div class="lg:w-full lg:max-w-270 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 text-white">
                <h1 class="font-medium text-2xl">Verifikasi Email</h1>
            </div>
        </section>
        <section class="p-8 lg:p-0 lg:px-4 lg:py-16 lg:flex lg:justify-center">
            <div class="flex flex-col gap-8 lg:w-full lg:max-w-lg">
                <p>Mohon verifikasi alamat email Anda dengan mengklik tautan yang baru saja kami kirimkan melalui email.</p>
                <p v-if="page.flash.message" class="text-success-600">{{ page.flash.message }}</p>
                <Form :action="route('verification.send')" method="post">
                    <PillButton>Kirim ulang email verifikasi</PillButton>
                </Form>
                <Form :action="route('logout')" method="post">
                    <button class="text-danger-500">Log out</button>
                </Form>
            </div>
        </section>
    </HomeLayout>
</template>
