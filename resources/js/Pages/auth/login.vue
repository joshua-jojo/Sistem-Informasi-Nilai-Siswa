<template lang="">
    <div class="w-full h-screen flex justify-center items-center bg-base-300">
        <div class="card mix-w-xs max-w-md w-full shadow-lg bg-base-200 pb-8">
            <div class="card-body gap-4">
                <div class="uppercase text-center text-2xl font-bold">
                    login
                </div>

                <div class="alert alert-error" v-if="form.errors.login_status">
                    <span>{{form.errors.login_status}}</span>
                </div>
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Username</span>
                    </label>
                    <input
                        type="text"
                        class="input input-bordered"
                        v-model="form.username"
                        placeholder="Masukkan Username"
                    />
                    <label class="label" v-if="form.errors.username">
                        <span class="label-text-alt text-error">{{
                            form.errors.username
                        }}</span>
                    </label>
                </div>

                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Password</span>
                    </label>
                    <input
                        type="password"
                        class="input input-bordered"
                        v-model="form.password"
                        placeholder="Masukkan Password"
                    />
                    <label class="label" v-if="form.errors.password">
                        <span class="label-text-alt text-error">{{
                            form.errors.password
                        }}</span>
                    </label>
                </div>

                <button
                    class="btn btn-success"
                    :disabled="form.processing"
                    @click="submit_form"
                >
                    <span class="loading" v-if="form.processing"></span>
                    login
                </button>
            </div>
        </div>
    </div>
</template>
<script setup>
import { useForm } from "@inertiajs/vue3";
const form = useForm({
    username: "",
    password: "",
});

const submit_form = () => {
    form.post(route("cek-login"));
};
</script>
<style lang=""></style>
