<div class="card">
    <div class="card-header">Obnovení zapomenutého hesla
    </div>
    <div class="card-block">
        <?php echo $this->Flash->render(); ?>
        <p class="card-text text-center">Do pole níže zadejte email, na který vám odešleme nové heslo.</p>
        <?php echo $this->Form->create(); ?>
        <div class="row">
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <?php echo $this->Form->email('email', array('placeholder'=>'Email', 'id'=>'email')); ?>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="form-group">
                <div class="text-center">
                    <?php echo $this->Form->button('Obnovit heslo', ['class' => 'btn btn-primary']); ?>
                </div>
            </div>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>