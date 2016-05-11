<script type="text/javascript"
        src="/path/to/shared/js/modernizr.com/Modernizr-2.5.3.forms.js">
</script>

<script type="text/javascript"
        data-webforms2-support="date"
        data-lang="en"
        src="/path/to/html5Forms/shared/js/html5Forms.js">

</script>
<?php echo $this->Html->script('canvas-to-blob.min.js') ?>
<?php echo $this->Html->script('fileinput.min.js') ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/i18n/cs.js"></script>
<?php echo $this->Html->script('fileinput_locale_cz.js', array('type' => 'text/javascript')) ?>
<div class="card">
    <div class="card-header">Přidání nového příspěvku
    </div>
    <div class="card-block">
        <?php echo $this->Flash->render(); ?>
        <?php
        echo $this->Form->create($source, ['type' => 'file']); ?>
        <?php if (!$this->request->session()->read('Auth.User')) { ?>

            <div>
                <div class="col-md-6">
                    <label for="jmeno">Jméno*</label>
                    <input type="text" class="form-control" required id="jmeno" name="forename">
                </div>
                <div class="col-md-6">
                    <label for="prijmeni">Příjmení*</label>
                    <input type="text" class="form-control" required id="prijmeni" name="surname">
                </div>
            </div>
            <div class="form-group col-md-12">
                <label>Email*</label>
                <input type="text" class="form-control" required name="email">
            </div>
            <div class="form-group col-md-12 text-center">
                <span class="text-danger"><i class="fa fa-info-circle"> </i> Pro registrované uživatele jsou informace o autorovi vyplňovány automaticky</span>
            </div>
            <hr>
        <?php } ?>
        <div class="form-group col-md-12">
            <label>Název příspěvku*:</label>
            <input type="text" class="form-control" required name="name">
        </div>
        <div class="form-group col-md-12">
            <?php echo $this->Form->input('Krátký popis:', ['type' => 'textarea', 'escape' => true, 'class' => 'form-control', 'rows' => '5', 'name' => 'text']); ?>
        </div>
        <div class="form-group">

            <div class="col-md-6">
                <label>Datum události*:</label>
                <input type="date" class="form-control" required name="date_from">
            </div>

            <div class="col-md-6">
                <label><label class="c-input c-checkbox">
                        <input type="checkbox" id="date-span"
                               onclick="document.getElementById('date-to').disabled=!this.checked; if(!this.checked) document.getElementById('date-to').value = '';">
                        <script>$('#date-span').prop('indeterminate', true)</script>
                        <span class="c-indicator"></span>
                    </label>Trvání události do:</label>

                <input type="date" class="form-control" id="date-to" name="date_to" style="margin-bottom: 0" disabled>
                <span class="text-muted" style="font-size: 0.75rem">Pokud nevíte přesné datum, nebo událost trvala více jak den, zadejte datum jako interval</span>
            </div>
        </div>
        <div class="form-group col-md-12">
            <label class="control-label">Soubory</label>
            <ul class="nav nav-tabs" role="tablist" style="margin-left: 0">
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#text" role="tab">
                        <i class="fa fa-quote-right"> </i><span class="hidden-xs-down"> Text</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#image" role="tab">
                        <i class="fa fa-picture-o"> </i><span class="hidden-xs-down"> Obrázky</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#audio" role="tab">
                        <i class="fa fa-music"> </i><span class="hidden-xs-down"> Audio</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#video" role="tab">
                        <i class="fa fa-film"> </i><span class="hidden-xs-down"> Video</span></a>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane" id="text" role="tabpanel">
                    <input id="text_file_input" name="text_file[]" type="file" multiple="multiple">
                    <script>
                        $(document).on('ready', function () {
                            $("#text_file_input").fileinput({
                                uploadUrl: "/historyweb/articles/new-article", // server upload action
                                uploadAsync: false,
                                dropZoneEnabled: false,
                                overwriteInitial: false,
                                maxFileSize: 15000,
                                maxFileCount: 20,
                                previewFileType: 'any',
                                showUpload: false,
                                language: 'cz',
                                showCancel: false,
                                showClose: false,
                                initialPreviewShowDelete: true,
                                allowedFileExtensions: ['txt', 'doc', 'docx', 'pdf'],
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
                                },
                                browseIcon: '<i class="fa fa-folder-open" aria-hidden="true"></i>',
                                browseLabel: 'Vybrat',
                                removeIcon: '<i class="fa fa-trash" aria-hidden="true"></i>'
                            });
                        });
                    </script>
                </div>
                <div class="tab-pane active" id="image" role="tabpanel">
                    <input id="image_file_input" name="image_file[]" type="file" multiple class="file-loading">
                    <script>
                        $(document).on('ready', function () {
                            $("#image_file_input").fileinput({
                                uploadUrl: "/historyweb/articles/new-article", // server upload action
                                uploadAsync: false,
                                dropZoneEnabled: false,
                                overwriteInitial: false,
                                maxFileSize: 30000,
                                maxFileCount: 20,
                                previewFileType: 'any',
                                showUpload: false,
                                language: 'cz',
                                showCancel: false,
                                showClose: false,
                                initialPreviewShowDelete: true,
                                allowedFileExtensions: ['jpg', 'jpeg', 'png', 'gif', 'bmp'],
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
                                },
                                browseIcon: '<i class="fa fa-folder-open" aria-hidden="true"></i>',
                                browseLabel: 'Vybrat',
                                removeIcon: '<i class="fa fa-trash" aria-hidden="true"></i>'
                            });
                        });
                    </script>
                </div>
                <div class="tab-pane" id="audio" role="tabpanel">
                    <input id="audio_file_input" name="audio_file[]" type="file" multiple class="file-loading">
                    <script>
                        $(document).on('ready', function () {
                            $("#audio_file_input").fileinput({
                                uploadUrl: "/historyweb/articles/new-article", // server upload action
                                uploadAsync: false,
                                dropZoneEnabled: false,
                                overwriteInitial: false,
                                maxFileSize: 40000,
                                maxFileCount: 20,
                                previewFileType: 'any',
                                showUpload: false,
                                language: 'cz',
                                showCancel: false,
                                showClose: false,
                                initialPreviewShowDelete: true,
                                allowedFileExtensions: ['mp3', 'wav', 'flac', 'mpg'],
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
                                },
                                browseIcon: '<i class="fa fa-folder-open" aria-hidden="true"></i>',
                                browseLabel: 'Vybrat',
                                removeIcon: '<i class="fa fa-trash" aria-hidden="true"></i>'
                            });
                        });
                    </script>
                </div>
                <div class="tab-pane" id="video" role="tabpanel">
                    <input id="video_file_input" name="video_file[]" type="file" multiple class="file-loading">
                    <script>
                        $(document).on('ready', function () {
                            $("#video_file_input").fileinput({
                                uploadUrl: "/historyweb/articles/new-article", // server upload action
                                uploadAsync: false,
                                dropZoneEnabled: false,
                                overwriteInitial: false,
                                maxFileSize: 100000,
                                maxFileCount: 20,
                                previewFileType: 'any',
                                showUpload: false,
                                language: 'cz',
                                showCancel: false,
                                showClose: false,
                                initialPreviewShowDelete: true,
                                allowedFileExtensions: ['mp4', 'mpeg', 'avi'],
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
                                },
                                browseIcon: '<i class="fa fa-folder-open" aria-hidden="true"></i>',
                                browseLabel: 'Vybrat',
                                removeIcon: '<i class="fa fa-trash" aria-hidden="true"></i>'
                            });
                        });
                    </script>
                </div>
            </div>

        </div>
        <hr>
        <div class="form-group col-md-12 select-box" id="district-selector">
            <label class="control-label">Obec:</label>


            <select class="js-example-basic-single" id="district_id" name="district_id" onChange="setCenter()">
                <option></option>
                <?php foreach ($district as $dist) {
                    ?>
                    <option> <?php echo $dist->municipality ?>,
                        okres <?php echo $dist->district ?>, <?php echo $dist->region ?>
                    </option> <?php
                } ?>

            </select>
            <script type="text/javascript">
                $(document).ready(function () {
                    $(".js-example-basic-single").select2({
                        language: "cs",
                        width: '100%',
                        placeholder: "Vyberte obec",
                        matcher: function (params, data) {
                            if ($.trim(params.term) === '') {
                                return data;
                            }

                            if (
                                $(data.element).text().toUpperCase().indexOf(params.term.toUpperCase()) == 1
                            ) {
                                var modifiedData = $.extend({}, data, true);

                                return modifiedData;
                            }

                            return null;
                        }
                    });
                });
            </script>
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
                        zoom: 8,
                        minZoom: 3
                    });

                    google.maps.event.addListener(map, 'click', function (event) {
                        placeMarker(event.latLng);
                    });

                    var strictBounds = new google.maps.LatLngBounds(
                        new google.maps.LatLng(85, -180),           // top left corner of map
                        new google.maps.LatLng(-85, 180)            // bottom right corner
                    );
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
        <input type="text" name="lat" id="lat" required hidden>
        <input type="text" name="lng" id="lng" required hidden>
        <hr>
        <div class="g-recaptcha" style="margin-bottom: 15px;"
             data-sitekey="6LdMihwTAAAAABHyUIcfago1qMOTWkT4dL7XP_Bx"></div>
        <h6 class="text-muted" style="color:red">Prosím potvrďte příspěvek tím že nejste robot.<br> Všechna pole
            označená * jsou povinná.</h6>
        <button type="submit" name="submit-article" id="submit-article" class="btn btn-primary fileinput-upload">Přidat
            článek
        </button>
        <?php echo $this->Form->end();
        ?>
    </div>
</div>
