<?php

if (!defined('F2_VIEW_DIR')) {
    define('F2_VIEW_DIR', __DIR__ . '/views/');
}

if (!defined('F2_VIEW_DEBUG_TYPE')) {
    define('F2_VIEW_DEBUG_TYPE', 'throw'); // log|throw|die|ignore
}

if (!function_exists('f2_view_log')) {
    /**
     * function f2_view_log
     *
     * @param mixed $content
     * @param string $type
     *
     * @return void
     */
    function f2_view_log(mixed $content, string $type = 'log'): void
    {
        $type = match ($type) {
            'error' => 'error',
            'log' => 'log',
            'info' => 'info',
            default => 'log',
        };

        file_put_contents(
            __DIR__ . '/view_logs.log',
            sprintf(
                '[%s] [%s] %s' . PHP_EOL,
                date('c'),
                $type,
                var_export($content, true)
            )
        );
    }
}

if (!function_exists('f2_view_action_on_error')) {
    /**
     * function f2_view_action_on_error
     *
     * @param \Throwable|string $message
     *
     * @return void
     */
    function f2_view_action_on_error(
        \Throwable|string $message = '',
        int $statusCode = 500,
    ): void {
        http_response_code($statusCode);

        if (!defined('F2_VIEW_DEBUG_TYPE')) {
            die(is_a($message, \Throwable::class) ? $message?->getTraceAsString() : $message);
        }

        $debugMode = constant('F2_VIEW_DEBUG_TYPE');

        f2_view_log(
            is_a($message, \Throwable::class) ? $message?->getTraceAsString() : $message,
            'error'
        );

        match ($debugMode) {
            'log' => f2_view_log($message, 'error'),
            'throw' => throw (
                is_a($message, \Throwable::class)
                ? $message
                : new \Exception($message ?: 'Error on view', 1)
            ),
            'die' => die ($message),
            'ignore' => null,
            default => die ($message),
        };
    }
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
     * Retorna o conteúdo da view (sem imprimir na tela)
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

        if (!is_file($viewPath)) {
            f2_view_action_on_error(new \Exception("File do not exists. [{$viewPath}]", 1));
            return  null;
        }

        try {
            $content = function($viewPath) use ($data) {
                extract($data);
                return print_r(require $viewPath, true);
            };

            return $content($viewPath);
        } catch (\Throwable $th) {
            f2_view_action_on_error($th);
            return null;
        }
    }
}

if (!function_exists('f2_view_render')) {
    /**
     * function f2_view_render
     *
     * Renderiza diretamente o conteúdo da view
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
        if (!$safe) {
            echo f2_view_get($view, $data, $fromViewDir);
            return;
        }

        echo htmlentities(f2_view_get($view, $data, $fromViewDir));
    }
}

if (!function_exists('f2_view_unsafe_render')) {
    /**
     * function f2_view_unsafe_render
     *
     * Renderiza diretamente o conteúdo da view
     *
     * @param string $view
     * @param array $data
     *
     * @return void
     */
    function f2_view_unsafe_render(
        string $view,
        array $data = [],
        ?string $fromViewDir = null,
    ): void {
        echo f2_view_get($view, $data, $fromViewDir);
    }
}
