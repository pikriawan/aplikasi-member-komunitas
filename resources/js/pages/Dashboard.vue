<script setup>
import { Form } from '@inertiajs/vue3';
</script>

<template>
    <div class="p-4 flex flex-col items-start gap-4">
        <h1 class="text-3xl font-medium">Dashboard</h1>
        <Form action="/logout" method="post">
            <button class="bg-red-600 text-white px-4 py-2">Logout</button>
        </Form>
    </div>
</template>
