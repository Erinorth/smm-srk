@extends('layouts.print')

@section('title','Check List')

@section('content')
   @php
      $post = [
         'UserMail' => '951091', // User Mail
         'PassMail' => '#6z8bihi6i8pencs', // Password Mail
         'ToMail' => "569887@egat.co.th", // x1@egat.co.th, x2@egat.co.th
         'Subject' => "งานที่ต้องดำเนินการ", 
         'ContentMail' => "
               <div class='container text-center' >
                  $data
               </div>
            "
      ];

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, 'http://10.20.18.188/mail/SendEgatMail2.php');
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
      $response = curl_exec($ch);
      var_export($response)
   @endphp
@endsection