<script setup>
    import { onMounted } from 'vue';
    import { useInscritosStore } from '@/stores/inscritos'
    const store = useInscritosStore()
    
    onMounted(() => store.fetch())
</script>

<template>
    <Card class="bg-white p-8">
        <h1>Inscritos</h1>
        <Data-Table :headers="store.headers" :data="store.inscritos" :loading="store.loading" :export="false" />
    </Card>
</template>



