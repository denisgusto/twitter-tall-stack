<?php

use App\Models\User;
use App\Models\Tweet;
use App\Http\Livewire\Timeline;
use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;
use function Pest\Laravel\assertDatabaseCount;
use App\Http\Livewire\Tweet\Create as TweetCreate;

it('should be able to create a tweet', function ($tweet) {
    $user = User::factory()->create();
    actingAs($user);

    livewire(TweetCreate::class)
        ->set('body', $tweet)
        ->call('tweet')
        ->assertEmitted('tweet::created');

    assertDatabaseCount('tweets', 1);
    expect(Tweet::first())
        ->body->toBe($tweet)
        ->created_by->toBe($user->id);
})
    ->with(['This is my first tweet', 'This is my second tweet', 'This is my third tweet']);

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

test('the tweet body should have a max length of 140 characters', function () {
    actingAs(User::factory()->create());

    livewire(TweetCreate::class)
        ->set('body', str_repeat('a', 141))
        ->call('tweet')
        ->assertHasErrors(['body' => 'max']);
});

it('should show the tweet on the timeline', function () {
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

    livewire(Timeline::class)
        ->assertSee('This is my first tweet');
});

it('should set body as null after tweeting', function () {
    actingAs(User::factory()->create());

    livewire(TweetCreate::class)
        ->set('body', 'This is my first tweet')
        ->call('tweet')
        ->assertEmitted('tweet::created')
        ->assertSet('body', null);
});
