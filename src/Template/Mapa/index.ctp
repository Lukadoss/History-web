<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body>
<div class="card card-block card-map-header">
    <h4 class="card-title">Interaktivní mapa</h4>
    <input id="pick-year" type="text" data-slider-min="1700" data-slider-max="2016" data-slider-step="1" data-slider-value="1810">
    <span id="pick-year-val">1810</span>

    <script>
        $("#pick-year").slider();
        $("#pick-year").on("slide", function (slideEvt) {
            $("#pick-year-val").text(slideEvt.value);
        });
    </script>
</div>
<div class="card-map" id="map">
    <script>
        var map;
        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: 49.406620, lng: 13.905871},
                zoom: 8
            });


            var centerControlDiv = document.createElement('div');
            var centerControl = new CenterControl(centerControlDiv, map);

            centerControlDiv.index = 1;
            map.controls[google.maps.ControlPosition.BOTTOM_CENTER].push(centerControlDiv);

            var text1content = '<h6>test textového příspěvku</h6><br>' + '<img src="http://data.filek.cz/cat.gif" width="100px">';
            var text1infowindow = new google.maps.InfoWindow({
                content: text1content
            });
            var audio1content = '<h6>test audio příspěvku</h6><br>' + '<img src="http://data.filek.cz/cat.gif" width="100px">';
            var audio1infowindow = new google.maps.InfoWindow({
                content: audio1content
            });
            var video1content = '<h6>test video příspěvku</h6><br>' + '<img src="http://data.filek.cz/cat.gif" width="100px">';
            var video1infowindow = new google.maps.InfoWindow({
                content: video1content
            });

            var textmarker = 'e60000';
            var audiomarker = '0066ff';
            var videomarker = '008000';

            var textmarker1 = new google.maps.Marker({
                position: {lat: 48.9622271, lng: 14.5141815},
                map: map,
                icon: 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|' + textmarker
            });

            textmarker1.addListener('click', function () {
                video1infowindow.close(map);
                audio1infowindow.close(map);
                text1infowindow.open(map, textmarker1);
            });

            var textmarker2 = new google.maps.Marker({
                position: {lat: 48.8622271, lng: 14.7141815},
                map: map,
                icon: 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|' + textmarker
            });

            textmarker2.addListener('click', function () {
                video1infowindow.close(map);
                audio1infowindow.close(map);
                text1infowindow.open(map, textmarker2);
            });

            var audiomarker1 = new google.maps.Marker({
                position: {lat: 49.7188805, lng: 13.3593384},
                map: map,
                icon: 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|' + audiomarker
            });

            audiomarker1.addListener('click', function () {
                audio1infowindow.open(map, audiomarker1);
                video1infowindow.close(map);
                text1infowindow.close(map);
            });

            var videomarker1 = new google.maps.Marker({
                position: {lat: 49.420338, lng: 13.878407},
                map: map,
                icon: 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|' + videomarker
            });

            videomarker1.addListener('click', function () {
                video1infowindow.open(map, videomarker1);
                audio1infowindow.close(map);
                text1infowindow.close(map);
            });

            function CenterControl(controlDiv, map) {

                // Set CSS for the control border.
                var controlUI = document.createElement('div');
                controlUI.style.backgroundColor = '#fff';
                controlUI.style.border = '2px solid #fff';
                controlUI.style.borderRadius = '3px';
                controlUI.style.boxShadow = '0 1px 3px rgba(0,0,0,.3)';
                controlUI.style.cursor = 'pointer';
                controlUI.style.marginBottom = '22px';
                controlUI.style.textAlign = 'center';
                controlUI.title = 'Ovládání animací';
                controlDiv.appendChild(controlUI);

                // Set CSS for the control interior.
                var controlText = document.createElement('div');
                controlText.style.color = 'rgb(25,25,25)';
                controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
                controlText.style.fontSize = '16px';
                controlText.style.lineHeight = '38px';
                controlText.style.paddingLeft = '5px';
                controlText.style.paddingRight = '5px';
                controlText.innerHTML = '<span id="play-pause-btn" style="margin-right: 1rem"><?= $this->html->image('play-pause-btn.png', array('style' => 'height:1.5rem'), ['alt' => 'Přehrát/Pozastavit']) ?></span>' +
                    '<span id="stop-btn"><?= $this->html->image('stop-btn.png', array('style' => 'height:1.5rem'), ['alt' => 'Přehrát/Pozastavit']) ?></span>';
                controlUI.appendChild(controlText);

                // Setup the click event listeners: simply set the map to Chicago.
                controlUI.addEventListener('click', function () {
                    map.setCenter(chicago);
                });

            }

        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDcDBMIqB9QnfD3wks9zVI2WUSHLnbU9so&callback=initMap"
            async defer></script>
</div>
<div class="card card-block card-map-footer">
    <div class="text-center">
        <button class="btn btn-primary btn-middle" type="button" data-toggle="collapse" data-target="#animationOptions" aria-expanded="false" aria-controls="collapseExample">
            Možnosti animace
        </button>
    </div>
    <div class="collapse" id="animationOptions">
        <h5>Zobrazované časové období</h5>
        <div class="select-year">

            <div class="col-xs-12" style="padding-left: 0; padding-right: 0">
                <input id="slider-year" type="text" class="slider slider-horizontal span2" value="" data-slider-min="1700" data-slider-max="2016"
                       data-slider-step="1" data-slider-value="[1810,1920]" style="width: 100%"/>
            </div>
            <div class="col-xs-6" style="padding-left: 0">
                <div class="col-xs-3" style="padding-left: 0">
                    <input class="form-control" style="min-width: 4rem" type="text" id="slider-year-val-min" value="1810"/>
                </div>
            </div>
            <div class="col-xs-6" style="text-align: right; padding-right: 0">
                <div class="col-xs-3" style="float: right; padding-right: 0">
                    <input class="form-control" style="text-align: right; min-width: 4rem; float: right" type="text" id="slider-year-val-max" value="1920"/>
                </div>
            </div>
            <script>
                $("#slider-year").slider({});

                $("#slider-year").on("slide", function (slideEvt) {
                    $("#slider-year-val-min").val(slideEvt.value[0]);
                    $("#slider-year-val-max").val(slideEvt.value[1]);
                });

                $("$sli")
            </script>

        </div>

        <hr>
        <h5>Rychlost animace</h5>
        <label class="c-input c-radio">
            <input id="radio1" name="radio" type="radio" checked>
            <span class="c-indicator"></span>
            1x
        </label>
        <label class="c-input c-radio">
            <input id="radio2" name="radio" type="radio">
            <span class="c-indicator"></span>
            2x
        </label>
        <label class="c-input c-radio">
            <input id="radio3" name="radio" type="radio">
            <span class="c-indicator"></span>
            5x
        </label>
        <hr>
        <a href="#" class="btn btn-primary">Animuj ty čubo!!!</a>
    </div>
</div>
<div class="card card-block">
    <h4 class="card-title">Legenda</h4>
    <div class="row">
        <div class="col-sm-6">
            <p><?= $this->Html->image('http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|e60000', array('alt' => 'Text marker')); ?>
                - text / textové soubory</p>
            <p><?= $this->Html->image('http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|0066ff', array('alt' => 'Audio marker')); ?>
                - audio soubory</p>
            <p><?= $this->Html->image('http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|008000', array('alt' => 'Video marker')); ?>
                - video soubory</p>
        </div>
        <div class="col-sm-6">
            <p><?= $this->html->image('play-pause-btn.png', array('style' => 'height:1.5rem'), ['alt' => 'Přehrát/Pozastavit']) ?>
                - tlačítko přehrání/pozastavení animace</p>
            <p><?= $this->html->image('stop-btn.png', array('style' => 'height:1.5rem'), ['alt' => 'Přehrát/Pozastavit']) ?>
                - tlačítko vypnutí animace</p>
        </div>
    </div>
</div>
</body>
</html>