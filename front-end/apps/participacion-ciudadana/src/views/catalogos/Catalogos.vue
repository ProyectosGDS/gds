<script setup>
    import Tabs from '../../components/Tabs.vue'
    import { RouterView } from 'vue-router'

</script>

<template>
    <Tabs :index="1" />
    <RouterView />
</template>