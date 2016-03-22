<div class="card card-block" data-toggle="table">
    <h4 class="text-center">Administrace příspěvků</h4>
    <hr>
    <table class="table table-hover">
        <thead class="thead-inverse">
        <tr>
            <th>Název příspěvku</th>
            <th>Autor</th>
            <th>Typ příspěvku</th>
            <th>Možnosti</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><?php echo $this->Html->link(__('Audio příspěvek'), [
                    'controller' => 'Article',
                    'action' => 'detail',
                    5
                ]) ?></td>
            <td>Otto</td>
            <td>Audio</td>
            <td><?php echo $this->Html->link(__('<i class="fa fa-check"></i> Přijmout'), [
                    'controller' => 'Info',
                ], array('class' => 'label label-pill label-success', 'escape' => false)) ?>
                <?php echo $this->Html->link(__('<i class="fa fa-pencil-square-o"></i> Editovat'), [
                    'controller' => 'Info',
                ], array('class' => 'label label-pill label-primary', 'escape' => false)) ?>
                <?php echo $this->Html->link(__('<i class="fa fa-times"></i> Smazat'), [
                    'controller' => 'Info',
                ], array('class' => 'label label-pill label-danger', 'escape' => false)) ?>
        </tr>
        <tr>
            <td><?php echo $this->Html->link(__('Další příspěvek'), [
                    'controller' => 'Article',
                    'action' => 'detail',
                    5
                ]) ?></td>
            <td>Thornton</td>
            <td>Text</td>
            <td><?php echo $this->Html->link(__('<i class="fa fa-check"></i> Přijmout'), [
                    'controller' => 'Info',
                ], array('class' => 'label label-pill label-success', 'escape' => false)) ?>
                <?php echo $this->Html->link(__('<i class="fa fa-pencil-square-o"></i> Editovat'), [
                    'controller' => 'Info',
                ], array('class' => 'label label-pill label-primary', 'escape' => false)) ?>
                <?php echo $this->Html->link(__('<i class="fa fa-times"></i> Smazat'), [
                    'controller' => 'Info',
                ], array('class' => 'label label-pill label-danger', 'escape' => false)) ?>
        </tr>
        <tr>
            <td><?php echo $this->Html->link(__('Poslední příspěvek'), [
                    'controller' => 'Article',
                    'action' => 'detail',
                    5
                ]) ?></td>
            <td>Larry the Bird</td>
            <td>Obrázek</td>
            <td><?php echo $this->Html->link(__('<i class="fa fa-check"></i> Přijmout'), [
                    'controller' => 'Info',
                ], array('class' => 'label label-pill label-success', 'escape' => false)) ?>
                <?php echo $this->Html->link(__('<i class="fa fa-pencil-square-o"></i> Editovat'), [
                    'controller' => 'Info',
                ], array('class' => 'label label-pill label-primary', 'escape' => false)) ?>
                <?php echo $this->Html->link(__('<i class="fa fa-times"></i> Smazat'), [
                    'controller' => 'Info',
                ], array('class' => 'label label-pill label-danger', 'escape' => false)) ?>
        </tr>
        </tbody>
    </table>
</div>