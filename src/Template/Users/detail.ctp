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
                <h3 class="card-title"><?= htmlspecialchars($user->forename); ?> <?= htmlspecialchars($user->surname); ?></h3>
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
            <div class="tab-pane active" id="home" role="tabpanel" style="padding-top: 1rem">
                <?php if ($accepted->isEmpty()){ ?>... Zatím nemáte žádný vydaný příspěvek<?php }else{ ?>
                <table id="detail" class="table table-hover tablesorter">
                    <thead class="thead-inverse">
                        <tr>
                            <th>Název příspěvku</th>
                            <th>Možnosti</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($accepted as $item){ ?>
                        <tr>
                            <td style="vertical-align: middle"><?= $this->Html->link(__($item->name), [
                                    'controller' => 'Articles',
                                    'action' => 'detail',
                                    $item->source_id
                                ]) ?></td>
                            <td style="vertical-align: middle"><?= $this->Html->link(__('<i class="fa fa-pencil-square-o"></i> <span class="hidden-sm-down">Editovat</span>'), [
                                    'controller' => 'Articles', 'action' => 'edit', $item->source_id
                                ], array('class' => 'label label-pill label-primary', 'escape' => false)) ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <?php } ?>
            </div>

            <div class="tab-pane" id="profile" role="tabpanel" style="padding-top: 1rem">
                <?php if ($onHold->isEmpty()){ ?>... Nemáte žádné příspěvky čekající na schválení<?php }else{ ?>
                    <table id="detail" class="table table-hover tablesorter">
                        <thead class="thead-inverse">
                        <tr>
                            <th>Název příspěvku</th>
                            <th>Možnosti</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($onHold as $item){ ?>
                            <tr>
                                <td style="vertical-align: middle"><?= $this->Html->link(__($item->name), [
                                        'controller' => 'Articles',
                                        'action' => 'detail',
                                        $item->source_id
                                    ]) ?></td>
                                <td style="vertical-align: middle"><?= $this->Html->link(__('<i class="fa fa-pencil-square-o"></i> <span class="hidden-sm-down">Editovat</span>'), [
                                        'controller' => 'Articles', 'action' => 'edit', $item->source_id
                                    ], array('class' => 'label label-pill label-primary', 'escape' => false)) ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

