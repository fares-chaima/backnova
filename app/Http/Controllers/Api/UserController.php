<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Login;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\CreateUserRequest;
use Illuminate\Support\Facades\DB;
class UserController extends Controller
{
    /**
     * Create User
     * @param App\Http\Requests\CreateUserRequest $request
     * @return User 
     */
    public function createUser(CreateUserRequest $request)
    {
        //$data = $request->validated();
        //$data['password'] = Hash::make($data['password']);

        $user = User::create($request->except('roles_ids'));
        $user->roles()->attach($request->roles_ids);
    
        return response()->json([
            'status' => true,
            'message' => 'User created successfully',
            'token' => $user->createToken("API TOKEN")->plainTextToken
        ], 200);
    }
    
    public function update(Request $request, $id)
    {
        // Validation
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'nullable',
            'email' => 'required|email|unique:users,email,' . $id,
            'numero' => 'required|digits:10|unique:users,numero,' . $id,
            'photo_url' => 'nullable',
            'is_active' => 'nullable|boolean',
            'password' => 'required',
        ]);
    
        // Find the user
        $user = User::findOrFail($id);
        
        // Update user data
        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->email = $request->input('email');
        $user->numero = $request->input('numero');
        $user->photo_url = $request->input('photo_url');
        $user->is_active = $request->input('is_active') ?? true; 
        $user->password = Hash::make($request->input('password'));
    
        $user->save();
    
        return response()->json($user, 200);
    }
    public function login(Request $request){

    
        $request->validate([
            "email" => "required|email|string",
            "password" => "required"
        ]);

        // Email check
        $user = User::where("email", $request->email)->first();

        if(!empty($user)){
            // User exists
            if(Hash::check($request->password, $user->password)){
                // Password matched
                $token = $user->createToken("mytoken")->plainTextToken;
                Login::create([
                    'user_id' => $user->id,
                ]);
                return response()->json([
                    "status" => true,
                    "message" => "User logged in",
                    "token" => $token,
                    "data" => []
                ]);
               
                
                
            }else{
                return response()->json([
                    "status" => false,
                    "message" => "Invalid password",
                    "data" => []
                ]);
            }
        }else{
            return response()->json([
                "status" => false,
                "message" => "Email doesn't match with records",
                "data" => []
            ]);
        }
    }

    public function profile(){

        $userData = auth()->user();
        return response()->json([
            "status" => true,
            "message" => "Profile Information",
            "data" => $userData,
            "id" => auth()->user()->id
        ]);
    }

    // GET [Auth: Token]
   // public function logout(){
   //     Auth::User()->tokens()->delete();
     //    return response()->json([
       //     "status" => true,
         //   "message" => "User logged out",
           // "data" => []
       // ]);
    //}
    public function logout( Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            "status" => true,
            "message" => "User logged out",
            "data" => []
        ]);
}
    public function nbrOfUser(){
        $users = User::count();
        return $users;
    }
    public function nbrOfActiveUser(){
        $users = User::where('is_active',1)->count();
       
        return $users;
    }
    public function nbrOfNoActiveUser(){
        $users = User::where('is_active',0)->count();
        
        return $users;
    } 

    public function getLoginFrequency(Request $request)
    {
        $year = $request->query('year', date('Y'));

        $data = Login::selectRaw('MONTH(created_at) as month, COUNT(*) as logins')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(function($item) {
                return [
                    'month' => date('M', mktime(0, 0, 0, $item->month, 10)),
                    'logins' => $item->logins
                ];
            });

        return response()->json([
            'year' => $year,
            'data' => $data
        ]);
    }
    function LastTwoLogins() {
        $lastTwoLogins = Login::select('user_id', 'created_at')
        ->distinct('user_id')
        ->orderBy('created_at', 'desc')
        ->take(2)
        ->get();
    
        return $lastTwoLogins->map(function ($login) {
            $user = User::find($login->user_id); 
            $roles = $user->roles->pluck('name')->toArray();
            return [
                'nom' => $login->user->firstname,
                'prenom'=>$login->user->lastname,
                'email' => $login->user->email,
               'roles' => $roles,
            ];
        });
    }
    public function getTopConsumers()
    {
        // Query to get top 5 consumers
        $topConsumers = User::select('users.id', 'users.firstname', 'users.lastname', DB::raw('SUM(quantite_demandes.quantity) as total_quantity'))
            ->join('b_c_internes', 'users.id', '=', 'b_c_internes.user_id')
            ->join('quantite_demandes', 'b_c_internes.id', '=', 'quantite_demandes.b_c_interne_id')
            ->groupBy('users.id', 'users.firstname', 'users.lastname')
            ->orderBy('total_quantity', 'desc')
            ->take(5)
            ->get();

        return response()->json($topConsumers);
    }
    
}

