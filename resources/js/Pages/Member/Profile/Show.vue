<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { computed, useTemplateRef, watchEffect } from "vue";
import DashboardHeader from "../../../Components/DashboardHeader.vue";
import Badge from "../../../Components/Ui/Badge.vue";
import Button from "../../../Components/Ui/Button.vue";
import Modal from "../../../Components/Ui/Modal.vue";
import ModalTrigger from "../../../Components/Ui/ModalTrigger.vue";
import ModalClose from "../../../Components/Ui/ModalClose.vue";
import ModalContent from "../../../Components/Ui/ModalContent.vue";
import Popover from "../../../Components/Ui/Popover.vue";
import PopoverContent from "../../../Components/Ui/PopoverContent.vue";
import PopoverTrigger from "../../../Components/Ui/PopoverTrigger.vue";
import MemberLayout from "../../../Layouts/MemberLayout.vue";

const page = usePage();

const appUrl = computed(() => page.props.appUrl);
const storageUrl = computed(() => page.props.storageUrl);
const user = computed(() => page.props.user);
const memberProfile = computed(() => page.props.memberProfile);

const memberCard = useTemplateRef("member-card");

watchEffect(() => {
    if (memberCard.value) {
        drawMemberCard(memberCard.value);
    }
});

function loadImage(src) {
    return new Promise((resolve) => {
        const image = new Image();
        image.src = src;
        image.onload = () => resolve(image);
    });
}

function drawMemberCardProfileImage(ctx, image, x, y, size) {
    const sourceSize = Math.min(image.width, image.height);

    const sourceX = (image.width - sourceSize) / 2;
    const sourceY = (image.height - sourceSize) / 2;

    ctx.drawImage(
        image,
        sourceX,
        sourceY,
        sourceSize,
        sourceSize,
        x,
        y,
        size,
        size
    );
}

async function drawMemberCard(memberCard) {
    const canvasWidth = 600;
    const canvasHeight = canvasWidth * 9 / 16;
    const scale = devicePixelRatio;

    const canvas = document.createElement("canvas");
    canvas.width = canvasWidth * scale;
    canvas.height = canvasHeight * scale;
    canvas.style.width = `${canvasWidth}px`;
    canvas.style.height = `${canvasHeight}px`;

    const ctx = canvas.getContext("2d");
    ctx.scale(scale, scale);

    const computedStyles = getComputedStyle(document.documentElement);
    const primaryColor = computedStyles.getPropertyValue("--color-primary");
    const surfaceColor = computedStyles.getPropertyValue("--color-surface");
    const fontGeist = computedStyles.getPropertyValue("--font-geist");

    ctx.clearRect(0, 0, canvasWidth, canvasHeight);

    ctx.beginPath();
    ctx.rect(0, 0, canvasWidth, canvasHeight);
    ctx.fillStyle = surfaceColor;
    ctx.fill();
    ctx.closePath();

    const cardPadding = canvasWidth / 20;

    const profileImage = await loadImage(memberProfile.value.image_url ? `${storageUrl.value}/${memberProfile.value.image_url}` : `${appUrl.value}/images/profile-placeholder.svg`);
    const profileImageSize = canvasWidth / 8;
    const profileImageX = cardPadding;
    const profileImageY = canvasHeight / 2 - profileImageSize / 2;

    drawMemberCardProfileImage(ctx, profileImage, profileImageX, profileImageY, profileImageSize);

    ctx.beginPath();
    ctx.rect(
        profileImageX,
        profileImageY,
        profileImageSize,
        profileImageSize
    );
    ctx.lineWidth = 1;
    ctx.strokeStyle = primaryColor;
    ctx.stroke();
    ctx.closePath();

    const name = user.value.name;
    const nameFont = `normal 600 ${canvasWidth / 25}px ${fontGeist}`;
    ctx.font = nameFont;
    const nameText = ctx.measureText(name);
    const nameHeight = nameText.actualBoundingBoxAscent + nameText.actualBoundingBoxDescent;

    const memberId = memberProfile.value.id;
    const memberIdFont = `${canvasWidth / 33.33}px ${fontGeist}`;
    ctx.font = memberIdFont;
    const memberIdText = ctx.measureText(memberId);
    const memberIdHeight = memberIdText.actualBoundingBoxAscent + memberIdText.actualBoundingBoxDescent;

    const gap = canvasWidth / 12.5;
    const textGap = canvasWidth / 25;

    const textHeight = nameHeight + textGap + memberIdHeight;

    const nameX = cardPadding + profileImageSize + gap;
    const nameY = profileImageY + (profileImageSize - textHeight) / 2;

    const memberIdX = nameX;
    const memberIdY = nameY + nameHeight + textGap;

    ctx.textBaseline = "top";
    ctx.font = nameFont;
    ctx.fillStyle = "black";
    ctx.fillText(name, nameX, nameY);

    ctx.textBaseline = "top";
    ctx.font = memberIdFont;
    ctx.fillStyle = "black";
    ctx.fillText(memberId, memberIdX, memberIdY);

    const membershipUntil = `Berlaku hingga: ${memberProfile.value.membership_until}`;
    const membershipUntilText = ctx.measureText(membershipUntil);

    const membershipUntilX = cardPadding;
    const membershipUntilY = canvasHeight - cardPadding;

    ctx.textBaseline = "bottom";
    ctx.fillText(membershipUntil, membershipUntilX, membershipUntilY);

    const dataURL = canvas.toDataURL();
    memberCard.src = dataURL;
}

function downloadMemberCard() {
    const a = document.createElement("a");
    a.href = memberCard.value.src;
    a.download = "Member Card.png";
    a.click();
}
</script>

<template>
    <MemberLayout>
        <DashboardHeader title="Profil">
            <Popover class="h-full aspect-square">
                <PopoverTrigger class="w-full h-full flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ellipsis-vertical-icon lucide-ellipsis-vertical"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                </PopoverTrigger>
                <PopoverContent class="top-[calc(100%-1rem)] right-4 flex flex-col gap-px bg-onyx-200">
                    <Link class="flex items-center gap-4 p-4 bg-white first:rounded-t-[0.4375rem] last:rounded-b-[0.4375rem] whitespace-nowrap" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen-icon lucide-square-pen shrink-0"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/></svg>
                        Edit profil
                    </Link>
                </PopoverContent>
            </Popover>
        </DashboardHeader>
        <main class="w-full h-full overflow-auto">
            <div class="flex flex-col gap-8 p-8">
                <div class="flex flex-col gap-8 lg:flex-row lg:items-center">
                    <img :src="memberProfile.image_url ? `${storageUrl}/${memberProfile.image_url}` : `${appUrl}/images/profile-placeholder.svg`" alt="Profile" class="w-32 aspect-square object-cover rounded-full">
                    <div class="flex flex-col gap-4">
                        <h2 class="font-semibold text-[1.25rem]">{{ user.name }}</h2>
                        <div class="flex flex-col gap-4 lg:flex-row lg:flex-wrap">
                            <div class="flex items-center gap-2.5 text-onyx-400 font-semibold">
                                <span class="p-1 rounded-full bg-onyx-50 text-onyx-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-building-icon lucide-building"><path d="M12 10h.01"/><path d="M12 14h.01"/><path d="M12 6h.01"/><path d="M16 10h.01"/><path d="M16 14h.01"/><path d="M16 6h.01"/><path d="M8 10h.01"/><path d="M8 14h.01"/><path d="M8 6h.01"/><path d="M9 22v-3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3"/><rect x="4" y="2" width="16" height="20" rx="2"/></svg>
                                </span>
                                {{ memberProfile.institution || "-" }}
                            </div>
                            <div class="flex items-center gap-2.5 text-onyx-400 font-semibold">
                                <span class="p-1 rounded-full bg-onyx-50 text-onyx-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-icon lucide-users"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><path d="M16 3.128a4 4 0 0 1 0 7.744"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><circle cx="9" cy="7" r="4"/></svg>
                                </span>
                                {{ memberProfile.department || "-" }}
                            </div>
                            <div class="flex items-center gap-2.5 text-onyx-400 font-semibold">
                                <span class="p-1 rounded-full bg-onyx-50 text-onyx-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail-icon lucide-mail"><path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"/><rect x="2" y="4" width="20" height="16" rx="2"/></svg>
                                </span>
                                {{ user.email }}
                            </div>
                        </div>
                        <div class="flex flex-col gap-4 lg:flex-row lg:flex-wrap">
                            <div class="lg:min-w-50 flex flex-col gap-4 p-4 rounded-lg border border-dashed border-onyx-200">
                                <div class="flex items-center gap-2.5 font-semibold">
                                    <span class="p-1 rounded-full bg-success-50 text-success-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-id-card-icon lucide-id-card"><path d="M16 10h2"/><path d="M16 14h2"/><path d="M6.17 15a3 3 0 0 1 5.66 0"/><circle cx="9" cy="11" r="2"/><rect x="2" y="5" width="20" height="14" rx="2"/></svg>
                                    </span>
                                    {{ memberProfile.id }}
                                </div>
                                <p class="text-onyx-400">Nomor Anggota</p>
                            </div>
                            <div class="lg:min-w-50 flex flex-col gap-4 p-4 rounded-lg border border-dashed border-onyx-200">
                                <div class="flex items-center gap-2.5 font-semibold">
                                    <span class="p-1 rounded-full bg-blue-50 text-blue-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-icon lucide-user"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                    </span>
                                    {{ memberProfile.is_active ? "Aktif" : "Nonaktif" }}
                                </div>
                                <p class="text-onyx-400">Status</p>
                            </div>
                            <div class="lg:min-w-50 flex flex-col gap-4 p-4 rounded-lg border border-dashed border-onyx-200">
                                <div class="flex items-center gap-2.5 font-semibold">
                                    <span class="p-1 rounded-full bg-violet-50 text-violet-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-days-icon lucide-calendar-days"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/><path d="M8 18h.01"/><path d="M12 18h.01"/><path d="M16 18h.01"/></svg>
                                    </span>
                                    {{ memberProfile.join_date }}
                                </div>
                                <p class="text-onyx-400">Bergabung Sejak</p>
                            </div>
                            <div class="lg:min-w-50 flex flex-col gap-4 p-4 rounded-lg border border-dashed border-onyx-200">
                                <div class="flex items-center gap-2.5 font-semibold">
                                    <span class="p-1 rounded-full bg-danger-50 text-danger-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-timer-icon lucide-timer"><line x1="10" x2="14" y1="2" y2="2"/><line x1="12" x2="15" y1="14" y2="11"/><circle cx="12" cy="14" r="8"/></svg>
                                    </span>
                                    {{ memberProfile.membership_until }}
                                </div>
                                <p class="text-onyx-400">Membership Hingga</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col gap-8">
                    <h2 class="font-semibold text-2xl">Informasi Pribadi</h2>
                    <div class="w-full max-w-150 flex flex-col gap-6 lg:gap-4">
                        <div class="flex flex-col gap-2 lg:grid grid-cols-2">
                            <p>Nama lengkap</p>
                            <p class="font-semibold">{{ user.name }}</p>
                        </div>
                        <div class="flex flex-col gap-2 lg:grid grid-cols-2">
                            <p>Email</p>
                            <p class="font-semibold">{{ user.email }}</p>
                        </div>
                        <div class="flex flex-col gap-2 lg:grid grid-cols-2">
                            <p>Nomor anggota</p>
                            <p class="font-semibold">{{ memberProfile.id }}</p>
                        </div>
                        <div class="flex flex-col gap-2 lg:grid grid-cols-2">
                            <p>Status</p>
                            <div>
                                <Badge v-if="memberProfile.is_active" variant="success">Aktif</Badge>
                                <Badge v-else variant="danger">Nonaktif</Badge>
                            </div>
                        </div>
                        <div class="flex flex-col gap-2 lg:grid grid-cols-2">
                            <p>Bergabung sejak</p>
                            <p class="font-semibold">{{ memberProfile.join_date }}</p>
                        </div>
                        <div class="flex flex-col gap-2 lg:grid grid-cols-2">
                            <p>Membership hingga</p>
                            <p class="font-semibold">{{ memberProfile.membership_until }}</p>
                        </div>
                        <div class="flex flex-col gap-2 lg:grid grid-cols-2">
                            <p>Institusi</p>
                            <p class="font-semibold">{{ memberProfile.institution || "-" }}</p>
                        </div>
                        <div class="flex flex-col gap-2 lg:grid grid-cols-2">
                            <p>Departemen</p>
                            <p class="font-semibold">{{ memberProfile.department || "-" }}</p>
                        </div>
                        <div class="flex flex-col gap-2 lg:grid grid-cols-2">
                            <p>Nomor telepon</p>
                            <p class="font-semibold">{{ user.telephone || "-" }}</p>
                        </div>
                        <div class="flex flex-col gap-2 lg:grid grid-cols-2">
                            <p>Alamat rumah</p>
                            <p class="font-semibold">{{ memberProfile.address || "-" }}</p>
                        </div>
                    </div>
                    <div class="flex flex-col lg:flex-row items-start lg:items-center gap-4">
                        <Modal>
                            <ModalTrigger :as="Button" class="font-geist" variant="outlined" :disabled="!memberProfile.is_active">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-icon lucide-eye shrink-0"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>
                                Pratinjau kartu member
                            </ModalTrigger>
                            <ModalContent class="font-geist flex flex-col gap-5">
                                <header class="flex justify-between gap-4">
                                    <h3 class="font-semibold">Pratinjau Kartu Member</h3>
                                    <ModalClose>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-icon lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                                    </ModalClose>
                                </header>
                                <img ref="member-card" src="" alt="Member Card" class="w-full lg:w-100 aspect-video object-cover rounded-lg">
                                <Button class="w-full justify-center" @click="downloadMemberCard">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-download-icon lucide-download shrink-0"><path d="M12 15V3"/><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="m7 10 5 5 5-5"/></svg>
                                    Unduh kartu member
                                </Button>
                            </ModalContent>
                        </Modal>
                        <Button variant="outlined" :disabled="!memberProfile.is_active">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-download-icon lucide-download shrink-0"><path d="M12 15V3"/><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="m7 10 5 5 5-5"/></svg>
                            Unduh surat keanggotaan
                        </Button>
                    </div>
                </div>
            </div>
        </main>
    </MemberLayout>
</template>
