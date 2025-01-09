<?php

declare(strict_types = 1);

namespace App\Services;

use App\Http\Controllers\Controller;
use App\Traits\{ApiResponse, Ownerable};
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

final class CrudController extends Controller
{
    use ApiResponse;
    use Ownerable;

    private $model;

    private $resource;

    private $requestClass;

    public function index(Request $request)
    {
        try {
            $items = $this->model::filterRecords($request);

            return $this->resource::collection($items)->additional($this->preparedResponse('index'));
        } catch (Exception $e) {
            $this->recordException($e);

            return $this->serverErrorResponse();
        }
    }

    public function store()
    {
        try {
            $request = app($this->requestClass);
            $item = $this->model::create($request->all());

            return (new $this->resource($item))->additional($this->preparedResponse('store'));
        } catch (QueryException $queryException) {
            return $this->queryExceptionResponse($queryException);
        }
    }

    public function show($id)
    {
        try {
            $item = $this->model::findOrFail($id);

            if (!isset($this->model::$isEnableResourceOwnerCheck)) {
                return (new $this->resource($item))->additional($this->preparedResponse('show'));
            }

            if ($this->model::$isEnableResourceOwnerCheck !== true) {
                return (new $this->resource($item))->additional($this->preparedResponse('show'));
            }

            if (!$this->isOwner($item)) {
                return $this->forbiddenAccessResponse();
            }

            return (new $this->resource($item))->additional($this->preparedResponse('show'));
        } catch (ModelNotFoundException $modelException) {
            return $this->recordNotFoundResponse($modelException);
        } catch (Exception) {
            return $this->serverErrorResponse();
        }
    }

    public function update($id)
    {
        try {
            $request = app($this->requestClass);
            $item = $this->model::findOrFail($id);

            if (isset($this->model::$isEnableResourceOwnerCheck) && $this->model::$isEnableResourceOwnerCheck === true && !$this->isOwner($item)) {
                return $this->forbiddenAccessResponse();
            }

            $item->update($request->all());

            return (new $this->resource($item))->additional($this->preparedResponse('update'));
        } catch (ModelNotFoundException $modelException) {
            return $this->recordNotFoundResponse($modelException);
        } catch (QueryException $queryException) {
            return $this->queryExceptionResponse($queryException);
        }
    }

    public function destroy($id)
    {
        try {
            $item = $this->model::findOrFail($id);

            if (isset($this->model::$isEnableResourceOwnerCheck) && $this->model::$isEnableResourceOwnerCheck === true && !$this->isOwner($item)) {
                return $this->forbiddenAccessResponse();
            }

            $item->status = 'inactive';
            $item->save();

            return (new $this->resource($item))->additional($this->preparedResponse('destroy'));
        } catch (ModelNotFoundException $modelException) {
            return $this->recordNotFoundResponse($modelException);
        } catch (QueryException $queryException) {
            return $this->queryExceptionResponse($queryException);
        }
    }
}
