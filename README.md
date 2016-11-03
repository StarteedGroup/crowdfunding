Starteed Crowdfunding PHP API wrapper
--
Official Starteed Crowdfunding PHP API wrapper: help to read public data of Starteed Crowdfunding campaigns.

Widely inspired by [Sparkpost PHP API wrapper](https://github.com/SparkPost/php-sparkpost).

Still in **alpha** version.

No authentication is needed due to public data access.


## Installation
---

Install Composer first

    curl -sS https://getcomposer.org/installer | php

Starteed Crowdfunding requires php-http client: we suggest Guzzle6.

    composer require php-http/guzzle6-adapter

Next install the package.

    composer require starteed/crowdfunding


## Setting up a Request Adapter
---
Because of dependency collision, we have opted to use a request adapter rather than requiring a request library. This means that your application will need to pass in a request adapter to the constructor of the Starteed Crowdfunding Library (we choose HTTPlug) Please visit their repo for a list of supported clients and adapters. If you don't currently use a request library, you will need to require one and create a client from it and pass it along. The example below uses the GuzzleHttp Client Library.

A Client can be setup like so:

    <?php
    
    require_once __DIR__ . '/vendor/autoload.php';
    
    use GuzzleHttp\Client;
    use Starteed\Crowdfunding;
    use Http\Adapter\Guzzle6\Client as GuzzleAdapter;
    
    $http_client = new GuzzleAdapter(new Client);
    $starteed = new Crowdfunding($http_client, [
        'platform' => 'myplatform.starteed.com'
    ]);
    
    ?>

## Localization
---
Localization is provided by Accept-Language header: you can pass a dash or underscore value (e.g.: it_IT or it-IT) or just the language ISO code in the configuration array.

    $http_client = new GuzzleAdapter(new Client);
    $starteed = new Crowdfunding($http_client, [
        'platform' => 'myplatform.starteed.com',
        'language' => 'en_US'
    ]);

*Note that if the language locale is not available all the results will be translated with default language as fallback option.*

## Campaigns
---
### Paginated results
    $campaigns = $starteed->campaigns->all();
    // PHP object accessing
    {
      "data": [
        // Array of available campaigns
       ],
       "pagination": {
         "total": 1,
         "count": 1,
         "per_page": 20,
         "current_page": 1,
         "total_pages": 1,
         "links": [],
       }
    }
    
    // Grabbing first element of the data array
    $campaign = $campaigns->data[0];
    
    $campaign->title
    # My campaign title
    
    $campaign->goal
    # 15000
    
    $campaign->currency
    #{
    #    "id": 1,
    #    "code": "EUR",
    #    "symbol": "€",
    #    "label": "Euro"
    #}
    
    $campaign->currency->label
    # Euro

### Retrieve by ID
    $campaign = $starteed->campaigns->retrieve(1);
    
    $campaign->title
    # My campaign title
    
    $campaign->goal
    # 15000
    
    $campaign->duration
    #{
    #    "start": 1476264100,
    #    "end": 1479427200,
    #    "is_non_stop": false
    #}

# Rewards
---
### Paginated results

    $rewards = $starteed->campaigns->retrieve(1)->rewards->all();
    // PHP object accessing
    {
      "data": [
        // Array of available rewards
       ],
       "pagination": {
         "total": 5,
         "count": 5,
         "per_page": 20,
         "current_page": 1,
         "total_pages": 1,
         "links": [],
       }
    }
    
    // Grabbing first element of the data array
    $reward = $campaigns->data[0];
    
    $reward->image
    # "rewards/57fcce15a573a.jpg"
    
    $reward->is_active
    # true
    
    $reward->estimated_shipping
    #1476662400
    
    $reward->description
    # The reward description chosen by campaign admin

### Retrieve by ID

    $reward = $starteed->campaigns->retrieve(1)->rewards->retrieve(2);
    
    $reward->amount
    # 50

# FAQs
---
### Paginated results

    $faqs = $starteed->campaigns->retrieve(1)->faqs->all();
    // PHP object accessing
    {
      "data": [
        // Array of available faqs
       ],
       "pagination": {
         "total": 5,
         "count": 5,
         "per_page": 20,
         "current_page": 1,
         "total_pages": 1,
         "links": [],
       }
    }
    
    // Grabbing first element of the data array
    $faq = $campaigns->data[0];
    
    $faq->question
    # "Is this a question?"
    
    $faq->answer
    # "It looks like it!"

### Retrieve by ID

    $faq = $starteed->campaigns->retrieve(1)->faqs->retrieve(2);
    
    $faq->question
    # "Are donations deductible?"
    
    $faq->answer
    # "Yes, of course: you will receive a receipt via email once the donation is confirmed!"

# Supporters
---
### Paginated results

    $supporters = $starteed->campaigns->retrieve(1)->supporters->all();
    // PHP object accessing
    {
      "data": [
        // Array of donators/supporters
       ],
       "pagination": {
         "total": 20,
         "count": 20,
         "per_page": 20,
         "current_page": 1,
         "total_pages": 2,
         "links": [
             "next": "https://api.starteed.com/v1/campaigns/1/supporters/?page=2"
         ],
       }
    }
    
    // Grabbing first element of the data array
    $supporter = $supporters->data[0];
    
    $supporter->firstname
    # "John"
    
    $supporter->lastname
    # "Doe"

### Retrieve by ID

    $supporter = $starteed->campaigns->retrieve(1)->supporters->retrieve(2);
    
    $faq->email
    # "john.doe@starteed.com"