<?php

namespace App\Http\Controllers;

use App\Enum\MessagesEnum;
use App\Http\Requests\StoreAppRequest;
use App\Http\Requests\UpdateAppRequest;
use App\Http\Resources\AppResource;
use App\Models\App;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

/**
 * App Controller
 */
class AppController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function list(): AnonymousResourceCollection
    {
        return AppResource::collection(App::paginate(100));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAppRequest $request
     * @return Response|mixed
     */
    public function store(StoreAppRequest $request): mixed
    {
        return App::create($request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse|AppResource
     */
    public function show(int $id): JsonResponse|AppResource
    {
        $app = App::find($id);
        if (empty($app)) {
            return AppResource::handle(MessagesEnum::APP_NOT_FOUND);
        }
        return new AppResource($app);
    }

    /**
     * Update
     * @param UpdateAppRequest $request
     * @param int $id
     * @return JsonResponse|AppResource
     */
    public function update(UpdateAppRequest $request, int $id): JsonResponse|AppResource
    {
        $app = App::find($id);
        if (empty($app)) {
            return AppResource::handle(MessagesEnum::APP_NOT_FOUND);
        }
        if ($app->update($request->validated())) {
            return new AppResource($app);
        }
        return AppResource::handle(MessagesEnum::APP_SOMETHING_WENT_WRONG);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $app = App::find($id);
        if (empty($app)) {
            return AppResource::handle(MessagesEnum::APP_NOT_FOUND);
        }
        if ($app->delete()) {
            return AppResource::success(MessagesEnum::APP_SUCCESS_DELETE);
        }
        return AppResource::handle(MessagesEnum::APP_SOMETHING_WENT_WRONG);
    }
}
