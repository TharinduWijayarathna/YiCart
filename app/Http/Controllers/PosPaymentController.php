<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use PDF;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\DataResource;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Builder;
use domain\Facades\MaterialFacade\MaterialFacade;
use domain\Facades\PosOrderFacade\PosOrderFacade;
use domain\Facades\PosPaymentFacade\PosPaymentFacade;
use domain\Facades\ReturnBillFacade\ReturnBillFacade;
use domain\Facades\GiftVoucherFacade\GiftVoucherFacade;
use domain\Facades\PosCustomerFacade\PosCustomerFacade;
use App\Http\Requests\PosPayment\CreatePosPaymentRequest;
use App\Models\BusinessDetail;
use domain\Facades\BillPaymentFacade\BillPaymentFacade;
use domain\Facades\PosOrderItemFacade\PosOrderItemFacade;
use domain\Facades\ConsignmentItemLogFacade\ConsignmentItemLogFacade;

/**
 * PosPayment Controller
 * php version 8
 *
 * @category Controller
 *
 * */
class PosPaymentController extends ParentController
{
    /**
     * store
     * Store payment details of the order
     *
     * @param  CreatePosPaymentRequest $request
     * @return void
     */
    // public function store(CreatePosPaymentRequest $request)
    // {
    //     try {
    //         if (count($request->voucher_codes) > 0) {
    //             $vouchers = $request->voucher_codes;
    //             foreach ($vouchers as $value) {
    //                 GiftVoucherFacade::useVoucher($value, $request->order_id);
    //             }
    //         }
    //         if ($request->return_code) {
    //             ReturnBillFacade::useCreditNote($request->return_code);
    //         }
    //         if ($request->remark) {
    //             PosOrderFacade::addRemark($request->order_id, $request->remark);
    //         }
    //         if ($request->customer_id) {
    //             PosCustomerFacade::addCredit($request->customer_id, $request->credit);
    //         }
    //         $order_items = PosOrderItemFacade::all($request->order_id);
    //         foreach ($order_items as $item) {
    //             if($item->type == 0){
    //                 $is_consignment = MaterialFacade::isConsignment($item->fg_id);
    //                 if ($is_consignment == 1) {
    //                     ConsignmentItemLogFacade::store($item);
    //                 }
    //             }
    //         }
    //         $payment = PosPaymentFacade::store($request->all());
    //         PosOrderFacade::changeCreditStatus($request->order_id);
    //         return $payment;
    //     } catch (\Throwable $th) {
    //         Log::error($th);
    //         return response()->json([
    //             'message' => 'Payment Failed'
    //         ], 500);
    //     }
    // }

    /**
     * print
     *
     * @param  int $order_id
     * @return void
     */
    public function print(int $order_id)
    {
        $response['order'] = PosOrderFacade::get($order_id);
        $response['bill'] = BillPaymentFacade::get($order_id);
        // $response['credit_bills'] = BillPaymentFacade::getBills($order_id);
        $response['config'] = BusinessDetail::orderBy('id', 'desc')->first();
        $pdf = PDF::loadView('print.pages.payment', $response)->setPaper([0, 0, 300, 700], 'portrait');
        return $pdf->stream("Payment.pdf", array("Attachment" => false));
    }

    public function returnPrint(int $order_id)
    {
        $response['order'] = PosOrderFacade::get($order_id);
        $response['config'] = BusinessDetail::orderBy('id', 'desc')->first();
        $pdf = PDF::loadView('print.pages.return', $response)->setPaper([0, 0, 300, 700], 'portrait');
        return $pdf->stream("Return.pdf", array("Attachment" => false));
    }

    /**
     * get
     *
     * @param  int $order_id
     * @return void
     */
    public function get(int $order_id)
    {
        return PosPaymentFacade::getByOrderId($order_id);
    }
}
