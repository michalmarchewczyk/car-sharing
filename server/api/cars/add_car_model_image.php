<?php

function add_car_model_image($id, $image): bool {
    $target_dir = '../../data/photos/car_models/';
    $target_file = $target_dir.$id.'.jpg';

    if(!$image['tmp_name']){
        return false;
    }

    $check = getimagesize($image['tmp_name']);
    if(!$check){
        return false;
    }
    if ($image["size"] > 10*1024*1024) {
        return false;
    }
    move_uploaded_file($image["tmp_name"], $target_file);
    return false;
}
