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

        <div class="py-7 container flex justify-end">
            <div class="bg-white shadow-md p-4 flex justify-between items-center md:w-1/3">
                <h3 class="text-xl font-bold inline-block">Balance</h3>
                <span :class="getBalanceClasses(balance)" class="text-2xl p-4 rounded inline-block font-bold text-white">{{ localNumber(balance) }}</span>
            </div>
        </div>

        <div class="pb-4">
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
                                <th class="p-4 border-b-2">Autor</th>
                                <th class="p-4 border-b-2 text-center">IVA</th>
                                <th class="p-4 border-b-2 text-center">Monto MXN</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="hover:bg-gray-100" v-for="transaction in transactions.data" :key="transaction.id">
                                <td class="p-4 border-b">{{ transaction.id }}</td>
                                <td class="p-4 border-b">{{ dateFormat(transaction.created_at) }}</td>
                                <td class="p-4 border-b">{{ transaction.concept }}</td>
                                <td class="p-4 border-b">{{ transaction.account.name }}</td>
                                <td class="p-4 border-b capitalize text-center">{{ transaction.type }}</td>
                                <td class="p-4 border-b capitalize">
                                    <img class="h-8 w-8 rounded-full object-cover" :src="transaction.user.profile_photo_url" :alt="transaction.user.name" />
                                </td>
                                <td class="p-4 border-b text-right">{{ localNumber(transaction.taxes) }}</td>
                                <td class="p-4 border-b text-right">
                                    <span :class="colorTransaction(transaction.type)" class="text-white p-3 rounded-full font-bold">{{ localNumber(transaction.amount) }}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <pagination-links class="shadow" :links="transactions.links"></pagination-links>
            </div>
        </div>
        <register-transaction :show="registerModal" :accounts="accounts" @close="closeRegisterModal" @refreshTransactions="refreshTransactions"></register-transaction>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Welcome from '@/Jetstream/Welcome'
    import ButtonPrimary from '@/Shared/ButtonPrimary'
    import RegisterTransaction from './Modals/RegisterTransaction'
    import PaginationLinks from '@/Shared/PaginationLinks'

    export default {
        props: [ 'transactions', 'accounts', 'balance' ],

        components: {
            AppLayout,
            Welcome,
            ButtonPrimary,
            RegisterTransaction,
            PaginationLinks,
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
                    return 'bg-green-500'
                }
                return 'bg-red-500'
            },

            dateFormat(date) {
                return moment(date).format('DD-MM-YYYY')
            },

            localNumber(number) {
                return Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(number)
            },

            getBalanceClasses(balance) {
                if (balance >= 0) {
                    return 'bg-green-500'
                }
                return 'bg-red-500'
            },

            refreshTransactions() {
                this.$inertia.reload({ only: [ 'transactions', 'balance' ] })
            }
        }
    }
</script>
