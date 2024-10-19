<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

// テスト全体に対してRefreshDatabaseを適用
uses(RefreshDatabase::class);

it('returns a successful response', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});
