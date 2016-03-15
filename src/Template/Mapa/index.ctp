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
                center: {lat: 48.9622271, lng: 14.5141815},
                zoom: 8
            });

            var contentString = '<h6>testík</h6><br>' + '<img src="http://data.filek.cz/cat.gif" width="100px">';

            var infowindow = new google.maps.InfoWindow({
                content: contentString,
                position: {lat: 48.9622271, lng: 14.5141815}
            });

            infowindow.open(map);
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
    <p class="card-text">tohle dělá tohle<br>
        tohle dělá tamto<br>
        a tohle dělá drsný drsný věci ee
    </p>

</div>
</body>
</html>