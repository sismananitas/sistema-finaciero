<template>
    <div class="bg-white rounded shadow overflow-x-auto cursor-default">
        <table class="w-full whitespace-no-wrap">
            <tr class="text-left font-bold">
                <th class="px-6 pt-6 pb-4">ID</th>
                <th class="px-6 pt-6 pb-4">Nombre</th>
                <th class="px-6 pt-6 pb-4">E-mail</th>
                <th class="px-6 pt-6 pb-4">Registro</th>
            </tr>
            <tr v-for="(user, key) in users" :key="key" @click="showEditUser(user)" class="hover:bg-gray-100">
                <td class="border-t px-6 py-4 items-center">{{ user.id }}</td>
                <td class="border-t px-6 py-4 items-center">{{ user.name }}</td>
                <td class="border-t px-6 py-4 items-center">{{ user.email }}</td>
                <td class="border-t px-6 py-4 items-center">{{ dateFormat(user.created_at) }}</td>
            </tr>
        </table>
    </div>
</template>
<script>
export default {
    props: ["users"],

    emits: ['clickedUser'],
    
    methods: {
        showEditUser(user){
            this.$emit("clickedUser", user)   
        },
        dateFormat() {
            //
        },
    }
}
</script>