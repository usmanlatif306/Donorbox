# Donorbox

Donorbox is a technology company headquartered in San Francisco, California. Donorbox provides an online fundraising platform enabling individuals and nonprofit organizations to facilitate online donations. Donorbox requires no start-up costs, monthly fees, or contractual agreements. It offers features designed to streamline the donation process, such as Ultraswift Pay, which provides swift payment processing via various services including Mercado Pago, Venmo, PayPal Checkout, Google Pay, and Apple Pay.

## Issue

Although donorbox provides facility for taking donations but the issue arose you don't get categorized data about your all different compaigns. You don't get know when each of your compaigns get how much donations. Neither its shows any information about your donors how much they have paid and when nor you can filter the donations within range.

## Solution

This scripts solve all the issues mention above. You can get you all compaigns donation record with beautifully represented on charts. You can get information about all your donors how much they have paid you. You can filter the donations about different date range like weekly, monthly, quarterly, half year or even yearly and much more features related your compaigns on donorbox.

## How It Works

This scripts work with donorbox api. It has cron job that run after every hour to fetch latest data and show on your dashboard. Of course you can change time period according to your need.

## Requirements

Rename '.env.examle' file to '.env'. You need to have your [donorbox api key](https://github.com/donorbox/donorbox-api) from here and place it 'DONORBOX_API_KEY' veriable in .env file. Also write your email address that you use for login on donorbox dashbaord and place it 'DONORBOX_EMAIL' in .env file.

## Tech Stacks

Following tech stacks are used for building this script.
1: [Laravel](https://laravel.com)
2: [Livewire](https://livewire.laravel.com)
3: [Bootstrap 5](https://getbootstrap.com)

## Screenshots

![App Screenshot](https://firebasestorage.googleapis.com/v0/b/laravel-notification-22697.appspot.com/o/donorbox%2Fdonorbox-1.png?alt=media&token=f7d13a39-d55d-4d64-a590-16a2fdf9490a)

![App Screenshot](https://firebasestorage.googleapis.com/v0/b/laravel-notification-22697.appspot.com/o/donorbox%2Fdonorbox-2.png?alt=media&token=e96efa99-75cc-4c82-9b0b-d3a6ab6b6b55)

![App Screenshot](https://firebasestorage.googleapis.com/v0/b/laravel-notification-22697.appspot.com/o/donorbox%2Fdonorbox-3.png?alt=media&token=427603ad-91c4-40e2-84a7-f97531821e4c)

![App Screenshot](https://firebasestorage.googleapis.com/v0/b/laravel-notification-22697.appspot.com/o/donorbox%2Fdonorbox-4.png?alt=media&token=3aada360-277e-4723-97fa-2927ff20e3ac)

![App Screenshot](https://firebasestorage.googleapis.com/v0/b/laravel-notification-22697.appspot.com/o/donorbox%2Fdonorbox-5.png?alt=media&token=9ed380a1-8c2c-4b7f-874a-26e39e34bb6a)

![App Screenshot](https://firebasestorage.googleapis.com/v0/b/laravel-notification-22697.appspot.com/o/donorbox%2Fdonorbox-6.png?alt=media&token=8b6adedb-054e-43b2-86c2-40694515f7da)
