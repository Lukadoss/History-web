<?= $this->Html->script('markerclusterer.js') ?>
<div class="card">
    <div class="card-header">Interaktivní mapa
    </div>
    <div class="card-block">
        <div class="col-md-2"><span
                style="line-height: 2rem; text-align: center; min-width: 130px">Zobrazené období</span></div>
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
            var delay = (function () {
                var timer = 0;
                return function (callback, ms) {
                    clearTimeout(timer);
                    timer = setTimeout(callback, ms);
                };
            })();

            $("#pick-year").slider();
            $("#pick-year").on("change", function (slideEvt) {
                delay(function () {
                    $.ajax({
                        url: 'map',
                        type: 'get',
                        data: {"float": slideEvt.value.newValue},
                        success: function (response) {
                            $("#pick-year-val").val(response);
                        }
                    });
                }, 50);
            });

            $("#pick-year-val").on("change", function () {
                delay(function () {
                    $.ajax({
                        url: 'map',
                        type: 'get',
                        dataType: "text",
                        data: {"float": $("#pick-year-val").val(), "funct": 'mktime'},
                        success: function (converted) {
                            $("#pick-year").slider().slider("setValue", parseInt(converted));
                        }
                    });
                }, 500);
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
                    zoom: 8,
                    minZoom: 3
                });

                var markers = new Array();
                var marker_data = '<?php echo json_encode($sources); ?>';
                var marker_obj_data = JSON.parse(marker_data);
                var markerColor;

                var centerControlDiv = document.createElement('div');
                var centerControl = new CenterControl(centerControlDiv, map);

                centerControlDiv.index = 1;
                map.controls[google.maps.ControlPosition.BOTTOM_CENTER].push(centerControlDiv);

                var content, fileType;
                var infowindow = new google.maps.InfoWindow(
                {
                    content: content
                });
                var i;
                for(i in marker_obj_data){
                    if(marker_obj_data[i].type == 'text') {
                        markerColor = 'd9534f';
                        fileType = 'Textový dokument';
                    }
                    else if (marker_obj_data[i].type == 'audio') {
                        markerColor = '0275d8';
                        fileType = 'Audio';
                    }
                    else if (marker_obj_data[i].type == 'video') {
                        markerColor = '5cb85c';
                        fileType = 'Video';
                    }
                    else if (marker_obj_data[i].type == 'image') {
                        markerColor = 'f0ad4e';
                        fileType = 'Obrázky';
                    }

                    var marker = new google.maps.Marker({
                        position: {lat: marker_obj_data[i].lat, lng: marker_obj_data[i].lng},
                        map: map,
                        icon: 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|' + markerColor
                    });

                    content = '<h6><a href="/historyweb/articles/detail/' + marker_obj_data[i].source_id + '" target="_blank" class="nav-link">' + marker_obj_data[i].name + '</a></h6><br>'
                        + '<span class="text-muted">typ: ' + fileType
                        + '<br>Počet souborů: x</span>';
                    setInfoWindow(marker, content);

                    markers.push(marker);
                }

                function setInfoWindow(marker, content){
                    google.maps.event.addListener(marker,'click', function(){
                        infowindow.setContent(content);
                        infowindow.open(map, this);

                    });
                }

                var mcOptions = {
                    gridSize: 20, maxZoom: 15, averageCenter: true, styles: [{
                        textColor: 'white',
                        textSize: 14,
                        height: 40,
                        url: "/historyweb/img/mc/m1.png",
                        width: 40
                    },
                        {
                            textColor: 'white',
                            height: 45,
                            url: "/historyweb/img/mc/m2.png",
                            width: 45
                        },
                        {
                            textColor: 'white',
                            height: 50,
                            url: "/historyweb/img/mc/m3.png",
                            width: 50
                        },
                        {
                            textColor: 'white',
                            height: 58,
                            url: "/historyweb/img/mc/m4.png",
                            width: 58
                        },
                        {
                            textColor: 'white',
                            height: 70,
                            url: "/historyweb/img/mc/m5.png",
                            width: 70
                        }]/*, imagePath: */
                };

                var mc = new MarkerClusterer(map, markers, mcOptions);

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

            function setMarkers (){

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
                            class="fa fa-picture-o"> </i> Obrázky</span>
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
                        <input type="date" value="1968-10-05" id="pick-year-val" min="1920-01-01" max="2015-12-31"
                               style="width: 9.5rem">
                    </div>
                </div>
                <div class="col-xs-6" style="text-align: right; padding-right: 0">
                    <div style="float: right; padding-right: 0">
                        <input type="date" value="1968-10-05" id="pick-year-val" min="1920-01-01" max="2015-12-31"
                               style="width: 9.5rem">
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