<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController
{
    private $products = [
        ["id" => 1, "name" => "Laptop"],
        ["id" => 2, "name" => "Monitor"],
        ["id" => 3, "name" => "Klavesnica"]
    ];

     /* Display a listing of the resource.
     */
    public function index()
    {
       return $this->products;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return "Formular na vytvorenie produktu";
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return "Produkt bol uložený";
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return "Detail produktu";
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return "Editovanie produktu";
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return "Produkt bol aktualizovaný";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return "Produkt bol vymazaný";
    }
}
