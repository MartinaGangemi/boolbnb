<template>

<div class="container-fluid">


    <!-- form ricerca appartamento -->
    <form @submit.prevent>
        <input type="text" class="form-control" v-model="searchText" @keyup='searchAddress' >
        <!-- autoload da fixare -->
        <div v-for="(singleAddress,index) in addressResults" :key="singleAddress.id"> <span class="ms-4" @click="checkAddress(index)">{{singleAddress.address.freeformAddress}}</span></div>
        <button type="submit" class=" my-4 btn btn-primary w-100" @click='searchApartments' >cerca appartamento</button>
    </form>



    <!-- lista appartamenti -->
    <div class="row justify-content-around">

        <div class="box col-3 p-0 shadow" v-for="apartment in apartments" :key="apartment.id">
            <div class="card_img d-flex justify-content-center">
                <img :src="'storage/' + apartment.cover_img" :alt='apartment.slug'>
            </div>

            <div class="card-body">
                <h4 class="card-title">{{apartment.summary}}</h4>
                <p class="card-text"></p>
            </div>

            <!-- card overflow -->
            <div class="content text-center">
                <h3>{{apartment.summary}}</h3>

                <p>
                    {{apartment.description}}
                </p>

                <a href="#" class="btn btn-light">vedere</a>
            </div>
        </div>



    </div>



    <!-- numero pagine -->
    <!-- <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center  mt-5">
        <li class="page-item" v-if="apartmentsResponse.current_page > 1">
            <a class="page-link"  @click="getAllApartments(apartmentsResponse.current_page - 1)">Previous</a>
        </li>
        <li :class="{'page-item' : true , 'active' : page == apartmentsResponse.current_page  }" v-for="page in apartmentsResponse.last_page" :key='page.id'>
            <a class="page-link" href="#" @click.prevent="getAllApartments(page)">{{ page }}</a>
        </li>

        <li class="page-item" v-if="apartmentsResponse.current_page < apartmentsResponse.last_page">
            <a class="page-link" href="#" @click.prevent="getAllApartments(apartmentsResponse.current_page + 1)">Next</a>
        </li>
    </ul>
    </nav> -->

</div>


</template>

<script>
export default{
   name:'Search',
    data(){
        return{
            apartments:[],
            apartmentsResponse:'',
            searchText:'',

            addressResults:[],
            lat:0,
            lon:0,
        }


    },

    methods:{

       searchApartments(){
        this.apartments=[];
        axios.get('/api/apartments')
        .then(response => {
            console.log(response.data);
            const results = response.data.data
            this.apartmentsResponse = response.data
            results.forEach(result => {

               if(result.address.includes(this.searchText)){
                this.apartments.push(result)
               }

            });

        })
        .catch(e => {
            console.error(e)
        })
        },


        //autoload da fixare

        searchAddress() {

        window.axios.defaults.headers.common = {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        };

       //const resultElement = document.querySelector('.results')
       //resultElement.innerHTML = ''
        const link = `https://kr-api.tomtom.com/search/2/geocode/`+ this.searchText + `.json?key=D4OSGfRW4VAQYImcVowdausckQhvMUbq&typeahead=true`
        axios.get(link).then(response => {
            let results = response.data.results
           console.log(results);
            this.addressResults = results

        });

       },


     checkAddress(addressId){
         //console.log('suca')
         this.searchText = null
         /* this.addressResults.forEach(item => {
             this.searchText = item.address.municipality
             this.lat = item.position.lat
             this.lon = item.position.lon
             console.log(item.position)

         }); */

        console.log(addressId);
        console.log(this.addressResults[0].address.freeformAddress);

         this.searchText = this.addressResults[addressId].address.freeformAddress
         this.lat =  this.addressResults[addressId].position.lat
         this.lon =  this.addressResults[addressId].position.lon

         console.log(this.searchText)
         console.log(this.lat,this.lon, 'latlon')


     },

    //  searchApartments(){
    //     axios.get()
    //      https://api.tomtom.com/search/2/geocode/4%20north%202nd%20street%20san%20jose.json?storeResult=false&lat=37.337&lon=-121.89&radius=20000&view=Unified&key=*****
    //  }


    //`https://api.tomtom.com/search/2/geocode/`+ $searchText + `.json?storeResult=false&lat=`37.337&lon=-121.89&radius=20000&view=Unified&key=*****



    //end methods
    }
//end data
}








</script>

<style lang="scss" scoped>



    .box {
        height: 500px;
        width: 400px;
        background-color: #7F7F7F;
        position: relative;
        overflow: hidden;
        border-radius: 1rem;
        color: #FFFFFF;
    }

    .box .card {
        width: 100%;
        height: 100%;
        border-radius: 1rem;
    }

    .card_img{
        height: 40%;
    }

    .card_img img{
        height: 100%;
    }

    .content {
        background-color: black;
        color: white;
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        padding: 20px;
        transition: all 0.7s;
        opacity: 0.9
    }

    .box:hover .content {
        left: 0
    }

    .content p {
        border-top: 1px solid white;
        border-bottom: 1px solid white;
        padding: 17px 0px
    }


</style>
