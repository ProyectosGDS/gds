<script setup>
    import { onMounted } from 'vue'
    import { useCursosStore } from '@/stores/cursos'
    import DataCard from '@/components/DataCard.vue'

    const store = useCursosStore()

    onMounted(() => {
        store.fetch()
        store.fetchCategorias()
    })
</script>

<template>
    <DataCard :data="store.cursos" :categorias="store.categorias" :loading="store.loading">
        <template #action="{item}">
            <Button @click="store.detalleCurso(item)" icon="fas fa-arrow-right" text="Saber mas ..." class="bg-blue-muni text-white rounded-full" />
        </template>
    </DataCard>
    
</template>