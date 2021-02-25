<template>
    <jet-dialog-modal :show="showModal" @close="closeModal" @before-enter="cleanForm">
        <template #title>
            <h2>Registrar rol</h2>
        </template>
        <template #content>
            <form action="#" @submit.prevent="">
                <label for="#">Nombre</label>
                <input class="form-control" type="text" name="name" v-model="form.name">
                <p v-if="errors.name" class="text-red-600 py-2">{{ errors.name[0] }}</p>
            </form>
        </template>
        <template #footer>
            <button class="btn btn-primary" @click="storeRole">Registrar</button>
        </template>
    </jet-dialog-modal>
</template>

<script>
import JetDialogModal from './../../../Jetstream/DialogModal'
import Swal from 'sweetalert2'
import Axios from 'axios'

export default {
    props: [ 'showModal' ],

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

        closeModal() {
            this.$emit('closeModal')
        },

        cleanForm() {
            this.form = {}
            this.errors = {}
        },

        storeRole() {
            let data = this.form
            Axios.post('/roles', data)
            .then(jsonResponse => {
                this.successAlert(jsonResponse.data.message)
                this.closeModal()
                this.$emit('registered')
            })
            .catch(fail => {
                this.errors = fail.response.data.errors
            })
        },
    }
}
</script>