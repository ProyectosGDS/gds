<script setup>
    import { useAdministrativoStore } from '../stores/administrativo'

    const store = useAdministrativoStore()

</script>

<template>
    <Card class="bg-white p-8">
        <template #header>
            <h1 class="text-xl text-violet-400">Administrativo</h1>
        </template>
        <br>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">

            <Input option="label" title="no. formularo" v-model="store.data.formulario" :error="store.errors.hasOwnProperty('formulario')" autocomplete="off" />
            <Input option="label" title="fecha de inscripciòn" type="date" v-model="store.data.fecha_inscripcion" :error="store.errors.hasOwnProperty('fecha_inscripcion')"autocomplete="off" />
            <Input option="label" title="lugar de inscripcion" v-model="store.data.lugar_inscripcion" :error="store.errors.hasOwnProperty('lugar_inscripcion')" autocomplete="off" />
            <Select v-model="store.data.zona" placeholder="PROGRAMA SOCIAL" :items="zonas" :fields="['id','name']" format="'Zona ' + item.name" :error="store.errors.hasOwnProperty('zona')" />
            <Select v-model="store.data.zona" placeholder="CURSO" :items="zonas" :fields="['id','name']" format="'Zona ' + item.name" :error="store.errors.hasOwnProperty('zona')" />
            <Select v-model="store.data.zona" placeholder="SEDE" :items="zonas" :fields="['id','name']" format="'Zona ' + item.name" :error="store.errors.hasOwnProperty('zona')" />
            <Select v-model="store.data.zona" placeholder="HORARIO" :items="zonas" :fields="['id','name']" format="'Zona ' + item.name" :error="store.errors.hasOwnProperty('zona')" />
            <Input option="label" title="NO PLACA" v-model="store.data.placa" :error="store.errors.hasOwnProperty('placa')" autocomplete="off" />
            
            <Input option="label" title="primer apellido" v-model="store.data.primer_apellido" :error="store.errors.hasOwnProperty('primer_apellido')" autocomplete="off" />
            <Input option="label" title="segundo apellido" v-model="store.data.segundo_apellido" :error="store.errors.hasOwnProperty('segundo_apellido')" autocomplete="off" />
            <Input option="label" title="apellido casada" v-model="store.data.apellido_casada" :error="store.errors.hasOwnProperty('apellido_casada')" autocomplete="off" />
        
            <div class="flex gap-3 items-center justify-center">
                <label>
                    <input type="checkbox">
                    Le acompaña un menor ?
                </label>
            </div>
            <Select class="col-span-3" v-model="store.data.zona" placeholder="QUE OTRO CURSO MUNICIPAL HA RECIBIDO ?" :items="zonas" :fields="['id','name']" format="'Zona ' + item.name" :error="store.errors.hasOwnProperty('zona')" />
        </div>
    </Card>
    <br>
    <Card class="bg-white p-8">
        <template #header>
            <h1 class="text-xl text-violet-400">Datos pago</h1>
        </template>
        <br>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
            <Input option="label" title="cui / dpi" type="number" v-model="store.data.telefono" :error="store.errors.hasOwnProperty('telefono')" autocomplete="off" />
            <Input option="label" title="no interlocutor sap" type="number" v-model="store.data.celular" :error="store.errors.hasOwnProperty('celular')" autocomplete="off" />
            <Input option="label" title="monto" type="email" v-model="store.data.correo" :error="store.errors.hasOwnProperty('correo')" autocomplete="off" />
        </div>
        <br>
        <template #footer>
            <div class="flex justify-evenly">
                <Button text="Cancelar" icon="fas fa-xmark" class="btn-dark rounded-full" />
                <Button text="Aceptar" icon="fas fa-check" class="btn-primary rounded-full" />
            </div>
        </template>
    </Card>
</template>