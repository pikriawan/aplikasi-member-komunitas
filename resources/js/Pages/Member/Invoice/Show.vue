<script setup>
import { Form, usePage } from "@inertiajs/vue3";
import { computed, useTemplateRef } from "vue";
import DashboardHeader from "../../../Components/DashboardHeader.vue";
import Alert from "../../../Components/Ui/Alert.vue";
import Badge from "../../../Components/Ui/Badge.vue";
import Button from "../../../Components/Ui/Button.vue";
import Popover from "../../../Components/Ui/Popover.vue";
import PopoverContent from "../../../Components/Ui/PopoverContent.vue";
import PopoverTrigger from "../../../Components/Ui/PopoverTrigger.vue";
import TextField from "../../../Components/Ui/TextField.vue";
import InvoiceStatus from "../../../Enums/InvoiceStatus.js";
import MemberLayout from "../../../Layouts/MemberLayout.vue";
import { cn } from "../../../lib/utils.js";

const page = usePage();

const appUrl = computed(() => page.props.appUrl);
const storageUrl = computed(() => page.props.storageUrl);
const setting = computed(() => page.props.setting);
const messages = computed(() => page.flash.messages);
const invoice = computed(() => page.props.invoice);
const payment = computed(() => invoice.value?.payment);

const paymentProof = useTemplateRef("payment-proof");
const paymentProofInput = useTemplateRef("payment-proof-image");

function onPaymentProofInputChange(event) {
    const fileList = event.target.files;

    if (fileList.length === 1) {
        paymentProof.value.src = URL.createObjectURL(fileList[0]);
    }
}
</script>

<template>
    <MemberLayout>
        <DashboardHeader title="Rincian Tagihan" :back-href="route('member.invoices.index')">
            <Popover v-if="invoice.status === InvoiceStatus.Unpaid.value" class="h-full aspect-square">
                <PopoverTrigger class="w-full h-full flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ellipsis-vertical-icon lucide-ellipsis-vertical"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                </PopoverTrigger>
                <PopoverContent class="top-[calc(100%-1rem)] right-4 flex flex-col gap-px bg-onyx-200">
                    <button form="edit_invoice" class="flex items-center gap-4 p-4 bg-white first:rounded-t-[0.4375rem] last:rounded-b-[0.4375rem] whitespace-nowrap">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-icon lucide-file shrink-0"><path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"/><path d="M14 2v5a1 1 0 0 0 1 1h5"/></svg>
                        Simpan bukti pembayaran
                    </button>
                    <Form class="flex first:rounded-t-[0.4375rem] last:rounded-b-[0.4375rem] bg-white text-red-500" :action="route('member.invoices.cancel', invoice.id)" method="put">
                        <button class="w-full flex items-center gap-4 p-4 whitespace-nowrap">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-minus-icon lucide-circle-minus shrink-0"><circle cx="12" cy="12" r="10"/><path d="M8 12h8"/></svg>
                            Batalkan tagihan
                        </button>
                    </Form>
                </PopoverContent>
            </Popover>
        </DashboardHeader>
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
                        <div class="flex flex-col gap-8">
                            <h2 class="font-semibold text-2xl">Rincian Tagihan</h2>
                            <div class="w-full lg:max-w-150 flex flex-col gap-6 lg:gap-4">
                                <div class="flex flex-col gap-2 lg:grid grid-cols-2">
                                    <p>Nomor invoice</p>
                                    <p class="font-semibold">{{ invoice.number }}</p>
                                </div>
                                <div class="flex flex-col gap-2 lg:grid grid-cols-2">
                                    <p>Tanggal tagihan</p>
                                    <p class="font-semibold">{{ invoice.long_date }}</p>
                                </div>
                                <div class="flex flex-col gap-2 lg:grid grid-cols-2">
                                    <p>Tanggal kadaluarsa</p>
                                    <p class="font-semibold">{{ invoice.due_date }}</p>
                                </div>
                                <div class="flex flex-col gap-2 lg:grid grid-cols-2">
                                    <p>Jumlah</p>
                                    <p class="font-semibold">{{ Intl.NumberFormat("id-ID", { style: "currency", currency: "IDR" }).format(Number(invoice.amount || "0")) }}</p>
                                </div>
                                <div class="flex flex-col gap-2 lg:grid grid-cols-2">
                                    <p>Atas nama rekening tujuan</p>
                                    <p class="font-semibold">{{ setting.account_holder_name || "-" }}</p>
                                </div>
                                <div class="flex flex-col gap-2 lg:grid grid-cols-2">
                                    <p>Nomor rekening tujuan</p>
                                    <p class="font-semibold">{{ setting.account_number || "-" }}</p>
                                </div>
                                <div class="flex flex-col gap-2 lg:grid grid-cols-2">
                                    <p>Nama bank tujuan</p>
                                    <p class="font-semibold">{{ setting.bank_name || "-" }}</p>
                                </div>
                                <div class="flex flex-col gap-2 lg:grid grid-cols-2">
                                    <p>Status</p>
                                    <div>
                                        <Badge :variant="InvoiceStatus.from(invoice.status).variant">{{ InvoiceStatus.from(invoice.status).label }}</Badge>
                                    </div>
                                </div>
                                <div v-if="payment.reject_reason" class="flex flex-col gap-2 lg:grid grid-cols-2">
                                    <p>Alasan penolakan</p>
                                    <p class="font-semibold">{{ payment.reject_reason }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col gap-8">
                            <h2 class="font-semibold text-2xl">Pembayaran</h2>
                            <Form id="edit_invoice" class="flex flex-col gap-8" :action="route('member.invoices.update', invoice.id)" method="post" v-slot="{ errors }">
                                <div class="flex flex-col gap-4 lg:max-w-150">
                                    <label class="font-semibold">Bukti pembayaran</label>
                                    <img :src="payment.payment_proof_url ? `${storageUrl}/${payment.payment_proof_url}` : `${appUrl}/images/payment-proof-placeholder.svg`" alt="Payment Proof" class="w-32 aspect-square object-cover rounded-lg border border-onyx-200" ref="payment-proof">
                                    <template v-if="invoice.status === InvoiceStatus.Unpaid.value">
                                        <div class="flex gap-2 text-onyx-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-alert-icon lucide-circle-alert shrink-0"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                                            Format JPG atau PNG, ukuran maksimal 1MB
                                        </div>
                                        <div class="flex flex-wrap gap-4">
                                            <input type="file" accept=".jpg, .jpeg, .png" class="hidden" name="payment_proof" id="payment_proof" @change="onPaymentProofInputChange" ref="payment-proof-input">
                                            <Button as="label" for="payment_proof" class="whitespace-nowrap">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-upload-icon lucide-upload shrink-0"><path d="M12 3v12"/><path d="m17 8-5-5-5 5"/><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/></svg>
                                                Unggah bukti pembayaran
                                            </Button>
                                        </div>
                                    </template>
                                    <p class="text-danger-500 text-sm" v-if="errors.payment_proof">{{ errors.payment_proof }}</p>
                                </div>
                                <div class="flex flex-col gap-2 lg:max-w-150">
                                    <label for="date" class="font-semibold">Tanggal pembayaran</label>
                                    <TextField class="w-full appearance-[textfield] [&::-webkit-outer-spin-button]:appearance-[textfield] [&::-webkit-inner-spin-button]:appearance-[textfield]" id="date" name="date" type="datetime-local" placeholder="Tanggal pembayaran" :value="payment.date" :disabled="invoice.status !== InvoiceStatus.Unpaid.value" />
                                    <p class="text-danger-500 text-sm" v-if="errors.date">{{ errors.date }}</p>
                                </div>
                                <div class="flex flex-col gap-2 lg:max-w-150">
                                    <label for="account_holder_name" class="font-semibold">Atas nama pengirim</label>
                                    <TextField id="account_holder_name" name="account_holder_name" placeholder="Atas nama pengirim" :value="payment.account_holder_name" :disabled="invoice.status !== InvoiceStatus.Unpaid.value" />
                                    <p class="text-danger-500 text-sm" v-if="errors.account_holder_name">{{ errors.account_holder_name }}</p>
                                </div>
                                <div class="flex flex-col gap-2 lg:max-w-150">
                                    <label for="account_number" class="font-semibold">Nomor rekening pengirim</label>
                                    <TextField id="account_number" name="account_number" placeholder="Nomor rekening pengirim" :value="payment.account_number" :disabled="invoice.status !== InvoiceStatus.Unpaid.value" />
                                    <p class="text-danger-500 text-sm" v-if="errors.account_number">{{ errors.account_number }}</p>
                                </div>
                                <div class="flex flex-col gap-2 lg:max-w-150">
                                    <label for="account_bank_name" class="font-semibold">Nama bank pengirim</label>
                                    <TextField id="account_bank_name" name="account_bank_name" placeholder="Nama bank pengirim" :value="payment.account_bank_name" :disabled="invoice.status !== InvoiceStatus.Unpaid.value" />
                                    <p class="text-danger-500 text-sm" v-if="errors.account_bank_name">{{ errors.account_bank_name }}</p>
                                </div>
                            </Form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </MemberLayout>
</template>
