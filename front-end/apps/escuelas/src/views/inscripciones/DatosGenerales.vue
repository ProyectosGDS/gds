<script setup>
    import { useInscripcionesStore } from '@/stores/inscripciones/inscripciones'
    import Switch from '@/components/Switch.vue';
    import SelectSearch from '@/components/SelectSearch.vue'
    import { onMounted } from 'vue';
    import { useAuthStore } from '@/stores/auth'

    const auth = useAuthStore()


    const store = useInscripcionesStore()



    onMounted(() => {
        store.fetchEtnias()
        store.fetchDepartamentos()
        store.fetchMunicipios()
        store.fetchZonas()
        store.fetchGruposHabitacionales()
    })

</script>
<template>
    {{  }}
    <h1 class="text-gray-500 text-2xl font-semibold text-center">Datos generales</h1>
    <br>
    <div>
        <div class="grid gap-3">
            <Input option="label" v-model="store.datos.cui" title="CUI" :error="store.errors.hasOwnProperty('cui')" />
            <fieldset v-if="!auth.permisos.includes('Inscripciones')" class="grid md:grid-cols-2 xl:grid-cols-3 gap-3 border p-4 rounded">
                <legend class="px-4 font-bold text-violet-500 uppercase">Nombres</legend>
                <Input option="label" v-model="store.datos.primer_nombre" title="primer" :error="store.errors.hasOwnProperty('primer_nombre')" required />
                <Input option="label" v-model="store.datos.segundo_nombre" title="segundo" />
                <Input option="label" v-model="store.datos.tercer_nombre" title="tercer"/>
            </fieldset>
            <fieldset class="grid md:grid-cols-2 xl:grid-cols-3 gap-3 border p-4 rounded">
                <legend class="px-4 font-bold text-violet-500 uppercase">Apellidos</legend>
                <Input option="label" v-model="store.datos.primer_apellido" title="primer" :error="store.errors.hasOwnProperty('primer_apellido')" required />
                <Input option="label" v-model="store.datos.segundo_apellido" title="segundo" />
                <Input option="label" v-model="store.datos.apellido_casada" title="apellido casada"/>
            </fieldset>
            <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-3"> 
                <Input option="label" type="date" v-model="store.datos.fecha_nacimiento" title="fecha de nacimiento" :error="store.errors.hasOwnProperty('fecha_nacimiento')" required />
                <div class="flex gap-x-3 justify-center items-center">
                    <Icon icon="fas fa-person-dress" class="text-4xl text-pink-400"/>
                    <Switch :values="['m','h']" class="h-6 bg-blue-500 has-[:checked]:bg-pink-400" v-model="store.datos.sexo" />
                    <Icon icon="fas fa-person" class="text-4xl text-blue-500"/>
                </div>
                <!-- <SelectSearch v-model="store.datos.estado_civil" title="ESTADO CIVIL" :error="store.errors.hasOwnProperty('estado_civil')" required /> -->
            </div>
            <div v-if="store.catalogos.etnias.length > 0" class="grid md:grid-cols-2 xl:grid-cols-3 gap-3"> 
                <Input option="label" type="tel" pattern="[0-9]{4}-[0-9]{4}" required v-model="store.datos.celular" title="No de celular" :error="store.errors.hasOwnProperty('celular')" />
                <Input option="label" type="email" required v-model="store.datos.correo" title="Correo electronico" :error="store.errors.hasOwnProperty('correo')" />
                <SelectSearch v-model="store.datos.etnia_id" :items="store.catalogos.etnias" :fields="['id','nombre']" title="etnia" :error="store.errors.hasOwnProperty('etnia_id')" required />
            </div>
            <fieldset v-if="store.catalogos.departamentos.length > 0" class="grid md:grid-cols-2 xl:grid-cols-3 gap-3 border p-4 rounded">
                <legend class="px-4 font-bold text-violet-500 uppercase">direccion domiciliar</legend>
                <SelectSearch v-model="store.datos.departamento_id" title="departamento" :items="store.catalogos.departamentos" :fields="['id','nombre']" :error="store.errors.hasOwnProperty('departamento_id')"  />
                <SelectSearch v-model="store.datos.municipio_id" title="municipio" :items="store.catalogos.municipios" :fields="['id','nombre']" :error="store.errors.hasOwnProperty('municipio_id')"  />
                <SelectSearch v-model="store.datos.zona_id" title="zona" :items="store.catalogos.zonas" :fields="['id','numero']" format="'Zona '+item.numero" :error="store.errors.hasOwnProperty('zona_id')"  />
                <SelectSearch v-model="store.datos.grupo_habitacional_id" title="Grupo habitacional" :items="store.catalogos.gruposHabitacionales" :fields="['id','nombre']" :error="store.errors.hasOwnProperty('grupo_habitacional_id')"  />
                <Input  option="label" v-model="store.datos.nombre_grupo_habitacional" title="nombre grupo habitacional" :error="store.errors.hasOwnProperty('nombre_grupo_habitacional')" />
                <Input  option="label" v-model="store.datos.direccion" title="Direccion" :error="store.errors.hasOwnProperty('direccion')" />                
            </fieldset>
        </div>
    </div>
</template>

