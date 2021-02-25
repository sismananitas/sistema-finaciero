<template>
    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="w-full whitespace-no-wrap text-center cursor-default">
            <tr class="font-bold">
                <th class="px-6 pt-6 pb-4">ID</th>
                <th class="px-6 pt-6 pb-4">Name</th>
                <th class="px-6 pt-6 pb-4">Guard Name</th>
                <th class="px-6 pt-6 pb-4">Created At</th>
                <th class="px-6 pt-6 pb-4">Updated At</th>
            </tr>
            <tr v-for="permission in permissions" :key="permission.id"
            @click="clickPermission(permission)"
            class="hover:bg-gray-100 focus-within:bg-gray-100 cursor-pointer">
                <td class="border-t px-6 py-4 items-center">{{ permission.id }}</td>
                <td class="border-t px-6 py-4 items-center">{{ permission.name }}</td>
                <td class="border-t px-6 py-4 items-center">{{ permission.guard_name }}</td>
                <td class="border-t px-6 py-4 items-center">{{ dateFormat(permission.created_at) }}</td>
                <td class="border-t px-6 py-4 items-center">{{ dateFormat(permission.updated_at) }}</td>
            </tr>
            <tr v-if="permissions.length === 0">
                <td class="border-t px-6 py-4" colspan="11">No se encontraron Permisos</td>
            </tr>
        </table>
    </div>
</template>

<script>
export default {
    props: [ 'permissions' ],

    emits: ['clickPermission'],

    methods: {
        clickPermission(permission) {
            this.$emit('clickPermission', permission)
        },

        dateFormat(date) {
            return moment(date).format('YYYY-MM-DD hh:mm a')
        },
    }
}
</script>