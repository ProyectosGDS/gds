<script setup>
    import { useDomicilioResponbaleStore } from '../stores/domicilio-responbale'
    import { useCatalogosStore } from '../stores/catalogos'
    import { onMounted, watchEffect } from 'vue'

    const store = useDomicilioResponbaleStore()
    const catalogos = useCatalogosStore()

    watchEffect(() => {
        store.changePais()
        store.changeDepartamento()
    })

    onMounted(() => {
        catalogos.fetchEnfermedades()
        catalogos.fetchEscolaridades()
        catalogos.fetchEtnias()
        catalogos.fetchGruposHabitacionales()
        catalogos.fetchPaises()
        catalogos.fetchParentescos()
        catalogos.fetchTipoSangre()
        catalogos.fetchZonas()
    })
</script>

<template>
    <Card class="bg-white p-8">
        <template #header>
            <h1 class="text-xl text-violet-400">Responsable</h1>
        </template>
        <br>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 grid-cols gap-5">

            <Input option="label" title="cui / dpi" v-model="store.data.cui" :error="store.errors.hasOwnProperty('cui')" maxlength="13" minlength="13" autocomplete="off" />
            
            <Input option="label" title="primer nombre" v-model="store.data.primer_nombre" :error="store.errors.hasOwnProperty('primer_nombre')" autocomplete="off" />
            <Input option="label" title="segundo nombre" v-model="store.data.segundo_nombre" :error="store.errors.hasOwnProperty('segundo_nombre')" autocomplete="off" />
            <Input option="label" title="tercer nombre" v-model="store.data.tercer_nombre" :error="store.errors.hasOwnProperty('tercer_nombre')" autocomplete="off" />
            
            <Input option="label" title="primer apellido" v-model="store.data.primer_apellido" :error="store.errors.hasOwnProperty('primer_apellido')" autocomplete="off" />
            <Input option="label" title="segundo apellido" v-model="store.data.segundo_apellido" :error="store.errors.hasOwnProperty('segundo_apellido')" autocomplete="off" />
            <Input option="label" title="apellido casada" v-model="store.data.apellido_casada" :error="store.errors.hasOwnProperty('apellido_casada')" autocomplete="off" />
        
            <div class="flex gap-3 items-center justify-center">
                Mujer
                <Switch class="w-14 h-7 bg-blue-500 has-[:checked]:bg-fuchsia-500" :values="['mujer','hombre']" v-model="store.data.genero" :error="store.errors.hasOwnProperty('genero')" />
                Hombre
            </div>
            <Select v-model="store.data.zona" placeholder="SELECCIONE ZONA" :items="catalogos.zonas" :fields="['id','numero']" format="'Zona ' + item.numero" :sort="false" :error="store.errors.hasOwnProperty('zona_id')" />
            <Select v-model="store.data.grupo_habitacional" placeholder="GRUPO HABITACIONAL" :items="catalogos.gruposHabitacionales" :fields="['id','nombre']" :error="store.errors.hasOwnProperty('grupo_habitacional_id')"/>
            <Input option="label" title="nombre grupo habitacional" v-model="store.data.nombre_grupo_habitacional" :error="store.errors.hasOwnProperty('nombre_grupo_habitacional')" autocomplete="off" />
            <Input option="label" title="dirección" v-model="store.data.direccion" :error="store.errors.hasOwnProperty('direccion')" autocomplete="off" />
            <Select v-model="store.data.pais_id" placeholder="PAIS" :items="catalogos.paises" :fields="['id','nombre']" :error="store.errors.hasOwnProperty('pais_id')"/>
            <Select v-model="store.data.departamento_id" placeholder="DEPARTAMENTO" :items="catalogos.departamentos" :fields="['id','nombre']" :error="store.errors.hasOwnProperty('departamento_id')"/>
            <Select v-model="store.data.municipio_id" placeholder="MUNICIPIO" :items="catalogos.municipios" :fields="['id','nombre']" :error="store.errors.hasOwnProperty('municipio_id')"/>
            <Input option="label" title="Telefono" type="number" v-model="store.data.telefono" :error="store.errors.hasOwnProperty('telefono')" autocomplete="off" />
            <Input option="label" title="Celular" type="number" v-model="store.data.celular" :error="store.errors.hasOwnProperty('celular')" autocomplete="off" />
            <Input option="label" title="Correo electronico" type="email" v-model="store.data.correo" :error="store.errors.hasOwnProperty('correo')" autocomplete="off" />
            <Select v-model="store.data.parentesco" placeholder="PARENTESCO" :items="catalogos.parentescos" :fields="['id','nombre']" :error="store.errors.hasOwnProperty('parentesco')"/>
        </div>
        <template #footer>
            <Button text="Guardar" icon="fas fa-save" class="btn-primary rounded-full" />
        </template>
    </Card>
    <br>
    <Card class="bg-white p-8">
        <template #header>
            <h1 class="text-xl text-violet-400">Contacto de emergencia</h1>
        </template>
        <br>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">

            <Input option="label" title="cui / dpi" v-model="store.data.cui" :error="store.errors.hasOwnProperty('cui')" maxlength="13" minlength="13" autocomplete="off" />
            
            <Input option="label" title="primer nombre" v-model="store.data.primer_nombre" :error="store.errors.hasOwnProperty('primer_nombre')" autocomplete="off" />
            <Input option="label" title="segundo nombre" v-model="store.data.segundo_nombre" :error="store.errors.hasOwnProperty('segundo_nombre')" autocomplete="off" />
            <Input option="label" title="tercer nombre" v-model="store.data.tercer_nombre" :error="store.errors.hasOwnProperty('tercer_nombre')" autocomplete="off" />
            
            <Input option="label" title="primer apellido" v-model="store.data.primer_apellido" :error="store.errors.hasOwnProperty('primer_apellido')" autocomplete="off" />
            <Input option="label" title="segundo apellido" v-model="store.data.segundo_apellido" :error="store.errors.hasOwnProperty('segundo_apellido')" autocomplete="off" />
            <Input option="label" title="apellido casada" v-model="store.data.apellido_casada" :error="store.errors.hasOwnProperty('apellido_casada')" autocomplete="off" />
        
            <div class="flex gap-3 items-center justify-center">
                Mujer
                <Switch class="w-14 h-7 bg-blue-500 has-[:checked]:bg-fuchsia-500" :values="['mujer','hombre']" v-model="store.data.genero" />
                Hombre
            </div>
            <Select v-model="store.data.zona_id" placeholder="SELECCIONE ZONA" :items="catalogos.zonas" :fields="['id','numero']" :sort="false" format="'Zona ' + item.numero" :error="store.errors.hasOwnProperty('zona_id')" />
            <Select v-model="store.data.grupo_habitacional" placeholder="GRUPO HABITACIONAL" :items="catalogos.gruposHabitacionales" :fields="['id','nombre']" :error="store.errors.hasOwnProperty('grupo_habitacional')"/>
            <Input option="label" title="dirección" v-model="store.data.direccion" :error="store.errors.hasOwnProperty('direccion')" autocomplete="off" />
            <Select v-model="store.data.pais" placeholder="PAIS" :items="catalogos.paises" :fields="['id','nombre']" :error="store.errors.hasOwnProperty('pais_id')"/>
            <Select v-model="store.data.departamento" placeholder="DEPARTAMENTO" :items="catalogos.departamentos" :fields="['id','nombre']" :error="store.errors.hasOwnProperty('departamento')"/>
            <Select v-model="store.data.municipio" placeholder="MUNICIPIO" :items="catalogos.municipios" :fields="['id','nombre']" :error="store.errors.hasOwnProperty('municipio')"/>
            <Input option="label" title="Telefono" type="number" v-model="store.data.telefono" :error="store.errors.hasOwnProperty('telefono')" autocomplete="off" />
            <Input option="label" title="Celular" type="number" v-model="store.data.celular" :error="store.errors.hasOwnProperty('celular')" autocomplete="off" />
            <Input option="label" title="Correo electronico" type="email" v-model="store.data.correo" :error="store.errors.hasOwnProperty('correo')" autocomplete="off" />
            <Select v-model="store.data.parentesco" placeholder="PARENTESCO" :items="catalogos.parentescos" :fields="['id','nombre']" :error="store.errors.hasOwnProperty('parentesco')"/>
        </div>
    </Card>
</template>