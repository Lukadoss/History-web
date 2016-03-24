<div class="card card-block">
    <?= $this->Flash->render() ;
    print_r($this->request->data);
    ?>
    <h4 class="card-title"><?= $user->forename;?> <?= $user->surname ?></h4>
    <h5><?= $user->email; ?></h5>
</div>

