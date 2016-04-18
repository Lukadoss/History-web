<div class="card">
    <div class="card-header">Administrace příspěvků
    </div>
    <div class="card-block" data-toggle="table">
        <?php echo $this->Flash->render(); ?>
        <table id="administration" class="table table-hover tablesorter">
            <thead class="thead-inverse">
            <tr>
                <th>Název příspěvku</th>
                <th>Autor</th>
                <th>Typ</th>
                <th style="">Možnosti</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($sources as $source) { ?>
                <tr>
                    <td style="vertical-align: middle"><?= $this->Html->link(__($source->name), [
                            'controller' => 'Articles',
                            'action' => 'detail',
                            $source->source_id
                        ]) ?></td>
                    <td style="vertical-align: middle">
                        <?php if(!isset($source->user_id)) {
                            echo $source->forename . ' ' . $source->surname;
                        }
                        else {
                            echo $source->user->forename . ' ' . $source->user->surname;
                        }?><br>
                        <span class="text-muted">
                            <?php if(!isset($source->user_id)) {
                                echo $source->email;
                            }
                            else {
                                echo $source->user->email;
                            }?>
                        </span></td>
                    <td style="vertical-align: middle"><?= $source->type ?></td>
                    <td style="vertical-align: middle"><?= $this->Html->link(__('<i class="fa fa-check"></i> <span class="hidden-sm-down">Přijmout</span>'), [
                            'controller' => 'Administration', 'action' => 'accept', $source->source_id
                        ], array('class' => 'label label-pill label-success', 'escape' => false)) ?>
                        <?= $this->Html->link(__('<i class="fa fa-pencil-square-o"></i> <span class="hidden-sm-down">Editovat</span>'), [
                            'controller' => 'Articles', 'action' => 'edit', $source->source_id
                        ], array('class' => 'label label-pill label-primary', 'escape' => false)) ?>
                        <?= $this->Html->link(__('<i class="fa fa-times"></i> <span class="hidden-sm-down">Smazat</span>'), [
                            'controller' => 'Administration', 'action' => 'delete', $source->source_id
                        ], array('class' => 'label label-pill label-danger', 'escape' => false)) ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>