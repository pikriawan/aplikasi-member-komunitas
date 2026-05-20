<script setup>
import { Form } from "@inertiajs/vue3";
</script>

<template>
    <div class="flex flex-col gap-4 p-4">
        <h1 class="font-semibold text-2xl">Login</h1>
        <Form class="flex flex-col items-start gap-2" :action="route('login.store')" method="post" v-slot="{ errors }">
            <div class="flex flex-col gap-1">
                <input class="ring ring-inset ring-zinc-600 px-2 py-1 rounded-lg" name="email" type="email" placeholder="Email">
                <p class="text-red-600 text-sm" v-if="errors.email">{{ errors.email }}</p>
            </div>
            <div class="flex flex-col gap-1">
                <input class="ring ring-inset ring-zinc-600 px-2 py-1 rounded-lg" name="password" type="password" placeholder="Password">
                <p class="text-red-600 text-sm" v-if="errors.password">{{ errors.password }}</p>
            </div>
            <button class="bg-violet-600 text-white px-2 py-1 rounded-lg">Login</button>
        </Form>
    </div>
</template>
