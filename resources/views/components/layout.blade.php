<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <x-script/>
    <title>otwlogin</title>
    <link rel="icon" type="image/jpg" href="{{ asset('favicon.jpg') }}">
    @livewireStyles
</head>
<body>
<!--
  This example requires updating your template: Apakau lihat lihat

  ```
  <html class="h-full bg-gray-100">
  <body class="h-full">
  ```
-->
<div class="min-h-full mt-16">
  <x-navbar></x-navbar>
  <x-header>{{$title}}</x-header>
  <main>
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
    {{$slot}}
  </main>
</div>
@livewireScripts
</body>
</html>