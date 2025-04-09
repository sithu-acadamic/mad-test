<?php
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Inquiries\InquiriesController;
use App\Http\Controllers\Library\DropdownController;
use App\Http\Controllers\Settings\SettingsController;
use App\Http\Controllers\Review\GoogleReviewController;
use App\Http\Controllers\Settings\PartnershipLogoController;
use App\Http\Controllers\Service\OurServiceController;
use App\Http\Controllers\Team\TeamController;
use App\Http\Controllers\Blog\BlogController;
use App\Http\Controllers\Admin\AdminController;
// Inquiries
Route::get('/inquiries/inbox', [InquiriesController::class, 'index'])->name('inquiries.inbox');
Route::get('/inquiries/details', [InquiriesController::class, 'inquiryDetails'])->name('inquiries.details');

// brand
Route::post('/brand/details', [DropdownController::class, 'getSupplier'])->name('brand.details');

Route::post('/brand/parts', [DropdownController::class, 'getParts'])->name('part.details');

Route::post('/inquiries/map-vendors', [InquiriesController::class, 'mapVendorToInquiry'])->name('inquiries.mapVendors');

Route::post('/get/vendors', [InquiriesController::class, 'getVendor'])->name('get.vendors');

Route::get('/settings', [SettingsController::class, 'index'])->name('settings');

Route::post('/update-section-image', [SettingsController::class, 'updateSectionImage'])->name('section.image');

Route::get('/google-review', [GoogleReviewController::class, 'index'])->name('review');
Route::post('/reviews/store', [GoogleReviewController::class, 'store'])->name('reviews.store');
Route::post('/reviews/update/{review}', [GoogleReviewController::class, 'update'])->name('reviews.update');
Route::delete('/reviews/delete/{review}', [GoogleReviewController::class, 'destroy'])->name('reviews.destroy');
Route::post('/reviews/toggle-status/{review}', [GoogleReviewController::class, 'toggleStatus'])->name('reviews.toggleStatus');



Route::get('/partnership-logos', [PartnershipLogoController::class, 'index'])->name('partnershipLogo');
Route::post('/partnership-logos/store', [PartnershipLogoController::class, 'store'])->name('partnership-logos.store');
Route::get('/partnership-logos/edit/{id}', [PartnershipLogoController::class, 'edit'])->name('partnership-logos.edit');
Route::post('/partnership-logos/update/{id}', [PartnershipLogoController::class, 'update'])->name('partnership-logos.update');
Route::post('/partnership-logos/delete/{id}', [PartnershipLogoController::class, 'destroy'])->name('partnership-logos.destroy');
Route::post('/partnership-logos/toggle-status/{id}', [PartnershipLogoController::class, 'toggleStatus'])->name('partnership-logos.toggle-status');

Route::get('our-services', [OurServiceController::class, 'index'])->name('our-services.index');
Route::post('our-services/store', [OurServiceController::class, 'store'])->name('our-services.store');
Route::get('our-services/edit/{id}', [OurServiceController::class, 'edit'])->name('our-services.edit');
Route::post('our-services/update/{id}', [OurServiceController::class, 'update'])->name('our-services.update');
Route::post('our-services/destroy/{id}', [OurServiceController::class, 'destroy'])->name('our-services.destroy');
Route::post('/our-services/toggle-status/{id}', [OurServiceController::class, 'toggleStatus'])->name('our-services.toggle-status');

Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');
Route::post('/teams/store', [TeamController::class, 'store'])->name('teams.store');
Route::post('/teams/update/{id}', [TeamController::class, 'update'])->name('teams.update');
Route::delete('/teams/destroy/{id}', [TeamController::class, 'destroy'])->name('teams.destroy');
Route::post('/teams/toggle-status/{id}', [TeamController::class, 'toggleStatus'])->name('teams.toggle-status');

Route::post('/teams/reorder', [TeamController::class, 'reorder'])->name('teams.reorder');


Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
Route::post('/blogs/store', [BlogController::class, 'store'])->name('blogs.store');
Route::post('/blogs/update/{blog}', [BlogController::class, 'update'])->name('blogs.update');
Route::delete('/blogs/delete/{blog}', [BlogController::class, 'destroy'])->name('blogs.destroy');
Route::post('/blogs/toggle-status/{blog}', [BlogController::class, 'toggleStatus'])->name('blogs.toggle-status');


Route::get('/user', [AdminController::class, 'index'])->name('user.index');
Route::post('/user/store', [AdminController::class, 'store'])->name('user.store');
Route::post('/user/update/{id}', [AdminController::class, 'update'])->name('user.update');
Route::delete('/user/delete/{id}', [AdminController::class, 'destroy'])->name('user.destroy');






