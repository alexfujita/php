<?php require APP_ROOT . '/views/includes/admin/header.php'; ?>
<div class="container">
<table>
  <thead>
    <tr>
      <th>物名件</th>
      <th>ファイル名</th>
      <th>フィーチャー画像</th>
      <th></th>
      <th></th>
    </tr>
  </thead>
  <tbody>
      <?php foreach($data as $photo) : ?>
    <tr>
      <td><?php echo $photo->property_ja; ?></td>
      <td><?php echo $photo->filename; ?></td>
      <td><?php echo $photo->is_feature; ?></td>
      <td><a href="<?php echo URL_ROOT . '/photo/edit/' . $photo->id; ?>"><img src="<?php echo URL_ROOT; ?>/icons/edit.svg" width="15px" alt=""></a></td>
      <td><img src="<?php echo URL_ROOT; ?>/icons/delete.svg" width="15px" alt=""></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
</div>

<?php require APP_ROOT . '/views/includes/footer.php'; ?>