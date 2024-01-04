<?php

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

function uploadToS3($folder, $imagedata, $filename){
    $s3 = new S3Client([
        'version' => AWS_VERSION,
        'region'  => AWS_REGION,
        'credentials' => [
            'key'    => ACCESS_KEY_ID,
            'secret' => ACCESS_KEY_SECRET
        ]
    ]);

    try {
        $result = $s3->putObject([
            'Bucket' => S3_BUCKET_NAME,
            'Key'    => S3_BUCKET_KEY . $folder . '/' . $filename . '.png',
            'Body'   => base64_decode($imagedata),
            'ContentType' => 'image/png',
            'ACL'    => 'public-read'
        ]);
    } catch (S3Exception $e) {
        echo $e->getMessage() . PHP_EOL;
    }

    return $filename;

}

function uploadImage($filename, $imagedata){
    file_put_contents('img/temp/'. $filename . '.png', $imagedata );
}

