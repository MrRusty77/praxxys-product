<?php

namespace App\Maya;

use Aceraven777\PayMaya\PayMayaSDK;
use Aceraven777\PayMaya\API\Checkout;
use Aceraven777\PayMaya\Model\Checkout\Item;
use App\Libraries\PayMaya\User as PayMayaUser;
use Aceraven777\PayMaya\Model\Checkout\ItemAmount;
use Aceraven777\PayMaya\Model\Checkout\ItemAmountDetails;

class MayaCheckout
{

    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    public function checkout($transaction, $checkout)
    {
        PayMayaSDK::getInstance()->initCheckout(
            "pk-rpwb5YR6EfnKiMsldZqY4hgpvJjuy8hhxW2bVAAiz2N",
            "sk-6s9dwnYGFJdZOYu1HCUAfUZctWEf9AjtHIG38kezX8W",
            'SANDBOX'
        );


        $user_phone = '1234567';
        $user_email = 'louiecabacungan.praxxys@gmail.com';

        // Item
        $itemAmountDetails = new ItemAmountDetails();
        $itemAmountDetails->tax = "0.00";
        $itemAmountDetails->subtotal = number_format($checkout->total_amount, 2, '.', '');
        $itemAmount = new ItemAmount();
        $itemAmount->currency = "PHP";
        $itemAmount->value = $itemAmountDetails->subtotal;
        $itemAmount->details = $itemAmountDetails;

        // Checkout
        $itemCheckout = new Checkout();
        $user = new PayMayaUser();
        $user->contact->phone = $user_phone;
        $user->contact->email = $user_email;

        $itemCheckout->buyer = $user->buyerInfo();

        $itemCheckout->items = $this->generateItems($checkout->products);

        $itemCheckout->totalAmount = $checkout->total_amount;
        $itemCheckout->requestReferenceNumber = $transaction->code;

        $itemCheckout->redirectUrl = array(
            "success" => url("/mayaPayment?hash={$transaction->hash}&status=success&code={$transaction->code}"),
            "failed" => url("/mayaPayment?hash={$transaction->hash}&status=failure&code={$transaction->code}"),
            "failure" => url("/mayaPayment?hash={$transaction->hash}&code={$transaction->code}&status=failure"),
            "fail" => url("/mayaPayment?hash={$transaction->hash}&status=failure&code={$transaction->code}"),
            "cancel" => url("/mayaPayment?hash={$transaction->hash}&status=cancel&code={$transaction->code}"),
        );

        dd($itemCheckout->execute());


        if ($itemCheckout->execute() === false) {
            $error = $itemCheckout::getError();
            dd($error);
            // return redirect()->back()->withErrors(['message' => $error['message']]);
        }

        if ($itemCheckout->retrieve() === false) {
            $error = $itemCheckout::getError();
            return redirect()->back()->withErrors(['message' => $error['message']]);
        }

        return redirect()->to($itemCheckout->url);
    }

    protected function generateItems($checkoutProduct)
    {
        $temp_items = [];

        foreach ($checkoutProduct as $product) {

            $item = $this->item;
            $item->name = $product['name'];
            $item->amount =  $product['price'];
            $item->totalAmount = $product['price'] * $product['qty'];

            array_push($temp_items, $item);
        }

        return $temp_items;
    }
}
