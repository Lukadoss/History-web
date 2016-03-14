<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <?= $this->Html->css('fileinput.min.css') ?>

    <?= $this->Html->script('canvas-to-blob.min.js') ?>
    <?= $this->Html->script('fileinput.min.js') ?>
    <?= $this->Html->script('fileinput_locale_cz.js') ?>

</head>
<body>
<div class="card card-block">
    <h4>Přidání nového příspěvku</h4>
    <hr>
    <form role="form" action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Název článku:</label>
            <input type="text" class="form-control" required name="Header">
        </div>
        <div class="form-group">
            <label>Obsah:</label>
            <textarea type="text" rows="15" class="form-control" required name="Text"></textarea>
        </div>

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

        <hr>
        <button type="submit" name="submit-article" class="btn btn-primary">Přidat článek</button>
    </form>
</div>
</body>
</html>