<?php


namespace Domain\Cart;


use Domain\Cart\Contracts\CartStorageContract;
use Domain\Cart\Models\Cart;
use Domain\Cart\Models\CartItem;
use Domain\Cart\Storage\FakeSessionStorage;
use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Support\ValueObjects\Price;

class CartManager
{
    public function __construct(private CartStorageContract $storage)
    {

    }

    private function storageData(string $id)
    {
        $data = ['storage_id' => $id];

        if(auth()->check()) {
            $data['user_id'] = auth()->id();
        }

        return $data;
    }

    public function add(Product $product, int $quantity = 1, array $optionValues = [])
    {

        $cart = Cart::query()
            ->updateOrCreate(['storage_id' => $this->storage->get()],
            $this->storageData($this->storage->get())
            );

        sort($optionValues);

        $cartItem = $cart->cartItems()->updateOrCreate([
            'product_id' => $product->getKey(),
            'string_option_values' => implode(';', $optionValues)
        ], [
            'price' => $product->price,
            'quantity' => DB::raw("quantity + $quantity"),
            'string_option_values' => implode(';', $optionValues)
        ]);

        $cartItem->optionValues()->sync($optionValues);

        $this->forgetCache();

        return $cart;
    }

    public function quantity(CartItem $item, int $quantity = 1): void
    {
        $item->update([
            'quantity' => $quantity
        ]);

        $this->forgetCache();
    }

    public function delete(CartItem $item): void
    {
        $item->delete();

        $this->forgetCache();
    }

    public function truncate(): void
    {
        $this->get()?->delete();

        $this->forgetCache();
    }

    public function get()
    {
        //return Cache::remember($this->cacheKey(), now()->addHour(), function () {
         return Cart::query()
                ->with('cartItems')
                ->where('storage_id', $this->storage->get())
                ->when(auth()->check(), fn(Builder $query)=>$query->orWhere('user_id', auth()->id()))
                ->first();
        //});

    }

    public function cartItems(): Collection
    {
        return $this->get()?->cartItems ?? collect([]);
    }

    public function count(): int
    {
        return $this->cartItems()->sum(function ($item) {
            return $item->quantity;
        });
    }

    public function amount(): Price
    {
        return Price::make(
            $this->cartItems()->sum(function ($item) {
                return $item->amount->raw();
            })
        );
    }

    private function cacheKey(): string
    {
        //dd('cart_'.$this->storage->get());
        return 'cart_'.$this->storage->get();
//        return str('cart_'.$this->storage->get())
//            ->slug('_')
//            ->value();
    }

    private function forgetCache(): void
    {
        Cache::forget($this->cacheKey());
    }

    public function items(): Collection
    {
//        if(!$this->get()) {
//            return collect([]);
//        }

        return CartItem::query()
            ->with(['product','optionValues.option'])
            //->whereBelongsTo($this->get())
            ->get();

    }

    public function updateStorageId(string $old, string $current): void
    {
        Cart::query()->where('storage_id', $old)->update($this->storageData($current));
    }

    public static function fake(): void
    {
        app()->bind(CartStorageContract::class, FakeSessionStorage::class);
    }
}
