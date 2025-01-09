<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\IpRequest;
use App\Http\Resources\IPResource;
use App\Models\IPList;
use App\Services\CrudController;

final class IPController extends CrudController
{
    protected $model = IPList::class;

    protected $resource = IPResource::class;

    protected $requestClass = IpRequest::class;

    // Controller-specific methods can be added here if needed
}
