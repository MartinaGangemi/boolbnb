<template>
    <div id="body">

  

    
   

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

    <section id="site_main" class="container-fluid">
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


        <!-- lista appartamenti -->
        <div class="container-fluid">
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
        </div>
    </section>

  

    <!-- numero pagine -->
         <nav aria-label="Page navigation example">
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
         </nav>
</div>
</template>

<script>

export default{
   name:'Home',
    data(){
        return{
            apartments:'',
            apartmentsResponse:'',
        }

        
    },

     methods:{
        getAllApartments(apartmentPage){
            axios.get('/api/apartments', {
          params : {
            page: apartmentPage
          }
          })
        .then(response => {
            console.log(response.data);
            const apartments = response.data.data
            this.apartmentsResponse = response.data
            this.apartments = apartments.slice(0, 6)
        })
        .catch(e => {
            console.error(e)
        })
        }
    },

    mounted(){
        this.getAllApartments(1);
    }
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
