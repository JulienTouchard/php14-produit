<?php

function debug($tableau)
{
    echo '<pre style="height:200px;overflow: scroll; font-size: .8em;padding: 10px;font-family: Consolas, Monospace; background-color: #000;color:#fff;">';
    print_r($tableau);
    echo '</pre>';
}
function dd($tableau)
{
    echo '<pre style="height:200px;overflow: scroll; font-size: .8em;padding: 10px;font-family: Consolas, Monospace; background-color: #000;color:#fff;">';
    var_dump($tableau);
    echo '</pre>';
    die;
}

function validText($errors,$value,$key,$min,$max,$mandatory=true){
    if(!empty($value)) {
        if(mb_strlen($value) < $min) {
            $errors[$key] = 'Min '.$min.' caractères';
        } elseif(mb_strlen($value) > $max ) {
            $errors[$key] = 'Max '.$max.' caractères';
        }
    } else {
        if($mandatory){
            $errors[$key] = 'Veuillez renseigner ce champ';
        }
    }
    return $errors;
}

function validEmail($errors,$value,$key = 'email') {
    if(!empty($value)) {
        if (filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
            $errors[$key] = 'Veuillez renseigner un email valide.';
        }
    } else {
        $errors[$key] = 'Veuillez renseigner un email.';
    }
    return $errors;
}

function viewError($errors,$key) {
    if(!empty($errors[$key])) {
        echo $errors[$key];
    }
}
// gestion des failles xss
function xss($value){
    return trim(strip_tags($value));
}

// gestion des images 
function imageManager( $files,$assetsUrl,$widthMax,$widthMin,$entity,$image){

// Je prépare une fonction qui sera répétée dans Update mais aussi pour
        // créer les images de mes produits
        // les paramêtres utiles à ma function :
        /* $files = $_FILES['avatar'];
        $assetsUrl = "../asset/";
        $widthMax = 300;
        $widthMin = 50;
        $entity = "avatar"; */
        
        // la logique de ma fonction
        $newImgName = explode(".",$files['name']);
        $newImgName = $newImgName[0];
        
        
        // pour redimensionner mon image j'utilise mon bundle gumlet/php-image-resize
        $image->resizeToWidth($widthMax);
        // Comment récupérer le nom de l'image sans l'extension que je veux modifier (webp)
        // récupeer une image avatar de 300px de large max
        $image->save($assetsUrl."img/$entity/".$newImgName.".webp", IMAGETYPE_WEBP);
        // opération suivante  : la meme chose mais avec une miniature de 50px de width
        // uploadée dans le dossier thumbnail
        $image->resizeToWidth($widthMin);
        $image->save($assetsUrl."img/$entity/thumbnail/".$newImgName.".webp", IMAGETYPE_WEBP);
        // dernière étape  : supprimer l'image originale d'uplaod devenue inutile
        unlink($assetsUrl."upload/" . $files['name']);
        // fin de ma function 
        // je teste avant d'en faire une fonction
}