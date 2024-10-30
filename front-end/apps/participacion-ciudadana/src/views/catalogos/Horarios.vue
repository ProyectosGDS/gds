<script setup>
    import { onMounted } from 'vue'
    import { useHorariosStore } from '../../stores/escuelas/horarios'

    import DropDownButton from '@/components/DropDownButton.vue'

    const store = useHorariosStore()

    onMounted(() => {
        store.fetch()
    })

</script>

<template>
    <Card class="bg-white p-8">
        <h1 class="text-2xl text-gray-500 font-semibold">Horarios</h1>
        <div class="flex justify-center">
            <Tool-Tip message="Crear nuevo horario" class="-mt-8 text-violet-400">
                <Button @click="store.openModalNew = true" icon="fas fa-plus" class="btn-primary" />
            </Tool-Tip>
        </div>
        <Data-Table :headers="store.headers" :data="store.horarios" :loading="store.loading" :export="false">
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
    <Modal :open="store.openModalNew" icon="fas fa-school" title="Crear nuevo horario" class="w-96">
        <template #close>
            <Icon @click="store.resetData" icon="fas fa-xmark" class="text-violet-200 text-xl hover:scale-125 cursor-pointer" />
        </template>

        <div>
            <Input option="select" title="Día" v-model="store.horario.dia" :error="store.errors.hasOwnProperty('dia')">
                <option value=""></option>
                <option value="Lunes">Lunes</option>
                <option value="Martes">Martes</option>
                <option value="Miercoles">Miercoles</option>
                <option value="Jueves">Jueves</option>
                <option value="Viernes">Viernes</option>
                <option value="Sábado">Sábado</option>
                <option value="Lunes a Viernes">Lunes a Viernes</option>
                <option value="Lun - Mie - Vie">Lun - Mie - Vie</option>
                <option value="Mar - Jue">Mar - Jue</option>
            </Input>

            <Input v-model="store.horario.hora_inicial" type="time" min="07:00" max="18:00" option="label" title="Hora inicial" :error="store.errors.hasOwnProperty('hora_inicial')" />
            <Input v-model="store.horario.hora_final" type="time" min="07:00" max="18:00" option="label" title="Hora final" :error="store.errors.hasOwnProperty('hora_final')" />
            <Validate-Errors :errors="store.errors" v-if="store.errors != 0" />
        </div>


        <template #footer>
            <Button @click="store.resetData" text="Cancelar" icon="fas fa-xmark" class="btn-dark rounded-full" />
            <Button @click="store.store" text="Crear" icon="fas fa-plus" class="btn-primary rounded-full" :loading="store.loading" />
        </template>
    </Modal>

    <Modal :open="store.openModalEdit" title="Editar horario" icon="fas fa-school" class="w-96">
        <template #close>
            <Icon @click="store.resetData" icon="fas fa-xmark" class="text-violet-200 text-xl hover:scale-125 cursor-pointer" />
        </template>
        <div>
            <div class="flex justify-end">
                <div class="flex gap-3 text-gray-500">
                    <span>Activo</span>
                    <Switch :values="[null,0]" v-model="store.horario.deleted_at" class="bg-gray-400 w-12 has-[:checked]:bg-violet-400"/>
                    <span>Inactivo</span>
                </div>
            </div>
            <br>
            <Input option="select" title="Día" v-model="store.horario.dia" :error="store.errors.hasOwnProperty('dia')" :disabled="store.horario.deleted_at">
                <option value=""></option>
                <option value="Lunes">Lunes</option>
                <option value="Martes">Martes</option>
                <option value="Miercoles">Miercoles</option>
                <option value="Jueves">Jueves</option>
                <option value="Viernes">Viernes</option>
                <option value="Sábado">Sábado</option>
                <option value="Diario">Diario</option>
                <option value="Lun - Mie - Vie">Lun - Mie - Vie</option>
                <option value="Mar - Jue">Mar - Jue</option>
            </Input>

            <Input v-model="store.horario.hora_inicial" type="time" min="07:00" max="18:00" option="label" title="Hora inicial" :error="store.errors.hasOwnProperty('hora_inicial')" :disabled="store.horario.deleted_at" />
            <Input v-model="store.horario.hora_final" type="time" min="07:00" max="18:00" option="label" title="Hora final" :error="store.errors.hasOwnProperty('hora_final')" :disabled="store.horario.deleted_at" />
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
                <h1>¿Esta seguro de eliminar el horario?</h1>
                <h2 class="text-center font-semibold text-xl">{{ `${store.horario.dia} ${store.horario.hora_inicial} - ${store.horario.hora_final}` }}</h2>
            </div>
        </div>
        <template #footer>
            <Button @click="store.resetData" text="Cancelar" icon="fas fa-xmark" class="btn-dark rounded-full" />
            <Button @click="store.destroy" text="Sí, estoy seguro" icon="fas fa-check" class="btn-danger rounded-full" :loading="store.loading" />
        </template>
    </Modal>

</template>