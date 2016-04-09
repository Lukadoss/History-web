<div class="card">
    <div class="card-header">Změna hesla
    </div>
    <div class="card-block">
        <h2 class="hightitle"><?php __('Forget Password'); ?></h2>
        <div class="forgetpwd form">
            <?php echo $this->Flash->render(); ?>
            <div class="row">
                <?php echo $this->Form->create(); ?>
                <div class="form-group">
                    <div class="col-md-offset-4 col-md-4">
                        <?= $this->Form->password('password', array('placeholder' => 'Nové heslo', 'id' => 'pwd', 'class' => 'form-control')); ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-offset-4 col-md-4">
                        <?= $this->Form->password('pass', array('placeholder' => 'Nové heslo znovu', 'id' => 'pwd2', 'class' => 'form-control')); ?>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group">
                    <div class="text-center">
                        <?= $this->Form->button('Obnovit heslo', ['class' => 'btn btn-primary']); ?>
                    </div>
                </div>
                <?= $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>