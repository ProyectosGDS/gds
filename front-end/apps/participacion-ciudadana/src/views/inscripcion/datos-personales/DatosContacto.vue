<script setup>
    import { useInscripcionStore } from '@/stores/inscripcion'
    import { watchEffect } from 'vue'

    const store = useInscripcionStore()
    
    watchEffect(() => {
        store.changePais()
        store.changeDepartamento()
    })

    async function checkField(fieldname) {
        const ids_direcciones = store.camposRegistro.filter(item => item.categoria =='datos contacto')
        const result = ids_direcciones.find(item => item.campo == fieldname)
        return result.di_direcciones.includes(store.datos.di_direccion_id)
    }


    
</script>

<template>
    <details :open="true" class="border p-4 rounded-lg border-violet-400">
        <summary>DATOS DE CONTACTO </summary>
        <br>
        <div class="grid xl:flex gap-4">
            <div v-if="checkField('celular')" class="grow">
                <span class="uppercase">Celular</span>
                <input v-model="store.datos.celular" type="number" maxlength="8" minlength="8" class="input focus:outline-none" :class="{'border-red-400':store.errors.hasOwnProperty('celular')}" >
            </div>
            <div v-if="checkField('correo')" class="grow">
                <span class="uppercase">correo electrónico</span>
                <input v-model="store.datos.correo" type="email" class="input focus:outline-none" :class="{'border-red-400':store.errors.hasOwnProperty('correo')}" >
            </div>
            <div v-if="checkField('telefono')" class="grow">
                <span class="uppercase">teléfono</span>
                <input v-model="store.datos.telefono" type="number" maxlength="8" minlength="8" class="input focus:outline-none" :class="{'border-red-400':store.errors.hasOwnProperty('telefono')}" >
            </div>
        </div>
        <div class="grid xl:flex gap-4">
            <div v-if="checkField('facebook')" class="grow">
                <span class="uppercase">facebook</span>
                <input v-model="store.datos.facebook" type="text" class="input focus:outline-none" :class="{'border-red-400':store.errors.hasOwnProperty('facebook')}" >
            </div>
            <div v-if="checkField('tiktok')" class="grow">
                <span class="uppercase">tiktok</span>
                <input v-model="store.datos.tiktok" type="text" class="input focus:outline-none" :class="{'border-red-400':store.errors.hasOwnProperty('tiktok')}" >
            </div>
            <div v-if="checkField('instagram')" class="grow">
                <span class="uppercase">instagram</span>
                <input v-model="store.datos.instagram" type="text" class="input focus:outline-none" :class="{'border-red-400':store.errors.hasOwnProperty('instagram')}" >
            </div>
        </div>
    </details>
</template>