<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = [
        'question_id', 'answer_id', 'question_en', 'answer_en',
        'category', 'sort_order', 'is_active',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function getQuestionAttribute(): string
    {
        return app()->getLocale() === 'en' ? $this->question_en : $this->question_id;
    }

    public function getAnswerAttribute(): string
    {
        return app()->getLocale() === 'en' ? $this->answer_en : $this->answer_id;
    }
}
