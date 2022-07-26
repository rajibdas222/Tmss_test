<?php

    use App\Http\Controllers\AuthController;
    use App\Http\Controllers\DepartmentController;
    use App\Http\Controllers\ResultController;
    use App\Http\Controllers\StudentController;
    use Illuminate\Support\Facades\Route;


//API route for register and login
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

//Protecting Routes
    Route::group(['middleware' => ['jwt.verify']], function() {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('get_user', [AuthController::class, 'get_user']);
//department
        Route::get('departments', [DepartmentController::class, 'index']);
        Route::post('departments', [DepartmentController::class, 'store']);
        Route::get('departments/{id}/show', [DepartmentController::class, 'show']);
        Route::put('departments/{id}/update', [DepartmentController::class, 'update']);
        Route::delete('departments/{id}/delete', [DepartmentController::class, 'destroy']);
//students
        Route::get('dept_list', [StudentController::class, 'getDepartment']);
        Route::get('students', [StudentController::class, 'index']);
        Route::post('students', [StudentController::class, 'store']);
        Route::get('students/{id}/show', [StudentController::class, 'show']);
        Route::put('students/{id}/update', [StudentController::class, 'update']);
        Route::delete('students/{id}/delete', [StudentController::class, 'destroy']);

//results
        Route::get('st_list', [ResultController::class, 'getStudents']);
        Route::get('results', [ResultController::class, 'index']);
        Route::post('results', [ResultController::class, 'store']);
        Route::get('results/{id}/show', [ResultController::class, 'show']);
        Route::put('results/{id}/update', [ResultController::class, 'update']);
        Route::delete('results/{id}/delete', [ResultController::class, 'destroy']);
        Route::get('results/search', [ResultController::class, 'searchResult']);



    });

