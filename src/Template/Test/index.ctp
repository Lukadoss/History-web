<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body>
<div class="card card-block">
    <h4 class="card-title">Test obsahu</h4>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's
        content.</p>
</div>
<div class="card card-block">
    <h4 class="card-title">Test slideru</h4>
    <div class="select-year">
        <span id="slider-year-val-min">1000 </span>
        <span>
            <input id="slider-year" type="text" class="span2" value="" data-slider-min="666" data-slider-max="2016"
               data-slider-step="1" data-slider-value="[1000,1200]"/>
        </span>
        <span id="slider-year-val-max">1200 </span>

        <script>
            // Instantiate a slider
            $("#slider-year").slider({});

            $("#slider-year").on("slide", function(slideEvt) {
                $("#slider-year-val-min").text(slideEvt.value[0]);
                $("#slider-year-val-max").text(slideEvt.value[1]);
            });

        </script>
    </div>
</div>
<div class="card card-map" id="map">
    <script>
        var map;
        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: 48.9622271, lng: 14.5141815},
                zoom: 8
            });

            var contentString = '<div id="content">'+
                    '<div id="siteNotice">'+
                    '</div>'+
                    '<h1 id="firstHeading" class="firstHeading">Uluru</h1>'+
                    '<div id="bodyContent">'+
                    '<p><b>Uluru</b>, also referred to as <b>Ayers Rock</b>, is a large ' +
                    'sandstone rock formation in the southern part of the '+
                    'Northern Territory, central Australia. It lies 335&#160;km (208&#160;mi) '+
                    'south west of the nearest large town, Alice Springs; 450&#160;km '+
                    '(280&#160;mi) by road. Kata Tjuta and Uluru are the two major '+
                    'features of the Uluru - Kata Tjuta National Park. Uluru is '+
                    'sacred to the Pitjantjatjara and Yankunytjatjara, the '+
                    'Aboriginal people of the area. It has many springs, waterholes, '+
                    'rock caves and ancient paintings. Uluru is listed as a World '+
                    'Heritage Site.</p>'+
                    '<p>Attribution: Uluru, <a href="https://en.wikipedia.org/w/index.php?title=Uluru&oldid=297882194">'+
                    'https://en.wikipedia.org/w/index.php?title=Uluru</a> '+
                    '(last visited June 22, 2009).</p>'+
                    '</div>'+
                    '</div>';

            var infowindow = new google.maps.InfoWindow({
                content: contentString
            });

            infowindow.open(map, {lat: 48.9622271, lng: 14.5141815});
        }



        infowindow.open(map, {lat: 48.9622271, lng: 14.5141815});
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDcDBMIqB9QnfD3wks9zVI2WUSHLnbU9so&callback=initMap"
            async defer></script>
</div>
<div class="card card-block">
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's
        content.</p>
    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
    <a href="#" class="btn btn-primary">Button</a>
</div>
</body>
</html>