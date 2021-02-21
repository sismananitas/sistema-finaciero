<template>
    <dialog-modal :show="show" @close="close">
        <template #title>
            Registrar movimiento
        </template>
        <template #content>
            <div class="form">
                <label for="concept">Concepto</label>
                <input class="w-full" type="text" name="concept" v-model="form.concept">
                <p v-if="errors.concept" class="text-red-500">{{ errors.concept[0] }}</p>

                <label for="type">Cuenta</label>
                <select class="w-full" name="type" v-model="form.account_id">
                    <option value="">- Elegir -</option>
                    <option v-for="account in accounts" :key="account.id" :value="account.id">{{ account.name }}</option>
                </select>
                <p v-if="errors.account_id" class="text-red-500">{{ errors.account_id[0] }}</p>

                <label for="type">Tipo</label>
                <select class="w-full" name="type" v-model="form.type">
                    <option value="">- Elegir -</option>
                    <option value="ingreso">Ingreso</option>
                    <option value="egreso">Egreso</option>
                </select>
                <p v-if="errors.type" class="text-red-500">{{ errors.type[0] }}</p>

                <label for="amount">Monto</label>
                <input class="w-full" type="text" name="amount" v-model="form.amount">
                <p v-if="errors.amount" class="text-red-500">{{ errors.amount[0] }}</p>

                <label for="tax">IVA</label>
                <input class="w-full" type="number" v-model="form.has_taxes">
                <p v-if="errors.has_taxes" class="text-red-500">{{ errors.has_taxes[0] }}</p>

                <label for="description">Descripción</label>
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
        close() {
            this.$emit('close')
        },

        store() {
            Axios.post('/transactions', this.form)
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
        }
    }
}
</script>