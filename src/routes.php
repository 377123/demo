<?php
Route::middleware('uxx.log')->get('hello', function(){
	echo 'Hello from the my-first-laravel-package package!';
});