<?php

if (!defined('F2_VIEW_DIR')) {
    define('F2_VIEW_DIR', __DIR__ . '/views/');
}

if (!function_exists('f2_view_path_get')) {
    /**
     * function f2_view_path_get
     *
     * Retorna o camionho onde deverá estar a view
     *
     * @param string $view
     * @param ?string $fromViewDir
     *
     * @return ?string
     */
    function f2_view_path_get(
        string $view,
        ?string $fromViewDir = null,
    ): ?string {
        $fromViewDir ??= F2_VIEW_DIR;
        $view = trim($view, '/\\');
        $parsedViewLocation = str_replace('.', '/', $view) . '.view.php';
        $viewPath = rtrim($fromViewDir, '\\/') . '/' . trim($parsedViewLocation, '/\\');

        return $viewPath;
    }
}

if (!function_exists('f2_view_get')) {
    /**
     * function f2_view_get
     *
     * Retorna o conteúdo da view
     *
     * @param string $view
     * @param array $data
     * @param ?string $fromViewDir
     *
     * @return ?string
     */
    function f2_view_get(
        string $view,
        array $data = [],
        ?string $fromViewDir = null,
    ): ?string {
        $viewPath = f2_view_path_get($view, $fromViewDir);
        return $viewPath;
    }
}

if (!function_exists('f2_view_render')) {
    /**
     * function f2_view_render
     *
     * Renderiza o conteúdo da view
     *
     * @param string $view
     * @param array $data
     * @param bool $safe
     *
     * @return void
     */
    function f2_view_render(
        string $view,
        array $data = [],
        bool $safe = true,
        ?string $fromViewDir = null,
    ): void {
        //
    }
}
