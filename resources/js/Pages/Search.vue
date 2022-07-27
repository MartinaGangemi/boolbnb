<template>
  <div class="container-fluid mt-4">
    <!-- form ricerca appartamento -->
    <form @submit.prevent>
      <input
        type="text"
        class="form-control"
        v-model="searchText"
        @keyup="searchAddress"
      />
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

      <div class="row mt-4 p-0">
        <strong>Seleziona almeno un servizio</strong>
        <div class="row">
          <div
            v-for="(service, index) in services"
            :key="service.id"
            class="col-12 col-sm-6 col-md-4 col-lg-3 text-dark"
          >
            <input
              class="text-dark"
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

      <button
        type="submit"
        class="my-4 btn btn-dark w-100 fw-bold fs-2 text-white"
        @click="searchApartments"
      >
        cerca appartamento
      </button>
    </form>

    <!-- lista appartamenti -->
    <div class=" row justify-content-center" style="padding-bottom: 2000px">
      <!-- sezione mappa -->
      <div class="row col-lg-9 pb-5 original-map">
        <div id="map" class="my-round my-col" ref="mapRef"></div>
     <div class=" row col-lg-9 pb-5 h-100 w-100 bg-light text-dark cover-map" v-if="apartments <= [0]">
        <div id="map2" class="display-5 fw-bold d-flex justify-content-center align-items-center text-center"> Loading...⏲️ <br> oppure non ce stanno appartamenti 👌</div>
      </div>
      </div>



      <div class="col col-md-12 col-lg-10 mb-2 p-3 gap-2 d-flex flex-wrap">
        <div
          class="box p-0 shadow"
          v-for="apartment in apartments"
          :key="apartment.id"
        >
          <div class="card_img d-flex justify-content-center">
            <img
              :src="'storage/' + apartment.cover_img"
              :alt="apartment.slug"
            />
          </div>

          <div class="card-body">
            <h4 class="card-title">{{ apartment.summary }}</h4>
            <p class="card-text"></p>
            <router-link
              class="btn btn-light"
              :to="{ name: 'apartment', params: { id: apartment.id } }"
              >Read More</router-link
            >
          </div>

          <!-- card overflow -->
          <!-- <div class="content text-center">
          <h3>{{ apartment.summary }}</h3>

          <p>
            {{ apartment.description }}
          </p>

          <a class="btn btn-light" :href="'admin/apartments/' + apartment.slug">vedere</a>
        </div> -->
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
    searchApartments() {
      this.apartments = [];

      console.log(this.checkedServices);

      axios
        .get("/api/apartments", {
          params: {
            beds: this.beds,
            rooms: this.rooms,
            services: this.services,
            checkedServices: this.checkedServices
          },
        })
        .then((response) => {
          //console.log(response.data);
          const results = response.data.data;
          this.apartmentsResponse = response.data;

          const link =
            "https://kr-api.tomtom.com/search/2/geocode/" +
            this.searchText +
            ".json?key=Jpqe16Wf8nfHE1cJGvGsx04P06GgVcIT&typeahead=true";

          axios.get(link).then((searchResponse) => {
            let searchResults = searchResponse.data.results;

            //console.log('Risultati di ricerca: ' , searchResults[0].position);
            this.searchLat = searchResults[0].position.lat;
            this.searchLon = searchResults[0].position.lon;

            results.forEach((result) => {
              //console.log("Risultato: ", result);

              const distance = this.getDistanceFromLatLonInKm(
                result.lat,
                result.lon,
                this.searchLat,
                this.searchLon
              );
              //console.log(distance);

              if (distance <= this.defaultDistance) {
                this.apartments.push(result);
              }
            });

            //console.log("Lista appartamenti: ", this.apartments);

            this.apartments.sort(function (apartment1, apartment2) {
              //console.log("1: ", apartment1, " 2: ", apartment2);

              /* let distance1 = this.getDistanceFromLatLonInKm(
                    apartment1.lat,
                    apartment1.lon,
                    this.searchLat,
                    this.searchLon
                );

                let distance2 = this.getDistanceFromLatLonInKm(
                    apartment2.lat,
                    apartment2.lon,
                    this.searchLat,
                    this.searchLon
                ); */

              //console.log("1: ", distance1, " 2: ", distance2);

              return 0;
            });

            //mappa
            this.createMap();

            this.searchText = "";
          });
        })
        .catch((e) => {
          console.error(e);
        });
    },

    getDistanceFromLatLonInKm(lat1, lon1, lat2, lon2) {
      let R = 6371; // Radius of the earth in km
      let dLat = this.deg2rad(lat2 - lat1); // deg2rad below
      let dLon = this.deg2rad(lon2 - lon1);
      let a =
        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(this.deg2rad(lat1)) *
          Math.cos(this.deg2rad(lat2)) *
          Math.sin(dLon / 2) *
          Math.sin(dLon / 2);
      let c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
      let d = R * c; // Distance in km
      return d;
    },

    deg2rad(deg) {
      return deg * (Math.PI / 180);
    },

    createMap() {
      let map = tt.map({
        key: "Jpqe16Wf8nfHE1cJGvGsx04P06GgVcIT",
        container: "map",
        style: "tomtom://vector/1/basic-main",
        center: [this.apartments[0].lon, this.apartments[0].lat],
        zoom: 13,
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
        `.json?key=Jpqe16Wf8nfHE1cJGvGsx04P06GgVcIT&typeahead=true`;
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

.my-round {
  border-radius: 20px;
}

.fixed {
  position: -webkit-sticky;
  position: sticky;
  top: 0;
  padding: 5px;
  background-color: #cae8ca;
  border: 2px solid #4caf50;
}

.box {
  height: 500px;
  width: 400px;
  background: rgb(159, 35, 39);
  background: linear-gradient(
    352deg,
    rgb(165, 37, 41) 11%,
    rgba(2, 0, 36, 1) 100%
  );
  position: relative;
  overflow: hidden;
  border-radius: 1rem;
  color: #ffffff;
}

.box .card {
  width: 100%;
  height: 100%;
  border-radius: 1rem;
}

.card_img {
  height: 40%;
}

.card_img img {
  height: 100%;
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
