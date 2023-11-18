<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\Drug;
use App\Models\Transaction;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\CartContract;
use PDF;
use Illuminate\Support\Facades\Response;

class CartRepository extends BaseRepository implements CartContract
{
    /**
     * @var
     */
    protected $model;

    public function __construct(Cart $models)
    {
        $this->model = $models->whereNotNull('id');
    }

    public function store(array $data)
    {
        $data_old = Cart::where('drug_id', $data['id'])->first();
        if ($data_old) {
            $stok_obat = Drug::find($data['id']);
            if ($stok_obat->quantity < $data_old->total + 1)
                return [
                    'code' => 400,
                    'message' => 'Stok Obat Tidak Cukup'
                ];
            $data_old->total = $data_old->total + 1;
            $data_old->save();
            return [
                'code' => 200,
                'message' => __('success.public'),
            ];
        } else {
            $data_new = [];
            $data_new['drug_id'] = $data['id'];
            $data_new['total'] = 1;
            Cart::create($data_new);
            return [
                'code' => 200,
                'message' => __('success.public'),
            ];
        }
    }

    public function update(array $data, $id)
    {
        $data_old = Cart::where('id', $id)->first();

        if ($data['command'] == 'minus') {
            if ($data_old->total == 1) {
                $data_old->delete();
                return [
                    'code' => 200,
                    'message' => __('success.public'),
                ];
            }
            $data_old->total = $data_old->total - 1;
            $data_old->save();
            return [
                'code' => 200,
                'message' => __('success.public'),
            ];
        } else if ($data['command'] == 'plus') {
            $stok_obat = Drug::find($data['drug_id']);
            if ($stok_obat->quantity < $data_old->total + 1)
                return [
                    'code' => 400,
                    'message' => 'Stok Obat Tidak Cukup'
                ];
            $data_old->total = $data_old->total + 1;
            $data_old->save();
            return [
                'code' => 200,
                'message' => __('success.public'),
            ];
        }

        // delete
        $data_old->delete();
        return [
            'code' => 200,
            'message' => __('success.public'),
        ];
    }

    public function delete($id)
    {
        // delete all
        Cart::whereNotNull('id')->delete();
        return [
            'code' => 200,
            'message' => __('success.public'),
        ];
    }

    public function proses($data)
    {
        $cart = Cart::whereNotNull('id')->get();
        $cart2 = $cart;
        $total = 0;
        foreach ($cart as $cart) {
            $total += $cart->total * $cart->detail->price;
        }
        // to transaction
        $transaction = Transaction::create([
            'name' => $data['name'],
            'total_price' => $total,
            'date' => date('Y-m-d'),
            'tunai' => $data['tunai'],
        ]);

        foreach ($cart2 as $cart) {
            $transaction->detail()->create([
                'transaction_id' => $transaction->id,
                'drug_id' => $cart->drug_id,
                'quantity' => $cart->total,
                'price' => $cart->detail->price * $cart->total,
            ]);
            Drug::where('id', $cart->drug_id)->decrement('quantity', $cart->total);
        }

        $transactionNew = Transaction::with('detail')->where('id', $transaction->id)->first();

        Cart::whereNotNull('id')->delete();

        $pdf = PDF::loadview('_card.pdf', ['transactionNew' => $transactionNew])->setOptions(['defaultFont' => 'sans-serif']);
        $pdf->setOptions(['isHtml5ParserEnabled' => true]);
        $pdf->getDomPDF()->set_option('isRemoteEnabled', true);
        $pdf->getDomPDF()->set_option('isHtml5ParserEnabled', true);
        $pdf->getDomPDF()->set_option('isPhpEnabled', true);
        $pdf->getDomPDF()->set_option('isJavascriptEnabled', true);
        $pdf->getDomPDF()->set_option('isCssFloatEnabled', true);
        $pdf->getDomPDF()->setBasePath(public_path());
        $pdf->render();

        // save to public folder with random filename with timestamp
        $uniq = uniqid();
        $tgl = date('Y-m-d');
        // cek if folder not exist
        if (!file_exists(public_path() . '/pdf')) {
            mkdir(public_path() . '/pdf', 0777, true);
        }
        $name_pdf = $uniq . '-' . $tgl . '.pdf';
        $pdf->save(public_path() . '/pdf/' . $name_pdf);

        $transaction->update([
            'pdf' => $name_pdf
        ]);

        return [
            'code' => 200,
            'message' => __('success.public'),
            'name_pdf' => $name_pdf
        ];
    }
}
