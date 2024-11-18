<script setup>

    import { ref, watchEffect, onMounted } from 'vue'
    import { useEscuelasStore } from '@/stores/escuelas/escuelas'
    import { useProgramasStore } from '@/stores/escuelas/programas'
    import { useNivelesStore } from '@/stores/escuelas/niveles'
    import { useSeccionesStore } from '@/stores/escuelas/secciones'
    import { useCursosStore } from '@/stores/escuelas/cursos'
    import { useInstructoresStore } from '@/stores/escuelas/instructores'
    import { useHorariosStore } from '@/stores/escuelas/horarios'
    import { useGlobalStore } from '@/stores/global'
    import { useSedesStore } from '@/stores/escuelas/sedes'

    import FormCard from '@/components/FormCard.vue'
    import SelectSearch from '@/components/SelectSearch.vue'
    import axios from 'axios'
    
    const props = defineProps(['escuela_id'])
    
    const escuelaStore = useEscuelasStore()
    const programaStore = useProgramasStore()
    const nivelStore = useNivelesStore()
    const seccionStore = useSeccionesStore()
    const cursoStore = useCursosStore()
    const instructorStore = useInstructoresStore()
    const horarioStore = useHorariosStore()
    const sedeStore = useSedesStore()
    const global = useGlobalStore()

    const escuela = ref({
        escuela_id : props.escuela_id,
        programa_id : '',
        nivel_id : '',
        seccion_id : '',
        curso_id : '',
        instructor_id : '',
        horario_id : '',
        modalidad : '',
        sede_id : '',
    })

    const zonas = ref([])

    const type = ref({
        url : '',
        title : ''
    })

    const openModal = ref(false)

    const resource = ref({
        escuela_id : props.escuela_id,
        nombre : '',
        descripcion : '',
        hora_inicial : '',
        hora_final : '',
        dia:'',
        modalidad : '',
        direccion : '',
        zona_id: '',
        di_direccion_id : localStorage.getItem('direccion_id'),
        cupo : ''
    })

    const loading = ref(false)
    const errors = ref([])

    const syncResources = () => {
        loading.value = true
        axios.post('portafolio/store',escuela.value)
        .then(response => {
            if(response.data.status == 'ok'){
                programaStore.fetch();
                if(props.escuela_id) {
                    escuelaStore.fetchEscuela(props.escuela_id)
                }
                global.setAlert(response.data.message,'success')
                resetData()

            }else{
                global.setAlert(response.data.message,'danger')
            }
        })
        .catch(error => {
            if(error.response.data.errors){
                errors.value = error.response.data.errors
            }else{
                global.setAlert(error.response.data,'danger')
            }
        })
        .finally(() => loading.value = false)
    }

    const openResource = (url,title) => {
        type.value.url = url
        type.value.title = title
        openModal.value = true
    }

    const createResource = () => {
        loading.value = true
        axios.post(`${type.value.url}/store`,resource.value)
        .then(response => {
            if(response.data.status == 'ok'){
                if(props.escuela_id) {
                    escuelaStore.fetchEscuela(props.escuela_id)
                }
                programaStore.fetch(props.escuela_id)
                nivelStore.fetch()
                seccionStore.fetch()
                cursoStore.fetch()
                instructorStore.fetch()
                horarioStore.fetch()
                sedeStore.fetch()
                global.setAlert(response.data.message,'success')
                reset()

            }else{
                global.setAlert(response.data.message,'danger')
            }
        })
        .catch(error => {
            if(error.response.data.errors){
                errors.value = error.response.data.errors
            }else{
                global.setAlert(error.response.data.message,'danger')
            }
        })
        .finally(() => loading.value = false)
    }

    const reset = () => {

        resource.value = {
            escuela_id : props.escuela_id,
            nombre : '',
            descripcion : '',
            hora_inicial : '',
            hora_final : '',
            dia:'',
            modalidad : '',
            sede_id : '',
            cupo : '',
        }

        openModal.value = false
        errors.value = []
        type.value = {
            url : '',
            title : ''
        }
    }

    const resetData = () => {

        escuela.value = {
            escuela_id : props.escuela_id,
            programa_id : '',
            nivel_id : '',
            seccion_id : '',
            curso_id : '',
            instructor_id : '',
            sede_id : '',
            horario_id : '',
            modalidad : ''
        }

        errors.value = []
    }

    function fetchZonas () {
        axios.get('zonas')
        .then(response => zonas.value = response.data)
        .catch(error => console.error(error.response.data))
    }
    
    watchEffect(() => {
        if(props.escuela_id) {
            escuelaStore.fetchEscuela(props.escuela_id)
        }
    })

    onMounted(() => {
        programaStore.fetch(props.escuela_id)
        nivelStore.fetch()
        seccionStore.fetch()
        cursoStore.fetch()
        instructorStore.fetch()
        horarioStore.fetch()
        sedeStore.fetch()
        fetchZonas()
    })

</script>

<template>
    <div v-if="props.escuela_id">
        <h2 class="text-2xl font-medium">
            <Icon icon="fas fa-school" class="text-violet-500" />
            Escuela Municipal de 
            {{ escuelaStore.escuela.nombre }}
        </h2>
    </div>
    <br>
    <FormCard>
        <template #description>
            
            <h1 class="text-center font-medium text-2xl text-gray-500">Detalle de los programas</h1>
            <br>
            <div class="md:pr-5">
                
                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Programa</th>
                            <th>Niveles</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <template v-if="props.escuela_id">
                            <template v-for="programa in escuelaStore.escuela.programas">
                                <tr v-if="!programa.deleted_at">
                                    <td>{{ programa.id }}</td>
                                    <td>{{ programa.nombre }}</td>
                                    <td class="grid gap-1 md:flex md:gap-5">
                                        <span v-for="nivel in programa.niveles" @click="nivelStore.view(nivel.id,programa.id)" class="bg-violet-100 text-violet-400 px-2 py-1 rounded-full text-xs text-center cursor-pointer hover:scale-105">
                                            {{ nivel.nombre }}
                                        </span>
                                    </td>
                                </tr>
                            </template>
                        </template>
                        <template v-else>
                            <template v-for="programa in programaStore.programas">
                                <tr v-if="!programa.deleted_at">
                                    <td>{{ programa.id }}</td>
                                    <td>{{ programa.nombre }}</td>
                                    <td class="grid gap-1 md:flex md:gap-5">
                                        <span v-for="nivel in programa.niveles" @click="nivelStore.view(nivel.id,programa.id)" class="bg-violet-100 text-violet-400 px-2 py-1 rounded-full text-xs text-center cursor-pointer hover:scale-105">
                                            {{ nivel.nombre }}
                                        </span>
                                    </td>
                                </tr>
                            </template>
                        </template>
                    </tbody>
                </table>
            </div>
            
        </template>
        <template #form>
            <hr class="xl:hidden my-5 xl:my-0">
            <h1 class="text-center text-2xl font-medium text-gray-500">Asignar recursos existentes</h1>
            <br>
            <div class="pl-5 grid gap-5">
                <div class="flex items-center gap-3">
                     <SelectSearch :items="programaStore.programas" v-model="escuela.programa_id" :fields="['id','nombre']" title="Seleccione programa" :error="errors.hasOwnProperty('programa_id')" />
                    <Icon icon="fas fa-plus" @click="openResource('programas','Nuevo programa')" class="icon-button bg-violet-500" />
                </div>
                <div class="flex items-center gap-3">
                    <SelectSearch :items="nivelStore.niveles" v-model="escuela.nivel_id" :fields="['id','nombre']" title="Seleccione nivel" :error="errors.hasOwnProperty('nivel_id')" />
                    <Icon icon="fas fa-plus" @click="openResource('niveles','Nuevo nivel')" class="icon-button bg-violet-500" />
                </div>
                <div class="flex items-center gap-3">
                    <SelectSearch :items="seccionStore.secciones" v-model="escuela.seccion_id" :fields="['id','nombre']" title="Seleccione sección" :error="errors.hasOwnProperty('seccion_id')" />
                    <Icon icon="fas fa-plus" @click="openResource('secciones','Nueva seccion')" class="icon-button bg-violet-500" />
                </div>
                <div class="flex items-center gap-3">
                    <SelectSearch :items="cursoStore.cursos" v-model="escuela.curso_id" :fields="['id','nombre']" title="Seleccione curso" :error="errors.hasOwnProperty('curso_id')" />
                    <Icon icon="fas fa-plus" @click="openResource('cursos','Nuevo curso')" class="icon-button bg-violet-500" />
                </div>
                <div class="flex items-center gap-3">
                    <SelectSearch :items="instructorStore.instructores" v-model="escuela.instructor_id" :fields="['id','nombre']" title="Seleccione instructor" :error="errors.hasOwnProperty('instructor_id')" />
                    <Icon icon="fas fa-plus" @click="openResource('instructores','Nuevo instructor')" class="icon-button bg-violet-500" />
                </div>
                <div class="flex items-center gap-3">
                    <SelectSearch :items="horarioStore.horarios" v-model="escuela.horario_id" :fields="['id','dia']" title="Seleccione horario" format="item.dia+' '+item.hora_inicial+' - '+item.hora_final" :error="errors.hasOwnProperty('horario_id')" />
                    <Icon icon="fas fa-plus" @click="openResource('horarios','Nuevo horario')" class="icon-button bg-violet-500" />
                </div>
                <div class="flex items-center gap-3">
                    <SelectSearch :items="sedeStore.sedes" v-model="escuela.sede_id" :fields="['id','nombre']" title="Seleccione sede" format="item.nombre+' - '+item.direccion + ' ZONA '+ item.zona.numero" :error="errors.hasOwnProperty('sede_id')" />
                    <Icon icon="fas fa-plus" @click="openResource('sedes','Nueva Sede')" class="icon-button bg-violet-500" />
                </div>
                <fieldset class="border rounded p-4">
                    <legend class="px-3 text-violet-500">MODALIDAD</legend>
                    <div class="grid grid-cols-3 justify-items-center text-violet-500">
                        <label class="flex gap-3 cursor-pointer">
                            <input type="radio" v-model="escuela.modalidad" name="modalidad" value="PRESENCIAL">
                            <span>PRESENCIAL</span>
                        </label>
                        <label class="flex gap-3 cursor-pointer">
                            <input type="radio" v-model="escuela.modalidad" name="modalidad" value="VIRTUAL">
                            <span>VIRTUAL</span>
                        </label>
                        <label class="flex gap-3 cursor-pointer">
                            <input type="radio" v-model="escuela.modalidad" name="modalidad" value="HIBRIDA">
                            <span>HIBRIDA</span>
                        </label>
                    </div>
                </fieldset>
                <br>
                <Validate-Errors :errors="errors" v-if="errors != 0" />
            </div>
            <div class="flex justify-end">
                <Button @click="syncResources" text="Asignar recursos" icon="fas fa-plus" class="btn-primary rounded-full" :loading="loading" />
            </div>
        </template>
    </FormCard>

    <Modal :open="openModal" :title="type.title" icon="fas fa-book" class="w-96 h-full">
        <div v-if="type.url != 'horarios'" class="grid gap-4">
            <SelectSearch v-if="type.url == 'sedes'" :items="zonas" v-model="resource.zona_id" :fields="['id','numero']" title="SELECCIONE ZONA" format="'Zona '+ item.numero" :error="errors.hasOwnProperty('zona_id')" />
            <Input v-if="type.url == 'sedes'" option="label" title="direccion" v-model="resource.direccion" :error="errors.hasOwnProperty('direccion')" autocomplete="off" />
            <Input option="label" title="nombre" v-model="resource.nombre" :error="errors.hasOwnProperty('nombre')" autocomplete="off" />
            <Input v-if="type.url == 'cursos'" option="label" title="cupo" type="number" v-model="resource.cupo" :error="errors.hasOwnProperty('cupo')" autocomplete="off" />
            <Input v-if="['programas','cursos'].includes(type.url)" option="text-area" title="descripcion" rows="4" v-model="resource.descripcion" autocomplete="off" />
            
            
        </div>
        <div v-else>   
            <Input option="select" title="Día" v-model="resource.dia" :error="errors.hasOwnProperty('dia')">
                <option value=""></option>
                <option value="Lunes">Lunes</option>
                <option value="Martes">Martes</option>
                <option value="Miercoles">Miercoles</option>
                <option value="Jueves">Jueves</option>
                <option value="Viernes">Viernes</option>
                <option value="Sabado">Sábado</option>
                <option value="Lunes a Viernes">Lunes a Viernes</option>
                <option value="Lun - Mie - Vie">Lun - Mie - Vie</option>
                <option value="Mar - Jue">Mar - Jue</option>
            </Input>

            <Input v-model="resource.hora_inicial" type="time" min="07:00" max="18:00" option="label" title="Hora inicial" />
            <Input v-model="resource.hora_final" type="time" min="07:00" max="18:00" option="label" title="Hora final" />
        </div>
        <Validate-Errors v-if="errors != 0" :errors="errors" />
        <template #footer>
            <Button @click="reset" text="Cancelar" icon="fas fa-xmark" class="btn-dark rounded-lg" />
            <Button @click="createResource" text="Crear" icon="fas fa-plus" class="btn-primary rounded-lg" />
        </template>
    </Modal>

    <Modal :open="nivelStore.openModalView" :title="nivelStore.nivel?.nombre" icon="fas fa-book" class="w-3/4">
        <template #close>
            <Icon @click="nivelStore.resetData" icon="fas fa-xmark" class="text-white text-xl cursor-pointer hover:scale-110" />
        </template>
        <div class="grid gap-2" >
            <template v-for="(cursos,index) in nivelStore.nivel.secciones">
                <details open class="border rounded-lg p-5 ">
                    <summary class="cursor-pointer text-violet-500 font-medium">
                        {{ `Cursos de la sección: ${index}` }}
                    </summary>
                    <Loading-Bar v-if="cursoStore.loading" class="h-1 bg-violet-300" />
                    <Transition name="fade">
                        <table class="table-fixed w-full text-sm">
                            <thead>
                                <tr>
                                    <th>Curso</th>
                                    <th>Horario</th>
                                    <th>Instructor</th>
                                    <th>Modalidad</th>
                                    <th>Sede</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="detalle in cursos">
                                    <td>{{ detalle.curso.nombre }}</td>
                                    <td>{{ `${detalle.horario.dia} ${detalle.horario.hora_inicial} - ${detalle.horario.hora_final}` }}</td>
                                    <td>{{ detalle.instructor.nombre }}</td>
                                    <td>{{ detalle.modalidad }}</td>
                                    <td>{{ detalle.sede.nombre + ' ' + detalle.sede.direccion + ' ZONA ' + detalle.sede.zona.numero  }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </Transition>
                </details>
            </template>
        </div>
    </Modal>
    
</template>

<style scoped>

    td{
        @apply py-3 px-3;
    }

    th{
        @apply font-semibold py-2 px-3 text-left text-gray-400;
    }

    tr {
        @apply hover:bg-gray-50;
    }

</style>