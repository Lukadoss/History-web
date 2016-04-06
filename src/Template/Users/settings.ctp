<div class="card">
    <div class="card-header">Nastavení uživatele
    </div>
    <div class="card-block">
        <?php echo $this->Flash->render(); ?>
        <?php echo $this->Form->create(); ?>
        <div class="row">
            <h4 class="text-center">Změna osobních údajů</h4>
            <div class="form-group">
                <label class="col-md-5 form-control-label form-login-label" for="jmeno">Jméno:</label>
                <div class="col-md-3">
                    <?php echo $this->Form->text('forename', array('placeholder'=>'Jméno', 'id'=>'jmeno')); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-5 form-control-label form-login-label" for="prijmeni">Příjmení:</label>
                <div class="col-md-3">
                    <?php echo $this->Form->text('surname', array('placeholder'=>'Příjmení', 'id'=>'prijmeni')); ?>
                </div>
            </div>
            <hr>
            <h4 class="text-center">Změna hesla</h4>
            <div class="form-group">
                <label class="col-md-5 form-control-label form-login-label" for="pwd">Stávající heslo:</label>
                <div class="col-md-3">
                    <?php echo $this->Form->password('current_password', array('placeholder'=>'Stávající heslo', 'id'=>'pwd')); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-5 form-control-label form-login-label" for="pwd">Nové heslo:</label>
                <div class="col-md-3">
                    <?php echo $this->Form->password('password', array('placeholder'=>'Nové heslo', 'id'=>'pwd')); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-5 form-control-label form-login-label" for="pwd2"></label>
                <div class="col-md-3">
                    <?php echo $this->Form->password('pass', array('placeholder'=>'Nové heslo znovu', 'id'=>'pwd2')); ?>
                </div>
            </div>
<hr>
            <p class="text-center text-danger">Pro zachování stávajících údajů nechte pole prázdné</p>
            <div class="form-group">
                <div class="col-md-offset-5 col-md-3">
                    <?php echo $this->Form->button('Upravit údaje', ['class' => 'btn btn-primary']); ?>
                </div>
            </div>
            <?php echo $this->Form->end(); ?>
    </div>
</div>