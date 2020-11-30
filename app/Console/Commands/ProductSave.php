<?php

namespace App\Console\Commands;

use App\Services\Product\ProductServiceInterface;
use Illuminate\Console\Command;

class ProductSave extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:save';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Save to json file';

    /**
     * @ProductServiceInterface
     */
    private $service;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ProductServiceInterface $service)
    {
        parent::__construct();

        $this->service = $service;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $file = config("product.outfile");
        unlink($file);
        $fh = fopen($file, 'a') or die("can't open file");

        fwrite($fh, "[");
        $this->service->saveAll($fh);
        fwrite($fh, "]");
        
        fclose($fh);
    }
}
