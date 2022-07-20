
<template>
<div>
    <div class="navbar" id="navbarSupportedContent">
        <!-- Left Side Of Navbar -->
        <ul class="navbar-nav mr-auto">
            <li class="nav-item" v-for="item in menu_items" :key="item.id">
                <router-link class="nav-link" :to="{ name: item.route_name }">{{ item.route_text }}
                </router-link>
            </li>
        </ul>
    </div>
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



