<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use PDF;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\DataResource;
use domain\Facades\PosCustomOrderFacade\PosCustomOrderFacade;
use domain\Facades\PosAdvanceReceiptFacade\PosAdvanceReceiptFacade;
use App\Models\PosCustomOrder;
use App\Models\PosCustomOrderIssue;
use App\Http\Requests\PosCustomOrder\CreatePosCustomOrderRequest;
use App\Http\Requests\PosCustomOrder\PosCustomOrderReverseRequest;
use App\Http\Requests\PosCustomOrder\CreatePosCustomOrderIssueRequest;
use Illuminate\Support\Facades\Auth;

/**
 * PosCustomOrder Controller
 * php version 8
 *
 * @category Controller
 *
 * */
class PosCustomOrderController extends ParentController
{
    /**
     * index
     * Load Customer Order index page
     *
     * @return void
     */
    public function index()
    {
        if (Auth::user()->can('access_custom_order')) {
            return Inertia::render('CustomOrder/index');
        } else {
            $response['alert-danger'] = 'You do not have permission to custom orders.';
            return Inertia::render('CustomOrder/index');
        }
    }

    /**
     * store
     * Store Customer Order details
     *
     * @param  CreatePosCustomOrderRequest $req
     * @return void
     */
    public function store(CreatePosCustomOrderRequest $req)
    {
        if (Auth::user()->can('access_custom_order')) {
            return PosCustomOrderFacade::store($req->all());
        } else {
            $response['alert-danger'] = 'You do not have permission to create custom orders.';
            return redirect()->route('customOrder.index')->with($response);
        }
    }

    /**
     * all
     * Get all Customer Order details. If there is request, filter will be worked
     *
     * @param  Request $request
     * @return void
     */
    public function all(Request $request)
    {
        $query = PosCustomOrder::orderBy('id', 'desc');
        $payload = QueryBuilder::for($query)
            ->allowedSorts(['id'])
            ->allowedFilters(
                AllowedFilter::callback('search', function ($query, $value) {
                    $query->whereHas('customer', function(Builder $query) use ($value){
                        $query->where('name', 'like', "%{$value}%");
                    });
                    $query->orWhereHas('cashier', function(Builder $query) use ($value){
                        $query->where('name', 'like', "%{$value}%");
                    });
                    $query->orWhere('order_no', 'like', "%{$value}%");
                    $query->orWhere('specification_no', 'like', "%{$value}%");
                    $query->orWhere('delivery_date', 'like', "%{$value}%");
                    $query->orWhere('payment_status', 'like', "%{$value}%");
                    $query->orWhere('extra_charges', 'like', "%{$value}%");
                    $query->orWhere('order_type', 'like', "%{$value}%");
                    $query->orWhere('contact_at', 'like', "%{$value}%");
                    $query->orWhere('grand_total', 'like', "%{$value}%");
                    $query->orWhere('remark', 'like', "%{$value}%");
                })
            )
            ->paginate(request('per_page', config('basic.pagination_per_page')));
        return DataResource::collection($payload);
    }

    public function edit(int $order_id)
    {
        if (Auth::user()->can('access_custom_order')) {
            $response['order'] = PosCustomOrderFacade::get($order_id);
            return Inertia::render('CustomOrder/edit', $response);
        } else {
            $response['alert-danger'] = 'You do not have permission to view custom orders.';
            return redirect()->route('customOrder.index')->with($response);
        }
    }

    /**
     * get
     * Get single Customer Order details using Customer Order id
     *
     * @param  int $customer_order_id
     * @return void
     */
    public function get(int $customer_order_id)
    {
        return PosCustomOrderFacade::get($customer_order_id);
    }

    /**
     * update
     * Update Customer Order detail according to the request
     *
     * @param  CreatePosCustomOrderRequest $request
     * @param  int $customer_order_id
     * @return void
     */
    public function update(CreatePosCustomOrderRequest $request, int $customer_order_id)
    {
        if (Auth::user()->can('access_custom_order')) {
            return PosCustomOrderFacade::update($request->all(),$customer_order_id);
        } else {
            $response['alert-danger'] = 'You do not have permission to update custom orders.';
            return redirect()->route('customOrder.index')->with($response);
        }
    }

    public function getByNumber(int $phone_number)
    {
        return PosCustomOrderFacade::getByNumber($phone_number);
    }

    public function approve(int $order_id)
    {
        return PosCustomOrderFacade::approve($order_id);
    }

    public function reject(int $order_id)
    {
        return PosCustomOrderFacade::reject($order_id);
    }

    public function reverse(PosCustomOrderReverseRequest $request, int $order_id)
    {
        // dd( $request->status_remark );
        return PosCustomOrderFacade::reverse($order_id, $request->status_remark);
    }



    /**
     * print
     *
     * @param  int $order_id
     * @return void
     */
    public function print(int $order_id){
        $order = PosCustomOrderFacade::get($order_id);
        $response['totalQuantity'] = $order['items ']->sum('quantity');
        $response['totalAmount'] = $order['items']->sum('total');
        $response['order'] = $order;
        $response['advance_receipt'] = PosAdvanceReceiptFacade::getAdvanceReceipt($order_id);
        $pdf = PDF::loadView('print.pages.order', $response);
        return $pdf->stream("Custom-Order.pdf", array("Attachment" => false));
    }

    /**
     * issues
     * get issues item details by order id
     *
     * @param  int $order_id
     * @return void
     */
    public function issues(int $order_id)
    {
        $query = PosCustomOrderIssue::where('order_id', $order_id)->orderBy('id', 'desc');
        $payload = QueryBuilder::for($query)
            ->allowedSorts(['id'])
            ->allowedFilters(
                AllowedFilter::callback('search', function ($query, $value) {
                })
            )
            ->paginate(request('per_page', config('basic.pagination_per_page')));
        return DataResource::collection($payload);
    }

    /**
     * storeIssue
     *
     * @param  mixed $request
     * @return void
     */
    public function storeIssue(CreatePosCustomOrderIssueRequest $request){
        return PosCustomOrderFacade::storeIssue($request->all());
    }

}
