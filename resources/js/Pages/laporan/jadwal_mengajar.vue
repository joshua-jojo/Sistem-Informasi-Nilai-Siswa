<template lang="">
    <div class="flex flex-col gap-4">
        <div class="flex justify-between gap-4">
            <div class="flex flex-row w-max justify-center items-center gap-2">
                <label class="label">
                    <span class="label-text">Tampilkan data tanggal : </span>
                </label>
                <input
                    type="date"
                    v-model="dari"
                    class="input input-bordered input-sm"
                />
                <label class="label">
                    <span class="label-text">Sampai tanggal : </span>
                </label>
                <input
                    type="date"
                    v-model="sampai"
                    class="input input-bordered input-sm"
                />
            </div>
        </div>

        <!-- tabel  -->
        <table class="table table-xs w-full table-zebra select-none">
            <thead>
                <tr class="bg-sky-200">
                    <th>No.</th>
                    <th>Kelas</th>
                    <th>Pelajaran</th>
                    <th>Tanggal</th>
                    <th>Mulai</th>
                    <th>Selesai</th>
                    <th class="text-center">Menu</th>
                </tr>
            </thead>
            <tbody>
                <transition-group name="table" v-if="jadwal_mengajar.length">
                    <tr v-for="(item, index) in jadwal_mengajar" :key="item.id">
                        <td>{{ index + 1 }}</td>
                        <td>{{ item?.kelas?.kelas }}</td>
                        <td>{{ item?.mata_pelajaran.pelajaran }}</td>
                        <td>{{ item.tanggal }}</td>
                        <td>{{ item.mulai }}</td>
                        <td>{{ item.selesai }}</td>
                        <td class="flex justify-center gap-2">
                            <label
                                for="tugas/ulangan"
                                class="btn btn-xs btn-success"
                                @click="data_id_jadwal(item)"
                            >
                                tugas / ulangan
                            </label>

                            <label
                                for="absensi"
                                @click="data_absensi(item)"
                                class="btn btn-xs btn-primary"
                            >
                                Absensi
                            </label>
                        </td>
                    </tr>
                </transition-group>
                <tr v-else>
                    <td colspan="99" class="text-center font-bold capitalize">
                        Belum Ada Jadwal
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <modal_normal id="absensi" title="Menu Absensi Murid">
        <div class="">
            <table class="table-xs table table-zebra">
                <thead>
                    <tr class="bg-sky-200">
                        <th>Nama</th>
                        <th>Hadir</th>
                        <th>Izin</th>
                        <th>Alpa</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-if="form_absensi.murid.length"
                        v-for="(item, index) in form_absensi.murid"
                        :key="index"
                    >
                        <td>{{ item?.user?.nama }}</td>
                        <td>
                            <input
                                type="radio"
                                :name="`radio${item.id}`"
                                class="radio radio-sm radio-success"
                                value="hadir"
                                v-model="item.status"
                            />
                        </td>
                        <td>
                            <input
                                type="radio"
                                :name="`radio${item.id}`"
                                class="radio radio-sm radio-warning"
                                value="izin"
                                v-model="item.status"
                            />
                        </td>
                        <td>
                            <input
                                type="radio"
                                :name="`radio${item.id}`"
                                class="radio radio-sm radio-error"
                                value="alpa"
                                v-model="item.status"
                            />
                        </td>
                    </tr>
                    <tr v-else>
                        <td colspan="99" class="text-center">
                            Belum ada murid dalam kelas ini
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <template v-slot:action>
            <button
                class="btn bg-success"
                @click="submit_absensi"
                :disabled="form_absensi.processing"
            >
                <div class="loading" v-if="form_absensi.processing"></div>
                Simpan
            </button>
        </template>
    </modal_normal>

    <Modal_lg id="tugas/ulangan" title="Tambah Tugas Atau Ulangan">
        <div class="grid grid-cols-2 gap-4">
            <div class="h-max card shadow-lg">
                <div class="card-body gap-4">
                    <div class="form-control">
                            <label class="label">
                                <span class="label-text">Judul</span>
                            </label>
                            <input
                                type="text"
                                class="input input-bordered input-sm"
                                v-model="form_tugas.judul"
                                placeholder="Masukkan judul atau ulangan"
                            />
                            <label class="label" v-if="form_tugas.errors.judul">
                                <span class="label-text text-error">{{
                                    form_tugas.errors.judul
                                }}</span>
                            </label>
                        </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Mulai</span>
                            </label>
                            <input
                                type="date"
                                class="input input-bordered input-sm"
                                v-model="form_tugas.mulai"
                            />
                            <label class="label" v-if="form_tugas.errors.mulai">
                                <span class="label-text text-error">{{
                                    form_tugas.errors.mulai
                                }}</span>
                            </label>
                        </div>
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Selesai</span>
                            </label>
                            <input
                                type="date"
                                class="input input-bordered input-sm"
                                v-model="form_tugas.selesai"
                            />
                            <label
                                class="label"
                                v-if="form_tugas.errors.selesai"
                            >
                                <span class="label-text text-error">{{
                                    form_tugas.errors.selesai
                                }}</span>
                            </label>
                        </div>
                    </div>
                    <button
                        class="btn btn-success btn-sm"
                        :disabled="form_tugas.processing"
                        @click="submit_tugas"
                    >
                        <div class="loading" v-if="form_tugas.processing"></div>
                        tambah
                    </button>
                </div>
            </div>
            <div class="h-full card shadow-lg">
                <div class="card-body gap-2">
                    <div
                        class="card shadow-lg h-max w-full"
                        v-for="(item, index) in data_tugas"
                        :key="index"
                    >
                        <div class="card-body">
                            <table class="table table-xs table-zebra">
                                <tbody>
                                    <tr>
                                        <td colspan="2">
                                            {{item.judul}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Mulai</td>
                                        <td>: {{item.mulai}}</td>
                                    </tr>
                                    <tr>
                                        <td>Selesai</td>
                                        <td>: {{item.selesai}}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="flex gap-2 justify-end">
                                <label for="isi_nilai" @click="data_isi_nilai(item)" class="btn btn-xs btn-primary w-max">
                                    isi nilai
                                </label>
                                <label for="hapus_tugas" @click="data_hapus_tugas(item)" class="btn btn-xs btn-error w-max">
                                    hapus
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Modal_lg>
    <modal_normal id="hapus_tugas" title="Hapus Tugas">
        Lanjutkan untuk menghapus tugas?

        <template v-slot:action>
            <button class="btn btn-error" :disabled="form_hapus_tugas.processing" @click="submit_hapus_tugas">
                <div class="loading" v-if="form_hapus_tugas.processing"></div>
                Lanjutkan
            </button>
        </template>
    </modal_normal>
    <modal_normal id="isi_nilai" title="Isi Nilai">
        

        <template v-slot:action>
            <button class="btn btn-success" :disabled="form_hapus_tugas.processing" @click="submit_hapus_tugas">
                <div class="loading" v-if="form_hapus_tugas.processing"></div>
                Lanjutkan
            </button>
        </template>
    </modal_normal>
</template>
<script>
import { useStore } from "vuex";
import Menu_layout from "../../layout/menu_layout.vue";
import { router, useForm } from "@inertiajs/vue3";
import Modal_normal from "../../component/modal/modal_normal.vue";
import Modal_lg from "../../component/modal/modal_lg.vue";
import input_normal from "../../component/input/input_normal.vue";
export default {
    layout: Menu_layout,
    props: ["params", "jadwal_mengajar"],
    components: {
        Modal_normal,
        Modal_lg,
        input_normal,
    },
    setup() {
        const store = useStore();
        store.state.page.bagian = "Data";
        store.state.page.judul = "Jadwal Mengajar";

        const form_absensi = useForm({
            id: null,
            status: null,
            murid: [],
        });

        const form_tugas = useForm({
            kelas_id: "",
            jadwal_pelajaran_id: "",
            judul: "",
            mulai: "",
            selesai: "",
        });

        const form_hapus_tugas = useForm({
            id : ""
        })

        return {
            form_absensi,
            form_tugas,
            form_hapus_tugas,
        };
    },
    data() {
        return {
            dari: this.params.dari,
            sampai: this.params.sampai,
            data_tugas : []
        };
    },
    methods: {
        get_data() {
            router.get(
                route("laporan.jadwal-mengajar.index"),
                {
                    dari: this.dari,
                    sampai: this.sampai,
                },
                {
                    preserveState: true,
                }
            );
        },
        async data_absensi(data) {
            if (data.absensi.length) {
                const data_absen = [...data.absensi];

                await data_absen.map((e) => {
                    console.log(e);
                });
                this.form_absensi.murid = data_absen;
                this.form_absensi.status = true;
                this.form_absensi.id = data.id;
            } else {
                this.form_absensi.id = data.id;
                this.form_absensi.murid = data.kelas?.murid;
                this.form_absensi.status = false;
            }
        },
        submit_absensi() {
            this.form_absensi.post(route("laporan.jadwal-mengajar.store"), {
                onSuccess: () => {
                    document.getElementById("absensi")?.click();
                    this.form_absensi.reset();
                },
            });
        },
        submit_tugas(){
            this.form_tugas.post(route("master.jadwal-pelajaran.tugas"),{
                onSuccess : () => {
                    this.form_tugas.judul = ""
                    this.form_tugas.mulai = ""
                    this.form_tugas.selesai = ""

                    this.data_tugas = this.jadwal_mengajar.find((e) => {
                        return e.id == this.form_tugas.jadwal_pelajaran_id
                    })?.tugas
                }
            });
        },
        data_id_jadwal(data){
            this.form_tugas.jadwal_pelajaran_id = data.id
            this.form_tugas.kelas_id = data.kelas_id

            this.data_tugas = data.tugas
        },
        data_hapus_tugas(data){
            this.form_hapus_tugas.id = data.id;
            this.form_hapus_tugas.judul = data.judul;
        },
        submit_hapus_tugas(){
            this.form_hapus_tugas.post(route("master.jadwal-pelajaran.hapus_tugas"),{
                onSuccess : () => {
                    this.form_hapus_tugas.reset(),
                    document.getElementById("hapus_tugas")?.click()
                    this.data_tugas = this.jadwal_mengajar.find((e) => {
                        return e.id == this.form_tugas.jadwal_pelajaran_id
                    })?.tugas
                }
            })
        },
        data_isi_nilai(data){
            console.log(data);
        }
    },
    watch: {
        dari() {
            this.get_data();
        },
        sampai() {
            this.get_data();
        },
    },
};
</script>
<style lang=""></style>
