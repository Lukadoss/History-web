<div class="card">
    <div class="card-header">Přihlášení uživatele
    </div>
    <div class="card-block">
        <?= $this->Flash->render(); ?>
        <form class="form-horizontal" role="form" action="" method="POST">
            <div class="form-group">
                <label class="col-md-5 form-control-label form-login-label" for="email">Email:</label>
                <div class="col-md-3">
                    <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-5 form-control-label form-login-label" for="password">Heslo:</label>
                <div class="col-md-3">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Heslo"
                           required>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-5 col-sm-3">
                    <button type="submit" name="submit-login" class="btn btn-primary" value="submit">Přihlásit</button>
                </div>
            </div>
        </form>
        <hr>
        <p style="text-align:center">Ještě nemáš účet? <?php echo $this->Html->link(__('Zaregistruj se.'), [
                'controller' => 'Users',
                'action' => 'registration'
            ]) ?></p>
        <p style="text-align:center"><?php echo $this->Html->link(__('Zapomenuté heslo.'), [
                'controller' => 'Users',
                'action' => 'lostpassword'
            ]) ?></a></p>
    </div>
</div>