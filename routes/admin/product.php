<?php
use App\Http\Controllers\Admin\ProductController;


// Product
    Route::get('/product', [ProductController::class, 'index'])->name('product');
    Route::post('/product/get-data', [ProductController::class, 'getResultData'])->name('product.data');
    Route::get('/product/create/', [ProductController::class, 'create'])->name('product.create');
    Route::post('/product/form', [ProductController::class, 'form'])->name('product.form');
    Route::post('/product/save', [ProductController::class, 'save'])->name('product.save');
    Route::get('/product/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::post('/product/delete', [ProductController::class, 'delete'])->name('product.delete');
