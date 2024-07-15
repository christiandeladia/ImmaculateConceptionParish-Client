<?php
require 'vendor/autoload.php';

use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;
Configuration::instance([
    'cloud' => [
      'cloud_name' => 'dkjg38sv5', 
      'api_key' => '681886933897461', 
      'api_secret' => 'fDDQ5doWkR19WQPto4h-eyqFf1A'],
    'url' => [
      'secure' => true]]);
(new UploadApi())->upload('image/cert.jpg')
?>
