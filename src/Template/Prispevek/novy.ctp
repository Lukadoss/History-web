<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <?= $this->Html->css('fileinput.min.css') ?>

    <?= $this->Html->script('canvas-to-blob.min.js') ?>
    <?= $this->Html->script('fileinput.min.js') ?>
    <?= $this->Html->script('fileinput_locale_cz.js') ?>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/i18n/cs.js"></script>


</head>
<body>
<div class="card card-block">
    <h4>Přidání nového příspěvku</h4>
    <hr>
    <form role="form" action="" method="POST" enctype="multipart/form-data">
        <div>
            <div class="col-md-6">
                <label for="jmeno">Jméno</label>
                <input type="text" class="form-control" required id="jmeno" name="Forename">
            </div>
            <div class="col-md-6">
                <label for="prijmeni">Příjmení</label>
                <input type="text" class="form-control" required id="prijmeni" name="Surname">
            </div>
        </div>
        <div class="form-group col-md-12">
            <label>Email</label>
            <input type="text" class="form-control" required name="Mail">
        </div>
        <div class="form-group col-md-12 checkbox">
            <label class="c-input c-checkbox">
                <input type="checkbox" checked>
                <span class="c-indicator"></span>
                Zaregistrovat
            </label>
        </div>
        <hr>
        <div class="form-group col-md-12">
            <label>Název příspěvku:</label>
            <input type="text" class="form-control" required name="Header">
        </div>
        <div class="form-group col-md-12">
            <label>Krátký popis (nepovinný):</label>
            <textarea type="text" rows="5" class="form-control" required name="Text"></textarea>
        </div>
        <div class="form-group col-md-12">
            <label class="control-label">Soubory</label>
            <input id="input-24" name="input24[]" type="file" multiple class="file-loading">
            <script>
                $(document).on('ready', function () {
                    $("#input-24").fileinput({
                        overwriteInitial: false,
                        maxFileSize: 100000,
                        previewFileType: 'any'
                    });
                });
            </script>
        </div>
        <div class="form-group col-md-12 select-box" id="district-selector">
            <script type="text/javascript">
                $(document).ready(function () {
                    $(".js-example-basic-single").select2({
                        language: "cs"
                    });
                });
            </script>

            <select class="js-example-basic-single" onchange="setCenter()">
                <option value="Plzeň">Plzeň</option>
                <option value="České Budějovice">České Budějovice</option>
                <option value="Písek">Písek</option>
                <option value="Vidlákov">Vidlákov</option>
                <option value="Loučovice">Loučovice</option>
            </select>
        </div>
        <hr>
        <div class="card-map" id="map">
            <script>
                var map;
                function initMap() {
                    var select = document.getElementById('district-selector');
                    //geocoder = new google.maps.Geocoder();
                    map = new google.maps.Map(document.getElementById('map'), {
                        center: {lat: 48.9622271, lng: 14.5141815},
                        zoom: 8
                    });


                    google.maps.event.addDomListener(select, 'change', function () {
                        alert('Selected!');
                    });

                    /*
                     function codeAddress(address) {
                     geocoder.geocode({'address': address}, function (results, status) {
                     if (status == google.maps.GeocoderStatus.OK) {
                     map.setCenter(results[0].geometry.location);
                     map.fitBounds(results[0].geometry.viewport);
                     }

                     });
                     }

                     codeAddress('okres '+'Plzeň-město');
                     */
                }

                function setCenter() {
                    map.setCenter({lat: 48.9622271, lng: 14.5141815});
                    map.setZoom(10);
                }
            </script>
            <script
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDcDBMIqB9QnfD3wks9zVI2WUSHLnbU9so&callback=initMap"
                async defer></script>
        </div>
        <hr>
        <button type="submit" name="submit-article" class="btn btn-primary">Přidat článek</button>

    </form>
</div>
</body>
</html>