<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import HomeLayout from "../layouts/HomeLayout.vue";

const page = usePage();

const appUrl = page.props.appUrl;
const posts = page.props.posts;

// const posts = [
//     { id: 0, date: "05/04/2026", title: "Kolaborasi Komunitas Dorong Inovasi Digital Lokal", description: "Sinergi antar anggota komunitas terbukti menjadi kunci lahirnya berbagai solusi digital yang relevan dengan kebutuhan masyarakat lokal. Temukan kisah inspiratif di balik proyek-proyek kolaboratif yang mengubah ekosistem digital daerah." },
//     { id: 1, date: "04/04/2026", title: "Generasi Muda Semakin Aktif dalam Kegiatan Sosial", description: "Tren keterlibatan anak muda dalam berbagai gerakan sosial terus meningkat. Dari kegiatan lingkungan hingga pemberdayaan masyarakat, generasi Z dan milenial membuktikan bahwa perubahan bisa dimulai dari aksi nyata." },
//     { id: 2, date: "01/04/2026", title: "Workshop Pengembangan Diri Diminati Banyak Peserta", description: "Antusiasme masyarakat terhadap kegiatan pelatihan dan pengembangan diri semakin tinggi. Workshop yang mengangkat tema produktivitas, mindset, dan keterampilan hidup ini berhasil menarik ratusan peserta dari berbagai latar belakang." },
//     { id: 3, date: "23/03/2026", title: "Komunitas Lokal Gelar Event Kreatif Tahunan", description: "Ajang tahunan yang dinantikan kembali hadir, menghadirkan ruang ekspresi bagi para seniman, pelaku budaya, dan kreator lokal. Event ini menjadi bukti nyata bahwa kreativitas komunitas mampu menyatukan banyak pihak." },
//     { id: 4, date: "22/03/2026", title: "Pentingnya Jejaring dalam Dunia Profesional Modern", description: "Di era kompetisi global, membangun relasi yang kuat bukan lagi sekadar pilihan—melainkan keharusan. Artikel ini mengulas strategi efektif membangun jejaring profesional yang bermakna dan berkelanjutan." },
//     { id: 5, date: "28/02/2026", title: "Komunitas Gelar Workshop Digital Untuk Pemula", description: "Tidak perlu latar belakang teknis untuk mulai belajar dunia digital. Workshop ramah pemula ini dirancang khusus untuk memperkenalkan keterampilan digital dasar kepada masyarakat yang ingin meningkatkan kompetensinya." },
//     { id: 6, date: "01/01/2026", title: "Seminar Nasional Buka Wawasan Tentang Tren Teknologi Terkini", description: "Para pakar dan praktisi teknologi berkumpul dalam seminar nasional untuk berbagi pandangan tentang perkembangan AI, otomasi, dan transformasi digital. Wawasan baru siap membuka perspektif Anda tentang masa depan teknologi." },
//     { id: 7, date: "13/11/2025", title: "Event Kolaborasi Hadirkan Berbagai Kegiatan Inspiratif", description: "Dalam satu panggung yang sama, puluhan komunitas bersatu untuk menghadirkan rangkaian kegiatan yang memotivasi dan menginspirasi. Dari talk show hingga pameran karya, setiap sudut event ini menyimpan cerita yang layak untuk diikuti." }
// ];
</script>

<template>
    <HomeLayout>
        <div class="flex flex-col">
            <section class="relative flex lg:justify-center lg:items-center p-8 lg:p-0 lg:px-4 lg:h-136">
                <div class="absolute top-0 left-0 w-full h-full bg-[rgba(0,127,255,0.8)] -z-1" />
                <div class="absolute top-0 left-0 w-full h-full grayscale -z-2 bg-cover" :style="{ backgroundImage: `url('${appUrl}/images/background.jpg')` }" />
                <div class="lg:w-full lg:max-w-270">
                    <div class="flex flex-col items-start gap-8 lg:max-w-150">
                        <h1 class="font-medium text-3xl text-white">Bangun Koneksi dan Tumbuh Bersama</h1>
                        <p class="text-white">Terhubung dengan individu dari berbagai latar belakang, berbagi ide, dan membangun kolaborasi dalam komunitas inklusif untuk berkembang bersama serta menciptakan dampak nyata.</p>
                        <Link class="flex justify-start items-center gap-3 bg-black text-white px-6 py-2 rounded-full" href="/register">
                            Gabung membership
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-move-right-icon lucide-move-right"><path d="M18 8L22 12L18 16"/><path d="M2 12H22"/></svg>
                        </Link>
                    </div>
                </div>
            </section>
            <section class="flex lg:justify-center lg:items-center p-8 lg:p-0 lg:px-4 lg:py-16" id="about">
                <div class="lg:w-full lg:max-w-270 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">
                    <img class="w-full lg:w-80 aspect-square object-cover" :src="`${appUrl}/images/earth.jpg`" />
                    <div class="lg:w-full lg:max-w-150 flex flex-col gap-6">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 flex items-center justify-center">
                                <span class="w-6 h-0.5 bg-[#007FFF]" />
                            </div>
                            <h2 class="font-medium text-2xl w-full">Tentang</h2>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8" />
                            <p class="text-[#999999] w-full">
                                Komunitas ini adalah ruang terbuka bagi siapa saja yang ingin belajar, berkembang, dan saling terhubung dalam lingkungan yang positif dan kolaboratif. Kami menghadirkan berbagai kesempatan untuk bertukar wawasan, membangun relasi, serta berpartisipasi dalam kegiatan yang mendorong pertumbuhan pribadi maupun profesional.
                                <br />
                                <br />
                                Dengan semangat kebersamaan, kami percaya bahwa setiap individu memiliki potensi untuk memberikan kontribusi dan menciptakan dampak yang berarti. Di sini, kamu tidak hanya menjadi bagian dari komunitas, tetapi juga bagian dari perjalanan untuk tumbuh dan berkembang bersama.
                            </p>
                        </div>
                    </div>
                </div>
            </section>
            <section class="flex lg:justify-center lg:items-center p-8 lg:p-0 lg:px-4 lg:py-16 bg-[#F2F2F2]">
                <div class="lg:w-full lg:max-w-270 flex flex-col items-start gap-6">
                    <div class="w-full flex items-center gap-6">
                        <div class="w-full flex items-center gap-2.5">
                            <div class="w-8 h-8 flex items-center justify-center">
                                <span class="w-6 h-0.5 bg-[#007FFF]" />
                            </div>
                            <h2 class="font-medium text-2xl w-full">Berita Terbaru</h2>
                        </div>
                        <Link class="hidden lg:flex shrink-0 justify-start items-center gap-3 text-[#007FFF] shadow-[0_0_0_0.0625rem_#007FFF_inset] px-6 py-2 rounded-full" href="/blog">
                            Lihat semua
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-move-right-icon lucide-move-right"><path d="M18 8L22 12L18 16"/><path d="M2 12H22"/></svg>
                        </Link>
                    </div>
                    <div v-if="posts.length > 0" class="w-full flex flex-col gap-6 lg:grid lg:grid-cols-4">
                        <div
                            v-for="post in posts"
                            :key="post.id"
                            class="flex flex-col items-start justify-between gap-6 p-6 bg-white"
                        >
                            <div class="w-full flex flex-col items-start gap-6">
                                <span class="p-1 text-sm text-white bg-[#007FFF]">{{ post.date }}</span>
                                <h3 class="font-medium">{{ post.title }}</h3>
                                <p class="text-[#999999]">{{ post.description }}</p>
                            </div>
                            <div class="w-full flex flex-col items-start gap-6">
                                <span class="w-full h-px bg-[#CCCCCC]" />
                                <Link class="flex items-center gap-3 font-medium" href="#">
                                    Lanjut membaca
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-move-right-icon lucide-move-right"><path d="M18 8L22 12L18 16"/><path d="M2 12H22"/></svg>
                                </Link>
                            </div>
                        </div>
                    </div>
                    <p v-else>Tidak ada berita.</p>
                    <Link class="flex lg:hidden justify-start items-center gap-3 text-[#007FFF] shadow-[0_0_0_0.0625rem_#007FFF_inset] px-6 py-2 rounded-full" href="/blog">
                        Lihat semua
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-move-right-icon lucide-move-right"><path d="M18 8L22 12L18 16"/><path d="M2 12H22"/></svg>
                    </Link>
                </div>
            </section>
        </div>
    </HomeLayout>
</template>
