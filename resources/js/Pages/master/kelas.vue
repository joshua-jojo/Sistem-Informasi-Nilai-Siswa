<script>
import { Link, router, useForm } from "@inertiajs/vue3";
import menu_layout from "../../layout/menu_layout.vue";
import modal_normal from "../../component/modal/modal_normal.vue";
import input_normal from "../../component/input/input_normal.vue";
import select_normal from "../../component/input/select_normal.vue";
import { useStore } from "vuex";
export default {
    layout: menu_layout,
    components: {
        Link,
        modal_normal,
        input_normal,
        select_normal,
    },
    setup() {
        const store = useStore();
        store.state.page.bagian = "Master";
        store.state.page.judul = "Kelas";

        const form_tambah = useForm({
            kelas: "",
            jurusan_id: null,
        });
        const form_edit = useForm({
            id: null,
            jurusan_id: null,
            kelas: "",
        });

        const form_hapus = useForm({
            id: null,
            kelas: "",
        });

        return {
            form_tambah,
            form_edit,
            form_hapus,
        };
    },
    props: ["kelas", "params", "jurusan"],
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
            router.get(route("master.kelas.index"), params, {
                preserveState: true,
            });
        },
        submit_tambah() {
            this.form_tambah.post(route("master.kelas.store"), {
                onSuccess: () => {
                    document.getElementById("tambah")?.click();
                    this.form_tambah.reset();
                },
            });
        },
        data_edit(data) {
            this.form_edit.id = data.id;
            this.form_edit.kelas = data.kelas;
            this.form_edit.jurusan_id = data.jurusan_id;
        },
        submit_edit() {
            this.form_edit.put(
                route("master.kelas.update", { id: this.form_edit.id }),
                {
                    onSuccess: () => {
                        document.getElementById("edit")?.click();
                        this.form_edit.reset();
                    },
                }
            );
        },
        data_hapus(data) {
            this.form_hapus.id = data.id;
            this.form_hapus.kelas = data.kelas;
        },
        submit_hapus() {
            this.form_hapus.delete(
                route("master.kelas.destroy", { id: this.form_hapus.id }),
                {
                    onSuccess: () => {
                        document.getElementById("hapus")?.click();
                        this.form_hapus.reset();
                    },
                }
            );
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
};
</script>

<template>
    <div class="flex flex-col gap-4">
        <div class="flex justify-between">
            <label for="tambah" class="btn btn-xs bg-success">
                <i class="fa fa-plus"></i> tambah
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

        <!-- table  -->
        <div class="overflow-x-auto scrollbar-hide">
            <table class="table table-xs table-zebra">
                <thead>
                    <tr class="bg-sky-200">
                        <th>NO.</th>
                        <th>Kelas</th>
                        <th>Jurusan</th>
                        <th class="text-center">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <transition-group name="table">
                        <tr
                            v-for="(item, index) in kelas?.data"
                            :key="item?.id"
                            v-if="kelas?.data?.length"
                        >
                            <td>{{ index + 1 }}</td>
                            <td>{{ item.kelas }}</td>
                            <td class="uppercase">
                                {{ item?.jurusan?.jurusan }}
                            </td>
                            <td class="w-40">
                                <div class="flex gap-2 w-full">
                                    <label
                                        @click="data_edit(item)"
                                        for="edit"
                                        class="btn btn-xs bg-warning"
                                    >
                                        <i class="fa fa-pen"></i> edit
                                    </label>
                                    <label
                                        @click="data_hapus(item)"
                                        for="hapus"
                                        class="btn btn-xs bg-error"
                                    >
                                        <i class="fa fa-trash"></i> hapus
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr v-else>
                            <td colspan="10" class="text-center font-bold">
                                Belum ada data!
                            </td>
                        </tr>
                    </transition-group>
                </tbody>
            </table>
        </div>

        <div class="flex justify-center items-center" v-if="kelas.data.length">
            <div class="join">
                <Link
                    as="button"
                    class="join-item btn btn-xs"
                    :class="{ 'bg-active': item.active }"
                    v-for="(item, index) in kelas.links"
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
    <modal_normal id="tambah" title="Tambah Kelas">
        <input_normal
            title="Nama Kelas"
            :error="form_tambah?.errors.kelas"
            v-model="form_tambah.kelas"
            placeholder="Masukkan nama kelas"
            :length="50"
        />
        <select_normal
            title="Jurusan"
            placeholder="Pilih Jurusan"
            v-model="form_tambah.jurusan_id"
            :error="form_tambah.errors.jurusan_id"
            :data="jurusan"
            label="jurusan"
            get="id"
            uppercase
        />
        <template v-slot:action>
            <button
                class="btn bg-success"
                :class="{ 'loading btn-disabled': form_tambah.processing }"
                @click="submit_tambah"
            >
                simpan
            </button>
        </template>
    </modal_normal>

    <!-- edit  -->
    <modal_normal id="edit" title="Edit Kelas">
        <input_normal
            title="Nama Kelas"
            :error="form_edit?.errors.kelas"
            v-model="form_edit.kelas"
            placeholder="Masukkan nama kelas"
            :length="50"
        />
        <select_normal
            title="Jurusan"
            placeholder="Pilih Jurusan"
            v-model="form_edit.jurusan_id"
            :error="form_edit.errors.jurusan_id"
            :data="jurusan"
            label="jurusan"
            get="id"
            uppercase
        />
        <template v-slot:action>
            <button
                class="btn bg-warning"
                :class="{ 'loading btn-disabled': form_edit.processing }"
                @click="submit_edit"
            >
                edit
            </button>
        </template>
    </modal_normal>

    <!-- hapus  -->
    <modal_normal id="hapus" title="Hapus Kelas">
        Lanjutkan untuk menghapus kelas <b>{{ form_hapus.kelas }}</b
        >. Semua data yang terkait akan di hapus.
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
