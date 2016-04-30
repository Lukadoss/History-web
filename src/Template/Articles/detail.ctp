<div class="card card-block">
    <div class="card-title col-md-9" style="padding: 0">
        <h4>
            <span class=""><?php echo htmlspecialchars($source->name); ?></span>
        </h4>
        <h5 class="text-muted">Datum: <?php echo date_format($source->date_from, 'd. m. Y');
            if (isset($source->date_to)) echo " - " . date_format($source->date_to, 'd. m. Y');; ?></h5>
    </div>
    <div class="col-md-3">
        <h6 class="text-muted text-right">
            Autor: <?php if ($source->user_id) echo htmlspecialchars($articleAuthor->forename) . " " . htmlspecialchars($articleAuthor->surname);
            else {
                echo htmlspecialchars($source->forename) . " " . htmlspecialchars($source->surname);
            } ?>
        </h6>
    </div>
    <?php if ($source->text) { ?>
        <hr>
        <p><?php echo htmlspecialchars($source->text) ?></p>
    <?php } ?>
    <hr>
    <h5>Přiložené soubory:</h5>
    <ul class="nav nav-tabs" role="tablist" style="margin-left: 0">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#text" role="tab">Text</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#images" role="tab">Obrázky</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#audio" role="tab">Audio</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#video" role="tab">Video</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="text" role="tabpanel" style="padding-top: 1rem">
            <?php if (!is_dir('files/' . $source->source_id . '/Text')) { ?>... Nebyl nahrát žádný textový soubor<?php } else {
                $path = 'files/' . $source->source_id . '/Text';
                $dir = opendir($path);
                ?>
                <table id="detail" class="table table-hover tablesorter">
                    <thead class="thead-inverse">
                    <tr>
                        <th>Název</th>
                        <th>Stáhnout</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while ($file = readdir($dir)) {
                        $validation = array('pdf', 'doc', 'docx', 'txt');
                        if (in_array((strtolower(pathinfo($file, PATHINFO_EXTENSION))), $validation)) {
                            ?>
                            <tr>
                                <td style="vertical-align: middle"><?php
                                    echo $file;
                                    ?></td>
                                <td style="vertical-align: middle"><i class="fa fa-download"></i> <span class="hidden-sm-down">Download</span></td>
                            </tr>
                        <?php }
                    } ?>
                    </tbody>
                </table>
            <?php } ?>
        </div>

        <div class="tab-pane" id="images" role="tabpanel" style="padding-top: 1rem">
            <?php if (!is_dir('files/' . $source->source_id . '/Image')) { ?>... Nebyl nahrát žádný obrázek<?php } else {
                $path = 'files/' . $source->source_id . '/Image';
                $dir = opendir($path);
                ?>
                <table id="detail" class="table table-hover tablesorter">
                    <thead class="thead-inverse">
                    <tr>
                        <th>Název příspěvku</th>
                        <th>Možnosti</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while ($file = readdir($dir)) {
                        $validation = array('jpg', 'jpeg', 'gif', 'bmp', 'png');
                        if (in_array((strtolower(pathinfo($file, PATHINFO_EXTENSION))), $validation)) {
                            ?>
                            <tr>
                                <td style="vertical-align: middle"><?php
                                    echo $file;
                                    ?></td>
                                <td style="vertical-align: middle"><i class="fa fa-download"></i> <span class="hidden-sm-down">Download</span></td>
                            </tr>
                        <?php }
                    } ?>
                    </tbody>
                </table>
            <?php } ?>
        </div>

        <div class="tab-pane" id="audio" role="tabpanel" style="padding-top: 1rem">
            <?php if (!is_dir('files/' . $source->source_id . '/Audio')) { ?>... Nebyl nahrát žádný audio soubor<?php } else {
                $path = 'files/' . $source->source_id . '/Audio';
                $dir = opendir($path);
                ?>
                <table id="detail" class="table table-hover tablesorter">
                    <thead class="thead-inverse">
                    <tr>
                        <th>Název příspěvku</th>
                        <th>Možnosti</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while ($file = readdir($dir)) {
                        $validation = array("mp3", "wav", "flac", "mpg");
                        if (in_array((strtolower(pathinfo($file, PATHINFO_EXTENSION))), $validation)) {
                            ?>
                            <tr>
                                <td style="vertical-align: middle"><?php
                                    echo $file;
                                    ?></td>
                                <td style="vertical-align: middle"><i class="fa fa-download"></i> <span class="hidden-sm-down">Download</span></td>
                            </tr>
                        <?php }
                    } ?>
                    </tbody>
                </table>
            <?php } ?>
        </div>

        <div class="tab-pane" id="video" role="tabpanel" style="padding-top: 1rem">
            <?php if (!is_dir('files/' . $source->source_id . '/Video')) { ?>... Nebyl nahrát žádný video soubor<?php } else {
                $path = 'files/' . $source->source_id . '/Video';
                $dir = opendir($path);
                ?>
                <table id="detail" class="table table-hover tablesorter">
                    <thead class="thead-inverse">
                    <tr>
                        <th>Název příspěvku</th>
                        <th>Možnosti</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while ($file = readdir($dir)) {
                        $validation = array("mp4", "avi", "mpeg");
                        if (in_array((strtolower(pathinfo($file, PATHINFO_EXTENSION))), $validation)) {
                            ?>
                            <tr>
                                <td style="vertical-align: middle"><?php
                                    echo $file;
                                    ?></td>
                                <td style="vertical-align: middle"><i class="fa fa-download"></i> <span class="hidden-sm-down">Download</span></td>
                            </tr>
                        <?php }
                    } ?>
                    </tbody>
                </table>
            <?php } ?>
        </div>

    </div>
    <br>
    <div class="card">
        <div class="card-block card-map">
            <iframe
                width="100%"
                height="100%"
                frameborder="0" style="border:0"
                src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDcDBMIqB9QnfD3wks9zVI2WUSHLnbU9so
    &q=<?php echo $source->lat; ?>,<?php echo $source->lng; ?>&zoom=12">
            </iframe>
        </div>
    </div>