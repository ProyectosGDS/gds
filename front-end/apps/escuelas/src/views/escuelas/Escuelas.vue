<script setup>
    import { onMounted } from 'vue'
    import { useEscuelasStore } from '@/stores/escuelas/escuelas'
    import { useRouter } from 'vue-router'

    import { useProgramasStore } from '@/stores/escuelas/programas'
    import { useNivelesStore } from '@/stores/escuelas/niveles'
    import { useSeccionesStore } from '@/stores/escuelas/secciones'
    import { useCursosStore } from '@/stores/escuelas/cursos'

    import axios from 'axios'
   

    const router = useRouter()
    const store = useEscuelasStore()
    const programaStore = useProgramasStore()
    const nivelStore = useNivelesStore()
    const seccionStore = useSeccionesStore()
    const cursoStore = useCursosStore()

    const sendParams = (id)  => {

        programaStore.programa = []
        nivelStore.nivel = []
        seccionStore.seccion = []
        cursoStore.curso = []

        router.push({ 
            name : 'Edit', 
            params : {
                escuela_id : id
            }
        })
    }

    onMounted(() => {
        store.fetch()
    })

</script>

<template>
    <div>
        <div class="flex items-center text-3xl font-bold gap-3">
            <Icon icon="fas fa-school" class="text-violet-400 text-4xl" />
            <h1>Escuelas Municipales</h1>
            <Icon @click="store.openNew" icon="fas fa-plus" class="icon-button bg-violet-400" />
        </div>
    </div>
    <br>
    <div class="grid lg:grid-cols-2 xl:grid-cols-4 gap-8">
        <template v-for="escuela in store.escuelas">
            <Card v-if="!escuela.deleted_at" class="bg-white cursor-pointer overflow-hidden relative p-5">
                <div class="absolute top-3 right-3">
                    <div class="flex gap-3 text-xs">
                        <Icon @click="store.edit(escuela)" icon="fas fa-pencil" class="text-gray-400 hover:scale-125 hover:text-violet-500" />
                    </div>
                </div>
                <div @click="sendParams(escuela.id)" class="grid gap-3">
                    <h1 class="text-2xl font-semibold">{{ escuela.nombre }}</h1>
                    <div>
                        <img src="@/assets/img/foto-card.png" class="w-full" :alt="escuela.nombre">
                    </div>
                    <div>
                        <p>
                            {{ escuela.descripcion }}
                        </p>
                    </div>
                </div>
                <template #footer>
                    <div class="bg-gray-100 px-5 py-2 rounded-lg">
                        <div class="flex justify-between items-center text-gray-500">
                            <span>
                                <Icon icon="fas fa-clipboard-list" />
                                {{ escuela.programas.length }}
                            </span>
                            <span class="flex items-center gap-2">
                                <Icon icon="fas fa-user-graduate"/>
                                <span>45</span>
                            </span>
                        </div>
                    </div>
                </template>
            </Card>
        </template>
    </div>
    
    <!-- MODALES -->
    <Modal :open="store.openModalNew" title="Nueva escuela" icon="fas fa-school" class="w-96">
        <div class="grid gap-3">
            <Input option="label" title="Nombre de la escuela" type="text" v-model="store.escuela.nombre" :error="store.errors.hasOwnProperty('nombre')" />
            <Input option="text-area" rows="5" title="Descripcion" v-model="store.escuela.descripcion" :error="store.errors.hasOwnProperty('descripcion')" />
        </div>
        <Validate-Errors v-if="store.errors != 0" :errors="store.errors" />
        <template #footer>
            <Button @click="store.resetData" text="Cancelar" icon="fas fa-xmark" class="btn-dark rounded-full" />
            <Button @click="store.store" :loading="store.loading" text="Crear" icon="fas fa-plus" class="btn-primary shadow-vilet-800 rounded-full" />
        </template>
    </Modal>

    <Modal :open="store.openModalEdit" title="Editar escuela" icon="fas fa-school" class="w-96">
        <div class="grid gap-3">
            <Input option="label" title="Nombre de la escuela" type="text" v-model="store.escuela.nombre" :error="store.errors.hasOwnProperty('nombre')" />
            <Input option="text-area" rows="5" title="Descripcion" v-model="store.escuela.descripcion" :error="store.errors.hasOwnProperty('descripcion')" />
        </div>
        <Validate-Errors v-if="store.errors != 0" :errors="store.errors" />
        <template #footer>
            <Button @click="store.resetData" text="Cancelar" icon="fas fa-xmark" class="btn-dark rounded-full" />
            <Button @click="store.update" :loading="store.loading" text="actualizar registro" icon="fas fa-save" class="btn-primary rounded-full" />
        </template>
    </Modal>

    <Modal :open="store.openModalDelete">
        <div class="flex items-center gap-4">
            <Icon icon="fas fa-triangle-exclamation" class="text-orange-500 text-7xl" />
            <div class="grid gap-1">
                <h1 class="text-2xl font-bold">Atención</h1>
                <h1 class="font-medium whitespace-nowrap">
                    ¿ Esta seguro de eliminar : 
                    <span class="font-semibold">
                        {{store.escuela.nombre}}
                    </span> 
                    ?
                </h1>
            </div>
        </div>
        <template #footer>
            <Button @click="store.resetData" text="Cancelar" icon="fas fa-xmark" class="btn-dark shadow-gray-800 rounded-lg" />
            <Button @click="store.destroy" text="Sí, estoy seguro" icon="fas fa-check" class="btn-danger shadow-red-800 rounded-lg" />
        </template>
    </Modal>

</template>

