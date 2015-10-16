<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL.'/webracine/styles/table.css';?>">
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL.'/webracine/styles/style.css';?>"  media="all" />
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL.'/webracine/styles/megamenu.css';?>"  media="all" />
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL.'/webracine/styles/pieddepage.css';?>">

        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
       
        <script type="text/javascript" src="<?php echo BASE_URL.'/webracine/js/sorttable.js';?>"></script>
        
        <script type="text/javascript" src="<?php echo BASE_URL.'/webracine/js/jquery.min.js';?>"></script>
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
        <script type="text/javascript" src="<?php echo BASE_URL.'/webracine/js/jquery.jscrollpane.min.js';?>"></script>
        <script type="text/javascript" id="sourcecode">
            $(function()
            {
                $('.scroll-pane').jScrollPane();
            });
        </script>
        <!----details-product-slider--->
                <!-- Include the Etalage files -->
        <link rel="stylesheet" href="<?php echo BASE_URL.'/webracine/styles/etalage.css';?>">
        <script src="<?php echo BASE_URL.'/webracine/js/jquery.etalage.min.js';?>"></script>
                <!-- Include the Etalage files -->
        <script>
            jQuery(document).ready(function($){

                $('#etalage').etalage({
                    thumb_image_width: 300,
                    thumb_image_height: 400,
                    
                    show_hint: true,
                    click_callback: function(image_anchor, instance_id){
                        alert('Callback example:\nYou clicked on an image with the anchor: "'+image_anchor+'"\n(in Etalage instance: "'+instance_id+'")');
                    }
                });
                // This is for the dropdown list example:
                $('.dropdownlist').change(function(){
                    etalage_show( $(this).find('option:selected').attr('class') );
                });

            });
        </script>
                <!----//details-product-slider--->  
        <!-- top scrolling -->
        <script src="http://maps.googleapis.com/maps/api/js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL.'/webracine/js/move-top.js';?>"></script>
        <script type="text/javascript" src="<?php echo BASE_URL.'/webracine/js/easing.js';?>"></script>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                $(".scroll").click(function(event){     
                    event.preventDefault();
                    $('html,body').animate({scrollTop:$(this.hash).offset().top},1200);
                });
            });
        </script>       
    </head>
<body>



    <?php //debug($_SESSION);
    
    ?>
    <?php require 'menu.inc.php'; ?>
    
    <?php /*
        if (!isset($_SESSION['User'])) {
            $this->Session->flash();
        } */
        //debug($this->Session->flash());
    ?>
    
    <div class="content_for_layout">
        <?php  echo $this->Session->flash();?>
        <?php  echo $content_for_layout;?>
        
    </div>
    
    
    <!-- div>
        <a href="<?php echo Router::url('connection/logout');?>">se déconncter</a>
    </div>
    <div>
        <a href="<?php echo Router::url('');?>">Page d'acceil</a>
    </div -->

<div class="footer-middle">
    <div class="wrap">
        <div class="section group">
            <div class="col_1_of_5 span_1_of_5">
                <h3 class="m_9">Raison social</h3>
            </div>
            <div class="col_1_of_5 span_1_of_5">
                <h3 class="m_9">Type de structure </h3>
            </div>
            <div class="col_1_of_5 span_1_of_5">
                <h3 class="m_9">Adresse</h3>
            </div>
            <div class="col_1_of_5 span_1_of_5">
                <h3 class="m_9">Mission</h3>
            </div>
            <div class="col_1_of_5 span_1_of_5">
                <h3 class="m_9">Péromètre géographique:</h3>
            </div>
            <div class="clear"></div>
    
        </div>
    </div>
</div>
<div class="footer">
<?php require 'bas.inc.php'; ?>
</div>
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
</body>
</html>
