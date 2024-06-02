<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

use App\Http\Controllers\Api\FournisseurController;
use App\Http\Controllers\Api\ChapterController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\ChapterArticleController;
use App\Http\Controllers\Api\ChapterArticleProductController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\RoleController;
use App\Models\Role;
use App\Http\Controllers\Api\ParamètreController;
use App\Http\Controllers\Api\QuantitéCommandController;
use App\Http\Controllers\Api\B_C_ExterneController;
use App\Http\Controllers\Api\QuantiteLivréContoller;
use App\Http\Controllers\Api\B_C_InterneController;
use App\Http\Controllers\Api\B_SortieController;
use App\Http\Controllers\QunatiteDemandeController;
use App\Http\Controllers\Api\QuantiteSortieController;
use App\Http\Controllers\Api\StructureController;
use App\Http\Controllers\Api\B_ReceptionController;
use App\Http\Controllers\Api\InvantaireController;
use App\Http\Controllers\Api\QuantitePerduController;
Route::group(['middleware' => ['cors']], function () {
// structure 
Route::post('/structure', [StructureController::class, 'store']);
Route::put('/structure/{id}', [StructureController::class, 'update']);

Route::get('/products', [ProductController::class, 'index'])->middleware('is_able:read-product');
Route::post('/products', [ProductController::class, 'store'])->middleware('is_able:create-product');
Route::get('/products/{id}', [ProductController::class, 'show'])->middleware('is_able:show-product');
Route::put('/products/{id}', [ProductController::class, 'update'])->middleware('is_able:update-product');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->middleware('is_able:delete-product');



Route::get('/articles', [ArticleController::class, 'index'])->middleware('is_able:read-article');
Route::post('/articles', [ArticleController::class, 'store'])->middleware('is_able:create-article');
Route::get('/articles/{article}', [ArticleController::class, 'show'])->middleware('is_able:show-article');
Route::put('/articles/{article}', [ArticleController::class, 'update'])->middleware('is_able:update-article');
Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->middleware('is_able:delete-article');

Route::get('/chapters', [ChapterController::class, 'index'])->middleware('is_able:read-chapter');
Route::post('/chapters', [ChapterController::class, 'store'])->middleware('is_able:create-chapter');
Route::put('/chapters/{id}', [ChapterController::class, 'update'])->middleware('is_able:update-chapter');
Route::delete('/chapters/{id}', [ChapterController::class, 'destroy'])->middleware('is_able:delete-chapter');


Route::prefix('fournisseurs')->group(function () {
    Route::get('/', [FournisseurController::class, 'index'])->middleware('is_able:read-fournisseur');
    Route::post('/', [FournisseurController::class, 'store'])->middleware('is_able:create-fournisseur');
    Route::get('/{id}', [FournisseurController::class, 'show'])->middleware('is_able:show-fournisseur');
    Route::put('/{id}', [FournisseurController::class, 'update'])->middleware('is_able:update-fournisseur');
    Route::delete('//{id}', [FournisseurController::class, 'destroy'])->middleware('is_able:delete-fournisseur');
});

Route::post('/auth/register', [UserController::class, 'createUser']);//->middleware('is_able:create-user');
Route::post('/auth/login', [UserController::class, 'login'])->name('login');


Route::group([
    "middleware" => ["auth:sanctum"]
], function(){
    Route::get("profile", [UserController::class, "profile"]);
    Route::get("logout", [UserController::class, "logout"]);
});

Route::put('/update/{id}', [UserController::class, 'update']);




Route::get('/roles', function(){
  return response()->json(Role::select('id', 'name')->get());
    
});
Route::get('/roles', [RoleController::class, 'index']);
Route::get('/roles/{id}', [RoleController::class, 'show']);
Route::post('/roles', [RoleController::class, 'store']);
Route::put('/roles/{id}', [RoleController::class, 'update']);
Route::delete('/roles/{id}', [RoleController::class, 'destroy']);


Route::get('/paramètres', [ParamètreController::class, 'index'])->middleware('is_able:read-paramaters');
Route::post('/paramètres', [ParamètreController::class, 'store'])->middleware('is_able:create-paramaters');
Route::get('/paramètres/{paramètre}', [ParamètreController::class, 'show'])->middleware('is_able:show-paramaters');
Route::put('/paramètres/{paramètre}', [ParamètreController::class, 'update'])->middleware('is_able:update-paramaters');
Route::delete('/paramètres/{paramètre}', [ParamètreController::class, 'destroy'])->middleware('is_able:delete-paramaters');

// pour le bon de commande externe

Route::prefix('chapters')->group(function () {
    Route::get('/', [ChapterController::class, 'index']);
    Route::get('/{chapter}', [ChapterController::class, 'show']);
});

Route::prefix('chapters/{chapter}/articles')->controller(ChapterArticleController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/{article}', 'show');
});

Route::prefix('chapters/{chapter}/articles/{article}/products')->controller(ChapterArticleProductController::class)->group(function () {
    Route::get('/', 'index'); 
    Route::get('/{product}', 'show');
});

Route::post('/create-bce', [QuantitéCommandController::class, 'store']);//->middleware('is_able:create-bcq');
Route::get('/show-bce/{b_c_externe_id}',[QuantitéCommandController::class, 'show']);
Route::put('/update-bce/{b_c_externe_id}',[QuantitéCommandController::class, 'update']);


 

Route::get('/bce', [B_C_ExterneController::class, 'index'])->middleware('is_able:read-BCE');// liste of bce
Route::post('/bce', [B_C_ExterneController::class, 'store'])->middleware('is_able:create-BCE');
Route::get('/bce/{id}', [B_C_ExterneController::class, 'show'])->middleware('is_able:show-BCE');// id , date , id_fournisseur
Route::delete('/bce/{id}', [B_C_ExterneController::class, 'destroy'])->middleware('is_able:delete-BCE');

// bon de reception
Route::patch('bs_de_livraison/{b_livraison}/quantity', [QuantiteLivréContoller::class, 'store']);
Route::get('/liste-br', [B_ReceptionController::class, 'index']); 
Route::post('/create-br/{id_b_c_externe}', [B_ReceptionController::class, 'create_br']);  
Route::delete('/delete/{id_BR}', [B_ReceptionController::class, 'destroy']);
Route::get('/afficher-br/{id_br}',[QuantiteLivréContoller::class,'show']);// show quntité recus
Route::get('/show_br/{id_br}',[B_ReceptionController::class,'show']); // recuperier le id br ,id bce ,id_fournisseur


// Bon de commande interne
Route::get('/bci', [B_C_InterneController::class, 'index'])->middleware('is_able:read-BCI');
Route::post('/bci', [B_C_InterneController::class, 'store'])->middleware('is_able:create-BCI');

// retrun the bci date
Route::get('/bci/{id}', [B_C_InterneController::class, 'show'])->middleware('is_able:show-BCI');
Route::delete('/bci/{id}', [B_C_InterneController::class, 'destroy'])->middleware('is_able:delete-BCI');

Route::post('/bci-add-product', [QunatiteDemandeController::class ,'store'])->middleware('is_able:add-producrt-to-BCI');
Route::put('/update-bci/{b_c_interne_id}',[QunatiteDemandeController::class, 'update'])->middleware('is_able:update-BCI');
Route::get('/BS/{b_sortie_id}',[QuantiteSortieController::class, 'show']);

// changer l'etat de bci 
Route::patch('/bci/{bc}/send', [B_C_InterneController::class,'send']);

Route::get('/show-bci/{b_c_interne_id}',[QunatiteDemandeController::class, 'show']);
Route::post('/list-Bs',[B_SortieController::class, 'index_b_sortie']);
Route::post('/list-Bd',[B_SortieController::class, 'index_b_decharge']);
Route::post('/create_BDorBS/{b_c_interne_id}',[B_SortieController::class,'createBSorBD']);
Route::post('/RetourDeProduit/{b_Decharge_id}',[B_SortieController::class,'RetourDeProduit']);

// inventaire
Route::post('/saveinv',[QuantitePerduController::class,'store']);
Route::get('/inventaire/{invenataire_id}',[QuantitePerduController::class, 'show']);

//Dashbord of magasinger
Route::get('/mostDemandedProducts',[QunatiteDemandeController::class, 'mostDemandedProducts']);
Route::get('/nbrOfBci',[B_C_InterneController::class,'countBci']);
Route::get('/nbrOfBS',[B_C_InterneController::class,'countBS']);
Route::get('/nbrOfBD',[B_C_InterneController::class,'countBD']);

//Dashbord of Admin
Route::get('/nbrOfuser',[UserController::class, 'nbrOfUser']);
Route::get('/nbrOfActiveuser',[UserController::class, 'nbrOfActiveUser']);
Route::get('/nbrOfNoActiveuser',[UserController::class, 'nbrOfNoActiveUser']);
Route::get('/nbrOfStructure',[UserController::class, 'nbrOfStructure']);
Route::get('/login-frequency', [UserController::class, 'getLoginFrequency']);
Route::get('/LastestLogins', [UserController::class, 'LastTwoLogins']);

//Dashbord of ASA
Route::get('/nbrofChapter',[ChapterController::class, 'nbrofChapter']);
Route::get('/nbrofArticle',[ArticleController::class, 'nbrofArticle']);
Route::get('/nbrofProduct',[ProductController::class, 'nbrofProduct']);
Route::get('/nbrofBCE',[B_C_ExterneController::class, 'nbrofBce']);
Route::get('/nbrofBCE',[B_C_ExterneController::class,'mostCommandedProducts']);
Route::get('/product_commanded_per_year/{product_id}',[QuantitéCommandController::class, 'yearly']);
Route::get('/quantité_livrée/{bce_id}',[QuantitéCommandController::class, 'totalQuantity']);
Route::get('/list-of-fourn',[FournisseurController::class, 'listing']);

// dashbord of consomateur
Route::get('/nbrofBCi/{user_id}',[B_C_InterneController::class, 'getUserBCICount']);
Route::get('/getQunatityConsu/{user_id}',[QuantiteSortieController::class, 'getQunatityConsu']);
Route::get('/produitRetourne/{user_id}',[QuantiteSortieController::class, 'produitRetourne']);
Route::post('/consomation',[B_C_InterneController::class, 'getConsumptionStatistics']);

// dashbord of RDS
Route::get('/nbrofBCItraité',[B_C_InterneController::class, 'countBciNotvadlidatedbyRDS']);
Route::get('/nbrofBCIrecu',[B_C_InterneController::class, 'countBcivadlidatedbyRDS']);
Route::get('/getTopConsumers',[UserController::class, 'getTopConsumers']); 
Route::get('/getTopProduct/{structure_id}',[ProductController::class, 'getTopProductsByStructure']); 



});