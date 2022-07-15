
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

        <div class="container-fluid">
            <div class="row justify-content-around">
                
                <div class="box col-3 p-0 shadow">
                    <div class="card_img d-flex justify-content-center">
                        <img src="https://dhqbz5vfue3y3.cloudfront.net/fotomondobb/1929_top.jpg">
                    </div>                 
                        
                    <div class="card-body">
                        <h4 class="card-title">Descrizione</h4>
                        <p class="card-text"></p>
                    </div>

                    <div class="content text-center"> 
                        <h3>B&B</h3> 

                        <p>
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Magni aperiam nesciunt quibusdam id, minima, autem neque suscipit, accusantium numquam iure libero. Dolorem accusantium doloribus obcaecati veritatis et temporibus nulla aut alias corporis consequatur, repellendus eos molestiae nesciunt maxime corrupti officiis. Explicabo asperiores quo quod minus! Inventore illo soluta tenetur pariatur!
                        </p>
                        
                        <a href="#" class="btn btn-light">vedere</a>
                    </div> 
                </div>
 
                <div class="box col-3 p-0 shadow">
                    <div class="card_img d-flex justify-content-center">
                        <img src="https://dhqbz5vfue3y3.cloudfront.net/fotomondobb/1929_top.jpg">
                    </div>                 
                        
                    <div class="card-body">
                        <h4 class="card-title">Descrizione</h4>
                        <p class="card-text"></p>
                    </div>

                    <div class="content text-center"> 
                        <h3>B&B</h3> 

                        <p>
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Magni aperiam nesciunt quibusdam id, minima, autem neque suscipit, accusantium numquam iure libero. Dolorem accusantium doloribus obcaecati veritatis et temporibus nulla aut alias corporis consequatur, repellendus eos molestiae nesciunt maxime corrupti officiis. Explicabo asperiores quo quod minus! Inventore illo soluta tenetur pariatur!
                        </p>
                        
                        <a href="#" class="btn btn-light">vedere</a>
                    </div> 
                </div>

                <div class="box col-3 p-0 shadow">
                    <div class="card_img d-flex justify-content-center">
                        <img src="https://dhqbz5vfue3y3.cloudfront.net/fotomondobb/1929_top.jpg">
                    </div>                 
                        
                    <div class="card-body">
                        <h4 class="card-title">Descrizione</h4>
                        <p class="card-text"></p>
                    </div>

                    <div class="content text-center"> 
                        <h3>B&B</h3> 

                        <p>
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Magni aperiam nesciunt quibusdam id, minima, autem neque suscipit, accusantium numquam iure libero. Dolorem accusantium doloribus obcaecati veritatis et temporibus nulla aut alias corporis consequatur, repellendus eos molestiae nesciunt maxime corrupti officiis. Explicabo asperiores quo quod minus! Inventore illo soluta tenetur pariatur!
                        </p>
                        
                        <a href="#" class="btn btn-light">vedere</a>
                    </div> 
                </div>

            </div>
        </div>
    </section>
 
    </div>
</template>


<script>
export default {
    name: 'App',
    components: {  }
}
</script>


<style lang="scss" scoped>

    #body{
        background-color: #FFFFFF;
    }

    .my_back{
        background: url('https://cdn.materialdistrict.com/wp-content/uploads/2018/05/fire-alarm-wallpaper-can-warn-of-house-fires-01.jpg');
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
