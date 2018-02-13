<?php

namespace Ergare17\Articles\Http\Requests;

use Acacha\Events\Http\Requests\Traits\ChecksPermissions;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class DestroyArticle
 *
 * @package App\Http\Requests
 */
class DestroyArticle extends FormRequest
{
    use ChecksPermissions;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->hasPermissionTo('destroy-articles')) return true;
        if ($this->owns('article')) return true;
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }
}
