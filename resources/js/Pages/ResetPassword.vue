<script setup>
import { Form, usePage } from "@inertiajs/vue3";
import { watchEffect } from "vue";

const page = usePage();

watchEffect(() => {
    console.log(page.props.request);
});
</script>

<template>
    <div class="flex flex-col gap-4 p-4">
        <h1 class="font-semibold text-2xl">Reset Password</h1>
        <Form class="flex flex-col items-start gap-2" :action="route('password.update')" method="post" v-slot="{ errors }">
            <input name="token" type="hidden" :value="page.props.token">
            <div class="flex flex-col gap-1">
                <input class="ring ring-inset ring-zinc-600 px-2 py-1 rounded-lg" name="email" type="email" :value="page.props.request?.email" placeholder="Email">
                <p class="text-red-600 text-sm" v-if="errors.email">{{ errors.email }}</p>
            </div>
            <div class="flex flex-col gap-1">
                <input class="ring ring-inset ring-zinc-600 px-2 py-1 rounded-lg" name="password" type="password" placeholder="Password">
                <p class="text-red-600 text-sm" v-if="errors.password">{{ errors.password }}</p>
            </div>
            <div class="flex flex-col gap-1">
                <input class="ring ring-inset ring-zinc-600 px-2 py-1 rounded-lg" name="password_confirmation" type="password" placeholder="Konfirmasi password">
                <p class="text-red-600 text-sm" v-if="errors.password_confirmation">{{ errors.password_confirmation }}</p>
            </div>
            <button class="bg-violet-600 text-white px-2 py-1 rounded-lg">Reset password</button>
        </Form>
    </div>
</template>
