<?php

namespace MvcPhpUrlShortner\Interfaces;


interface MigrationInteface
{

    /**
     * create the table
     * @return void
     */
    public function up(): void;

    /**
     * Drop the table.
     * @return void
     */
    public function down(): void;
}