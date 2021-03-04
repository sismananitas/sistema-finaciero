<template>
    <jet-dialog-modal :show="showModal" @close="closeModal" @before-enter="cleanData">
        <template #content>
            <div>
                <label for="name">Nombre</label>
                <input type="text" class="w-full" name="name" v-model="form.name">
                <p class="text-red-600" v-if="errors.name">{{ errors.name[0] }}</p>

                <label for="name">E-mail</label>
                <input type="email" class="w-full" name="email" v-model="form.email">
                <p class="text-red-600" v-if="errors.email">{{ errors.email[0] }}</p>

                <div class="flex justify-between mb-2">
                    <div class="w-1/2 pr-3">
                        <label for="name">Contraseña</label>
                        <input type="password" class="w-full" name="password" v-model="form.password">
                        <p class="text-red-600" v-if="errors.password">{{ errors.password[0] }}</p>
                    </div>
                    <div class="w-1/2">
                        <label for="name">Contraseña</label>
                        <input type="password" class="w-full" name="password_confirmation" v-model="form.password_confirmation">
                        <p class="text-red-600" v-if="errors.password_confirmation">{{ errors.password_confirmation[0] }}</p>
                    </div>
                </div>
            </div>
        </template>
        <template #footer>
            <button class="py-2 px-4 bg-green-500 text-white" @click="storeUser">Registrar</button>
        </template>
    </jet-dialog-modal>
</template>
<script>
import Axios from 'axios'
import JetDialogModal from "@/Jetstream/DialogModal"
import Swal from 'sweetalert2'

export default {
    props: ["showModal"],

    emits: ['registered', 'closeModal'],

    components: {
        JetDialogModal
    },

    data() {
        return {
            form: {},
            roleName: "",
            errors: {},
        }
    },

    methods: {
        storeUser() {
            Axios.post("/usuarios", this.form)
            .then(this.successAlert)
            .then(() => this.$emit("registered"))
            .then(this.closeModal)
            .catch(this.errorAlert)
        },

        successAlert(response) {
            Swal.fire({
                icon: 'success',
                title: response.data.message,
                position: 'top-right',
                timer: 2000,
                toast: true,
            })
        },

        errorAlert(fail) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: fail.response.data.message,
            })
            if (fail.response.status === 422) {
                this.errors = fail.response.data.errors
            }
        },

        closeModal() {
            this.$emit("closeModal")
        },

        cleanData() {
            this.form = {}
            this.roleName = ""
            this.errors = {}
        },
    }  
}
</script>
