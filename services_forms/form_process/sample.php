<?php
require 'vendor/autoload.php';

use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;
Configuration::instance([
    'cloud' => [
      'cloud_name' => 'db7kmure7', 
      'api_key' => '156177539645118', 
      'api_secret' => 'Mfq6luSsMbA155I3usVRMvuv_w'],
    'url' => [
      'secure' => true]]);
(new UploadApi())->upload('images.jpg')
?>
