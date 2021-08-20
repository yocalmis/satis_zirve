<?php

require_once('config.php');

# create request class
$request = new \Iyzipay\Request\CreateCheckoutFormInitializeRequest();
$request->setLocale(\Iyzipay\Model\Locale::TR);
$request->setConversationId($bid);
$request->setPrice("1");
$request->setPaidPrice($rakam);
$request->setCurrency(\Iyzipay\Model\Currency::TL);
$request->setBasketId($sip);
$request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);
$request->setCallbackUrl($donus2);
$request->setEnabledInstallments(array(2, 3, 6, 9));

$buyer = new \Iyzipay\Model\Buyer();
$buyer->setId($mid);
$buyer->setName("_".$nm."");
$buyer->setSurname("_".$sm."");
$buyer->setGsmNumber("_".$tel."");
$buyer->setEmail("_".$em."");
$buyer->setIdentityNumber("_".$sip."");
$buyer->setLastLoginDate("".$bitis."");
$buyer->setRegistrationDate("".$bugun.""); 
$buyer->setRegistrationAddress("_".$adr."");
$buyer->setIp("_".$ip."");
$buyer->setCity("_".$il."");
$buyer->setCountry("_".$ul."");
$buyer->setZipCode("_".$pk."");
$request->setBuyer($buyer);

$shippingAddress = new \Iyzipay\Model\Address();
$shippingAddress->setContactName("_".$nm." ".$sm."");
$shippingAddress->setCity("_".$il."");
$shippingAddress->setCountry("_".$ul."");
$shippingAddress->setAddress("_".$adr."");
$shippingAddress->setZipCode("_".$pk."");
$request->setShippingAddress($shippingAddress);

$billingAddress = new \Iyzipay\Model\Address();
$billingAddress->setContactName("_".$nm." ".$sm."");
$billingAddress->setCity("_".$il."");
$billingAddress->setCountry("_".$ul."");
$billingAddress->setAddress("_".$adr."");
$billingAddress->setZipCode("_".$pk."");
$request->setBillingAddress($billingAddress);

$basketItems = array();
$firstBasketItem = new \Iyzipay\Model\BasketItem();
$firstBasketItem->setId($sip);
$firstBasketItem->setName($bid);
$firstBasketItem->setCategory1($bid);
$firstBasketItem->setCategory2($bid);
$firstBasketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
$firstBasketItem->setPrice("1");
$basketItems[0] = $firstBasketItem;

/*
$secondBasketItem = new \Iyzipay\Model\BasketItem();
$secondBasketItem->setId($sip);
$secondBasketItem->setName($bid);
$secondBasketItem->setCategory1($bid);
$secondBasketItem->setCategory2($bid);
$secondBasketItem->setItemType(\Iyzipay\Model\BasketItemType::VIRTUAL);
$secondBasketItem->setPrice("0.5");
$basketItems[1] = $secondBasketItem;

$thirdBasketItem = new \Iyzipay\Model\BasketItem();
$thirdBasketItem->setId($sip);
$thirdBasketItem->setName($bid);
$thirdBasketItem->setCategory1($bid);
$thirdBasketItem->setCategory2($bid);
$thirdBasketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
$thirdBasketItem->setPrice("0.2");
$basketItems[2] = $thirdBasketItem;
*/
$request->setBasketItems($basketItems);

# make request
$checkoutFormInitialize = \Iyzipay\Model\CheckoutFormInitialize::create($request, Config::options());

# print result
//print_r($checkoutFormInitialize);


//print_r($checkoutFormInitialize->getStatus()); 
//print_r($checkoutFormInitialize->getErrorMessage());
print_r($checkoutFormInitialize->getCheckoutFormContent());


?>

<html>
<body>
<div id="iyzipay-checkout-form" class="popup"></div>
</body>
</html>
