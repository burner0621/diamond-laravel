@php
use App\Models\Step;
use App\Models\StepGroup;

$strStepId = '';
if ($product->step_type == 1) {
    $step_group = $product->step_group;
    $stepGroup = StepGroup::find($step_group);
    if ($stepGroup) {
        $strStepId = $stepGroup->steps;
    }
} else if ($product->step_type == 2) {
    $strStepId = $product->steps;
}

$arrSteps = array();
if (trim($strStepId) != '') {
    $arrStepIds = explode(',', $strStepId);
    $arrStepsTemp = Step::whereIn('id', $arrStepIds)->get();
    $arrSteps = array_fill_keys($arrStepIds, null);

    foreach ($arrStepsTemp as $step) {
        $arrSteps[$step->id] = $step;
    }
}

@endphp

@if (count($arrSteps))
<div class="card">
    <div class="fs-18 py-2 fw-600 card-header">Steps</div>
    <div class="card-body">
        <div class="accordion">
            @foreach ($arrSteps as $step)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="accHeading{{ $step->id }}">
                        <button class="accordion-button collapsed" type="button"
                            data-bs-toggle="collapse" data-bs-target="#accContent{{ $step->id }}"
                            aria-expanded="false" aria-controls="accContent{{ $step->id }}">
                            {{ $step->name }}
                        </button>
                    </h2>
                    <div id="accContent{{ $step->id }}" class="accordion-collapse collapse"
                        aria-labelledby="accHeading{{ $step->id }}">
                        <div class="accordion-body">
                            {{ $step->description }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif