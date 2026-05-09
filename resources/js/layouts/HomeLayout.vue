<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="p-4 flex flex-col gap-4">
        <header class="flex gap-2 text-blue-600">
            <Link href="/">Home</Link>
            <Link href="/auth/login">Login</Link>
        </header>
        <main class="flex flex-col gap-4">
            <slot />
        </main>
    </div>
</template>
