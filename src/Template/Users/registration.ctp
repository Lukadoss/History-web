<div class="card card-block">
    <h4 class="card-title text-center">Registrace nového uživatele</h4>
    <hr>
    <?php echo $this->Form->create($user); ?>
    <form action="" class="form-horizontal" role="form" method="POST" data-toggle="validator">
        <div class="row">
            <div class="form-group">
                <label class="col-md-5 form-control-label form-login-label" for="email">Email:</label>
            <div class="col-md-3">
                <?php echo $this->Form->email('email', array('placeholder'=>'Email', 'id'=>'email')); ?>
                     <!--  pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" -->
            </div>
            </div>
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
            <div class="form-group">
                <label class="col-md-5 form-control-label form-login-label" for="pwd">Heslo:</label>
                <div class="col-md-3">
                    <?php echo $this->Form->password('password', array('placeholder'=>'Heslo', 'id'=>'pwd')); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-5 form-control-label form-login-label" for="pwd2"></label>
                <div class="col-md-3">
                    <?php echo $this->Form->password('pass', array('placeholder'=>'Heslo znovu', 'id'=>'pwd2')); ?>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-offset-5 col-md-3">
                    <?php echo $this->Form->button('Registrovat', ['class' => 'btn btn-primary']); ?>
                </div>
            </div>
        <?php
            echo $this->Form->end();
            echo $this->Flash->render();
        ?>
        </div>
    </form>
</div>