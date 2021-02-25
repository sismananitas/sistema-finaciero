<template>
    <panel-layout>
        <template #header>
            <div class="flex justify-between items-center px-4">
                <h3 class="title uppercase">Roles</h3>
                <button class="bg-green-500 text-white py-2 px-4" @click="openRoleModal">Nuevo Rol</button>
            </div>
        </template>
        <div class="container mx-auto my-4">
            <!-- Roles -->
            <roles-table :roles="roles.data" @clickRole="openUpdateRole"></roles-table>
        </div>

        <!-- Modal Role -->
        <register-role-modal
            :showModal="showRegisterRole"
            @closeModal="closeModalRole"
            @registered="refreshRolesAndPermissions">
        </register-role-modal>

        <update-role-modal
            :showModal="showUpdateRole"
            :role="role"
            :permissions="permissions"
            :rolePermissions="rolePermissions"
            @refreshRolePermissions="refreshRolePermissions"
            @closeModal="closeModalRole"
            @updated="refreshRolesAndPermissions"
            @deleted="refreshRolesAndPermissions">
        </update-role-modal>
    </panel-layout>
</template>

<script>
import PanelLayout from "@/Layouts/AppLayout"
import RolesTable from './Tables/RolesTable'
import RegisterRoleModal from './Modals/RegisterRoleModal'
import UpdateRoleModal from './Modals/UpdateRoleModal'
import Axios from "axios"

export default {
    props: ['roles', 'permissions'],

    components: {
        PanelLayout,
        RolesTable,
        RegisterRoleModal,
        UpdateRoleModal,
    },

    data() {
        return {
            // Roles
            showRegisterRole: false,
            showUpdateRole: false,
            role: {},
            rolePermissions: [],
            
            // Permisos
            showModalPermission: false,
            showUpdatePermission: false,
            permission: {},
        }
    },

    methods: {
        // Roles
        openRoleModal() {
            this.showRegisterRole = true
        },

        openUpdateRole(role) {
            this.role = role
            this.rolePermissions = []
            this.refreshRolePermissions()
            .then(() => {
                this.showUpdateRole = true
            })
        },

        closeModalRole() {
            this.showRegisterRole = false
            this.showUpdateRole = false
        },

        refreshRolePermissions() {
            return Axios.get('/roles/' + this.role.id)
            .then(jsonResponse => {
                this.rolePermissions = JSON.parse(JSON.stringify(jsonResponse.data.role.permissions))
            })
        },

        // Permisos
        openRegisterPermission() {
            this.showModalPermission = true
        },

        openUpdatePermission(permission) {
            this.showUpdatePermission = true
            this.permission = permission
        },

        closeModalPermission() {
            this.showModalPermission = false
            this.showUpdatePermission = false
        },

        refreshRolesAndPermissions() {
            this.$inertia.reload({ only: ['roles', 'permissions'], preserveScroll: true })
        },
    }
}
</script>
