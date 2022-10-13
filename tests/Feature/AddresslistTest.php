<?php

it('has addresslist page', function () {
    $response = $this->get('/addresslist');

    $response->assertStatus(200);
});
