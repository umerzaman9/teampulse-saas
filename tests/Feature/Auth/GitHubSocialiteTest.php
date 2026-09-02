<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;

uses(RefreshDatabase::class);

it('allows a user to sign in with github', function () {
    Socialite::fake('github', (new SocialiteUser)->map([
        'id' => 'github-123',
        'name' => 'Taylor Otwell',
        'email' => 'taylor@example.com',
    ]));

    $this->get('/auth/github/callback')
        ->assertRedirect(route('dashboard'));

    expect(User::where('email', 'taylor@example.com')->exists())->toBeTrue();
    expect(auth()->check())->toBeTrue();
});
