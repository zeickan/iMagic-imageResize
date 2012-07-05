<?php

/**
* @package Resize image and create thumbnails
* @version 1.0
* @author  Andros Romo <me@androsromo.com>
* @twitter @AndrosRomo
* @license GNU GPL
* @desc    Resize any image (including transparent PNGs) and creates thumbnails with specified size or proportion of the original image
* @returns True or False if you want save result in a folder
* @example index.php
* @updated 04/Jul/2012
*/

require("imagic.class.php");

/*

# Example 1 

$image = new imagic();

$image->path = 'images/';
$image->image = 'sintel.jpg';

# Guardamos la imagen

#$image->save = 'tmp/resize-'.$image->image;

# Redimencionamos la imagen a un porcentaje

$image->imageNewSize( '50%' );

// $image->imageNewSize( '150%' );


# O si prefieres puedes seleccionar el numero de pixeles al cual deseas redimencionar la imagen
# La redimencion conservara su aspecto y no la deformara, es decir que si colocas 500
# la imagen redimencionara a 500 en ancho y su proporción en alto

# $image->imageNewSize( 500 ); < Defecto es ancho

# También puedes indicar que el valor que pones es de alto y entonces el valor de ancho sera 
# asignado por proporción 

# $image->imageNewSize( 500 , 'vertical' ); < You can define vertical 

if( $image->resizeImage() ){
    
    echo"Success";
    
} else {
    
    echo"Error";
    
}

*/

# Example 2
# Redimencion con corte de imagen

$image = new imagic();

$image->path = 'images/';
$image->image = 'sintel.jpg';

# Para recortar la imagen utilizamos crop que actuara como mascara para la imagen
# Y mostrara una imagen en este tama–o y nuestra imagen dentro

$image->crop->width = '300';
$image->crop->height = '200';

# Por defecto la imagen se acomodara centrada tanto vertical como horizontalmente
# Pero podemos acomodarla en base a sus cordenadas si eso queremos

#$image->crop->centerX = '100';
#$image->crop->centerY = '-100';

$image->crop->centerX = 'center';
$image->crop->centerY = 'center';

# Guardamos la imagen

#$image->save = 'tmp/resize-'.$image->image;

# Redimencionamos la imagen a un porcentaje, esto nos ayudara a crear miniaturas
#Êdefiniendo el tama–o de la imagen central incluso pudiendo ser 100% o el tama–o
# original de la imagen 

$image->imageNewSize( '500' ); // 500px de ancho

// $image->imageNewSize( '100%' ); // tama–o original

# O si prefieres puedes seleccionar el numero de pixeles al cual deseas redimencionar la imagen
# La redimencion conservara su aspecto y no la deformara, es decir que si colocas 500
# la imagen redimencionara a 500 en ancho y su proporción en alto

# $image->imageNewSize( 500 ); < Defecto es ancho

# También puedes indicar que el valor que pones es de alto y entonces el valor de ancho sera 
# asignado por proporción 

# $image->imageNewSize( 500 , 'vertical' ); < You can define vertical

# Llamamos a la funcion cropImage para recortarla, en un futura ambas funciones
# quedaran unificadas pero de moment

if( $image->cropImage() ){
    
    echo"Success";
    
} else {
    
    echo"Error";
    
}

#echo"<pre>".print_r($image->imagen,1)."</pre>";