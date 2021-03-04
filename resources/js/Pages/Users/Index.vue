<template>
    <panel-layout>
        <template #header>
            <div class="flex justify-between items-center">
                <h1 class="title uppercase">Usuarios</h1>
                <button class="btn bg-green-500 text-white py-2 px-4" @click="showRegisterModal">Nuevo usuario</button>
            </div>
        </template>
        <!-- Users table -->
        <div class="container mx-auto mt-4">
            <users-table :users="users" @clickedUser="showEditModal"></users-table>
        </div>
        <!-- modal register -->
        <register-user-modal
            :showModal="registerMode"
            @closeModal="closeModals"
            @registered="refreshUsers"
        ></register-user-modal>
        <!-- modal update -->
        <update-user-modal
            :showModal="editMode" 
            :user="user"
            :roles="roles"
            :userRoles="userRoles"
            @getUserRoles="getUserRoles"
            @closeModal="closeModals"
            @updated="refreshUsers"
            @destroyed="refreshUsers"
        ></update-user-modal>
    </panel-layout>
</template>

<script>
import PanelLayout from "@/Layouts/AppLayout"
import UpdateUserModal from './Modals/UpdateUserModal.vue'
import RegisterUserModal from './Modals/RegisterUserModal.vue'
import UsersTable from "./Tables/UsersTable"
import Axios from 'axios'

export default {
    props: ["users", "roles"],

    components: {
        PanelLayout,
        UpdateUserModal,
        RegisterUserModal,
        UsersTable
    },

    data() {
        return {
            registerMode: false,
            editMode: false,
            user: {},
            userRoles: [],
        }
    },

    methods: {
        showRegisterModal() {
            this.registerMode = true
        },

        showEditModal(user) {
            this.getUserRoles(user)
            .then(() => {
                this.user = user
                this.editMode = true
            })
        },

        closeModals () {
            this.registerMode = false
            this.editMode = false
        },

        async getUserRoles(user){
            return Axios.get(`/roles-de-usuario/${user.id}`)
            .then(jsonResponse => {
                this.userRoles = jsonResponse.data.roles
            })
        },

        refreshUsers () {
            this.$inertia.reload({ only: ["users"], preserveScroll: true })
        }
    }
}
</script>