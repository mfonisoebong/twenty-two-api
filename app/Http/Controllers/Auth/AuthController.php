<?php

namespace App\Http\Controllers\Auth;

use App\Enums\StatusCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\SendPasswordResetRequest;
use App\Http\Requests\Auth\SignInRequest;
use App\Http\Requests\Auth\SignUpRequest;
use App\Http\Requests\Auth\UpdateCredentialsRequest;
use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Http\Requests\Auth\VerifyEmailRequest;
use App\Http\Resources\Auth\UserProfileResource;
use App\Mail\Auth\OtpMail;
use App\Models\User;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    use HttpResponses;

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->success(null, 'Logged out successfully.');
    }

    public function signUp(SignUpRequest $request)
    {

        try {

            DB::transaction(function () use ($request) {

                $user = $request->createUser();
                $this->sendOtpMail($user, 'email');
                Auth::login($user);
            });

            $user = auth()->user();

            $token = $user->createToken('auth_token')->plainTextToken;
            $profile = new UserProfileResource($user);

            $data = [
                'token' => $token,
                'profile' => $profile
            ];

            return $this->success($data, 'Signed up successfully. Please verify your email');
        } catch (Exception $e) {
            return $this->failed(null, StatusCode::InternalServerError->value, $e->getMessage());
        }
    }

    public function signIn(SignInRequest $request)
    {
        try {
            $request->signInUser();

            $user = auth()->user();

            $token = $user->createToken('auth_token')->plainTextToken;

            $profile = new UserProfileResource($user);

            $data = [
                'token' => $token,
                'profile' => $profile
            ];

            return $this->success($data, 'Signed in successfully');
        } catch (Exception $e) {
            return $this->failed(null, StatusCode::InternalServerError->value, $e->getMessage());
        }
    }

    public function updateCredentials(UpdateCredentialsRequest $request)
    {
        DB::beginTransaction();

        try {

            $user = $request->updateCredentials();

            DB::commit();

            if ($request->updatedEmail) {
                $this->sendOtpMail($user, 'email');
            }

            return $this->success(null, 'Credentials updated successfully');
        } catch (Exception) {
            DB::rollBack();
            return $this->failed(null, StatusCode::InternalServerError->value, 'An error occurred');
        }
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $request->updateUser();

        return $this->success(null, 'Profile updated successfully');
    }

    public function verifyEmail(VerifyEmailRequest $request)
    {
        $request->verifyEmail();

        return $this->success(null, 'Email verified successfully');
    }

    public function user(Request $request)
    {
        $user = $request->user();

        $profile = new UserProfileResource($user);

        return $this->success($profile, 'User profile retrieved successfully');
    }

    public function resendEmailVerificationOtp(Request $request)
    {

        try {
            $user = auth()->user();

            $this->sendOtpMail($user, 'email');

            return $this->success(null, 'Otp sent successfully');
        } catch (Exception) {
            return $this->failed(null, StatusCode::InternalServerError->value, 'An error occurred');
        }
    }

    public function sendPasswordReset(SendPasswordResetRequest $request)
    {

        try {

            $user = User::where('email', $request->email)->first();

            $this->sendOtpMail($user, 'password');

            return $this->success(null, 'Otp sent successfully');
        } catch (Exception) {
            return $this->failed(null, StatusCode::InternalServerError->value, 'An error occurred');
        }
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $request->resetPassword();

        return $this->success(null, 'Password reset successfully');
    }

    public function unauthenticated()
    {
        return $this->failed(null, StatusCode::Unauthorized->value, 'You are not signed in');
    }

    private function sendOtpMail($user, string $type)
    {
        try {
            $otp = $user->otps()->create([
                'type' => $type,
            ]);
            Mail::to($user->email)
                ->send(new OtpMail($otp));
        } catch (Exception $e) {
        }
    }
}
