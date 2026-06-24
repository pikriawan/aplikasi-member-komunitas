<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import DashboardHeader from "../../../../Components/DashboardHeader.vue";
import Alert from "../../../../Components/Ui/Alert.vue";
import Badge from "../../../../Components/Ui/Badge.vue";
import LeaderLayout from "../../../../Layouts/LeaderLayout.vue";
import { cn } from "../../../../lib/utils.js";

const page = usePage();

const memberProfiles = computed(() => page.props.memberProfiles);
const messages = computed(() => page.flash.messages);

const links = computed(() => memberProfiles.value?.links.map((link) => {
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
    <LeaderLayout>
        <DashboardHeader title="Statistik Member" :back-href="route('leader.statistics.index')" />
        <main class="flex-1 overflow-auto">
            <div class="flex flex-col gap-8 p-8 lg:min-h-full">
                <div class="flex-1 flex flex-col gap-8 justify-between">
                    <div class="flex flex-col gap-8">
                        <Alert v-for="message in messages" :variant="message.variant" :key="message.text">
                            {{ message.text }}
                        </Alert>
                        <div v-if="memberProfiles?.data?.length > 0" class="w-full overflow-x-auto rounded-lg border border-onyx-200">
                            <table class="min-w-full">
                                <thead class="bg-onyx-50 rounded-lg">
                                    <tr class="border-b border-onyx-200">
                                        <th class="whitespace-nowrap p-4 text-start font-semibold">Nama lengkap</th>
                                        <th class="whitespace-nowrap p-4 text-start font-semibold">Email</th>
                                        <th class="whitespace-nowrap p-4 text-start font-semibold">Nomor anggota</th>
                                        <th class="whitespace-nowrap p-4 text-start font-semibold">Status membership</th>
                                        <th class="whitespace-nowrap p-4 text-start font-semibold">Bergabung sejak</th>
                                        <th class="whitespace-nowrap p-4 text-start font-semibold">Membership hingga</th>
                                        <th class="whitespace-nowrap p-4 text-start font-semibold">Jenis kelamin</th>
                                        <th class="whitespace-nowrap p-4 text-start font-semibold">Golongan darah</th>
                                        <th class="whitespace-nowrap p-4 text-start font-semibold">Pendidikan terakhir</th>
                                        <th class="whitespace-nowrap p-4 text-start font-semibold">Institusi</th>
                                        <th class="whitespace-nowrap p-4 text-start font-semibold">Departemen</th>
                                        <th class="whitespace-nowrap p-4 text-start font-semibold">Nomor telepon</th>
                                        <th class="whitespace-nowrap p-4 text-start font-semibold">Alamat rumah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="memberProfile in memberProfiles.data" :key="memberProfile.id">
                                        <td class="whitespace-nowrap p-4 align-middle">{{ memberProfile.user.name }}</td>
                                        <td class="whitespace-nowrap p-4 align-middle">{{ memberProfile.user.email }}</td>
                                        <td class="whitespace-nowrap p-4 align-middle">{{ memberProfile.number }}</td>
                                        <td class="whitespace-nowrap p-4 align-middle">
                                            <div>
                                                <Badge v-if="memberProfile.is_active" variant="success">Aktif</Badge>
                                                <Badge v-else variant="danger">Nonaktif</Badge>
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap p-4 align-middle">{{ memberProfile.join_date }}</td>
                                        <td class="whitespace-nowrap p-4 align-middle">{{ memberProfile.membership_until }}</td>
                                        <td class="whitespace-nowrap p-4 align-middle">{{ memberProfile.gender || "-" }}</td>
                                        <td class="whitespace-nowrap p-4 align-middle">{{ memberProfile.blood_type || "-" }}</td>
                                        <td class="whitespace-nowrap p-4 align-middle">{{ memberProfile.last_education || "-" }}</td>
                                        <td class="whitespace-nowrap p-4 align-middle">{{ memberProfile.institution || "-" }}</td>
                                        <td class="whitespace-nowrap p-4 align-middle">{{ memberProfile.department || "-" }}</td>
                                        <td class="whitespace-nowrap p-4 align-middle">{{ memberProfile.user.telephone || "-" }}</td>
                                        <td class="whitespace-nowrap p-4 align-middle">{{ memberProfile.address || "-" }}</td>
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
    </LeaderLayout>
</template>
