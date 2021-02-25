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
            <tr class="hover:bg-gray-100 focus-within:bg-gray-100 cursor-pointer"
                v-for="role in roles" :key="role.id"
                @click="clickRole(role)">
                <td class="border-t px-6 py-4 items-center">{{ role.id }}</td>
                <td class="border-t px-6 py-4 items-center">{{ role.name }}</td>
                <td class="border-t px-6 py-4 items-center">{{ role.guard_name }}</td>
                <td class="border-t px-6 py-4 items-center">{{ dateFormat(role.created_at) }}</td>
                <td class="border-t px-6 py-4 items-center">{{ dateFormat(role.updated_at) }}</td>
            </tr>
            <tr v-if="roles.length === 0">
                <td class="border-t px-6 py-4" colspan="11">No se encontraron Roles.</td>
            </tr>
        </table>
    </div>
</template>

<script>
export default {
    props: ['roles'],

    methods: {
        clickRole(role) {
            this.$emit('clickRole', role)
        },

        dateFormat(date) {
            return moment(date).format('YYYY-MM-DD hh:mm a')
        },
    }
}
</script>