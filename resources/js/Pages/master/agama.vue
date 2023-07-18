<script>
import { router, useForm } from "@inertiajs/vue3";
import menu_layout from "../../layout/menu_layout.vue";
import modal_normal from "../../component/modal/modal_normal.vue"
import input_normal from "../../component/input/input_normal.vue"
import { useStore } from "vuex";
export default {
    layout: menu_layout,
    props: ["agama", "params"],
    components : {
        modal_normal,
        input_normal
    },
    setup() {
        const store = useStore();
        store.state.page.bagian = "Master";
        store.state.page.judul = "Agama";

        const form_tambah = useForm({
            agama : "",
        });

        const form_edit = useForm({
            id : null,
            agama : "",
        });

        const form_hapus = useForm({
            id : null,
            agama : "",
        });

        return {
            form_tambah,
            form_edit,
            form_hapus,
        }
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
            router.get(route("master.agama.index"), params, {
                preserveState: true,
            });
        },
        submit_tambah() {
            this.form_tambah.post(route("master.agama.store"), {
                onSuccess: () => {
                    document.getElementById("tambah")?.click();
                    this.form_tambah.reset();
                },
            });
        },
        data_edit(data) {
            this.form_edit.id = data.id;
            this.form_edit.agama = data.agama;
        },
        submit_edit() {
            this.form_edit.put(
                route("master.agama.update", { id: this.form_edit.id }),
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
            this.form_hapus.agama = data.agama;
        },
        submit_hapus() {
            this.form_hapus.delete(
                route("master.agama.destroy", { id: this.form_hapus.id }),
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
    <div class="flex flex-col gap-2">
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
            </div>
        </div>

        <!-- tabel  -->
        <div class="overflow-x-auto scrollbar-hide">
            <table class="table table-xs table-zebra">
                <thead>
                    <tr class="bg-sky-200">
                        <th>NO.</th>
                        <th>Agama</th>
                        <th class="text-center">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <transition-group name="table">
                        <tr
                            v-for="(item, index) in agama"
                            :key="item?.id"
                            v-if="agama.length"
                        >
                            <td>{{ index + 1 }}</td>
                            <td class="uppercase">{{ item.agama }}</td>
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
    </div>

    <!-- tambah  -->
    <modal_normal id="tambah" title="Tambah Agama">
        <input_normal title="Agama" v-model="form_tambah.agama" :error="form_tambah.errors.agama" placeholder="Masukkan Agama" :length="50"/>
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
    <modal_normal id="edit" title="Edit Agama">
        <input_normal title="Agama" v-model="form_edit.agama" :error="form_edit.errors.agama" placeholder="Masukkan Agama" :length="50"/>
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
    <modal_normal id="hapus" title="Hapus Agama">
        Lanjutkan untuk menghapus Agama <b>{{ form_hapus.agama }}</b
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
