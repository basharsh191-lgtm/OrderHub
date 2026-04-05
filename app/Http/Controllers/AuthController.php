<?php

namespace App\Http\Controllers;

use App\Mail\OtpEmail;
use App\Models\otp_user;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

use function Symfony\Component\Clock\now;

class AuthController extends Controller
{
        //هاد بقا منتحكم فيه بعد ما نحدد شو نوع ال otp  يلي بدنا نضيفو بعدين
    public function sendOtpCode($mobile, $otp)
    {
        // إرسال عبر UltraMsg
        $params = [
            'token' => env('ULTRAMSG_TOKEN'),
            'to'    => $mobile,
            'body'  =>  "Your verification code is : $otp \n expire is 10 minutes"
        ];

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.ultramsg.com/" . env('ULTRAMSG_INSTANCE') . "/messages/chat",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => http_build_query($params),
            CURLOPT_HTTPHEADER => ["content-type: application/x-www-form-urlencoded"],
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0
        ]);

        curl_exec($curl);
        curl_close($curl);

        return response()->json(['message' => 'Done....'], 200);
    }
    //إرسال OTP عبر الإيميل
    public function sendOtpToEmail($email, $otp, $name = null)
    {
        try {
            Mail::to($email)->send(new OtpEmail($otp, $name));
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send OTP email: ' . $e->getMessage());
            return false;
        }
    }
    public function requestOtpViaEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'phone_Number' => 'required|string'
        ]);
        $user = User::where('phone_Number', $request->phone_Number)
            ->orWhere('email', $request->email)
            ->first();
        if (!$user) {
            return response()->json([
                'message' => 'User aleardy exites'
            ], 404);
        }
        $existingOtp = otp_user::where('phone_Number', $user->phone_Number)
            ->where('expires_at', '>', now())
            ->first();

        if ($existingOtp) {
            $minutesLeft = Carbon::now()->diffInMinutes($existingOtp->expires_at, false);
            return response()->json([
                'message' => "An active token already exists. Please wait {$minutesLeft} minutes before requesting a new token.",
                'time_remaining' => $minutesLeft
            ], 429);
        }
        $otp = rand(100000, 999999);

        otp_user::updateOrCreate(
            ['phone_Number' => $user->phone_Number],
            [
                'otp' => $otp,
                'expires_at' => Carbon::now()->addMinutes(10)
            ]
        );

        $emailSent = $this->sendOtpToEmail($request->email, $otp, $user->name);

        if (!$emailSent) {
            return response()->json([
                'message' => 'Failed to send the code to your email. Please try again later.'
            ], 500);
        }

        return response()->json([
            'message' => 'A verification code has been successfully sent to your email',
            'is_verified' => false,
            'expires_in' => '10 minutes'
        ], 200);
    }
    public function register(Request $request)
    {
        $request->validate([
            'phone_Number' => 'required|string|max:10',
            'name' => 'required|string|max:15',
            'email' => 'nullable|email|unique:users,email'
        ]);

        $phone = $request->phone_Number;
        $name = $request->name;
        $email = $request->email;

        $existingUser = User::where('phone_Number', $phone)->first();

        if ($existingUser) {
            $otp = rand(100000, 999999);

            otp_user::updateOrCreate(
                ['phone_Number' => $phone],
                ['otp' => $otp, 'expires_at' => Carbon::now()->addMinutes(10)]
            );

            if ($email) {
                $this->sendOtpToEmail($email, $otp, $existingUser->name);
                $method = 'email';
            } else {
                $this->sendOtpCode($phone, $otp);
                $method = 'whatsapp';
            }

            return response()->json([
                'message' => "The Number already been taken ",
                'requires_otp' => true,
                'is_verified' => false
            ], 200);
        }

        $user = User::create([
            'name' => $name,
            'phone_Number' => $phone,
            'email' => $email
        ]);

        $otp = rand(100000, 999999);

        otp_user::updateOrCreate(
            ['phone_Number' => $phone],
            ['otp' => $otp, 'expires_at' => Carbon::now()->addMinutes(10)]
        );

        if ($email) {
            $this->sendOtpToEmail($email, $otp, $name);
            $method = 'email';
        } else {
            $this->sendOtpCode($phone, $otp);
            $method = 'whatsapp';
        }

        return response()->json([
            'message' => "Created account succssfully",
            'user_id' => $user->id,
            'is_verified' => false
        ], 200);
    }
    public function logout(Request $request)
    {
        $user = $request->user();
        $user->update(['is_verified' => false]);
        $user->currentAccessToken()->delete();
        return response()->json([
            'message' => 'The log out successfully',
            'is_verified' => false
        ], 200);
    }
    public function login(Request $request)
    {
        $validated = $request->validate([
            'phone_Number' => 'required|string|max:10',
        ]);

        $user = User::where('phone_Number', $request->phone_Number)->first();

        if (!$user) {
            return response()->json([
                'message' => 'Invalid phone number'
            ], 401);
        }

        $otp = rand(100000, 999999);

        otp_user::updateOrCreate(
            ['phone_Number' => $validated['phone_Number']],
            [
                'otp' => $otp,
                'expires_at' => Carbon::now()->addMinutes(10)
            ]
        );

        $this->sendOtpCode([$validated['phone_Number']], $otp);

        return response()->json([
            'message' => 'Please verify the code sent to WhatsApp.',
            'user_id' => $user->id,
            'is_verified' => false
        ], 200);
    }
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone_Number' => 'required|string',
            'otp' => 'required|string'
        ]);
        $otpRecord = otp_user::where('phone_Number', $request->phone_Number)
            ->where('otp', $request->otp)
            ->where('expires_at', '>', now())
            ->first();
        if (!$otpRecord) {
            return response()->json(['message' => 'Invalid OTP or code expired.']);
        }
        $user = User::where('phone_Number', $request->phone_Number)->firstOrCreate();
        $user->update(['is_verified' => true]);
        $otpRecord->delete();
        $token = $user->createToken('auth_Token')->plainTextToken;

        return response()->json([
            'message' => 'Verification successful. Your account is now active.',
            'is_verified' => true,
            'tolen' => $token
        ], 200);
    }
    public function resendOtp(Request $request)
    {
        $request->validate([
            'phone_Number' => 'required|string|max:10'
        ]);
        $user = User::where('phone_Number', $request->phone_Number)->first();
        if (!$user) {
            return response()->json([
                'message' => 'Phone number not found',
                'is_verified' => false
            ], 404);
        }
        $existingOtp = otp_user::where('phone_Number', $request->phone_Number)
            ->where('expires_at', '>', now())
            ->first();
        if ($existingOtp) {
            $now = Carbon::now();
            $expiresAt = Carbon::parse($existingOtp->expires_at);
            $minutesLeft = $now->diffInMinutes($expiresAt, false);
            return response()->json([
                'message' => "An active code already exists. Please wait {$minutesLeft} minutes before requesting a new code.",
                'is_verified' => false,
                'time_remaining' => $minutesLeft
            ], 429);
        }
        $otp = rand(100000, 999999);
        otp_user::updateOrCreate(
            ['phone_Number' => $request->phone_Number],
            [
                'otp' => $otp,
                'expires_at' => Carbon::now()->addMinutes(10)
            ]
        );
        $this->sendOtpCode($request->phone_Number, $otp);
        return response()->json([
            'message' => 'New verification code sent successfully to WhatsApp',
            'user_id' => $user->id,
            'is_verified' => false,
            'expires_in' => '10 minutes'
        ], 200);
    }


}
