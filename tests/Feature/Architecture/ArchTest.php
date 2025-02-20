<?php

    use App\Http\Controllers\AdminController;

    arch()->preset()->laravel()
        ->ignoring(AdminController::class);
