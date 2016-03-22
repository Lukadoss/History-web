<div class="card card-block">
    <h4 class="card-title text-center">Přihlášení uživatele</h4>
    <hr>
    <form class="form-horizontal" role="form" action="/historyweb/uzivatel/login" method="post">
        <div class="form-group">
            <label class="col-md-5 form-control-label form-login-label" for="email">Email:</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="email" id="email" placeholder="Email" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-5 form-control-label form-login-label" for="pwd">Heslo:</label>
            <div class="col-md-3">
                <input type="password" class="form-control" name="password" id="password" placeholder="Heslo" required>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-5 col-sm-3">
                <button type="submit" name="login" class="btn btn-primary">Přihlásit</button>
            </div>
        </div>
    </form>
    <hr>
    <p style="text-align:center">Ještě nemáš účet? <?php echo $this->Html->link(__('Zaregistruj se.'), [
            'controller' => 'Uzivatel',
            'action' => 'registrace'
        ]) ?></p>
    <p style="text-align:center"><a href="">Zapomenuté heslo</a></p>
</div>