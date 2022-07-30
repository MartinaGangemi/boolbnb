<template >


  <div class="custom-height bg-dark">
    <!-- form ricerca appartamento -->
<div class="container ">
    <h2 class="fw-bold text-center text-white pt-5">Cerca un appartamento</h2>
        <div class="card bg-light">
    <form @submit.prevent class="container mt-4 searchs">
            <input
                type="text"
                class="form-control "
                v-model="searchText"
                @keyup="searchAddress"
            />
    <div class="">

        <button
            type="submit"
            class=" btn btn-custom search-btn fw-bold text-white"
            @click="searchApartments"
        >
        <i class="fa-solid fa-magnifying-glass"></i>
        </button>

    </div>


            <!-- autoload da fixare -->
            <div class="listAddress">
                <div
                v-for="(singleAddress, index) in addressResults"
                :key="singleAddress.id"
                >
                <span @click="checkAddress(index)" v-if="!isHidden">{{
                    singleAddress.address.freeformAddress
                }}</span>
                </div>
            </div>


      <div class="text-center">

      <div class="beds-rooms-commands mt-4">
        <span class="me-2">
          <label for="rooms"
            >Distanza (km) <i class="fa-solid fa-map-location-dot"></i
          ></label>
          <input
            type="number"
            min="0"
            step="5"
            v-model="defaultDistance"
            class="border border-danger rounded"
            style="width: 50px"
          />
        </span>

        <span class="me-2">
          <label for="rooms"
            >Nr. Stanze <i class="fa-solid fa-door-closed"></i
          ></label>
          <input
            type="number"
            min="1"
            max="8"
            v-model="rooms"
            class="border border-danger rounded"
            style="width: 50px"
          />
        </span>

        <span>
          <label for="rooms">Nr. Letti <i class="fa-solid fa-bed"></i></label>
          <input
            type="number"
            min="1"
            max="8"
            v-model="beds"
            class="border border-danger rounded"
            style="width: 50px"
          />
        </span>
      </div>
      </div>

       <div class="row mt-4 p-0 ">
        <strong class="text-center mb-2">Seleziona almeno un servizio</strong>
        <div class="row ">
          <div
            v-for="(service, index) in services"
            :key="service.id"
            class="col-12 col-sm-6 col-md-4 col-lg-3 text-dark text-center "
          >
            <input
              class="text-dark checkbox"
              type="checkbox"
              :id="service"
              :name="services"
              :value="index+1"
              v-model="checkedServices"
            />
            <label class="form-check-label" :for="service">{{ service }}</label>
          </div>
        </div>
      </div>

    </form>
    </div>

    <!-- lista appartamenti -->
    <div class=" row justify-content-center mt-2" >
      <!-- sezione mappa -->
       <div class="row col pb-5 original-map">
        <div id="map" class="my-round " ref="mapRef"></div>
     <div class=" row col-lg-9 pb-5 bg-light text-dark cover-map" v-if="apartments <= [0]">
        <div id="map2" class="display-5 fw-bold d-flex justify-content-center align-items-center text-center"> Caricamento...⏲️ </div>
      </div>
      </div>




<!-- nuova card -->

<div class="col-12 d-flex gap-3 flex-wrap card-wrapper  justify-content-between ">
        <div class="card border-0  col-12 col-sm-6  p-0 d-flex align-content-stretch flex-wrap  justify-content-center" v-for="apartment in apartments"
          :key="apartment.id"  style="width: 18rem;">
            <img class="card-img-top img-fluid" :src="'storage/' + apartment.cover_img" :alt="apartment.summary">
            <div class="card-body d-flex align-items-center">
                <span class="text-center fw-bold" >{{ apartment.summary }}</span>
                 <router-link
              class="ms-1 btn btn-custom text-light"
              :to="{ name: 'apartment', params: { id: apartment.id } }"
              >Visita</router-link
            >
              </div>
        </div>
    </div>

    </div>
    </div>
<!-- PAGINAZIONE NON FUNZIONANTE  -->
    <nav aria-label="Page navigation"  >
        <ul class="pagination justify-content-center mb-0">
            <li
            class="page-item"
            v-if="apartmentsResponse.current_page > 1"
            >
                <a
                 class="page_link"
                 aria-label="Previous"
                 @click="searchApartments(apartmentsResponse.current_page - 1)"
                >
                <span aria-hidden="true">&laquo;</span>
                <span class="visually-hidden">Previous</span>
                </a>
            </li>
            <li
                :class="{'page-item': true, active: apartmentsResponse.current_page == page,}"
                v-for="page in apartmentsResponse.last_page"
                :key="page"
                  >
                <a class="page_link" @click="searchApartments(page)">{{
                      page
                    }}</a>
            </li>
            <li
                class="page-item"
                v-if="
                apartmentsResponse.current_page <
                apartmentsResponse.last_page
                "
            >
                <a
                class="page_link"
                aria-label="Next"
                @click="searchApartments(apartmentsResponse.current_page + 1)"
                >
                <span aria-hidden="true">&raquo;</span>
                <span class="visually-hidden">Next</span>
                </a>
            </li>
        </ul>
     </nav>

  </div>
</template>

<script>
export default {
  name: "Search",

  data() {
    return {
      apartments: [],
      apartmentsResponse: "",
      searchText: "",
      services: [
        "Wifi",
        "Parcheggio interno",
        "Belvedere",
        "Asciugacapelli",
        "TV",
        "Climatizzatore",
        "Microonde",
      ],
      checkedServices: [],
      addressResults: [],
      lat: 0,
      lon: 0,
      searchLat: 0,
      searchLon: 0,
      defaultDistance: 20,
      beds: 1,
      rooms: 1,
    };
  },

  methods: {

    searchApartments(selectPage) {
      this.apartments = [];

      //console.log(this.checkedServices);

      axios
        .get("/api/apartments", {
          params: {
            page: selectPage,
            beds: this.beds,
            rooms: this.rooms,
            checkedServices: this.checkedServices,
            defaultDistance: this.defaultDistance * 1000,
            searchLat: this.lat,
            searchLon: this.lon
          },
        })
        .then((response) => {
          console.log(response.data);
          this.apartmentsResponse = response.data;
          this.apartments = response.data.data;

            //mappa
            this.createMap();

            this.searchText = "";
          })
        .catch((e) => {
          console.error(e);
        });
    },


    createMap() {

      //zoom per la mappa
      let zoomMap = 0
      if(this.defaultDistance <= 20){
        zoomMap = 15
      } else if (this.defaultDistance <= 40){
        zoomMap = 8
      } else if (this.defaultDistance <= 80){
        zoomMap = 6
      }else if (this.defaultDistance <= 160){
        zoomMap = 4
      }

      let map = tt.map({
        key: "psWmQcjzXO6qcmJWIp1XA7yeL0JCHDGN",
        container: "map",
        style: "tomtom://vector/1/basic-main",
        center: [this.apartments[0].lon, this.apartments[0].lat],
        zoom: zoomMap,
      });

      map.addControl(new tt.FullscreenControl());
      map.addControl(new tt.NavigationControl());

      let popupOffset = 25;

      this.apartments.forEach((apartment) => {
        let latMarker = apartment.lat;
        let lonMarker = apartment.lon;
        //  let lat = this.apartments[0].lat
        //  let lon = this.apartments[0].lon
        let coordinates = [lonMarker, latMarker];
        // console.log(coordinates);

        //marker

        let marker = new tt.Marker().setLngLat(coordinates).addTo(map);
        // console.log(marker);
        let popup = new tt.Popup({ offset: popupOffset }).setHTML(
          apartment.summary
        );
        marker.setPopup(popup).togglePopup();
      });
    },

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
        `.json?key=psWmQcjzXO6qcmJWIp1XA7yeL0JCHDGN&typeahead=true`;
      axios.get(link).then((response) => {
        let results = response.data.results;
        //console.log(results);
        this.addressResults = results;
      });
      //visualizza la lista degli indirizzi/città
      this.isHidden = false;
    },

    checkAddress(addressId) {
      this.searchText = null;

      console.log(addressId);
      console.log(this.addressResults[0].address.freeformAddress);

      //prende la lista delle città e lat e lon
      this.searchText = this.addressResults[addressId].address.freeformAddress;
      this.lat = this.addressResults[addressId].position.lat;
      this.lon = this.addressResults[addressId].position.lon;
      //nasconde la lista degli indirizzi/cittò
      this.isHidden = true;
    },

    //end methods
  },

  created() {
    this.apartments = this.$route.params.data;
  },

  mounted() {
    //this.searchApartments();
    this.createMap();
  },
};
</script>

<style lang="scss" scoped>
#map {
  height: 35vh;
}
#map2 {
  height: 35vh;
}

ul {
  padding: 0;
  margin: 0;
  clear: both;
}
li{
  list-style-type: none;
  list-style-position: outside;
  padding: 10px;
  float: left;
}
input[type="checkbox"]:not(:checked),
input[type="checkbox"]:checked {
  position: absolute;
  left: -9999%;
}
input[type="checkbox"] + label {
  display: inline-block;
  width: 200px;
  padding: 10px;
  cursor: pointer;
  border-radius: 20px;
  color: white;
  background-color: #212529;
  margin-bottom: 10px;
}

input:focus {   box-shadow: 0 0 0 0.25rem #b945457b;   border-color: #b945457b; }
input:focus {
  box-shadow: 0 0 0 0.25rem #b945457b;
  border-color: #b945457b;
}

input[type="checkbox"]:checked + label {
  color: white;
  background-color: #B94545;
}

.my-round {
   border-radius: 5px;

}

.btn-custom{
    background-color: #B94545;
}

.custom-height{
min-height: calc(100vh  - 170px) ;
}
.col-12{
        .card{
            height: 260px;
            border-radius: 5px;
            margin-bottom: 20px;
            filter: drop-shadow(2px 4px 6px black);
            .card-img-top{
                height: 150px;
            }
        }
}
.searchs{
    position: relative;
}
.search-btn {
  position: absolute;
  width: 10%;
  top: 0;
  right: 10px;
}
button {
  background-color: #b94545;
  width: 30px;
  height: 36px;
  border: none;
}
.listAddress {
  max-height: 130px;
  overflow-y: scroll;
}

.original-map{
    position: relative;
    z-index: 1;
}
.cover-map{
    position: absolute;
    top: 0;
    left: 0;
    z-index: 4;
    transition: 4s;
    width: 100%;
    background-color: #212529 !important;
    color: white !important;
}

/*.content {
  background-color: black;
  color: white;
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  padding: 20px;
  transition: all 0.7s;
  opacity: 0.9;
}

.box:hover .content {
  left: 0;
}

.content p {
  border-top: 1px solid white;
  border-bottom: 1px solid white;
  padding: 17px 0px;
}*/
</style>
