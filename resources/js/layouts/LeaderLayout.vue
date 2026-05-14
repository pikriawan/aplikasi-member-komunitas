<script setup>
import { Form, Link, usePage } from "@inertiajs/vue3";

const page = usePage();
</script>

<template>
    <div>
        <h1>Halo, {{ page.props.auth.user.name }} sebagai {{ page.props.auth.user.role }}!</h1>
        <Form action="/logout" method="post">
            <button class="text-[#FF0800]">Log out</button>
        </Form>
        <slot />
    </div>
</template>
