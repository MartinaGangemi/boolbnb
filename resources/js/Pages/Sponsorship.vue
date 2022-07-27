<template>
    <div class="container">
        <div class="" v-if="loading">
            Loading..
        </div>
        <div v-else>
            <div v-for="sponsor in sponsors" :key="sponsor.id">
                {{sponsor.price}}
                <a href="">buy now</a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Sponsorship",

    data(){
        return{
            loading  : true,
            sponsors : [],
        }
    },

    async mounted(){
        this.loading = true
        const response = await axios.get('/api/sponsorship')
        this.sponsors = response.data.data
        this.loading = false
    }
}
</script>

<style lang="scss" scoped>

</style>