<script setup>
import { Link, useForm, usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import Alert from "../../../components/Alert.vue";
import Button from "../../../components/Button.vue";
import MemberLayout from "../../../layouts/MemberLayout.vue";
import { cn } from "../../../lib/utils";

const page = usePage();

const error = computed(() => page.props.error);
const conversation = computed(() => page.props.conversation);
const messages = computed(() => page.props.messages ? Object.entries(page.props.messages) : []);
const user = computed(() => page.props.auth?.user);

const form = useForm({
    content: null
});
</script>

<template>
    <MemberLayout v-slot="{ setSidebarShow }">
        <header class="sticky top-0 h-14 flex items-center lg:gap-4 shadow-[0_-0.0625rem_0_#CCCCCC_inset] lg:h-20 lg:px-8 bg-white">
            <Link class="h-full lg:h-8 aspect-square flex items-center justify-center" href="/member/questions">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-left-icon lucide-chevron-left"><path d="m15 18-6-6 6-6"/></svg>
            </Link>
            <h1 class="w-full font-semibold lg:text-2xl">{{ conversation?.ticket_number ? `#${conversation.ticket_number}` : "Pertanyaan Tidak Ditemukan" }}</h1>
        </header>
        <div class="overflow-x-auto lg:w-full lg:h-full">
            <div class="lg:h-full lg:relative flex flex-col">
                <div class="w-full flex flex-col p-8" v-if="conversation.is_closed">
                    <Alert variant="success">Pertanyaan ini telah ditandai sebagai selesai.</Alert>
                </div>
                <div class="w-full flex flex-col p-8" v-if="error">
                    <Alert variant="danger">{{ error }}</Alert>
                </div>
                <div class="flex flex-col gap-8 w-full" v-else>
                    <div class="flex flex-col gap-8 lg:overflow-y-auto p-5 pb-28 lg:p-8 lg:pb-31">
                        <template v-if="messages.length > 0" v-for="[date, messageList] in messages">
                            <p class="text-center">{{ date }}</p>
                            <template v-for="message in messageList">
                                <div :class="cn('flex', user?.id === message.sender_id && 'justify-end')">
                                    <div :class="cn('w-full max-w-100 flex flex-col gap-3 p-5 bg-[#F2F2F2] rounded-xl', user?.id === message.sender_id ? 'rounded-tr' : 'rounded-tl')">
                                        <p class="font-medium">
                                            {{ user?.id === message.sender_id ? "Saya" : "Petugas" }}
                                            •
                                            {{ message.time }}
                                        </p>
                                        <p>{{ message.content }}</p>
                                    </div>
                                </div>
                            </template>
                        </template>
                        <Alert variant="danger" v-if="form.errors.content">{{ form.errors.content }}</Alert>
                    </div>
                    <div class="fixed lg:absolute bottom-0 left-0 w-full flex flex-col px-5 pb-5 bg-white" v-if="!conversation.is_closed">
                        <form 
                            class="flex gap-4 p-3 rounded-xl shadow-[0_0_0_0.0625rem_#CCCCCC_inset]" 
                            @submit.prevent="() => {
                                form.clearErrors();
                                form.post(`/member/questions/${conversation.ticket_number}/send`, {
                                    onSuccess() {
                                        form.reset();
                                    }
                                });
                            }"
                        >
                            <input class="w-full focus:outline-0" placeholder="Tulis pertanyaan" autofocus v-model="form.content" />
                            <Button>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-send-horizontal-icon lucide-send-horizontal"><path d="M3.714 3.048a.498.498 0 0 0-.683.627l2.843 7.627a2 2 0 0 1 0 1.396l-2.842 7.627a.498.498 0 0 0 .682.627l18-8.5a.5.5 0 0 0 0-.904z"/><path d="M6 12h16"/></svg>
                                Kirim
                            </Button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </MemberLayout>
</template>
