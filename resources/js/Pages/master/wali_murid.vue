<script>
import menu_layout from "../../layout/menu_layout.vue";
import { useStore } from "vuex";
import Textarea_normal from "../../component/input/textarea_normal.vue";
import Select_normal from "../../component/input/select_normal.vue";
import Input_normal from "../../component/input/input_normal.vue";
import Input_filter from "../../component/input/input_filter.vue";
import Input_password from "../../component/input/input_password.vue";
import { Link,router,useForm } from "@inertiajs/vue3";
import Modal_normal from "../../component/modal/modal_normal.vue"
export default {
    layout: menu_layout,
    components: {
        Input_normal,
        Textarea_normal,
        Link,
        Modal_normal,
        Select_normal,
        Input_password,
        Input_filter,
    },
    props: ["user",'params',"murid"],
    setup() {
        const store = useStore();
        store.state.page.bagian = "Master";
        store.state.page.judul = "Wali Murid";

        const form_tambah = useForm({
            nama: "",
            username: "",
            password: "",
            password_confirmation: "",
            no_hp: "",
            status: "",
            alamat: "",
            role_id: null,
            murid_id: null,
        });

        return {
            form_tambah
        }
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
        },
        submit_tambah() {
            this.form_tambah.post(route("master.wali-murid.store"), {
                onSuccess: () => {
                    document.getElementById("tambah")?.click();
                    this.form_tambah.reset();
                },
            });
        },
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
                                <div v-if="item.wali_murid?.murid">
                                    {{ item.wali_murid?.murid?.nama }}
                                </div>
                                <div class="badge bg-danger bg-red-100 text-xs" v-else>
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
    
    <Modal_normal id="tambah" title="Tambah Wali Murid">
        <div class="grid grid-cols-2 gap-4">
            <Input_normal
                v-model="form_tambah.nama"
                :error="form_tambah.errors.nama"
                :length="100"
                title="Nama"
                placeholder="Masukkan Nama"
            />
            <Input_normal
                v-model="form_tambah.username"
                :error="form_tambah.errors.username"
                :length="100"
                title="Username"
                placeholder="Masukkan Username"
            />
        </div>
        <Input_normal
            v-model="form_tambah.no_hp"
            :error="form_tambah.errors.no_hp"
            :length="15"
            autocomplete="off"
            title="Nomor Handphone"
            placeholder="Masukkan Nomor Handphone"
        /> 
        <Input_filter
            v-model="form_tambah.murid_id"
            :error="form_tambah.errors.murid_id"
            :title="'Murid'"
            :data="murid"
            label="nama"
            get="id"
            :capitalize="true"
            placeholder="Pilih Murid"
        /> 
        <Textarea_normal
            v-model="form_tambah.alamat"
            :error="form_tambah.errors.alamat"
            :length="100"
            title="Alamat"
            placeholder="Masukkan Alamat"
        />
        <div class="grid grid-cols-2 gap-4">
            <Input_password
                v-model="form_tambah.password"
                :error="form_tambah.errors.password"
                :length="100"
                title="Password"
                placeholder="Masukkan Nama"
            />
            <Input_password
                v-model="form_tambah.password_confirmation"
                :length="100"
                title="Konfirmasi Password"
                placeholder="Masukkan Username"
            />
        </div>

        <template v-slot:action>
            <button
                class="btn bg-success"
                :class="{ 'loading btn-disabled': form_tambah.processing }"
                @click="submit_tambah"
            >
                simpan
            </button>
        </template>
    </Modal_normal>
</template>
