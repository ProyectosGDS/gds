<script setup>
    import { onMounted } from 'vue'
    import { useCursosStore } from '@/stores/cursos'

    const store = useCursosStore()

    onMounted(() => store.fetch())
</script>

<template>
    <div class="flex justify-between gap-5">
        <select class="input uppercase">
            <option value="">Tecnologia</option>
            <option value="">Manualidades</option>
            <option value="">Belleza y estilo</option>
            <option value="">Artes y musica</option>
            <option value="">Cultura</option>
            <option value="" selected>Todos los cursos</option>
        </select>
        <Input icon="fas fa-search" placeholder="Buscar curso .." />
    </div>
    <hr class="my-5">
    <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
        <Card v-for="curso in store.cursos" class="overflow-hidden border" >
            <template #header>
                <img src="/public/img/foto-card.jpg" :alt="curso.nombre" class=" object-cover h-48 w-auto object-center">
            </template>
            <div class="p-4">
                <span class=" text-wrap text-lg font-medium text-blue-muni">
                    {{ `${curso.curso.nombre} ${curso.nivel.nombre}` }}
                </span>
                <p>
                    {{ curso.curso.descripcion }}
                </p>
            </div>
            <template #footer>
                <div class="p-4">
                    <Button @click="store.detalleCurso(curso)" icon="fas fa-arrow-right" text="Saber mas ..." class="bg-blue-muni text-white rounded-full" />
                </div>
            </template>
        </Card>
    </div>
</template>