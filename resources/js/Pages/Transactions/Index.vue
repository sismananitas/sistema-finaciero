<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <div class="flex items-center justify-between w-full">
                    Transacciones
                    <button-primary type="button" @click="showRegisterModal">
                        Nuevo movimiento
                    </button-primary>
                </div>
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
                    <table class="w-full text-left">
                        <thead>
                            <tr>
                                <th class="p-4 border-b-2">ID</th>
                                <th class="p-4 border-b-2">Fecha</th>
                                <th class="p-4 border-b-2">Concepto</th>
                                <th class="p-4 border-b-2">Cuenta</th>
                                <th class="p-4 border-b-2 text-center">Movimiento</th>
                                <th class="p-4 border-b-2 text-center">IVA</th>
                                <th class="p-4 border-b-2 text-center">Monto MXN</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="transaction in transactions" :key="transaction.id">
                                <td class="p-4 border-b">{{ transaction.id }}</td>
                                <td class="p-4 border-b">{{ dateFormat(transaction.created_at) }}</td>
                                <td class="p-4 border-b">{{ transaction.concept }}</td>
                                <td class="p-4 border-b">{{ transaction.account.name }}</td>
                                <td :class="colorTransaction(transaction.type)" class="p-4 border-b text-white capitalize text-center">{{ transaction.type }}</td>
                                <td class="p-4 border-b text-right">{{ localNumber(transaction.taxes) }}</td>
                                <td class="p-4 border-b text-right">{{ localNumber(transaction.amount) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <register-transaction :show="registerModal" :accounts="accounts" @close="closeRegisterModal"></register-transaction>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Welcome from '@/Jetstream/Welcome'
    import ButtonPrimary from '@/Shared/ButtonPrimary'
    import RegisterTransaction from './Modals/RegisterTransaction'

    export default {
        props: [ 'transactions', 'accounts' ],

        components: {
            AppLayout,
            Welcome,
            ButtonPrimary,
            RegisterTransaction,
        },

        data() {
            return {
                registerModal: false
            }
        },

        methods: {
            showRegisterModal() {
                this.registerModal = true
            },

            closeRegisterModal() {
                this.registerModal = false
            },

            colorTransaction(type) {
                if (type == 'ingreso') {
                    return 'bg-green-400'
                }
                return 'bg-red-500'
            },

            dateFormat(date) {
                return moment(date).format('DD-MM-YYYY')
            },

            localNumber(number) {
                return Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(number)
            }
        }
    }
</script>
