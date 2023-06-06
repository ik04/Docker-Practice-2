<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request){
        return response()->json("Welcome to Auth Api ~ Made by Ishaan Khurana",200);
    }
    // "creationTimeStamp"
    public function register(Request $request){
        $validation = Validator::make($request->all(),[
        "name"=>"required|string",
        "email"=>"required|email|unique:users",
        "password"=>"required|string",
        ]);
        if($validation->fails()){
            return response()->json($validation->errors()->all(),400);
        }
        $validated = $validation->validated();

        $currentTime = Carbon::now();
        $readableTime = $currentTime->toDateTimeString(); // this is in utc, it has date and time
        

       $user = User::create(["name"=>$validated["name"],"email"=>$validated["email"],"password" =>Hash::make($validated["password"]),"creationTimeStamp"=>$readableTime,"isAdmin"=>0]);
       return response()->json($user,200);
    }
    public function registerAdmin(Request $request){
        $validation = Validator::make($request->all(),[
        "name"=>"required|string",
        "email"=>"required|email|unique:users",
        "password"=>"required|string",
        ]);
        if($validation->fails()){
            return response()->json($validation->errors()->all(),400);
        }
        $validated = $validation->validated();

        $currentTime = Carbon::now();
        $readableTime = $currentTime->toDateTimeString(); // this is in utc, it has date and time
    
       $user = User::create(["name"=>$validated["name"],"email"=>$validated["email"],"password" =>Hash::make($validated["password"]),"creationTimeStamp"=>$readableTime,"isAdmin"=>1]);
    // creates an admin user that can delete other users
       return response()->json($user,200);
    }
    
    public function login(Request $request){
        $validation = Validator::make($request->all(),[
            "email"=>"required|email",
            "password"=>"required|string",
            ]);
            if($validation->fails()){
                return response()->json($validation->errors()->all(),400);
            }
            $validated = $validation->validated();
            $user = User::where('email',$validated['email'])->first();
            if(!$user){
                return response()->json(['error'=>"Email Not registered"],400);

            }
        if(!Hash::check($validated['password'],$user->password)){
            return response()->json(["error"=>"Invalid Credentials"],401);
        }
        $token = $user->createToken('myapptoken')->plainTextToken;
        return response()->json(['user'=>$user,'token'=>$token],200)->withCookie(cookie()->forever('at',$token)); 
        // use the returned token in authorization header to make certain routes work
    }
    public function listUsers(Request $request){
        $users = User::select("id","name","email","creationTimeStamp")->orderBy("name","asc")->get();
        return response()->json($users,200);
    }

    public function createdByHour(Request $request, $hours){
        $requestedTime = Carbon::now()->subHour($hours)->toDateTimeString(); // subtracts the parameter time from current time
        $requestedUsers = User::where("creationTimeStamp",">=",$requestedTime)->get(); // utc time comparison, check here for ist  https://www.utctime.net/utc-to-ist-indian-converter
        return response()->json($requestedUsers,200);
    }

    
    public function searchUser(Request $request,$id){
            if($user=User::where("id",$id)->select("id","name","email","creationTimeStamp")->get()){
                $count  = count($user,1);
                if(!($count === 0)){
                    return response()->json($user,200);
                }else{
                return response()->json('user with id '.$id.' not found',404);
            }
        }else{
            return response()->json('user with id '.$id.' not found',404);
        }

    }
    public function deleteUser(Request $request,$id){
            if($user=User::where("id",$id)->first()){
                    $currentUser = $request->user();
                    if($currentUser["isAdmin"] || $user['id'] === $currentUser["id"]){
                        $user->delete();
                        return response()->json("User Account Deleted.",200);
                    }else{
                        return response()->json("You Are Unauthorized",401);
                    }
        }else{
            return response()->json('user with id '.$id.' not found',404);
        }

    }

    public function logout(Request $request){
        $currentUser = $request->user();
        $username = $currentUser["name"];
        $request->user()->tokens()->delete();
        //deletes user tokens making them invalid 
        $response =  [
            'message' => 'logged out '. $username
        ];
        return response($response,200);
    }
}   