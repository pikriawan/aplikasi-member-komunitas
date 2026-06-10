<script setup>
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import DashboardHeader from "../../../Components/DashboardHeader.vue";
import Alert from "../../../Components/Ui/Alert.vue";
import MemberLayout from "../../../Layouts/MemberLayout.vue";

const page = usePage();

const messages = computed(() => page.flash.messages);
</script>

<template>
    <MemberLayout>
        <DashboardHeader title="Pembayaran" />
        <main class="flex-1 overflow-auto">
            <div class="flex flex-col gap-8 p-8 lg:min-h-full">
                <div class="flex-1 flex flex-col gap-8 justify-between">
                    <div class="flex flex-col gap-8">
                        <Alert v-for="message in messages" :variant="message.variant" :key="message.text">
                            {{ message.text }}
                        </Alert>
                    </div>
                </div>
            </div>
        </main>
    </MemberLayout>
</template>
