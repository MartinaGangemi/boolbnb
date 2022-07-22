//lista delle pagine
import Home from "./Pages/Home";
import Search from "./Pages/Search";
import Apartment from "./Pages/Apartment"


const routes = [
    { path: '/', name: 'home', component: Home },
    { path: '/search', name: 'search', component: Search},
    { path : '/search/apartment/:id', name: 'apartment', component: Apartment}
] 

export default routes;