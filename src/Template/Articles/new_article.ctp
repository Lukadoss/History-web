<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <?= $this->Html->css('fileinput.min.css') ?>

    <?= $this->Html->script('canvas-to-blob.min.js') ?>
    <?= $this->Html->script('fileinput.min.js') ?>


    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/i18n/cs.js"></script>

    <?= $this->Html->script('fileinput_locale_cz.js', array('type' => 'text/javascript')) ?>
</head>
<body>
<div class="card">
    <div class="card-header">Přidání nového příspěvku
    </div>
    <div class="card-block">
        <?= $this->Flash->render(); ?>
        <?php
        echo $this->Form->create($source, ['type' => 'file']); ?>
        <?php if (!$this->request->session()->read('Auth.User')) { ?>
            <div>
                <div class="col-md-6">
                    <label for="jmeno">Jméno</label>
                    <input type="text" class="form-control" required id="jmeno" name="forename">
                </div>
                <div class="col-md-6">
                    <label for="prijmeni">Příjmení</label>
                    <input type="text" class="form-control" required id="prijmeni" name="surname">
                </div>
            </div>
            <div class="form-group col-md-12">
                <label>Email</label>
                <input type="text" class="form-control" required name="email">
            </div>
            <div class="form-group col-md-12 checkbox">
                <label class="c-input c-checkbox">
                    <input type="checkbox" name="register" checked>
                    <span class="c-indicator"></span>
                    Zaregistrovat
                </label>
            </div>
            <hr>
        <?php } ?>
        <div class="form-group col-md-12">
            <label>Název příspěvku:</label>
            <input type="text" class="form-control" required name="name">
        </div>
        <div class="form-group col-md-12">
            <label>Krátký popis (nepovinný):</label>
            <textarea type="text" rows="5" class="form-control" name="text"></textarea>
        </div>
        <div class="form-group">

            <div class="col-md-6">
                <label>Datum události od:</label>
                <input type="date" class="form-control" required name="date_from">
            </div>
            <div class="col-md-6">
                <label>Datum do:</label>
                <input type="date" class="form-control" name="date_to">
            </div>
        </div>
        <div class="form-group col-md-12">
            <label class="control-label">Soubory</label>
            <input id="file_input" name="file_input[]" type="file" multiple class="file-loading">
            <script>
                $(document).on('ready', function () {
                    $("#file_input").fileinput({
                        uploadUrl: "http://localhost/", // server upload action
                        uploadAsync: false,
                        dropZoneEnabled: false,
                        overwriteInitial: false,
                        maxFileSize: 300000,
                        previewFileType: 'any',
                        showUpload: false,
                        language: 'cz',
                        showCancel: false,
                        showClose: false,
                        initialPreviewShowDelete: true,
                        allowedFileExtensions: ['jpg', 'jpeg', 'png', 'gif',
                            'mp3', 'wav',
                            'mp4', 'avi', 'wmv'],
                        removeClass: 'btn btn-danger btn-remove',
                        fileActionSettings: {
                            removeIcon: '<i class="fa fa-trash-o"></i>',
                            removeClass: 'btn btn-danger-outline file-upload-remove-btn btn-sm',
                            uploadIcon: '<i class="fa fa-upload"></i>'
                        },
                        layoutTemplates: {
                            actions: '<div class="file-actions file-upload-actionbar">\n' +
                            '    <div class="file-footer-buttons file-upload-actionbar">\n' +
                            '        {delete}' +
                            '    </div>\n' +
                            '    <div class="file-upload-indicator" tabindex="-1" title="{indicatorTitle}">{indicator}</div>\n' +
                            '    <div class="clearfix"></div>\n' +
                            '</div>'
                        }
                    });
                });
            </script>
        </div>
        <hr>
        <div class="form-group col-md-12 select-box" id="district-selector" name="district">
            <label class="control-label">Obec:</label>
            <script type="text/javascript">
                $(document).ready(function () {
                    $(".js-example-basic-single").select2({
                        language: "cs",
                        width: '100%',
                        placeholder: "Vyberte obec"
                    });
                });
            </script>

            <select class="js-example-basic-single" id="district_id" name="district_id" onChange="setCenter()">
                <option></option>
                <?php foreach ($district as $dist) {
                    ?>
                    <option value="<?= $dist->id ?>"> <?= $dist->municipality ?>, <span class="text-muted"><i
                                class="fa fa-user"> </i>okres <?= $dist->district ?>, <?= $dist->region ?></span>
                    </option> <?php
                } ?>

            </select>
        </div>
        <div class="clearfix"></div>
        <div class="card-map m-x-1" id="map">
            <script>
                var map;
                var marker;

                function initMap() {
                    geocoder = new google.maps.Geocoder();
                    map = new google.maps.Map(document.getElementById('map'), {
                        center: {lat: 48.9622271, lng: 14.5141815},
                        zoom: 8
                    });

                    google.maps.event.addListener(map, 'click', function (event) {
                        placeMarker(event.latLng);
                    });
                }

                function codeAddress(address) {
                    geocoder.geocode({'address': address}, function (results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            map.setCenter(results[0].geometry.location);
                            map.fitBounds(results[0].geometry.viewport);
                            placeMarker(results[0].geometry.location);
                        }
                    });
                }

                function placeMarker(location) {
                    if (marker) {
                        marker.setPosition(location);
                    } else {
                        marker = new google.maps.Marker({
                            position: location,
                            map: map,
                            draggable: true
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
        <input type="text" name="lat" id="lat" hidden>
        <input type="text" name="lng" id="lng" hidden>
        <hr>
        <div class="g-recaptcha" style="margin-bottom: 15px;" data-sitekey="6LdMihwTAAAAABHyUIcfago1qMOTWkT4dL7XP_Bx"></div>
        <button type="submit" name="submit-article" class="btn btn-primary">Přidat článek</button>
        <?php echo $this->Form->end();
        ?>
    </div>
</div>
</body>
</html>