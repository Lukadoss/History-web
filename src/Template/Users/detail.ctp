<div class="card card-block">
    <?= $this->Flash->render() ;
    ?>
    <h4 class="card-title"><?= $user->forename;?> <?= $user->surname ?></h4>
    <h5><?= $user->email; ?></h5>
</div>

