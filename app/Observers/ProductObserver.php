<?php

namespace App\Observers;

use App\Models\CashierNotification;
use App\Models\Product;

class ProductObserver
{
    public function saving(Product $product): void
    {
        // Nouveau produit : sa quantité de départ devient la référence 100%
        if (!$product->exists) {
            if (is_null($product->reference_stock)) {
                $product->reference_stock = $product->stock_quantity;
            }
            return;
        }

        if ($product->isDirty('stock_quantity')) {
            $old = $product->getOriginal('stock_quantity') ?? 0;
            $new = $product->stock_quantity;

            // Le stock augmente (réapprovisionnement) → nouvelle référence 100%
            if ($new > $old || is_null($product->reference_stock)) {
                $product->reference_stock = $new;
            }
        }
    }

    public function updated(Product $product): void
    {
        if (!$product->wasChanged('stock_quantity')) {
            return;
        }

        $old = $product->getOriginal('stock_quantity');
        $new = $product->stock_quantity;
        $reference = $product->reference_stock;

        if (!$reference || $reference <= 0) {
            return;
        }

        $thresholdQty = $reference * 0.3;

        // On alerte seulement au moment où on FRANCHIT le seuil vers le bas
        $wasAbove = $old > $thresholdQty;
        $isNowAtOrBelow = $new <= $thresholdQty;

        if ($wasAbove && $isNowAtOrBelow) {
            $percent = round(($new / $reference) * 100);

            CashierNotification::create([
                'title' => 'Low stock alert',
                'message' => "{$product->name} : il vous reste {$new} unité(s), soit {$percent}% du stock initial ({$reference}).",
                'type' => 'stock',
                'is_read' => false,
            ]);
        }
    }
}