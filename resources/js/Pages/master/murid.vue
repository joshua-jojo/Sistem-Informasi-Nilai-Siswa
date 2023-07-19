<script>
import { router, useForm, Link } from "@inertiajs/vue3";
import menu_layout from "../../layout/menu_layout.vue";
import { useStore } from "vuex";
import modal_normal from "../../component/modal/modal_normal.vue";
import input_normal from "../../component/input/input_normal.vue";
import input_password from "../../component/input/input_password.vue";
import input_tanggal from "../../component/input/input_tanggal.vue";
import textarea_normal from "../../component/input/textarea_normal.vue";
import select_normal from "../../component/input/select_normal.vue";
export default {
    layout: menu_layout,
    props: ["params", "murid", "jurusan", "agama"],
    components: {
        modal_normal,
        input_normal,
        input_tanggal,
        input_password,
        textarea_normal,
        select_normal,
        Link,
    },
    setup() {
        const store = useStore();
        store.state.page.bagian = "Master";
        store.state.page.judul = "Murid";

        const form_tambah = useForm({
            nama: "",
            username: "",
            alamat: "",
            password: "",
            password_confirmation: "",
            kelas_id: null,
            jurusan_id: null,
            agama_id: null,
            tanggal_lahir: "",
            no_hp: "",
        });

        const form_edit = useForm({
            id: null,
            nama: "",
            username: "",
            alamat: "",
            password: "",
            password_confirmation: "",
            kelas_id: null,
            jurusan_id: null,
            agama_id: null,
            tanggal_lahir: "",
            no_hp: "",
        });

        const form_hapus = useForm({
            id: null,
            nama: "",
        });

        return {
            form_tambah,
            form_edit,
            form_hapus,
        };
    },
    data() {
        return {
            show: this.params.show,
            cari: this.params.cari,
        };
    },
    methods: {
        get_data() {
            const params = {
                show: this.show,
                cari: this.cari,
            };
            router.get(route("master.murid.index"), params, {
                preserveState: true,
            });
        },
        submit_tambah() {
            this.form_tambah.post(route("master.murid.store"), {
                onSuccess: () => {
                    document.getElementById("tambah")?.click();
                    this.form_tambah.reset();
                },
            });
        },
        async data_edit(data) {
            this.form_edit.id = await data.id;
            this.form_edit.nama = await data.nama;
            this.form_edit.alamat = await data.alamat;
            this.form_edit.no_hp = await data.no_hp;
            this.form_edit.username = await data.username;
            this.form_edit.jurusan_id = await data.murid?.jurusan_id;
            this.form_edit.kelas_id = await data.murid?.kelas_id;
            this.form_edit.agama_id = await data.murid?.agama_id;
            this.form_edit.tanggal_lahir = await data.murid?.tanggal_lahir;
        },
        submit_edit() {
            this.form_edit.put(route("master.murid.update", {id : this.form_edit}), {
                onSuccess: () => {
                    document.getElementById("edit")?.click();
                    this.form_edit.reset();
                },
            });
        },
        async data_hapus(data) {
            this.form_hapus.id = await data.id;
            this.form_hapus.nama = await data.nama;
        },
        submit_hapus() {
            this.form_hapus.delete(route("master.murid.update", {id : this.form_hapus}), {
                onSuccess: () => {
                    document.getElementById("hapus")?.click();
                    this.form_hapus.reset();
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
    },
    computed: {
        kelas() {
            if (this.form_tambah.jurusan_id) {
                this.form_tambah.kelas_id = null;
                const data = this.jurusan.find((item) => {
                    return item.id == this.form_tambah.jurusan_id;
                });
                return data.kelas;
            } else {
                this.form_edit.kelas_id = null;
                const data = this.jurusan.find((item) => {
                    return item.id == this.form_edit.jurusan_id;
                });
                return data.kelas;
            }
        },
    },
};
</script>

<template>
    <div class="flex flex-col gap-4">
        <div class="flex justify-between">
            <div class="flex gap-4">
                <label for="tambah" class="btn btn-xs bg-success">
                    <i class="fa fa-plus"></i> tambah
                </label>
            </div>

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

        <div class="overflow-x-auto scrollbar-hide">
            <table class="table table-xs table-zebra">
                <thead>
                    <tr class="capitalize bg-sky-200">
                        <th>No.</th>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Agama</th>
                        <th>Kelas</th>
                        <th>Jurusan</th>
                        <th>Alamat</th>
                        <th>Kontak</th>
                        <th class="text-center">opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <transition-group name="table">
                        <tr
                            v-for="(item, index) in murid.data"
                            :key="item.id"
                            v-if="murid.data.length"
                        >
                            <td>{{ index + 1 }}</td>
                            <td>
                                <div class="" v-if="item.murid?.nis">
                                    {{ item.murid?.nis }}
                                </div>
                                <div class="" v-else>-</div>
                            </td>
                            <td>{{ item.nama }}</td>
                            <td class="uppercase">
                                {{ item.murid?.agama.agama }}
                            </td>
                            <td class="uppercase">
                                {{ item.murid?.kelas.kelas }}
                            </td>
                            <td class="uppercase">
                                {{ item.murid?.jurusan.jurusan }}
                            </td>
                            <td>{{ item.alamat }}</td>
                            <td>{{ item.no_hp }}</td>
                            <td class="w-40">
                                <div class="flex gap-2 justify-center">
                                    <label
                                        @click="data_edit(item)"
                                        for="edit"
                                        class="btn btn-xs bg-warning"
                                    >
                                        <i class="fa fa-pen"></i>
                                        edit
                                    </label>
                                    <label
                                        for="hapus"
                                        @click="data_hapus(item)"
                                        class="btn btn-xs bg-danger"
                                    >
                                        <i class="fa fa-trash"></i>
                                        hapus
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr v-else>
                            <td colspan="99" class="text-center font-bold">
                                Belum ada data!
                            </td>
                        </tr>
                    </transition-group>
                </tbody>
            </table>
        </div>

        <div class="flex justify-center items-center" v-if="murid.data.length">
            <div class="join">
                <Link
                    as="button"
                    class="join-item btn btn-xs"
                    :class="{ 'bg-active': item.active }"
                    v-for="(item, index) in murid.links"
                    :key="index"
                    v-html="item.label"
                    :disabled="!item.url"
                    :href="item.url ? item.url : '#'"
                    :preserve-state="true"
                ></Link>
            </div>
        </div>
    </div>

    <!-- tambah  -->
    <modal_normal id="tambah" title="Tambah Murid">
        <div class="flex flex-row gap-2 w-full">
            <input_normal
                title="Nama"
                v-model="form_tambah.nama"
                :error="form_tambah.errors.nama"
                placeholder="Masukkan Nama Murid"
                :length="50"
            />
            <input_normal
                title="Username"
                v-model="form_tambah.username"
                :error="form_tambah.errors.username"
                placeholder="Masukkan Username Murid"
                :length="50"
            />
        </div>

        <div class="flex gap-2">
            <input_tanggal
                title="Tanggal Lahir"
                v-model="form_tambah.tanggal_lahir"
                placeholder="Masukkan Tanggal Lahir"
                :error="form_tambah.errors.tanggal_lahir"
            />
            <input_normal
                title="Kontak"
                v-model="form_tambah.no_hp"
                placeholder="Masukkan kontak"
                :error="form_tambah.errors.no_hp"
                :length="15"
            />
        </div>

        <textarea_normal
            v-model="form_tambah.alamat"
            :length="100"
            title="Alamat"
            :error="form_tambah.errors.alamat"
            placeholder="Masukkan Alamat Murid"
        />

        <select_normal
            title="Agama"
            placeholder="Pilih Agama"
            :data="agama"
            :error="form_tambah.errors.agama_id"
            label="agama"
            get="id"
            v-model="form_tambah.agama_id"
            uppercase
        ></select_normal>

        <div class="flex flex-row gap-2 w-full">
            <select_normal
                title="Jurusan"
                placeholder="Pilih Jurusan"
                :data="jurusan"
                :error="form_tambah.errors.jurusan_id"
                label="jurusan"
                get="id"
                v-model="form_tambah.jurusan_id"
                uppercase
            ></select_normal>
            <select_normal
                v-if="form_tambah.jurusan_id"
                :key="form_tambah.jurusan_id"
                title="Kelas"
                placeholder="Pilih Kelas"
                :data="kelas"
                label="kelas"
                get="id"
                v-model="form_tambah.kelas_id"
                :error="form_tambah.errors.kelas_id"
                uppercase
            ></select_normal>
        </div>

        <div class="flex flex-row gap-2 w-full">
            <input_password
                title="Password"
                v-model="form_tambah.password"
                :error="form_tambah.errors.password"
                placeholder="Masukkan Password"
                :length="50"
            />
            <input_password
                title="Konfirmasi Password"
                v-model="form_tambah.password_confirmation"
                placeholder="Konfirmasi Password"
                :length="50"
            />
        </div>

        <template v-slot:action>
            <button
                class="btn bg-success"
                :class="{ 'loading btn-disabled': form_tambah.processing }"
                @click="submit_tambah"
            >
                tambah
            </button>
        </template>
    </modal_normal>

    <!-- edit  -->
    <modal_normal id="edit" title="Edit Murid">
        <div class="flex flex-row gap-2 w-full">
            <input_normal
                title="Nama"
                v-model="form_edit.nama"
                :error="form_edit.errors.nama"
                placeholder="Masukkan Nama Murid"
                :length="50"
            />
            <input_normal
                title="Username"
                v-model="form_edit.username"
                :error="form_edit.errors.username"
                placeholder="Masukkan Username Murid"
                :length="50"
            />
        </div>

        <div class="flex gap-2">
            <input_tanggal
                title="Tanggal Lahir"
                v-model="form_edit.tanggal_lahir"
                placeholder="Masukkan Tanggal Lahir"
                :error="form_edit.errors.tanggal_lahir"
            />
            <input_normal
                title="Kontak"
                v-model="form_edit.no_hp"
                placeholder="Masukkan kontak"
                :error="form_edit.errors.no_hp"
                :length="15"
            />
        </div>

        <textarea_normal
            v-model="form_edit.alamat"
            :length="100"
            title="Alamat"
            :error="form_edit.errors.alamat"
            placeholder="Masukkan Alamat Murid"
        />

        <select_normal
            title="Agama"
            placeholder="Pilih Agama"
            :data="agama"
            :error="form_edit.errors.agama_id"
            label="agama"
            get="id"
            v-model="form_edit.agama_id"
            uppercase
        ></select_normal>

        <div class="flex flex-row gap-2 w-full">
            <select_normal
                title="Jurusan"
                placeholder="Pilih Jurusan"
                :data="jurusan"
                :error="form_edit.errors.jurusan_id"
                label="jurusan"
                get="id"
                v-model="form_edit.jurusan_id"
                uppercase
            ></select_normal>
            <select_normal
                v-if="form_edit.jurusan_id"
                :key="form_edit.jurusan_id"
                title="Kelas"
                placeholder="Pilih Kelas"
                :data="kelas"
                label="kelas"
                get="id"
                v-model="form_edit.kelas_id"
                :error="form_edit.errors.kelas_id"
                uppercase
            ></select_normal>
        </div>

        <div class="flex flex-row gap-2 w-full">
            <input_password
                title="Password"
                v-model="form_edit.password"
                :error="form_edit.errors.password"
                placeholder="Masukkan Password"
                :length="50"
            />
            <input_password
                title="Konfirmasi Password"
                v-model="form_edit.password_confirmation"
                placeholder="Konfirmasi Password"
                :length="50"
            />
        </div>

        <template v-slot:action>
            <button
                class="btn bg-warning"
                :class="{ 'loading btn-disabled': form_tambah.processing }"
                @click="submit_edit"
            >
                Edit
            </button>
        </template>
    </modal_normal>

    <!-- hapus  -->
    <modal_normal id="hapus" title="Hapus Data Murid">
        Lanjutkan untuk menghapus data <b>{{ form_hapus.nama }}</b>. Data yang terkait akan di hapus!
        <template v-slot:action>
            <button
                class="btn bg-error"
                :class="{ 'loading btn-disabled': form_hapus.processing }"
                @click="submit_hapus"
            >
                Lanjutkan
            </button>
        </template>
    </modal_normal>
</template>
