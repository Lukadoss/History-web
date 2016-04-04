<div class="card">
    <div class="card-header">Detail uživatele
    </div>
    <div class="card-block">
        <div class="row" style="padding: 2rem">
            <div class="col-md-2" style="text-align: center">
                <i class="fa fa-user" style="font-size: 8rem"></i>
            </div>
            <div class="col-md-10 device-text-align">
                <?= $this->Flash->render();
                ?>
                <h3 class="card-title"><?= $user->forename; ?> <?= $user->surname ?></h3>
                <h5 class="text-muted"><?= $user->email; ?></h5>
                <?= $this->Html->link(__('<i class="fa fa-wrench"> </i> Nastavení'), [
                    'controller' => 'Users',
                    'action' => 'settings'
                ], array('class' => 'btn btn-primary', 'escape' => false)) ?>
            </div>
        </div>
        <ul class="nav nav-tabs" role="tablist" style="margin-left: 0">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#home" role="tab">Schválené příspěvky</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#profile" role="tab">Čekající na schválení</a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="home" role="tabpanel" style="padding-top: 1rem">...
            Zatím jste nenahrál žádný příspěvek</div>
            <div class="tab-pane" id="profile" role="tabpanel" style="padding-top: 1rem">...
            Nemáte žádné příspěvky čekající na schválení</div>
        </div>
    </div>
</div>

