//lista delle pagine
import Home from "./Pages/Home";
import Search from "./Pages/Search";
import _id from "./Pages/checkout/_id";
import Apartment from "./Pages/Apartment"
import Sponsorship from "./Pages/Sponsorship";


const routes = [
    { path: '/', name: 'home', component: Home },
    { path: '/search', name: 'search', component: Search},
    { path: '/sponsorship', name: 'sponsorship', component: Sponsorship},
    { path: '/sponsorship/:id', name: 'checkout', component: _id},
    { path : '/search/apartment/:id', name: 'apartment', component: Apartment}
]

export default routes;
