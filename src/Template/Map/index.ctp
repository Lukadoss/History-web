<?= $this->Html->script('markerclusterer.js') ?>
<div class="card">
    <div class="card-header">Interaktivní mapa
    </div>
    <div class="card-block">
        <div class="col-md-2"><span
                style="line-height: 2rem; text-align: center; min-width: 130px">Zobrazené období</span></div>
        <div class="col-md-8">
            <input id="pick-year" type="text"
                   data-slider-min="<?= adodb_mktime(0, 0, 0, $oldest[1], $oldest[2], $oldest[0]) ?>"
                   data-slider-max="<?= adodb_mktime(0, 0, 0, $current[1], $current[2], $current[0]) ?>"
                   data-slider-step="86400"
                   data-slider-value="<?= adodb_mktime(0, 0, 0, $oldest[1], $oldest[2], $oldest[0]) ?>">
        </div>
        <div class="col-md-2" style="padding-left: 0">
            <input type="date" value="<?php echo $oldest[0] . "-" . $oldest[1] . "-" . $oldest[2]?>" id="pick-year-val" min="<?php echo $oldest[0] . "-" . $oldest[1] . "-" . $oldest[2]?>" max="<?php echo $current[0] . "-" . $current[1] . "-" . $current[2]?>">
        </div>
        <div class="clearfix"></div>
        <script>
            /*
                Function for delaying another function call
             */
            var delay = (function () {
                var timer = 0;
                return function (callback, ms) {
                    clearTimeout(timer);
                    timer = setTimeout(callback, ms);
                };
            })();

            /*
                Initializing the plugin javascript slider.

                Adding an event listener for slider change, to refresh the value in the related date input
                and setting the approptiate markers on map
             */
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
                    clearMapMarkers();
                    setMarkers(marker_obj_data, activeMarkers, document.getElementById("pick-year-val").value);
                }, 50);

            });

            /*
                Event listener for adjusting the slider value based on changed date input
                Setting the appropriate markers on map based on the selected date from the date input
             */
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
                    clearMapMarkers();
                    setMarkers(marker_obj_data, activeMarkers, document.getElementById("pick-year-val").value);
                }, 300);

            })
        </script>
    </div>
    <?= $this->Html->script('markerclusterer.js', array('type' => 'text/javascript')) ?>
    <div class="card-block card-map" id="map">
        <script>
            /*
                Google Maps Api v3 javascript, MarkerClusterer initialization, Map animation functions

             */
            var map, infoWindow, clusterInfoWindow;
            var activeMarkers = [];
            var marker_data = '<?php echo json_encode($sources); ?>';
            var marker_obj_data = JSON.parse(marker_data);
            var mc;
            var filterSettings = {audio: 1, video: 1, image: 1, text: 1}; //audio, video, image, text
            var interval;
            var animSpeed = 1;

            var mcOptions = {
                gridSize: 30, maxZoom: 21, averageCenter: true, styles: [{
                    textColor: 'white',
                    textSize: 14,
                    height: 40,
                    url: getBaseUrl() + "img/mc/m1.png",
                    width: 40
                },
                    {
                        textColor: 'white',
                        height: 45,
                        url: getBaseUrl() + "img/mc/m2.png",
                        width: 45
                    },
                    {
                        textColor: 'white',
                        height: 50,
                        url: getBaseUrl() + "img/mc/m3.png",
                        width: 50
                    },
                    {
                        textColor: 'white',
                        height: 58,
                        url: getBaseUrl() + "img/mc/m4.png",
                        width: 58
                    },
                    {
                        textColor: 'white',
                        height: 70,
                        url: getBaseUrl() + "img/mc/m5.png",
                        width: 70
                    }]/*, imagePath: */
            };

            /*
                Initialization of the whole map provided by Google Maps Api v3.
                Adding a custom control element containing animation controls.
                Adding default markers on map, based on default date.
             */
            function initMap() {
                map = new google.maps.Map(document.getElementById('map'), {
                    center: {lat: 49.406620, lng: 13.905871},
                    zoom: 8,
                    minZoom: 3,
                    fullscreenControl: false
                });

                var centerControlDiv = document.createElement('div');
                var centerControl = new CenterControl(centerControlDiv, map);

                centerControlDiv.index = 1;
                map.controls[google.maps.ControlPosition.BOTTOM_CENTER].push(centerControlDiv);

                infoWindow = new google.maps.InfoWindow(
                    {
                        maxWidth: 400
                    });

                clusterInfoWindow = new google.maps.InfoWindow(
                    {
                        pixelOffset: new google.maps.Size(0, -30),
                        maxWidth: 400
                    });

                setMarkers(marker_obj_data, activeMarkers, document.getElementById("pick-year-val").value);
            }

            /*
                Function for specifying the custom map control element and its inner HTML containing the animation control buttons
             */
            function CenterControl(controlDiv, map) {

                // Set CSS for the control border.
                var controlUI = document.createElement('div');
                controlUI.style.backgroundColor = '#fff';
                controlUI.style.border = '2px solid #fff';
                controlUI.style.borderRadius = '3px';
                controlUI.style.boxShadow = '0 1px 3px rgba(0,0,0,.3)';
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
                controlText.innerHTML = '<a id="play-pause-btn" style="margin-right: 1rem"><?= $this->html->image('play-pause-btn.png', array('style' => 'height:1.5rem', 'title' => 'Přehrát/Pozastavit', 'id' => 'play-animation', 'onclick' => 'startAnimation()')) ?></a>' +
                    '<a id="stop-btn"><?= $this->html->image('stop-btn.png', array('style' => 'height:1.5rem', 'title' => 'Zastavit', 'id' => 'anim-stop', 'onclick' => 'stopAnimation()')) ?></a>';
                controlUI.appendChild(controlText);

                // Setup the click event listeners
                controlUI.addEventListener('click', function () {

                });


            }

            /*
                Function for setting a map value for every marker in passed array
            */
            function setMarkerMap(map, markers) {
                for (var i = 0; i < markers.length; i++) {
                    markers[i].setMap(map);
                }
            }

            /*
                Dynamically getting the base URL of website, for creating dynamic links
            */
            function getBaseUrl() {
                var re = new RegExp(/^.*\//);
                return re.exec(window.location.href);
            }

            /*
                Function for string escaping, preventing XSS attacks
            */
            function escapeHtml(text) {
                return text
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;")
                    .replace(/"/g, "&quot;")
                    .replace(/'/g, "&#039;");
            }

            function startAnimation() {
                var timesRun = 0;
                var jump = 1;
                document.getElementById("pick-year-val").value = document.getElementById("pick-year-val-min").value;
                interval = setInterval(function(){
                    var days = convertToDays(new Date(document.getElementById("pick-year-val-min").value), new Date(document.getElementById("pick-year-val-max").value));
                    if (days>365 && days<3650) jump = 30;
                    else if(days>3650) jump = 365;
                    else jump = 1;

                    if(days === timesRun){
                        clearInterval(interval);
                    }else{
                        clearMapMarkers();
                        var date = new Date(document.getElementById("pick-year-val").value);
                        date.setDate(date.getDate()+jump);
                        document.getElementById("pick-year-val").value = date.toISOString().substr(0,10);
                        console.log(date.toISOString().substr(0,10));
                        setMarkers(marker_obj_data, activeMarkers, document.getElementById("pick-year-val").value);
                    }
                    timesRun+=1;
                }, 3000/animSpeed);
            }

            function stopAnimation(){
                clearInterval(interval);
            }

            function convertToDays(mindate, maxdate){
                var oneDay = 24*60*60*1000;
                return Math.round(Math.abs((mindate.getTime() - maxdate.getTime()) / (oneDay)));
            }

            /*
                Removes the markers from the map, aswell as from the array of active markers.
            */
            function clearMapMarkers() {
                mc.clearMarkers();
                setMarkerMap(null, activeMarkers);
                activeMarkers = [];
            }

            function setSpeed(){
                animSpeed = $("input[name='radio']:checked").val();
                console.log(animSpeed);
            }

            /*
                Function for creating an info window for passed marker
             */
            function setInfoWindow(marker, content) {
                google.maps.event.addListener(marker, 'click', function () {
                    infoWindow.setContent(content);
                    clusterInfoWindow.close();
                    infoWindow.open(map, this);
                });
            }

            /*
                Function that selects markers by appropriate date, pushing them into an array of active markers
                An info window is created for each of the active marker, aswell as setting the right color depending on the source type
                Function then sets all the active markers on map.
             */
            function setMarkers(marker_obj_data, activeMarkers, currentDate) {
                var markerColor, fileType, i, content;
                activeMarkers = [];
                for (i in marker_obj_data) {
                    var markerDateFrom = new Date(marker_obj_data[i].date_from).toISOString().slice(0, 10);
                    var markerDateTo = new Date(marker_obj_data[i].date_to).toISOString().slice(0, 10);
                    //var formattedDate = markerDate.getFullYear() + "-" + (markerDate.getMonth()+1) + "-" + markerDate.getDate();

                    if (markerDateFrom == currentDate || (markerDateFrom <= currentDate && markerDateTo >= currentDate)) {
                        var filterChecker = true;

                        if (marker_obj_data[i].isText == false && marker_obj_data[i].isAudio == false && marker_obj_data[i].isVideo == false && marker_obj_data[i].isImage == false) {
                            markerColor = 'b3b3b3';
                            fileType = 'Bez přípony';
                            filterChecker = false;
                        }

                        if (marker_obj_data[i].isText == true) {
                            if (filterSettings.text) {
                                markerColor = 'd9534f';
                                fileType = 'Textový dokument';
                                filterChecker = false;
                            }
                        }
                        if (marker_obj_data[i].isAudio == true) {
                            if (filterSettings.audio) {
                                markerColor = '0275d8';
                                fileType = 'Audio';
                                filterChecker = false;
                            }
                        }
                        if (marker_obj_data[i].isVideo == true) {
                            if (filterSettings.video) {
                                markerColor = '5cb85c';
                                fileType = 'Video';
                                filterChecker = false;
                            }
                        }
                        if (marker_obj_data[i].isImage == true) {
                            if (filterSettings.image) {
                                markerColor = 'f0ad4e';
                                fileType = 'Obrázky';
                                filterChecker = false;
                            }
                        }

                        if (filterChecker){
                            continue;
                        }

                        var marker = new google.maps.Marker({
                            position: {lat: marker_obj_data[i].lat, lng: marker_obj_data[i].lng},
                            map: map,
                            animation: google.maps.Animation.DROP,
                            icon: 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|' + markerColor,
                            sourceId: marker_obj_data[i].source_id,
                            name: marker_obj_data[i].name
                        });

                        content = '<h6><a href="' + getBaseUrl() + 'articles/detail/' + marker_obj_data[i].source_id + '" target="_blank" class="nav-link">' + escapeHtml(marker_obj_data[i].name) + '</a></h6><br>'
                            + '<span class="text-muted">typ: ' + fileType
                            + '<br>Počet souborů: x</span>';

                        setInfoWindow(marker, content);

                        activeMarkers.push(marker);
                    }
                }

                /*
                    Initializing the google maps javascript addon MarkerClusterer

                    Adding an event listener that is fired when user clicks on any of the clusters on map
                    that shows an info window for that cluster, containing an additional information.
                 */
                mc = new MarkerClusterer(map, activeMarkers, mcOptions);
                var clusteredmarkers, clusterContent = '';
                google.maps.event.addListener(mc, 'click', function (cluster) {
                    clusteredmarkers = cluster.getMarkers();
                    clusterContent = '';

                    //map.fitBounds(cluster.getBounds());
                    if (map.getZoom() > 20) {
                        clusterContent = '<h6>Tato oblast obsahuje tyto příspěvky</h6>';
                        for (i = 0; i < clusteredmarkers.length; i++) {
                            clusterContent += '<hr><h6><a href="' + getBaseUrl() + 'articles/detail/' + clusteredmarkers[i].sourceId + '" target="_blank" class="nav-link">' + escapeHtml(clusteredmarkers[i].name) + '</a></h6>';
                        }
                        clusterInfoWindow.setContent(clusterContent);
                        clusterInfoWindow.setPosition(cluster.getCenter());
                        infoWindow.close();
                        clusterInfoWindow.open(map);
                    }
                });
            }

            /*
                This function is called any time when an object of filter settings is changed, refreshing the map markers with the changed filter settings
             */
            function setFilters() {
                clearMapMarkers();
                setMarkers(marker_obj_data, activeMarkers, document.getElementById("pick-year-val").value);
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
                    <input type="checkbox" id="filter-image" checked>
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
            <!-- cdn for modernizr, if you haven't included it already -->
            <script src="http://cdn.jsdelivr.net/webshim/1.12.4/extras/modernizr-custom.js"></script>
            <!-- polyfiller file to detect and load polyfills -->
            <script src="http://cdn.jsdelivr.net/webshim/1.12.4/polyfiller.js"></script>
            <script>
                webshims.setOptions('waitReady', false);
                webshims.setOptions('forms-ext', {types: 'date'});
                webshims.polyfill('forms forms-ext');
            </script>
        </div>
        <script>
            /*
                Event listeners for every filter checkbox, adjusting an object filter settings according to the user selected filters
             */
            document.getElementById('filter-audio').addEventListener('change', function () {
                if (document.getElementById('filter-audio').checked)
                    filterSettings.audio = 1;
                else
                    filterSettings.audio = 0;
                setFilters();
            });

            document.getElementById('filter-video').addEventListener('change', function () {
                if (document.getElementById('filter-video').checked)
                    filterSettings.video = 1;
                else
                    filterSettings.video = 0;
                setFilters();
            });

            document.getElementById('filter-image').addEventListener('change', function () {
                if (document.getElementById('filter-image').checked)
                    filterSettings.image = 1;
                else
                    filterSettings.image = 0;
                setFilters();
            });

            document.getElementById('filter-text').addEventListener('change', function () {
                if (document.getElementById('filter-text').checked)
                    filterSettings.text = 1;
                else
                    filterSettings.text = 0;
                setFilters();
            });
        </script>
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
                           data-slider-min="<?= adodb_mktime(0, 0, 0, $oldest[1], $oldest[2], $oldest[0]) ?>"
                           data-slider-max="<?= adodb_mktime(0, 0, 0, $current[1], $current[2], $current[0]) ?>"
                           data-slider-step="86400"
                           data-slider-value="[<?= adodb_mktime(0, 0, 0, $oldest[1], $oldest[2], $oldest[0]) ?>,<?= adodb_mktime(0, 0, 0, $current[1], $current[2], $current[0]) ?>]"
                           style="width: 100%"/>
                </div>
                <div class="col-xs-6" style="padding-left: 0">
                    <div style="padding-left: 0">
                        <input type="date" value="<?php echo $oldest[0] . "-" . $oldest[1] . "-" . $oldest[2]?>" id="pick-year-val-min"
                               min="<?php echo $oldest[0] . "-" . $oldest[1] . "-" . $oldest[2]?>"
                               max="<?php echo $current[0] . "-" . $current[1] . "-" . $current[2]?>"
                               style="width: 9.5rem" >
                    </div>
                </div>
                <div class="col-xs-6" style="text-align: right; padding-right: 0">
                    <div style="float: right; padding-right: 0">
                        <input type="date" value="<?php echo $current[0] . "-" . $current[1] . "-" . $current[2]?>" id="pick-year-val-max"
                               min="<?php echo $oldest[0] . "-" . $oldest[1] . "-" . $oldest[2]?>"
                               max="<?php echo $current[0] . "-" . $current[1] . "-" . $current[2]?>"
                               style="width: 9.5rem">
                    </div>
                </div>
                <script>
                    $("#slider-year").slider({});
                    $("#slider-year").on("change", function (slideEvt) {
                        delay(function () {
                            $.ajax({
                                url: 'map',
                                type: 'get',
                                dataType: 'json',
                                data: {
                                    "float-min": slideEvt.value.newValue[0],
                                    "float-max": slideEvt.value.newValue[1]
                                },
                                success: function (response) {
                                    $("#pick-year-val-min").val(response[0]);
                                    $("#pick-year-val-max").val(response[1]);
                                }
                            });
                        }, 50);
                        if (interval != null){
                            stopAnimation();
                        }
                    });
                    /*
                     $("#pick-year-val-min").on("change", function () {
                     delay(function () {
                     $.ajax({
                     url: 'map',
                     type: 'get',
                     dataType: "text",
                     data: {"float-min": $("#pick-year-val-min").val(), "funct": 'mktime'},
                     success: function (converted) {
                     $("#slider-year").slider().slider("setValue", parseInt(converted));
                     }
                     });
                     }, 300);

                     })
                     */
                </script>

            </div>

            <hr>
            <h5>Rychlost animace</h5>
            <label class="c-input c-radio">
                <input id="radio1" value="1" name="radio" type="radio" onclick="setSpeed()" checked>
                <span class="c-indicator"></span>
                1x
            </label>
            <label class="c-input c-radio">
                <input id="radio2" value="2" name="radio" onclick="setSpeed()" type="radio">
                <span class="c-indicator"></span>
                2x
            </label>
            <label class="c-input c-radio">
                <input id="radio3" value="3" name="radio" onclick="setSpeed()" type="radio">
                <span class="c-indicator"></span>
                3x
            </label>
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