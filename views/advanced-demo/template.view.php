<?php

$prepare = f2_view_get('advanced-demo.top', [
    'title' => 'Meu titulo',
]);

$prepare .= f2_view_get('advanced-demo.content', [
    'content' => $content ?? null,
]);

$prepare .= f2_view_get('advanced-demo.footer');


return $prepare ?? null;
