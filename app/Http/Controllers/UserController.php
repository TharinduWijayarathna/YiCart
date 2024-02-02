<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\CreateUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Http\Resources\DataResource;
use App\Models\User;
use domain\Facades\UserFacade\UserFacade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends ParentController
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        if (Auth::user()->user_role_id == 1) {
            return Inertia::render('User/index');
        } else {
            return Inertia::render('Cart/index');
        }
    }

    /**
     * all
     *
     * @return void
     */
    public function all()
    {
        $query = User::query()->withTrashed()->orderBy('id', 'desc');
        $payload = QueryBuilder::for($query)
            ->allowedSorts(['id'])
            ->allowedFilters(
                AllowedFilter::callback('search', function ($query, $value) {
                    $query->where('name', 'like', "%{$value}%");
                    $query->orWhere('email', 'like', "%{$value}%");
                })
            )
            ->paginate(request('per_page', config('basic.pagination_per_page')));
        return DataResource::collection($payload);
    }

    /**
     * store
     *
     * @param  CreateUserRequest $request
     * @return void
     */
    public function store(CreateUserRequest $request)
    {
        if (Auth::user()->can('create_user')) {
            return UserFacade::store($request->all());
        } else {
            $response['alert-danger'] = 'You do not have permission to create users.';
            return redirect()->route('dashboard')->with($response);
        }
    }

    /**
     * delete
     *
     * @param  int $user_id
     * @return void
     */
    public function delete(int $user_id)
    {
        if (Auth::user()->can('delete_user')) {
            return UserFacade::delete($user_id);
        } else {
            $response['alert-danger'] = 'You do not have permission to delete users.';
            return redirect()->route('dashboard')->with($response);
        }
    }

    /**
     * restore
     *
     * @param  int $user_id
     * @return void
     */
    public function restore(int $user_id)
    {
        return UserFacade::restore($user_id);
        if (Auth::user()->can('restore_user')) {
        } else {
            $response['alert-danger'] = 'You do not have permission to restore users.';
            return redirect()->route('dashboard')->with($response);
        }
    }

    /**
     * update
     *
     * @param  UpdateUserRequest $request
     * @param  int $user_id
     * @return void
     */
    public function update(UpdateUserRequest $request, int $user_id)
    {
        return UserFacade::update($request->all(), $user_id);
    }

    /**
     * get
     *
     * @param  int $user_id
     * @return void
     */
    public function get(int $user_id)
    {
        $payload = UserFacade::get($user_id);
        return new DataResource($payload);
    }

    /**
     * roles
     *
     * @return void
     */
    public function roles()
    {
        $payload = UserFacade::get($user_id);
        return new DataResource($payload);
    }
}
