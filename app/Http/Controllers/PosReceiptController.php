<?php

namespace App\Http\Controllers;

use App\Http\Requests\PosReceipt\CreateBillRequest;
use App\Http\Resources\DataResource;
use App\Models\BillPayment;
use App\Models\PosOrder;
use domain\Facades\PosOrderFacade\PosOrderFacade;
use domain\Facades\PosReceiptFacade\PosReceiptFacade;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class PosReceiptController extends ParentController
{
    public function index()
    {
        return Inertia::render('Receipt/index');
    }

    public function credit()
    {
        return Inertia::render('Receipt/credit');
    }
    public function notCompleteView()
    {
        return Inertia::render('Receipt/bills');
    }


    public function all(Request $request)
    {
        $query = PosOrder::query()->where('status', '>', 0)->orderBy('updated_at', 'desc');
        if (isset($request->search_order_customer)) {
            $query->where('customer_id', $request->search_order_customer);
        }
        if (isset($request->search_order_cashier)) {
            $query->where('created_by', $request->search_order_cashier);
        }
        if (isset($request->search_order_from_date)) {
            $query->whereDate('created_at', '>=', $request->search_order_from_date);
        }
        if (isset($request->search_order_to_date)) {
            $query->whereDate('created_at', '<=', $request->search_order_to_date);
        }
        if (isset($request->search_order_status)) {
            $query->where('status', $request->search_order_status);
        }
        $payload = QueryBuilder::for($query)
            ->allowedSorts(['code'])
            ->allowedFilters(
                AllowedFilter::callback('search', function ($query, $value) {
                    $query->Where('code', 'like', "%{$value}%");
                })
            )
            ->paginate(request('per_page', config('basic.pagination_per_page')));
        return DataResource::collection($payload);
    }

    public function notCompleteAll(Request $request)
    {
        $query = PosOrder::query()->where('status', 1)->where('total','>' ,'balance')->where('balance','!=' ,0)->orderBy('id', 'desc');
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

    public function creditAll(Request $request)
    {
        $query = PosOrder::query()->where('credit_status', 0)->where('status', 1)->orderBy('updated_at', 'desc');
        if (isset($request->search_order_customer)) {
            $query->where('customer_id', $request->search_order_customer);
        }
        if (isset($request->search_order_cashier)) {
            $query->where('created_by', $request->search_order_cashier);
        }
        if (isset($request->search_order_from_date)) {
            $query->whereDate('created_at', '>=', $request->search_order_from_date);
        }
        if (isset($request->search_order_to_date)) {
            $query->whereDate('created_at', '<=', $request->search_order_to_date);
        }

        $payload = QueryBuilder::for($query)
            ->allowedSorts(['code'])
            ->allowedFilters(
                AllowedFilter::callback('search', function ($query, $value) {
                    $query->Where('code', 'like', "%{$value}%");
                })
            )
            ->paginate(request('per_page', config('basic.pagination_per_page')));
        return DataResource::collection($payload);
    }

    public function edit(int $order_id)
    {
        $response['order'] = PosOrderFacade::get($order_id);
        return Inertia::render('Receipt/edit', $response);
    }

    public function bills(int $order_id)
    {
        return PosReceiptFacade::getBills($order_id);
    }

    public function creditPay(CreateBillRequest $request, int $order_id)
    {
        return PosReceiptFacade::creditPay($request->all(), $order_id);
    }
}
