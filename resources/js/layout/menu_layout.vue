<script>
import { router } from "@inertiajs/vue3";
import { useStore } from "vuex";
export default {
    setup() {
        const store = useStore();
        return {
            store,
        };
    },
    methods: {
        dashboard() {
            router.get(route("dashboard.index"));
        },
        nilai_akademik() {
            router.get(route("laporan.nilai-akademik.index"));
        },
        rapor() {
            router.get(route("laporan.rapor.index"));
        },
        absensi() {
            router.get(route("laporan.absensi.index"));
        },
        ekskul() {
            router.get(route("master.ekskul.index"));
        },
        guru() {
            router.get(route("master.guru.index"));
        },
        jurusan() {
            router.get(route("master.jurusan.index"));
        },
        kelas() {
            router.get(route("master.kelas.index"));
        },
        mata_pelajaran() {
            router.get(route("master.mata-pelajaran.index"));
        },
        murid() {
            router.get(route("master.murid.index"));
        },
        agama() {
            router.get(route("master.agama.index"));
        },
        jadwal_pelajaran() {
            router.get(route("master.jadwal-pelajaran.index"));
        },
        user() {
            router.get(route("master.user.index"));
        },
        wali_murid() {
            router.get(route("master.wali-murid.index"));
        },
        profil_user() {
            router.get(route("pengaturan.profil-user.index"));
        },
        profil_sekolah() {
            router.get(route("pengaturan.profil-sekolah.index"));
        },
    },
};
</script>

<template>
    <div class="h-screen flex flex-col relative">
        <div
            class="navbar bg-base-100 shadow-[rgba(50,_50,_105,_0.15)_0px_2px_5px_0px,_rgba(0,_0,_0,_0.05)_0px_1px_1px_0px] z-50 absolute top-0"
        >
            <div class="flex-1">
                <a class="btn btn-ghost normal-case text-xl">daisyUI</a>
            </div>
            <div class="flex-none gap-2">
                <div class="dropdown dropdown-end">
                    <label tabindex="0" class="btn btn-ghost btn-circle avatar">
                        <div class="w-10 rounded-full">
                            <img
                                src="/images/stock/photo-1534528741775-53994a69daeb.jpg"
                            />
                        </div>
                    </label>
                    <ul
                        tabindex="0"
                        class="mt-3 z-[1] p-2 shadow menu menu-sm dropdown-content bg-base-100 rounded-box w-52"
                    >
                        <li>
                            <a class="justify-between">
                                Profile
                                <span class="badge">New</span>
                            </a>
                        </li>
                        <li><a :class="{'bg-active' : store.state.page.judul == ''}">Settings</a></li>
                        <li><a :class="{'bg-active' : store.state.page.judul == ''}">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="h-full bg-base-100 flex gap-2 w-screen px-4 overflow-hidden mt-16">
            <div class="bg-base-100 py-4 w-[70px] z-10">
                <ul
                    class="menu h-max rounded-box menu-vertical shadow-[rgba(50,_50,_105,_0.15)_0px_2px_5px_0px,_rgba(0,_0,_0,_0.05)_0px_1px_1px_0px]"
                    :key="store.state.page.judul"
                >
                    <li
                        class="text-[20px] h-[40px] dropdown dropdown-right dropdown-hover"
                    >
                        <label tabindex="0" :class="{'bg-active' : store.state.page.bagian == 'Dashboard'}">
                            <i class="fa fa-home"></i>
                        </label>
                        <ul
                            tabindex="0"
                            class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52"
                        >
                            <li class="menu-title">Dashboard</li>
                            <li @click="dashboard"><a :class="{'bg-active' : store.state.page.judul == 'Halaman Utama'}">Dashboard</a></li>
                        </ul>
                    </li>
                    <li
                        class="text-[20px] h-[40px] dropdown dropdown-right dropdown-hover"
                    >
                        <label tabindex="0" :class="{'bg-active' : store.state.page.bagian == 'Laporan'}">
                            <i class="fa-solid fa-rectangle-list"></i>
                        </label>
                        <ul
                            tabindex="0"
                            class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52"
                        >
                            <li class="menu-title">Laporan</li>
                            <li @click="nilai_akademik">
                                <a :class="{'bg-active' : store.state.page.judul == 'Nilai Akademik'}">Nilai Akademik</a>
                            </li>
                            <li @click="rapor"><a :class="{'bg-active' : store.state.page.judul == 'Rapor'}">Rapor</a></li>
                            <li @click="absensi"><a :class="{'bg-active' : store.state.page.judul == 'Absensi'}">Absensi</a></li>
                        </ul>
                    </li>
                    <li
                        class="text-[20px] h-[40px] dropdown dropdown-right dropdown-hover"
                    >
                        <label tabindex="1" :class="{'bg-active' : store.state.page.bagian == 'Master'}">
                            <i class="fa-solid fa-folder"></i>
                        </label>
                        <ul
                            tabindex="1"
                            class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52"
                        >
                            <li class="menu-title">Master</li>
                            <li @click="jurusan"><a :class="{'bg-active' : store.state.page.judul == 'Jurusan'}">Jurusan</a></li>
                            <li @click="kelas"><a :class="{'bg-active' : store.state.page.judul == 'Kelas'}">Kelas</a></li>
                            <li @click="mata_pelajaran">
                                <a :class="{'bg-active' : store.state.page.judul == 'Mata Pelajaran'}">Mata Pelajaran</a>
                            </li>
                            <li @click="ekskul"><a :class="{'bg-active' : store.state.page.judul == 'Ekskul'}">Ekskul</a></li>
                            <li @click="jadwal_pelajaran"><a :class="{'bg-active' : store.state.page.judul == 'Jadwal Pelajaran'}">Jadwal Pelajaran</a></li>
                            <li @click="agama"><a :class="{'bg-active' : store.state.page.judul == 'Agama'}">Agama</a></li>
                            <li @click="murid"><a :class="{'bg-active' : store.state.page.judul == 'Murid'}">Murid</a></li>
                            <li @click="wali_murid"><a :class="{'bg-active' : store.state.page.judul == 'Wali Murid'}">Wali Murid</a></li>
                            <li @click="guru"><a :class="{'bg-active' : store.state.page.judul == 'Guru'}">Guru</a></li>
                            <li @click="user"><a :class="{'bg-active' : store.state.page.judul == 'User'}">User</a></li>
                        </ul>
                    </li>
                    <li
                        class="text-[20px] h-[40px] dropdown dropdown-right dropdown-hover"
                    >
                        <label tabindex="1" :class="{'bg-active' : store.state.page.bagian == 'Pengaturan'}">
                            <i class="fa fa-gear"></i>
                        </label>
                        <ul
                            tabindex="1"
                            class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52"
                        >
                            <li class="menu-title">Pengaturan</li>
                            <li @click="profil_sekolah">
                                <a :class="{'bg-active' : store.state.page.judul == 'Profil Sekolah'}">Profil Sekolah</a>
                            </li>
                            <li @click="profil_user"><a :class="{'bg-active' : store.state.page.judul == 'Profil User'}">Profil User</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="z-0 py-4 px-4 flex flex-col w-full">
                <div class="w-full">
                    <div class="text-sm breadcrumbs h-[40px] overflow-hidden">
                        <ul class="z-0">
                            <transition-group name="menu">
                                <li
                                    v-if="store.state.page.bagian"
                                    :key="store.state.page.bagian"
                                >
                                    <a :class="{'bg-active' : store.state.page.judul == ''}">{{ store.state.page.bagian }}</a>
                                </li>
                                <li
                                    v-if="store.state.page.judul"
                                    :key="store.state.page.judul"
                                >
                                    <a :class="{'bg-active' : store.state.page.judul == ''}">{{ store.state.page.judul }}</a>
                                </li>
                            </transition-group>
                        </ul>
                    </div>
                </div>
                <div class="overflow-x-auto w-full card shadow-lg mt-4 scrollbar-hide">
                    <div class="w-full card-body scrollbar-hide">
                        <slot></slot>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.menu-enter-from {
    transform: translateY(-100px);
    opacity: 0;
    z-index: 1;
}
.menu-enter-to {
    transform: translateY(0);
    opacity: 1;
    z-index: 1;
}
.menu-enter-active {
    animation: slide-in-top 0.3s 0.3s cubic-bezier(0.455, 0.03, 0.515, 0.955)
        both;
}

@keyframes slide-in-top {
    0% {
        transform: translateY(-100px);
        opacity: 0;
        z-index: 1;
    }
    100% {
        transform: translateY(0);
        opacity: 1;
        z-index: 1;
    }
}
.menu-leave-from {
    transform: translateY(0);
    opacity: 1;
    z-index: 5;
}
.menu-leave-to {
    transform: translateY(100px);
    opacity: 0;
    z-index: 5;
}
.menu-leave-active {
    animation: slide-out-bottom 0.3s cubic-bezier(0.55, 0.085, 0.68, 0.53) both;
}

@keyframes slide-out-bottom {
    0% {
        transform: translateY(0);
        opacity: 1;
        z-index: 5;
    }
    100% {
        transform: translateY(100px);
        opacity: 0;
        z-index: 5;
    }
}
</style>
