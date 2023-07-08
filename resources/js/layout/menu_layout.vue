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
    <div class="h-screen flex flex-col">
        <div
            class="navbar bg-base-100 shadow-[rgba(50,_50,_105,_0.15)_0px_2px_5px_0px,_rgba(0,_0,_0,_0.05)_0px_1px_1px_0px] z-50"
        >
            <div class="flex-1">
                <a class="btn btn-ghost normal-case text-xl">daisyUI</a>
            </div>
            <div class="flex-none">
                <ul class="menu menu-horizontal px-1">
                    <li><a>Link</a></li>
                    <li>
                        <details>
                            <summary>Parent</summary>
                            <ul class="p-2 bg-base-100">
                                <li><a>Link 1</a></li>
                                <li><a>Link 2</a></li>
                            </ul>
                        </details>
                    </li>
                </ul>
            </div>
        </div>
        <div class="h-full bg-base-100 flex gap-2 w-screen px-4">
            <div class="bg-base-100 py-4 w-[70px] z-10">
                <ul
                    class="menu h-max rounded-box menu-vertical shadow-[rgba(50,_50,_105,_0.15)_0px_2px_5px_0px,_rgba(0,_0,_0,_0.05)_0px_1px_1px_0px]"
                    :key="store.state.page.judul"
                >
                    <li
                        class="text-[20px] h-[40px] dropdown dropdown-right dropdown-hover"
                    >
                        <label tabindex="0" class="">
                            <i class="fa fa-home"></i>
                        </label>
                        <ul
                            tabindex="0"
                            class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52"
                        >
                            <li class="menu-title">Dashboard</li>
                            <li @click="dashboard"><a>Dashboard</a></li>
                        </ul>
                    </li>
                    <li
                        class="text-[20px] h-[40px] dropdown dropdown-right dropdown-hover"
                    >
                        <label tabindex="0" class="">
                            <i class="fa-solid fa-rectangle-list"></i>
                        </label>
                        <ul
                            tabindex="0"
                            class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52"
                        >
                            <li class="menu-title">Laporan</li>
                            <li @click="nilai_akademik"><a>Nilai Akademik</a></li>
                            <li @click="rapor"><a>Rapor</a></li>
                            <li @click="absensi"><a>Absensi</a></li>
                        </ul>
                    </li>
                    <li
                        class="text-[20px] h-[40px] dropdown dropdown-right dropdown-hover"
                    >
                        <label tabindex="1" class="">
                            <i class="fa-solid fa-folder"></i>
                        </label>
                        <ul
                            tabindex="1"
                            class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52"
                        >
                            <li class="menu-title">Master</li>
                            <li><a>User</a></li>
                            <li><a>Wali Murid</a></li>
                            <li><a>Siswa</a></li>
                            <li><a>Guru</a></li>
                            <li><a>Jurusan</a></li>
                            <li><a>Kelas</a></li>
                            <li><a>Mata Pelajaran</a></li>
                            <li><a>Ekskul</a></li>
                        </ul>
                    </li>
                    <li
                        class="text-[20px] h-[40px] dropdown dropdown-right dropdown-hover"
                    >
                        <label tabindex="1" class="">
                            <i class="fa fa-gear"></i>
                        </label>
                        <ul
                            tabindex="1"
                            class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52"
                        >
                            <li class="menu-title">Pengaturan</li>
                            <li @click="profil_sekolah">
                                <a>Profil Sekolah</a>
                            </li>
                            <li @click="profil_user"><a>Profil User</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="z-0 py-4 px-4 flex flex-col">
                <div class="">
                    <div class="text-sm breadcrumbs h-[40px] overflow-hidden">
                        <ul class="z-0">
                            <transition-group name="menu">
                                <li
                                    v-if="store.state.page.bagian"
                                    :key="store.state.page.bagian"
                                >
                                    <a>{{ store.state.page.bagian }}</a>
                                </li>
                                <li
                                    v-if="store.state.page.judul"
                                    :key="store.state.page.judul"
                                >
                                    <a>{{ store.state.page.judul }}</a>
                                </li>
                            </transition-group>
                        </ul>
                    </div>
                </div>
                <div class="overflow-x-auto p-4">
                    <slot></slot>
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
    animation: slide-in-top 0.3s 0.3s cubic-bezier(0.455, 0.03, 0.515, 0.955) both;
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
