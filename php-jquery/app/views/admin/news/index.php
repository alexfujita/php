<?php require APP_ROOT . '/views/includes/admin/header.php'; ?>
<div class="container">
<table>
  <thead>
    <tr>
      <th>日付</th>
      <th>タイトル</th>
      <th>内容</th>
      <th>画像</th>
      <th>編集</th>
      <th>削除</th>
    </tr>
  </thead>
  <tbody>
      <?php foreach($data as $news) : ?>
    <tr>
      <td class="w-10"><?php echo $news->date; ?></td>
      <td class="w-30"><?php echo $news->title; ?></td>
      <td class="w-40"><?php echo $news->body; ?></td>
      <td class="w-10"><img src="<?php echo is_null($news->image) ? URL_ROOT . '/public/img/no-photo.png' : $news->image; ?>" class="admin-img" alt=""></td>
      <td class="w-5"><a href="<?php echo URL_ROOT . '/admin/news/' . $news->id; ?>"><img src="<?php echo URL_ROOT; ?>/icons/edit.svg" width="15px" alt=""></a></td>
      <td class="w-5"><img src="<?php echo URL_ROOT; ?>/icons/delete.svg" width="15px" alt=""></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
</div>

<?php require APP_ROOT . '/views/includes/footer.php'; ?>