<?php

use App\Models\User;
use App\Models\Tweet;
use App\Livewire\Tweet\Create as TweetCreate;
use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;
use function Pest\Laravel\assertDatabaseCount;

it('should be able to create a tweet', function () {
    $user = User::factory()->create();
    actingAs($user);

    livewire(TweetCreate::class)
        ->set('body', 'This is my first tweet')
        ->call('tweet')
        ->assertEmitted('tweet::created');

    assertDatabaseCount('tweets', 1);
    expect(Tweet::first())
        ->body->toBe('This is my first tweet')
        ->created_by->toBe($user->id);
});

it('should make sure that only authenticated users can tweet', function () {
    livewire(TweetCreate::class)
        ->set('body', 'This is my first tweet')
        ->call('tweet')
        ->assertForbidden();

    actingAs(User::factory()->create());

    livewire(TweetCreate::class)
        ->set('body', 'This is my first tweet')
        ->call('tweet')
        ->assertEmitted('tweet::created');
});

test('body is required', function () {
    actingAs(User::factory()->create());

    livewire(TweetCreate::class)
        ->set('body', null)
        ->call('tweet')
        ->assertHasErrors(['body' => 'required']);
});

todo('the tweet body should have a max length of 140 characters');
todo('should show the tweet on the timeline');
