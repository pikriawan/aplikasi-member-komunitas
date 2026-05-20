<script setup>
import { Form, usePage } from "@inertiajs/vue3";
import { watchEffect } from "vue";

const page = usePage();

watchEffect(() => {
    console.log(page.flash);
});
</script>

<template>
    <div class="flex flex-col gap-4 p-4">
        <h1 class="font-semibold text-2xl">Lupa Password</h1>
        <Form class="flex flex-col items-start gap-2" :action="route('password.email')" method="post" v-slot="{ errors }">
            <div class="flex flex-col gap-1">
                <input class="ring ring-inset ring-zinc-600 px-2 py-1 rounded-lg" name="email" type="email" placeholder="Email">
                <p class="text-lime-500 text-sm" v-if="page.flash.status">{{ page.flash.status }}</p>
                <p class="text-red-600 text-sm" v-if="errors.email">{{ errors.email }}</p>
            </div>
            <button class="bg-violet-600 text-white px-2 py-1 rounded-lg">Kirim tautan reset password</button>
        </Form>
    </div>
</template>
