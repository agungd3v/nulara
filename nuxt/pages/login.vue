<template>
    <div class="w-full h-screen flex justify-center items-center">
        <div class="w-full md:w-2/4 lg:w-1/4 px-5">
            <div class="i-group flex flex-col mb-5">
                <label for="email" class="mb-2">Email</label>
                <input type="text" id="email" v-model="email" class="border rounded focus:outline-none focus:border-green-500 text-sm px-3 py-1">
            </div>
            <div class="i-group flex flex-col mb-5">
                <label for="password" class="mb-2">Password</label>
                <input type="password" id="password" v-model="password" class="border rounded focus:outline-none focus:border-green-500 text-sm px-3 py-1">
            </div>
            <div class="i-group flex items-center">
                <button 
                    type="button"
                    class="bg-green-500 text-white font-semibold focus:outline-none hover:bg-green-600 text-sm px-5 py-1 rounded"
                    v-on:click="login"
                    :class="loading ? 'pointer-events-none cursor-not-allowed bg-green-400' : 'pointer-events-auto cursor-pointer'"
                >
                    Login
                </button>
                <nuxt-link
                    to="/register"
                    class="text-green-500 ml-2 text-green-500 font-semibold focus:outline-none hover:text-green-600 text-sm"
                >
                    Register
                </nuxt-link>
            </div>
        </div>
        <loader v-if="loading" />
    </div>
</template>
<script>
import { mapGetters } from 'vuex'
import * as Cookies from 'js-cookie'
import Loader from '@/components/Loader'
export default {
    components: {
        Loader
    },
    middleware: 'hasauth',
    data() {
        return {
            email: '',
            password: '',
            loading: false
        }
    },
    computed:{
        ...mapGetters({
            token: 'auth/token',
            error: 'auth/error'
        })
    },
    watch:{
        token(newValue, oldValue){
            if(newValue) {
                const lastUrl = Cookies.get('last_url')
                this.$router.push(lastUrl)
            }
        },

        error() {}
    },
    methods: {
        async login() {
            this.loading = true
            if(this.email == '' || this.password == '') return
            this.$store.dispatch('auth/LOGIN', { email: this.email, password: this.password, web: true})
            this.loading = false
        }
    }
}
</script>