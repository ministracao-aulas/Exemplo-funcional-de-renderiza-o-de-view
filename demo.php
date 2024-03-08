<?php

require_once __DIR__ . '/view-helpers.php';

$conteudo = f2_view_get('modals.minha-modal', [
    'aaa' => 'Valor',
]);

echo $conteudo;

f2_view_render('modals.minha-modal', [
    'aaa' => 'Valor',
]);

echo PHP_EOL;

f2_view_unsafe_render('modals.minha-modal', [
    'aaa' => 'Valor',
]);

echo PHP_EOL;
