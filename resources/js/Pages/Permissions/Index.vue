<template>
    <panel-layout>
        <template #header>
            <div class="flex justify-between items-center px-4">
                <h3 class="uppercase font-semibold">Permisos</h3>
                <button class="bg-green-500 text-white py-2 px-4" @click="openRegisterPermission">Nuevo Permiso</button>
            </div>
        </template>

        <!-- Permisos -->
        <div class="container mx-auto my-4">
            <permissions-table :permissions="permissions.data" @clickPermission="openUpdatePermission"></permissions-table>
        </div>

        <!-- Modal Permission -->
        <register-permission
            :showModal="showModalPermission"
            @closeModal="closeModalPermission"
            @permissionRegistered="refreshRolesAndPermissions">
        </register-permission>

        <update-permission
            :showModal="showUpdatePermission"
            :permission="permission"
            @closeModal="closeModalPermission"
            @permissionUpdated="refreshRolesAndPermissions"
            @permissionDeleted="refreshRolesAndPermissions">
        </update-permission>
    </panel-layout>
</template>

<script>
import PanelLayout from "@/Layouts/AppLayout"
import PermissionsTable from './Tables/PermissionsTable'
import RegisterPermission from './Modals/RegisterPermission'
import UpdatePermission from './Modals/UpdatePermission'

export default {
    props: {
        permissions: Object,
    },

    components: {
        PanelLayout,
        PermissionsTable,
        RegisterPermission,
        UpdatePermission,
    },

    data() {
        return {
            // Permisos
            showModalPermission: false,
            showUpdatePermission: false,
            permission: {},
        }
    },

    methods: {
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
            this.$inertia.reload({ only: ['permissions'], preserveScroll: true })
        },
    }
}
</script>
