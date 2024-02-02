<?php

namespace App\Http\Controllers;

use App\Http\Resources\DataResource;
use App\Models\PosOrder;
use domain\Facades\PosOrderFacade\PosOrderFacade;
use domain\Facades\PosSavedOrderFacade\PosSavedOrderFacade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class HoldCartController extends ParentController
{
    public function index()
    {

        return Inertia::render('SavedCart/index');
    }

    public function all(Request $request)
    {
        $query = PosOrder::query()->where('status', 2)->orderBy('id', 'desc');
        if (isset($request->search_order_customer_id)) {
            $query->where('customer_id', $request->search_order_customer_id);
        }
        $payload = QueryBuilder::for($query)
            ->allowedSorts(['code'])
            ->allowedFilters(
                AllowedFilter::callback('search', function ($query, $value) {
                    $query->Where('code', 'like', "%{$value}%");
                })
            )
            // ->allowedSorts(['code'])
            ->paginate(request('per_page', config('basic.pagination_per_page')));
        return DataResource::collection($payload);
    }

    public function edit()
    {
        return Inertia::render('SavedCart/edit');
    }

    public function reActive(int $order_id)
    {
        return PosOrderFacade::reActive($order_id);
    }

    public function deleteOrder(int $order_id)
    {
        return PosOrderFacade::deleteOrder($order_id);
    }
}
