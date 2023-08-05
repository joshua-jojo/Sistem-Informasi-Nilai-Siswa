<script>
import { Link, useForm, router } from "@inertiajs/vue3";
import menu_layout from "../../layout/menu_layout.vue";
import modal_lg from "../../component/modal/modal_lg.vue";
import modal_normal from "../../component/modal/modal_normal.vue";
import { useStore } from "vuex";
export default {
    layout: menu_layout,
    props: ["params", "murid", "raport"],
    components: {
        Link,
        modal_lg,
        modal_normal,
    },
    setup() {
        const store = useStore();
        store.state.page.bagian = "Laporan";
        store.state.page.judul = "Rapor";

        const form_tambah = useForm({
            user_id: null,
            data_raport: [],
        });

        const form_hapus = useForm({
            user_id: null,
        });

        return {
            form_tambah,
            form_hapus,
        };
    },
    data() {
        return {
            show: this.params.show,
            cari: this.params.cari,
            input_mapel: {
                nama: null,
                nilai: null,
            },
            data_show: [],
        };
    },
    methods: {
        tambah_data() {
            const data = { ...this.input_mapel };
            this.form_tambah.data_raport.unshift(data);
            this.input_mapel.nilai = null;
            this.input_mapel.nama = null;
        },
        submit_tambah() {
            this.form_tambah.post(route("laporan.rapor.store"), {
                onSuccess: () => {
                    this.form_tambah.reset();
                    document.getElementById("tambah").click();
                },
            });
        },
        get_data_show(item) {
            this.data_show = item;
        },
        get_data() {
            const params = {
                show: this.show,
                cari: this.cari,
            };
            router.get(route("laporan.rapor.index"), params, {
                preserveState: true,
            });
        },
        get_data_hapus(item) {
            this.form_hapus.user_id = item.id;
            this.form_hapus.nama = item.nama;
        },
        submit_hapus() {
            this.form_hapus.delete(route("laporan.rapor.destroy",{id : this.form_hapus.user_id}), {
                onSuccess: () => {
                    this.form_hapus.reset();
                    document.getElementById("hapus").click();
                },
            });
        },
    },
    watch: {
        show() {
            this.get_data();
        },
        cari() {
            this.get_data();
        },
        "form_tambah.user_id"() {
            const data = this.murid.find(
                (e) => e.user_id == this.form_tambah.user_id
            );
            this.form_tambah.nama = data?.user?.nama;
            this.form_tambah.data_raport = [];
        },
        "input_mapel.nilai"(baru) {
            if (baru < 0) {
                this.input_mapel.nilai = 0;
            } else if (baru > 100) {
                this.input_mapel.nilai = 100;
            }
        },
    },
};
</script>

<template>
    <div class="flex flex-col gap-4">
        <div class="flex justify-between">
            <label for="tambah" class="btn btn-xs btn-success">
                <i class="fa fa-plus"></i>
                tambah
            </label>
            <div class="flex gap-4">
                <div class="form-control">
                    <input
                        type="text"
                        class="input input-xs input-bordered"
                        placeholder="Search..."
                        v-model="cari"
                    />
                </div>
                <div class="flex gap-2 justify-center items-center">
                    <div class="text-sm">Tampilkan</div>
                    <select
                        class="select select-bordered select-xs"
                        v-model="show"
                    >
                        <option :value="5">5 baris</option>
                        <option :value="10">10 baris</option>
                        <option :value="20">20 baris</option>
                    </select>
                </div>
            </div>
        </div>

        <table class="table table-xs table-zebra w-full">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Jurusan</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                <transition-group name="table">
                    <tr v-for="(item, index) in raport.data" :key="item.id">
                        <td>{{ index + 1 }}</td>
                        <td>{{ item.nama }}</td>
                        <td>{{ item.murid.kelas.kelas }}</td>
                        <td>{{ item.murid.jurusan.jurusan }}</td>
                        <td class="flex gap-2">
                            <label
                                @click="get_data_show(item)"
                                for="lihat"
                                class="btn btn-xs btn-primary"
                            >
                                <i class="fa fa-eye"></i>
                                lihat
                            </label>
                            <label
                                for="hapus"
                                @click="get_data_hapus(item)"
                                class="btn btn-xs btn-error"
                            >
                                <i class="fa fa-trash"></i>
                                hapus
                            </label>
                        </td>
                    </tr>
                </transition-group>
            </tbody>
        </table>

        <div
            class="flex justify-center items-center"
            v-if="raport?.data.length"
        >
            <div class="join">
                <Link
                    as="button"
                    class="join-item btn btn-xs"
                    :class="{ 'bg-active': item.active }"
                    v-for="(item, index) in raport?.links"
                    :key="index"
                    v-html="item.label"
                    :disabled="!item.url"
                    :href="item.url ? item.url : '#'"
                    :preserve-state="true"
                ></Link>
            </div>
        </div>
    </div>

    <modal_lg id="tambah" title="Tambah Raport">
        <div class="grid grid-cols-2 gap-4">
            <div class="card shadow-md">
                <div class="card-body">
                    <div class="form-control">
                        <label class="label">Pilih Siswa</label>
                        <select
                            class="select select-bordered"
                            v-model="form_tambah.user_id"
                        >
                            <option :value="null" selected>
                                Pilih Data Siswa
                            </option>
                            <option
                                :value="item?.user?.id"
                                v-for="(item, index) in murid"
                                :key="index"
                            >
                                {{ item?.user?.nama }}
                            </option>
                        </select>
                    </div>

                    <div class="flex flex-col" v-if="form_tambah.user_id">
                        <div class="form-control mt-8">
                            <label class="label">Nama Mapel</label>
                            <input
                                type="text"
                                v-model="input_mapel.nama"
                                class="input input-bordered"
                            />
                        </div>
                        <div class="form-control">
                            <label class="label">Nilai</label>
                            <input
                                type="number"
                                class="input input-bordered"
                                v-model="input_mapel.nilai"
                            />
                        </div>
                        <button
                            @click="tambah_data"
                            :disabled="!(input_mapel.nama && input_mapel.nilai)"
                            class="btn btn-success mt-4"
                        >
                            tambah
                        </button>
                    </div>
                </div>
            </div>

            <div class="card shadow-md" v-if="form_tambah.user_id">
                <div class="card-body gap-2">
                    <div class="font-bold text-lg">{{ form_tambah.nama }}</div>
                    <table class="table table-sm w-max">
                        <tbody>
                            <tr
                                v-for="(item, index) in form_tambah.data_raport"
                                :key="index"
                            >
                                <td>{{ item.nama }}</td>
                                <td>: {{ item.nilai }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <template v-slot:action>
            <button
                class="btn btn-success"
                :disabled="
                    form_tambah.processing || !form_tambah.data_raport.length
                "
                @click="submit_tambah"
            >
                <div class="loading" v-if="form_tambah.processing"></div>
                tambah
            </button>
        </template>
    </modal_lg>

    <modal_normal id="lihat" :title="`Nilai Raport ${data_show.nama}`">
        <table class="table table-zebra">
            <thead>
                <tr>
                    <th>Pelajaran</th>
                    <th>Nilai</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in data_show.raport" :key="index">
                    <td>{{ item.pelajaran }}</td>
                    <td>{{ item.nilai }}</td>
                </tr>
            </tbody>
        </table>
    </modal_normal>

    <modal_normal id="hapus" :title="`Hapus Raport ${form_hapus.nama}`">
        <template v-slot:action>
            <button
                class="btn btn-error"
                :disabled="form_hapus.processing"
                @click="submit_hapus"
            >
                <div class="loading" v-if="form_hapus.processing"></div>
                Lanjutkan
            </button>
        </template>
    </modal_normal>
</template>
