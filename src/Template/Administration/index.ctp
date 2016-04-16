<div class="card">
    <div class="card-header">Administrace příspěvků
    </div>
    <div class="card-block" data-toggle="table">
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
            <?php foreach ($sources as $source){    ?>
            <tr>
                <td><?php echo $this->Html->link(__($source->name), [
                        'controller' => 'Articles',
                        'action' => 'detail',
                        $source->source_id
                    ]) ?></td>
                <td><?php echo $source->forename . ' ' . $source->surname ?></td>
                <td><?php echo $source->type?></td>
                <td><?php echo $this->Html->link(__('<i class="fa fa-check"></i> Přijmout'), [
                        'controller' => 'Administration', 'action' => 'accept'
                    ], array('class' => 'label label-pill label-success', 'escape' => false)) ?>
                    <?php echo $this->Html->link(__('<i class="fa fa-pencil-square-o"></i> Editovat'), [
                        'controller' => 'Administration', 'action' => 'edit'
                    ], array('class' => 'label label-pill label-primary', 'escape' => false)) ?>
                    <?php echo $this->Html->link(__('<i class="fa fa-times"></i> Smazat'), [
                        'controller' => 'Administration', 'action' => 'delete'
                    ], array('class' => 'label label-pill label-danger', 'escape' => false)) ?>
            </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>