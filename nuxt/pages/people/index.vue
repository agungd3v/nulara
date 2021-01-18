<template>
    <div class="w-full h-screen flex justify-center items-center">
        <table>
            <thead>
                <tr>
                    <td colspan="6" class="px-1">
                        <nuxt-link
                            to="/people/create"
                            class="px-5 py-2 rounded bg-blue-600 text-white font-semibold text-xs hover:bg-blue-700 focus:outline-none"
                        >
                            Create People
                        </nuxt-link>
                    </td>
                </tr>
                <tr>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Hoby</th>
                    <th class="bg-gray-300"></th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="(people, index) in peoples"
                    :key="index"
                >
                    <td>{{ people.first_name }}</td>
                    <td>{{ people.last_name }}</td>
                    <td>{{ people.age }}</td>
                    <td>{{ people.gender }}</td>
                    <td>{{ people.hoby }}</td>
                    <td>
                        <nuxt-link
                            :to="`/people/${people.id}`"
                            class="px-5 py-2 rounded bg-green-600 text-white font-semibold text-xs hover:bg-green-700 focus:outline-none"
                        >Update</nuxt-link>
                        <button-delete :peopleId="people.id" @replacePeople="getPeople"></button-delete>
                    </td>
                </tr>
            </tbody>
        </table>
        <loader v-if="loading" />
    </div>
</template>
<script>
import ButtonDelete from '@/components/ButtonDelete'
import Loader from '@/components/Loader'
export default {
    components: {
        ButtonDelete,
        Loader
    },
    middleware: 'auth',
    data() {
        return {
            peoples: [],
            loading: false
        }
    },
    mounted() {
        this.getPeople()
    },
    methods: {
        async getPeople() {
            this.loading = true
            await this.$axios.get('/people').then((result) => {
                if (result.data.status) {
                    this.peoples = result.data.data
                }
                this.loading = false
            }).catch((err) => {
                console.error(err)
            })
        }
    }
}
</script>
<style lang="css">
    table, tr, th, td {
        border: 1px solid #e4e4e4;
    }
    th, td {
        padding: 10px 15px;
        font-size: 14px;
    }
</style>