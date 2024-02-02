<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\PosOrder;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\DataResource;

/**
 * PosSavedOrder Controller
 * php version 8
 *
 * @category Controller

 * */
class PosSavedOrderController extends ParentController
{
    /**
     * index
     * Load saved cart page - Hold carts
     *
     * @return void
     */
    public function index()
    {
        if (Auth::user()->can('access_hold_cart')) {
            return Inertia::render('SavedCart/index');
        } else {
            $response['alert-danger'] = 'You do not have permission to hold cart.';
            return redirect()->route('dashboard')->with($response);
        }
    }

    /**
     * all
     * Get all hold cart for saved cart section
     *
     * @param  mixed $request
     * @return void
     */
    public function all(Request $request)
    {
        // $user = Auth::user();
        $query = PosOrder::query()->where('status', 2)->where('created_by', Auth::id())->orderBy('id', 'desc');
        if (isset($request->search_order_customer)) {
            $query->where('customer_id', $request->search_order_customer);
        }
        $payload = QueryBuilder::for($query)
            ->allowedSorts(['id'])
            ->allowedFilters(
                AllowedFilter::callback('search', function ($query, $value) {
                    $query->whereHas('customer', function (Builder $query) use ($value) {
                        $query->where('name', 'like', "%{$value}%");
                    });
                    $query->orWhereHas('customerTypeData', function (Builder $query) use ($value) {
                        $query->where('name', 'like', "%{$value}%");
                    });
                    $query->orWhere('created_by', 'like', "%{$value}%");
                    $query->orWhere('total', $value);
                    $query->orWhere('sub_total', $value);
                    $query->orWhere('discount', $value);
                })
            )
            ->paginate(request('per_page', config('basic.pagination_per_page')));
        return DataResource::collection($payload);
    }
}
