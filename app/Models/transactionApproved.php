<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class transactionApproved extends Model
{
    //
    protected $guarded = [];

    protected $table = 'transaction_approve';

    protected $fillable=['school_id','account_id','transaction_id','amount','status'];

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';
}
