<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;


class User_Controller extends Controller
{

    public function get_item(Request $request)
    {
        $Users  = User::where('id' , $request['id'])->get();
        
        foreach($Users as $item)
        {
            $item->user_status;
            // $item->drivers;
            // $item->drivers;
        }
        
        if( $Users == null)
        {
            return response()->json(
                ['success'=>false]
            );   
        }
        else
        {
            return response()->json(
                ['success'=>true,
                'Users' => $Users
                ]
            ); 
        }
    }

    public function login(Request $request)
    {
        $creds = $request->only(['email','password']);

        
        if(!$token=Auth::guard('api')->attempt($creds)){
             return response()->json(
                ['success'=>false]
            );
        }
        else{
            return response()->json(
                ['success'=>true,
                    'token'=>$token,
                    'user'=>  Auth::guard('api')->user()
                ]
            );
        }
    }

    public function check_login(Request $request)
    {
        return response()->json(
            ['success'=>true]
        );   
    }

    public function logout(Request $request)
    {
        try
        {
            JWTAuth::invalidate(JWTAuth::parseToken());
            return response()->json(
                ['success'=>true ,
                'message' => 'logout success'  ]
            ); 
        }
        catch(Exception $e)
        {
            return response()->json(
                ['success'=>true ,
                'message' => ''.$e  ]
            ); 
        }
    }

    public function get_all(Request $request)
    {
        $Users = array();
        if($request->has('page'))
        {
            $Users = User::paginate($request['count']);
        }
        else
        {
            $Users = User::All();
        }
        
        if( $Users == null)
        {
            return response()->json(
                ['success'=>false]
            );   
        }
        else
        {
            return response()->json(
                ['success'=>true,
                'Users' => $Users
                ]
            ); 
        }
    }

    public function search(Request $request)
    {     
        $Users ;
        if($request->has('page'))
        {
            $Users = User::where('name' , 'LIKE' , '%'.$request['name'].'%' )->paginate($request['count']);
        }
        else
        {
            $Users = User::where('name' , 'LIKE' , '%'.$request['name'].'%')->get();
        }

        if( $Users == null) 
        {
            return response()->json(
                ['success'=>false]
            );   
        }
        else
        {
            return response()->json(
                ['success'=>true,
                'Users' => $Users
                ]
            ); 
        }
    }

    public function get_all_setting(Request $request)
    {
        $Users = array();
        if($request->has('page'))
        {
            $Users = User::where('tmp_password' , '!=' , '')->paginate($request['count']);
        }
        else
        {
            $Users = User::where('tmp_password' , '!=' , '')->get();
        }

        foreach($Users as $item)
        {
            $item->user_status;
        }
        
        if( $Users == null)
        {
            return response()->json(
                ['success'=>false]
            );   
        }
        else
        {
            return response()->json(
                ['success'=>true,
                'Users' => $Users
                ]
            ); 
        }
    }

    public function search_setting(Request $request)
    {     
        $Users ;
        if($request->has('page'))
        {
            $Users = User::where('name' , 'LIKE' , '%'.$request['name'].'%' )
                        ->where('tmp_password' , '!=' , '')->paginate($request['count']);
        }
        else
        {
            $Users = User::where('name' , 'LIKE' , '%'.$request['name'].'%')->get();
        }

        foreach($Users as $item)
        {
            $item->user_status;
        }

        if( $Users == null) 
        {
            return response()->json(
                ['success'=>false]
            );   
        }
        else
        {
            return response()->json(
                ['success'=>true,
                'Users' => $Users
                ]
            ); 
        }
    }

}
