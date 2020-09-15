<?php
namespace Uxx\Demo;
if (!function_exists('uxx_path')) {
    function uxx_path($path = '')
    {
        return ucfirst(config('uxx.directory')).($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}