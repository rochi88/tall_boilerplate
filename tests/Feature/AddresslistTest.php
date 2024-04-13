<?php

declare(strict_types = 1);

it('has addresslist page', function () {
    $response = $this->get('/addresslist');

    $response->assertStatus(200);
});
