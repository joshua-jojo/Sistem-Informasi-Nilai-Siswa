<template lang="">
    <div class="flex flex-col gap-4 bg-base-300 h-screen w-screen">
        <div class="navbar bg-base-100 shadow-md">
            <div class="flex-1">
                <a class="btn btn-ghost normal-case text-xl">daisyUI</a>
            </div>
            <div class="dropdown dropdown-end">
                <label tabindex="0" class="btn btn-sm btn-ghost">
                    <p class="truncate w-[100px]">
                        {{ user_auth?.nama }}
                    </p>
                </label>
                <ul
                    tabindex="0"
                    class="menu menu-sm dropdown-content mt-7 z-[1] p-2 shadow-md bg-base-100 rounded-box w-52"
                >
                    <li @click="logout"><a>Logout</a></li>
                </ul>
            </div>
        </div>

        <div class="flex flex-col gap-4 px-4">
            <div class="alert">
                <span
                    >Selamat Datang <b>{{ user_auth?.nama }}</b
                    >.</span
                >
            </div>

            <div class="card shadow-lg bg-base-200">
                <div class="card-body">
                    <div class="flex flex-col gap-4">
                        <div class="flex flex-col gap-2">
                            <h2 class="font-semibold">SISWA</h2>
                            <table class="table table-sm table-zebra w-max">
                                <tbody>
                                    <tr>
                                        <th>Nama</th>
                                        <td>
                                            :
                                            {{ murid?.wali_murid?.murid?.nama }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Jurusan</th>
                                        <td>
                                            :
                                            {{
                                                murid?.wali_murid?.murid?.murid
                                                    ?.jurusan?.jurusan
                                            }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Kelas</th>
                                        <td>
                                            :
                                            {{
                                                murid?.wali_murid?.murid?.murid
                                                    ?.kelas?.kelas
                                            }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Agama</th>
                                        <td>
                                            :
                                            {{
                                                murid?.wali_murid?.murid?.murid
                                                    ?.agama?.agama
                                            }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="card shadow-lg bg-base-200">
                    <div class="card-body">
                        <div class="flex flex-col gap-4">
                            <div class="flex flex-col gap-2">
                                <h2 class="font-semibold">Daftar Absensi</h2>
                                <table
                                    class="table table-sm table-zebra w-full"
                                >
                                    <thead>
                                        <tr>
                                            <th>tanggal</th>
                                            <th>Pelajaran</th>
                                            <th>Guru</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(item, index) in absensi"
                                            :key="index"
                                        >
                                            <td>
                                                {{
                                                    format_waktu(
                                                        item.created_at
                                                    )
                                                }}
                                            </td>
                                            <td>{{item?.jadwal_pelajaran?.mata_pelajaran?.pelajaran}}</td>
                                            <td>{{item?.jadwal_pelajaran?.user?.nama}}</td>
                                            <td>{{item?.status}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-lg bg-base-200">
                    <div class="card-body">
                        <div class="flex flex-col gap-4">
                            <div class="flex flex-col gap-2">
                                <h2 class="font-semibold">Daftar Nilai</h2>
                                <table
                                    class="table table-sm table-zebra w-full"
                                >
                                    <thead>
                                        <tr>
                                            <th>Pelajaran</th>
                                            <th>Guru</th>
                                            <th>Nama Tugas</th>
                                            <th>Nilai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in nilai" :key="index">
                                            <td>{{item?.tugas_ulangan?.jadwal_pelajaran?.mata_pelajaran?.pelajaran}}</td>
                                            <td>{{item?.tugas_ulangan?.jadwal_pelajaran?.user?.nama}}</td>
                                            <td>{{item?.tugas_ulangan?.judul}}</td>
                                            <td>{{item?.nilai}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { router } from "@inertiajs/vue3";

export default {
    props: ["user_auth", "murid", "absensi","nilai"],
    methods: {
        logout() {
            router.post(route("logout"));
        },
        format_waktu(date) {
            const day = new Date(date);

            const namaBulan = [
                "Januari",
                "Februari",
                "Maret",
                "April",
                "Mei",
                "Juni",
                "Juli",
                "Agustus",
                "September",
                "Oktober",
                "November",
                "Desember",
            ];

            const namaHari = [
                "Minggu",
                "Senin",
                "Selasa",
                "Rabu",
                "Kamis",
                "Jumat",
                "Sabtu",
            ];

            return `${namaHari[day.getDay()]}, ${day.getDay()} ${namaBulan[day.getMonth()]} ${day.getFullYear()}`;
        },
    },
};
</script>
<style lang=""></style>
