<div class="card">
    <div class="card-header">Přihlášení uživatele</div>
    <div class="card-block">
        <?php echo $this->Flash->render(); ?>
        <?php echo $this->Form->create(); ?>
        <div class="row">
            <div class="form-group">
                    <label class="col-md-5 form-control-label form-login-label" for="email">Email:</label>
                <div class="col-md-3">
                    <?php echo $this->Form->email('email', array('placeholder'=>'Email', 'id'=>'email')); ?>
                </div>
            </div>
            <div class="form-group">
                    <label class="col-md-5 form-control-label form-login-label" for="pwd">Heslo:</label>
                <div class="col-md-3">
                    <?php echo $this->Form->password('password', array('placeholder'=>'Heslo', 'id'=>'pwd')); ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-5 col-sm-3">
                    <?php echo $this->Form->button('Přihlásit', ['class' => 'btn btn-primary']); ?>
                </div>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
        <hr>
        <p style="text-align:center">Ještě nemáš účet? <?php echo $this->Html->link(__('Zaregistruj se.'), [
                'controller' => 'Users',
                'action' => 'registration'
            ]) ?></p>
        <p style="text-align:center"><?php echo $this->Html->link(__('Zapomenuté heslo.'), [
                'controller' => 'Tickets',
                'action' => 'lostpassword'
            ]) ?></a></p>
    </div>
</div>