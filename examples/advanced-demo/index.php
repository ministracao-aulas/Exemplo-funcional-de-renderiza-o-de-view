<?php

require_once __DIR__ . '/../../view-helpers.php';

f2_view_unsafe_render('advanced-demo/template', [
    'content' =>  f2_view_get('advanced-demo/meu-arquivo-legal')
]);

echo PHP_EOL;
