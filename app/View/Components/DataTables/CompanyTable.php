<?php
// app/View/Components/DataTables/CompanyTable.php

namespace App\View\Components\DataTables;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Collection; // Import Collection

class CompanyTable extends Component
{
    // Properti publik untuk menampung data perusahaan
    public $companies;

    /**
     * Create a new component instance.
     * * @param Collection|array $companies
     */
    public function __construct($companies)
    {
        // Pastikan data yang diterima diubah menjadi Collection
        $this->companies = is_array($companies) ? collect($companies) : $companies;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.data-tables.company-table');
    }
}