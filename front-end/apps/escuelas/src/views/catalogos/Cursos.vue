<script setup>
    import { onMounted } from 'vue'
    import { useCursosStore } from '@/stores/escuelas/cursos'

    import DropDownButton from '@/components/DropDownButton.vue'

    const store = useCursosStore()

    onMounted(() => {
        store.fetch()
    })

</script>

<template>

    <Card class="bg-white p-8">
        <h1 class="text-2xl text-gray-500 font-semibold">Cursos</h1>
        <div class="flex justify-center">
            <Tool-Tip message="Crear nuevo curso" class="-mt-8 text-violet-400">
                <Button @click="store.openModalNew = true" icon="fas fa-plus" class="btn-primary" />
            </Tool-Tip>
        </div>
        <Data-Table :headers="store.headers" :data="store.cursos" :loading="store.loading" :export="false">
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
    <Modal :open="store.openModalNew" icon="fas fa-school" title="Crear nuevo curso" class="w-96">
        <template #close>
            <Icon @click="store.resetData" icon="fas fa-xmark" class="text-violet-200 text-xl hover:scale-125 cursor-pointer" />
        </template>

        <div class="grid gap-3">
            <Input v-model="store.curso.nombre" option="label" title="Nombre del curso" :error="store.errors.hasOwnProperty('nombre')" />
            <Input v-model="store.curso.descripcion" option="text-area" title="Descripción" />
            <Validate-Errors :errors="store.errors" v-if="store.errors != 0" />
        </div>


        <template #footer>
            <Button @click="store.resetData" text="Cancelar" icon="fas fa-xmark" class="btn-dark rounded-full" />
            <Button @click="store.store" text="Crear" icon="fas fa-plus" class="btn-primary rounded-full" :loading="store.loading" />
        </template>
    </Modal>

    <Modal :open="store.openModalEdit" title="Editar curso" icon="fas fa-school" class="w-96">
        <template #close>
            <Icon @click="store.resetData" icon="fas fa-xmark" class="text-violet-200 text-xl hover:scale-125 cursor-pointer" />
        </template>
        <div class="grid gap-3">
            <div v-if="store.curso.deleted_at" class="flex justify-end">
                <div class="flex gap-3 text-gray-500">
                    <span>Activo</span>
                    <Switch :values="[null,0]" v-model="store.curso.deleted_at" class="bg-gray-400 w-12 has-[:checked]:bg-violet-400"/>
                    <span>Inactivo</span>
                </div>
            </div>
            <Input v-model="store.curso.nombre" option="label" title="Nombre del curso" :error="store.errors.hasOwnProperty('nombre')" :disabled="store.curso.deleted_at" />
            <Input v-model="store.curso.descripcion" option="text-area" title="Descripción" :disabled="store.curso.deleted_at" />
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
                <h1>¿Esta seguro de eliminar el curso?</h1>
                <h2 class="text-center font-semibold text-xl">{{ store.curso.nombre }}</h2>
            </div>
        </div>
        <template #footer>
            <Button @click="store.resetData" text="Cancelar" icon="fas fa-xmark" class="btn-dark rounded-full" />
            <Button @click="store.destroy" text="Sí, estoy seguro" icon="fas fa-check" class="btn-danger rounded-full" :loading="store.loading" />
        </template>
    </Modal>

</template>