@extends('layouts.app')

@section('title', 'Оформление заказа')

@section('content')
<main class="py-16 lg:py-20">
    <div class="container">
        <!-- Breadcrumbs -->
        <ul class="breadcrumbs flex flex-wrap gap-y-1 gap-x-4 mb-6">
            <li><a href="{{route('home')}}" class="text-body hover:text-pink text-xs">Главная</a></li>
            <li><a href="{{route('cart')}}" class="text-body hover:text-pink text-xs">Корзина покупок</a></li>
            <li><span class="text-body text-xs">Оформление заказа</span></li>
        </ul>
        <section>
            <!-- Section heading -->
            <h1 class="mb-8 text-lg lg:text-[42px] font-black">Оформление заказа</h1>

            <form method="POST" action="{{route('order.handle')}}" class="grid xl:grid-cols-3 items-start gap-6 2xl:gap-8 mt-12">
                @csrf
                <!-- Contact information -->
                <div class="p-6 2xl:p-8 rounded-[20px] bg-card">
                    <h3 class="mb-6 text-md 2xl:text-lg font-bold">Контактная информация</h3>
                    <div class="space-y-3">
                        <input name="customer[first_name]" type="text" class="w-full h-16 px-4 rounded-lg border border-body/10 focus:border-pink focus:shadow-[0_0_0_3px_#EC4176] bg-white/5 text-white text-xs shadow-transparent outline-0 transition" placeholder="Имя" required>
                        <input name="customer[last_name]" type="text" class="w-full h-16 px-4 rounded-lg border border-body/10 focus:border-pink focus:shadow-[0_0_0_3px_#EC4176] bg-white/5 text-white text-xs shadow-transparent outline-0 transition" placeholder="Фамилия" required>
                        <input name="customer[phone]" type="text" class="w-full h-16 px-4 rounded-lg border border-body/10 focus:border-pink focus:shadow-[0_0_0_3px_#EC4176] bg-white/5 text-white text-xs shadow-transparent outline-0 transition" placeholder="Номер телефона" required>
                        <input name="customer[email]" type="email" class="w-full h-16 px-4 rounded-lg border border-body/10 focus:border-pink focus:shadow-[0_0_0_3px_#EC4176] bg-white/5 text-white text-xs shadow-transparent outline-0 transition" placeholder="E-mail" required>
                        @guest
                            <div x-data="{ createAccount: false }">
                                <div class="py-3 text-body">Вы можете создать аккаунт после оформления заказа</div>
                                <div class="form-checkbox">
                                    <input name="create_account" value="1" type="checkbox" id="checkout-create-account">
                                    <label for="checkout-create-account" class="form-checkbox-label" @click="createAccount = ! createAccount">Зарегистрировать аккаунт</label>
                                </div>
                                <div
                                    x-show="createAccount"
                                    x-transition:enter="ease-out duration-300"
                                    x-transition:enter-start="opacity-0"
                                    x-transition:enter-end="opacity-100"
                                    x-transition:leave="ease-in duration-150"
                                    x-transition:leave-start="opacity-100"
                                    x-transition:leave-end="opacity-0"
                                    class="mt-4 space-y-3"
                                >
                                    <input name="password" type="password" class="w-full h-16 px-4 rounded-lg border border-body/10 focus:border-pink focus:shadow-[0_0_0_3px_#EC4176] bg-white/5 text-white text-xs shadow-transparent outline-0 transition" placeholder="Придумайте пароль" required>
                                    <input name="password_confirmation" type="password" class="w-full h-16 px-4 rounded-lg border border-body/10 focus:border-pink focus:shadow-[0_0_0_3px_#EC4176] bg-white/5 text-white text-xs shadow-transparent outline-0 transition" placeholder="Повторите пароль" required>
                                </div>
                            </div>
                        @endguest
                    </div>
                </div>

                <!-- Shipping & Payment -->
                <div class="space-y-6 2xl:space-y-8">
                    <!-- Shipping-->
                    <div class="p-6 2xl:p-8 rounded-[20px] bg-card">
                        <h3 class="mb-6 text-md 2xl:text-lg font-bold">Способ доставки</h3>
                        <div class="space-y-5">
                            @foreach($deliveries as $delivery)
                                <div class="space-y-3">
                                    <div class="form-radio">
                                        <input name="delivery_type_id"
                                               type="radio"
                                               id="delivery-method-address-{{$delivery->id}}"
                                               value="{{$delivery->id}}"
                                               @checked($loop->first || old('delivery_id') === $delivery->id)>
                                        <label for="delivery-method-address-{{$delivery->id}}" class="form-radio-label">{{$delivery->title}}</label>
                                    </div>
                                    @if ($delivery->with_address)
                                        <input name="customer[city]" type="text" class="w-full h-16 px-4 rounded-lg border border-body/10 focus:border-pink focus:shadow-[0_0_0_3px_#EC4176] bg-white/5 text-white text-xs shadow-transparent outline-0 transition" placeholder="Город" value="{{old('customer_city')}}" required>
                                        <input name="customer[address]" type="text" class="w-full h-16 px-4 rounded-lg border border-body/10 focus:border-pink focus:shadow-[0_0_0_3px_#EC4176] bg-white/5 text-white text-xs shadow-transparent outline-0 transition" placeholder="Адрес" value="{{old('customer_address')}}" required>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Payment-->
                    <div class="p-6 2xl:p-8 rounded-[20px] bg-card">
                        <h3 class="mb-6 text-md 2xl:text-lg font-bold">Метод оплаты</h3>
                        <div class="space-y-5">
                            @foreach($payments as $payment)
                                <div class="form-radio">
                                    <input type="radio"
                                           name="payment_method_id"
                                           id="payment-method-{{$payment->id}}"
                                           value="{{$payment->id}}"
                                           @checked($loop->first || old('payment_method_id') === $payment->id)>

                                    <label for="payment-method-{{$payment->id}}" class="form-radio-label">{{$payment->title}}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Checkout -->
                <div class="p-6 2xl:p-8 rounded-[20px] bg-card">
                    <h3 class="mb-6 text-md 2xl:text-lg font-bold">Заказ</h3>
                    <table class="w-full border-spacing-y-3 text-body text-xxs text-left" style="border-collapse: separate">
                        <thead class="text-[12px] text-body uppercase">
                        <th scope="col" class="pb-2 border-b border-body/60">Товар</th>
                        <th scope="col" class="px-2 pb-2 border-b border-body/60">К-во</th>
                        <th scope="col" class="px-2 pb-2 border-b border-body/60">Сумма</th>
                        </thead>
                        <tbody>
                        @foreach($items as $item)
                            <tr>
                                <td scope="row" class="pb-3 border-b border-body/10">
                                    <h4 class="font-bold"><a href="{{route('product', $item->product)}}" class="inline-block text-white hover:text-pink break-words pr-3">{{$item->product->title}}</a></h4>
                                    @if($item->optionValues->isNotEmpty())
                                    <ul>
                                        @foreach($item->optionValues as $value)
                                            <li class="text-body">{{$value->option->title}}: {{$value->title}}</li>
                                        @endforeach
                                    </ul>
                                    @endif
                                </td>
                                <td class="px-2 pb-3 border-b border-body/20 whitespace-nowrap">{{$item->quantity}} шт.</td>
                                <td class="px-2 pb-3 border-b border-body/20 whitespace-nowrap">{{$item->amount}} ₽</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="text-xs font-semibold text-right">Всего: {{cart()->amount()}} ₽</div>

                    <div class="mt-8 space-y-8">

                        <!-- Summary -->
                        <table class="w-full text-left">
                            <tbody>
                            <tr>
                                <th scope="row" class="text-md 2xl:text-lg font-black">Итого:</th>
                                <td class="text-md 2xl:text-lg font-black">{{cart()->amount()}} ₽</td>
                            </tr>
                            </tbody>
                        </table>

                        <!-- Process to checkout -->
                        <button type="submit" class="w-full btn btn-pink">Оформить заказ</button>
                    </div>
                </div>

            </form>
        </section>
    </div>
</main>
@endsection
