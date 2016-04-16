<div class="card">
    <div class="card-header">Administrace příspěvků
    </div>
    <div class="card-block" data-toggle="table">
        <table id="administration" class="table table-hover tablesorter">
            <thead class="thead-inverse">
            <tr>
                <th>Název příspěvku</th>
                <th>Autor</th>
                <th>Typ</th>
                <th>Možnosti</th>
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
                    <td style="vertical-align: middle"><?= $source->forename . ' ' . $source->surname ?><br><span
                            class="text-muted"><?php echo $source->email ?></span></td>
                    <td style="vertical-align: middle"><?= $source->type ?></td>
                    <td style="vertical-align: middle"><?= $this->Html->link(__('<i class="fa fa-check"></i> <span class="hidden-sm-down">Přijmout</span>'), [
                            'controller' => 'Administration', 'action' => 'accept'
                        ], array('class' => 'label label-pill label-success', 'escape' => false)) ?>
                        <?= $this->Html->link(__('<i class="fa fa-pencil-square-o"></i> <span class="hidden-sm-down">Editovat</span>'), [
                            'controller' => 'Administration', 'action' => 'edit'
                        ], array('class' => 'label label-pill label-primary', 'escape' => false)) ?>
                        <?= $this->Html->link(__('<i class="fa fa-times"></i> <span class="hidden-sm-down">Smazat</span>'), [
                            'controller' => 'Administration', 'action' => 'delete'
                        ], array('class' => 'label label-pill label-danger', 'escape' => false)) ?>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>