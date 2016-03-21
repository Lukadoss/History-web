<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body>
<div class="card card-block">
    <h4 class="card-title">Název příspěvku <?= $test ?></h4>
    <h6 class="text-muted">Autor: Jan Novák</h6>
    <hr>
    <p>Krátký popis příspěvku. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Proin in tellus sit amet nibh
        dignissim sagittis. Maecenas aliquet accumsan leo. Vivamus porttitor turpis ac leo.
        Donec iaculis gravida nulla. Nulla turpis magna, cursus sit amet, suscipit a, interdum id, felis. Nulla non arcu
        lacinia neque faucibus fringilla. Nunc dapibus tortor vel mi dapibus
        sollicitudin. Fusce consectetuer risus a nunc. Pellentesque habitant morbi tristique senectus et netus et
        malesuada fames ac turpis egestas. Integer in sapien. Temporibus autem quibusdam et
        aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non
        recusandae.</p>

</div>
<div class="card card-block">
    tady budou obrázky, video, audio...
</div>
<div class="card">
    <div class="card-block">
        <h5 class="text-center">Zobrazení příspěvku na mapě</h5>
    </div>
    <div class="card-block card-map">
        <iframe
            width="100%"
            height="100%"
            frameborder="0" style="border:0"
            src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDcDBMIqB9QnfD3wks9zVI2WUSHLnbU9so
    &q=49.7188805,13.3593384&zoom=12">
        </iframe>
    </div>
</div>
</body>
</html>