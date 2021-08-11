<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home1');
Auth::routes();
// author
Route::middleware('auth')->get('/author/my-articles', [App\Http\Controllers\AuthorController::class, 'index'])->name('my-submissions');
Route::middleware('auth')->get('/author/my-articles/{id}', [App\Http\Controllers\AuthorController::class, 'show'])->name('author-article');
Route::middleware('auth')->get('/author/my-articles/{id}/pdf/{type}', [App\Http\Controllers\AuthorController::class, 'showCoverPDF'])->name('author.download');
Route::middleware('auth')->get('/author/submit-article', [App\Http\Controllers\AuthorController::class, 'submit'])->name('submit-article');
Route::middleware('auth')->post('/author/author/submit', [App\Http\Controllers\AuthorController::class, 'store'])->name('author.submit');

// me
Route::middleware('auth')->get('/me/articles', [App\Http\Controllers\ManagingEditorController::class, 'index'])->name('me.articles');
Route::middleware('auth')->get('/me/articles/{id}', [App\Http\Controllers\ManagingEditorController::class, 'show'])->name('me.article');
Route::middleware('auth')->post('/me/update-file', [App\Http\Controllers\ManagingEditorController::class, 'updateFile'])->name('me.update-file');
Route::middleware('auth')->get('/me/articles/{id}/pdf/{type}', [App\Http\Controllers\ManagingEditorController::class, 'showCoverPDF'])->name('me.download-file');
Route::middleware('auth')->post('/me/add-reviewer', [App\Http\Controllers\ManagingEditorController::class, 'newReviewer'])->name('me.add-reviewer');
Route::middleware('auth')->post('/me/send-invitation', [App\Http\Controllers\ManagingEditorController::class, 'sendInvitation'])->name('me.send-invitation');
Route::middleware('auth')->post('/me/forward-sme', [App\Http\Controllers\ManagingEditorController::class, 'forwardSME'])->name('me.forward-sme');
Route::middleware('auth')->post('/me/forward-eic', [App\Http\Controllers\ManagingEditorController::class, 'forwardEIC'])->name('me.forward-eic');
Route::middleware('auth')->post('/me/notify', [App\Http\Controllers\ManagingEditorController::class, 'notify'])->name('me.notify');
Route::middleware('auth')->get('/me/pdf', [App\Http\Controllers\ManagingEditorController::class, 'abstractToPDF'])->name('me.pdf');

// sme
Route::middleware('auth')->get('/sme/articles', [App\Http\Controllers\SubjectMatterEditorController::class, 'index'])->name('sme.articles');
Route::middleware('auth')->get('/sme/users', [App\Http\Controllers\SubjectMatterEditorController::class, 'SMEs'])->name('sme.users');
Route::middleware('auth')->get('/sme/articles/{id}', [App\Http\Controllers\SubjectMatterEditorController::class, 'show'])->name('sme.article');
Route::middleware('auth')->post('/sme/update-file', [App\Http\Controllers\SubjectMatterEditorController::class, 'updateFile'])->name('sme.update-file');
Route::middleware('auth')->get('/sme/articles/{id}/pdf/{type}', [App\Http\Controllers\SubjectMatterEditorController::class, 'showCoverPDF'])->name('sme.download-file');
Route::middleware('auth')->post('/sme/add-reviewer', [App\Http\Controllers\SubjectMatterEditorController::class, 'newReviewer'])->name('sme.add-reviewer');
Route::middleware('auth')->post('/sme/forward-me', [App\Http\Controllers\SubjectMatterEditorController::class, 'forwardME'])->name('sme.forward-me');
Route::middleware('auth')->post('/sme/forward-eic', [App\Http\Controllers\SubjectMatterEditorController::class, 'forwardEIC'])->name('sme.forward-eic');
Route::middleware('auth')->post('/sme/recommend', [App\Http\Controllers\SubjectMatterEditorController::class, 'recommend'])->name('sme.recommend');


// eic
Route::middleware('auth')->get('/eic/articles', [App\Http\Controllers\EditorInChiefController::class, 'index'])->name('eic.articles');
Route::middleware('auth')->get('/eic/articles/{id}', [App\Http\Controllers\EditorInChiefController::class, 'show'])->name('eic.article');
Route::middleware('auth')->get('/eic/articles/{id}/pdf/{type}', [App\Http\Controllers\EditorInChiefController::class, 'showCoverPDF'])->name('eic.download-file');
Route::middleware('auth')->post('/eic/add-reviewer', [App\Http\Controllers\EditorInChiefController::class, 'newReviewer'])->name('eic.add-reviewer');
Route::middleware('auth')->post('/eic/forward-me', [App\Http\Controllers\EditorInChiefController::class, 'forwardME'])->name('eic.forward-me');
Route::middleware('auth')->post('/eic/forward-sme', [App\Http\Controllers\EditorInChiefController::class, 'forwardSME'])->name('eic.forward-sme');
Route::middleware('auth')->post('/eic/decision', [App\Http\Controllers\EditorInChiefController::class, 'decision'])->name('eic.decision');




// reviewer
Route::middleware('auth')->get('/reviewer/articles', [App\Http\Controllers\ReviewerController::class, 'index'])->name('reviewer.articles');
Route::middleware('auth')->get('/reviewer/articles/{id}/reviewer/{reviewer_id}', [App\Http\Controllers\ReviewerController::class, 'show'])->name('reviewer.article');
Route::get('/reviewer/accept/{id}', [App\Http\Controllers\ReviewerController::class, 'accept'])->name('reviewer.accept');
Route::get('/reviewer/decline/{id}', [App\Http\Controllers\ReviewerController::class, 'decline'])->name('reviewer.decline');
Route::middleware('auth')->post('/reviewer/articles/{id}/review', [App\Http\Controllers\ReviewerController::class, 'review'])->name('reviewer.review');
Route::middleware('auth')->get('/reviewer/articles/{id}/pdf/{type}', [App\Http\Controllers\ReviewerController::class, 'showCoverPDF'])->name('reviewer.download-file');

//admin
Route::middleware('auth')->get('/admin/users', [App\Http\Controllers\UserController::class, 'index'])->name('admin.users');
Route::middleware('auth')->post('/admin/users', [App\Http\Controllers\UserController::class, 'store'])->name('admin.add-user');
Route::middleware('auth')->put('/admin/users', [App\Http\Controllers\UserController::class, 'update'])->name('admin.update-user');
Route::middleware('auth')->post('/admin/role/assign', [App\Http\Controllers\RoleController::class, 'assign'])->name('admin.assign-role');


//issue
Route::middleware('auth')->get('/admin/issues', [App\Http\Controllers\IssueController::class, 'index'])->name('issue.all');
Route::middleware('auth')->get('/admin/issues/{issue}', [App\Http\Controllers\IssueController::class, 'show'])->name('issue.show');
Route::middleware('auth')->post('/admin/issues', [App\Http\Controllers\IssueController::class, 'store'])->name('issue.insert');
Route::middleware('auth')->put('/admin/issues', [App\Http\Controllers\IssueController::class, 'update'])->name('issue.update');
Route::middleware('auth')->delete('/admin/issues/{issue}', [App\Http\Controllers\IssueController::class, 'destroy'])->name('issue.delete');

// published article
Route::middleware('auth')->post('/admin/published-article', [App\Http\Controllers\PublishedArticleController::class, 'store'])->name('published-article.insert');
Route::middleware('auth')->put('/admin/published-article/{publishedArticle}', [App\Http\Controllers\PublishedArticleController::class, 'update'])->name('published-article.update');
Route::middleware('auth')->delete('/admin/published-article/{publishedArticle}', [App\Http\Controllers\PublishedArticleController::class, 'destroy'])->name('published-article.delete');


// published article
Route::middleware('auth')->post('/admin/published-article-keyword', [App\Http\Controllers\PublishedArticleKeywordController::class, 'store'])->name('keyword.insert');
Route::middleware('auth')->delete('/admin/published-article-keyword/{publishedArticleKeyword}', [App\Http\Controllers\PublishedArticleKeywordController::class, 'destroy'])->name('keyword.delete');

//page
Route::get('/p/{slug}', [App\Http\Controllers\PageController::class, 'show'])->name('page');
Route::get('/page', [App\Http\Controllers\PageController::class, 'index'])->name('pages');
Route::get('/issues/archive/{year}', [App\Http\Controllers\IssueController::class, 'archive'])->name('issue.archive');
Route::get('/issues/{slug}', [App\Http\Controllers\IssueController::class, 'issue'])->name('issue.issue');
Route::get('/issues/{issueSlug}/article/{slug}', [App\Http\Controllers\PublishedArticleController::class, 'show'])->name('article');



Route::get('/clear-cache1', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});
