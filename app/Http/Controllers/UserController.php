<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {
    function UserRegistration( Request $request ) {
        try {
            $request->validate( [
                'firstName' => 'required|string|max:50',
                'lastName'  => 'required|string|max:50',
                'email'     => 'required|string|email|max:50|unique:users,email',
                'mobile'    => 'required|string|max:50',
                'password'  => 'required|string|min:3',
            ] );

            User::create( [
                'firstName' => $request->input( 'firstName' ),
                'lastName'  => $request->input( 'lastName' ),
                'email'     => $request->input( 'email' ),
                'mobile'    => $request->input( 'mobile' ),
                'password'  => Hash::make( $request->input( 'password' ) ),
            ] );

            return response()->json( ['status' => 'success', 'message' => 'User Registration Successfully'], 200 );

        } catch ( Exception $e ) {
            return response()->json( ['status' => 'failed', 'message' => $e->getMessage()] );
        }
    }

    function UserLogin( Request $request ) {
        try {
            $request->validate( [
                'email'    => 'required|string|email|max:50',
                'password' => 'required|string|min:3',
            ] );

            $user = User::where( 'email', '=', $request->input( 'email' ) )->first();

            if ( !$user || !Hash::check( $request->input( 'password' ), $user->password ) ) {
                return response()->json( ['status' => 'failed', 'message' => 'Invalid User'] );
            }

            $token = $user->CreateToken( 'authToken' )->plainTextToken;
            return response()->json( ['status' => 'success', 'message' => 'Login Successful', 'token' => $token] );

        } catch ( Exception $e ) {
            return response()->json( ['status' => 'failed', 'message' => $e->getMessage()] );
        }
    }

    function UserProfile( Request $request ) {
        return Auth::user();
    }
}
