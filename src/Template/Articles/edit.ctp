<div class="card">
    <div class="card-header">
        Editace příspěvku
    </div>
    <?php echo $this->Form->create(); ?>
    <div class="card-block">
        <?php echo $this->Form->button('Uložit změny', ['class' => 'btn btn-primary', 'style' => 'margin-bottom: 0; float: right']); ?>
        <div class="clearfix"></div>
        <div class="col-md-9" style="padding: 0">
            <div>
                <?php echo $this->Form->text('name', array('id' => 'name', 'value' => htmlspecialchars($source->name), 'style' => 'max-width: 40rem')) ?>
            </div>
            <h5 class="text-muted form-inline">Datum:
                <div class="form-group">
                    <input type="date" class="form-control" required name="date_from"
                           value="<?php echo date_format($source->date_from, 'Y-m-d'); ?>" style="max-width: 10rem"> -
                </div>
                <div class="form-group">
                    <input type="date" class="form-control" name="date_to"
                           value="<?php if ($source->date_to) echo date_format($source->date_to, 'Y-m-d'); ?>"
                           style="max-width: 10rem">
                </div>
            </h5>
        </div>
        <div class="col-md-3">
            <h6 class="text-muted text-right">
                Autor: <?php if ($source->user_id) echo $articleAuthor->forename . " " . $articleAuthor->surname . "<br>" . $articleAuthor->email;
                else {
                    echo $source->forename . " " . $source->surname . "<br>" . $source->email;
                } ?>
            </h6>
        </div>
        <?php if ($source->text) { ?>
            <hr>
            <?php echo $this->Form->textarea('text', ['rows' => '5', 'cols' => '5', 'value' => htmlspecialchars($source->text)]);
        } ?>
        <hr>

        <h5>Přiložené soubory:</h5>
        tady budou obrázky, video, audio...
    </div>
</div>
<div class="card card-map">
    <div class="card-block card-map" id="map">
        <script>
            var map;
            var marker;

            function initMap() {
                geocoder = new google.maps.Geocoder();
                map = new google.maps.Map(document.getElementById('map'), {
                    center: <?php echo "{lat: " . $source->lat . ", lng: " . $source->lng . "}";?>,
                    zoom: 13,
                    minZoom: 3
                });

                google.maps.event.addListener(map, 'click', function (event) {
                    placeMarker(event.latLng);
                });

                var strictBounds = new google.maps.LatLngBounds(
                    new google.maps.LatLng(85, -180),           // top left corner of map
                    new google.maps.LatLng(-85, 180)            // bottom right corner
                );

                marker = new google.maps.Marker({
                    position: <?php echo "{lat: " . $source->lat . ", lng: " . $source->lng . "}";?>,
                    map: map,
                    draggable: false
                });
            }

            function placeMarker(location) {
                if (marker) {
                    marker.setPosition(location);
                } else {
                    marker = new google.maps.Marker({
                        position: location,
                        map: map,
                        draggable: false
                    });
                }
                document.getElementById('lat').value = location.lat();
                document.getElementById('lng').value = location.lng();
            }

            function setCenter() {
                var elt = document.getElementById('district_id');
                codeAddress(elt.options[elt.selectedIndex].text);
            }
        </script>
        <script
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDcDBMIqB9QnfD3wks9zVI2WUSHLnbU9so&callback=initMap"
            async defer></script>
    </div>
    <input type="text" name="lat" id="lat" required hidden value="<?php echo $source->lat ?>">
    <input type="text" name="lng" id="lng" required hidden value="<?php echo $source->lng ?>">
    <?php echo $this->Form->end(); ?>
</div>
</div>
