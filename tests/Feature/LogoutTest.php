<?php

it('has logout page', function () {
    $response = $this->get('/logout');

    $response->assertStatus(200);
});
