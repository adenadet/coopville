<?php 

use Illuminate\Support\Facades\Route;

Route::get('/closures/initials', 'ClosuresController@initials')->name('closures.initials');
Route::post('/contributions/import', 'ContributionsController@import')->name('contributions.import');
Route::get('/contributions/initials', 'ContributionsController@initials')->name('contributions.initials');
Route::get('/dashboard', 'UsersController@dashboard')->name('dashboard');
Route::delete('/guarantees/{guarantor}', 'GuarantorController@death')->name('guarantees.reject');
Route::get('/guarantors/initials', 'GuarantorController@initials')->name('guarantors.initials');
Route::get('/repayments/initials', 'RepaymentsController@initials')->name('repayments.initials');
Route::get('/savings/balance/{id}', 'SavingsController@balance')->name('savings.balance');
Route::get('/savings/branch/{id}', 'SavingsController@branch')->name('savings.branch');
Route::get('/savings/initials', 'SavingsController@initials')->name('savings.initials');
Route::get('/saving_types/initials', 'SavingsTypeController@initials')->name('saving_types.initials');
Route::get('/withdrawals/initials', 'WithdrawalsController@initials')->name('withdrawals.initials');
Route::get('/profile', 'UsersController@profile')->name('profile');
Route::put('/profile', 'UsersController@updateProfile')->name('profile.update');
Route::apiResources([
    'branches' => 'BranchesController',
    'closures' => 'ClosuresController',
    'contributions' => 'ContributionsController',
    'guarantors' => 'GuarantorController',
    'loans' => 'LoansController',
    'payments' => 'PaymentController',
    'repayments' => 'RepaymentsController',
    'savings' => 'SavingsController',
    'users' => 'UsersController',
    'withdrawals' => 'WithdrawalsController',
]);
