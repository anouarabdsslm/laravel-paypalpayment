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

    function it_is_initializable()
    {
        $this->shouldHaveType('Anouar\Paypalpayment\PaypalPayment');
    }

    public function it_is_return_address_object()
    {
        $this->address()->shouldBeAnInstanceOf(new Address);
    }

    public function it_is_return_amount_object()
    {
        $this->amount()->shouldBeAnInstanceOf(new Amount);
    }

    public function it_is_return_amountDetails_object()
    {
        $this->details()->shouldBeAnInstanceOf(new Details);
    }

    public function it_is_return_authorization_object()
    {
        $this->authorization()->shouldBeAnInstanceOf(new Authorization);
    }

    public function it_is_return_capture_object()
    {
        $this->capture()->shouldBeAnInstanceOf(new Capture);
    }
    public  function it_is_return_creditCard_object()
    {
        $this->creditCard()->shouldBeAnInstanceOf(new CreditCard);
    }

    public function it_is_return_creditCardToken_object()
    {
        $this->creditCardToken()->shouldBeAnInstanceOf(new CreditCardToken);
    }

    public function it_is_return_fundingInstrument_object()
    {
        $this->fundingInstrument()->shouldBeAnInstanceOf(new FundingInstrument);
    }

    public function it_is_return_item_object()
    {
        $this->item()->shouldBeAnInstanceOf(new Item);
    }

    public function it_is_return_itemList_object()
    {
        $this->itemList()->shouldBeAnInstanceOf(new ItemList);
    }

    public function it_is_return_link_object()
    {
        $this->links()->shouldBeAnInstanceOf(new Links);
    }

    public  function it_is_return_payee_object()
    {
        $this->payee()->shouldBeAnInstanceOf(new Payee);
    }

    public function it_is_return_payer_object()
    {
        $this->payer()->shouldBeAnInstanceOf(new Payer);
    }

    public function it_is_return_payerInfo_object()
    {
        $this->payerInfo()->shouldBeAnInstanceOf(new PayerInfo);
    }

    public  function its_is_return_Payment()
    {
        $this->payment()->shouldBeAnInstanceOf(new Payment);
    }

    public  function its_is_return_PaymentExecution()
    {
        $this->paymentExecution()->shouldBeAnInstanceOf(new PaymentExecution);
    }

    public  function its_is_return_PaymentHistory()
    {
        $this->paymentHistory()->shouldBeAnInstanceOf(new PaymentHistory);
    }

    public  function its_is_return_RedirectUrls()
    {
        $this->redirectUrls()->shouldBeAnInstanceOf(new RedirectUrls);
    }

    public  function its_is_return_Refund()
    {
        $this->refund()->shouldBeAnInstanceOf(new Refund);
    }

    public  function its_is_return_Resource()
    {
        $this->relatedResources()->shouldBeAnInstanceOf(new RelatedResources);
    }

    public  function its_is_return_Sale()
    {
        $this->sale()->shouldBeAnInstanceOf(new Sale);
    }

    public  function its_is_return_ShippingAddress()
    {
        $this->shippingAddress()->shouldBeAnInstanceOf(new ShippingAddress);
    }

    public  function its_is_return_Transaction()
    {
        $this->transaction()->shouldBeAnInstanceOf(new Transaction);
    }

    public  function its_is_return_Transactions()
    {
        $this->transactions()->shouldBeAnInstanceOf(new Transactions);
    }


    public  function its_set_ApiContext_details()
    {
        $credential = $this::OAuthTokenCredential("clientId", "clientSecret");

        $apiContext = new ApiContext($credential,35);

        $this->apiContext("clientId", "clientSecret", 35)->shouldBeAnInstanceOf($apiContext);
    }
}
