<script setup>
    import { onMounted } from 'vue'
    import { usePortafolioStore } from '@/stores/portafolio'
    import DataCard from '@/components/DataCard.vue'

    const store = usePortafolioStore()

    onMounted(() => {
        store.fetch()
        store.fetchDirecciones()
    })
</script>

<template>
    
    <div>
        <ul class="flex flex-wrap justify-center gap-4 text-violet-400">
            <li v-for="direccion in store.direcciones">{{ direccion.nombre }}</li>
        </ul>
    </div>

    <hr class="my-4">

    <div v-if="store.openDetails">
        <h1 class="text-2xl text-gray-500 font-semibold">Cursos disponibles</h1>
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
                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Vitae iste minima quae id aut cum, unde veritatis voluptatibus dolor voluptate similique enim, tempora ipsum! Eligendi recusandae reiciendis minus odio id!
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
                            <span>{{ store.portafolio.programa.escuela.direccion }}</span>
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
                <div class="h-[80%] flex items-center justify-center">
                    <Button @click="store.openModalView = true " text="Inscribete" class="bg-blue-muni text-white rounded-full h-16 w-40 text-3xl" />
                </div>
            </div>
        </div>
    </div>

    <Modal :open="store.openModalView" title="Ficha de inscripcion" icon="fa fa-file-signature">
        <template #close>
            <Icon @click="store.openModalView = false" icon="fas fa-xmark" class="text-xl text-violet-200" />
        </template>
        <div class="grid gap-3">

            primer_nombre
            segundo_nombre
            tercer_nombre
            primer_apellido
            segundo_apellido
            apellido_casada
            cui,
            correo electrónico,
            teléfono,
             
            <Input option="label" title="Primer nombre" :error="false" />
            <Input option="label" title="Segundo nombre" :error="false" />
            <Input option="label" title="Tercer nombre" :error="false" />
            <Input option="label" title="Primer apellido" :error="false" />
            <Input option="label" title="Segundo apellido" :error="false" />
            <Input option="label" title="apellido de casada" :error="false" />
            <Input option="label" title="cui" :error="false" />
            <Input type="email" option="label" title="correo electronico" :error="false" />
            <Input type="tel" option="label" title="teléfono" :error="false" />
        </div>
        <template #footer>
            <Button @click="store.openModalView = false" text="Cancelar" icon="fas fa-xmark" class="btn-dark rounded-full"/>
            <Button text="Aceptar" icon="fas fa-check" class="btn-danger rounded-full"/>
        </template>
    </Modal>

</template>

<style scoped>
    .background-img {
        background-image: url('/public/img/foto-card.jpg');
    }
</style>
