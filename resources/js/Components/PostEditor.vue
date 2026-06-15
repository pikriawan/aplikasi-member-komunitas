<script setup>
import { router } from "@inertiajs/vue3";
import Image from "@tiptap/extension-image";
import TextAlign from "@tiptap/extension-text-align";
import { Color, TextStyle } from "@tiptap/extension-text-style";
import StarterKit from "@tiptap/starter-kit";
import { Editor, EditorContent } from "@tiptap/vue-3";
import { onBeforeUnmount, onMounted, ref, watch } from "vue";
import { cn } from "../lib/utils";

const props = defineProps({
    modelValue: {
        type: String,
        default: ""
    },
});

const emit = defineEmits(["update:modelValue"]);

const editor = ref();

onMounted(() => {
    editor.value = new Editor({
        extensions: [
            StarterKit,
            TextStyle,
            Color,
            Image,
            TextAlign.configure({
                types: ["heading", "paragraph"]
            }),
        ],
        content: props.modelValue,
        onUpdate: () => {
            emit("update:modelValue", editor.value.getHTML());
        }
    });
});

onBeforeUnmount(() => {
    editor.value.destroy();
})

watch(
    () => props.modelValue,
    (value) => {
        const isSame = editor.value.getHTML() === value;

        if (isSame) {
            return;
        }

        editor.value.commands.setContent(value);
    }
);

function setLink() {
    const previousUrl = editor.value.getAttributes("link").href;
    const url = window.prompt("URL", previousUrl);

    if (url === null) {
        return;
    }

    if (url === "") {
        editor.value.chain().focus().extendMarkRange("link").unsetLink().run();

        return;
    }

    editor.value.chain().focus().extendMarkRange("link").setLink({ href: url }).run();
}

function addImage(event) {
    const fileList = event.target.files;

    if (fileList.length === 0) {
        return;
    }

    const content = [];

    for (const file of fileList) {
        content.push({
            type: "image",
            attrs: {
                src: URL.createObjectURL(file)
            }
        });

        content.push({
            type: "paragraph"
        });
    }

    editor.value.chain().focus().insertContent(content).run();
}
</script>

<template>
    <div class="flex flex-col ring ring-inset ring-onyx-200 rounded-lg">
        <div class="p-2 flex items-center flex-wrap gap-1 shadow-[0_-0.0625rem_0_var(--color-onyx-200)_inset]">
            <button @click="editor.chain().focus().undo().run()" :disabled="!editor?.can().chain().focus().undo().run()" type="button" class="w-8 h-8 rounded flex justify-center items-center disabled:text-onyx-400">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-undo-icon lucide-undo"><path d="M3 7v6h6"/><path d="M21 17a9 9 0 0 0-9-9 9 9 0 0 0-6 2.3L3 13"/></svg>
            </button>
            <button @click="editor.chain().focus().redo().run()" :disabled="!editor?.can().chain().focus().redo().run()" type="button" class="w-8 h-8 rounded flex justify-center items-center disabled:text-onyx-400">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-redo-icon lucide-redo"><path d="M21 7v6h-6"/><path d="M3 17a9 9 0 0 1 9-9 9 9 0 0 1 6 2.3l3 2.7"/></svg>
            </button>
            <div class="h-4 flex justify-center items-center px-2">
                <span class="w-px h-full bg-onyx-200" />
            </div>
            <button @click="editor.chain().focus().toggleBold().run()" :disabled="!editor?.can().chain().focus().toggleBold().run()" type="button" :class="cn('w-8 h-8 rounded flex justify-center items-center disabled:text-onyx-400', editor?.isActive('bold') && 'bg-onyx-100')">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bold-icon lucide-bold"><path d="M6 12h9a4 4 0 0 1 0 8H7a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h7a4 4 0 0 1 0 8"/></svg>
            </button>
            <button @click="editor.chain().focus().toggleItalic().run()" :disabled="!editor?.can().chain().focus().toggleItalic().run()" type="button" :class="cn('w-8 h-8 rounded flex justify-center items-center disabled:text-onyx-400', editor?.isActive('italic') && 'bg-onyx-100')">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-italic-icon lucide-italic"><line x1="19" x2="10" y1="4" y2="4"/><line x1="14" x2="5" y1="20" y2="20"/><line x1="15" x2="9" y1="4" y2="20"/></svg>
            </button>
            <button @click="editor.chain().focus().toggleUnderline().run()" :disabled="!editor?.can().chain().focus().toggleUnderline().run()" type="button" :class="cn('w-8 h-8 rounded flex justify-center items-center disabled:text-onyx-400', editor?.isActive('underline') && 'bg-onyx-100')">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-underline-icon lucide-underline"><path d="M6 4v6a6 6 0 0 0 12 0V4"/><line x1="4" x2="20" y1="20" y2="20"/></svg>
            </button>
            <label for="color" :style="{ color: editor?.getAttributes('textStyle').color }">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-baseline-icon lucide-baseline"><path d="M4 20h16"/><path d="m6 16 6-12 6 12"/><path d="M8 12h8"/></svg>
            </label>
            <input id="color" @input="editor.chain().focus().setColor($event.target.value).run()" type="color" class="hidden">
            <div class="h-4 flex justify-center items-center px-2">
                <span class="w-px h-full bg-onyx-200" />
            </div>
            <button @click="setLink" type="button" :class="cn('w-8 h-8 rounded flex justify-center items-center disabled:text-onyx-400', editor?.isActive('link') && 'bg-onyx-100')">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-link2-icon lucide-link-2"><path d="M9 17H7A5 5 0 0 1 7 7h2"/><path d="M15 7h2a5 5 0 1 1 0 10h-2"/><line x1="8" x2="16" y1="12" y2="12"/></svg>
            </button>
            <button @click="editor.chain().focus().unsetLink().run()" type="button" class="w-8 h-8 rounded flex justify-center items-center disabled:text-onyx-400">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-link2-off-icon lucide-link-2-off"><path d="M9 17H7A5 5 0 0 1 7 7"/><path d="M15 7h2a5 5 0 0 1 4 8"/><line x1="8" x2="12" y1="12" y2="12"/><line x1="2" x2="22" y1="2" y2="22"/></svg>
            </button>
            <label for="image" type="button" class="w-8 h-8 rounded flex justify-center items-center disabled:text-onyx-400">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-image-plus-icon lucide-image-plus"><path d="M16 5h6"/><path d="M19 2v6"/><path d="M21 11.5V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7.5"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/><circle cx="9" cy="9" r="2"/></svg>
            </label>
            <input id="image" @input="addImage" type="file" accept=".jpg, .jpeg, .png" multiple class="hidden">
            <div class="h-4 flex justify-center items-center px-2">
                <span class="w-px h-full bg-onyx-200" />
            </div>
            <button @click="editor.chain().focus().setTextAlign('left').run()" type="button" :class="cn('w-8 h-8 rounded flex justify-center items-center disabled:text-onyx-400', editor?.isActive({ textAlign: 'left' }) && 'bg-onyx-100')">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-text-align-start-icon lucide-text-align-start"><path d="M21 5H3"/><path d="M15 12H3"/><path d="M17 19H3"/></svg>
            </button>
            <button @click="editor.chain().focus().setTextAlign('center').run()" type="button" :class="cn('w-8 h-8 rounded flex justify-center items-center disabled:text-onyx-400', editor?.isActive({ textAlign: 'center' }) && 'bg-onyx-100')">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-text-align-center-icon lucide-text-align-center"><path d="M21 5H3"/><path d="M17 12H7"/><path d="M19 19H5"/></svg>
            </button>
            <button @click="editor.chain().focus().setTextAlign('right').run()" type="button" :class="cn('w-8 h-8 rounded flex justify-center items-center disabled:text-onyx-400', editor?.isActive({ textAlign: 'right' }) && 'bg-onyx-100')">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-text-align-end-icon lucide-text-align-end"><path d="M21 5H3"/><path d="M21 12H9"/><path d="M21 19H7"/></svg>
            </button>
            <button @click="editor.chain().focus().setTextAlign('justify').run()" type="button" :class="cn('w-8 h-8 rounded flex justify-center items-center disabled:text-onyx-400', editor?.isActive({ textAlign: 'justify' }) && 'bg-onyx-100')">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-text-align-justify-icon lucide-text-align-justify"><path d="M3 5h18"/><path d="M3 12h18"/><path d="M3 19h18"/></svg>
            </button>
        </div>
        <editor-content :editor="editor" />
    </div>
</template>

<style>
.tiptap {
    padding: 0.75rem 1rem;
    min-height: 8rem;

    &:focus {
        outline: 0;
    }
}
</style>
