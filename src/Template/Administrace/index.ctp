<div class="card card-block" data-toggle="table">
    <h4 class="text-center">Administrace příspěvků</h4>
    <hr>
    <table class="table table-hover">
        <thead class="thead-inverse">
        <tr>
            <th class="col-sm-4">Název</th>
            <th class="col-sm-3">Autor</th>
            <th class="col-sm-2">Typ</th>
            <th class="col-sm-3">Možnosti</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="col-sm-4"><?php echo $this->Html->link(__('Audio příspěvek'), [
                    'controller' => 'Prispevek',
                    'action' => 'detail',
                    5
                ]) ?></td>
            <td class="col-sm-3">Otto</td>
            <td class="col-sm-2">Audio</td>
            <td class="col-sm-3"><?php echo $this->Html->link(__('<i class="fa fa-check"></i> <span class="hidden-xs-down"> Přijmout</span>'), [
                    'controller' => 'Info',
                ], array('class' => 'label label-pill label-success', 'escape' => false)) ?>
                <?php echo $this->Html->link(__('<i class="fa fa-pencil-square-o"></i> <span class="hidden-xs-down"> Editovat</span>'), [
                    'controller' => 'Info',
                ], array('class' => 'label label-pill label-primary', 'escape' => false)) ?>
                <?php echo $this->Html->link(__('<i class="fa fa-times"></i> <span class="hidden-xs-down"> Smazat</span>'), [
                    'controller' => 'Info',
                ], array('class' => 'label label-pill label-danger', 'escape' => false)) ?>
        </tr>
        <tr>
            <td class="col-sm-4"><?php echo $this->Html->link(__('Další příspěvek'), [
                    'controller' => 'Prispevek',
                    'action' => 'detail',
                    5
                ]) ?></td>
            <td class="col-sm-3">Thornton</td>
            <td class="col-sm-2">Text</td>
            <td class="col-sm-3"><?php echo $this->Html->link(__('<i class="fa fa-check"></i> <span class="hidden-xs-down"> Přijmout</span>'), [
                    'controller' => 'Info',
                ], array('class' => 'label label-pill label-success', 'escape' => false)) ?>
                <?php echo $this->Html->link(__('<i class="fa fa-pencil-square-o"></i> <span class="hidden-xs-down"> Editovat</span>'), [
                    'controller' => 'Info',
                ], array('class' => 'label label-pill label-primary', 'escape' => false)) ?>
                <?php echo $this->Html->link(__('<i class="fa fa-times"></i> <span class="hidden-xs-down"> Smazat</span>'), [
                    'controller' => 'Info',
                ], array('class' => 'label label-pill label-danger', 'escape' => false)) ?>
        </tr>
        <tr>
            <td class="col-sm-4"><?php echo $this->Html->link(__('Poslední příspěvek'), [
                    'controller' => 'Prispevek',
                    'action' => 'detail',
                    5
                ]) ?></td>
            <td class="col-sm-3">Larry the Bird</td>
            <td class="col-sm-2">Obrázek</td>
            <td class="col-sm-3"><?php echo $this->Html->link(__('<i class="fa fa-check"></i> <span class="hidden-xs-down"> Přijmout</span>'), [
                    'controller' => 'Info',
                ], array('class' => 'label label-pill label-success', 'escape' => false)) ?>
                <?php echo $this->Html->link(__('<i class="fa fa-pencil-square-o"></i> <span class="hidden-xs-down"> Editovat</span>'), [
                    'controller' => 'Info',
                ], array('class' => 'label label-pill label-primary', 'escape' => false)) ?>
                <?php echo $this->Html->link(__('<i class="fa fa-times"></i> <span class="hidden-xs-down"> Smazat</span>'), [
                    'controller' => 'Info',
                ], array('class' => 'label label-pill label-danger', 'escape' => false)) ?>
        </tr>
        </tbody>
    </table>
</div>