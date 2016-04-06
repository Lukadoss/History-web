<h2 class="hightitle"><?php __('Forget Password'); ?></h2>
<div class="forgetpwd form" style="margin:5px auto 5px auto;width:450px;">
    <?php echo $this->Flash->render(); ?>
    <?php echo $this->Form->create('User', array('action' => 'reset')); ?>
    <?php
        echo $this->Form->password('password', array('placeholder'=>'Heslo', 'id'=>'pwd'));
        echo $this->Form->password('pass', array('placeholder'=>'Heslo znovu', 'id'=>'pwd2'));
        echo $this->Form->button('Registrovat', ['class' => 'btn btn-primary']);

        echo $this->Form->end();?>
</div>