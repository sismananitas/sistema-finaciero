<template>
    <dialog-modal :show="show" @close="close" @before-enter="fillForm">
        <template #title>
            {{ form.name }}
        </template>
        <template #content>
            <div class="form">
                <label for="concept">Nombre</label>
                <input class="w-full" type="text" name="name" v-model="form.name">
                <p v-if="errors.name" class="text-red-500">{{ errors.name[0] }}</p>
                
                <label for="amount">Número</label>
                <input class="w-full" type="number" name="amount" v-model="form.number">
                <p v-if="errors.number" class="text-red-500">{{ errors.number[0] }}</p>

                <label for="type">Tipo</label>
                <select class="w-full" name="type" v-model="form.type">
                    <option value="">- Elegir -</option>
                    <option value="corriente">Corriente</option>
                    <option value="ahorro">Ahorro</option>
                </select>
                <p v-if="errors.type" class="text-red-500">{{ errors.type[0] }}</p>

                <label for="holder">Titular</label>
                <input class="w-full" type="text" v-model="form.holder">
                <p v-if="errors.holder" class="text-red-500">{{ errors.holder[0] }}</p>

                <label for="description">Descripción</label>
                <textarea class="w-full" name="description" rows="4" v-model="form.description"></textarea>
                <p v-if="errors.description" class="text-red-500">{{ errors.description[0] }}</p>
            </div>
        </template>
        <template #footer>
            <button-warning type="button" @click="edit">Actualizar</button-warning>
            <button-danger class="ml-2" type="button" @click="del">Eliminar</button-danger>
        </template>
    </dialog-modal>
</template>

<script>
import DialogModal from '@/Jetstream/DialogModal'
import ButtonWarning from '@/Shared/ButtonWarning'
import ButtonDanger from '@/Shared/ButtonDanger'
import Axios from 'axios'
import Swal from 'sweetalert2'

export default {
    props: ['show', 'account'],

    emits: ['close', 'refreshAccounts'],

    components: {
        DialogModal,
        ButtonWarning,
        ButtonDanger,
    },

    data() {
        return {
            form: {},
            errors: {},
        }
    },

    methods: {
        close() {
            this.$emit('close')
        },

        fillForm() {
            this.form = JSON.parse(JSON.stringify(this.account))
            this.errors = {}
        },

        edit() {
            Swal.fire({
                icon: 'warning',
                title: 'Precaución',
                text: 'Esta acción es irrebersible',
                showCancelButton: true,
            })
            .then(result => {
                if (result.isConfirmed) {
                    this.update()
                }
            })
        },

        del() {
            Swal.fire({
                icon: 'warning',
                title: 'Precaución',
                text: 'Esta acción es irrebersible',
                showCancelButton: true,
            })
            .then(result => {
                if (result.isConfirmed) {
                    this.destroy()
                }
            })
        },

        update() {
            Axios.put(`/accounts/${this.form.id}`, this.form)
            .then(this.successAlert)
            .then(this.refreshAccounts)
            .then(this.close)
            .catch(this.errorAlert)
        },

        destroy() {
            Axios.delete(`/accounts/${this.form.id}`)
            .then(this.successAlert)
            .then(this.refreshAccounts)
            .then(this.close)
            .catch(this.errorAlert)
        },

        refreshAccounts() {
            this.$emit('refreshAccounts')
        },

        successAlert(response) {
            Swal.fire({
                icon: 'success',
                title: response.data.message,
                position: 'top-right',
                toast: true,
                timer: 2000,
                showConfirmButton: false,
            })
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