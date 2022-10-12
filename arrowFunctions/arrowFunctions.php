<?php

$nums = [1,2,3,4];

$mult =  2;

$res = array_map(fn ($item) => $item * $mult, $nums);

var_dump($res);