<script
src="http://maps.googleapis.com/maps/api/js">
</script>
<?php 
   

        $street="48 Boulevard de Bercy"; $postcode="75012"; $city="Paris"; $region="France";
        $adress_par_defaut['rue']= ' 31 Avenue George V';
        $adress_par_defaut['cp']= '75008';
        $adress_par_defaut['ville']='Paris';
        $adress_par_defaut['pays']='France';
        $default_a=$adress_par_defaut['rue'].", ".$adress_par_defaut['cp'].", ".$adress_par_defaut['ville'].", ".$adress_par_defaut['pays'];
        $default_address = urlencode($default_a);
        $default_link = "http://maps.google.com/maps/api/geocode/xml?address=".$default_address."&sensor=false";
        $default_file = file_get_contents($default_link);

        //debug($adresse);
        if ($adresse) {
            
            $a=$adresse[0].", ".$adresse[1].", ".$adresse[2].", ".$adresse[3];
            $address = urlencode($a);
            $link = "http://maps.google.com/maps/api/geocode/xml?address=".$address."&sensor=false";
            $file = file_get_contents($link);
            $str ='';
        }

        if(!$file)  {
          echo "Err: No access to Google service: ".$a."<br/>\n";
        }else {
            //$result = strpos($a,'are') !== false ? true : false;
            $get = simplexml_load_string($file);

            if ($get->status == "OK") {
                $lat = (float) $get->result->geometry->location->lat;
                $long = (float) $get->result->geometry->location->lng;
                //echo "lat: ".$lat."; long: ".$long."; ".$a."<br/>\n";
                //exec("lat: ".$lat."; long: ".$long."; ".$a."<br/>\n";);
                $geolocalx['latitude'] = $lat;
                $geolocalx['longitude'] = $long;
                //$geolocal; 
            }else{
                if(!$default_file) {
                  echo "Err: No access to Google service: ".$a."<br/>\n";
                }else {
                    //$result = strpos($a,'are') !== false ? true : false;
                    $get = simplexml_load_string($default_file);

                    if ($get->status == "OK") {
                        $lat = (float) $get->result->geometry->location->lat;
                        $long = (float) $get->result->geometry->location->lng;
                        //echo "lat: ".$lat."; long: ".$long."; ".$a."<br/>\n";
                        $geolocalx['latitude'] = $lat;
                        $geolocalx['longitude'] = $long;
                        //$geolocalx;
                    }else{      
                        echo "Err: address not found: ".$a."<br/>\n";
                    }
                }
            }
        }
$tb_mois = array("Jan","Fév","Mar","Avr","Mai","Jui","Jui","Août","Sep","Oct","Nov","Déc");

//debug($similaire);
//48 Bis Boulevard de Bercy, 75012 Paris, France
foreach ($detail_produit as $key => $value) {
    $id_salle = $value->id_salle;
    $id_produit = $value->id_produit;
    $photo  =  $value->photo;
    $pays = $value->pays;
    $ville = $value->ville;
    $adresse = $value->adresse;
    $cp = $value->cp;
    $titre = $value->titre;
    $date_arrivee = $value->date_arrivee;
    $date_depart = $value->date_depart;
    $prix = $value->prix;
    $description = $value->description;
    $categorie = $value->categorie;
    $capacite = $value->capacite;
}
$id_user=1;
if (isset($_SESSION['User'])) {
    $id_user = $this->Session->read('User')->id_membre;
}
$str = ' <br>';
$tb_note = array(1,2,3,4,5,6,7,8,9,10);
$html_addComent= '<div class="topavis">
     <p>Ajouter un commentaire</p>
    <form action="'.Router::url('avis/edit/'.$id_produit).'" method="post">
           <div class="col_1_of_middle span_1_of_middle">
                '.$this->Form->input('commentaire','commentaire', array('type'=>'textarea','required'=>true)).'
            </div>'.$this->Form->input('id_membre','hidden', array('value'=>$id_user)).'
            <div class="col_1_of_middle span_1_of_middle">
                '.$this->Form->input('note',"Note",array('type'=>'select','src'=>$tb_note,'required'=>true)).'
            </div>'.$this->Form->input('id_salle','hidden', array('value'=>$id_salle)).'
        
        <div class="actions">
            <input type="submit" class="btn primary" value="Soumettre">
        </div>

    </form>
</div>';
if (isset($avis)) {
    $html ='<div class="scrol">';
    if (sizeof($avis) == 0) {
        $nb_avis = 'Salle pas encore notée';
    }else{
        $nb_avis = $moyenne.'/10 moyenne sur '.sizeof($avis).'avis';
    }
    foreach ($avis as $key => $value){
        $html .='<p>
        Membre :'.$value->id_membre.'<br>
        Le ';
        $date = new Datetime($value->date);
        $html .= $date->format('d/m/Y H:i').'  
        la note attribuée : ('.$value->note.'/10) <br>
        Commentaire :'.$value->commentaire.'<br>
        ----------------------------------------------------------------------------------------
    </p>';
    
    }
    $html.='</div>';
}else{
    $html="ce produit n'a pas encore été noté";
}
?>

<script type="text/javascript">
    $(document).ready(function() {
        $(".dropdown img.flag").addClass("flagvisibility");

        $(".dropdown dt a").click(function() {
            $(".dropdown dd ul").toggle();
        });
                    
        $(".dropdown dd ul li a").click(function() {
            var text = $(this).html();
            $(".dropdown dt a span").html(text);
            $(".dropdown dd ul").hide();
            $("#result").html("Selected value is: " + getSelectedValue("sample"));
        });
                    
        function getSelectedValue(id) {
            return $("#" + id).find("dt a span.value").html();
        }

        $(document).bind('click', function(e) {
            var $clicked = $(e.target);
            if (! $clicked.parents().hasClass("dropdown"))
                $(".dropdown dd ul").hide();
        });


        $("#flagSwitcher").click(function() {
            $(".dropdown img.flag").toggleClass("flagvisibility");
        });
    });
 </script>
<script>
function initialize() {
  var latLng = new google.maps.LatLng(<?php echo floatval($geolocalx['latitude']);?>,<?php echo floatval($geolocalx['longitude']);?>);
  var mapProp = {
    center:latLng,
    zoom:15,
    mapTypeId:google.maps.MapTypeId.ROADMAP
  };
  var map=new google.maps.Map(document.getElementById("googleMap"), mapProp);
  var marker = new google.maps.Marker({
    position : latLng,
    map      : map,
    title    : "<?php echo $titre;?>"
    });
}
google.maps.event.addDomListener(window, 'load', initialize);
</script>
<script type="text/javascript">
     $(window).load(function() {
        $("#flexiselDemo1").flexisel();
        $("#flexiselDemo2").flexisel({
            enableResponsiveBreakpoints: true,
            responsiveBreakpoints: { 
                portrait: { 
                    changePoint:480,
                    visibleItems: 1
                }, 
                landscape: { 
                    changePoint:640,
                    visibleItems: 2
                },
                tablet: { 
                    changePoint:768,
                    visibleItems: 3
                }
            }
        });
    
        $("#flexiselDemo3").flexisel({
            visibleItems: 3,
            animationSpeed: 1000,
            autoPlay: true,
            autoPlaySpeed: 3000,            
            pauseOnHover: true,
            enableResponsiveBreakpoints: true,
            responsiveBreakpoints: { 
                portrait: { 
                    changePoint:480,
                    visibleItems: 1
                }, 
                landscape: { 
                    changePoint:640,
                    visibleItems: 2
                },
                tablet: { 
                    changePoint:768,
                    visibleItems: 3
                }
            }
        });
        
    });
</script>
<?php $url = BASE_URL."/webracine/js/jquery.flexisel.js";?>
<script type="text/javascript" src="<?php echo $url ;?>"></script>
         
<script type="text/javascript">
    $(document).ready(function() {
    
        var defaults = {
            containerID: 'toTop', // fading element id
            containerHoverID: 'toTopHover', // fading element hover id
            scrollSpeed: 1200,
            easingType: 'linear' 
        };
        
        
        $().UItoTop({ easingType: 'easeOutQuart' });
        
    });
</script>
<a href="#" id="toTop" style="display: block;"><span id="toTopHover" style="opacity: 1;"></span></a>



<div class="index-banner">
    <div class="wmuSliderWrapper">
        <article style="position: relative; width: 100%; opacity: 1;">
            <div class="banner-wrap">
                <div class="slider-left">
                    <img src="<?php echo BASE_URL."/webracine/images/".$photo;?>" alt=""/>  
                </div>
                 <div class="slider-right">
                    <h2><?php echo $titre;?></h2>
                    <h2><?php echo $ville;?></h2>
                    <h3>(<?php echo $nb_avis;?>)</h3>
                    <h3>capacité : <?php echo $capacite;?> personnes</h3>
                    <h3>Categorie : <?php echo $categorie;?></h3>
                    <h3><?php echo $description; echo $str ;?></h3>
                   <div class="btn">
                    <a href="<?php echo Router::url('connection/connexion_panier/'.$id_produit);?>">Ajouter au panier</a>
                    </div>
                 </div>
                 <div class="clear"></div>
            </div>
        </article>
    </div>
</div>
<div class="clear"></div>
<div class="main">
    <div class="wrap">
        <div class="content-bottom">
            <div class="clear"></div>
            
            <div class="box1">
                
                <div class="clear">
                </div>
                <div class="titre">
                    <p>
                        RESEVRATION EN DETAILS
                       
                    </p>

                </div>              
            </div>
            
            <div class="col_1_of_2 span_1_of_2 span_x colx">
                
                <div class="view view-fifth">
                    <div class="top_box">
                        <h3 class="m_1">Information complémentaires</h3>
                        
                        <h3>
                            Pays : <?php echo $pays;?><br> 
                            Ville : <?php echo $ville;?><br>
                            Adresse : <?php echo $adresse;?><br>
                            Cp : <?php echo $cp;?><br>
                            Date d'arrivée : <?php $date = new Datetime($date_arrivee); echo $date->format('d/m/Y H:i');?><br>
                            Date de départ : <?php $date = new Datetime($date_depart); echo $date->format('d/m/Y H:i');?><br>
                            Prix : <?php echo number_format($prix,2,",",".");?>&euro;<br>
                            *Ce prix est hors taxes.

                            
                        </h3>
                        <div><p class="m_2">
                            Geolocalisation</p>
                        </div>
                        <div class="clear"></div>
                         <div id="googleMap" style="width:100%;height:280px;" ></div>
                        
                    </div>

                </div>
                
                <div class="clear"></div>
                
            </div>
       
            <div class="col_1_of_2 span_1_of_2 col12 ">
                    
                <div class="view view-fifth ">

                    <div class="top_box">
                        <h3 class="m_1">Avis</h3>
                        <h3>(<?php echo $nb_avis;?>)</h3>
                        <?php echo $html ?>
                    </div>
                    <div class="clear"></div>
                   
                    <?php 
                        if (isset($_SESSION['User'])) {
                            echo $html_addComent;
                        }
                        
                    ?>
                </div>
                
                <div class="clear"></div>
            </div>
            <div class="clear">
            </div>
            
            <div class="titre">
                <p>
                    Autres Suggestions
                </p>
            </div>
        <div class="clear">
            </div>             
        <div class="cont span_2_of_3">
                <ul id="flexiselDemo3">
                    
                    <?php foreach ($similaire as $key => $value): ?>
                        <?php echo $value->capacite;?>
                        <li>
                            <img src="<?php echo BASE_URL."/webracine/images/".$value->photo;?>" alt=""/> 
                            <div class="grid-flex">
                                <a href="<?php echo Router::url("Visiteur/reservation_details/{$value->id_produit}"); ?>">
                                <?php 
                          
                               
                                
                                $date = new Datetime($value->date_arrivee);
                                $date_d = new Datetime($value->date_depart);
                                $a = $date->format('d/m/Y') ;
                                $d = $date_d->format('d/m/Y') ;
                                $ladate = 'Du '.explode('/', $a)[0].' '.$tb_mois[intval(explode('/', $a)[1])-1].' au  '.explode('/', $d)[0].' '.$tb_mois[intval(explode('/', $d)[1])-1].' '.explode('/', $a)[2];
                                echo $ladate.' - '.$value->titre.' '.$value->ville;
                                ?></a>
                               
                                <p><?php echo number_format($value->prix,2,",",".").'&euro; Pour * : '.$value->capacite;?> personnes</p>

                            </div>
                        </li>
                    <?php endforeach ?>
                          
                </ul>
            </div>
                <div class="clear"></div>
        </div>

    </div>
    <div class="clear">
            </div>
</div>
     <div class="clear">
     </div>