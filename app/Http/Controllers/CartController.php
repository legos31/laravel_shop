<?php

namespace App\Http\Controllers;

use Domain\Cart\Models\CartItem;
use Domain\Product\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {

        return view('cart.index', [
            'items' => cart()->items()
        ]);
    }
    public function add(Product $product): RedirectResponse
    {

        cart()->add($product, \request('quantity' , 1), \request('options', []));
        flash()->info('Product add to cart');
        return redirect()->intended(route('cart'));
    }

    public function quantity(CartItem $item): RedirectResponse
    {
        cart()->quantity($item, request('quantity' ,1));
        flash()->info('Quantity product is changed');
        return redirect()->intended(route('cart'));
    }

    public function delete(CartItem $item): RedirectResponse
    {
        cart()->delete($item);
        flash()->info('Deleted from cart');
        return redirect()->intended(route('cart'));
    }

    public function truncate(): RedirectResponse
    {
        cart()->truncate();
        flash()->info('The cart is cleaned!');
        return redirect()->intended(route('cart'));
    }

}
