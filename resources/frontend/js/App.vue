<script setup>
import { ref } from "vue";

const pageTitle = ref(window.wpvueplugin_object?.page_title);
</script>

<template>
    <h1 v-text="pageTitle"></h1>

    <ul>
        <li><router-link :to="{ name: 'Home' }"> Home </router-link></li>
        <li><router-link :to="{ name: 'About' }"> About </router-link></li>
    </ul>

    <router-view />
</template>
