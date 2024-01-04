<?php require APP_ROOT . '/views/includes/admin/header.php'; ?>
<div class="container">
<table>
  <thead>
    <tr>
      <th>年/月</th>
      <th>物件名</th>
      <th></th>
      <th></th>
    </tr>
  </thead>
  <tbody>
      <?php foreach($data as $work) : ?>
    <tr>
      <td><?php echo $work->year; ?></td>
      <td><?php echo $work->property_ja; ?></td>
      <td><a href="<?php echo URL_ROOT . '/work/edit/' . $work->id; ?>"><img src="<?php echo URL_ROOT; ?>/icons/edit.svg" width="15px" alt=""></a></td>
      <td><img src="<?php echo URL_ROOT; ?>/icons/delete.svg" width="15px" alt=""></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
</div>

<?php require APP_ROOT . '/views/includes/footer.php'; ?>