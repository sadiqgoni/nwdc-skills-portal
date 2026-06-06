<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\ProgrammeCycle;
use App\Models\State;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register', [
            'states' => State::query()->where('is_north_west', true)->orderBy('name')->get(),
            'eligibility' => session('eligibility'),
        ]);
    }

    public function register(Request $request)
    {
        $eligibility = session('eligibility');

        if ($eligibility) {
            $request->merge([
                'date_of_birth' => data_get($eligibility, 'date_of_birth'),
                'state_id' => data_get($eligibility, 'state_id'),
            ]);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'phone' => ['required', 'digits_between:10,15', Rule::unique('users', 'phone')],
            'nin' => ['required', 'digits:11', Rule::unique('users', 'nin')],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'state_id' => ['required', 'exists:states,id'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $cycle = ProgrammeCycle::query()->where('status', 'active')->latest('id')->first();
        $state = State::query()->findOrFail($data['state_id']);
        $age = Carbon::parse($data['date_of_birth'])->age;
        $minimumAge = $cycle?->minimum_age ?? 18;
        $maximumAge = $cycle?->maximum_age ?? 35;

        if (! $state->is_north_west || $age < $minimumAge || $age > $maximumAge) {
            throw ValidationException::withMessages([
                'date_of_birth' => 'Applicants must be aged ' . $minimumAge . '-' . $maximumAge . ' and from a North-West state for this cycle.',
            ]);
        }

        $user = User::query()->create([
            'name' => $data['name'],
            'email' => $data['email'] ?: null,
            'phone' => $data['phone'],
            'nin' => $data['nin'],
            'password' => Hash::make($data['password']),
            'role' => 'applicant',
            'is_active' => true,
        ]);

        session()->put('eligibility', [
            'date_of_birth' => $data['date_of_birth'],
            'state_id' => (int) $data['state_id'],
            'age' => $age,
        ]);

        Auth::login($user);

        return redirect()->route('portal.application.edit')->with('success', 'Account created. Complete your application to continue.');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = User::query()
            ->where('email', $data['login'])
            ->orWhere('phone', $data['login'])
            ->orWhere('nin', $data['login'])
            ->first();

        if (! $user || ! Hash::check($data['password'], $user->password) || ! $user->is_active) {
            throw ValidationException::withMessages([
                'login' => 'The supplied login details could not be verified.',
            ]);
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return redirect()->intended($user->role === 'admin' ? '/admin' : route('portal.dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
