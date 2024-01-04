<?php require APP_ROOT . '/views/includes/head.php'; ?>
<div id="app">
<div class="container">
    <div class="row form">
            <div class="subheader">
                <h3>◯◯　お知らせ　登録完了</h3>
            </div>

            <div class="row">
              <p class="center-align">登録完了いたしました。</p>
            </div>

            <div class="row btn-fluid">
                <div class="col s8">
                <a class="waves-effect waves-light btn-large" href="<?php echo URL_ROOT; ?>/news">
                        お知らせ TOPへ
                    </a>
                </div>
            </div>
    </div>
</div>
</div>

<script text="text/babel">
history.pushState(null, null, location.href);
window.addEventListener('popstate', (e) => {
  history.go(1);
});
</script>

<?php require APP_ROOT . '/views/includes/footer.php'; ?>