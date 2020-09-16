<?php

namespace App\Http\Requests;

use App\ProcedureModality;
use App\Rules\LoanIntervalAmount;
use App\Rules\LoanIntervalTerm;
use App\Rules\LoanParameterTicket;


use Illuminate\Foundation\Http\FormRequest;

class CalculatorForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->procedure_modality_id) {
            $procedure_modality = ProcedureModality::findOrFail($this->procedure_modality_id);
        }else{
            return[
                'procedure_modality_id' => ['required','exists:procedure_modalities,id']
            ];
        }
        return[
            'affiliate_id'=> ['required', 'integer', 'exists:affiliates,id'],
            'parent_loan_id' => ['integer', 'nullable', 'exists:loans,id'],
            'contributions' => ['required', 'array', 'min:1'],
            'contributions.*.payable_liquid' => ['required'],
            'contributions.*.border_bonus' => ['required'],
            'contributions.*.seniority_bonus' => ['required'],
            'contributions.*.public_security_bonus' => ['required'],
            'contributions.*.east_bonus' => ['required'],
        ];
    }

}
