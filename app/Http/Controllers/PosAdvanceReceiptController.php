<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use PDF;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\DataResource;
use domain\Facades\PosAdvanceReceiptFacade\PosAdvanceReceiptFacade;
use App\Models\PosAdvanceReceipt;
use App\Http\Requests\PosAdvanceReceipt\CreatePosAdvanceReceiptRequest;
use Illuminate\Support\Facades\Auth;

class PosAdvanceReceiptController extends ParentController
{
    /**
     * index
     * Load Customer Order index page
     *
     * @return void
     */
    public function index()
    {
        if (Auth::user()->can('access_advance_receipt')) {
            return Inertia::render('AdvanceReceipt/index');
        } else {
            $response['alert-danger'] = 'You do not have permission to advance receipt.';
            return redirect()->route('dashboard')->with($response);
        }
    }

    /**
     * store
     * Store Customer Order details
     *
     * @param  CreatePosAdvanceReceiptRequest $req
     * @return void
     */
    public function store(int $order_id, CreatePosAdvanceReceiptRequest $req)
    {
        if (Auth::user()->can('access_advance_receipt')) {
            return PosAdvanceReceiptFacade::store($order_id, $req->all());
        } else {
            $response['alert-danger'] = 'You do not have permission to create advance receipt.';
            return redirect()->route('advanceReceipt.index')->with($response);
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
        $query = PosAdvanceReceipt::orderBy('id', 'desc');
        $payload = QueryBuilder::for($query)
            ->allowedSorts(['id'])
            ->allowedFilters(
                AllowedFilter::callback('search', function ($query, $value) {
                    $query->whereHas('order', function(Builder $query) use ($value){
                        $query->where('order_no', 'like', "%{$value}%");
                    });
                    $query->orWhere('receipt_no', $value);
                    $query->orWhere('amount', $value);
                    $query->orWhere('date',$value);
                    $query->orWhere('remark', 'like', "%{$value}%");
                })
            )
            ->paginate(request('per_page', config('basic.pagination_per_page')));
        return DataResource::collection($payload);
    }


    /**
     * get
     * Get single Customer Order details using Customer Order id
     *
     * @param  int $order_id
     * @return void
     */
    public function get(int $order_id)
    {
        return PosAdvanceReceiptFacade::get($order_id);
    }

    /**
     * update
     * Update Customer Order detail according to the request
     *
     * @param  CreatePosAdvanceReceiptRequest $request
     * @param  int $receipt_id
     * @return void
     */
    public function update(CreatePosAdvanceReceiptRequest $request, int $receipt_id)
    {
        if (Auth::user()->can('access_advance_receipt')) {
            return PosAdvanceReceiptFacade::update($request->all(),$receipt_id);
        } else {
            $response['alert-danger'] = 'You do not have permission to update advance receipt.';
            return redirect()->route('advanceReceipt.index')->with($response);
        }
    }

    /**
     * print
     *
     * @param  int $order_id
     * @return void
     */
    // public function print(int $receipt_id){
    //     $response['receptDetails'] = PosAdvanceReceiptFacade::get($receipt_id);
    //     $pdf = PDF::loadView('print.pages.receipt', $response);
    //     return $pdf->stream("Receipt.pdf", array("Attachment" => false));
    // }
    public function print(int $order_id){
        $response['receptDetails'] = PosAdvanceReceiptFacade::getById($order_id);
        $response['total'] = PosAdvanceReceiptFacade::getTotalByOrderId($order_id);
        $pdf = PDF::loadView('print.pages.receipt', $response)->setPaper([0, 0, 300, 700], 'portrait');
        return $pdf->stream("Receipt.pdf", array("Attachment" => false));
    }

    /**
     * printPaymentWise
     *
     * @param  int $order_id
     * @return void
     */
    public function printPaymentWise(int $order_id, Request $receipt){
        // dd($receipt);
        $response['receptDetails'] = PosAdvanceReceiptFacade::getById($order_id);
        $response['total'] = PosAdvanceReceiptFacade::getTotalByOrderId($order_id);
        $response['receipt'] = $receipt;
        $pdf = PDF::loadView('print.pages.receipt-payment-wise', $response)->setPaper([0, 0, 300, 700], 'portrait');
        return $pdf->stream("Receipt.pdf", array("Attachment" => false));
    }

    /**
     * list
     *
     * @param  mixed $order_id
     * @return void
     */
    public function list(int $order_id)
    {
        return PosAdvanceReceiptFacade::list($order_id);
    }

}
