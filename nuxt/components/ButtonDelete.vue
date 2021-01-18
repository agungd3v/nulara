<template>
    <button
        class="px-5 py-2 rounded bg-red-600 text-white font-semibold text-xs hover:bg-red-700 focus:outline-none"
        v-on:click="deletePeople"
    >
        Delete
    </button>
</template>
<script>
export default {
    props: {
        peopleId: Number
    },
    methods: {
        async deletePeople() {
            const questionDelete = confirm('are you sure want to delete this people from your life ?')
            if (questionDelete) {
                await this.$axios.delete(`/people/people_delete/${this.peopleId}`).then((result) => {
                    if (result.data.status) {
                        return this.$emit('replacePeople', true)
                    }
                }).catch((err) => {
                    console.error(err)
                });
            }
        }
    }
}
</script>