//lista delle pagine
import Home from "./Pages/Home";
import Search from "./Pages/Search";


const routes = [
    { path: '/', name: 'home', component: Home },
    { path: '/search', name: 'search', component: Search },
] 

export default routes;