<template>
    <jet-dialog-modal :show="showModal" @close="closeModal" @before-enter="fillForm">
        <template #title>
            <h2>{{ permission.name }}</h2>
        </template>
        <template #content>
            <form action="#" @submit.prevent="">
                <label class="my-3 block" for="name">Nombre</label>
                <input class="form-control" type="text" name="name" v-model="form.name">
                <p v-if="errors.name" class="text-red-600 py-2">{{ errors.name[0] }}</p>
            </form>
        </template>
        <template #footer>
            <button class="py-2 px-4 mr-2 bg-yellow-300" @click="editPermission">Actualizar</button>
            <button class="py-2 px-4 bg-red-500 text-white" @click="deletePermission">Borrar</button>
        </template>
    </jet-dialog-modal>
</template>

<script>
import JetDialogModal from '@/Jetstream/DialogModal'
import Swal from 'sweetalert2'
import Axios from 'axios'

export default {
    props: ['showModal', 'permission'],

    emits: ['closeModal', 'permissionUpdated', 'permissionDeleted'],

    components: {
        JetDialogModal,
    },

    data() {
        return {
            form: {},
            errors: {}
        }
    },

    methods: {
        closeModal() {
            this.$emit('closeModal')
        },

        fillForm() {
            this.form = JSON.parse(JSON.stringify(this.permission))
            this.errors = {}
        },

        editPermission() {
            Swal.fire({
                icon: 'warning',
                title: 'Confirmar cambios',
                showCancelButton: true
            })
            .then(result => {
                if (result.isConfirmed) {
                    this.updatePermission()
                }
            })
        },

        updatePermission() {
            Axios.put(`/permissions/${this.permission.id}`, this.form)
            .then(json_response => {
                this.successAlert(json_response.data.message)
                this.closeModal()
                this.$emit('permissionUpdated')
            })
            .catch(this.errorAlert)
        },

        deletePermission() {
            Swal.fire({
                icon: 'warning',
                title: 'Confirmar eliminación',
                showCancelButton: true
            })
            .then(result => {
                if (result.isConfirmed) {
                    this.destroyPermission()
                }
            })
        },

        destroyPermission() {
            Axios.delete(`/permissions/${this.permission.id}`)
            .then(jsonResponse => {
                this.successAlert(jsonResponse.data.message)
                this.closeModal()
                this.$emit('permissionDeleted')
            })
            .catch(this.errorAlert)
        },

        successAlert(message) {
            return Swal.fire({
                icon: 'success',
                title: message,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
            })
        },

        errorAlert(fail) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: fail.response.data.message
            })

            if (fail.response.status == 422) {
                this.errors = fail.response.data.errors
            }
        },
    }
}
</script>