<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart  = session()->get('cart', []);

        // Sync prices, stock, and images from database to prevent stale session data
        $updated = false;
        foreach ($cart as $id => &$item) {
            $product = Product::find($id);
            if (!$product || !$product->is_active) {
                unset($cart[$id]);
                $updated = true;
                continue;
            }
            if ($item['price'] != $product->price || $item['stock'] != $product->stock || $item['image'] != $product->image) {
                $item['price'] = $product->price;
                $item['stock'] = $product->stock;
                $item['image'] = $product->image;
                $item['name']  = $product->name;
                $updated = true;
            }
            // Cap quantity to available stock
            if ($item['quantity'] > $product->stock) {
                $item['quantity'] = max(1, $product->stock);
                $updated = true;
            }
        }
        unset($item); // break reference

        if ($updated) {
            session()->put('cart', $cart);
        }

        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        return view('cart', compact('cart', 'total'));
    }

    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if (!$product->isAvailable()) {
            return back()->with('error', 'Produk tidak tersedia atau stok habis.');
        }

        $qty  = max(1, (int) $request->input('quantity', 1));
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $newQty = $cart[$id]['quantity'] + $qty;
            if ($newQty > $product->stock) {
                return back()->with('error', 'Jumlah melebihi stok tersedia (' . $product->stock . ' ' . $product->unit . ').');
            }
            $cart[$id]['quantity'] = $newQty;
        } else {
            $cart[$id] = [
                'id'       => $product->id,
                'name'     => $product->name,
                'price'    => $product->price,
                'image'    => $product->image,
                'unit'     => $product->unit,
                'stock'    => $product->stock,
                'quantity' => $qty,
            ];
        }

        session()->put('cart', $cart);
        return back()->with('success', $product->name . ' berhasil ditambahkan ke keranjang.');
    }

    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        $qty  = (int) $request->input('quantity', 1);

        if (isset($cart[$id])) {
            $product = Product::findOrFail($id);
            if ($qty < 1) {
                unset($cart[$id]);
            } elseif ($qty > $product->stock) {
                return back()->with('error', 'Stok tidak mencukupi.');
            } else {
                $cart[$id]['quantity'] = $qty;
            }
        }

        session()->put('cart', $cart);
        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);
        return back()->with('success', 'Produk dihapus dari keranjang.');
    }

    public function count()
    {
        $cart = session()->get('cart', []);
        return response()->json(['count' => count($cart)]);
    }
}
