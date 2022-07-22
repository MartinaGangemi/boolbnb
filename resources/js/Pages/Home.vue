<template>
    <div id="body">

    <!-- jumbotron -->
    <div class=" bg-light my_back">

        <div class="container text-light py-5">

            <div class="row justify-content-center align-items-center row-form">
                <div class="col-7 text-center">
                   <h1 class="display-1">Fablo B&B</h1>
                   <!-- ricerca -->
                    <form @submit.prevent class="mt-4 d-flex flex-column align-items-center">
                        <input placeholder="Dove vuoi andare?"
                            type="text"
                            class="form-control "
                            v-model="searchText"
                            @keyup="searchAddress"
                        />
                        <button type="submit" class="  rounded-end  text-uppercase text-center text-white" @click="searchApartments()">
                                 <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                        <!-- autoload -->
                        <div class="list-address">
                            <div
                                v-for="(singleAddress, index) in addressResults"
                                :key="singleAddress.id"
                            >
                                <span  class="p-2" @click="checkAddress(index)" v-if="!isHidden">{{
                                singleAddress.address.freeformAddress
                                }}</span>
                            </div>

                        </div>



                    </form>
                </div>
        </div>
        </div>
    </div>




    <!-- form -->
    <section id="site_main" class="container-fluid mt-5">



        <div class="row justify-content-center py-3">
            <div class="col-10">
                <h3>Appartamenti consigliati </h3>

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

   <!--  <div class="trapezioIs">a</div> -->

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
        `.json?key=zGXvHBjS1KlaiUjP2EEuWGTzWzjTGrEB&typeahead=true`;
      axios.get(link).then((response) => {
        let results = response.data.results;
        console.log(results);
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

    .row-form{
        height: 500px;
    }

    .list-address{
        background-color: rgba(255, 255, 255, 0.527);
        color: black;
        max-height: 50px;
        margin-top: 0.5rem;
        width: 95%;
        position: relative;
        top: -9px;

    }
    .my_back{
        background:
        linear-gradient(rgba(0, 0, 0, 0.494), rgba(0, 0, 0, 0.679)),
        url('https://house-diaries.com/wp-content/uploads/2020/11/25337.jpg');
        background-repeat:no-repeat ;
        background-size:cover ;
        background-position: center;


    }


    input{
        height: 40px;
    }
    input:focus{
        box-shadow: 0 0 0 0.25rem #b945457b;
        border-color: #b945457b

    }


    h1{
        text-shadow: 4px 4px #b94545;
        color: rgba(255, 255, 255, 0.827);
    }

    form{
        position: relative;
    }
    button{
        background-color: #b94545;
        position: absolute;
        width: 20%;
        height: 40px;
        top: 0;
        right: 0;
        border: none;
        transition: 1s;
    }
     button:hover{
         background: -webkit-gradient(radial, 100 75, 100, 100 75, 0, from(rgba(0, 0, 0, .7)), to(rgba(0, 0, 0, .4)))


    }


</style>
