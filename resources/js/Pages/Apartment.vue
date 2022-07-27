<template>

<div class="apartment-container">
  <div class="apartment-img">
    <img :src="'/storage/' +  apartment.cover_img" alt="">
  </div>


    <div class="container mt-5">


      <h1 class="text-uppercase">{{apartment.summary}}</h1>

          <div class="row apartment-information">

            <div class="col-6">
              <!-- informazioni appartamento -->
              <p>{{apartment.description}}</p>
                <strong><i class="fa-solid fa-map-location"></i> Address : </strong><span>{{apartment.address}}</span><br>
              <strong><i class="fa-solid fa-door-closed"></i> Rooms : </strong><span>{{apartment.rooms}}</span><br>
              <strong><i class="fa-solid fa-bed"></i> Beds : </strong><span>{{apartment.beds}}</span><br>
              <strong><i class="fa-solid fa-toilet"></i> Bathrooms : </strong><span>{{apartment.bathrooms}}</span><br>
              <strong><i class="fa-solid fa-ruler-combined"></i> Square Meters : </strong><span>{{apartment.square_meters}}</span><br>
              <strong><i class="fa-solid fa-list"></i> Services : </strong>
              <ul class="d-inline-block list-inline">
                <li class="list-inline-item" v-for="service in apartment.services" :key="service.id">{{service.name}}</li>
              </ul>


            </div>
            <div class="col-6">

              <!-- mappa -->
              <div id="map"  ref="mapRef"></div>
            </div>


          </div>


      <!-- sezione messaggi e recensioni-->
      <div class=" row mt-5">
        <!-- Messaggi -->
        <div class="col-12 col-lg-6 mb-2">
          <div class="card p-5 text-center">
            <h2 class="text-uppercase">Contatta l'host</h2>

            <form  class="mt-5" action="">
              <div class="mb-3 d-flex gap-2">
                  <input type="name" class="form-control" id="exampleFormControlInput1" placeholder="Nome">
                  <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Email">
                </div>
                <div class="mb-3">
                  <textarea class="form-control" id="exampleFormControlTextarea1" placeholder="Scrivi un messaggio *" rows="3"></textarea>
                </div>
                <button type="submit" class="search-btn  text-uppercase text-center text-white">Contatta</button>
              </form>
          </div>
        </div>
        <!-- immagine random -->
        <div class="col-12 col-lg-6">
          <div class="img-container p-5">
            <img src="http://cdn.home-designing.com/wp-content/uploads/2017/06/red-dining-chairs.jpg" alt="">
          </div>
      </div>
    </div>
    </div>


</div>





</template>


<script>


export default {
    name:'apartment',
    data(){
        return{
        apartment:'',
        lat: 0,
        lon: 0,

      }
    },

    methods:{
      createMap(){
      let map = tt.map({
        key: "Jpqe16Wf8nfHE1cJGvGsx04P06GgVcIT",
        container: "map",
        style: "tomtom://vector/1/basic-main",
        center: [this.apartment.lon, this.apartment.lat],
        zoom: 20,
      });

      //console.log(this.apartment)
      map.addControl(new tt.FullscreenControl());
      map.addControl(new tt.NavigationControl());

      let popupOffset = 25;

      let latMarker = this.apartment.lat;
      let lonMarker = this.apartment.lon;
      //  let lat = this.apartments[0].lat
      //  let lon = this.apartments[0].lon
      let coordinates = [lonMarker, latMarker];
      console.log(coordinates);

      //marker

      let marker = new tt.Marker().setLngLat(coordinates).addTo(map);
      console.log(marker);
      let popup = new tt.Popup({ offset: popupOffset }).setHTML(
        this.apartment.summary
      );
      marker.setPopup(popup).togglePopup();
      console.log(apartment)
      },
    },

    mounted(){


      axios.get('/api/search/apartments/' + this.$route.params.id, )
      .then(response =>{

        if(response.data.status_code === 404){
          //this.$router.push({name: 'not-found'})
        } else{
          this.apartment = response.data
          //console.log(this.apartment)
           this.createMap();
        }
      })
      .catch(e => {
      console.error(e);
      })



    },

  }
</script>


<style lang="scss" scoped>

img{
  width: 100%;
  height: 100%;
  object-fit: cover;
}
  .apartment-img{
    height: 500px;
    width: 100%;
  }

   h2{
        position: relative;
        text-transform: uppercase;
    }
    h2:after {
        border-bottom: solid 2px  #b94545;
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        width: 20%;
        top: 40px;
        margin: 0 auto;
    }

    button {
    background-color: #b94545;
    width: 40%;
    height: 40px;
    border: none;
}

#map {
  height: 400px;
}
</style>
