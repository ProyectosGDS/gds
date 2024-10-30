<script setup>
    import { useRegisterStore } from '../stores/register'
    import { onMounted } from 'vue'

    const store = useRegisterStore()

    onMounted(() => {

        store.fetchDirecciones()
        store.fetchEtnias()

    })
    
</script>

<template>
    <main class="h-screen container mx-auto pt-8">
        <Card class="bg-white p-8 w-">
            <form @submit.prevent="store.store()" >
                <header class="flex items-center gap-4">
                    <img src="../assets/img/logo.png" alt="Gerencia de Desarrollo Social" class="h-20 w-auto">
                    <h1 class="text-2xl font-semibold">Gerencia de Desarrollo Social</h1>
                </header>
                <br>
                <div>
                    <fieldset class="border rounded-lg p-4 grid grid-cols-2 gap-4">
                        
                        <legend class="text-xl">Datos generales</legend>
                        
                        <Select placeholder="SELECCIONE DIRECCION" v-model="store.empleado.di_direccion_id" :items="store.direcciones" :fields="['id','nombre']" :error="store.errors.hasOwnProperty('di_direccion_id')" />
                        <Input option="label" title="cui" type="number" maxlength="13" minlength="13" v-model="store.empleado.cui" :error="store.errors.hasOwnProperty('cui')" required />
                        
                        <Input option="label" title="Primer nombre" type="text" v-model="store.empleado.primer_nombre" :error="store.errors.hasOwnProperty('primer_nombre')" required />
                        <Input option="label" title="Segundo nombre" type="text" v-model="store.empleado.segundo_nombre" :error="store.errors.hasOwnProperty('segundo_nombre')" required />
                        <Input option="label" title="Primer apellido" type="text" v-model="store.empleado.primer_apellido" :error="store.errors.hasOwnProperty('primer_apellido')" required />
                        <Input option="label" title="Segundo apellido" type="text" v-model="store.empleado.segundo_apellido" :error="store.errors.hasOwnProperty('segundo_apellido')" required />
                        <Input option="label" title="fecha nacimiento" type="date" v-model="store.empleado.fecha_nacimiento" :error="store.errors.hasOwnProperty('fecha_nacimiento')" required />
                        <Select placeholder="SELECCIONE ETNIA" :items="store.etnias" v-model="store.empleado.grupo_etnico_id" :fields="['id','nombre']" :erros="store.errors.hasOwnProperty('grupo_etnico_id')" />
                        <Input option="label" title="Password" type="password" v-model="store.empleado.password" :error="store.errors.hasOwnProperty('password')" required />
                        <Input option="label" title="Confirmar Password" type="password" v-model="store.empleado.password_confirmation" required />
                        <fieldset class="flex col-span-2 items-center gap-4 justify-center border border-violet-400 p-4 rounded-lg">
                            <legend class="text-violet-400 px-3">SEXO</legend>
                            <Icon icon="fas fa-person" class="text-4xl text-blue-500" />
                            <Switch :values="['h','m']" v-model="store.empleado.sexo" class="h-7 bg-pink-500 has-[:checked]:bg-blue-500" />
                            <Icon icon="fas fa-person-dress" class="text-4xl text-pink-500" />
                        </fieldset>
                    </fieldset>
                    <Validate-Errors v-if="store.errors != 0" :errors="store.errors"  />
                </div>
                <br>
                <Button type="submit" text="Guardar" icon="fas fa-save" class="btn-primary rounded-full" />
            </form>
            {{ store.empleado }}
        </Card>
    </main>
</template>