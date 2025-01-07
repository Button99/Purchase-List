<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta http-equiv="Content-Type" content="text/html;" charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="A nice place where you can add and organize
            all your things you want to buy for free!">
        <link rel="canonical" href="https://purchase-list.website/" />
        <meta name="description" content="Easily create and manage purchase lists with https://purchase-list.website. Our user-friendly website allows you to add, delete and check items on your list. Keep track of your shopping needs and stay organized with our purchase list management tool.">
        <meta name="robots" content="index, follow">
        <meta content="https://purchase-list.website/" property="og:url">
        <meta name="keywords" content="Purchaselist, purchase, purchases, list, lists, item, items, social media, fun, funny, 
        buy, things,  buy things, shopping, shopping list, purchase list, shopping cart, cart, virtual, organize, organization, multi list, online purchase list,
        item list, shopping organizer, buy list, purchase tracker, online shopping list, buy list, shopping management, purchase management, list maker">
        <title inertia>{{ config('app.name', 'PurchaseList') }}</title>
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8827433963978520"
            crossorigin="anonymous"></script>
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Scripts -->
        @routes
        @vite('resources/js/app.js')
        @inertiaHead
    </head>
    <body class="font-sans antialiased bg-[#EFEFEF]">
        @inertia
    </body>
</html>

<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-K6V1602GPG');

</script>
