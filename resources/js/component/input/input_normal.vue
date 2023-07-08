<script setup>
const props = defineProps({
    placeholder : String,
    name : String,
    error : String,
    title : String,
})
</script>
<template lang="">
    <div class="form-control">
        <label class="label">
            <span class="label-text">{{props.title}}</span>
        </label>
        <input
            :name="props.name"
            type="text"
            class="input input-sm input-bordered w-full"
            :placeholder="props.placeholder"
        />
        <label class="label" v-if="props.error">
            <span class="label-text-alt text-error">{{props.error}}</span>
        </label>
    </div>
</template>
