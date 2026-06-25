<script setup>
import { Form, usePage } from "@inertiajs/vue3";
import { computed, useTemplateRef } from "vue";
import DashboardHeader from "../../../Components/DashboardHeader.vue";
import Alert from "../../../Components/Ui/Alert.vue";
import Badge from "../../../Components/Ui/Badge.vue";
import Button from "../../../Components/Ui/Button.vue";
import Modal from "../../../Components/Ui/Modal.vue";
import ModalClose from "../../../Components/Ui/ModalClose.vue";
import ModalContent from "../../../Components/Ui/ModalContent.vue";
import ModalTrigger from "../../../Components/Ui/ModalTrigger.vue";
import Popover from "../../../Components/Ui/Popover.vue";
import PopoverContent from "../../../Components/Ui/PopoverContent.vue";
import PopoverTrigger from "../../../Components/Ui/PopoverTrigger.vue";
import TextField from "../../../Components/Ui/TextField.vue";
import InvoiceStatus from "../../../Enums/InvoiceStatus.js";
import FinanceLayout from "../../../Layouts/FinanceLayout.vue";
import { cn } from "../../../lib/utils.js";

const page = usePage();

const appUrl = computed(() => page.props.appUrl);
const storageUrl = computed(() => page.props.storageUrl);
const setting = computed(() => page.props.setting);
const messages = computed(() => page.flash.messages);
const invoice = computed(() => page.props.invoice);
const payment = computed(() => invoice.value?.payment);
</script>

<template>
    <FinanceLayout>
        <DashboardHeader title="Rincian Tagihan" :back-href="route('finance.invoices.index')">
            <Popover v-if="invoice?.status === InvoiceStatus.Paid.value" class="h-full aspect-square">
                <PopoverTrigger class="w-full h-full flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ellipsis-vertical-icon lucide-ellipsis-vertical"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                </PopoverTrigger>
                <PopoverContent class="top-[calc(100%-1rem)] right-4 flex flex-col gap-px bg-onyx-200">
                    <Form class="flex first:rounded-t-[0.4375rem] last:rounded-b-[0.4375rem] bg-white" :action="route('finance.invoices.accept', invoice.id)" method="put">
                        <button class="w-full flex items-center gap-4 p-4 whitespace-nowrap">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-icon lucide-check shrink-0"><path d="M20 6 9 17l-5-5"/></svg>
                            Terima pembayaran
                        </button>
                    </Form>
                    <Modal>
                        <ModalTrigger form="edit_invoice" class="flex items-center gap-4 p-4 bg-white text-red-500 first:rounded-t-[0.4375rem] last:rounded-b-[0.4375rem] whitespace-nowrap">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-minus-icon lucide-circle-minus shrink-0"><circle cx="12" cy="12" r="10"/><path d="M8 12h8"/></svg>
                            Tolak pembayaran
                        </ModalTrigger>
                        <ModalContent :as="Form" class="lg:min-w-150 font-geist" :action="route('finance.invoices.reject', invoice.id)" method="put">
                            <div class="flex flex-col gap-5">
                                <header class="flex justify-between items-center gap-4">
                                    <h3 class="font-semibold">Alasan penolakan</h3>
                                    <ModalClose class="shrink-0" type="button">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-icon lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                                    </ModalClose>
                                </header>
                                <TextField as="textarea" name="reject_reason" placeholder="Alasan penolakan" />
                                <div class="flex gap-4">
                                    <ModalClose type="button" class="w-full justify-center" :as="Button" variant="outlined">Batal</ModalClose>
                                    <Button class="w-full justify-center">Simpan</Button>
                                </div>
                            </div>
                        </ModalContent>
                    </Modal>
                </PopoverContent>
            </Popover>
        </DashboardHeader>
        <main class="flex-1 overflow-auto">
            <div class="flex flex-col gap-8 p-8 lg:min-h-full">
                <div class="flex-1 flex flex-col gap-8 justify-between">
                    <div class="flex flex-col gap-8">
                        <Alert v-for="message in messages" :variant="message.variant" :key="message.text">
                            {{ message.text }}
                        </Alert>
                        <div v-if="invoice" class="flex flex-col gap-8">
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
                        <div v-if="payment" class="flex flex-col gap-8">
                            <h2 class="font-semibold text-2xl">Pembayaran</h2>
                            <div class="w-full lg:max-w-150 flex flex-col gap-6 lg:gap-4">
                                <div class="flex flex-col gap-2">
                                    <p class="font-semibold text-[1.25rem]">Bukti pembayaran</p>
                                    <img :src="payment.payment_proof_url ? `${storageUrl}/${payment.payment_proof_url}` : `${appUrl}/images/payment-proof-placeholder.svg`" alt="Payment Proof" class="w-32 aspect-square object-cover rounded-lg border border-onyx-200">
                                </div>
                                <div class="flex flex-col gap-2 lg:grid grid-cols-2">
                                    <p>Tanggal pembayaran</p>
                                    <p class="font-semibold">{{ payment.long_date || "-" }}</p>
                                </div>
                                <div class="flex flex-col gap-2 lg:grid grid-cols-2">
                                    <p>Atas nama pengirim</p>
                                    <p class="font-semibold">{{ payment.account_holder_name || "-" }}</p>
                                </div>
                                <div class="flex flex-col gap-2 lg:grid grid-cols-2">
                                    <p>Nomor rekening pengirim</p>
                                    <p class="font-semibold">{{ payment.account_number || "-" }}</p>
                                </div>
                                <div class="flex flex-col gap-2 lg:grid grid-cols-2">
                                    <p>Nama bank pengirim</p>
                                    <p class="font-semibold">{{ payment.account_bank_name || "-" }}</p>
                                </div>
                                <div v-if="payment.reject_reason" class="flex flex-col gap-2 lg:grid grid-cols-2">
                                    <p>Alasan penolakan</p>
                                    <p class="font-semibold">{{ payment.reject_reason }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </FinanceLayout>
</template>
