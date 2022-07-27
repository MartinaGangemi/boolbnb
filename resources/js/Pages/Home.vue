<template>
  <div id="body">
    <!-- jumbotron -->
    <div class="bg-light my_back">
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

    <section id="site_main" class="container mt-5">
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
              <button class="text-light mt-4 w-50">Inizia a viaggiare</button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- appartamenti sponsorizzati -->
    <section class="mt-5 container">
      <h2 class="text-center">Appartamenti consigliati</h2>
      <div class="mt-5 row card-container">
        <div class="col-12 col-sm-6 col-lg-3">
          <div class="card">
            <div class="card-img">card-img</div>
            <div class="p-2 card-text d-flex flex-column align-items-center">
              <!-- text -->
              <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi
                nisi facere minus labore distinctio corporis veniam ab quos
                velit quod.
              </p>
              <button class="w-50 text-light text-uppercase">dettagli</button>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
export default {
  name: "Home",

  data() {
    return {
      addressResults: [],
      searchText: "",
      apartments: [],
      error: false,
      beds: 1,
      rooms: 1,
      defaultDistance: 20,
      lat: 0,
      lon: 0
    };
  },

  methods: {
    searchApartments() {
      this.apartments = [];
      axios
        .get("/api/apartments", {
            params: {
              beds: this.beds,
              rooms: this.rooms,
              defaultDistance: this.defaultDistance * 1000,
              searchLat: this.lat,
              searchLon: this.lon
            }
        })
        .then((response) => {
          //console.log(response.data);
          const results = response.data;
          this.apartmentsResponse = response.data;
          //filtro appartamenti per città
          results.forEach((result) => {
            if (
              result.address
                .toLowerCase()
                .includes(this.searchText.toLowerCase()) &&
              this.searchText != ""
            ) {
              this.apartments.push(result);
              this.$router.push({
                name: "search",
                params: { data: this.apartments },
              });
            } else {
              this.error = true;
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
        `https://api.tomtom.com/search/2/geocode/` +
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
};
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
</style>


