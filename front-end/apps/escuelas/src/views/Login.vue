<script setup>

    import { useAuthStore } from '@/stores/auth'
    import { useGlobalStore } from '@/stores/global'

    const global =  useGlobalStore()
    const auth = useAuthStore()

</script>

<template>
    <div class="h-screen flex justify-center items-center">
        <div class="border rounded-lg p-4 shadow-md">
            <form @submit.prevent="auth.login" class="flex flex-col gap-4">
                <img src="../assets/img/logo2.png" alt="Desarrollo social" class=" h-20 w-96 mx-auto">
                <Input v-model="auth.user.cui" icon="fas fa-id-card-clip" type="number" placeholder="Ingrese numero de dpi" :error="auth.errors.hasOwnProperty('cui')"/>
                <Input v-model="auth.user.password" icon="fas fa-key" type="password" placeholder="Password" :error="auth.errors.hasOwnProperty('password')"/>
                <Button type="submit" text="Acceder" icon="fas fa-right-to-bracket" class="btn-primary rounded-full" :loading="auth.loading" />
                <Validate-Errors v-if="auth.errors != 0" :errors="auth.errors" />
            </form>
            <br>
            <hr>
            <br>
            <p class="text-center text-gray-400">
                Municipalidad de Guatemala - Derechos reservados © {{ global.year.getFullYear() }}
            </p>
        </div>
    </div>
</template>