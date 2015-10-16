<!DOCTYPE html>
<html lang="fr">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
* {
    box-sizing: border-box;
}
.row {
    margin: 10px auto;
    background-color: #D8DDBF;
    border-radius: 5px;
    border: 1px solid black;
    width: 88%;
}
.row:after {
    content: "";
    clear: both;
    display: block;
}
[class*="col-"] {
    float: left;
    padding: 15px;
}
html {
    font-family: "Lucida Sans", sans-serif;
}
a {
    text-decoration: none;
   color:#ffffff;
}
/* entete de la page web */
.header {
    background-color: rgba(33,41,54,1);
    color: #ffffff;
    padding: 0px;
    width: 88%;
    margin: 0 auto;
    border: 1px solid gray;
    overflow: hidden;
    border-radius: 5px;
}
.logo {
    background-color: rgba(33,41,54,0.95);
    padding: 0;
    margin: 0;    
}

.logo img, div img {
    /*width: 299px;
    height: 129px;
    margin: 0;
    padding: 0;*/
    /*
    le max-width propriété est définie à 100%, l'image sera réduire si elle doit, mais jamais évoluer jusqu'à être plus grande que sa taille d'origine
    */
    max-width: 100%;
    height: auto;
}

#search{
        float: right;
        background-color: rgba(33,41,54,0.95);
        /*border: 1px solid #D8DDBF;*/
        border-radius: 5px;
 }   

#search input{
    border-radius: 5px;
    font-weight: bold;
    font-size: 0.75em;
    height: 35px;
    margin: 5px;
    padding: 10px;
    float: right;
    background-image: url(../webracine/images/search.png);
    background-repeat: no-repeat;
    background-position: right;


}
.nav {
    background-color: rgba(33,41,54,0.95);
    margin: 0;
    padding: 0;
    overflow: hidden;
}


.nav ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    
}

.nav li {
    /*
    list-style-type: none;
    background-color: rgba(33,41,54,1);
    
    margin: 2px;
    line-height: 35px;
    width:  110px;
    border-radius: 5px;
    float: right;
    height: 30px;*/
    border: 1px solid #D8DDBF;
    background-color: rgba(33,41,54,1);
    /*border-bottom: 5px solid #54BAE2;*/
    display: block;
    width: 114px;
    height: 25;
    margin: 2px;
    text-align: center;
    float: right;
    border-radius: 5px;/* lement sur la meme ligne*/
    
}
.nav li a{
    /*color:#D8DDBF;
    font-size: 0.6em;    
    font-weight: bold;
    line-height: 25px;
    text-decoration: none;
    text-transform: uppercase;
    text-align: center;
    width: 150px;
    height: 25px;
    background-color:green;*/
    color: #D8DDBF;
    font-size: 0.7em;
    text-transform: uppercase;
    display: block;
    /*font-weight: bold;*/
    line-height: 25px;
    text-decoration: none;
    width: 111px;
    height: 25px;
    overflow: hidden;
    
}
.nav li:hover {
    background:rgba(176,121,20,1);
}
/*
.nav1{
    background-color: red;

}

.nav1 ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
}

.nav1 li {
    
    list-style-type: none;
    background-color: rgba(33,41,70,0.1);
    font-size: 0.7em;
    margin: 2px;
    line-height: 30px;
    text-align: center;
    text-transform: uppercase;
    width: 100%;
    border-radius: 5px;
    float: right;
    border-left: 1px solid white;
    border-right: 1px solid white;


}
.nav li:hover {
    background:rgba(176,121,20,1);
}
.nav1 li:hover {
    background:rgba(176,121,20,1);
}
*/

/* */


h2 {
    /*position: relative;*/
    font-size: 16px;
    line-height: 11px;
    left: 25px;
    margin: 25px 10px 10px 10px;;
    text-transform: uppercase;
    color: #FDEDCB;
    }
hr {
    background: #E2D3CB none repeat scroll 0% 0%;
    border: 0px none;
    height: 1px;
    color: #E2D3CB;
    margin: 0px 10px 25px 10px;
    }
h3 {
    font-size: 14px;
    line-height: 11px;
    text-transform: uppercase;
    border-bottom: 1px solid #FFF;
    color: rgba(176,121,20,1);
    margin: 20px 10px 5px 10px;
    padding-bottom: 5px;
}
p {
    font-size: 16px;
    /*line-height: 14px;*/
    margin: 0px 0px 5px;
    color: #FDEDCB;
    padding: 10px 10px 15px;
}


.menu {
    border: 1px solid gray;
    border-radius: 5px;
    margin-top: 5px; 
}
.menu ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
}
.menu li {
    padding: 8px;
    margin-bottom: 7px;
    background-color :#33b5e5;
    color: #ffffff;
    box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
}



.menu li:hover {
    background-color: #0099cc;
}
.aside {
    background-color: #33b5e5;
    padding: 5px;
    color: #ffffff;
    text-align: left;
    font-size: 14px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
}
.footer {
    margin: 10px auto;
    background-color: #0099cc;
    color: #ffffff;
    text-align: center;
    font-size: 12px;
    padding: 15px;
    width: 88%;
}
/* For mobile phones: */
[class*="col-"] {
    width: 100%;
}
#section {
    border: 1px solid black;

}

#slideshow {
    overflow: hidden;
    margin: 5px auto 10px auto;
}

#slideshow img {
    position:absolute;
    left:0;
    animation-name: cf4FadeInOut;
    animation-timing-function: ease-in-out;
    animation-iteration-count: infinite;
    /*animation-duration: 10s;*/
    animation-direction: alternate;
    -webkit-transition: opacity 1s ease-in-out;
    -moz-transition: opacity 1s ease-in-out;
    -o-transition: opacity 1s ease-in-out;
    transition: opacity 1s ease-in-out;
}

@media only screen and (min-width: 600px) {
    /* For tablets: */
    .col-m-12 {width: 8.33%;}
    .col-m-2 {width: 16.66%;}
    .col-m-3 {width: 25%;}
    .col-m-4 {width: 33.33%;}
    .col-m-5 {width: 41.66%;}
    .col-m-6 {width: 50%;}
    .col-m-7 {width: 58.33%;}
    .col-m-8 {width: 66.66%;}
    .col-m-9 {width: 75%;}
    .col-m-10 {width: 83.33%;}
    .col-m-11 {width: 91.66%;}
    .col-m-12 {width: 100%;}
    .menu li {
        color: lightgreen;
    }

}
@media only screen and (min-width: 768px) {
    /* For desktop: */
    .col-1 {width: 8.33%;}
    .col-2 {width: 16.66%;}
    .col-3 {width: 25%;}
    .col-4 {width: 33.33%;}
    .col-5 {width: 41.66%;}
    .col-6 {width: 50%;}
    .col-7 {width: 58.33%;}
    .col-8 {width: 66.66%;}
    .col-9 {width: 75%;}
    .col-10 {width: 83.33%;}
    .col-11 {width: 91.66%;}
    .col-12 {width: 100%;}

}
@media screen and (max-width: 665px) {
    body {
        background-color: lightblue;
    }
    .row,.header {
        width: 100%;

    }
    
    #search {
        /*border: 1px solid #D8DDBF;*/
        border-bottom:1px solid #D8DDBF;
        border-top:1px solid #D8DDBF; 
        
    }
    .nav ul {
    margin: 10px;}
    
    .nav li {
       width: 100%;
       line-height: 30px;
       float: left;
    }
}

@keyframes cf4FadeInOut {
  0% {
    opacity:1;
  }
  17% {
    opacity:1;
  }
  25% {
    opacity:0;
  }
  92% {
    opacity:0;
  }
  100% {
    opacity:1;
  }
}

#slideshow img:nth-of-type(1) {
  animation-delay: 6s;
}
#slideshow img:nth-of-type(2) {
  animation-delay: 4s;
}
#slideshow img:nth-of-type(3) {
  animation-delay: 2s;
}
#slideshow img:nth-of-type(4) {
  animation-delay: 0;
}

/*

#search{
        float: right;
        background-color: rgba(33,41,54,0.95);
        border: 1px solid #D8DDBF;
        border-radius: 5px;
 }  
@media screen and (min-width: 665px) {
    body {
        background-color: lightgreen;
    }
    .nav1 {
       display: none;
    }
}*/
</style>
<!-- script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript">
    $("#slideshow > div:gt(0)").hide();
    setInterval(function(){
        $('#slideshow > div:first')
            .fadeOut(1000)
            .next()
            .fadeIn(1000)
            .end()
            .appendTo('#slideshow')
    }, 4000);
</script-->
</head>
<body>

?>
<div class="header">
    
    <div class="col-4 logo">
        <img src="<?php echo BASE_URL.'/webracine/images/logohotel1.jpg'?>" width="299" height="129">
    </div>
    <div id="search" class="col-8">
        <form>
            <input type="text" name="search" placeholder="seach">
        </form>
    </div>
    <div id="navigo1" class="col-12 nav">
        <ul>
            <li id="item5" >
                <a href="<?php echo Router::url('admin/salle/index'); ?>" title="Gestion des menbres"><span>Salles</span>
                </a>
            </li>
             <li id="item4">
                <a href="<?php echo Router::url('admin/produit/index'); ?>" title="Gestion des produits"><span>Produits</span>
                </a>
            </li>
            <li id="item3">
                <a href="<?php echo Router::url('admin/membre/index'); ?>" title="Gestion des menbres"><span>Membres</span>
                </a>
            </li>
             <li id="item2">
                <a href="<?php echo Router::url('admin/commande/index'); ?>" title="Gestion des commandes"><span>Commandes</span></a></li>
            <li id="item1">
                <a href="<?php echo Router::url('admin/avis/index'); ?>" title="Gestion des avis"><span>Avis</span></a></li>    
            <li id="item6">
                <a href="<?php echo Router::url('admin/codepromo/index'); ?>" title="Gestion Code promo"><span>Code promo</span></a></li>
              
            <li id="item7">
                <a href="<?php echo Router::url('admin/statistique/index'); ?>" title="Statistiques"><span>Statistiques</span></a></li>    
            <li id="item8">
                <a href="<?php echo Router::url('admin/newletter/index'); ?>" title="Envoyer la newsletter"><span>Newsletter</span></a></li>
        </ul>
    </div>
    <!-- div class="col-m-12 nav1">
        <ul>
            <li>The Flight</li>
            <li>The City</li>
            <li>The Island</li>
            <li>The Food</li>
            <li>The Island</li>        
            <li>The Island</li>            
        </ul>
    </div-->
</div>

<div class="row">


	

	<div class="col-3 col-m-12">
	    <div class="aside">
	        <h2>Informations</h2>
	        <h3>contact</h3>
	        <p>  2 rue est 00000 Paris<br/>
	        Accueil telephonique 24 sur 24 H<br/>
	        Tel: 01 01 01 01 01<br/>Fax : 01 01 01 01 01<br/>
	        Email: contact@hotel-est-paris.fr<br/>
	        <a href="la-localisation.html" title="La localisation">Plan d'acces</a></p>

	        <h3>services</h3>
	        <p>Réception 24h/24<br/>Service fax à la réception<br/>Salon<br/>Parking privé gratuit.<br/><strong>Navette gratuite en directuition de l'aéroport</strong> sur simple appel de 06h30 à 22h00 </p>
	    </div>

	</div>
	<div id="section" class="col-9 col-m-12">
	    
	    <div id="slideshow">
            <?php  echo $this->Session->flash();?>
	        <?php  echo $content_for_layout;?>

	            
	    </div>
        <div>
            <a href="<?php echo Router::url('');?>">Page d'acceil</a>
        </div>
        <div>
            <a href="<?php echo Router::url('connection/logout');?>">se déconncter</a>
        </div>
	    
	</div>

</div>

<div class="footer">
<p>Resize the browser window to see how the content respond to the resizing.</p>
</div>

</body>
</html>
