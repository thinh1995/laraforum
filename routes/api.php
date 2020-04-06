<?php

Route::apiResource('/question', 'QuestionController');
Route::apiResource('/category', 'CategoryController');
Route::apiResource('/question/{question}/reply', 'ReplyController');
Route::post('/like/{reply}', 'LikeControler@likeIt');
Route::delete('/like/{reply}', 'LikeControler@unLikeIt');
