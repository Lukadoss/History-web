<div class="card card-block">
    <h4 class="card-title col-xs-9">
        <span class=""><?= $source->name ?></span>
    </h4>
    <h6 class="col-xs-3 text-muted text-right">Autor: <?php if($source->user_id) echo $articleAuthor->forename . " " . $articleAuthor->surname;
        else{
            echo $source->forename . " " . $source->surname;
        }?>
    </h6>
    <h5 class="col-xs-12">Datum: <?= date_format($source->date_from, 'd. m. Y'); if(isset($source->date_to)) echo " - " . date_format($source->date_to, 'd. m. Y');; ?>, typ příspěvku: <?= $source->type ?></h5>
    <?php if($source->text){ ?>
    <hr>
    <p><?= $source->text ?></p>
    <?php } ?>
<hr>
    <h5>Přiložené soubory:</h5>
    tady budou obrázky, video, audio...
</div>
<div class="card">
    <div class="card-block card-map">
        <iframe
            width="100%"
            height="100%"
            frameborder="0" style="border:0"
            src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDcDBMIqB9QnfD3wks9zVI2WUSHLnbU9so
    &q=<?= $source->lat; ?>,<?= $source->lng; ?>&zoom=12">
        </iframe>
    </div>
</div>