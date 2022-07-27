<template>
  <div class="apartment-container">
    <div class="apartment-img">
      <img :src="'/storage/' + apartment.cover_img" alt="" />
    </div>

    <div class="container mt-5">
      <h1 class="text-uppercase">{{ apartment.summary }}</h1>

      <div class="row apartment-information">
        <div class="col-6">
          <!-- informazioni appartamento -->
          <p>{{ apartment.description }}</p>
          <strong><i class="fa-solid fa-map-location"></i> Address : </strong
          ><span>{{ apartment.address }}</span
          ><br />
          <strong><i class="fa-solid fa-door-closed"></i> Rooms : </strong
          ><span>{{ apartment.rooms }}</span
          ><br />
          <strong><i class="fa-solid fa-bed"></i> Beds : </strong
          ><span>{{ apartment.beds }}</span
          ><br />
          <strong><i class="fa-solid fa-toilet"></i> Bathrooms : </strong
          ><span>{{ apartment.bathrooms }}</span
          ><br />
          <strong
            ><i class="fa-solid fa-ruler-combined"></i> Square Meters : </strong
          ><span>{{ apartment.square_meters }}</span
          ><br />
          <strong><i class="fa-solid fa-list"></i> Services : </strong>
          <ul class="d-inline-block list-inline">
            <li
              class="list-inline-item"
              v-for="service in apartment.services"
              :key="service.id"
            >
              {{ service.name }}
            </li>
          </ul>
        </div>
        <div class="col-6">
          <!-- mappa -->
          <div id="map" ref="mapRef"></div>
        </div>
      </div>

      <!-- sezione messaggi e recensioni-->
      <div class="row mt-5">
        <!-- Messaggi -->
        <div class="col-12 col-lg-6 mb-2">
          <div class="card p-5 text-center">
            <div class="message-form message-style p-4">
              <h2 class="text-uppercase fw-bold">
                Invia un messaggio all' Host
              </h2>

              <div class="mb-3">
                <label for="name" class="form-label">Nome:</label>
                <input
                  v-model="guestFullName"
                  type="text"
                  class="form-control"
                  name="name"
                  id="name"
                  aria-describedby="namehelpId"
                  placeholder="Mario Rossi"
                />
              </div>

              <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input
                  v-model="guestEmail"
                  type="email"
                  class="form-control"
                  name="email"
                  id="email"
                  aria-describedby="emailHelpId"
                  placeholder="mariorossi@example.com"
                />
              </div>

              <div class="mb-3">
                <label for="message" class="form-label">Messaggio:</label>
                <textarea
                  @keyup.enter="saveMessage()"
                  v-model="guestMessage"
                  class="form-control"
                  name="message"
                  id="message"
                  rows="3"
                ></textarea>
              </div>

              <button class="btn btn-primary" @click="saveMessage()">
                Invia
              </button>
            </div>
            <div
              :class="messageSent ? 'position-absolute' : 'd-none'"
              class="
                message_sent
                rounded
                p-1
                mb-2
                bg-success
                text-white
                d-inline-block
              "
            >
              Messaggio inviato!
            </div>
          </div>
        </div>
        <!-- immagine random -->
        <div class="col-12 col-lg-6">
          <div class="img-container p-5">
            <img
              src="http://cdn.home-designing.com/wp-content/uploads/2017/06/red-dining-chairs.jpg"
              alt=""
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
export default {
  name: "apartment",
  data() {
    return {
      apartment: "",
      lat: 0,
      lon: 0,
      guestMessage: "",
      guestEmail: "",
      guestFullName: "",
      messageSent: false,
    };
  },

  methods: {
    createMap() {
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
      console.log(apartment);
    },
    getAuthUser() {
      this.guestEmail = window.user_email;
      this.guestFullName = window.user_name;
    },
    saveMessage() {
      axios
        .get("/api/apartment/message", {
          params: {
            apartment_id: this.$route.params.id,
            fullname: this.guestFullName,
            email: this.guestEmail,
            description: this.guestMessage,
          },
        })
        .then((response) => {
          console.log(response);
          this.guestMessage = "";
          this.guestEmail = "";
          this.guestFullName = "";
          this.messageSent = true;
          setTimeout(() => {
            this.messageSent = false;
          }, 2000);
        })
        .catch((e) => {
          console.error(e);
        });
    },
  },

  mounted() {
    axios
      .get("/api/search/apartments/" + this.$route.params.id)
      .then((response) => {
        if (response.data.status_code === 404) {
          //this.$router.push({name: 'not-found'})
        } else {
          this.apartment = response.data;
          //console.log(this.apartment)
          this.createMap();
        }
      })
      .catch((e) => {
        console.error(e);
      });
  },
};
</script>


<style lang="scss" scoped>
.message_sent {
  position: absolute;
  bottom: 0;
  left: 50%;
  transform: translate(-50%, 0);
  transition: all 1s;
}
img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
.apartment-img {
  height: 500px;
  width: 100%;
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
