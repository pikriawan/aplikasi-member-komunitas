<script setup>
import { Form } from "@inertiajs/vue3";
import { onMounted, useTemplateRef } from "vue";
import DashboardHeader from "../../../Components/DashboardHeader.vue";
import Button from "../../../Components/Ui/Button.vue";
import Popover from "../../../Components/Ui/Popover.vue";
import PopoverContent from "../../../Components/Ui/PopoverContent.vue";
import PopoverTrigger from "../../../Components/Ui/PopoverTrigger.vue";
import MemberLayout from "../../../Layouts/MemberLayout.vue";

const input = useTemplateRef("input");

onMounted(() => {
    input.value.focus();
});
</script>

<template>
    <MemberLayout>
        <DashboardHeader title="Pertanyaan" />
        <main class="flex-1 overflow-auto">
            <div class="flex flex-col w-full h-full">
                <div class="h-full overflow-y-auto">
                    <p class="h-1000"></p>
                </div>
                <div class="shrink-0 p-2">
                    <Form class="flex items-center gap-4 p-3 ring ring-inset ring-onyx-200 rounded-[1.25rem] focus-within:ring-primary">
                        <input class="w-full focus:outline-0" placeholder="Tulis pertanyaan" ref="input">
                        <Button>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-send-horizontal-icon lucide-send-horizontal shrink-0"><path d="M3.714 3.048a.498.498 0 0 0-.683.627l2.843 7.627a2 2 0 0 1 0 1.396l-2.842 7.627a.498.498 0 0 0 .682.627l18-8.5a.5.5 0 0 0 0-.904z"/><path d="M6 12h16"/></svg>
                            Kirim
                        </Button>
                    </Form>
                </div>
            </div>
        </main>
    </MemberLayout>
</template>
