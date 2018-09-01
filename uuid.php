<?php
require 'vendor/autoload.php';

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

try{
    $uuid1 = Uuid::uuid1();
    echo $uuid1->toString()."<br/>";
    $uuid3 = Uuid::uuid3(Uuid::NAMESPACE_DNS,'hellowba.net');
    echo $uuid3->toString()."<br/>";
    $uuid4 = Uuid::uuid4();
    echo $uuid4->toString()."<br/>";
    $uuid5 = Uuid::uuid5(Uuid::NAMESPACE_DNS,'helloweba.net');
    echo $uuid5->toString()."<br/>";
}catch (UnsatisfiedDependencyException $e){
    echo 'Caught exception: '.$e->getMessage()."<br/>";
}