<script>
import menu_layout from "../../layout/menu_layout.vue";
import { useStore } from "vuex";
import input_normal from "../../component/input/input_normal.vue";
import { Link,router } from "@inertiajs/vue3";
export default {
    layout: menu_layout,
    components: {
        input_normal,
        Link
    },
    props: ["user",'params'],
    setup() {
        const store = useStore();
        store.state.page.bagian = "Master";
        store.state.page.judul = "Wali Murid";
    },
    data(){
        return {
            show : this.params.show,
            cari : this.params.cari
        }
    },
    methods : {
        get_data(){
            const params = {
                show : this.show,
                cari : this.cari,
            }
            router.get(route("master.wali-murid.index"),params,{
                preserveState : true
            })
        }
    },
    watch : {
        show(){
            this.get_data()
        },
        cari(){
            this.get_data()
        }
    }
};
</script>

<template>
    <div class="flex flex-col gap-4">
        <div class="flex justify-end">
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
                    <select class="select select-bordered select-xs" v-model="show">
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
                        <th>Nama</th>
                        <th>siswa / siswi</th>
                        <th>alamat</th>
                        <th>kontak</th>
                        <th class="text-center">opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <transition-group name="table">
                        <tr v-for="(item, index) in user.data" :key="item.id" v-if="user.data.length">
                            <td>{{index + 1}}</td>
                            <td>{{ item.nama }}</td>
                            <td>
                                <div class="badge bg-danger bg-red-100 text-xs">
                                    Belum Diatur
                                </div>
                            </td>
                            <td>{{ item.alamat }}</td>
                            <td>{{ item.no_hp }}</td>
                            <td class="w-40">
                                <div class="flex gap-2 justify-center">
                                    <label
                                        for="edit"
                                        class="btn btn-xs bg-warning"
                                    >
                                        <i class="fa fa-pen"></i>
                                        edit
                                    </label>
                                    <label
                                        for="hapus"
                                        class="btn btn-xs bg-danger"
                                    >
                                        <i class="fa fa-pen"></i>
                                        hapus
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr v-else>
                            <td colspan="7" class="text-center font-bold">
                                Belum ada data!
                            </td>
                        </tr>
                    </transition-group>
                </tbody>
            </table>
        </div>

        <div class="flex justify-center items-center" v-if="user.data.length">
            <div class="join">
                <Link
                    as="button"
                    class="join-item btn btn-xs"
                    :class="{ 'bg-active': item.active }"
                    v-for="(item, index) in user.links"
                    :key="index"
                    v-html="item.label"
                    :disabled="!item.url"
                    :href="item.url ? item.url : '#'"
                    :preserve-state="true"
                ></Link>
            </div>
        </div>
    </div>
</template>
