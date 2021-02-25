<template>
    <dialog-modal :show="show" @close="close" @before-enter="cleanForm">
        <template #title>
            Registrar permiso
        </template>
        <template #content>
            <div class="form">
                <label class="inline-block mb-3" for="concept">Concepto</label>
                <input class="w-full" type="text" name="concept" v-model="form.concept">
                <p v-if="errors.concept" class="text-red-500">{{ errors.concept[0] }}</p>

                <label class="inline-block mb-3" for="type">Cuenta</label>
                <select class="w-full" name="type" v-model="form.account_id">
                    <option value="">- Elegir -</option>
                    <option v-for="account in accounts" :key="account.id" :value="account.id">{{ account.name }}</option>
                </select>
                <p v-if="errors.account_id" class="text-red-500">{{ errors.account_id[0] }}</p>

                <label class="inline-block mb-3" for="type">Tipo</label>
                <select class="w-full" name="type" v-model="form.type">
                    <option value="">- Elegir -</option>
                    <option value="ingreso">Ingreso</option>
                    <option value="egreso">Egreso</option>
                </select>
                <p v-if="errors.type" class="text-red-500">{{ errors.type[0] }}</p>

                <div class="flex justify-between">
                    <div class="col">
                        <label class="inline-block mb-3" for="amount">Monto</label>
                        <input class="w-full" type="number" name="amount" v-model="form.amount" @keyup="applyTaxes">
                        <p v-if="errors.amount" class="text-red-500">{{ errors.amount[0] }}</p>
                    </div>

                    <div class="col">
                        <label class="inline-block mb-3" for="tax">IVA</label>
                        <input class="ml-4 p-2" type="checkbox" name="has_taxes" v-model="form.has_taxes" @change="applyTaxes">

                        <input :disabled="!form.has_taxes" class="w-full disabled:opacity-50" type="number" v-model="form.taxes">
                        <p v-if="errors.taxes" class="text-red-500">{{ errors.taxes[0] }}</p>
                    </div>
                </div>

                <label class="inline-block mb-3" for="description">Descripción</label>
                <textarea class="w-full" name="description" rows="4" v-model="form.description"></textarea>
                <p v-if="errors.description" class="text-red-500">{{ errors.description[0] }}</p>
            </div>
        </template>
        <template #footer>
            <button-primary type="button" @click="store">Registrar</button-primary>
        </template>
    </dialog-modal>
</template>

<script>
import DialogModal from '@/Jetstream/DialogModal'
import ButtonPrimary from '@/Shared/ButtonPrimary'
import Axios from 'axios'
import Swal from 'sweetalert2'

export default {
    props: ['show', 'accounts'],

    emits: ['close', 'refreshTransactions'],

    components: {
        DialogModal,
        ButtonPrimary,
    },

    data() {
        return {
            form: {
                account_id: '',
                type: '',
            },
            errors: {},
        }
    },

    methods: {
        store() {
            Axios.post('/transactions', this.form)
            .then(this.successAlert)
            .then(this.refreshTransactions)
            .then(this.close)
            .catch(this.errorAlert)
        },

        errorAlert(fail) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: fail.response.data.message
            })

            if (fail.response.status === 422) {
                this.errors = fail.response.data.errors
            }
        },

        successAlert(response) {
            Swal.fire({
                icon: 'success',
                title: response.data.message,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
            })
        },

        cleanForm() {
            this.form = {
                account_id: '',
                type: '',
            }
            this.errors = {}
        },

        calcTaxes(amount) {
             return amount * this.$page.props.taxes.iva
        },

        applyTaxes() {
            if (this.form.has_taxes) {
                this.form.taxes = this.calcTaxes(this.form.amount)
            } else {
                this.form.taxes = null
            }
        },

        close() {
            this.$emit('close')
        },

        refreshTransactions() {
            this.$emit('refreshTransactions')
        }
    }
}
</script>