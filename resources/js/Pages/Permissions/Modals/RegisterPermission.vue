<template>
    <jet-dialog-modal :show="showModal" @close="closeModal" @before-enter="cleanForm">
        <template #title>
            <h2>Crear Permiso</h2>
        </template>
        <template #content>
            <form action="#" @submit.prevent="">
                <label class="my-3 block" for="name">Nombre</label>
                <input class="w-full" type="text" name="name" v-model="form.name">
                <p v-if="errors.name" class="text-red-600 py-2">{{ errors.name[0] }}</p>
            </form>
        </template>
        <template #footer>
            <button class="py-2 px-3 bg-green-500 text-white" @click="storePermission">Registrar</button>
        </template>
    </jet-dialog-modal>
</template>

<script>
import JetDialogModal from '@/Jetstream/DialogModal'
import Swal from 'sweetalert2'
import Axios from 'axios'

export default {
    props: ['showModal'],

    emits: ['closeModal', 'permissionRegistered'],

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

        cleanForm() {
            this.form = {}
            this.errors = {}
        },

        storePermission() {
            Axios.post('/permissions', this.form)
            .then(this.successAlert)
            .then(() => this.$emit('permissionRegistered'))
            .then(this.closeModal)
            .catch(this.errorAlert)
        },

        successAlert(response) {
            return Swal.fire({
                icon: 'success',
                title: response.data.message,
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