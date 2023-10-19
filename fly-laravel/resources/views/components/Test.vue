<script setup>
import { ref } from "vue";

const num = ref(0);
</script>
<template>
    <button @click="num++">times: {{ num }}</button>
</template>