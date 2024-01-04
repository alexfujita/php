<?php require APP_ROOT . '/views/includes/head.php'; ?>
<div id="container-members" class="container">
    <div class="row flex-column">
        <div class="subheader" style="width: 100%">
            <h3>◯◯ | ポイント管理画面</h3>
        </div>

        <div class="row">
            <div class="col-md-12">
                <hr>
            </div>
            <table class="striped" id="data-table">
                <thead>
                    <tr>
                        <?php foreach($data['columns'] as $column) : ?>
                            <th class="align-center"><?php echo $column; ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['members'] as $m) : ?>
                    <tr id='<?php echo $m->id; ?>'>
                        <td>
                            <a href='https://admin.xxx.jp/userlist/detail?id="<?php echo $m->uid; ?>"' target='_blank'><?php echo $m->uid; ?></a>
                        </td>
                        <td><?php echo $m->nickname; ?></td>
                        <td><?php echo $m->invites; ?></td>
                        <td><?php echo $m->invited; ?></td>
                        <td><?php echo $m->product; ?></td>
                        <td><?php echo $m->mtgroom; ?></td>
                        <td><?php echo $m->events; ?></td>
                        <td><?php echo $m->posts; ?></td>
                        <td><?php echo $m->chips; ?></td>
                        <td><?php echo $m->bags; ?></td>
                        <td><?php echo $m->level; ?></td>
                        <td><?php echo $m->chips_total; ?></td>
                        <td><?php echo substr($m->created, 0, 10); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <hr>
        </div>
    </div>
</div>
<!-- script references -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
<script src="<?php echo js('bootstrap.min'); ?>"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css"/>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css"/>
<script>
jQuery(function($){
  $("#data-table").DataTable({
    dom: 'Bfrtip',
    buttons:['copy', 'csv', 'excel']
  });
});
</script>
<?php require APP_ROOT . '/views/includes/footer.php'; ?>