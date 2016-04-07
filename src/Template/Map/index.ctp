<div class="card">
    <div class="card-header">Interaktivní mapa
    </div>
    <div class="card-block">
        <div class="col-md-2"><span style="line-height: 2rem; text-align: center; min-width: 130px">Zobrazené období</span></div>
        <div class="col-md-8">
        <input id="pick-year" type="text" data-slider-min="<?= adodb_mktime(0, 0, 0, 1, 1, 1920) ?>"
               data-slider-max="<?= adodb_mktime(0, 0, 0, 12, 31, 2015) ?>" data-slider-step="86400"
               data-slider-value="<?= adodb_mktime(0, 0, 0, 10, 5, 1968) ?>">
        </div>
        <div class="col-md-2" style="padding-left: 0">
        <input type="date" value="1968-10-05" id="pick-year-val" min="1920-01-01" max="2015-12-31">
        </div>
        <div class="clearfix"></div>
        <script>
            var delay = ( function() {
                var timer = 0;
                return function(callback, ms) {
                    clearTimeout (timer);
                    timer = setTimeout(callback, ms);
                };
            })();

            $("#pick-year").slider();
            $("#pick-year").on("change", function (slideEvt) {
                delay(function(){
                    $.ajax({
                        url: 'map',
                        type: 'get',
                        data: {"float": slideEvt.value.newValue},
                        success: function (response) {
                            $("#pick-year-val").val(response);
                        }
                    });
                }, 50 );
            });

            $("#pick-year-val").on("change", function() {
                delay(function(){
                $.ajax({
                    url: 'map',
                    type: 'get',
                    dataType: "text",
                    data: {"float": $("#pick-year-val").val(), "funct": 'mktime'},
                    success: function (converted) {
                        $("#pick-year").slider().slider("setValue", parseInt(converted));
                    }
                });
                }, 500 );
            })
        </script>
    </div>
    <?= $this->Html->script('markerclusterer.js', array('type' => 'text/javascript')) ?>
    <div class="card-block card-map" id="map">
        <script>
            var map;
            function initMap() {
                map = new google.maps.Map(document.getElementById('map'), {
                    center: {lat: 49.406620, lng: 13.905871},
                    zoom: 8
                });

                var mcOptions = {gridSize: 50, maxZoom: 15};
                var mc = new MarkerClusterer(map, [], mcOptions);

                var centerControlDiv = document.createElement('div');
                var centerControl = new CenterControl(centerControlDiv, map);

                centerControlDiv.index = 1;
                map.controls[google.maps.ControlPosition.BOTTOM_CENTER].push(centerControlDiv);

                var text1content = '<h6>test textového příspěvku</h6><br>' + '<span class="text-muted">typ: text<br>souborů: 1</span>';
                var text1infowindow = new google.maps.InfoWindow({
                    content: text1content
                });
                var audio1content = '<?php echo $this->Html->link(__('<h6>test audio příspěvku</h6><br>'), [
                        'controller' => 'Articles',
                        'action' => 'detail',
                        10
                    ], array('target' => '_blank', 'escape' => false)) ?>' + '<span class="text-muted">typ: audio<br>souborů: 1</span>';
                var audio1infowindow = new google.maps.InfoWindow({
                    content: audio1content
                });
                var video1content = '<h6>test video příspěvku</h6><br>' + '<span class="text-muted">typ: video<br>souborů: 2</span>';
                var video1infowindow = new google.maps.InfoWindow({
                    content: video1content
                });
                var image1content = '<h6>test image příspěvku</h6><br>' + '<span class="text-muted">typ: obrázek<br>souborů: 5</span>';
                var image1infowindow = new google.maps.InfoWindow({
                    content: image1content
                });

                var textmarker = 'd9534f';
                var audiomarker = '0275d8';
                var videomarker = '5cb85c';
                var imagemarker = 'f0ad4e';

                var textmarker1 = new google.maps.Marker({
                    position: {lat: 48.9622271, lng: 14.5141815},
                    map: map,
                    icon: 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|' + textmarker
                });

                textmarker1.addListener('click', function () {
                    video1infowindow.close(map);
                    audio1infowindow.close(map);
                    image1infowindow.close(map);
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
                    image1infowindow.close(map);
                    text1infowindow.open(map, textmarker2);
                });

                var imagemarker1 = new google.maps.Marker({
                    position: {lat: 49.378962, lng: 13.275344},
                    map: map,
                    icon: 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|' + imagemarker
                });

                imagemarker1.addListener('click', function () {
                    image1infowindow.open(map, imagemarker1);
                    video1infowindow.close(map);
                    text1infowindow.close(map);
                    audio1infowindow.close(map);
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
                    image1infowindow.close(map);
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
                    image1infowindow.close(map);
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
                    controlDiv.appendChild(controlUI);

                    // Set CSS for the control interior.
                    var controlText = document.createElement('div');
                    controlText.style.color = 'rgb(25,25,25)';
                    controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
                    controlText.style.fontSize = '16px';
                    controlText.style.lineHeight = '38px';
                    controlText.style.paddingLeft = '5px';
                    controlText.style.paddingRight = '5px';
                    controlText.innerHTML = '<span id="play-pause-btn" style="margin-right: 1rem"><?= $this->html->image('play-pause-btn.png', array('style' => 'height:1.5rem', 'title' => 'Přehrát/Pozastavit')) ?></span>' +
                        '<span id="stop-btn"><?= $this->html->image('stop-btn.png', array('style' => 'height:1.5rem', 'title' => 'Zastavit')) ?></span>';
                    controlUI.appendChild(controlText);

                    // Setup the click event listeners
                    controlUI.addEventListener('click', function () {
                    });

                }

            }
        </script>
        <script
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDcDBMIqB9QnfD3wks9zVI2WUSHLnbU9so&callback=initMap"
            async defer></script>
    </div>
    <div class="card-block">
        <div class="collapse" id="filterOptions">
            <div class="row p-b-1">
                <h5>Filtry zobrazení:</h5>
                <div class="bg-primary map-filter col-md-3"><span class="p-x-1"><i
                            class="fa fa-music"> </i> Audio</span>
            <span class="p-x-1 pull-right">
                <label class="c-input c-checkbox">
                    <input type="checkbox" id="filter-audio" checked>
                    <span class="c-indicator"></span>
                </label>
            </span>
                </div>
                <div class="bg-success map-filter col-md-3"><span class="p-x-1"><i class="fa fa-film"> </i> Video</span>
            <span class="p-x-1 pull-right">
                <label class="c-input c-checkbox">
                    <input type="checkbox" id="filter-video" checked>
                    <span class="c-indicator"></span>
                </label>
            </span>
                </div>
                <div class="bg-warning map-filter col-md-3"><span class="p-x-1"><i
                            class="fa fa-picture-o"> </i> Foto</span>
            <span class="p-x-1 pull-right">
                <label class="c-input c-checkbox">
                    <input type="checkbox" id="filter-foto" checked>
                    <span class="c-indicator"></span>
                </label>
            </span>
                </div>
                <div class="bg-danger map-filter col-md-3"><span class="p-x-1"><i
                            class="fa fa-quote-right"> </i> Text</span>
            <span class="p-x-1 pull-right">
                <label class="c-input c-checkbox">
                    <input type="checkbox" id="filter-text" checked>
                    <span class="c-indicator"></span>
                </label>
            </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 text-left">
                <button class="btn btn-primary btn-middle" type="button" data-toggle="collapse"
                        data-target="#filterOptions"
                        aria-expanded="false" aria-controls="collapseExample">
                    <i class="fa fa-filter"> </i> <span class="hidden-xs-down">Nastavení filtrů</span>
                </button>
            </div>
            <div class="col-xs-6 text-right">
                <button class="btn btn-primary btn-middle" type="button" data-toggle="collapse"
                        data-target="#animationOptions" aria-expanded="false" aria-controls="collapseExample">
                    <i class="fa fa-cog"> </i> <span class="hidden-xs-down">Možnosti animace</span>
                </button>
            </div>
        </div>
        <div class="collapse" id="animationOptions">
            <hr>
            <h5>Zobrazované časové období</h5>
            <div class="select-year">

                <div class="col-xs-12" style="padding-left: 0; padding-right: 0">
                    <input id="slider-year" type="text" class="slider slider-horizontal span2" value=""
                           data-slider-min="1700" data-slider-max="2016"
                           data-slider-step="1" data-slider-value="[1810,1920]" style="width: 100%"/>
                </div>
                <div class="col-xs-6" style="padding-left: 0">
                    <div style="padding-left: 0">
                        <input type="date" value="1968-10-05" id="pick-year-val" min="1920-01-01" max="2015-12-31" style="width: 9.5rem">
                    </div>
                </div>
                <div class="col-xs-6" style="text-align: right; padding-right: 0">
                    <div style="float: right; padding-right: 0">
                        <input type="date" value="1968-10-05" id="pick-year-val" min="1920-01-01" max="2015-12-31" style="width: 9.5rem">
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
            <a href="#" class="btn btn-primary">Uložit nastavení</a>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">Legenda
    </div>
    <div class="card-block">
        <div class="row">
            <div class="col-sm-6">
                <p><?= $this->Html->image('http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|d9534f', array('alt' => 'Text marker')); ?>
                    - text / textové soubory</p>
                <p><?= $this->Html->image('http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|f0ad4e', array('alt' => 'Image marker')); ?>
                    - obrazové soubory</p>
                <p><?= $this->Html->image('http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|0275d8', array('alt' => 'Audio marker')); ?>
                    - audio soubory</p>
                <p><?= $this->Html->image('http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|5cb85c', array('alt' => 'Video marker')); ?>
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
</div>