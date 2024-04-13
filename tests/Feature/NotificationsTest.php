<?php

declare(strict_types = 1);

it('has notifications page', function () {
    $response = $this->get('/notifications');

    $response->assertStatus(200);
});
