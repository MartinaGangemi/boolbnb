<template>

<div class="container">


    <h3>{{apartment.summary}}</h3>
    <div class="card">
        <img :src="'/storage/' +  apartment.cover_img" alt="">
        <div class="card-body">
            <p>{{apartment.description}}</p>
               <strong><i class="fa-solid fa-map-location"></i> Address : </strong><span>{{apartment.address}}</span><br>
            <strong><i class="fa-solid fa-door-closed"></i> Rooms : </strong><span>{{apartment.rooms}}</span><br>
            <strong><i class="fa-solid fa-bed"></i> Beds : </strong><span>{{apartment.beds}}</span><br>
            <strong><i class="fa-solid fa-toilet"></i> Bathrooms : </strong><span>{{apartment.bathrooms}}</span><br>
            <strong><i class="fa-solid fa-ruler-combined"></i> Square Meters : </strong><span>{{apartment.square_meters}}</span><br>

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
      }
    },



    mounted(){
        axios.get('/api/search/apartments/' + this.$route.params.id, )
      .then(response =>{

        if(response.data.status_code === 404){
          //this.$router.push({name: 'not-found'})
        } else{
          this.apartment = response.data
          console.log(response.data)
        }
      })
      .catch(e => {
      console.error(e);
      })
    }
}
</script>
