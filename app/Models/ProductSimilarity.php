<?php declare(strict_types=1);

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Exception;

class ProductSimilarity
{
    protected $products       = [];
    protected $product_nameWeight = 1;
    protected $categoryWeight = 1;
    protected $priceWeight    = 1;
    protected $discountWeight  = 1;
    protected $priceHighRange = 20000;
    protected $discountHinghRange = 100;

    public function __construct(array $products)
    {
      // dd($products);
        $this->products       = $products;
        // dd($products);
        $this->priceHighRange = max(array_column($products, 'harga_jual'));
    }

    public function setDiscountWeight(float $weight): void
    {
        $this->discountWeight = $weight;
    }

    public function setPriceWeight(float $weight): void
    {
        $this->priceWeight = $weight;
    }

    public function setCategoryWeight(float $weight): void
    {
        $this->categoryWeight = $weight;
    }


        public function setProdcut_NameWeight(float $weight): void
        {
            $this->product_nameWeight = $weight;
        }


    public function calculateSimilarityMatrix(): array
    {
        $matrix = [];
        foreach ($this->products as $product) {

            $similarityScores = [];

            foreach ($this->products as $_product) {
              // foreach $products as $_product
              // dd($this->products);

                if ($product->id_produk === $_product->id_produk) {
                    continue;
              // memasangkan id dri setiap array $products dengan

                }
                $similarityScores['product_id_' . $_product->id_produk] = $this->calculateSimilarityScore($product, $_product);
                // Menghitung SimilarityScore per produk
                // dd($similarityScores);
            }

            $matrix['product_id_' . $product->id_produk] = $similarityScores;
            // memindahkan ke $matrix

        }
        // dd($matrix);
        return $matrix;
    }

    public function getProductsSortedBySimilarity( $productIds, array $matrix): array
    {
        foreach ($productIds as $productId ) {
        $similarities   = $matrix['product_id_' . $productId] ?? null;
      }
        // getting the score and put it on $similarities

        $sortedProducts = [];

        if (is_null($similarities)) {
            throw new Exception('Can\'t find product with that ID.');
            // Checking the array
        }
        arsort($similarities);

        foreach ($similarities as $productIdKey => $similarity) {
            $id      = intval(str_replace('product_id_', '', $productIdKey));
            $products = array_filter($this->products, function ($product) use ($id) { return $product->id_produk === $id; });
            if (! count($products)) {
                continue;
            }
            $product = $products[array_keys($products)[0]];
            $product->similarity = $similarity;
            $sortedProducts[] = $product;
        }
        return $sortedProducts;
    }

    protected function calculateSimilarityScore($productA, $productB)
    {

        // $productAFeatures = ($productA->nama_kategori);
        // dd($productA);
        // $productBFeatures = ($productB->nama_kategori);
        // dd($productB);
        // dd($productBFeatures);

        // $test=
        // Similarity::euclidean(
        //   // Harga
        //     Similarity::minMaxNorm([$productA->harga_jual], 0, $this->priceHighRange),
        //     Similarity::minMaxNorm([$productB->harga_jual], 0, $this->priceHighRange)) * $this->priceWeight;
        // dd($test);

        return array_sum([
          // array_sum untuk menjumlah bilangan di dalam array
          // array_sum = Harga + Diskon + nama_Kategori / totalweight

            // (Similarity::hamming($productAFeatures, $productBFeatures) * $this->productFeaturesWeight),
            ( Similarity::euclidean(
              // Harga
                Similarity::minMaxNorm([$productA->harga_jual], 0, $this->priceHighRange),
                Similarity::minMaxNorm([$productB->harga_jual], 0, $this->priceHighRange)) * $this->priceWeight),

            (Similarity::euclidean(
              // Diskon
                Similarity::minMaxNorm([$productA->diskon], 0, $this->discountHinghRange),
                Similarity::minMaxNorm([$productB->diskon], 0, $this->discountHinghRange)) * $this->discountWeight),

            (Similarity::jaccard($productA->nama_produk, $productB->nama_produk) * $this->product_nameWeight),
            (Similarity::jaccard($productA->nama_kategori, $productB->nama_kategori) * $this->categoryWeight)
        ]) / ($this->discountWeight + $this->priceWeight + $this->categoryWeight + $this->product_nameWeight);



    }
}
