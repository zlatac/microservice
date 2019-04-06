<?php

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

Route::get('/', function () {
    return view('twisted');
});

Route::post('/my','UploadCsv@collect');

Route::get('/fz', 'UploadCsv@ballz');

Route::get('/test', function(){
    return view('index');
});

Route::post('/form','UploadCsv@dope');

Route::post('/mail', 'UploadCsv@sendMail');

Route::get('/why', 'Hackathon@beastmode');

Route::get('/mocha/{insta?}', 'UploadCsv@getData');

Route::get('/contest', 'UploadCsv@mochaContest');

Route::get('/fzcontest', 'UploadCsv@fzMochaContest');

Route::get('/dmzcontest', 'UploadCsv@dmzMochaContest');

Route::get('/leaderboard', 'UploadCsv@getLeader');

Route::get('/fzleaderboard', 'UploadCsv@fzGetLeader');

Route::get('/dmzleaderboard', 'UploadCsv@dmzGetLeader');

Route::get('/lzcontest', 'UploadCsv@lzMochaContest');
Route::get('/lzleaderboard', 'UploadCsv@lzGetLeader');

Route::get('/borocontest', 'UploadCsv@boroMochaContest');
Route::get('/apileaderboard', 'UploadCsv@apiGetLeader');
Route::get('/apianalytics', 'UploadCsv@apiGetAnalytics');

Route::get('/nlscontest', 'UploadCsv@nlsMochaContest');

Route::get('/inlightencontest', 'UploadCsv@inlightenMochaContest');
Route::get('/nudnikcontest', 'UploadCsv@nudnikMochaContest');
Route::get('/andelacontest', 'UploadCsv@andelaMochaContest');
Route::get('/odessucontest', 'UploadCsv@odessuMochaContest');
Route::get('/carlacontest', 'UploadCsv@carlaMochaContest');
Route::post('/traffic', 'UploadCsv@submitTraffic');
Route::post('/puzzlesubmit', 'UploadCsv@submitCelebPuzzle');
Route::get('/puzzlechamps', 'UploadCsv@getCurrentChampions');
Route::get('/puzzleoldchamps', 'UploadCsv@getOldChampions');
Route::post('/blessmyrequest', 'UploadCsv@blessMyRequest');
Route::get('/bmrclients', 'UploadCsv@blessMyRequestClients');
Route::get('/bmr-report', 'UploadCsv@blessMyRequestReport');

Route::post('/bmr-vip/{club}/{insta}/{expiry_date}/{limit}', 'UploadCsv@bmrAddToVip');
Route::post('/bmr-vip-limit/{club}/{unique_id}', 'UploadCsv@bmrUpdateVipLimit');
Route::get('/bmr-vip/{club}/{insta}/{date}', 'UploadCsv@bmrVerifyVip');

//Route::get('index',function(){
//    return view('index');
//});

