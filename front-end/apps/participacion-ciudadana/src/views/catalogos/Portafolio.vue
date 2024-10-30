<script setup>
    import { onMounted } from 'vue'
    import { usePortafolioStore } from '../../stores/escuelas/portafolio'
    import { useProgramasStore } from '../../stores/escuelas/programas'
    import { useNivelesStore } from '../../stores/escuelas/niveles'
    import { useSeccionesStore } from '../../stores/escuelas/secciones'
    import { useCursosStore } from '../../stores/escuelas/cursos'
    import { useInstructoresStore } from '../../stores/escuelas/instructores'
    import { useHorariosStore } from '../../stores/escuelas/horarios'

    import DropDownButton from '@/components/DropDownButton.vue'

    const store = usePortafolioStore()

    const programaStore = useProgramasStore()
    const nivelStore = useNivelesStore()
    const seccionStore = useSeccionesStore()
    const cursoStore = useCursosStore()
    const instructorStore = useInstructoresStore()
    const horarioStore = useHorariosStore()

    onMounted(() => {
        store.fetch()
        programaStore.fetch()
        nivelStore.fetch()
        seccionStore.fetch()
        cursoStore.fetch()
        instructorStore.fetch()
        horarioStore.fetch()
    })

</script>

<template>

    <Card class="bg-white p-8">
        <h1 class="text-2xl text-gray-500 font-semibold">Portafolio</h1>
        <div class="flex justify-center">
            <Tool-Tip message="Crear nuevo portafolio" class="-mt-8 text-violet-400">
                <Button @click="store.openModalNew = true" icon="fas fa-plus" class="btn-primary" />
            </Tool-Tip>
        </div>
        <Data-Table :headers="store.headers" :data="store.portafolios" :loading="store.loading" :export="false">
            <template #horario.dia="{item}">
                {{ `${item.horario.dia} ${item.horario.hora_inicial} - ${item.horario.hora_final}` }}
            </template>
            <template #deleted_at="{item}">
                <Tool-Tip :message="item.deleted_at ? 'Inactivado el: '+item.deleted_at : ' Activo '" class="-mt-8" :class="item.deleted_at ? 'text-red-400' : ' text-green-400 '">
                    <Icon :icon="item.deleted_at ? 'fas fa-xmark' : 'fas fa-check'" :class="item.deleted_at ? 'text-red-500' : 'text-green-500'"/>
                </Tool-Tip>
            </template>
            <template #actions="{item}">
                <div class="relative">
                    <DropDownButton icon="fas fa-ellipsis-vertical">
                        <ul class="grid gap-3 text-violet-500">
                            <li @click="store.edit(item)" class="hover:font-medium cursor-pointer">
                                Editar
                            </li>
                            <hr>
                            <li v-if="!item.deleted_at" @click="store.deleteItem(item)" class="hover:font-medium cursor-pointer">
                                Eliminar
                            </li>
                        </ul>
                    </DropDownButton>
                </div>
            </template>
        </Data-Table>
    </Card>

    <!-- AREA DE MODALES -->
    <Modal :open="store.openModalNew" icon="fas fa-school" title="Crear nuevo portafolio" class="w-96">
        <template #close>
            <Icon @click="store.resetData" icon="fas fa-xmark" class="text-violet-200 text-xl hover:scale-125 cursor-pointer" />
        </template>

        <div>
            <Input v-model="store.portafolio.programa_id" option="select" title="Seleccione programa" :error="store.errors.hasOwnProperty('programa_id')" >
                <option value=""></option>
                <option v-for="programa in programaStore.programas" :value="programa.id">{{ programa.nombre }}</option>
            </Input>
            <Input v-model="store.portafolio.nivel_id" option="select" title="Seleccione nivel" :error="store.errors.hasOwnProperty('nivel_id')" >
                <option value=""></option>
                <option v-for="nivel in nivelStore.niveles" :value="nivel.id">{{ nivel.nombre }}</option>
            </Input>
            <Input v-model="store.portafolio.seccion_id" option="select" title="Seleccione seccion" :error="store.errors.hasOwnProperty('seccion_id')" >
                <option value=""></option>
                <option v-for="seccion in seccionStore.secciones" :value="seccion.id">{{ seccion.nombre }}</option>
            </Input>
            <Input v-model="store.portafolio.curso_id" option="select" title="Seleccione curso" :error="store.errors.hasOwnProperty('curso_id')" >
                <option value=""></option>
                <option v-for="curso in cursoStore.cursos" :value="curso.id">{{ curso.nombre }}</option>
            </Input>
            <Input v-model="store.portafolio.instructor_id" option="select" title="Seleccione instructor" :error="store.errors.hasOwnProperty('instructor_id')" >
                <option value=""></option>
                <option v-for="instructor in instructorStore.instructores" :value="instructor.id">{{ instructor.nombre }}</option>
            </Input>
            <Input v-model="store.portafolio.horario_id" option="select" title="Seleccione horario" :error="store.errors.hasOwnProperty('horario_id')" >
                <option value=""></option>
                <option v-for="horario in horarioStore.horarios" :value="horario.id">{{ `${horario.dia} ${horario.hora_inicial} - ${horario.hora_final}` }}</option>
            </Input>
            <fieldset class="border rounded p-4">
                    <legend class="px-3 text-violet-500">MODALIDAD</legend>
                    <div class="grid grid-cols-3 justify-items-center text-violet-500">
                        <label class="flex gap-3 cursor-pointer">
                            <input type="radio" v-model="store.portafolio.modalidad" name="modalidad" value="PRESENCIAL">
                            <span>PRESENCIAL</span>
                        </label>
                        <label class="flex gap-3 cursor-pointer">
                            <input type="radio" v-model="store.portafolio.modalidad" name="modalidad" value="VIRTUAL">
                            <span>VIRTUAL</span>
                        </label>
                        <label class="flex gap-3 cursor-pointer">
                            <input type="radio" v-model="store.portafolio.modalidad" name="modalidad" value="HIBRIDA">
                            <span>HIBRIDA</span>
                        </label>
                    </div>
                </fieldset>
            <Validate-Errors :errors="store.errors" v-if="store.errors != 0" />
        </div>


        <template #footer>
            <Button @click="store.resetData" text="Cancelar" icon="fas fa-xmark" class="btn-dark rounded-full" />
            <Button @click="store.store" text="Crear" icon="fas fa-plus" class="btn-primary rounded-full" :loading="store.loading" />
        </template>
    </Modal>

    <Modal :open="store.openModalEdit" title="Editar portafolio" icon="fas fa-school" class="w-96">
        <template #close>
            <Icon @click="store.resetData" icon="fas fa-xmark" class="text-violet-200 text-xl hover:scale-125 cursor-pointer" />
        </template>
        <div>
            <div class="flex justify-end">
                <div class="flex gap-3 text-gray-500">
                    <span>Activo</span>
                    <Switch :values="[null,0]" v-model="store.portafolioEdit.deleted_at" class="bg-gray-400 w-12 has-[:checked]:bg-violet-400"/>
                    <span>Inactivo</span>
                </div>
            </div>
            <br>
            <Input v-model="store.portafolioEdit.programa_id" option="select" title="Seleccione programa" :error="store.errors.hasOwnProperty('programa_id')" :disabled="store.portafolio.deleted_at" >
                <option value=""></option>
                <option v-for="programa in programaStore.programas" :value="programa.id">{{ programa.nombre }}</option>
            </Input>
            <Input v-model="store.portafolioEdit.nivel_id" option="select" title="Seleccione nivel" :error="store.errors.hasOwnProperty('nivel_id')" :disabled="store.portafolio.deleted_at" >
                <option value=""></option>
                <option v-for="nivel in nivelStore.niveles" :value="nivel.id">{{ nivel.nombre }}</option>
            </Input>
            <Input v-model="store.portafolioEdit.seccion_id" option="select" title="Seleccione seccion" :error="store.errors.hasOwnProperty('seccion_id')" :disabled="store.portafolio.deleted_at" >
                <option value=""></option>
                <option v-for="seccion in seccionStore.secciones" :value="seccion.id">{{ seccion.nombre }}</option>
            </Input>
            <Input v-model="store.portafolioEdit.curso_id" option="select" title="Seleccione curso" :error="store.errors.hasOwnProperty('curso_id')" :disabled="store.portafolio.deleted_at" >
                <option value=""></option>
                <option v-for="curso in cursoStore.cursos" :value="curso.id">{{ curso.nombre }}</option>
            </Input>
            <Input v-model="store.portafolioEdit.instructor_id" option="select" title="Seleccione instructor" :error="store.errors.hasOwnProperty('instructor_id')" :disabled="store.portafolio.deleted_at" >
                <option value=""></option>
                <option v-for="instructor in instructorStore.instructores" :value="instructor.id">{{ instructor.nombre }}</option>
            </Input>
            <Input v-model="store.portafolioEdit.horario_id" option="select" title="Seleccione horario" :error="store.errors.hasOwnProperty('horario_id')" :disabled="store.portafolio.deleted_at" >
                <option value=""></option>
                <option v-for="horario in horarioStore.horarios" :value="horario.id">{{ `${horario.dia} ${horario.hora_inicial} - ${horario.hora_final}` }}</option>
            </Input>
            <fieldset class="border rounded p-4">
                    <legend class="px-3 text-violet-500">MODALIDAD</legend>
                    <div class="grid grid-cols-3 justify-items-center text-violet-500">
                        <label class="flex gap-1 cursor-pointer">
                            <input type="radio" v-model="store.portafolioEdit.modalidad" name="modalidad" value="PRESENCIAL" :disabled="store.portafolio.deleted_at">
                            <span>PRESENCIAL</span>
                        </label>
                        <label class="flex gap-1 cursor-pointer">
                            <input type="radio" v-model="store.portafolioEdit.modalidad" name="modalidad" value="VIRTUAL" :disabled="store.portafolio.deleted_at">
                            <span>VIRTUAL</span>
                        </label>
                        <label class="flex gap-1 cursor-pointer">
                            <input type="radio" v-model="store.portafolioEdit.modalidad" name="modalidad" value="HIBRIDA" :disabled="store.portafolio.deleted_at">
                            <span>HIBRIDA</span>
                        </label>
                    </div>
                </fieldset>
            <Validate-Errors :errors="store.errors" v-if="store.errors != 0" />
        </div>
        <template #footer>
            <Button @click="store.resetData" text="Cancelar" icon="fas fa-xmark" class="btn-dark rounded-full" />
            <Button @click="store.update" text="Actualizar" icon="fas fa-save" class="btn-primary rounded-full" :loading="store.loading" />
        </template>
    </Modal>

    <Modal :open="store.openModalDelete">
        <div class="flex items-center gap-4">
            <Icon icon="fas fa-triangle-exclamation" class="text-6xl text-orange-500" />
            <div class="grid">
                <h1 class="text-xl font-bold">¿Esta seguro de eliminar el portafolio que contiene?</h1>
                <ul class="font-semibold">
                    <li>Programa: 
                        <span class="font-normal"> 
                            {{ store.portafolio?.programa?.nombre }}
                        </span>
                    </li>
                    <li>Nivel: 
                        <span class="font-normal"> 
                            {{ store.portafolio?.nivel?.nombre }}
                        </span>
                    </li>
                    <li>Seccion: 
                        <span class="font-normal"> 
                            {{ store.portafolio?.seccion?.nombre }}
                        </span>
                    </li>
                    <li>Curso: 
                        <span class="font-normal"> 
                            {{ store.portafolio?.curso?.nombre }}
                        </span>
                    </li>
                    <li>Horario: 
                        <span class="font-normal"> 
                            {{ `${store.portafolio?.horario?.dia} ${store.portafolio?.horario?.hora_inicial} - ${store.portafolio?.horario?.hora_final}` }}
                        </span>
                    </li>
                    <li>Instructor: 
                        <span class="font-normal"> 
                            {{ store.portafolio?.instructor?.nombre }}
                        </span>
                    </li>
                </ul>
            </div>
        </div>
        <template #footer>
            <Button @click="store.resetData" text="Cancelar" icon="fas fa-xmark" class="btn-dark rounded-full" />
            <Button @click="store.destroy" text="Sí, estoy seguro" icon="fas fa-check" class="btn-danger rounded-full" :loading="store.loading" />
        </template>
    </Modal>

</template>
