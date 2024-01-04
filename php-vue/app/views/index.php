<?php require APP_ROOT . '/views/includes/head.php'; ?>
<div class="container">
    <div class="row flex-column">
        <div class="subheader">
            <h3>ログイン</h3>
        </div>

        <div class="row">
            <form action="<?php echo URL_ROOT; ?>/index" method="post" class="col s12">
                <div class="row">
                    <div class="input-field col s12">
                        <input name="name" id="first_name" type="text" class="<?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['name']; ?>">
                        <label for="username">Username</label>
                        <span class="invalid-feedback"><?php echo $data['name_err']; ?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input name="password" id="password" type="password" class="<?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['password']; ?>">
                        <label for="password">Password</label>
                        <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
                    </div>
                </div>
                <div class="row" style="padding-top: 40px">
                    <div class="input-field col s12">
                        <button class="btn waves-effect waves-light" type="submit" name="action">送信
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require APP_ROOT . '/views/includes/footer.php'; ?>