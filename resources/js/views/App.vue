
<template>
<div>
    
    <main>
         <router-view></router-view>
    </main>
    

</div>

</template>


<script>
export default {
    name: 'App',
    data(){
        return{
            apartments:'',
            apartmentsResponse:'',

            menu_items: [
                {
                    route_name: 'home',
                    route_text: 'Home'
                },
                {
                     route_name: 'search',
                    route_text: 'Search'
                }
            ]
        }
    },
    components: {  },

}
</script>



