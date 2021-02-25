<template>
    <jet-dialog-modal :show="showModal" max-width="3xl" @close="closeModal" @before-enter="fillForm">
        <template #title>
            <h3>{{ role.name }}</h3>
        </template>
        <template #content>
            <form action="#" @submit.prevent="">
                <label for="#">Nombre</label>
                <input class="w-full" type="text" name="name" v-model="form.name">
                <p v-if="errors.name" class="text-red-600 py-2">{{ errors.name[0] }}</p>
            </form>

            <h5 class="title mb-2">Permisos</h5>
            <div class="flex">
                <select class="w-full mr-4" name="name" v-model="permissionName">
                    <option value="">- Elegir -</option>
                    <option v-for="permission in permissions" :key="permission.id" :value="permission.name">{{ permission.name }}</option>
                </select>
                <button class="py-2 px-3 bg-blue-500 text-white w-1/3" @click="givePermission">Agregar permiso</button>
            </div>
            <p v-if="errorsPermission.name" class="text-red-600 py-2">{{ errorsPermission.name[0] }}</p>

            <ul class="my-4 flex flex-wrap">
                <li class="w-1/4 px-2 pb-2" v-for="permission in rolePermissions" :key="permission.id">
                    <div class="badge rounded-full py-3 px-6 bg-blue-600 hover:bg-blue-500 text-white cursor-pointer flex justify-between"
                        @click="revokePermission(permission)">
                        {{ permission.name }}<span class="font-bold">&times;</span>
                    </div>
                </li>

                <li v-if="rolePermissions.length < 1" class="alert alert-warning w-full">No hay permisos registrados</li>
            </ul>
        </template>
        <template #footer>
            <button class="py-2 px-3 bg-yellow-300 mr-2" @click="editRole">Actualizar</button>
            <button class="py-2 px-3 bg-red-500 text-white" @click="deleteRole">Borrar</button>
        </template>
    </jet-dialog-modal>
</template>

<script>
import Axios from 'axios'
import JetDialogModal from '@/Jetstream/DialogModal'
import Swal from 'sweetalert2'

export default {
    props: ['showModal', 'role', 'permissions', 'rolePermissions'],

    components: {
        JetDialogModal,
    },

    data() {
        return {
            form: {},
            permissionName: '',
            errors: {},
            errorsPermission: {},
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

        fillForm() {
            this.form = JSON.parse(JSON.stringify(this.role))
            this.permissionName = ''
            this.errors = {}
            this.errorsPermission = {}
        },

        editRole() {
            Swal.fire({
                icon: 'warning',
                title: 'Confirmar cambios',
                showCancelButton: true
            })
            .then(result => {
                if (result.isConfirmed) {
                    this.updateRole()
                }
            })
        },

        updateRole() {
            Axios.put('/roles/' + this.form.id, this.form)
            .then(jsonResponse => {
                this.successAlert(jsonResponse.data.message)
                this.$emit('updated')
                this.closeModal()
            })
            .catch(fail => {
                this.errors = fail.response.data.errors
            })
        },

        deleteRole() {
            Swal.fire({
                icon: 'warning',
                title: 'Confirmar eliminación',
                showCancelButton: true
            })
            .then(result => {
                if (result.isConfirmed) {
                    this.destroyRole()
                }
            })
        },

        destroyRole() {
            Axios.delete('/roles/' + this.form.id)
            .then(jsonResponse => {
                this.successAlert(jsonResponse.data.message)
                this.$emit('deleted')
                this.closeModal()
            })
            .catch(fail => {
                this.errors = fail.response.data.errors
            })
        },

        givePermission() {
            let data = { name: this.permissionName }
            Axios.post('/agregar-permiso/role/' + this.form.id, data)
            .then(jsonResponse => {
                this.successAlert(jsonResponse.data.message)
                this.refresRolePermissions()
            })
            .catch(fail => {
                this.errorsPermission = fail.response.data.errors
            })
        },

        revokePermission(permission) {
            let data = { name: permission.name }

            Swal.fire({
                icon: 'warning',
                title: '¿Revocar permiso?',
                text: 'Esta acción es irreversible',
                showCancelButton: true
            })
            .then(result => {
                if (result.isConfirmed) {
                    Axios.post('/quitar-permiso/role/' + this.form.id, data)
                    .then(jsonResponse => {
                        this.successAlert(jsonResponse.data.message)
                        this.refresRolePermissions()
                    })
                }
            })
        },

        refresRolePermissions() {
            this.$emit('refreshRolePermissions')
        },
    }
}
</script>