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
        <textarea
            :name="props.name"
            type="text"
            class="textarea textarea-sm textarea-bordered w-full"
            :placeholder="props.placeholder"
        ></textarea>
        <label class="label" v-if="props.error">
            <span class="label-text-alt text-error">{{props.error}}</span>
        </label>
    </div>
</template>
