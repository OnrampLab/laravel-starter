<?php

use Modules\Core\Http\Controllers\CoreController;

Route::prefix('core')->group(function (): void {
    Route::get('/', [CoreController::class, 'index']);
});
