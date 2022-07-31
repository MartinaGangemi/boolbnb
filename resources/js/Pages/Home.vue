<template>
  <div id="body" class="pb-4">
    <!-- jumbotron -->
    <div class="my_back">
      <div class="container text-light py-5">
        <div class="row justify-content-center align-items-center row-form">
          <div class="col-7 text-center">
            <h1 class="display-1">Fablo B&B</h1>
            <!-- ricerca -->
            <form
              @submit.prevent
              class="mt-4 d-flex flex-column align-items-center"
            >
              <input
                placeholder="Dove vuoi andare?"
                type="text"
                class="form-control"
                v-model="searchText"
                @keyup="searchAddress"
              />
              <button
                type="submit"
                class="
                  search-btn
                  rounded-end
                  text-uppercase text-center text-white
                "
                @click="searchApartments()"
              >
                <i class="fa-solid fa-magnifying-glass"></i>
              </button>
              <!-- autoload -->
              <div class="list-address rounded-bottom">
                <div
                  v-for="(singleAddress, index) in addressResults"
                  :key="singleAddress.id"
                >
                  <span
                    class="p-2"
                    @click="checkAddress(index)"
                    v-if="!isHidden"
                    >{{ singleAddress.address.freeformAddress }}</span
                  >
                </div>
              </div>
              <div
                class="mt-2 position-absolute error-search"
                v-show="error == true"
              >
                Non abbiamo trovato nessun appartamento
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

      <div class="bg"></div>
    <div class="bg bg2"></div>
    <div class="bg bg3"></div>
    <section id="site_main" class="container mt-5 bg_light contentsd">
      <div class="row justify-content-center py-3">
        <div class="row row-cols-2 my-5 justify-content-between">
          <div class="col-12 col-lg-8 text">
            <img
              class="img-home img-fluid"
              src="https://www.imghoteles.com/wp-content/uploads/sites/1709/nggallery/desktop-pics//fott1.jpg"
              alt=""
            />
          </div>

          <div
            class="
              col-12 col-lg-4
              text-description
              d-flex
              flex-column
              justify-content-end
              mt-4
            "
          >
            <h3 class="text-uppercase">Benvenuti su Fablo B&B</h3>
            <p>
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Aperiam
              cum neque odio at a obcaecati doloremque fuga veritatis, non
              provident?
            </p>

            <div class="d-flex justify-content-center mb-4">
              <router-link
                  class="btn btn-custom text-uppercase text-light"
                  :to="{
                    name: 'search', }"
                >
                  Viaggia
                </router-link>
            </div>
          </div>
        </div>
      </div>
    </section>




    <!-- appartamenti sponsorizzati -->
    <section class="mt-5 container">
     <h2 class="text-center text-white">I preferiti di Fablo B&B</h2>
      <div class="mt-5 row g-2 card-container">
        <div class="col-12 col-sm-6 col-lg-3" v-for="apartment in sponsoredApartments" :key="apartment.id">

          <div class="card border-0">
            <span class="position-absolute fw-bold top-custom start-custom translate-middle badge p-3 bg-dark">
              <i class="fa-solid fa-crown text-warning fs-5"></i>


            </span>
            <div class="card-img">
              <img class="card-img-top img-fluid" :src="'storage/' + apartment.cover_img" :alt="apartment.summary">
            </div>
            <div class="p-2 card-body d-flex flex-column align-items-center">
              <!-- text -->
             
              <div class="description-apartment col-12">
                <span class="text-center fw-bold" >{{ trimTitle(apartment.summary) }}</span>
                <span>
                {{trimText(apartment.description)}}

                </span>
                <div class="my-2 text-center">
                 <span class=" me-2"><i class="fa-solid fa-bed"></i> :{{apartment.beds}}</span>
                  <span><i class="fa-solid fa-toilet"></i>: {{apartment.bathrooms}} </span>
                </div>
              </div>

              <router-link
                  class="btn btn-custom text-uppercase text-light"
                  :to="{
                    name: 'apartment',
                    params: {
                      id: apartment.id,
                    },
                  }"
                >
                  Visualizza dettagli
                </router-link>

            </div>
          </div>
        </div>
      </div>
      <!-- numero pagine -->
         <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center  mt-5 fw-bold ">
               <li class="page-item" v-if="response_apartments.current_page > 1">
                  <a class="page-link"  @click="getSponsoredApartments(response_apartments.current_page - 1)">Previous</a>
               </li>
               <li :class="{'page-item' : true , 'active' : page == response_apartments.current_page  } " v-for="page in response_apartments.last_page" :key='page.id'>
                  <a class="page-link" href="#" @click.prevent="getSponsoredApartments(page)">{{ page }}</a>
               </li>

               <li class="page-item" v-if="response_apartments.current_page < response_apartments.last_page">
                  <a class="page-link" href="#" @click.prevent="getSponsoredApartments(response_apartments.current_page + 1)">Next</a>
               </li>
            </ul>
         </nav>

    </section>
  </div>
</template>

<script>
export default {
  name: "Home",

  data() {
    return {
      apartments: [],
      apartmentsResponse: "",
      addressResults: [],
      searchText: "",
      sponsoredApartments: [],
      error: false,
      beds: 1,
      rooms: 1,
      defaultDistance: 20,
      lat: 0,
      lon: 0,
      response_apartments: null,
    };
  },

  methods: {

    trimTitle(text){
 if(text.length >38){
         return text.slice(0,30) + '...'
        }
        return text;
    },

     trimText(text){
        if(text.length >70 ){
         return text.slice(0,70) + '...'
        }
        return text;

    },
    getSponsoredApartments(selectPage) {
      axios
        .get("/api/apartment/sponsorship",{
            params:{
                 page: selectPage,
            }
        })
        .then((response) => {
          //console.log(response);

            this.sponsoredApartments = response.data.data;
            this.response_apartments = response.data;
            this.loading = false;
            console.log(this.response_apartments)

        })
        .catch((e) => {
          console.error(e);
        });
    },
    searchApartments(selectPage) {
      this.apartments = [];
      axios
        .get("/api/apartments", {
            params: {
              page: selectPage,
              beds: this.beds,
              rooms: this.rooms,
              defaultDistance: this.defaultDistance * 1000,
              searchLat: this.lat,
              searchLon: this.lon
            }
        })
        .then((response) => {
          //console.log(response.data);
          const results = response.data.data;
          this.apartmentsResponse = response.data;
          //filtro appartamenti per città
          results.forEach((result) => {
              this.apartments.push(result);
          });
          
          const searchResults = this.apartments;
          searchResults.unshift(this.apartmentsResponse);
          searchResults.unshift(this.lon);
          searchResults.unshift(this.lat);
          console.log(searchResults);

          this.$router.push({
                name: "search",
                params: { data: searchResults},
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
        `https://api.tomtom.com/search/2/geocode/` +
        this.searchText +
        `.json?key=zGXvHBjS1KlaiUjP2EEuWGTzWzjTGrEB&typeahead=true`;
      axios.get(link).then((response) => {
        let results = response.data.results;
        //console.log(results);
        this.addressResults = results;
      });
      //visualizza la lista degli indirizzi/città
      this.isHidden = false;
    },

    //metodo per cliccare l'indirizzo che compare in autoload
    checkAddress(addressId) {
      this.searchText = null;

      console.log(addressId);

      //prende la lista delle città e lat e lon
      this.searchText = this.addressResults[addressId].address.freeformAddress;
      this.lat = this.addressResults[addressId].position.lat;
      this.lon = this.addressResults[addressId].position.lon;
      //nasconde la lista degli indirizzi/cittò
      this.isHidden = true;
      //console.log(this.searchText);
      //console.log(this.lat, this.lon, "latlon");
    },
  },

  mounted(){
    this.getSponsoredApartments();
  }
}



</script>

<style lang="scss" scoped>
.row-form {
  height: 500px;
}

.list-address {
  background-color: rgba(255, 255, 255, 0.527);
  color: black;
  max-height: 100px;
  overflow-y: scroll;
  margin-top: 0.5rem;
  width: 100%;
  position: absolute;
  top: 30px;
  text-align: left;
  span {
    cursor: pointer;
  }
}



.start-custom {
    left: 25px !important;
}
.top-custom {
    top: 25px !important;
}

.my_back {
  background: linear-gradient(rgba(0, 0, 0, 0.494), rgba(0, 0, 0, 0.679)),
    url("https://house-diaries.com/wp-content/uploads/2020/11/25337.jpg");
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center;
  filter: drop-shadow(2px 4px 6px black);
}

input {
  height: 40px;
}

input:focus {
  box-shadow: 0 0 0 0.25rem #b945457b;
  border-color: #b945457b;
}

h1 {
  text-shadow: 4px 4px #b94545;
  color: rgba(255, 255, 255, 0.827);
}

form {
  position: relative;
}

.search-btn {
  position: absolute;
  width: 20%;
  top: 0;
  right: 0;
}

h2 {
  position: relative;
  text-transform: uppercase;
}

h2:after {
  border-bottom: solid 2px #b94545;
  content: "";
  position: absolute;
  left: 0;
  right: 0;
  width: 10%;
  top: 40px;
  margin: 0 auto;
}

button {
  background-color: #b94545;
  width: 40%;
  height: 40px;
  border: none;
}

.img-home {
  filter: drop-shadow(2px 4px 6px black);
}

.error-search {
  top: 50px;
}

.bg {
    animation:slide 3s ease-in-out infinite alternate;
    background-image: linear-gradient(-60deg, #B94545 50%, #202023 50%);
    bottom:0;
    left:-50%;
    opacity:.5;
    position:fixed;
    right:-50%;
    top:0;
    z-index:-1;
}
.bg2 {
    animation-direction:alternate-reverse;
    animation-duration:4s;
}
.bg3 {
    animation-duration:5s;
}
.contentsd {
    color: white;
    padding:10vmin;
    text-align:center;
}
@keyframes slide {
    0% {
        transform:translateX(-25%);
    }
    100% {
        transform:translateX(25%);
    }
}

.btn-custom{
    background-color: #B94545;
}



.card-img{
  height: 200px;
  img{
    height: 100%;
    object-fit: cover;
  }
}
.description-apartment{
  height: 150px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}
//paginate
.page-item.active .page-link {
    z-index: 3;
    color: #fff;
    background-color: #B94545;
    border-color: #B94545;

  }
  .page-link{
    color:#B94545 ;
  }
  .page-link:focus {
    box-shadow: 0 0 0 0.25rem #b945457b;
  }



</style>


