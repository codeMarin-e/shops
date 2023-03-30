<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use App\Models\Shop;
use Illuminate\Validation\ValidationException;

class ShopRequest extends FormRequest
{

    private $mergeReturn = [];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $chShop = request()->route('chShop');
        $rules = array_merge(
            OpenCloseRequest::validation_rules(), [
            'add.name' => 'required|max:255',
            'add.description' => 'nullable',
            'active' => 'boolean',
        ]);
        // @HOOK_REQUEST_RULES

        return $rules;
    }

    public function messages() {
        $return = Arr::dot((array)trans('admin/shops/validation'));

        // @HOOK_REQUEST_MESSAGES

        return $return;
    }

    public function validationData() {
        $inputBag = 'shop';
        $this->errorBag = $inputBag;
        $inputs = $this->all();
        if(!isset($inputs[$inputBag])) {
            throw ValidationException::withMessages([
                $inputBag => trans('admin/shops/validation.no_inputs'),
            ])->errorBag($inputBag);;
        }
        $inputs[$inputBag]['active'] = isset($inputs[$inputBag]['active']);
        OpenCloseRequest::validation_prework($inputs, $inputBag);

        // @HOOK_REQUEST_PREPARE

        $this->replace($inputs);
        request()->replace($inputs); //global request should be replaced, too
        return $inputs[$inputBag];
    }

    public function validated($key = null, $default = null) {
        $validatedData = parent::validated($key, $default);

        // @HOOK_REQUEST_VALIDATED

        if(is_null($key)) {

            // @HOOK_REQUEST_AFTER_VALIDATED
            OpenCloseRequest::validateData($validatedData);

            return array_merge($validatedData, $this->mergeReturn);
        }

        // @HOOK_REQUEST_AFTER_VALIDATED_KEY

        return $validatedData;
    }
}
