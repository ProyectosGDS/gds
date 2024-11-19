<script setup>
    import { useCursosStore } from '@/stores/cursos'
    import { useInscripcionStore } from '@/stores/inscripcion'

    import { computed, onBeforeMount, ref, watchEffect } from 'vue'
    import Steps from '@/components/Steps.vue'

    import DatosPersonales from '@/views/inscripcion/datos-personales/DatosPersonales.vue'
    import Responsable from '@/views/inscripcion/responsable/Responsable.vue'
    import Otros from '@/views/inscripcion/otros/Otros.vue'

    const props = defineProps(['curso_id'])

    const store = useCursosStore()
    const inscripcion = useInscripcionStore()

    const steps = ref([
        { 
            index : 1, 
            text : 'Datos personales', 
            name : 'DatosPersonales', 
            active : false 
        },
        { 
            index : 2, 
            text : 'Datos academicos y medicos', 
            name : 'Otros', 
            active : false 
        },
        { 
            index : 3, 
            text : 'Responsable y emergencia', 
            name : 'Responsable', 
            active : false 
        },
    ])

    const components = {
        DatosPersonales,
        Responsable,
        Otros
    }

    const cupo = computed(() => {
        return (store.curso.curso.cupo - store.curso.inscritos.length);
    })


    watchEffect(() => {
        store.show(props.curso_id)
    })

    onBeforeMount(() => {

        inscripcion.fetchCatalogos()
        store.fieldFormByDirection()
        
    })
    
</script>

<template>
    <div class="p-2 md:p-4 lg:p-8" v-if="store.curso?.hasOwnProperty('curso')">
        <div class="flex">
            <div @click="store.router.go(-1)" class="flex items-center justify-center gap-2 text-blue-muni cursor-pointer">
                <Icon icon="fas fa-arrow-left" class="text-xl" />
                <span>REGRESAR</span>
            </div>
        </div>
        <br>
        <header class="w-full flex items-center justify-center h-48 bg-center bg-cover rounded-lg overflow-hidden "
                :style="{ backgroundImage: `url(data:image/jpeg;base64,${store.curso.curso.imageEncode})` }"
        >
            <h1 class="text-white text-3xl lg:text-7xl uppercase text-center drop-shadow-xl">
                {{ store.curso?.curso.nombre + ' ' + store.curso.nivel?.nombre }}
            </h1>
        </header>
        <br>
        <div class="grid lg:grid-cols-2 gap-4 text-gray-500">
            <div>
                <div>
                    <h1 class="text-3xl text-blue-muni">Información del curso</h1>
                    <br>
                    <ul class="uppercase">
                        
                        <li class="flex gap-3 items-center">
                            <Icon icon="fas fa-calendar-days" class=" text-[1.3rem]"/>
                            <span class="font-medium">Horario :</span>
                            <span>{{ store.curso?.horario?.dia + ' ' + store.curso?.horario?.hora_inicial + ' - ' + store.curso?.horario?.hora_final }}</span>
                        </li>
                        <li class="flex gap-3 items-center">
                            <Icon icon="fas fa-users"/>
                            <span class="font-medium">Cupo disponible :</span>
                            <span>{{ cupo }}</span>
                        </li>
                        <li class="flex gap-3 items-center">
                            <Icon icon="fas fa-chalkboard-user"/>
                            <span class="font-medium">Instructor :</span>
                            <span>{{ store.curso?.instructor?.nombre }}</span>
                        </li>
                        <li class="flex gap-3 items-center">
                            <Icon icon="fas fa-layer-group" class="text-lg"/>
                            <span class="font-medium">Modalidad :</span>
                            <span>{{ store.curso?.modalidad }}</span>
                        </li>
                        <li class="flex gap-3 items-center">
                            <Icon icon="fas fa-city"/>
                            <span class="font-medium">Sede :</span>
                            <span>{{ `${store.curso?.sede?.direccion} ZONA ${store.curso?.sede?.zona?.numero} ${store.curso?.sede?.nombre}` }}</span>
                        </li>
                    </ul>
                </div>
                <br>
                <div>
                    <h1 class="text-3xl text-blue-muni">Requisitos</h1>
                    <br>
                    <ul>
                        <li v-for="requisito in store.curso.curso.requisitos">
                            <label class="flex items-center gap-4">
                                <Icon icon="fas fa-check" />
                                <span>{{ requisito.descripcion }}</span>
                            </label>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="grid grid-rows-2">
                <div>
                    <h3 class="text-3xl text-blue-muni">Descripción</h3>
                    <br>
                    <p>
                        {{ store.curso?.curso?.descripcion }}
                    </p>
                </div>
                <div class="flex justify-center items-center">
                    <Button @click="inscripcion.modal(store.curso)" icon="fas fa-thumbs-up" text="Inscribete" class="bg-blue-muni btn text-white rounded-full h-16 w-40 text-3xl self-center mx-auto" />
                </div>
            </div>
        </div>
    </div>
    <Modal :open="inscripcion.openModal.form" :title="'Formulario de inscripción - ' + store.curso?.curso?.nombre" icon="fas fa-clipboard-list" class="w-2/3">
        <div>
            <Steps :steps="steps" :components="components" />
            <Validate-Errors v-if="inscripcion.errors != 0" :errors="inscripcion.errors" />
        </div>
        <template #footer>
            <Button @click="inscripcion.resetData()" text="Cancelar" icon="fas fa-xmark" class="btn-dark rounded-full" />
        </template>
    </Modal>
</template>
