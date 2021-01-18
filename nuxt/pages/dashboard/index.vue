<template>
    <div class="w-full h-screen flex justify-center items-center">
        <div class="">
            <ul class="flex gap-5 justify-center mb-5">
                <li>
                    <small>Name</small>
                    <p>{{ user.name }}</p>
                </li>
                <li>
                    <small>Email</small>
                    <p>{{ user.email }}</p>
                </li>
            </ul>
            <ul class="flex justify-between items-center">
                <li>
                    <nuxt-link
                        to="/people"
                        class="px-5 py-2 rounded bg-blue-600 text-white font-semibold text-sm hover:bg-blue-700 focus:outline-none"
                    >
                        Manage People
                    </nuxt-link>
                </li>
                <li>
                    <nuxt-link
                        to=""
                        class="px-5 py-2 rounded bg-red-600 text-white font-semibold text-sm hover:bg-red-700 focus:outline-none"
                    >
                        Logout Account
                    </nuxt-link>
                </li>
            </ul>
        </div>
    </div>
</template>
<script>
import { mapGetters } from 'vuex'
export default {
    middleware: 'auth',
    data() {
        return {
            user: {
                name: '',
                email: ''
            }
        }
    },
    mounted() {
        this.getUser()
    },
    methods: {
        async getUser() {
            await this.$axios.get('/jwt/get_user').then((result) => {
                if (result.data.status) {
                    this.user.name = result.data.user.name
                    this.user.email = result.data.user.email
                }
            }).catch((err) => {
                console.error(err)
            })
        }
    }
}
</script>