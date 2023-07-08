<script setup>
const props = defineProps({
    placeholder: String,
    name: String,
    error: String,
    title: String,
});

const data = ["1", "2", "3"];
</script>
<template lang="">
    <div class="form-control">
        <label class="label">
            <span class="label-text">{{ props.title }}</span>
        </label>
        <select
            :name="props.name"
            type="text"
            class="select select-sm select-bordered w-full"
            :placeholder="props.placeholder"
        >
            <option value="" v-for="(item, index) in data" :key="index">{{item}}</option>
        </select>
        <label class="label" v-if="props.error">
            <span class="label-text-alt text-error">{{ props.error }}</span>
        </label>
    </div>
</template>
