<script>
import { router, Link, useForm } from "@inertiajs/vue3";
import menu_layout from "../../layout/menu_layout.vue";
import modal_normal from "../../component/modal/modal_normal.vue";
import input_normal from "../../component/input/input_normal.vue";
import { useStore } from "vuex";
export default {
    layout: menu_layout,
    props: ["pelajaran", "params"],
    components: {
        Link,
        modal_normal,
        input_normal,
    },
    setup() {
        const store = useStore();
        store.state.page.bagian = "Master";
        store.state.page.judul = "Mata Pelajaran";

        const form_tambah = useForm({
            pelajaran: "",
        });
        return {
            store,
            form_tambah,
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
            router.get(route("master.mata-pelajaran.index"), params, {
                preserveState: true,
            });
        },
        submit_tambah(){
            this.form_tambah.post(route("master.mata-pelajaran.store"),{
                onSuccess : () => {
                    document.getElementById("tambah")?.click()
                    this.form_tambah.reset();
                }
            })
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
                        <th>Pelajaran</th>
                        <th class="text-center">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <transition-group name="table">
                        <tr
                            v-for="(item, index) in pelajaran?.data"
                            :key="item?.id"
                            v-if="pelajaran?.data?.length"
                        >
                            <td>{{ index + 1 }}</td>
                            <td>{{ item.pelajaran }}</td>
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

        <div
            class="flex justify-center items-center"
            v-if="pelajaran?.data.length"
        >
            <div class="join">
                <Link
                    as="button"
                    class="join-item btn btn-xs"
                    :class="{ 'bg-active': item.active }"
                    v-for="(item, index) in pelajaran?.links"
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
    <modal_normal id="tambah" title="Tambah Pelajaran">
        <input_normal
            title="Pelajaran"
            placeholder="Masukkan Mata Pelajaran"
            v-model="form_tambah.pelajaran"
            :length="50"
            :error="form_tambah.errors.pelajaran"
        />

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
</template>
