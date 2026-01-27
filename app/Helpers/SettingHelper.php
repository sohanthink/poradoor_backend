<?php

use App\Enums\Common\CurrencyPossition;
use App\Models\Page;
use App\Models\Product\Category;
use App\Models\Product\Product;
use App\Models\Setting;
use Illuminate\Support\Facades\Route;
use App\Services\FlashSaleService;



if (!function_exists('isFlashAvailable')) {
    function isFlashAvailable($product)
    {
        $flashSaleService = app(FlashSaleService::class);
        return $flashSaleService->isFlashAvailable($product);

    }
}
if (!function_exists('flashProduct')) {
    function flashProduct($product)
    {
        $flashSaleService = app(FlashSaleService::class);
        return $flashSaleService->flashProduct($product);

    }
}


if (!function_exists('setting')) {
    function setting($name, $default = null)
    {
        return \App\Models\Setting::getByName($name, $default);
    }
}
if (!function_exists('active_menu')) {
    function active_menu($name)
    {
        $class = '';
        if (request()->routeIs($name)) {
            $class = 'active';
        }
        return $class;
    }
}

if (!function_exists('view_avater')) {
    function view_avater($avater)
    {
        $file = asset('default.webp');
        if (!empty($avater)) {
            $file = $avater;
        }
        return $file;
    }
}
if (!function_exists('user_name_with_id')) {
    function user_name_with_id($user)
    {
        $name = 'User Not Found';
        if ($user) {
            $name = '(' . $user->id . ')' . $user->first_name . ' ' . $user->last_name;
        }

        return $name;
    }
}

if (!function_exists('user_name')) {
    function user_name($user)
    {
        $name = 'User Not Found';
        if ($user) {
            $name = $user->first_name . ' ' . $user->last_name;
        }

        return $name;
    }
}


if (!function_exists('page')) {
    function page($name, $default = null)
    {
        return \App\Models\Page::getByName($name, $default);

    }

}
if (!function_exists('setting_img')) {

    function setting_img($name, $default = null)
    {
        $img = asset('default.webp');
        $setting = Setting::where('name', $name)->first();
        if ($setting) {
            $img = $setting->getFirstMediaUrl($name);
        }

        return $img;
    }

}


if (!function_exists('get_image_url')) {
    function get_image_url($model, $collectionName = 'default', $conversion = '')
    {
        if (!$model) {
            return null; // Or a placeholder image URL
        }

        $media = $model->getFirstMedia($collectionName);

        if ($media) {
            if ($conversion) {
                return $media->getUrl($conversion); // URL with conversion
            } else {
                return $media->getUrl(); // Original URL
            }
        }

        return asset('default.webp'); // Or a placeholder image URL
    }
}
if (!function_exists('get_multiple_image_url')) {
    function get_multiple_image_url($model, $collectionName = 'default')
    {
        if (!$model) {
            return null; // Or a placeholder image URL
        }
        $medias = $model->getMedia($collectionName);
        $urls = [];
        foreach ($medias as $key => $media) {
            $urls[] = $media->getUrl();
        }
        return $urls;
    }
}

if (!function_exists('price')) {

    function price($price)
    {


        if (setting('currency_position') == CurrencyPossition::Right->value) {
            $price = $price . setting('currency');
        } else {
            $price = setting('currency') . $price;
        }

        return $price;
    }

}
if (!function_exists('get_price')) {

    function get_price($product)
    {
        return $product->price;
    }

}


if (!function_exists('cart_count')) {

    function cart_count()
    {
        $item = 0;
        if (session('cart')) {
            foreach (session('cart') as $id => $product) {

                $item = $item + 1;
            }
        }
        return $item;
    }

}

if (!function_exists('categories')) {

    function categories()
    {
        return Category::with('subCategories:id,name,slug,category_id')->active()->latest()->take(8)->get();
    }

}

if (!function_exists('check_route')) {

    function check_route($route)
    {
        $currentRouteName = Route::currentRouteName();
        $class = '';
        if ($currentRouteName == $route) {
            $class = 'active';
        }
        return $class;
    }

}

if (!function_exists('check_ingredient')) {
    function check_ingredient($id, $type, $ingredient)
    {
        $cart = session('cart');

        // First, check if the cart exists and if the specific item ($id) exists in it
        if ($cart && isset($cart[$id])) {
            $item = $cart[$id];

            // Now, check if the specified type exists in the item and if its value matches
            if (isset($item[$type]) && $item[$type] == trim($ingredient)) {
                return 'selected';
            }
        }
        return ' ';
    }
}



if (!function_exists('convertNumberToWord')) {
    function convertNumberToWord($number)
    {
        $ones = array(
            0 => "Zero",
            1 => "One",
            2 => "Two",
            3 => "Three",
            4 => "Four",
            5 => "Five",
            6 => "Six",
            7 => "Seven",
            8 => "Eight",
            9 => "Nine",
            10 => "Ten",
            11 => "Eleven",
            12 => "Twelve",
            13 => "Thirteen",
            14 => "Fourteen",
            15 => "Fifteen",
            16 => "Sixteen",
            17 => "Seventeen",
            18 => "Eighteen",
            19 => "Nineteen"
        );
        $tens = array(
            20 => "Twenty",
            30 => "Thirty",
            40 => "Forty",
            50 => "Fifty",
            60 => "Sixty",
            70 => "Seventy",
            80 => "Eighty",
            90 => "Ninety"
        );
        $hundreds = array(
            100 => "Hundred",
            1000 => "Thousand",
            1000000 => "Million",
            1000000000 => "Billion",
            1000000000000 => "Trillion",
            1000000000000000 => "Quadrillion",
            1000000000000000000 => "Quintillion"
        );

        if (!is_numeric($number)) {
            return false;
        }

        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            trigger_error(
                'convertNumberToWord only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
                E_USER_WARNING
            );
            return false;
        }

        if ($number < 20) {
            return $ones[$number];
        }

        if ($number < 100) {
            return $tens[((int) ($number / 10)) * 10] . (($number % 10) ? " " . $ones[$number % 10] : "");
        }

        if ($number < 1000) {
            return $ones[(int) ($number / 100)] . " " . $hundreds[100] . (($number % 100) ? " " . convertNumberToWord($number % 100) : "");
        }

        if ($number < 1000000) {
            return convertNumberToWord((int) ($number / 1000)) . " " . $hundreds[1000] . (($number % 1000) ? " " . convertNumberToWord($number % 1000) : "");
        }

        for ($i = 1000000; $i <= $number; $i *= 1000) {
            if ($number < $i * 1000) {
                return convertNumberToWord((int) ($number / $i)) . " " . $hundreds[$i] . (($number % $i) ? " " . convertNumberToWord($number % $i) : "");
            }
        }

        return $number;
    }
}

if (!function_exists('setSettingValue')) {
    function setSettingValue($name, $value){
        $data = [
            "name" => $name,
            "value" => $value,
        ];
        $setting = Setting::create($data);
        return $setting? $setting: null; 
    }
}
if (!function_exists('getSettingValue')) {
    function getSettingValue($name){
        $setting = Setting::where('name',$name)->first();
        if(!$setting) return null;
        return $setting->value;
    }
}

if (!function_exists('getTitleBySlug')) {
    function getTitleBySlug($slug): string {
        if($slug == "about") return "About Us";
        if($slug == "terms-and-condition") return "Terms And Condition";
        if($slug == "privacy-policy") return "Privacy Policy";
        if($slug == "return-policy") return "Return Policy";
        return "";
    }
}
if (!function_exists('getPageContent')) {
    function getPageContent($slug): string {
        $page = Page::where('slug', $slug)->first();
        return $page->description;
    }
}
