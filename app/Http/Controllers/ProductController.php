<?php


namespace App\Http\Controllers;


use Domain\Product\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;


class ProductController
{
    public function __invoke(Product $product) : Factory|View|Application
    {
        $also = null;

        if (session()->has('also')) {
            $also = Product::query()
                ->where(function ($q) use ($product) {
                    $q->whereIn('id', session('also'))
                        ->where('id', '!=', $product->id);
                })
                ->get();
        }

        $product->load(['optionValues.option']);
//        $options = $product->optionValues->mapToGroups(Function ($item) {
//            return [$item->option->title => $item];
//        });

        session()->put('also.'.$product->id, $product->id);

        return view('product.show', [
            'product' => $product,
            'options' => $product->optionValues->keyValues(),
            'also' => $also,
        ]);
    }


}
