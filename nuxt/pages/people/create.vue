<template>
    <div class="w-full h-screen flex justify-center items-center">
        <div class="w-full md:w-3/4 lg:w-2/4 pl-3 pr-5">
            <ul class="flex flex-col md:flex-row pl-0">
                <li class="i-group w-full flex flex-col mx-1 mb-5">
                    <label for="firstname" class="mb-2">First Name</label>
                    <input type="text" v-model="biodata.firstName" id="firstname" class="border w-full rounded focus:outline-none focus:border-green-500 text-sm px-3 py-1">
                </li>
                <li class="i-group w-full flex flex-col mx-1 mb-5">
                    <label for="lastname" class="mb-2">Last Name</label>
                    <input type="text" v-model="biodata.lastName" id="lastname" class="border w-full rounded focus:outline-none focus:border-green-500 text-sm px-3 py-1">
                </li>
            </ul>
            <ul class="flex flex-col md:flex-row pl-0">
                <li class="i-group w-full flex flex-col mx-1 mb-5">
                    <label for="age" class="mb-2">Age</label>
                    <input type="number" v-model="biodata.age" id="age" class="border w-full rounded focus:outline-none focus:border-green-500 text-sm px-3 py-1">
                </li>
                <li class="i-group w-full flex flex-col mx-1 mb-5">
                    <label for="gender" class="mb-2">Gender</label>
                    <input type="text" v-model="biodata.gender" id="gender" class="border w-full rounded focus:outline-none focus:border-green-500 text-sm px-3 py-1">
                </li>
                <li class="i-group w-full flex flex-col mx-1 mb-5">
                    <label for="hoby" class="mb-2">Hoby</label>
                    <input type="text" v-model="biodata.hoby" id="hoby" class="border w-full rounded focus:outline-none focus:border-green-500 text-sm px-3 py-1">
                </li>
            </ul>
            <ul class="flex pl-0">
                <li class="i-group w-full">
                    <button 
                        type="button"
                        class="bg-green-500 text-white font-semibold focus:outline-none hover:bg-green-600 text-sm px-5 py-2 rounded"
                        v-on:click="submitData"
                    >
                        Submit
                    </button>
                </li>
            </ul>
        </div>
        <loader v-if="loading" />
    </div>
</template>
<script>
import Loader from '@/components/Loader'
export default {
    components: {
        Loader
    },
    middleware: 'auth',
    data() {
        return {
            biodata: {
                firstName: '',
                lastName: '',
                age: '',
                gender: '',
                hoby: ''
            },
            loading: false
        }
    },
    methods: {
        async submitData() {
            this.loading = true
            await this.$axios.post('/people/people_save', this.biodata).then((result) => {
                if (result.data.status) {
                    this.$router.push({ path: '/people' })
                }
                this.loading = false
            }).catch((err) => {
                console.error(err)
            });
        }
    }
}
</script>