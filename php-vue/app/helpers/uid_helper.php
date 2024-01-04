<?php

function decryptUid($uid)
{
    // 暗号化＆復号化キー
    $key = md5('xxx');
    // 暗号化モジュール使用開始
    $td = mcrypt_module_open('des', '', 'ecb', '');
    $key = substr($key, 0, mcrypt_enc_get_key_size($td));
    $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
    // 暗号化モジュール初期化
    if (mcrypt_generic_init($td, $key, $iv) < 0) {
        exit('error.');
    }
    // データを復号化
    $cnv_uid = strtr($uid, '-_', '+/');
    $cnv_uid = str_pad($cnv_uid, strlen($uid) % 4, '=', STR_PAD_RIGHT);
    $cnv_uid = base64_decode($cnv_uid);
    if ($cnv_uid !== '') {
        $decrypt_uid = mdecrypt_generic($td, $cnv_uid);
    } else {
        $decrypt_uid = false;
    }
    // 暗号化モジュール使用終了
    mcrypt_generic_deinit($td);
    mcrypt_module_close($td);

    // なぜかくっついてる空白文字を削除
    return preg_replace('/(\s|　|\0)/', '', $decrypt_uid);
}
