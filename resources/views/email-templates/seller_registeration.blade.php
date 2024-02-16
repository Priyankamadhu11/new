<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>{{\App\CPU\translate('Order Placed')}}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style type="text/css">
  /**
   * Google webfonts. Recommended to include the .woff version for cross-client compatibility.
   */

  @import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');
  /**
   * Avoid browser level font resizing.
   * 1. Windows Mobile
   * 2. iOS / OSX
   */
   body{
    font-family: 'Roboto', sans-serif;
   }
  body,
  table,
  td,
  a {
    -ms-text-size-adjust: 100%; /* 1 */
    -webkit-text-size-adjust: 100%; /* 2 */
  }

  /**
   * Remove extra space added to tables and cells in Outlook.
   */
  table,
  td {
    mso-table-rspace: 0pt;
    mso-table-lspace: 0pt;

  }

  /**
   * Better fluid images in Internet Explorer.
   */
  img {
    -ms-interpolation-mode: bicubic;
  }

  /**
   * Remove blue links for iOS devices.
   */
  a[x-apple-data-detectors] {
    font-family: inherit !important;
    font-size: inherit !important;
    font-weight: inherit !important;
    line-height: inherit !important;
    color: inherit !important;
    text-decoration: none !important;
  }

  /**
   * Fix centering issues in Android 4.4.
   */
  /* div[style*="margin: 16px 0;"] {
    margin: 0 !important;
  } */



  /**
   * Collapse table borders to avoid space between cells.
   */
  table {
    border-collapse: collapse !important;
  }

  a {
    color: #1a82e2;
  }

  img {
    height: auto;
    line-height: 100%;
    text-decoration: none;
    border: 0;
    outline: none;
  }

  </style>

</head>
<body style="background-color: #ececec;margin:0;padding:0">

<?php

    use App\Model\BusinessSetting;
    $company_phone =BusinessSetting::where('type', 'company_phone')->first()->value;
    $company_email =BusinessSetting::where('type', 'company_email')->first()->value;
    $company_name =BusinessSetting::where('type', 'company_name')->first()->value;
    $company_web_logo =BusinessSetting::where('type', 'company_web_logo')->first()->value;
    $company_mobile_logo =BusinessSetting::where('type', 'company_mobile_logo')->first()->value;

?>

<div style="width:650px;margin:auto; background-color:#ececec;height:50px;">

</div>
<div style="width:650px;margin:auto; background-color:white;padding:40px;border-radius: 3px;">
   
    <?php
        $sellers = \App\Model\Seller::find($seller->id);
        $shop = \App\Model\Shop::find($sellers->id);
    ?>

    <p>Hello Admin,</p>
    
    <p>A new seller has registered on the platform. Here are the details:</p>
    
    <ul>
        <li><strong>Name:</strong> {{ $seller->f_name }} {{ $seller->l_name }}</li>
        <li><strong>Email:</strong> {{ $seller->email }}</li>
        <li><strong>Phone:</strong> {{ $seller->phone }}</li>
        <li><strong>Shop Name:</strong> {{ $shop->name }}</li>
        <li><strong>Shop Address:</strong> {{ $shop->address }}</li>
    </ul>
    
    <p>Please review their application and take appropriate action.<a href="https://zigamart.in/admin/sellers/seller-list">Go to seller list</a></p>
    
    <p>Thank you.</p>

</div>

</body>
</html>
