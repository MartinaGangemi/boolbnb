<template>
  <div class="container-fluid">
    <!-- form ricerca appartamento -->
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
      <button type="submit" class="my-4 btn btn-dark w-100 fw-bold fs-2 text-white" @click="searchApartments">
        cerca appartamento
      </button>
    </form>

    <!-- lista appartamenti -->
    <div class="row justify-content-center">
      <div class="col col-md-12 col-lg-10 mb-2 gap-2 d-flex flex-wrap">
           <div
        class="box  p-0 shadow"
        v-for="apartment in apartments"
        :key="apartment.id"
      >
        <div class="card_img d-flex justify-content-center">
          <img :src="'storage/' + apartment.cover_img" :alt="apartment.slug" />
        </div>

        <div class="card-body">
          <h4 class="card-title">{{ apartment.summary }}</h4>
          <p class="card-text"></p>
        </div>

        <!-- card overflow -->
        <div class="content text-center">
          <h3>{{ apartment.summary }}</h3>

          <p>
            {{ apartment.description }}
          </p>

          <a class="btn btn-light" :href="'admin/apartments/' + apartment.slug">vedere</a>
        </div>
      </div>
      </div>

      <!-- mappa -->
      <div class="col-12">
        <div id='map' ref="mapRef"></div>
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

      addressResults: [],
      lat: 0,
      lon: 0,

      
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
          results.forEach(result => {
            if (result.address.includes(this.searchText)) {
              this.apartments.push(result);
            }
          });


  //mappa

    let map = tt.map({
    key: 'D4OSGfRW4VAQYImcVowdausckQhvMUbq',
    container:  'map',
    style: 'tomtom://vector/1/basic-main',
    center: [this.apartments[0].lon,this.apartments[0].lat],
    zoom: 17
    });

    map.addControl(new tt.FullscreenControl());
    map.addControl(new tt.NavigationControl());

    let popupOffset = 25;


    this.apartments.forEach(apartment=>{

    let latMarker = apartment.lat;
    let lonMarker = apartment.lon;
    //  let lat = this.apartments[0].lat
    //  let lon = this.apartments[0].lon
      let coordinates = [lonMarker, latMarker]
      console.log(coordinates)

      //marker

          let marker = new tt.Marker().setLngLat(coordinates).addTo(map);
          console.log(marker)
          let popup = new tt.Popup({ offset: popupOffset }).setHTML(apartment.summary);
          marker.setPopup(popup).togglePopup();

  });

    this.searchText = '';
    })
    .catch((e) => {
      console.error(e);
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
        `.json?key=D4OSGfRW4VAQYImcVowdausckQhvMUbq&typeahead=true`;
      axios.get(link).then((response) => {
        let results = response.data.results;
        //console.log(results);
        this.addressResults = results;
      });
      //visualizza la lista degli indirizzi/città
      this.isHidden = false
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
       this.isHidden = true
      
    },

   

    //end methods
  },

  created(){
    this.apartments=this.$route.params.data
  }


};
</script>

<style lang="scss" scoped>
.box {
  height: 500px;
  width: 400px;
  background: rgb(159, 35, 39);
  background: linear-gradient(352deg, rgb(165, 37, 41) 11%, rgba(2,0,36,1) 100%);
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
  opacity: 0.9;
}

.box:hover .content {
  left: 0;
}

.content p {
  border-top: 1px solid white;
  border-bottom: 1px solid white;
  padding: 17px 0px;
}

#map {
    height: 50vh;

}
</style>
