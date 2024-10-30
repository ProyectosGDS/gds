<script setup>
    import { onMounted } from 'vue'
    import { usePortafolioStore } from '@/stores/portafolio'
    import { usePersonaStore } from '@/stores/persona'
    import DataCard from '@/components/DataCard.vue'

    const store = usePortafolioStore()
    const personaStore = usePersonaStore()

    onMounted(() => {
        store.fetch()
        store.fetchDirecciones()
    })
</script>

<template>
<!--    
     -->

    <hr class="my-4">
    <div v-if="store.openDetails">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl text-gray-500 font-semibold">Cursos disponibles</h1>
            <select class="input w-1/3">
                <option value="" disabled>Seleccione un filtro</option>
                <option value="">Salud y belleza</option>
                <option value="">Manualidades</option>
                <option value="">Arte y cultura</option>
                <option value="">Deportes</option>
                <option value="" selected>Todos</option>
            </select>
        </div>
        <br>    
        <DataCard :data="store.portafolios">
            <template #body="{item}">
                <h1 class="font-semibold text-blue-muni text-2xl">
                    {{ item.curso.nombre }}
                </h1>
                <h1 class="font-semibold text-blue-muni text-lg">
                    {{ item.nivel.nombre }}
                </h1>
                <small class="text-blue-muni uppercase">{{ item.programa.escuela.direccion }}</small>
                <div>
                    <p class="">
                        {{ item.curso.descripcion }}
                    </p>
                </div>
            </template>
            <template #footer="{item}">
                    <Button @click="store.edit(item)" text="Saber mas .." icon="fas fa-arrow-right" class="bg-blue-muni text-blue-100 rounded-full" />
            </template>
        </DataCard>
    </div>

    <div v-else="store.openDetails" class="p-8">
        <div class="flex">
            <div class="flex items-center justify-center gap-2 text-blue-muni cursor-pointer" @click="store.openDetails = !openDetails">
                <Icon icon="fas fa-arrow-left" class="text-xl" />
                <span>REGRESAR</span>
            </div>
        </div>
        <br>
        <header class="background-img w-full flex items-center justify-center h-48 bg-center bg-cover rounded-lg overflow-hidden">
            <h1 class="text-white text-7xl uppercase text-center">
                {{ store.portafolio.curso.nombre + ' ' + store.portafolio.nivel.nombre }}
            </h1>
        </header>
        <br>
        <div class="grid lg:grid-cols-2 gap-4 text-gray-500">
            <div>
                <div>
                    <h1 class="text-3xl text-blue-muni">Informacion del curso</h1>
                    <br>
                    <ul>
                        <li class="flex gap-3 items-center">
                            <Icon icon="fas fa-city" />
                            <span>Sede :</span>
                            <span class="uppercase">{{ `${store.portafolio.sede.direccion} ZONA ${store.portafolio.sede.zona.numero} ${store.portafolio.sede.nombre}` }}</span>
                        </li>
                        <li class="flex gap-3 items-center">
                            <Icon icon="fas fa-calendar-days" />
                            <span>Horario :</span>
                            <span>{{ store.portafolio.horario.dia + ' ' + store.portafolio.horario.hora_inicial + ' - ' + store.portafolio.horario.hora_final }}</span>
                        </li>
                        <li class="flex gap-3 items-center">
                            <Icon icon="fas fa-users" />
                            <span>Cupo disponible :</span>
                            <span>{{ store.portafolio.curso.cupo }}</span>
                        </li>
                        <li class="flex gap-3 items-center">
                            <Icon icon="fas fa-chalkboard-user" />
                            <span>Instructor :</span>
                            <span>{{ store.portafolio.instructor.nombre }}</span>
                        </li>
                        <li class="flex gap-3 items-center">
                            <Icon icon="fas fa-layer-group" />
                            <span>Modalidad :</span>
                            <span>{{ store.portafolio.modalidad }}</span>
                        </li>
                    </ul>
                </div>
                <br>
                <div>
                    <h1 class="text-3xl text-blue-muni">Requisitos</h1>
                    <br>
                    <ul>
                        <li v-for="i in 8">
                            <label class="flex items-center gap-4">
                                <Icon icon="fas fa-check" />
                                <span>Lorem ipsum dolor sit amet</span>
                            </label>
                        </li>
                    </ul>
                </div>
            </div>
            <div>
                <div>
                    <h3 class="text-3xl text-blue-muni">Descripción</h3>
                    <br>
                    <p>
                        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quia ipsa quasi esse, vero sit nihil modi neque nemo quaerat ratione soluta officiis dignissimos ut, laudantium unde pariatur nobis, tempora consequatur?
                    </p>
                </div>
                <br>
                <div class="flex xl:h-[50%]">
                    <Button @click="personaStore.openModalNew = true " text="Inscribete" class="bg-blue-muni text-white rounded-full h-16 w-40 text-3xl self-center mx-auto" />
                </div>
            </div>
        </div>
    </div>
    <Modal :open="personaStore.openModalNew" title="Ficha de inscripcion" icon="fa fa-file-signature" class="w-1/2">
        <template #close>
            <Icon @click="personaStore.resetData()" icon="fas fa-xmark" class="text-xl text-violet-200" />
        </template>
        <div class="grid grid-cols-3 gap-3">
            <fieldset class="grid grid-cols-3 gap-3 col-span-3 border p-4 rounded-lg">
                <legend class="text-violet-400 font-semibold uppercase px-4">Nombre</legend>
                <Input v-model="personaStore.persona.primer_nombre" option="label" title="Primer nombre" :error="personaStore.errors.hasOwnProperty('primer_apellido')" />
                <Input v-model="personaStore.persona.segundo_nombre" option="label" title="Segundo nombre" />
                <Input v-model="personaStore.persona.tercer_nombre" option="label" title="Tercer nombre" />
            </fieldset>
            <fieldset class="grid grid-cols-3 gap-3 col-span-3 border p-4 rounded-lg">
                <legend class="text-violet-400 font-semibold uppercase px-4">Apellido</legend>
                <Input v-model="personaStore.persona.primer_apellido" option="label" title="Primer apellido" :error="personaStore.errors.hasOwnProperty('primer_apellido')" />
                <Input v-model="personaStore.persona.segundo_apellido" option="label" title="Segundo apellido" />
                <Input v-model="personaStore.persona.apellido_casada" option="label" title="apellido de casada" />
            </fieldset>
            <Input v-model="personaStore.persona.cui" option="label" title="cui" :error="personaStore.errors.hasOwnProperty('cui')" />
            <Input v-model="personaStore.persona.correo" type="email" option="label" title="correo electronico" :error="personaStore.errors.hasOwnProperty('celular')" />
            <Input v-model="personaStore.persona.celular" type="tel" option="label" title="Celular" :error="personaStore.errors.hasOwnProperty('correo')" />
        </div>
        <Validate-Errors v-if="personaStore.errors != 0" :errors="personaStore.errors" />
        <template #footer>
            <Button @click="personaStore.resetData()" text="Cancelar" icon="fas fa-xmark" class="btn-dark rounded-full"/>
            <Button @click="personaStore.store" text="Aceptar" icon="fas fa-check" class="btn-danger rounded-full"/>
        </template>
    </Modal>

</template>

<style scoped>
    .background-img {
        background-image: url('/public/img/foto-card.jpg');
    }
</style>
