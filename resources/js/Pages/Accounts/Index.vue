<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <div class="flex items-center justify-between">
                    Cuentas
                    <button-primary type="button" @click="showRegisterAccount">Registrar cuenta</button-primary>
                </div>
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <table class="w-full text-left">
                        <thead>
                            <tr>
                                <th class="p-4 border-b-2">ID</th>
                                <th class="p-4 border-b-2">Nombre</th>
                                <th class="p-4 border-b-2">Número</th>
                                <th class="p-4 border-b-2">Titular</th>
                                <th class="p-4 border-b-2">Tipo</th>
                                <th class="p-4 border-b-2">Balance</th>
                            </tr>
                        </thead>
                        <tbody v-for="account in accounts" :key="account.id">
                            <tr>
                                <td class="p-4 border-b">{{ account.id }}</td>
                                <td class="p-4 border-b">{{ account.name }}</td>
                                <td class="p-4 border-b">{{ account.number }}</td>
                                <td class="p-4 border-b">{{ account.holder }}</td>
                                <td class="p-4 border-b">{{ account.type }}</td>
                                <td class="p-4 border-b">{{ account.balance }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <register-account-modal :show="registerAccount" @close="closeRegisterAccount"></register-account-modal>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import ButtonPrimary from '@/Shared/ButtonPrimary'
import RegisterAccountModal from './Modals/RegisterAccountModal'

export default {
    props: [ 'accounts' ],

    components: {
        AppLayout,
        ButtonPrimary,
        RegisterAccountModal,
    },

    data() {
        return {
            registerAccount: false,
        }
    },

    methods: {
        showRegisterAccount() {
            this.registerAccount = true
        },

        closeRegisterAccount() {
            this.registerAccount = false
        }
    }
}
</script>
