<script setup>
import { Form, Link, usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import DashboardHeader from "../../../Components/DashboardHeader.vue";
import Alert from "../../../Components/Ui/Alert.vue";
import Badge from "../../../Components/Ui/Badge.vue";
import Button from "../../../Components/Ui/Button.vue";
import TextField from "../../../Components/Ui/TextField.vue";
import UserRole from "../../../Enums/UserRole.js";
import SuperAdminLayout from "../../../Layouts/SuperAdminLayout.vue";
import { cn } from "../../../lib/utils.js";

const page = usePage();

const messages = computed(() => page.flash.messages);
const accounts = computed(() => page.props.accounts);
console.log(accounts.value);

const links = computed(() => accounts.value?.links.map((link) => {
    const result = {...link};

    if (result.label === "&laquo; Previous") {
        result.label = "Previous";
    }

    if (result.label === "Next &raquo;") {
        result.label = "Next";
    }

    return result;
}));
</script>

<template>
    <SuperAdminLayout>
        <DashboardHeader title="Kelola Akun" />
        <main class="flex-1 overflow-auto">
            <div class="flex flex-col gap-8 p-8 lg:min-h-full">
                <div class="flex-1 flex flex-col gap-8 justify-between">
                    <div class="flex flex-col gap-8">
                        <Alert v-for="message in messages" :variant="message.variant" :key="message.text">
                            {{ message.text }}
                        </Alert>
                        <div v-if="accounts?.data?.length > 0" class="w-full overflow-x-auto rounded-lg border border-onyx-200">
                            <table class="min-w-full">
                                <thead class="bg-onyx-50 rounded-lg">
                                    <tr class="border-b border-onyx-200">
                                        <th class="whitespace-nowrap p-4 text-start font-semibold">Nama lengkap</th>
                                        <th class="whitespace-nowrap p-4 text-start font-semibold">Email</th>
                                        <th class="whitespace-nowrap p-4 text-start font-semibold">Role</th>
                                        <th class="whitespace-nowrap p-4 text-start font-semibold">Status</th>
                                        <th class="whitespace-nowrap p-4 text-start font-semibold">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="account in accounts.data" :key="account.id">
                                        <td class="whitespace-nowrap p-4 align-middle">{{ account.name }}</td>
                                        <td class="whitespace-nowrap p-4 align-middle">{{ account.email }}</td>
                                        <td class="whitespace-nowrap p-4 align-middle">
                                            <Badge :variant="UserRole.from(account.role).variant">{{ UserRole.from(account.role).label }}</Badge>
                                        </td>
                                        <td class="whitespace-nowrap p-4 align-middle">
                                            <Badge v-if="account.is_active" variant="success">Aktif</Badge>
                                            <Badge v-else variant="success">Nonaktif</Badge>
                                        </td>
                                        <td class="whitespace-nowrap p-4 align-middle">
                                            <Link href="#">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-icon lucide-eye"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>
                                            </Link>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="flex justify-center">
                        <div class="flex justify-center items-center flex-wrap gap-3">
                            <template v-for="link in links" :key="link.label">
                                <Link v-if="link.url" :class="cn('px-4 py-2 rounded-lg', link.active && 'bg-primary text-white')" :href="link.url" v-html="link.label" />
                                <span v-else class="px-4 py-2" v-html="link.label" />
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </SuperAdminLayout>
</template>
