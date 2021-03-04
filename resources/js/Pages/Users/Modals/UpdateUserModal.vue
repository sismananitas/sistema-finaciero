<template>
    <jet-dialog-modal :show="showModal" @close="closeModal" @before-enter="fillData">
        <template #content>
            <form action="#" ref="fromNewUserEl" @submit.prevent="">
                <label for="name">Nombre</label>
                <input type="text" class="w-full" name="name" v-model="form.name" >
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
                <!-- Role manager -->
                <div>
                    <div class="flex">
                        <select class="w-full mr-4" name="name" v-model="roleName">
                            <option value="">- Elegir -</option>
                            <option v-for="role in roles" :key="role.id" :value="role.name">{{ role.name }}</option>
                        </select>
                        <button class="btn btn-primary w-1/3" @click="assignRole">Asignar rol</button>
                    </div>
                    <p v-if="errorsRole.name" class="text-red-600 py-2">{{ errorsRole.name[0] }}</p>
                </div>
                <h4 class="title">Roles</h4>
                <br>
                <div class="roles flex flex-wrap">
                    <div class="w-1/4 px-2 pb-2" v-for="role in userRoles" :key="role.id">
                        <button
                            class="badge rounded-full py-3 px-4 bg-blue-600 hover:bg-blue-500 text-white cursor-pointer flex justify-between"
                            @click="removeRole(role)">
                            {{ role.name }} <span class="bold">&times;</span>
                        </button>
                    </div>
                </div>
                <div v-if="userRoles.length < 1" class="p-4 bg-yellow-300">
                    No tiene roles registrados
                </div>
                <!-- End Role manager -->
            </form>
        </template>
        <template #footer>
            <button class="py-2 px-4 bg-yellow-300 mr-2" @click="editUser">Actualizar</button>
            <button class="py-2 px-4 bg-red-500 text-white" @click="deleteUser">Eliminar</button>
        </template>
    </jet-dialog-modal>
</template>

<script>
import Swal from 'sweetalert2'
import JetDialogModal from "@/Jetstream/DialogModal"
import Axios from 'axios'

export default {
    props: ["showModal", "user", "roles", "userRoles"],

    emits: ['updated', 'destroyed', 'closeModal', 'getUserRoles'],

    components: {
        JetDialogModal
    },

    data() {
        return {
            form: {},
            errors: {},
            roleName: "",
            errorsRole: {},
        }
    },
    methods: {
        editUser() {
            this.warningAlert()
            .then(result => {
                if (result.isConfirmed) {
                    this.updateUser()
                }
            })
        },

        deleteUser() {
            this.warningAlert()
            .then(result => {
                if (result.isConfirmed) {
                    this.destroyUser()
                }
            })
        },

        updateUser() {
            Axios.put(`/users/${this.user.id}`, this.form)
            .then(this.successAlert)
            .then(() => this.$emit("updated"))
            .then(this.closeModal)
            .catch(this.errorAlert)
        },

        destroyUser() {
            Axios.delete(`/users/${this.user.id}`)
            .then(this.successAlert)
            .then(() => this.$emit("destroyed"))
            .then(this.closeModal)
            .catch(this.errorAlert)
        },

        assignRole() {
            Axios.post(`/role-usuario/${this.user.id}`, { name: this.roleName })
            .then(this.successAlert)
            .then(this.getUserRoles)
            .catch(this.errorRoleAlert)
        },

        removeRole(role) {
            this.warningAlert()
            .then(result => {
                if (result.isConfirmed) {
                    Axios.put(`/role-usuario/${this.user.id}`, { name: role.name })
                    .then(this.successAlert)
                    .then(this.getUserRoles)
                }
            })
        },

        successAlert(response) {
            Swal.fire({
                icon: 'success',
                title: response.data.message,
                toast: true,
                showConfirmButton: false,
                timer: 2000,
                position: 'top-end'
            })
        },

        warningAlert() {
            return Swal.fire({
                icon: "warning",
                title: "Atención",
                text: 'Esta acción es irreversible',
                showCancelButton: true,
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

        errorRoleAlert(fail) {
            Swal.fire({
                icon: 'error',
                title: fail.response.data.message,
                html: `<p>${fail.response.data.errors.name[0]}</p>`,    
            })
        },

        getUserRoles(){
            this.$emit('getUserRoles', this.user)
        },

        closeModal() {
            this.$emit('closeModal')
        },

        fillData() {
            this.form = JSON.parse(JSON.stringify(this.user));
            this.roleName = ''
            this.error = {}
            this.errorsRole = {}
        }
    }
}
</script>