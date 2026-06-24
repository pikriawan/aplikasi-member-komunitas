<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import { Line } from "vue-chartjs";
import { Chart as ChartJS, Title, Tooltip, Legend, LineElement, PointElement, LinearScale, CategoryScale } from "chart.js";
import DashboardHeader from "../../../Components/DashboardHeader.vue";
import LeaderLayout from "../../../Layouts/LeaderLayout.vue";
import { cn } from "../../../lib/utils.js";

const page = usePage();

const memberProfiles = computed(() => page.props.memberProfiles);
const contents = computed(() => page.props.contents);
const posts = computed(() => page.props.posts);
const invoices = computed(() => page.props.invoices);

const chartOptions = { responsive: true };

ChartJS.register(Title, Tooltip, Legend, LineElement, PointElement, LinearScale, CategoryScale);
</script>

<template>
    <LeaderLayout>
        <DashboardHeader title="Statistik">
        </DashboardHeader>
        <main class="flex-1 overflow-auto">
            <div class="flex flex-col gap-8 p-8 lg:grid grid-cols-[repeat(auto-fill,minmax(25rem,1fr))]">
                <div class="flex flex-col gap-4 p-5 rounded-lg ring ring-inset ring-onyx-200">
                    <Link :href="route('leader.statistics.members.index')" class="font-semibold flex items-center gap-2 self-start">
                        Statistik Member
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right-icon lucide-chevron-right shrink-0"><path d="m9 18 6-6-6-6"/></svg>
                    </Link>
                    <div>
                        <Line :data="memberProfiles" :options="chartOptions" />
                    </div>
                </div>
                <div class="flex flex-col gap-4 p-5 rounded-lg ring ring-inset ring-onyx-200">
                    <Link :href="route('leader.statistics.contents.index')" class="font-semibold flex items-center gap-2 self-start">
                        Statistik Konten
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right-icon lucide-chevron-right shrink-0"><path d="m9 18 6-6-6-6"/></svg>
                    </Link>
                    <div>
                        <Line :data="contents" :options="chartOptions" />
                    </div>
                </div>
                <div class="flex flex-col gap-4 p-5 rounded-lg ring ring-inset ring-onyx-200">
                    <Link :href="route('leader.statistics.posts.index')" class="font-semibold flex items-center gap-2 self-start">
                        Statistik Postingan
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right-icon lucide-chevron-right shrink-0"><path d="m9 18 6-6-6-6"/></svg>
                    </Link>
                    <div>
                        <Line :data="posts" :options="chartOptions" />
                    </div>
                </div>
                <div class="flex flex-col gap-4 p-5 rounded-lg ring ring-inset ring-onyx-200">
                    <Link :href="route('leader.statistics.revenues.index')" class="font-semibold flex items-center gap-2 self-start">
                        Statistik Pendapatan
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right-icon lucide-chevron-right shrink-0"><path d="m9 18 6-6-6-6"/></svg>
                    </Link>
                    <div>
                        <Line :data="invoices" :options="chartOptions" />
                    </div>
                </div>
            </div>
        </main>
    </LeaderLayout>
</template>
