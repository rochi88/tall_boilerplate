<?php

declare(strict_types = 1);

it('has dashboard page', function () {
    $response = $this->get('/dashboard');

    $response->assertStatus(200);
});
