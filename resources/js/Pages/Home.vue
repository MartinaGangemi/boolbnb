<template>
    <div id="body">
    
    <!-- jumbotron -->
    <div class="p-5 bg-light my_back">
        <div class="container text-light">
            <h1 class="display-3">Consigliati da noi</h1>
            <p class="lead">Jumbo helper text</p>
            <hr class="my-2">
            <p>More info</p>
            <p class="lead">
                <a class="btn btn-primary btn-lg" href="Jumbo action link" role="button">Jumbo action name</a>
            </p>
        </div>
    </div>



    
    <!-- form -->
    <section id="site_main" class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-8">
                <h1>Dove vuoi andare?</h1>
        <form @submit.prevent>
            <input
                type="text"
                class="form-control"
                v-model="searchText"
                @keyup="searchAddress"
            />
            <!-- autoload da fixare -->
            <div
                v-for="(singleAddress, index) in addressResults"
                :key="singleAddress.id"
            >
                <span @click="checkAddress(index)" v-if="!isHidden">{{
                singleAddress.address.freeformAddress
                }}</span>
            </div>
            
                <button type="submit" class="my-4 btn btn-dark w-100 fw-bold fs-2 text-white" @click="searchApartments()">
                    cerca appartamento
                </button>
           
            
        </form>
            </div>
        </div>


        <div class="row justify-content-center py-3">
            <div class="col-10">
                <h3>Small Room</h3>

                <div class="row justify-content-between">
                    <div class="col-9 text">

                        <img class="img-fluid" src="https://www.imghoteles.com/wp-content/uploads/sites/1709/nggallery/desktop-pics//fott1.jpg" alt="">

                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>

                    <div class="col-2 text">
                        TESTO DA SCEGLIERE
                    </div>
                </div>
            </div>
        </div>



    </section>




</div>
</template>

<script>

export default{
   name:'Home',

    data(){
        return {
            addressResults: [],
            searchText: "",
            apartments: [],
             props:{
            apartmentList: Array
                }
            
        };
    },

    methods: {
    
    searchApartments(addressId) {
      this.apartments = [];
      axios
        .get("/api/apartments")
        .then((response) => {
          //console.log(response.data);
          const results = response.data.data;
          this.apartmentsResponse = response.data;
          //filtro appartamenti per città
          results.forEach(result => {
            if (result.address.includes(this.searchText)) {
              this.apartments.push(result);
              this.$router.push({name:"search", params:{data:this.apartments}})
            }
          });
          
            
        })

        .catch((e) => {
        console.error(e);
        });
    },
    //chiamata tom tom e crea una lista sdi suggerimenti
    searchAddress() {
      window.axios.defaults.headers.common = {
        Accept: "application/json",
        "Content-Type": "application/json",
    };

      //const resultElement = document.querySelector('.results')
      //resultElement.innerHTML = ''
      const link =
        `https://kr-api.tomtom.com/search/2/geocode/` +
        this.searchText +
        `.json?key=D4OSGfRW4VAQYImcVowdausckQhvMUbq&typeahead=true`;
      axios.get(link).then((response) => {
        let results = response.data.results;
        //console.log(results);
        this.addressResults = results;
      });
      //visualizza la lista degli indirizzi/città
      this.isHidden = false
    },



        //metodo per cliccare l'indirizzo che compare in autoload
        checkAddress(addressId) {
      
      this.searchText = null;
      

      console.log(addressId);
      console.log(this.addressResults[0].address.freeformAddress);

      //prende la lista delle città e lat e lon
      this.searchText = this.addressResults[addressId].address.freeformAddress;
      this.lat = this.addressResults[addressId].position.lat;
      this.lon = this.addressResults[addressId].position.lon;
      //nasconde la lista degli indirizzi/cittò
       this.isHidden = true
      //console.log(this.searchText);
      //console.log(this.lat, this.lon, "latlon");
    }

},



    
    
}

</script>

<style lang="scss" scoped>

    #body{
        background-color: #FFFFFF;
    }

    .my_back{
        background: url('http://amdtapes.ro/wp-content/themes/options/images/skins/headers/full_width/header-tealSkies.jpg');
        background-repeat:no-repeat ;
        background-size:cover ;
        background-position: center;
    }



</style>