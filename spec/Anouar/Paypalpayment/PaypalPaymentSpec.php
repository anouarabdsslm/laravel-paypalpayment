<?php

namespace spec\Anouar\Paypalpayment;

use PayPal\Api\Address;
use PayPal\Api\Amount;
use PayPal\Api\Authorization;
use PayPal\Api\Capture;
use PayPal\Api\CreditCard;
use PayPal\Api\CreditCardToken;
use PayPal\Api\Details;
use PayPal\Api\FundingInstrument;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Links;
use PayPal\Api\Payee;
use PayPal\Api\Payer;
use PayPal\Api\PayerInfo;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\PaymentHistory;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Refund;
use PayPal\Api\RelatedResources;
use PayPal\Api\Sale;
use PayPal\Api\ShippingAddress;
use PayPal\Api\Transaction;
use PayPal\Api\Transactions;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PaypalPaymentSpec extends ObjectBehavior
{
    function let(Address $address, Amount $amount, Details $amountDetails, Authorization $authorization,
                     Capture $capture, CreditCard $creditCard, CreditCardToken $creditCardToken,
                     FundingInstrument $fundingInstrument,Item $item, ItemList $itemList, Links $links,
                     Payee $payee, Payer $payer, PayerInfo $payerInfo,Payment $payment, PaymentExecution $paymentExecution,
                     PaymentHistory $paymentHistory, RedirectUrls $redirectUrls, Refund $refund,RelatedResources $relatedResources,
                     Sale $sale, ShippingAddress $shippingAddress, Transactions $transactions,Transaction $transaction
                )
    {
        $this->beConstructedWith($address, $amount, $amountDetails,$authorization, $capture,$creditCard,  $creditCardToken,
                  $fundingInstrument, $item,  $itemList,  $links,$payee,  $payer,  $payerInfo, $payment,  $paymentExecution,
                  $paymentHistory,  $redirectUrls,  $refund, $relatedResources,$sale,  $shippingAddress,  $transactions,
                  $transaction
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Anouar\Paypalpayment\PaypalPayment');
    }

    public function it_is_return_address_object(Address $address)
    {
        $this->address()->shouldReturn($address);
    }

    public function it_is_return_amount_object(Amount $amount)
    {
        $this->amount()->shouldReturn($amount);
    }

    public function it_is_return_amountDetails_object(Details $amountDetails)
    {
        $this->amountDetails()->shouldReturn($amountDetails);
    }

    public function it_is_return_authorization_object(Authorization $authorization)
    {
        $this->authorization()->shouldReturn($authorization);
    }

    public function it_is_return_capture_object(Capture $capture)
    {
        $this->capture()->shouldReturn($capture);
    }
    public  function it_is_return_reditCard_object(CreditCard $creditCard)
    {
        $this->creditCard()->shouldReturn($creditCard);
    }

    public function it_is_return_creditCardToken_object(CreditCardToken $creditCardToken)
    {
        $this->creditCardToken()->shouldReturn($creditCardToken);
    }

    public function it_is_return_fundingInstrument_object(FundingInstrument $fundingInstrument)
    {
        $this->fundingInstrument()->shouldReturn($fundingInstrument);
    }

    public function it_is_return_item_object(Item $item)
    {
        $this->item()->shouldReturn($item);
    }

    public function it_is_return_itemList_object(ItemList $itemList)
    {
        $this->itemList()->shouldReturn($itemList);
    }

    public function it_is_return_link_object(Links $links)
    {
        $this->links()->shouldReturn($links);
    }

    public  function it_is_return_payee_object(Payee $payee)
    {
        $this->payee()->shouldReturn($payee);
    }

    public function it_is_return_payer_object(Payer $payer)
    {
        $this->payer()->shouldReturn($payer);
    }

    public function it_is_return_payerInfo_object(PayerInfo $payerInfo)
    {
        $this->payerInfo()->shouldReturn($payerInfo);
    }

    public  function its_is_return_Payment(Payment $payment)
    {
        $this->payment()->shouldReturn($payment);
    }

    public  function its_is_return_PaymentExecution(PaymentExecution $paymentExecution)
    {
        $this->paymentExecution()->shouldReturn($paymentExecution);
    }

    public  function its_is_return_PaymentHistory(PaymentHistory $paymentHistory)
    {
        $this->paymentHistory()->shouldReturn($paymentHistory);
    }

    public  function its_is_return_RedirectUrls(RedirectUrls $redirectUrls)
    {
        $this->redirectUrls()->shouldReturn($redirectUrls);
    }

    public  function its_is_return_Refund(Refund $refund)
    {
        $this->refund()->shouldReturn($refund);
    }

    public  function its_is_return_Resource(RelatedResources $relatedResources)
    {
        $this->relatedResources()->shouldReturn($relatedResources);
    }

    public  function its_is_return_Sale(Sale $sale)
    {
        $this->sale()->shouldReturn($sale);
    }

    public  function its_is_return_ShippingAddress(ShippingAddress $shippingAddress)
    {
        $this->shippingAddress()->shouldReturn($shippingAddress);
    }

    public  function its_is_return_Transaction(Transaction $transaction)
    {
        $this->transaction()->shouldReturn($transaction);
    }

    public  function its_is_return_Transactions(Transactions $transactions)
    {
        $this->transactions()->shouldReturn($transactions);
    }


    public  function its_set_ApiContext_details()
    {
        $credential = $this::OAuthTokenCredential("clientId", "clientSecret");

        $apiContext = new ApiContext($credential,35);

        $this->apiContext("clientId", "clientSecret", 35)->shouldBeAnInstanceOf($apiContext);
    }
}
