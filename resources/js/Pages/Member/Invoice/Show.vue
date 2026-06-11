<script setup>
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import DashboardHeader from "../../../Components/DashboardHeader.vue";
import Alert from "../../../Components/Ui/Alert.vue";
import InvoiceStatus from "../../../Enums/InvoiceStatus.js";
import MemberLayout from "../../../Layouts/MemberLayout.vue";
import { cn } from "../../../lib/utils.js";

const page = usePage();

const messages = computed(() => page.flash.messages);
const invoice = computed(() => page.props.invoice);
</script>

<template>
    <MemberLayout>
        <DashboardHeader title="Rincian Tagihan" :back-href="route('member.invoices.index')" />
        <main class="flex-1 overflow-auto">
            <div class="flex flex-col gap-8 p-8 lg:min-h-full">
                <div class="flex-1 flex flex-col gap-8 justify-between">
                    <div class="flex flex-col gap-8">
                        <div v-if="invoice" class="flex flex-col lg:flex-row gap-8">
                            <div class="flex items-center gap-4">
                                <div :class="cn('rounded-full w-8 h-8 flex justify-center items-center font-semibold text-sm bg-onyx-50 text-onyx-400', invoice.status === InvoiceStatus.Unpaid.value && 'bg-surface text-primary', [InvoiceStatus.Paid.value, InvoiceStatus.Verified.value].includes(invoice.status) && 'bg-success-50 text-success-600')">
                                    <svg v-if="[InvoiceStatus.Paid.value, InvoiceStatus.Verified.value].includes(invoice.status)" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-icon lucide-check text-success-600"><path d="M20 6 9 17l-5-5"/></svg>
                                    <span v-else>1</span>
                                </div>
                                <span :class="cn('font-semibold text-[1.25rem] text-onyx-800', invoice.status === InvoiceStatus.Unpaid.value && 'text-primary', [InvoiceStatus.Paid.value, InvoiceStatus.Verified.value].includes(invoice.status) && 'text-success-600')">Pembayaran</span>
                            </div>
                            <div class="w-8 h-8 lg:w-full lg:h-auto flex justify-center items-center">
                                <span class="w-px h-full lg:w-full lg:h-px bg-onyx-200" />
                            </div>
                            <div class="flex items-center gap-4">
                                <div :class="cn('rounded-full w-8 h-8 flex justify-center items-center font-semibold text-sm bg-onyx-50 text-onyx-400', invoice.status === InvoiceStatus.Paid.value && 'bg-surface text-primary', invoice.status === InvoiceStatus.Verified.value && 'bg-success-50 text-success-600')">
                                    <svg v-if="invoice.status === InvoiceStatus.Verified.value" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-icon lucide-check text-success-600"><path d="M20 6 9 17l-5-5"/></svg>
                                    <span v-else>2</span>
                                </div>
                                <span :class="cn('font-semibold text-[1.25rem] text-onyx-800', invoice.status === InvoiceStatus.Paid.value && 'text-primary', invoice.status === InvoiceStatus.Verified.value && 'text-success-600')">Verifikasi</span>
                            </div>
                            <div class="w-8 h-8 lg:w-full lg:h-auto flex justify-center items-center">
                                <span class="w-px h-full lg:w-full lg:h-px bg-onyx-200" />
                            </div>
                            <div class="flex items-center gap-4">
                                <div :class="cn('rounded-full w-8 h-8 flex justify-center items-center font-semibold text-sm bg-onyx-50 text-onyx-400', invoice.status === InvoiceStatus.Verified.value && 'bg-success-50 text-success-600')">
                                    <svg v-if="invoice.status === InvoiceStatus.Verified.value" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-icon lucide-check text-success-600"><path d="M20 6 9 17l-5-5"/></svg>
                                    <span v-else>3</span>
                                </div>
                                <span :class="cn('font-semibold text-[1.25rem] text-onyx-800', invoice.status === InvoiceStatus.Verified.value && 'text-success-600')">Aktif</span>
                            </div>
                        </div>
                        <Alert v-for="message in messages" :variant="message.variant" :key="message.text">
                            {{ message.text }}
                        </Alert>
                    </div>
                </div>
            </div>
        </main>
    </MemberLayout>
</template>
