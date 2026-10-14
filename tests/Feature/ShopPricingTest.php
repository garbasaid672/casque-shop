<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

// Règles boutique : aucun article au-dessus de 50 000 FCFA,
// AirPods Pro 2 = 10 000 FCFA, AirPods 3 = 15 000 FCFA.
class ShopPricingTest extends TestCase
{
    use RefreshDatabase;

    public function test_no_product_exceeds_50000_fcfa(): void
    {
        $this->seed();

        $maxFcfa = (float) Product::max('price') * Product::FCFA_RATE;

        $this->assertLessThanOrEqual(50000, $maxFcfa);
    }

    public function test_airpods_fixed_prices(): void
    {
        $this->seed();

        $pro2 = Product::where('slug', 'apple-airpods-pro-2')->firstOrFail();
        $air3 = Product::where('slug', 'apple-airpods-3')->firstOrFail();

        $this->assertSame('10 000 FCFA', $pro2->price_fcfa);
        $this->assertSame('15 000 FCFA', $air3->price_fcfa);
        $this->assertNull($pro2->compare_at_price_fcfa);
    }
}
