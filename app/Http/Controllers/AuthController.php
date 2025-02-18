<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\TechnicianProvince;
use App\Models\TechnicianSubCategory;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    /**
     * Register a new user.
     */
    public function register(Request $request)
    {



        return DB::transaction(function () use ($request) {
            try {
                // Validate the request data
                $validatedData = $request->validate([
                    'email' => 'nullable|string|email|max:255|unique:users',
                    'password' => 'required|string|min:8',
                    'name' => 'required|string|max:255',
                    'image' => 'required|string', // Assuming base64 or file path
                    'phone' => 'required|string|unique:users,phone',
                ]);

                // Hash password
                $validatedData['password'] = Hash::make($validatedData['password']);
                $validatedData['role'] = 'technician';

                // Create user
                $user = User::create($validatedData);

                // Create technician profile
                $technician = $user->technician()->create([
                    'name' => $user->name,
                    'phone' => $user->phone,
                    'address' => $request->address,
                    'email' => $request->email,
                    'status' => 'pending',
                    'image' => uploadFile($validatedData['image'], 'images', true),
                    'about' => $request->about,
                    'category_id' => $request->category_id,
                ]);

                $subCategories = collect($request->all())
                ->filter(fn($value, $key) => str_starts_with($key, 'sub_categories_'))
                ->values()
                ->toArray();
                if (!empty($subCategories)) {

                        collect($subCategories)->map(fn($id) =>
                            TechnicianSubCategory::create([
                                'technician_id' => $technician->id,
                            'sub_category_id' => $id,
                            'status' => 'pending',
                        ])
                    );
                }

                // Handle provinces
                $provinces = collect($request->all())
                ->filter(fn($value, $key) => str_starts_with($key, 'provinces_'))
                ->values()
                ->toArray();
                if (!empty($provinces)) {
                    collect($provinces)->map(fn($id) =>
                            TechnicianProvince::create([
                                'technician_id' => $technician->id,
                            'province_id' => $id,
                            'status' => 'pending',
                            ])
                        );
                }

                // Generate authentication token
                $token = $user->createToken('auth_token')->plainTextToken;

                return response()->json([
                    'user' => new UserResource($user),
                    'token' => $token,
                ], 201);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Registration failed', 'error' => $e->getMessage()], 500);
            }
        });
    }

    /**
     * Login a user.
     */
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'phone' => 'required|string|max:255',
            'password' => 'required|string',
        ]);
     
        if (!Auth::attempt($validatedData)) {
            return response()->json(['message' => 'User not found or wrong password'], 404);
        }
        $user = Auth::user();
        // $user->load('wallets');
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['user' => UserResource::make($user), 'token' => $token]);
    }

    /**
     * Logout a user.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully.']);
    }

    /**
     * Display the authenticated user.
     */
    public function me(Request $request)
    {
        return response()->json(['user' => UserResource::make(auth()->user()->load('technician'))]);
    }
    /**
     * Update the authenticated user's profile.
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user();
        $user->update($request->all());
        return response()->json(['message' => 'Profile updated successfully.']);
    }
    /**
     * Update the authenticated user's password.
     */
    public function updatePassword(Request $request)
    {
        $validatedData = $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
            'new_password_confirmation' => 'required_with:new_password|same:new_password|min:8',
        ]);

        $user = Auth::user();

        if (!Hash::check($validatedData['current_password'], $user->password)) {
            return response()->json(['message' => 'Current password does not match'], 401);
        }

        $user->password = Hash::make($validatedData['new_password']);
        $user->save();

        return response()->json(['message' => 'Password updated successfully.']);
    }
    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
        ]);

        // Generate a 6-digit OTP
        $otp = rand(100000, 999999);

        // Save OTP to session or database
        session(['otp' => $otp]);
        session(['otp_phone' => $request->phone]); // Store the phone number for verification

        // Send OTP via Zosto SMS API
        $client = new Client([
            'verify' => false, // Disable SSL verification
        ]);

        try {
            $response = $client->post('https://zostosms.com/api/v3/sms/send', [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('ZOSTO_SMS_API_KEY'),
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'json' => [
                    'recipient' => $request->phone,
                    'sender_id' => 16088798731, // Replace with your sender ID
                    'type' => 'plain',
                    'message' => "Your OTP is: $otp", // Customize the message
                ],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'OTP sent successfully!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send OTP.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string',
        ]);

        // Retrieve OTP and phone number from session
        $storedOtp = session('otp');
        $storedPhone = session('otp_phone');

        if ($request->otp == $storedOtp) {
            // OTP is valid
            session()->forget('otp'); // Clear OTP from session
            session()->forget('otp_phone'); // Clear phone number from session
            return response()->json([
                'success' => true,
                'message' => 'OTP verified successfully!',
            ]);
        } else {
            // OTP is invalid
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP.',
            ], 400);
        }
    }
}
