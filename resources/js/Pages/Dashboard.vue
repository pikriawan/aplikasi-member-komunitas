<script setup>
import { Form } from "@inertiajs/vue3";
</script>

<template>
    <div class="flex flex-col gap-4 p-4">
        <h1 class="font-semibold text-2xl">Dashboard</h1>
        <Form class="flex flex-col items-start gap-2" :action="route('logout')" method="post">
            <button class="bg-red-600 text-white px-2 py-1 rounded-lg">Logout</button>
        </Form>
    </div>
</template>

