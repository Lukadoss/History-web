<div class="card">
    <div class="card-header">
        Editace příspěvku
    </div>
    <?= $this->Form->create(); ?>
    <div class="card-block">
        <div class="col-md-9" style="padding: 0">
            <div>
                <?php echo $this->Form->text('name', array('id' => 'name', 'value' => $source->name, 'style' => 'max-width: 40rem')) ?>
            </div>
            <h5 class="text-muted form-inline">Datum:
                <div class="form-group">
                    <input type="date" class="form-control" required name="date_from"
                           value="<?= date_format($source->date_from, 'Y-m-d'); ?>" style="max-width: 10rem"> -
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
            <?= $this->Form->textarea('text', ['rows' => '5', 'cols' => '5', 'value' => $source->text]);
            echo $this->Form->button('Uložit změny', ['class' => 'btn btn-primary', 'style' => 'margin-bottom: 0']); ?>
        <?php } ?>
        <hr>
        <?= $this->Form->end(); ?>
        <h5>Přiložené soubory:</h5>
        tady budou obrázky, video, audio...
    </div>
</div>
<div class="card card-map">
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
