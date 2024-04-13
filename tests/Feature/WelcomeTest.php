<?php

declare(strict_types = 1);

it('has welcome page', function () {
    $response = $this->get('/welcome');

    $response->assertStatus(200);
});
